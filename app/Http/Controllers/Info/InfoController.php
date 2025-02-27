<?php

namespace App\Http\Controllers\Info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function __construct()
    {
        view()->share([
            'mainNum' => '7'
        ]);
    }

    public function venue()
    {
        return view('info.venue')->with(['subNum' => '1']);
    }

    public function hotel()
    {
        return view('info.hotel')->with(['subNum' => '4']);
    }
}
