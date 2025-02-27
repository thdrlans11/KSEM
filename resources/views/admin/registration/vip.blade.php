@extends('include.layoutPopup')

@push('scripts')
<script>
$(document).ready(function(){
    $('.resetBtn').click(function(){
        $("input:radio[name='vip']").attr("checked", false);
    });
});
</script>
@endpush

@section('content')
<div class="sub-conbox inner-layer">
    
    <div class="write-form-wrap">

        <div class="page-tit-wrap">
            <h3 class="page-tit">VIP</h3>
        </div>
        <form action="{{ route('admin.registration.vip', ['sid'=>encrypt($apply->sid)]) }}" method="post">
            {{ csrf_field() }}
            <fieldset>
                <legend class="hide">VIP</legend>
                <div class="write-wrap">
                    <ul>
                        <li>
                            <div class="form-tit"><strong class="required">*</strong> 구분</div>
                            <div class="form-con">
                                <div class="radio-wrap cst">
                                    @foreach( config('site.registration.vip') as $key => $val )
                                    <label class="radio-group">
                                        <input type="radio" name="vip" id="vip{{ $key }}" value="{{ $key }}" {{ ( $apply->vip ?? '' ) == $key ? 'checked' : '' }}>{{ $val }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>    
                <div class="btn-wrap text-center">
                    <button type="submit" class="btn btn-type1 color-type2">저장</button>
                    <a href="#n" class="btn btn-type1 color-type1 colorClose">닫기</a>
                    <a href="#n" class="btn btn-type1 color-type4 resetBtn">초기화</a>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@endsection