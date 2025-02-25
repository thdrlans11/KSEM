<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Services\Lecture\LectureService;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    private $LectureService;

    public function __construct()
    {
        $this->LectureService = new LectureService();

        view()->share([
            'mainNum' => '5'
        ]);
    }

    public function guide()
    {
        return $this->LectureService->guide();
    }

    public function registration(Request $request)
    {
        return $this->LectureService->registration($request);
    }

    public function emailCheck(Request $request)
    {
        return $this->LectureService->emailCheck($request);
    }

    public function upsert(Request $request)
    {
        return $this->LectureService->upsert($request);
    }

    public function search(Request $request)
    {
        return view('lecture.search')->with( $this->LectureService->search($request));
    }

    public function searchResult(Request $request)
    {
        return $this->LectureService->searchResult($request);
    }
}
