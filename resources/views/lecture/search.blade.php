@extends('include.layout')

@push('scripts')
<script type="text/javascript" src="/devScript/lecture.js?time={{ time() }}"></script>
@endpush
            
@section('content')
<div class="confirm-wrap">
    <div class="tit-wrap">
        <img src="/assets/image/sub/ic_confirm.png" alt="">
        <h5 class="tit"><span>강의원고 등록시 입력한 성명과 이메일을 입력해주세요</span></h5>
    </div>
    <form action="{{ route('lecture.searchResult') }}" method="post" onsubmit="return lectureSearchCheck(this)">
        {{ csrf_field() }}
        <fieldset>
            <legend class="hide">강의원고 확인</legend>
            <div class="input-box">
                <input type="text" name="name" id="name" class="form-item" placeholder="성명">
                <input type="text" name="email" id="email" class="form-item" placeholder="이메일">
                <input type="password" name="password" id="password" class="form-item" placeholder="비밀번호">
            </div>
            <div class="btn-wrap mt-0">
                <button type="submit" class="btn btn-type1 color-gra"><img src="/assets/image/sub/ic_login.png" alt="">조회</button>
            </div>
        </fieldset>
    </form>
</div>
@endsection