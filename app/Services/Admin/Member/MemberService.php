<?php

namespace App\Services\Admin\Member;

use App\Models\User;
use App\Services\dbService;
use App\Services\Util\ExcelService;
use Illuminate\Http\Request;

/**
 * Class MemberService
 * @package App\Services
 */
class MemberService extends dbService
{
    public function list(Request $request)
    {
        $lists = User::orderByDesc('created_at');

        foreach( $request->all() as $key => $val ){
            if( ( $key == 'id' || $key == 'email' )  && $val ){
                $lists->where($key, 'LIKE', '%'.$val.'%');        
            }
        }

        $lists = $lists->paginate('20')->appends($request->query());
        $lists = setListSeq($lists);
        $data['lists'] = $lists;

        return $data;
    }

    public function form(Request $request)
    {
        if( $request->sid ){
            $user = User::find(decrypt($request->sid));
            $data['user'] = $user;
        }else{
            $data['user'] = null;   
        }

        return $data;
    }

    public function upsert(Request $request)
    {
        $this->transaction();

        try {

            if( $request->sid ){
                $user = User::find(decrypt($request->sid));
                $user->setByPost($request);
                $user->save();
            }else{
                $user = new User();
                $user->setByPost($request);
                $user->save();
            }

            $this->dbCommit($msg ?? '관리자 계정 '.($request->sid?'수정':'등록')); 
            
            return redirect()->back()->withSuccess('계정이 '.($request->sid?'수정':'등록').'되었습니다.')->with('close','Y');

        } catch (\Exception $e) {

            return $this->dbRollback($e);

        }
    }

    public function idCheck(Request $request)
    {
        $user = User::where('id',trim($request->id))->first();

        if( $user ){
            return 'fail';
        }else{
            return 'success';
        }
        
    }

    public function dbChange(Request $request)
    {   
        $this->transaction();

        try {
            $user = User::find(decrypt($request->sid));
            
            if( $request->field == 'delete' ){
                if( $request->value == 'Y' ){
                    $user->delete();
                    $msg = '관리자 계정 삭제';
                }
            }else{
                $user[$request->field] = $request->value;
                $user->save();
            }
            

            $this->dbCommit($msg ?? '관리자 계정 데이터 변경'); 
            
            return 'success';

        } catch (\Exception $e) {

            return $this->dbRollback($e, 'ajax');

        }
    }
}
