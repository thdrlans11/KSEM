<?php

namespace App\Services\Admin\Lecture;

use App\Models\Lecture;
use App\Models\LecturePeriod;
use App\Services\dbService;
use Illuminate\Http\Request;

/**
 * Class LectureService
 * @package App\Services
 */
class LectureService extends dbService
{
    public function list(Request $request)
    {
        if( $request->del != 'Y' ){
            $lists = Lecture::orderBy('created_at','desc');
        }else{
            $lists = Lecture::onlyTrashed()->orderBy('created_at','desc');
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
            return (new ExcelService())->LectureExcel($lists, $cntQuery->count());
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
        $data['period'] = LecturePeriod::find(1);

        return $data;
    }
    
    public function modifyForm(Request $request)
    {
        $registration = Registration::find(decrypt($request->sid));

        $data['step'] = $request->step;
        $data['type'] = $registration->type;        
        $data['country'] = (new Country())->countryList('KOR');
        $data['captcha'] = (new CommonService())->captchaMakeService();
        $data['apply'] = $registration;
        $data['rgubun'] = $registration->ccode == 'KR' ? 'KOR' : null;

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

            if( $request->db == 'lecture_periods' ){

                $lecturePeriod = LecturePeriod::find(decrypt($request->sid));
                $lecturePeriod[$request->field] = $request->value;
                $lecturePeriod->save();

                $msg = '관리자 강의원고 등록 날짜 변경';

            }else{

                $lecture = lecture::withTrashed()->find(decrypt($request->sid));

                if( $request->field == 'delete' ){
                    if( $request->value == 'Y' ){
                        $lecture->delete();
                        $msg = '관리자 강의원고 삭제';
                    }else{
                        $lecture->restore();
                        $msg = '관리자 강의원고 복구';
                    }
                    
                }else{
                    $lecture[$request->field] = $request->value;

                    if( $request->field == 'payStatus' ){
                        if( $request->value != 'N' ){
                            $lecture->payComplete_at = now();
                            //(new MailService())->makeMail($lecture, 'applyPayComplete');
                        }else{
                            $lecture->payComplete_at = null;
                        }

                        $msg = '관리자 결제상태 변경';
                    }else if( $request->field == 'payMethod' ){
                        $msg = '관리자 결제방법 변경';
                    }

                    $lecture->save();
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
