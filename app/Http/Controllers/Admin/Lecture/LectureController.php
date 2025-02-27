<?php

namespace App\Http\Controllers\Admin\Lecture;

use App\Http\Controllers\Controller;
use App\Services\Admin\Lecture\LectureService;
use App\Services\Lecture\LectureService as LectureUserService;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    private $LectureService;
    private $LectureUserService;

    public function __construct()
    {
        $this->LectureService = new LectureService();
        $this->LectureUserService = new LectureUserService();
    }

    public function list(Request $request)
    {
        return view('admin.lecture.list')->with( $this->LectureService->list($request) );
    }

    public function modifyForm(Request $request)
    {
        return view('admin.lecture.form')->with( $this->LectureService->modifyForm($request) );
    }

    public function modify(Request $request)
    {
        return $this->LectureUserService->upsert($request);
    }

    public function excel(Request $request)
    {
        $request->merge(['excel' => true]);
        return $this->LectureService->list($request);
    }

    public function dbChange(Request $request)
    {
        return $this->LectureService->dbChange($request);
    }

    public function memoForm(Request $request)
    {
        return view('admin.lecture.memo')->with( $this->LectureService->memoForm($request) );
    }

    public function memo(Request $request)
    {
        return $this->LectureService->memo($request);
    }
}
