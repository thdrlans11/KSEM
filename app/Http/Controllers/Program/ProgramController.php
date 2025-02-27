<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function __construct()
    {
        view()->share([
            'mainNum' => '2'
        ]);
    }

    public function glance()
    {
        return view('program.glance')->with(['subNum' => '1']);
    }

    public function scientific()
    {
        return view('program.scientific')->with(['subNum' => '2']);
    }
}
