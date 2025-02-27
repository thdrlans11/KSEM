<?php

namespace App\Services\Admin\Lecture;

use App\Models\Hospital;
use App\Models\Lecture;
use App\Models\LecturePeriod;
use App\Services\CommonService;
use App\Services\dbService;
use App\Services\Util\ExcelService;
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
        $lecture = Lecture::find(decrypt($request->sid));
        $data['hospitals'] = Hospital::orderby('hospital')->get();
        $data['captcha'] = (new CommonService())->captchaMakeService();
        $data['apply'] = $lecture;

        return $data;
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
                    $lecture->save();
                    $msg = '관리자 강의원고 변경';
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
        $lecture = Lecture::find(decrypt($request->sid));
        $data['apply'] = $lecture;

        return $data;
    }    

    public function memo(Request $request)
    {   
        $this->transaction();

        try {

            $lecture = Lecture::find(decrypt($request->sid));
            $lecture->memo = $request->memo;
            $lecture->save();

            $this->dbCommit('강의원고 메모 변경'); 
            
            return redirect()->back()->withSuccess('메모 저장이 완료되었습니다.')->with('close','Y');

        } catch (\Exception $e) {

            return $this->dbRollback($e);

        }
    }
}
