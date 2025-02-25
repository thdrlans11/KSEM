@extends('include.layout')

@push('scripts')
<script type="text/javascript" src="/devScript/registration.js?time={{ time() }}"></script>
@endpush

@section('content')
<div class="border-box bg-grey">
    <p>사전등록 안내를 꼭 숙지 후 진행하여 주시기 바랍니다. 사전등록 안내는 우측 내용보기 버튼을 누르시면 확인 가능합니다.<br>
        <span class="text-red">* 마감일 이후 &quot;사전등록 확인 및 영수증&quot; 창에서 출력해 주시기 바랍니다.</span>
    </p>
    <a href="{{ route('registration.guide') }}" class="btn btn-small color-type6">내용보기</a>
</div>

<div class="confirm-wrap">
    <div class="tit-wrap">
        <img src="/assets/image/sub/ic_confirm.png" alt="">
        <h5 class="tit"><span>사전등록시 입력한 성명과 이메일 혹은 휴대폰번호를 입력해주세요</span></h5>
    </div>
    <form action="{{ route('registration.searchResult') }}" method="post" onsubmit="return registrationSearchCheck(this)">
        {{ csrf_field() }}
        <input type="hidden" name="searchCondition" id="searchCondition" value="P"/>
        <fieldset>
            <legend class="hide">사전등록 확인</legend>
            
            <div class="sub-tab-wrap type2">
                <ul class="sub-tab-menu js-tab-menu">
                    <li class="on"><a href="#n" class="searchConditionLi" data-condition="P"><span>휴대폰번호</span></a></li>
                    <li><a href="#n" class="searchConditionLi" data-condition="E"><span>이메일</span></a></li>
                </ul>
            </div>
            <div class="sub-tab-con js-tab-con" style="display: block;">
                <div class="input-box">
                    <input type="text" name="Pname" id="Pname" class="form-item" placeholder="성명">
                    <input type="text" name="Pphone" id="Pphone" class="form-item numOnly phoneHyphen" placeholder="휴대폰번호">
                </div>
            </div>
            <div class="sub-tab-con js-tab-con" style="display: none;">
                <div class="input-box">
                    <input type="text" name="Ename" id="Ename" class="form-item" placeholder="성명">
                    <input type="text" name="Eemail" id="Eemail" class="form-item emailOnly" placeholder="이메일">
                </div>
            </div>
            <div class="btn-wrap mt-0">
                <button type="submit" class="btn btn-type1 color-gra"><img src="/assets/image/sub/ic_login.png" alt="">조회</button>
            </div>
        </fieldset>
    </form>
</div>
@endsection