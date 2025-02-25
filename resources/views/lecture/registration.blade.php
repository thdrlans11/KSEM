@extends('include.layout')

@push('scripts')
<script type="text/javascript" src="/devScript/lecture.js?time={{ time() }}"></script>
@endpush

@section('content')
<form id="lectureForm" action="{{ route('apply.lecture.upsert') }}" method="post" enctype="multipart/form-data" onsubmit="return lectureCheck(this);">
    {{ csrf_field() }}
    <input type="hidden" name="sid" value="{{ isset($apply) ? encrypt($apply->sid) : '' }}"/>
    <input type="hidden" name="saveMode" id="saveMode" value=""/>
    <input type="hidden" name="pageMode" id="pageMode" value="regist"/>

    @if(!isset($apply) )
    {!! Honeypot::generate('my_name', 'my_time') !!}
    @endif
    
    <fieldset>
        <legend class="hide">강의원고 접수</legend>

        @include('lecture.form.upsert')

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

        <div class="btn-wrap text-center">
            <a href="{{ route('lecture.search') }}" class="btn btn-type1 color-type1">취소</a>
            <button type="submit" class="btn btn-type1 color-type2">다음</button>
        </div>
    </fieldset>
</form>
@endsection