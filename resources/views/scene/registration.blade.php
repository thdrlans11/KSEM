@extends('include.layout')

@push('scripts')
<script type="text/javascript" src="/devScript/registration.js?time={{ time() }}"></script>
@endpush

@section('content')
<form id="registrationForm" action="{{ route('apply.scene.registration.upsert') }}" method="post" onsubmit="return registrationCheck_01(this);">
    {{ csrf_field() }}
    <input type="hidden" name="type" value="{{ $type }}"/>
    <input type="hidden" name="sid" value="{{ isset($apply) ? encrypt($apply->sid) : '' }}"/>
    <input type="hidden" name="pageMode" id="pageMode" value="scene"/>
    
    {!! Honeypot::generate('my_name', 'my_time') !!}

    <fieldset>
        <legend class="hide">현장등록 정보입력</legend>  

        @include('registration.form.step01')

        <div class="noti-text bg-grey text-center"><span>현장등록은 현금결제만 가능합니다.</span></div>

        <div class="btn-wrap text-center">
            <button type="submit" class="btn btn-type1 color-type2">완료</button>
        </div>
    </fieldset>
</form>
@endsection