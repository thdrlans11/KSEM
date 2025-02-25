<?php

namespace App\Http\Controllers;

use App\Services\MainService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    private $MainService;

    public function __construct()
    {        

        $this->MainService = new MainService();

        view()->share([
            'wrapClass' => 'main',
        ]);
    }

    public function main()
    {   
        return view('main')->with( $this->MainService->data() );
    }

    public function ready(Request $request)
    {     
        return view('ready')->with([
            'mainNum' => $request->mainNum,
            'subNum' => $request->subNum,
            'wrapClass' => null
        ]);         
    }
}
