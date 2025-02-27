@extends('include.layout')

@push('scripts')
<script type="text/javascript" src="/devScript/registration.js?time={{ time() }}"></script>
@endpush

@section('content')

<form id="registrationForm" action="{{ route('apply.registration.upsert', ['step'=>$step]) }}" method="post" onsubmit="return registrationCheck_0{{ $step }}(this);">
    {{ csrf_field() }}
    <input type="hidden" name="step" value="{{ $step }}"/>
    <input type="hidden" name="type" value="{{ $type }}"/>
    <input type="hidden" name="sid" value="{{ isset($apply) ? encrypt($apply->sid) : '' }}"/>
    <input type="hidden" name="pageMode" id="pageMode" value="regist"/>

    @if( $step == 1 && !isset($apply) )
    {!! Honeypot::generate('my_name', 'my_time') !!}
    @endif

    <fieldset>
        <legend class="hide">사전등록</legend>

        @if( $step == 1 )
        <div class="btn-wrap text-right mt-0">
            <a href="{{ route('registration.search') }}" class="btn btn-type1 color-type9">사전등록 확인 및 영수증</a>
        </div>
        
        <p class="noti-text text-center"><span>사전등록 안내를 꼭 숙지 후 진행하여 주시기 바랍니다.</span></p>
        <div class="term-wrap scroll-y">
            <div class="term-conbox">
                <div class="regi-date-wrap">
                    <img src="/assets/image/sub/img_regi_date.png" alt="">
                    <p>사전등록 마감일: <strong class="text-pink">{{ $period->Eedate->format('Y년 m월 d일') }}({{ config('site.common.dayOfWeek')[$period->Eedate->format('w')] }})</strong></p>
                </div>
                <ul class="list-type list-type-bar">
                    <li>홈페이지 사전등록 접수와 입금을 마감일까지 해 주시기 바랍니다.</li>
                    <li>홈페이지 등록접수 또는 입금만 한 경우 인정 되지 않습니다.</li>
                    <li>마감일 이후 등록접수 또는 입금한 경우 현장등록으로 처리되오니 유의하시기 바랍니다.</li>
                    <li class="text-red">현장등록 시 중식이 제공되지 않습니다.</li>
                    <li><strong>대한의사협회 연수평점 : 17일: 6점(필수평점 1점) / 18일: 5점 (필수평점1점)</strong></li>
                    <li>다시보기 운영 예정이며 다시보기는 사전등록자에 한하여 시청 가능합니다.</li>
                </ul>
                <br>
                <p class="tit"><strong>등록비</strong></p>
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
                <br>
                <p class="tit"><strong>등록비 결제방법</strong></p>
                <ul class="list-type list-type-bar">
                    <li>온라인 송금 또는 카드결제</li>
                    <li>신한은행 110-543-331734 김창선 대한응급의학회 재무이사</li>
                </ul>
                <br>
                <p class="tit"><strong>등록방법 및 확인</strong></p>
                <ul class="list-type list-type-bar">
                    <li>사전등록은 대한응급의학회 학술대회 홈페이지에서 편리하게 하실 수 있습니다.</li>
                    <li>사전등록 신청 결과는 입력된 이메일로 자동 발송 됩니다.</li>
                    <li>사전등록 확인은 학술대회 홈페이지 > 사전등록 > 사전등록 확인 및 영수증 > 에서 확인하시기 바랍니다.</li>
                    <li>등록비 입금 시 반드시 (본인 이름+소속명)으로 기재하시기 바랍니다.</li>
                    <li>입금 하신 후, 2-3일 내에 등록확인이 되지 않으면 학회로 연락주시기 바랍니다.</li>
                </ul>
                <br>
                <p class="tit"><strong>영수증 출력</strong></p>
                <ul class="list-type list-type-bar">
                    <li>사전등록 신청후 등록비 입금확인 되면 "사전등록 확인 및 영수증" 에서 "입금완료" 확인이 가능합니다.</li>
                    <li>영수증 출력은 사전등록 취소로 인한 오류가 많이 발생하여 사전등록 마감일 이후 출력가능하게 변경되었습니다.</li>
                    <li>마감일 이후 "사전등록 확인 및 영수증" 창에서 출력해 주시기 바랍니다.</li>
                </ul>
                <br>
                <p class="tit"><strong>사전등록 취소</strong></p>
                <ul class="list-type list-type-bar">
                    <li>사전등록 취소를 원하시는 경우 취소요청서를 작성하여 이메일 <a href="mailto:ksem_yj@emergency.or.kr">ksem_yj@emergency.or.kr</a> 혹은 팩스 02)3676-1339로 보내주시기 바랍니다.</li>
                    <li>사전등록 취소는 사전등록 마감일 2024년 10월 11일(금)까지만 가능하오니 양해 부탁드립니다.</li>
                    <li>등록비 반환은 학술대회가 있는 월 말에 환불처리 됩니다.</li>
                </ul>
                <br>
                <p class="tit"><strong>공지사항</strong></p>
                <ul class="list-type list-type-bar">
                    <li>사전등록 마감일 이후에는 현장등록만 가능합니다.</li>
                    <li>정년퇴임 하신 분들은 무료등록 입니다. (만 65세 이상)</li>
                    <li>대한의사협회 연수교육 지침에 따라 등록비를 납부하더라도 출석하지 않으면 평점을 부여하지 않습니다(*대리출석 불가)</li>
                    <li>학회장에서 명찰 인쇄 후 입실과 퇴실 시 반드시 출석확인 바코드에 접촉하여 주시기 바랍니다.</li>
                    <li>주차권은 현장에서 판매됩니다. (가급적 대중교통을 이용해 주시기 바랍니다.)</li>
                </ul>
            </div>
        </div>
        <div class="checkbox-wrap term-check text-center cst">
            <label class="checkbox-group"><input type="checkbox" id="agree">숙지하였습니다.</label>
        </div>  
        <div class="term-wrap bg-grey">
            <p><strong>* 개인정보의 수집 및 이용목적</strong><br>
                대한응급의학회는 2025년 대한응급의학회 춘계학술대회 사전등록을 온라인으로 하고 있습니다. 이때 제공해주신 개인정보를 바탕으로 회원님의 등록 접수가 가능합니다.</p>
            <p><strong>* 수집하는 개인정보의 항목</strong><br>
                대한응급의학회는 온라인 사전등록을 위해 개인정보를 요구하고 있습니다. 회원구분, 성명, 등록비, 소속, 핸드폰, 이메일을 필수입력 사항으로 수집하고 있습니다.</p>
        </div>
        <div class="checkbox-wrap term-check text-center cst">
            <label class="checkbox-group"><input type="checkbox" id="agree2">동의합니다.</label>
        </div>  
        @endif

        @include('registration.form.step0'.$step)

        @if( $step <= 2 )
        <div class="sub-tit-wrap">
            <h4 class="sub-tit">Preventing Automation Program Entry</h4>
        </div>
        <div class="write-wrap">
            <ul>
                <li>
                    <div class="form-con">
                        <div class="captcha">
                            <span class="img"><img id="captcha_img" src="{{ $captcha }}"></span>
                            <button type="button" onclick="refreshCaptcha(); return false;"><img src="/assets/image/sub/ic_refresh.png" class="refresh"></button>                                                
                            <input type="text" id="captcha" class="form-item">
                        </div>
                        <p class="help-text mt-10 text-blue">
                            * For information security, you can register as a member after entering the text written below.
                        </p>
                    </div>
                </li>
            </ul>
        </div>
        @endif

        <div class="btn-wrap text-center">
            @if( $step == 1 )
            <a href="{{ route('registration.guide') }}" class="btn btn-type1 color-type1">이전</a>
            @elseif( $step == 2)
            <a href="{{ route('apply.registration', ['step'=>'1', 'sid'=>encrypt($apply->sid)]) }}" class="btn btn-type1 color-type1">이전</a>
            @endif
            
            @if( $step <= 2 )
            <button type="submit" class="btn btn-type1 color-type2">다음</button>
            @else
            <a href="{{ route('main') }}" class="btn btn-type1 btn-round color-type5 btn-line">HOME <img src="/assets/image/sub/ic_btn_arrow_type5.png" alt="" class="right"></a>
            <a href="{{ route('registration.search') }}" class="btn btn-type1 btn-round color-type5">사전등록 수정 및 확인 <img src="/assets/image/sub/ic_btn_arrow_wh.png" alt="" class="right"></a>
            @endif
        </div>
    </fieldset>
</form>
@endsection