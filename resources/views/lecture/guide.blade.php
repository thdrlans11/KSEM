@extends('include.layout')            

@section('content')
<div class="guide-conbox">
    <div class="regi-date-wrap">
        <img src="/assets/image/sub/img_regi_date.png" alt="">
        <div class="text-wrap">
            <p class="tit">접수 마감일: <strong class="text-pink">{{ $period->edate->format('Y년 m월 d일') }}({{ config('site.common.dayOfWeek')[$period->edate->format('w')] }})</strong></p>
        </div>
    </div>
    <ul class="list-type list-type-bar">
        <li>강의원고, 이력(CV), 발표슬라이드 의 파일 크기가 400MB가 넘는 경우 <a href="mailto:haksulpco@naver.com">haksulpco@naver.com</a>로 개별적으로 보내주시기 바랍니다.</li>
        <li>400MB 가 넘지 않는데 업로드 되지 않으시는 경우 쿠키삭제 또는 ctrl+f5 키를 눌러 새로고침 하신 후 다시한번 업로드 부탁드립니다.</li>
    </ul>
    <div class="btn-wrap text-center">
        <a href="{{ route('apply.lecture') }}" class="btn btn-img btn-green">강의원고 등록 바로가기</a>
    </div>
</div>
@endsection