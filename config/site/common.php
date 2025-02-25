<?php
return [

    // ================= api =================
    'api' => [
        'url' => env('APP_URL') . '/api',
    ],

    // ================= admin =================
    'admin' => [
        'url' => env('APP_URL') . '/admin',
    ],

    // ================= web =================
    'web' => [
        'url' => env('APP_URL'),
    ],

    'info' => [                
        'simpleName' => '대한응급의학회',
        'siteName' => '2025년도 대한응급의학회 춘계학술대회',
        'name' => '2025년도 대한응급의학회 춘계학술대회',
        'nameEng' => '2025 KSEM',
        'email' => 'office@emergency.or.kr',
        'email2' => 'a01028622407@gmail.com',        
        'url' => env('APP_URL'),
        'ecareNum' => env('ECARE_NUMBER'),
        'eventDay' => '2025-04-17'
    ],

    'default' => [
        'adminReceive' => false, //사무국 메일 활성화
        'mailReceive' => true, // 기획자 메일 활성화
    ],

    'dayOfWeek' => [
        '0' => '일',
        '1' => '월',
        '2' => '화',
        '3' => '수',
        '4' => '목',
        '5' => '금',
        '6' => '토'
    ],
]
?>