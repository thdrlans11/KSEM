<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>{{ config('site.common.info.name') }}</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes,viewport-fit=cover">
    <meta name="format-detection" content="telephone=no, address=no, email=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Pragma" content="no-cache">
    
    <meta name="Author" content="{{ config('site.common.info.name') }}">
    <meta name="Keywords" content="{{ config('site.common.info.name') }}">
    <meta name="description" content="{{ config('site.common.info.name') }}">
    <meta property="og:title" content="{{ config('site.common.info.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/assets/image/favicon.ico">

    <link rel="stylesheet" href="/assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/assets/css/slick.css">
    <link rel="stylesheet" href="/assets/css/common.css">
    <link type="text/css" rel="stylesheet" href="/devScript/colorbox/example3/colorbox.css" />
    @stack('css')

    <script src="/assets/js/jquery-1.12.4.min.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
    <script src="/assets/js/slick.min.js"></script>
    <script src="/assets/js/common.js"></script>
    <script type="text/javascript" src="/devScript/common.js"></script>
    <script src="/devScript/colorbox/jquery.colorbox-min.js"></script>
    @stack('scripts')
</head>
<body>
    
    <!-- 
        main일 때 class="main"
        sub일 때 class="sub"
    -->
    <div id="wrap" class="{{ $wrapClass ?? 'sub' }}">
        <!-- header -->
        <header id="header" class="js-header">
            <div class="header-wrap inner-layer">
                <h1 class="header-logo"><a href="{{ route('main') }}"><img src="/assets/image/common/h1-logo.png" alt=""></a></h1>
                <div class="right">
                    <div class="top t-hide">
                        <div class="dday-wrap">
                            <img src="/assets/image/common/ic_dday.png" alt="">
                            <p class="today">TODAY {{ date('Y.m.d') }}</p>
                            <p class="dday">{{ DDay(config('site.common.info.eventDay')) }}</p>
                        </div>
                        <div class="util-menu-wrap m-hide">
                            <ul class="util-menu">
                                <li><a href="https://emergency.or.kr" target="_blank">대한응급의학회 홈페이지</a></li>
                                <li><a href="{{ route('main') }}">행사 HOME</a></li>
                                <li><a href="http://2024f.ksem.kr/index.php" target="_blank">지난 학술대회 바로가기</a></li>
                                <li><a href="{{ route('admin') }}">ADMIN</a></li>
                            </ul>
                        </div>
                    </div>
                    <nav id="gnb">
                        <div class="m-gnb-header t-show m-show">
                            <a href="https://emergency.or.kr" target="_blank" class="btn btn-link">대한응급의학회 홈페이지</a>
                            <div class="util-wrap">
                                <ul class="util-menu">
                                    <li><a href="{{ route('admin') }}">ADMIN</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="gnb-wrap">
                            <ul class="gnb js-gnb">
                                @foreach( config('site.menu.menu') as $key => $val ) @if( $key > 7 ) @continue @endif
                                <li>
                                    <a href="{{ route($val['route_target'],$val['route_param']) }}">
                                        {{ $val['name'] }}
                                    </a>
                                    @if( isset( config('site.menu.sub_menu')[$key] ) )
                                    <ul>
                                        @foreach( config('site.menu.sub_menu')[$key] as $skey => $sval )
                                        <li>
                                            <a href="{{ route($sval['route_target'],$sval['route_param']) }}">
                                                {{ $sval['name'] }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn btn-menu-close js-btn-menu-close"><span class="hide">메뉴 닫기</span></button>
                    </nav>
                </div>
                <a href="{{ route('main') }}" class="btn-home t-show m-show"><img src="/assets/image/common/ic_home.png" alt="Home"></a>
                <button type="button" class="btn btn-menu-open js-btn-menu-open"><span class="hide">메뉴 열기</span></button>
            </div>
            <div id="dim" class="js-dim"></div>
        </header>
        <!-- //header -->

        <section id="container">
            @if( !isset($wrapClass) )
            <article class="sub-visual">
                <div class="sub-visual-con inner-layer">
                </div>
            </article>
            <article class="sub-menu-wrap">
                <div class="sub-menu">
                    <ul class="sub-menu-list js-sub-menu-list cf">
                        <li class="sub-menu-depth01">
                            <a href="#n" class="btn-sub-menu js-btn-sub-menu">{{ config('site.menu.menu')[$mainNum]['name'] }}</a>
                            <ul>
                                @foreach( config('site.menu.menu') as $key => $val ) @if( $key > 7 ) @continue @endif
                                <li><a href="{{ route($val['route_target'],$val['route_param']) }}">{{ $val['name'] }}</a>
                                @endforeach
                            </ul>
                        </li>
                        @if( isset( config('site.menu.sub_menu')[$mainNum] ) )
                        <li class="sub-menu-depth02">
                            <a href="#n" class="btn-sub-menu js-btn-sub-menu">{{ config('site.menu.sub_menu')[$mainNum][$subNum]['name'] }}</a>
                            <ul>
                                @foreach( config('site.menu.sub_menu')[$mainNum] as $skey => $sval ) 
                                <li {!! $subNum == $skey ? 'class="on"' : '' !!}>
                                    <a href="{{ route($sval['route_target'],$sval['route_param']) }}"><span>{{ $sval['name'] }}</span></a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                    </ul>
                    <ul class="breadcrumb">
                        <li><img src="/assets/image/sub/img_breadcrumb.png" alt=""></li>
                        <li>HOME</li>
                        <li class="font-suit">&gt;</li>
                        <li>{{ config('site.menu.menu')[$mainNum]['name'] }}</li>
                        @if( isset( config('site.menu.sub_menu')[$mainNum] ) )
                        <li class="font-suit">&gt;</li>
                        <li>{{ config('site.menu.sub_menu')[$mainNum][$subNum]['name'] }}</li>
                        @endif
                    </ul>
                </div>
            </article>
            <article class="sub-contents">
                <div class="sub-conbox inner-layer">
        
                    <div class="page-tit-wrap">
                        <h3 class="page-tit">{{ isset($subNum) ? config('site.menu.sub_menu')[$mainNum][$subNum]['name'] : config('site.menu.menu')[$mainNum]['name'] }}</h3>
                    </div>
            @endif

            @yield('content')
            
            @if( !isset($wrapClass) )
                </div>
            </article>
            @endif

        </section>

        <!-- footer -->
        <footer id="footer">
            <div class="footer-wrap inner-layer">
                <div class="footer-logo"><img src="/assets/image/common/footer-logo.png" alt=""></div>
                <ul>
                    <li>
                        <p>(04510) 서울특별시 중구 청파로 464, 101동 3104호 (중림동, 브라운스톤서울)</p>
                    </li>
                    <li>
                        <p><span>TEL </span><a href="tel:02-3676-1333">(02) 3676-1333</a></p>
                        <p><span>FAX </span>(02) 3676-1339</p>
                        <p><span>EMAIL </span><a href="mailto:office@emergency.or.kr">office@emergency.or.kr</a></p>
                    </li>
                    <li>
                        <p><span>COPYRIGHT 대한응급의학회 (THE KOREAN SOCIETY OF EMERGENCY MEDICINE) ALL RIGHTS RESERVED.</span></p>
                    </li>
                </ul>
            </div>
        </footer>
        <!-- //footer -->
    </div>

    @include('sweetalert::alert')
</body>
</html>
