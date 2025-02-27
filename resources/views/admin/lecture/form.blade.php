@extends('include.layoutPopup')

@push('scripts')
<script type="text/javascript" src="/devScript/lecture.js?time={{ time() }}"></script>
@endpush

@section('content')
<div class="sub-conbox inner-layer">
    
    <div class="write-form-wrap">
        <form id="lectureForm" action="{{ route('admin.lecture.modify', ['sid'=>encrypt($apply->sid)]) }}" method="post" enctype="multipart/form-data" onsubmit="return lectureCheck(this);">
            {{ csrf_field() }}
            <input type="hidden" name="sid" value="{{ encrypt($apply->sid) }}"/>
            <input type="hidden" name="saveMode" id="saveMode" value=""/>
            <input type="hidden" name="pageMode" id="pageMode" value="admin"/>
            <fieldset>
                <legend class="hide">강의원고 접수</legend>

                @include('lecture.form.upsert')

                <div class="sub-tit-wrap">
                    <h4 class="sub-tit">
                        Preventing Automation Program Entry
                    </h4>
                </div>
                <ul class="write-wrap">
                    <li>
                        <div class="form-con">
                            <div class="captcha">
                                <span class="img"><img id="captcha_img" src="{{ $captcha }}"></span>
                                <button type="button" onclick="refreshCaptcha();return false;"><img src="/assets/image/sub/ic_refresh.png" class="refresh"></button>                                                
                                <input type="text" id="captcha" class="form-item">
                            </div>
                            <p class="help-text mt-10 text-blue">
                                * For information security, you can register as a member after entering the text written below.
                            </p>
                        </div>
                    </li>
                </ul>

                <div class="btn-wrap text-center">
                    <a href="" class="btn btn-type1 color-type1 colorClose">Close</a>
                    <button type="submit" class="btn btn-type1 color-type2">Modify</button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@endsection
