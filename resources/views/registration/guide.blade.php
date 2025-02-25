@extends('include.layout')  

@section('content')
<div class="guide-conbox">
    <div class="regi-date-wrap">
        <img src="/assets/image/sub/img_regi_date.png" alt="">
        <div class="text-wrap">
            <p class="tit">사전등록 마감일: <strong class="text-pink">{{ $period->Eedate->format('Y년 m월 d일') }}({{ config('site.common.dayOfWeek')[$period->Eedate->format('w')] }})</strong></p>
        </div>
    </div>
    <ul class="list-type list-type-bar">
        <li>홈페이지 사전등록 접수와 입금을 마감일까지 해 주시기 바랍니다.</li>
        <li>홈페이지 등록접수 또는 입금만 한 경우 인정 되지 않습니다.</li>
        <li>마감일 이후 등록접수 또는 입금한 경우 현장등록으로 처리되오니 유의하시기 바랍니다.</li>
        <li class="text-red">현장등록 시 중식이 제공되지 않습니다.</li>
        <li><strong>대한의사협회 연수평점 : 17일: 6점(필수평점 1점) / 18일: 5점 (필수평점1점)</strong></li>
        <li>다시보기 운영 예정이며 다시보기는 사전등록자에 한하여 시청 가능합니다.</li>
    </ul>
    <div class="btn-wrap text-center">
        <a href="{{ route('apply.registration', ['step'=>'1']) }}" class="btn btn-img btn-blue">사전등록 바로가기</a>
    </div>

    <div class="sub-tit-wrap">
        <h4 class="sub-tit">등록비</h4>
    </div>
    <div class="table-wrap">
        <table class="cst-table">
            <caption class="hide">등록비</caption>
            <colgroup>
                <col style="width: 25%;">
                <col style="width: 25%;">
                <col style="width: 25%;">
                <col>
            </colgroup>
            <thead>
                <tr>
                    <th scope="col" colspan="2">구분</th>
                    <th scope="col">사전등록(Early bird)</th>
                    <th scope="col">현장등록(On site)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th rowspan="2">{{ config('site.registration.attendTypetText')['A'] }}</th>
                    <th>전문의</th>
                    <td class="text-center">{{ number_format(config('site.registration.categoryPrice')['A']['E']['B'])  }}</td>
                    <td class="text-center">{{ number_format(config('site.registration.categoryPrice')['A']['S']['B'])  }}</td>
                </tr>
                <tr>
                    <th>전문의 외</th>
                    <td class="text-center">{{ number_format(config('site.registration.categoryPrice')['A']['E']['C'])  }}</td>
                    <td class="text-center">{{ number_format(config('site.registration.categoryPrice')['A']['S']['C'])  }}</td>
                </tr>
                <tr>
                    <th rowspan="2">{{ config('site.registration.attendTypetText')['B'] }}</th>
                    <th>전문의</th>
                    <td class="text-center">{{ number_format(config('site.registration.categoryPrice')['B']['E']['B'])  }}</td>
                    <td class="text-center">{{ number_format(config('site.registration.categoryPrice')['B']['S']['B'])  }}</td>
                </tr>
                <tr>
                    <th>전문의 외</th>
                    <td class="text-center">{{ number_format(config('site.registration.categoryPrice')['B']['E']['C'])  }}</td>
                    <td class="text-center">{{ number_format(config('site.registration.categoryPrice')['B']['S']['C'])  }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <p class="help-text text-red mt-10">* 전공의 무료</p>

    <div class="sub-tit-wrap">
        <h4 class="sub-tit">등록비 결제방법</h4>
    </div>
    <ul class="list-type list-type-bar">
        <li>온라인 송금 또는 카드결제</li>
        <li>신한은행 110-543-331734 김창선 대한응급의학회 재무이사</li>
    </ul>

    <div class="sub-tit-wrap">
        <h4 class="sub-tit">등록방법 및 확인</h4>
    </div>
    <ul class="list-type list-type-bar">
        <li>사전등록은 대한응급의학회 학술대회 홈페이지에서 편리하게 하실 수 있습니다.</li>
        <li>사전등록 신청 결과는 입력된 이메일로 자동 발송 됩니다.</li>
        <li>사전등록 확인은 학술대회 홈페이지 > 사전등록 > 사전등록 확인 및 영수증 > 에서 확인하시기 바랍니다.</li>
        <li>등록비 입금 시 반드시 (본인 이름+소속명)으로 기재하시기 바랍니다.</li>
        <li>입금 하신 후, 2-3일 내에 등록확인이 되지 않으면 학회로 연락주시기 바랍니다.</li>
    </ul>

    <div class="sub-tit-wrap">
        <h4 class="sub-tit">영수증 출력</h4>
    </div>
    <ul class="list-type list-type-bar">
        <li>사전등록 신청후 등록비 입금확인 되면 "사전등록 확인 및 영수증" 에서 "입금완료" 확인이 가능합니다.</li>
        <li>영수증 출력은 사전등록 취소로 인한 오류가 많이 발생하여 사전등록 마감일 이후 출력가능하게 변경되었습니다.</li>
        <li>마감일 이후 "사전등록 확인 및 영수증" 창에서 출력해 주시기 바랍니다.</li>
    </ul>

    <div class="sub-tit-wrap">
        <h4 class="sub-tit">사전등록 취소</h4>
    </div>
    <div class="btn-wrap mt-0 mb-10">
        <a href="#n" class="btn btn-small color-cancle">
            <p>사전등록 취소 요청서 다운로드 (<span class="text-skyblue">계좌이체</span>) </p>
            <img src="/assets/image/sub/ic_btn_down.png" alt="" class="right">
        </a>
        <a href="#n" class="btn btn-small color-cancle">
            <p>사전등록 취소 요청서 다운로드 (<span class="text-skyblue">카드결제</span>) </p>
            <img src="/assets/image/sub/ic_btn_down.png" alt="" class="right">
        </a>
    </div>
    <ul class="list-type list-type-bar">
        <li>사전등록 취소를 원하시는 경우 취소요청서를 작성하여 이메일 <a href="mailto:ksem_yj@emergency.or.kr">ksem_yj@emergency.or.kr</a> 혹은 팩스 02)3676-1339로 보내주시기 바랍니다.</li>
        <li>사전등록 취소는 사전등록 마감일 2024년 10월 11일(금)까지만 가능하오니 양해 부탁드립니다.</li>
        <li>등록비 반환은 학술대회가 있는 월 말에 환불처리 됩니다.</li>
    </ul>

    <div class="sub-tit-wrap">
        <h4 class="sub-tit">공지사항</h4>
    </div>
    <ul class="list-type list-type-bar">
        <li>사전등록 마감일 이후에는 현장등록만 가능합니다.</li>
        <li>정년퇴임 하신 분들은 무료등록 입니다. (만 65세 이상)</li>
        <li>대한의사협회 연수교육 지침에 따라 등록비를 납부하더라도 출석하지 않으면 평점을 부여하지 않습니다(*대리출석 불가)</li>
        <li>학회장에서 명찰 인쇄 후 입실과 퇴실 시 반드시 출석확인 바코드에 접촉하여 주시기 바랍니다.</li>
        <li>주차권은 현장에서 판매됩니다. (가급적 대중교통을 이용해 주시기 바랍니다.)</li>
    </ul>
    <div class="btn-wrap text-center">
        <a href="{{ route('apply.registration', ['step'=>'1']) }}" class="btn btn-img btn-blue">사전등록 바로가기</a>
        <a href="{{ route('registration.search') }}" class="btn btn-img btn-green">사전등록 확인 및 영수증</a>
    </div>
</div>
@endsection