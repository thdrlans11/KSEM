<?php
return [
    'menu' => [
        '1' => [
            'name' => '인사말',
            'url' => "",
            'route_target' => 'greeting.message',
            'route_param' => [],
        ],
        '2' => [
            'name' => '학회프로그램',
            'url' => "",
            'route_target' => 'ready',
            'route_param' => ['mainNum'=>'2', 'subNum'=>'1'],
        ],
        '3' => [
            'name' => '초록 구연 및 포스터접수',
            'url' => "",
            'route_target' => 'ready',
            'route_param' => ['mainNum'=>'3', 'subNum'=>'1'],
        ],
        '4' => [
            'name' => '사전등록',
            'url' => "",
            'route_target' => 'registration.guide',
            'route_param' => [],
        ],        
        '5' => [
            'name' => '강의원고',
            'url' => "",
            'route_target' => 'lecture.guide',
            'route_param' => [],
        ],
        '6' => [
            'name' => '워크숍신청',
            'url' => "",
            'route_target' => 'ready',
            'route_param' => ['mainNum'=>'6', 'subNum'=>'1'],
        ],
        '7' => [
            'name' => '행사장안내',
            'url' => "",
            'route_target' => 'ready',
            'route_param' => ['mainNum'=>'7', 'subNum'=>'1'],
        ],       
    ],

    'sub_menu' => [
        '1' => [
            '1' => [
                'name' => '인사말',
                'url' => "",
                'route_target' => 'greeting.message',
                'route_param' => [],
            ]
        ],
        '2' => [
            '1' => [
                'name' => '전체프로그램',
                'url' => "",
                'route_target' => 'ready',
                'route_param' => ['mainNum'=>'2', 'subNum'=>'1'],
            ],
            '2' => [
                'name' => '세부프로그램',
                'url' => "",
                'route_target' => 'ready',
                'route_param' => ['mainNum'=>'2', 'subNum'=>'2'],
            ]
        ],
        '3' => [
            '1' => [
                'name' => '초록접수안내',
                'url' => "",
                'route_target' => 'ready',
                'route_param' => ['mainNum'=>'3', 'subNum'=>'1'],
            ],
            '2' => [
                'name' => '초록접수',
                'url' => "",
                'route_target' => 'ready',
                'route_param' => ['mainNum'=>'3', 'subNum'=>'2'],
            ],
            '3' => [
                'name' => '초록접수 수정 및 확인',
                'url' => "",
                'route_target' => 'ready',
                'route_param' => ['mainNum'=>'3', 'subNum'=>'3'],
            ],
            '4' => [
                'name' => '초록심사',
                'url' => "",
                'route_target' => 'ready',
                'route_param' => ['mainNum'=>'3', 'subNum'=>'4'],
            ]
        ],
        '4' => [
            '1' => [
                'name' => '사전등록안내',
                'url' => "",
                'route_target' => 'registration.guide',
                'route_param' => [],
            ],
            '2' => [
                'name' => '사전등록',
                'url' => "",
                'route_target' => 'apply.registration',
                'route_param' => ['step'=>'1'],
            ],
            '3' => [
                'name' => '사전등록 확인 및 영수증',
                'url' => "",
                'route_target' => 'registration.search',
                'route_param' => [],
            ],
        ],
        '5' => [
            '1' => [
                'name' => '강의원고 접수 안내',
                'url' => "",
                'route_target' => 'registration.guide',
                'route_param' => [],
            ],
            '2' => [
                'name' => '강의원고 접수',
                'url' => "",
                'route_target' => 'apply.lecture',
                'route_param' => [],
            ],
            '3' => [
                'name' => '강의원고 수정 및 확인',
                'url' => "",
                'route_target' => 'lecture.search',
                'route_param' => [],
            ],
        ],
        '6' => [            
            '1' => [
                'name' => '워크숍 등록 안내',
                'url' => "",
                'route_target' => 'ready',
                'route_param' => ['mainNum'=>'6', 'subNum'=>'1'],
            ],
            '2' => [
                'name' => '워크숍 신청',
                'url' => "",
                'route_target' => 'ready',
                'route_param' => ['mainNum'=>'6', 'subNum'=>'2'],
            ]
        ],
        '7' => [            
            '1' => [
                'name' => '오시는길',
                'url' => "",
                'route_target' => 'ready',
                'route_param' => ['mainNum'=>'7', 'subNum'=>'1'],
            ],
            '2' => [
                'name' => '부스배치도',
                'url' => "",
                'route_target' => 'ready',
                'route_param' => ['mainNum'=>'7', 'subNum'=>'2'],
            ],
            '3' => [
                'name' => '학회장보기',
                'url' => "",
                'route_target' => 'ready',
                'route_param' => ['mainNum'=>'7', 'subNum'=>'3'],
            ],
            '4' => [
                'name' => '부스배치도',
                'url' => "",
                'route_target' => 'ready',
                'route_param' => ['mainNum'=>'7', 'subNum'=>'4'],
            ]
        ]
    ],
    
    'admin_menu' => [
        '1' => [
            'name' => '관리자계정',
            'url' => "",
            'route_target' => 'admin.member',
            'route_param' => [],
        ],
        '2' => [
            'name' => '등록관리',
            'url' => "",
            'route_target' => 'admin.registration.list',
            'route_param' => ['tabMode'=>'E'],
        ],
        '3' => [
            'name' => '강의원고',
            'url' => "",
            'route_target' => 'admin.lecture.list',
            'route_param' => [],
        ],
        '4' => [
            'name' => '초록관리',
            'url' => "",
            'route_target' => 'admin',
            'route_param' => [],
        ],
        '5' => [
            'name' => '초록심사',
            'url' => "",
            'route_target' => 'admin',
            'route_param' => [],
        ],
        '6' => [
            'name' => '워크샵신청',
            'url' => "",
            'route_target' => 'admin',
            'route_param' => [],
        ]
    ],
]

?>