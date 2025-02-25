<?php

namespace App\Services\Lecture;

use App\Models\Hospital;
use App\Models\Lecture;
use App\Models\LecturePeriod;
use App\Services\CommonService;
use App\Services\dbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Class LectureService
 * @package App\Services
 */
class LectureService extends dbService
{
    public function guide()
    {
        $period = LecturePeriod::find(1);
        $data['period'] = $period;
        $data['subNum'] = '1';

        return view('lecture.guide')->with($data);
    }

    public function registration(Request $request)
    {        
        $periodCheck = $this->periodCheck();

        if( !$periodCheck['result'] ){
            return redirect()->route('lecture.guide')->withInfo($periodCheck['msg']);
        }
        
        if( $request->sid ){
            $lecture = Lecture::find(decrypt($request->sid));
        }
        
        $data['hospitals'] = Hospital::orderby('hospital')->get();
        $data['captcha'] = (new CommonService())->captchaMakeService();
        $data['apply'] = $lecture ?? null;
        $data['period'] = LecturePeriod::find(1);
        $data['subNum'] = '2';

        return view('lecture.registration')->with($data);
    }

    public function emailCheck(Request $request)
    {
        $apply = Lecture::where('email', $request->email)->first();

        if( $apply ){
            return 'already';
        }else{
            return 'vailable';
        }
    }

    public function upsert(Request $request)
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
                $lecture = new Lecture();
                $lecture->rnum = $this->makeRegistNumber();
                $lecture->email = $request->email;
            }else{
                $lecture = Lecture::find(decrypt($request->sid));
            }

            
            $lecture->name = $request->name;
            $lecture->office = $request->office;
            $lecture->phone = $request->phone;
            $lecture->tel = $request->tel;

            if( $request->userfile ){
                $file = (new CommonService())->fileUploadService($request->userfile, 'lecture');
                $lecture->filename = $file['filename'];
                $lecture->realfile = $file['realfile'];            
            }

            if( $request->userfile2 ){
                $file = (new CommonService())->fileUploadService($request->userfile2, 'lecture');
                $lecture->filename2 = $file['filename'];
                $lecture->realfile2 = $file['realfile'];            
            }

            if( $request->userfile3 ){
                $file = (new CommonService())->fileUploadService($request->userfile3, 'lecture');
                $lecture->filename3 = $file['filename'];
                $lecture->realfile3 = $file['realfile'];            
            }
    
            if( $request->delfile ){
                (new CommonService())->fileDeleteService($request->delfile);
            }

            if( $request->delfile2 ){
                (new CommonService())->fileDeleteService($request->delfile2);
            }

            if( $request->delfile3 ){
                (new CommonService())->fileDeleteService($request->delfile3);
            }

            if( $request->password ){
                $lecture->password = $request->password;
            }
            $lecture->complete_at = now();
            $lecture->save();

            $this->dbCommit($msg ?? ( checkUrl() == 'admin' ? '관리자 ' : '사용자' ).' 강의원고 '.$request->sid ? '수정' : '접수');

            if( checkUrl() == 'admin' ){
                return redirect()->route('admin.lecture.modifyForm', ['sid'=>encrypt($lecture->sid)]);
            }else{
                return redirect()->route('lecture.search')->withSuccess('강의원고 '.($request->sid ? '수정이' : '접수가').' 완료되었습니다.');
            }
            
        } catch (\Exception $e) {

            return $this->dbRollback($e);

        } 
        
    }

    public function search(Request $request)
    {
        $data['subNum'] = '3';

        return $data;
    }

    public function searchResult(Request $request)
    { 
        $lecture = Lecture::where('name', $request->name)->where('email', $request->email)->first();

        if( !$lecture ){
            return redirect()->back()->withError('조회되는 내역이 없습니다.');
        }else{
            if( !Hash::check($request->password, $lecture->password ) ){
                return redirect()->back()->withError('조회되는 내역이 없습니다.');
            }
        }

        $periodCheck = $this->periodCheck();

        $data['apply'] = $lecture;        
        $data['subNum'] = '3';
        $data['modifyYn'] = $periodCheck['result'];

        return view('lecture.searchResult')->with($data);
    }

    private function periodCheck()
    {
        $result = false;
        $period = LecturePeriod::find(1);

        if( !$period ){
            return ['result'=>$result, 'msg'=>'강의원고 접수 기간이 설정되어 있지 않습니다.'];
        }

        if( strtotime($period->sdate) < time() && strtotime($period->edate) > time() ){
            $result = true;
        }
        
        if( !$result ){
            return ['result'=>$result, 'msg'=>'강의원고 접수 기간이 설정되어 있지 않습니다.'];
        }else{
            return ['result'=>$result, 'msg'=>''];
        }
    }    

    private function makeRegistNumber()
    {
        $maxNumber = Lecture::selectRaw('max(substring(rnum,3)) as maxNumber')->first();
        return 'A-'.($maxNumber['maxNumber']?sprintf('%04d',($maxNumber['maxNumber'])+1):'0001');
    }
}
