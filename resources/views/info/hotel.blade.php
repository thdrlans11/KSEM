@extends('include.layout')

@section('content')
<div class="border-box bg-grey hotel">
    <p>홀리데이인 광주호텔</p>
    <span class="btn btn-small color-type8">마감</span>
</div>

<div class="table-wrap mt-20">
    <table class="cst-table">
        <caption class="hide">버스노선</caption>
        <colgroup>
            <col style="width: 50%;">
            <col>
        </colgroup>
        <tbody>
            <tr>
                <th>객실타입</th>
                <th>금액</th>
            </tr>
            <tr>
                <td class="text-center">1 킹베드 스탠다드</td>
                <td class="text-center">169,400원 (최대2인)</td>
            </tr>
            <tr>
                <td class="text-center">2 싱글베드 스탠다드</td>
                <td class="text-center">169,400원 (최대2인)</td>
            </tr>
            <tr>
                <td class="text-center">1 킹베드 프리미엄</td>
                <td class="text-center">181,500원 (최대2인)</td>
            </tr>
            <tr>
                <td class="text-center">2 싱글베드 프리미엄</td>
                <td class="text-center">181,500원 (최대2인)</td>
            </tr>
            <tr>
                <td class="text-center">1 킹베드 1 싱글베드 프리미엄</td>
                <td class="text-center">205,700원 (최대3인)</td>
            </tr>
        </tbody>
    </table>
</div>

<p class="notice-tit"><span>예약방법</span></p>
<ul class="list-type list-type-bar">
    <li>위 금액은 세금&봉사료 포함입니다.</li>
    <li>조식 추가 시 1인 34,650원</li>
    <li>예약마감일 2025년 4월 2일(수) 18시</li>
</ul>
@endsection