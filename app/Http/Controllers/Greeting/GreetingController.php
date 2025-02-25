<?php

namespace App\Http\Controllers\Greeting;

use App\Http\Controllers\Controller;

class GreetingController extends Controller
{
    public function __construct()
    {
        view()->share([
            'mainNum' => '1'
        ]);
    }

    public function message()
    {
        return view('greeting.message')->with(['subNum' => '1']);
    }
}
