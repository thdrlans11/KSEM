<?php

namespace App\Services\Admin\Registration;

use App\Models\Country;
use App\Models\Hospital;
use App\Models\Registration;
use App\Models\RegistrationPeriod;
use App\Services\CommonService;
use App\Services\dbService;
use App\Services\Util\ExcelService;
use App\Services\Util\MailService;
use Illuminate\Http\Request;

/**
 * Class RegistrationService
 * @package App\Services
 */
class RegistrationService extends dbService
{
    public function list(Request $request)
    {
        if( $request->tabMode != 'N' ){
            $lists = Registration::where('type', $request->tabMode)->where('status', 'Y')->orderBy('created_at','desc');
        }else{
            $lists = Registration::onlyTrashed()->where('status', 'Y')->orderBy('created_at','desc');
        }
        
        foreach( $request->all() as $key => $val ){
            if( ( $key == 'ccode' || $key == 'rnum' || $key == 'email' || $key == 'regName' || $key == 'category' || $key == 'attendType' || $key == 'payMethod' || $key == 'payStatus' || $key == 'lang' ) && $val ){
                if( $key == 'regName' ){
                    $lists->where(function($lists) use ($val) {
                        $lists->whereRaw("CONCAT(firstName,' ',lastName) LIKE '%".$val."%'")
                            ->orWhere('name', 'LIKE', '%' . $val . '%');
                    });
                }else{
                    $lists->where($key, 'LIKE', '%'.$val.'%');
                }
            }
        }

        if ($request->excel) {
            $cntQuery = clone $lists;
            return (new ExcelService())->RegistrationExcel($lists, $cntQuery->count());
        }

        if( $request->paginate ){
            $paginate = $request->paginate;
        }else{
            $paginate = '20';
        }

        $lists = $lists->paginate($paginate)->appends($request->query());
        $lists = setListSeq($lists);
        $data['lists'] = $lists;
        $data['tabMode'] = $request->tabMode;
        $data['period'] = RegistrationPeriod::find(1);

        return $data;
    }
    
    public function modifyForm(Request $request)
    {
        $registration = Registration::find(decrypt($request->sid));

        $data['step'] = $request->step;
        $data['type'] = $registration->type;        
        $data['captcha'] = (new CommonService())->captchaMakeService();
        $data['apply'] = $registration;
        $data['hospitals'] = Hospital::orderby('hospital')->get();
        $data['period'] = RegistrationPeriod::find(1);

        return $data;
    }

    public function sendMailForm(Request $request)
    {
        $registration = Registration::find(decrypt($request->sid));
        $mailBody = (new MailService())->makeMail($registration, 'registrationComplete', 'preview');

        $data['apply'] = $registration;
        $data['mailBody'] = $mailBody;

        return $data;
    }

    public function sendMail(Request $request)
    {
        $registration = Registration::find(decrypt($request->sid));

        if( $request->email ){
            $registration->email = $request->email;
        }

        (new MailService())->makeMail($registration, 'registrationComplete');

        return redirect()->back()->withSuccess('메일 전송이 완료되었습니다.')->with('close','Y');
    }

    public function dbChange(Request $request)
    {   
        $this->transaction();

        try {

            if( $request->db == 'registration_periods' ){

                $registrationPeriod = RegistrationPeriod::find(decrypt($request->sid));
                $registrationPeriod[$request->field] = $request->value;
                $registrationPeriod->save();

                $msg = '관리자 사전등록 날짜 변경';

            }else{

                $registration = Registration::withTrashed()->find(decrypt($request->sid));

                if( $request->field == 'delete' ){
                    if( $request->value == 'Y' ){
                        $registration->delete();
                        $msg = '관리자 사전등록 삭제';
                    }else{
                        $registration->restore();
                        $msg = '관리자 사전등록 복구';
                    }
                    
                }else{
                    $registration[$request->field] = $request->value;

                    if( $request->field == 'payStatus' ){
                        if( $request->value != 'N' ){
                            $registration->payComplete_at = now();
                        }else{
                            $registration->payComplete_at = null;
                        }
                        $msg = '관리자 결제상태 변경';
                    }else if( $request->field == 'payMethod' ){
                        if( $request->value == 'F' ){
                            $registration->payStatus = 'F';
                            $registration->payComplete_at = now();
                        }
                        $msg = '관리자 결제방법 변경';
                    }

                    $registration->save();
                }

            }               

            $this->dbCommit($msg); 
            
            return 'success';

        } catch (\Exception $e) {

            return $this->dbRollback($e, 'ajax');

        }
    }

    public function memoForm(Request $request)
    {
        $registration = Registration::find(decrypt($request->sid));
        $data['apply'] = $registration;

        return $data;
    }    

    public function memo(Request $request)
    {   
        $this->transaction();

        try {

            $registration = Registration::find(decrypt($request->sid));
            $registration->memo = $request->memo;
            $registration->save();

            $this->dbCommit('사전등록 메모 변경'); 
            
            return redirect()->back()->withSuccess('메모 저장이 완료되었습니다.')->with('close','Y');

        } catch (\Exception $e) {

            return $this->dbRollback($e);

        }
    }
}
