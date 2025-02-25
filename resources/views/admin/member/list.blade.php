@extends('admin.include.layout')

@push('css')
<link rel="stylesheet" href="/devCss/jquery-ui-timepicker-addon.css">
@endpush

@push('scripts')
<script src="/devScript/jquery-ui-timepicker-addon.js"></script>
<script>
$(document).ready(function(){
	$(".dateTimeCalendar").datetimepicker({
		dateFormat:'yy-mm-dd',
		monthNamesShort:[ '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월' ],
		dayNamesMin:[ '일', '월', '화', '수', '목', '금', '토' ],
		changeMonth:true,
		changeYear:true,
		showMonthAfterYear:true,
		timeFormat:'HH:mm:ss',
		controlType:'select',
		oneLine:true,
	});
});

function dbChange(sid,db,field,f){

    var value = '';

	if( db == 'users' && field == 'delete' ){
        value = $(f).data('status');
    }else{
        value = $(f).val();
    }

    $.ajax({
        type: 'POST',
        url: '{{ route('admin.member.dbChange') }}',
        data: { sid : sid, db : db, field : field, value : value },
        async: false,
        success: function(data) {
			if( data == 'error' ){
                swalAlert('시스템에러입니다.', '', 'error');
			}else{
				location.reload();
			}
        }
    });
}	
</script>
@endpush

@section('content')
<form action="{{ route('admin.member') }}" method="get">
    <fieldset>
        <legend class="hide">검색</legend>
        <div class="table-wrap">
            <table class="cst-table">
                <caption class="hide">
                    <colgroup>
                        <col style="width: 18%;">
                        <col style="width: 32%;">
                        <col style="width: 18%;">
                        <col style="width: 32%;">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th scope="row">이메일</th>
                            <td class="text-left">
                                <input type="text" name="email" id="email" value="{{ request()->query('email') }}" class="form-item">
                            </td>
                            <th scope="row">아이디</th>
                            <td class="text-left">
                                <input type="text" name="id" id="id" value="{{ request()->query('id') }}" class="form-item">
                            </td>
                        </tr>
                    </tbody>
                </caption>
            </table>
        </div>
        
        <div class="btn-wrap text-center">
            <button type="submit" class="btn btn-type1 color-type4">검색</button>
            <button type="reset" class="btn btn-type1 color-type6" onclick="location.href='{{ route('admin.member') }}'">검색 초기화</button>
        </div>
    </fieldset>
</form>

<div class="list-contop text-right cf">
    <span class="cnt full-left">
        [총 <strong>{{ $lists->count() }}</strong>명]
    </span>
    <a href="{{ route('admin.member.form') }}" class="btn btn-small color-type13 Load_Base_fix" Wsize="960" Hsize="600" Tsize="10%" Reload="Y">계정 추가</a>
    <select name="" id="" class="form-item" onchange="location.href='/admin/member/?paginate='+$(this).val()">
        <option value="20">20</option>
        <option value="30" {{ request()->query('paginate') == '30' ? 'selected' : '' }}>30</option>
        <option value="50" {{ request()->query('paginate') == '50' ? 'selected' : '' }}>50</option>
        <option value="100" {{ request()->query('paginate') == '100' ? 'selected' : '' }}>100</option>
    </select>
    개씩 보기
</div>
<div class="table-wrap">
    <table class="cst-table list-table">
        <caption class="hide">목록</caption>
        <colgroup>
            <col style="width: 3%;">
            <col style="width: 10%;">
            <col style="width: 10%;">
            <col style="width: *">
            
            <col style="width: 15%;">
            <col style="width: 15%;">
            <col style="width: 6%;">
        </colgroup>
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">아이디</th>
                <th scope="col">이름</th>
                <th scope="col">이메일</th>
                <th scope="col">등록일</th>
                <th scope="col">최종로그인</th>
                <th scope="col">관리</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $lists as $index => $d )
            <tr>
                <td>{{ $d->seq }}</td>                
                <td>{{ $d->id }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->email }}</td>
                <td>{{ $d->created_at }}</td>
                <td>{{ $d->login_at }}</td>
                <td>
                    <a href="{{ route('admin.member.form', ['sid'=>encrypt($d->sid)]) }}" class="btn-admin btn-modify Load_Base_fix" Wsize="960" Hsize="600" Tsize="10%" Reload="Y"><img src="/devAdmin/image/admin/ic_modify.png" alt="수정"></a>
                    <a href="#n" class="btn-admin btn-del" onclick="swalConfirm('삭제 처리하시겠습니까?', '', function(){ dbChange('{{ encrypt($d->sid) }}','users','delete',$('.btn-del')); })" data-status="Y"><img src="/devAdmin/image/admin/ic_del.png" alt="삭제"></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $lists->links('paginate', ['list'=>$lists]) }}

</div>
@endsection   
