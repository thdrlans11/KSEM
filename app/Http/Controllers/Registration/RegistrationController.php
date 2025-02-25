<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Services\Registration\RegistrationService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    private $RegistrationService;

    public function __construct()
    {
        $this->RegistrationService = new RegistrationService();

        view()->share([
            'mainNum' => '4'
        ]);
    }

    public function guide()
    {
        return $this->RegistrationService->guide();
    }

    public function registration(Request $request)
    {
        return $this->RegistrationService->registration($request);
    }

    public function emailCheck(Request $request)
    {
        return $this->RegistrationService->emailCheck($request);
    }

    public function phoneCheck(Request $request)
    {
        return $this->RegistrationService->phoneCheck($request);
    }

    public function makePrice(Request $request)
    {
        return $this->RegistrationService->makePrice($request);
    }

    public function makeLocalSub(Request $request)
    {
        return $this->RegistrationService->makeLocalSub($request);
    }

    public function upsert(Request $request)
    {
        if( $request->step == '1' ){
            return $this->RegistrationService->upsert_01($request);
        }else if( $request->step == '2' ){
            return $this->RegistrationService->upsert_02($request);
        }
    }

    public function payRegist(Request $request)
    {
        return $this->RegistrationService->payRegist($request);
    }

    public function payCancel(Request $request)
    {
        return $this->RegistrationService->payCancel($request);
    }

    public function paySuccess(Request $request)
    {
        return $this->RegistrationService->paySuccess($request);
    }

    public function payFail(Request $request)
    {
        return $this->RegistrationService->payFail($request);
    }

    public function search(Request $request)
    {
        return view('registration.search')->with( $this->RegistrationService->search($request));
    }

    public function searchResult(Request $request)
    {
        return $this->RegistrationService->searchResult($request);
    }
}
