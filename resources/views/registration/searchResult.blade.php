@extends('include.layout')

@section('content')

@include('registration.form.preview')

<div class="btn-wrap text-center">
    @if( $apply->payStatus == 'N' && $modifyYn )
    <a href="{{ route('apply.registration', ['step'=>'1', 'sid'=>encrypt($apply->sid)]) }}" class="btn btn-type1 color-type3">수정</a>
    @endif
    @if( $apply->payStatus == 'Y' && !$modifyYn )
    <a href="#n" onclick="swalAlert('준비중입니다', '', 'info')"  class="btn btn-type1 color-type4">영수증 출력</a>
    @endif
</div>
@endsection