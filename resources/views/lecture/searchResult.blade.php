@extends('include.layout')

@section('content')

@include('lecture.form.preview')

<div class="btn-wrap text-center">
    @if( $modifyYn )
    <a href="{{ route('apply.lecture', ['sid'=>encrypt($apply->sid)]) }}" class="btn btn-type1 color-type3">수정</a>
    @endif
    <a href="{{ route('lecture.search') }}"  class="btn btn-type1 color-type4">취소</a>
</div>
@endsection