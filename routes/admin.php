<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function(){

    //회원 관리
    Route::prefix('member')->controller(\App\Http\Controllers\Admin\Member\MemberController::class)->group(function() {
        Route::get('/', 'list')->name('admin.member');
        Route::get('/form/{sid?}', 'form')->name('admin.member.form');
        Route::post('/upsert/{sid?}', 'upsert')->name('admin.member.upsert');
        Route::post('/idCheck', 'idCheck')->name('admin.member.idCheck');
        Route::post('/dbChange', 'dbChange')->name('admin.member.dbChange');
    });
    
    //등록 관리
    Route::prefix('registration')->controller(\App\Http\Controllers\Admin\Registration\RegistrationController::class)->group(function() {            
        Route::get('/{tabMode}', 'list')->where('tabMode', 'E|S|I|N')->name('admin.registration.list');
        Route::get('/modify/{sid}', 'modifyForm')->name('admin.registration.modifyForm');
        Route::post('/modify/{sid}', 'modify')->name('admin.registration.modify');
        Route::get('/sendMail/{sid}', 'sendMailForm')->name('admin.registration.sendMailForm');
        Route::post('/sendMail/{sid}', 'sendMail')->name('admin.registration.sendMail');
        Route::get('/excel/{tabMode}', 'excel')->where('tabMode', 'E|S|I|N')->name('admin.registration.excel');
        Route::post('/dbChange', 'dbChange')->name('admin.registration.dbChange');
        Route::get('/memo/{sid}', 'memoForm')->name('admin.registration.memoForm');
        Route::post('/memo/{sid}', 'memo')->name('admin.registration.memo');
        Route::get('/vip/{sid}', 'vipForm')->name('admin.registration.vipForm');
        Route::post('/vip/{sid}', 'vip')->name('admin.registration.vip');
    });

    //강의원고 관리
    Route::prefix('lecture')->controller(\App\Http\Controllers\Admin\Lecture\LectureController::class)->group(function() {            
        Route::get('/', 'list')->name('admin.lecture.list');
        
        Route::get('/modify/{sid}', 'modifyForm')->name('admin.lecture.modifyForm');
        Route::post('/modify/{sid}', 'modify')->name('admin.lecture.modify');
        Route::get('/excel', 'excel')->name('admin.lecture.excel');
        Route::post('/dbChange', 'dbChange')->name('admin.lecture.dbChange');
        Route::get('/memo/{sid}', 'memoForm')->name('admin.lecture.memoForm');
        Route::post('/memo/{sid}', 'memo')->name('admin.lecture.memo');
    });
	
	

}); 

require __DIR__.'/common.php';
?>