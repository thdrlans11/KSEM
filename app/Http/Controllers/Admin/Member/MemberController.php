<?php

namespace App\Http\Controllers\Admin\Member;

use App\Http\Controllers\Controller;
use App\Services\Admin\Member\MemberService;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private $MemberService;

    public function __construct()
    {
        $this->MemberService = new MemberService();
        view()->share(['mainNum' => '6']);
    }

    public function list(Request $request)
    {
        return view('admin.member.list')->with( $this->MemberService->list($request) );
    }

    public function form(Request $request)
    {
        return view('admin.member.form')->with( $this->MemberService->form($request) );
    }

    public function upsert(Request $request)
    {
        return $this->MemberService->upsert($request);
    }

    public function idCheck(Request $request)
    {
        return $this->MemberService->idCheck($request);
    }

    public function dbChange(Request $request)
    {
        return $this->MemberService->dbChange($request);
    }
}
