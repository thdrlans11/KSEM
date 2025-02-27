<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//인사말
Route::prefix('greeting')->controller(\App\Http\Controllers\Greeting\GreetingController::class)->group(function() {
    Route::get('', 'message')->name('greeting.message');
});

//사전등록
Route::prefix('registration')->controller(\App\Http\Controllers\Registration\RegistrationController::class)->group(function() {
    Route::get('/guide', 'guide')->name('registration.guide');  
    Route::middleware('noCash')->group(function(){
        Route::get('registration/{step}', 'registration')->where('step', '1|2|3')->name('apply.registration');
        Route::post('emailCheck', 'emailCheck')->name('apply.registration.emailCheck');
        Route::post('phoneCheck', 'phoneCheck')->name('apply.registration.phoneCheck');
        Route::post('makePrice', 'makePrice')->name('apply.registration.makePrice');
        Route::post('makeLocalSub', 'makeLocalSub')->name('apply.registration.makeLocalSub');
        Route::post('upsert/{step}', 'upsert')->where('step', '1|2')->name('apply.registration.upsert');
        Route::post('payRegist', 'payRegist')->name('apply.registration.payRegist');
    });

    //Route::get('payCancel', 'payCancel')->name('apply.registration.payCancel');

    Route::post('paySuccess', 'paySuccess')->name('apply.registration.paySuccess');
    Route::post('payFail', 'payFail')->name('apply.registration.payFail');

    Route::get('search', 'search')->name('registration.search');
    Route::post('search', 'searchResult')->name('registration.searchResult');
});

//현장등록
Route::prefix('scene')->controller(\App\Http\Controllers\Scene\SceneController::class)->group(function() {
    Route::middleware('noCash')->group(function(){
        Route::get('registration', 'registration')->name('apply.scene.registration');
        Route::post('upsert', 'upsert')->name('apply.scene.registration.upsert');
    });    
});

//원고등록
Route::prefix('lecture')->controller(\App\Http\Controllers\Lecture\LectureController::class)->group(function() {
    Route::get('/guide', 'guide')->name('lecture.guide');  
    Route::middleware('noCash')->group(function(){
        Route::get('registration', 'registration')->name('apply.lecture');
        Route::post('emailCheck', 'emailCheck')->name('apply.lecture.emailCheck');
        Route::post('upsert', 'upsert')->name('apply.lecture.upsert');
        
    });
    Route::get('search', 'search')->name('lecture.search');
    Route::post('search', 'searchResult')->name('lecture.searchResult');
});

//학회 프로그램
Route::prefix('program')->controller(\App\Http\Controllers\Program\ProgramController::class)->group(function() {
    Route::get('', 'glance')->name('program.glance');
    Route::get('scientific', 'scientific')->name('program.scientific');
});

//행사장안내
Route::prefix('info')->controller(\App\Http\Controllers\Info\InfoController::class)->group(function() {
    Route::get('venue', 'venue')->name('info.venue');
    Route::get('hotel', 'hotel')->name('info.hotel');
});



require __DIR__.'/common.php';