<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $AuthService;

    public function __construct()
    {
        $this->AuthService = new AuthService();
    }

    public function loginShow()
    {
        return view('admin.auth');
    }

    public function loginProcess(Request $request)
    {
        return $this->AuthService->login($request);
    }

    public function logoutProcess()
    {
        return $this->AuthService->logout();
    }
}
