@extends('include.layoutPopup')

@push('scripts')
<script>
var idAddCheck = false;   
function checkMember(f){
	if( $(f.id).val() == "" ){
		swalAlert("아이디를 입력해주세요.","","warning","id");
		return false;
	}
    if( !idAddCheck ){
		swalAlert("아이디 중복검사를 진행해주세요.","","warning","id");
		return false;
	}
    if( $(f.name).val() == "" ){
		swalAlert("이름을 입력해주세요.","","warning","name");
		return false;
	}
    if( $(f.password).val() == "" ){
		swalAlert("비밀번호를 입력해주세요.","","warning","password");
		return false;
	}

}
function idCheck(target){

    var id = $("#id").val();

    if( !id ){
        swalAlert("아이디를 입력해주세요.","","warning","id");
		return false;
    }else{
        $.ajax({
            type: 'POST',
            url: '{{ route('admin.member.idCheck') }}',
            data: { id : id },
            async: false,
            success: function(data) {
                if( data == 'fail' ){
                    idAddCheck = false;
                    swalAlert('이미 사용중인 아이디입니다.', '', 'error');
                }else{
                    idAddCheck = true;
                    swalAlert('사용 가능한 아이디입니다.', '', 'success');
                    $("#id").attr("readonly", true);
                }
            }
        });
    }
}
</script>
@endpush

@section('content')
<div class="sub-conbox inner-layer">
    
    <div class="write-form-wrap">

        <div class="page-tit-wrap">
            <h3 class="page-tit">계정 {{ isset($user->sid) ? '수정' : '등록' }}</h3>
        </div>
        <form action="{{ route('admin.member.upsert', ['sid'=>!empty($user)?encrypt($user['sid']):'']) }}" method="post" onsubmit="return checkMember(this);">
            {{ csrf_field() }}
            <fieldset>
                <legend class="hide">계정 {{ isset($user->sid) ? '수정' : '등록' }}</legend>
                <div class="write-wrap">
                    <ul>
                        @if( isset($user) )
                        <li>
                            <div class="form-tit"><strong class="required">*</strong> 아이디</div>
                            <div class="form-con">{{ $user->id }}</div>
                        </li>
                        @else
                        <li>
                            <div class="form-tit"><strong class="required">*</strong> 아이디</div>
                            <div class="form-con">
                                <div class="form-group form-group-text has-btn">
                                    <input type="text" name="id" id="id" value="{{ $user->id ?? '' }}" class="form-item w-30p" placeholder="아이디">
                                    <a href="#n" class="btn btn-small color-type3" onclick="idCheck()">중복검사</a>
                                </div>
                            </div>
                        </li>
                        @endif

                        <li>
                            <div class="form-tit"><strong class="required">*</strong> 이름</div>
                            <div class="form-con">
                                <div class="form-group form-group-text">
                                    <input type="text" name="name" id="name" value="{{ $user->name ?? '' }}" class="form-item w-30p" placeholder="이름">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form-tit"><strong class="required">*</strong> 비밀번호</div>
                            <div class="form-con">
                                <div class="form-group form-group-text">
                                    <input type="password" name="password" id="password" class="form-item w-30p" placeholder="비밀번호">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form-tit"> 이메일</div>
                            <div class="form-con">
                                <div class="form-group form-group-text">
                                    <input type="text" name="email" id="email" value="{{ $user->email ?? '' }}" class="form-item w-50p" placeholder="이메일">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>    
                <div class="btn-wrap text-center">
                    <button type="submit" class="btn btn-type1 color-type2">{{ isset($user->sid) ? '수정' : '등록' }}</button>
                    <a href="#n" class="btn btn-type1 color-type1 colorClose">닫기</a>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@endsection