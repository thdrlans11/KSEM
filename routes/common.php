<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Common Routes
|--------------------------------------------------------------------------
*/
// 메인 페이지
Route::controller(\App\Http\Controllers\MainController::class)->group(function() {
    Route::get('/', 'main')->name('main');
    Route::get('/ready', 'ready')->name('ready');
});;

// 관리자 페이지
Route::controller(\App\Http\Controllers\Admin\MainController::class)->group(function() {
    Route::get('/admin', 'main')->name('admin');
});

// 로그인
Route::middleware('guest')->prefix('auth')->controller(\App\Http\Controllers\Admin\AuthController::class)->group(function() {
    Route::get('/', 'loginShow')->name('loginShow');
    Route::post('/', 'loginProcess')->name('loginProcess');
});

// 로그아웃
Route::middleware('auth:admin')->prefix('auth')->controller(\App\Http\Controllers\Admin\AuthController::class)->group(function() {
    Route::get('logout', 'logoutProcess')->name('logoutProcess');
});

Route::controller(\App\Http\Controllers\Controller::class)->prefix('common')->group(function () {       
    /*
     * File Download URL
     * type => only: 단일, zip: 일괄다운(zip)
     * tbl => 테이블
     * sid => sid 값 enCryptString(sid) 로 암호화해서 전송
     */
    Route::get('fileDownload/{type}/{tbl}/{sid}', 'fileDownload')->where('type', 'only|zip')->name("download");
    Route::post('/tinyUpload', 'tinyUpload')->name("tinyUpload");
    Route::post('/plUpload', 'plUpload')->name("plUpload");

    Route::post('captcha-make', 'captchaMake')->name("captcha.make");
    Route::post('captcha-check', 'captchaCheck')->name("captcha.check");
});

?>