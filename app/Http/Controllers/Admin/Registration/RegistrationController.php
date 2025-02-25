<?php

namespace App\Http\Controllers\Admin\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\Registration\RegistrationService;
use App\Services\Registration\RegistrationService as RegistrationUserService;

class RegistrationController extends Controller
{
    private $RegistrationService;
    private $RegistrationUserService;

    public function __construct()
    {
        $this->RegistrationService = new RegistrationService();
        $this->RegistrationUserService = new RegistrationUserService();
    }

    public function list(Request $request)
    {
        return view('admin.registration.list')->with( $this->RegistrationService->list($request) );
    }

    public function modifyForm(Request $request)
    {
        return view('admin.registration.form')->with( $this->RegistrationService->modifyForm($request) );
    }

    public function modify(Request $request)
    {
        if( $request->step == '1' ){
            return $this->RegistrationUserService->upsert_01($request);
        }else if( $request->step == '2' ){
            return $this->RegistrationUserService->upsert_02($request);
        }else if( $request->step == '3' ){
            return $this->RegistrationUserService->upsert_03($request);
        }
    }

    public function sendMailForm(Request $request)
    {
        return view('admin.registration.mail')->with( $this->RegistrationService->sendMailForm($request) );
    }

    public function sendMail(Request $request)
    {
        return $this->RegistrationService->sendMail($request);
    }

    public function excel(Request $request)
    {
        $request->merge(['excel' => true]);
        return $this->RegistrationService->list($request);
    }

    public function dbChange(Request $request)
    {
        return $this->RegistrationService->dbChange($request);
    }

    public function memoForm(Request $request)
    {
        return view('admin.registration.memo')->with( $this->RegistrationService->memoForm($request) );
    }

    public function memo(Request $request)
    {
        return $this->RegistrationService->memo($request);
    }

}
