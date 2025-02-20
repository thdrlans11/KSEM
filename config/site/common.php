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
        'siteName' => '2025년도 대한응급의학회 춘계학술대회',
        'name' => '2025년도 대한응급의학회 춘계학술대회',
        'email' => 'office@emergency.or.kr',
        'url' => env('APP_URL'),
        'ecareNum' => env('ECARE_NUMBER'),
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