@extends('include.layoutPopup')

@push('scripts')

@if( $rgubun == 'KOR' )
<script type="text/javascript" src="/devScript/registration{{ $rgubun }}.js?time={{ time() }}"></script>
@else
<script type="text/javascript" src="/devScript/registration.js?time={{ time() }}"></script>
@endif

@endpush

@section('content')
<div class="sub-conbox inner-layer">
    
    @include('registration.form'.$rgubun.'.tab')

    <div class="write-form-wrap">
        <form id="registrationForm" action="{{ route('admin.registration.modify', ['sid'=>encrypt($apply->sid), 'step'=>$step]) }}" method="post" enctype="multipart/form-data" onsubmit="return registrationCheck_0{{ $step }}(this);">
            {{ csrf_field() }}
            <input type="hidden" name="step" value="{{ $step }}"/>
            <input type="hidden" name="type" value="{{ $type }}"/>
            <input type="hidden" name="sid" value="{{ encrypt($apply->sid) }}"/>
            <input type="hidden" name="saveMode" id="saveMode" value=""/>
            <fieldset>
                <legend class="hide">Go to Register</legend>

                @include('registration.form'.$rgubun.'.step0'.$step)

                @if( $step != 4 )
                <div class="sub-tit-wrap">
                    <h4 class="sub-tit">
                        @if( $rgubun == 'KOR' )
                        자동화 프로그램 입력 방지
                        @else
                        Preventing Automation Program Entry
                        @endif
                        
                    </h4>
                </div>
                <ul class="write-wrap">
                    <li>
                        <div class="form-con">
                            <div class="captcha">
                                <span class="img"><img id="captcha_img" src="{{ $captcha }}"></span>
                                <button type="button" onclick="refreshCaptcha();return false;"><img src="/assets/image/icon/ic_refresh.png" class="refresh"></button>                                                
                                <input type="text" id="captcha" class="form-item">
                            </div>
                            <p class="help-text mt-10 text-blue">
                                @if( $rgubun == 'KOR' )
                                * 정보 보안을 위해 아래에 작성된 텍스트를 입력한 후 회원으로 등록할 수 있습니다.
                                @else
                                * For information security, you can register as a member after entering the text written below.
                                @endif
                            </p>
                        </div>
                    </li>
                </ul>
                @endif

                <div class="btn-wrap text-center">
                    <a href="" class="btn btn-type1 color-type2 colorClose">Close</a>

                    @if( $step != 4 )
                    <a href="#n" class="btn btn-type1 color-type1 saveImsi">Modify</a>
                    
                    @endif

                    @if( $step > 1 )
                    <a href="{{ route('admin.registration.modifyForm', ['sid'=>encrypt($apply->sid), 'step'=>$step-1]) }}" class="btn btn-type1 btn-line color-type2">Previous</a>
                    @endif

                    @if( $step < 4 )
                    <a href="{{ route('admin.registration.modifyForm', ['sid'=>encrypt($apply->sid), 'step'=>$step+1]) }}" class="btn btn-type1 btn-line color-type4">Next</a>
                    @endif
                </div>
            </fieldset>
        </form>
    </div>
</div>
@endsection
