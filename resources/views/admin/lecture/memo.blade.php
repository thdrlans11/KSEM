@extends('include.layoutPopup')

@section('content')
<div class="write-form-wrap">
    <form id="registrationForm" action="{{ route('admin.registration.memo', ['sid'=>encrypt($apply->sid)]) }}" method="post">
        {{ csrf_field() }}
        <fieldset>
            <legend class="hide">Memo</legend>

            <div class="sub-tit-wrap">
                <h4 class="sub-tit">Registration Memo</h4>
            </div>
            <ul class="write-wrap">
                <li>
                    <div class="form-con">
                        <textarea class="form-item" style="height:400px" name="memo">{{ $apply->memo ?? '' }}</textarea>
                    </div>
                </li>
            </ul>    

            <div class="btn-wrap text-center">
                <a href="" class="btn btn-type1 color-type2 colorClose">Close</a>
                <button type="submit" class="btn btn-type1 color-type1">Save</button>
            </div>
        </fieldset>
    </form>
</div>
@endsection
