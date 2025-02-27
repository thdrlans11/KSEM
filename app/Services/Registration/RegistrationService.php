<?php

namespace App\Services\Registration;

use App\Models\Hospital;
use App\Models\Registration;
use App\Models\RegistrationPeriod;
use App\Services\CommonService;
use App\Services\dbService;
use App\Services\Util\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class RegistrationService
 * @package App\Services
 */
class RegistrationService extends dbService
{
    public function guide()
    {
        $period = RegistrationPeriod::find(1);
        $data['period'] = $period;
        $data['subNum'] = '1';

        return view('registration.guide')->with($data);
    }

    public function registration(Request $request)
    {        
        $periodCheck = $this->periodCheck('E');

        if( !$periodCheck['type'] ){
            return redirect()->route('registration.guide')->withInfo($periodCheck['msg']);
        }else{
            $type = $periodCheck['type'];
        }
        
        if( $request->sid ){
            $registration = Registration::find(decrypt($request->sid));
            if( $registration->payStatus != 'N' ){
                $type = $registration->type;
            }
        }

        $data['step'] = $request->step;
        $data['type'] = $type;        
        $data['captcha'] = (new CommonService())->captchaMakeService();
        $data['apply'] = $registration ?? null;
        $data['hospitals'] = Hospital::orderby('hospital')->get();
        $data['period'] = RegistrationPeriod::find(1);
        $data['subNum'] = '2';

        return view('registration.registration')->with($data);
    }

    public function emailCheck(Request $request)
    {
        $apply = Registration::where('email', $request->email)->first();

        if( $apply ){
            return 'already';
        }else{
            return 'vailable';
        }
    }

    public function phoneCheck(Request $request)
    {
        $apply = Registration::where('phone', $request->phone)->first();

        if( $apply ){
            return 'already';
        }else{
            return 'vailable';
        }
    }

    public function makePrice(Request $request)
    {
        $totalPrice = 0;
        $totalPriceText = '';

        $type = $request->type; //타입
        $category = $request->category; //카테고리
        $attendType = $request->attendType; //참석타입

        if( $category && $attendType ){
            $totalPrice = config('site.registration.categoryPrice')[$attendType][$type][$category];                 
            $totalPriceText = $totalPrice > 0 ? number_format($totalPrice).'원' : '무료';
        }

        return ['priceUnit'=>$totalPriceText, 'price'=>$totalPrice];
        
    }

    public function makeLocalSub(Request $request)
    {
        $data['local'] = $request->local;
        $data['localSub'] = $request->localSub ?? '';

        return view('registration.form.local')->with($data);
        
    }

    public function upsert_01(Request $request)
    {   
        //허니팟 작동 ( 봇 방지 )
        if( !$request->sid && checkUrl() != 'admin' ){
            
            $rules = array(
                'my_name' => 'honeypot',
                'my_time' => 'required|honeytime:5'
            );

            $validator = Validator::make(['my_name'=>$request->my_name, 'my_time'=>$request->my_time], $rules);

            if($validator->fails()){
                return redirect()->route('main');
            }

        }

        $this->transaction();

        try {    

            if( !$request->sid ){
                $registration = new Registration();
                $registration->phone = $request->phone;
                $registration->email = $request->email;
            }else{
                $registration = Registration::find(decrypt($request->sid));
            }
    
            $registration->type = $request->type;
            $registration->attendType = $request->attendType;
            $registration->category = $request->category;
            $registration->category_etc = $request->category_etc;
            $registration->name = $request->name;
            $registration->license_number = $request->license_number;
            $registration->major = $request->major;
            $registration->birth = $request->birth;
            $registration->sex = $request->sex;
            $registration->office = $request->office;
            $registration->local = $request->local;
            $registration->local_sub = $request->local_sub;
            $registration->firstVisit = $request->firstVisit;
            $registration->price = $request->price;

            //출력이름 //출력소속
            $registration->printName = $request->printName ?? $request->name;
            $registration->printOffice = $request->printOffice ?? $request->office;

            $registration->save();

            $this->dbCommit($msg ?? ( checkUrl() == 'admin' ? '관리자 ' : '사용자' ).' 사전등록 스텝 1 저장');

            if( checkUrl() == 'admin' ){
                return redirect()->route('admin.registration.modifyForm', ['step'=>$request->step, 'sid'=>encrypt($registration->sid)]);
            }else{
                return redirect()->route('apply.registration', ['step'=>'2', 'sid'=>encrypt($registration->sid)]);
            }
            

        } catch (\Exception $e) {

            return $this->dbRollback($e);

        } 
        
    }

    public function upsert_02(Request $request)
    {
        $this->transaction();

        try {    
            
            $mailSend = false;

            $registration = Registration::find(decrypt($request->sid));
            $registration->type = $request->type;
            $registration->payMethod = $request->payMethod;            
            $registration->payName = $request->payName;
            $registration->payDate = $request->payDate;
            $registration->refundAccount = $request->refundAccount;
            $registration->refundBank = $request->refundBank;
            $registration->refundHolder = $request->refundHolder;
            
            //완료시에만 저장
            if( checkUrl() != 'admin' ){
                if( $request->payMethod == 'C' && $registration->payStatus == 'N' ){
                    $registration->pgCode = session()->pull('code');
                    $registration->pgTid = session()->pull('tid');
                    $registration->pgToken = session()->pull('payToken');
                    $registration->pgTraidId = session()->pull('tradeId');
                    $registration->payStatus = 'Y';
                    $registration->payComplete_at = now();                
                }
                if( $request->payMethod == 'F' && $registration->payStatus == 'N' ){
                    $registration->payStatus = 'F';
                    $registration->payComplete_at = now();                
                }
                if( $registration->status == 'N' ){
                    $mailSend = true;                    
                    $registration->rnum = $this->makeRegistNumber();
                    $registration->status = 'Y';
                    $registration->complete_at = now();
                }
            }

            $registration->save();

            if( $mailSend ){
                (new MailService())->makeMail($registration, 'registrationComplete');
            }

            $this->dbCommit($msg ?? ( checkUrl() == 'admin' ? '관리자 ' : '사용자' ).' 사전등록 스텝 2 저장');

            if( checkUrl() == 'admin' ){
                return redirect()->route('admin.registration.modifyForm', ['step'=>$request->step, 'sid'=>encrypt($registration->sid)]);
            }else{
                return redirect()->route('apply.registration', ['step'=>$request->step+1, 'sid'=>encrypt($registration->sid)]);
            }

        } catch (\Exception $e) {

            return $this->dbRollback($e);

        }
    }

    public function payRegist(Request $request)
    {
        $url = env('KG_PAYURL');

        $data = array(
            'sid' => env('KG_SID'),
            'cash_code' => 'CN',
            'product_name' => config('site.common.info.siteName'),
            'amount' => array( 'total' => $request->price ),            
            'user_id' => $request->user_id,
            'user_name' => $request->user_name,
            'trade_id' => 'KSEM_'.time(),
            'site_url' => env('KG_SITEURL'),
            'ok_url' => route('apply.registration.paySuccess'),
            'fail_url' => route('apply.registration.payFail'),
            'call_type' => 'P'
        );

        $curlHandle = curl_init($url);
        curl_setopt_array($curlHandle, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($data)
        ));

        $response = curl_exec($curlHandle);

        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        if( $httpCode != 200 ){
            return false;
        }else{
            $responseJson = json_decode($response,true);
            return $responseJson;
        }
    }    

    public function paySuccess(Request $request)
    {
        if( $request->code == '0000' ){
            session()->put([
                'code' => $request->code,
                'tid' => $request->tid,
                'payToken' => $request->pay_token,
                'tradeId' => $request->trade_id,
            ]);
            return view('pay.success');
        }else{
            return view('pay.fail')->with(['message'=>$request->message, 'code'=>$request->code ]);
        }
    }

    public function payFail(Request $request)
    {
        return view('pay.fail')->with(['message'=>$request->message, 'code'=>$request->code ]);
    }

    public function payCancel(Request $request)
    {
        //$url = 'https://mup.mobilians.co.kr/MUP/api/registration';
        $url = 'https://test.mobilians.co.kr/MUP/api/cancel';

        $data = array(
            'sid' => 'emergency',
            'trade_id' => 'KSEM_1740387390',
            'cash_code' => 'CN',
            'pay_token' => '5000005602',
            'amount' => '1000',            
            'cancel_type' => 'C',
            'part_cancel' => 'N'
        );

        $curlHandle = curl_init($url);
        curl_setopt_array($curlHandle, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($data)
        ));

        $response = curl_exec($curlHandle);

        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        if( $httpCode != 200 ){
            return false;
        }else{
            $responseJson = json_decode($response,true);
            return $responseJson;
        }
    }

    public function search(Request $request)
    {
        $data['subNum'] = '3';

        return $data;
    }

    public function searchResult(Request $request)
    {
        if( $request->searchCondition == 'P' ){
            $registration = Registration::where('name', $request->Pname)->where('phone', $request->Pphone)->first();
        }else if( $request->searchCondition == 'E' ){
            $registration = Registration::where('name', $request->Ename)->where('email', $request->Eemail)->first();
        }else{
            return redirect()->back()->withError('조회되는 내역이 없습니다.');
        }

        if( !$registration ){
            return redirect()->back()->withError('조회되는 내역이 없습니다.');
        }

        $periodCheck = $this->periodCheck('E');

        $data['apply'] = $registration;        
        $data['type'] = $registration->type;
        $data['subNum'] = '3';
        $data['modifyYn'] = ( $periodCheck['type'] ? true : false );

        return view('registration.searchResult')->with($data);
    }

    private function periodCheck($cha) //E : 사전, S : 현장
    {
        $type = null;
        $period = RegistrationPeriod::find(1);

        if( !$period ){
            return ['type'=>$type, 'msg'=>'등록 기간이 설정되어 있지 않습니다.'];
        }

        if( $_SERVER['REMOTE_ADDR'] != '218.235.94.223' && $_SERVER['REMOTE_ADDR'] != '218.235.94.212' ){
            if( strtotime($period[$cha.'sdate']) < time() && strtotime($period[$cha.'edate']) > time() ){
                $type = $cha;
            }
        }else{
            $type = $cha;
        }    
        
        if( !$type ){
            return ['type'=>$type, 'msg'=>( $type == 'E' ? '사전' : '현장' ).'등록 기간이 아닙니다.'];
        }else{
            return ['type'=>$type, 'msg'=>''];
        }
    }

    private function makeRegistNumber()
    {
        $maxNumber = Registration::selectRaw('max(substring(rnum,3)) as maxNumber')->first();
        return 'R-'.($maxNumber['maxNumber']?sprintf('%04d',($maxNumber['maxNumber'])+1):'0001');
    }

    //현장등록
    public function sceneRegistration()
    {        
        $periodCheck = $this->periodCheck('S');

        if( !$periodCheck['type'] ){
            return redirect()->route('registration.guide')->withInfo($periodCheck['msg']);
        }else{
            $type = $periodCheck['type'];
        }
        
        $data['type'] = $type;        
        $data['apply'] = null;
        $data['hospitals'] = Hospital::orderby('hospital')->get();

        return view('scene.registration')->with($data);
    }

    public function fluidUpsert(Request $request)
    {   
        //허니팟 작동 ( 봇 방지 )
        if( !$request->sid && checkUrl() != 'admin' ){
            
            $rules = array(
                'my_name' => 'honeypot',
                'my_time' => 'required|honeytime:5'
            );

            $validator = Validator::make(['my_name'=>$request->my_name, 'my_time'=>$request->my_time], $rules);

            if($validator->fails()){
                return redirect()->route('main');
            }

        }

        $this->transaction();

        try {    

            $registration = new Registration();
            $registration->rnum = $this->makeRegistNumber();
            $registration->type = $request->type;
            $registration->attendType = $request->attendType;
            $registration->category = $request->category;
            $registration->category_etc = $request->category_etc;
            $registration->name = $request->name;
            $registration->license_number = $request->license_number;
            $registration->major = $request->major;
            $registration->birth = $request->birth;
            $registration->sex = $request->sex;
            $registration->office = $request->office;
            $registration->phone = $request->phone;
            $registration->email = $request->email;
            $registration->local = $request->local;
            $registration->local_sub = $request->local_sub;
            $registration->firstVisit = $request->firstVisit;
            $registration->price = $request->price;
            $registration->payMethod = 'S';
            $registration->status = 'Y';
            $registration->complete_at = now();

            //출력이름 //출력소속
            $registration->printName = $request->printName ?? $request->name;
            $registration->printOffice = $request->printOffice ?? $request->office;

            $registration->save();

            if( $request->pageMode == 'scene' ){
                $msg = '현장등록 저장';
            }

            $this->dbCommit($msg);

            if( checkUrl() == 'admin' ){
                return redirect()->route('admin.registration.modifyForm', ['step'=>$request->step, 'sid'=>encrypt($registration->sid)]);
            }else{
                return redirect()->route('apply.scene.registration')->withSuccess('현장등록이 완료되었습니다.<br>데스크에서 결제를 완료해주세요.');
            }
            

        } catch (\Exception $e) {

            return $this->dbRollback($e);

        } 
        
    }
    //현장등록
}
