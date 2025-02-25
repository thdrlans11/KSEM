@extends('include.layout')

@section('content')
<article class="inner-layer">
    <div class="section main-visual-top">
        <div class="main-visual-wrap">
            <div class="main-visual">
                <div class="slide-con-slide">
                    <a href="#n">
                        <img src="/assets/image/main/main_visual.png" alt="" class="">
                    </a>
                </div>
            </div>
        </div>

        <div class="main-aside">
            <div class="main-aside-con menu1 m-hide">
                <div class="box">
                    <a href="#n">학회 프로그램</a>
                    <ul class="list-type list-type-dot">
                        @foreach( config('site.menu.sub_menu')['2'] as $skey => $sval ) 
                        <li>
                            <a href="{{ route($sval['route_target'],$sval['route_param']) }}"><span>{{ $sval['name'] }}</span></a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="main-aside-con menu2 m-hide">
                <div class="box">
                    <a href="#n">사전등록</a>
                    <ul class="list-type list-type-dot">
                        @foreach( config('site.menu.sub_menu')['4'] as $skey => $sval ) 
                        <li>
                            <a href="{{ route($sval['route_target'],$sval['route_param']) }}"><span>{{ $sval['name'] }}</span></a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="main-aside-con menu1 m-show">
                <div class="box">
                    <a href="#n" onclick="swalAlert('준비중 입니다.', '', 'info')">Voting</a>
                </div>
            </div>
            <div class="main-aside-con menu2 m-show">
                <div class="box">
                    <a href="#n" onclick="swalAlert('준비중 입니다.', '', 'info')">Q&A</a>
                </div>
            </div>
            <div class="main-aside-con menu3">
                <div class="box">
                    <a href="#n">강의원고 접수</a>
                    <ul class="list-type list-type-dot">
                        @foreach( config('site.menu.sub_menu')['5'] as $skey => $sval ) 
                        <li>
                            <a href="{{ route($sval['route_target'],$sval['route_param']) }}"><span>{{ $sval['name'] }}</span></a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="main-aside-con menu4">
                <div class="box">
                    <a href="#n">행사장 안내</a>
                    <ul class="list-type list-type-dot">
                        @foreach( config('site.menu.sub_menu')['7'] as $skey => $sval ) 
                        <li>
                            <a href="{{ route($sval['route_target'],$sval['route_param']) }}"><span>{{ $sval['name'] }}</span></a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section link-wrap">
        <div class="main-tit-wrap">
            <img src="/assets/image/main/ic_noti.png" alt="">
            <p class="main-tit">주요일정</p>
        </div>
        <div class="col-wrap">
            <div class="col2">
                <div>
                    <p class="title">온라인 사전등록</p>
                    <p class="date">2025-02-01 ~ 2025-03-31</p>
                </div>
                <p class="dday">D - 100</p>
            </div>
            <div class="col2">
                <div>
                    <p class="title">강의원고 등록</p>
                    <p class="date">2025-02-01 ~ 2025-03-31</p>
                </div>
                <p class="dday">D - 100</p>
            </div>
        </div>
    </div>
</article>
@endsection