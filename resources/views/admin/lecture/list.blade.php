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

	if( db == 'lecture_periods' ){
		if( !$(f).prev().val() ){
            swalAlert('날짜를 입력해주세요.', '', 'warning');			
			return false;
		}else{
            value = $(f).prev().val();
        }
	}else if( db == 'lectures' && field == 'delete' ){
        value = $(f).data('status');
    }else{
        value = $(f).val();
    }

    $.ajax({
        type: 'POST',
        url: '{{ route('admin.lecture.dbChange') }}',
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

<div class="sub-tab-wrap">
    <ul class="sub-tab-menu cf">
        <li {!! !request()->query('del') ? 'class="on"' : '' !!}><a href="{{ route('admin.lecture.list', request()->except('del','page')) }}">All List</a></li>
        <li {!! request()->query('del') == 'Y' ? 'class="on"' : '' !!}><a href="{{ route('admin.lecture.list', ['del'=>'Y'] + request()->except('del','page')) }}">Cancel</a></li>
    </ul>
</div>

<form action="{{ route('admin.lecture.list') }}" method="get">
    <fieldset>
        <legend class="hide">검색</legend>
        {{-- <div class="table-wrap">
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
                            <th scope="row">Country</th>
                            <td class="text-left">
                                <select name="ccode" id="ccode" class="form-item">
                                    <option value="">==COUNTRY CHOICE==</option>
                                    @foreach( $country as $key => $val )
                                    <option value="{{ $key }}" {{ request()->query('ccode') == $key ? 'selected' : '' }}>{{ $val['cn'] }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <th scope="row">접수번호</th>
                            <td class="text-left">
                                <input type="text" name="rnum" id="rnum" value="{{ request()->query('rnum') }}" class="form-item">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">E-Mail</th>
                            <td class="text-left">
                                <input type="text" name="email" id="email" value="{{ request()->query('email') }}" class="form-item">
                            </td>
                            <th scope="row">등록자 이름</th>
                            <td class="text-left">
                                <input type="text" name="regName" id="regName" value="{{ request()->query('regName') }}" class="form-item">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Category</th>
                            <td class="text-left">
                                <select name="category" id="category" class="form-item">
                                    <option value="">All</option>
                                    @foreach( config('site.registration.category') as $key => $val )
                                    <option value="{{ $key }}" {{ request()->query('category') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <th scope="row">Attendance Type</th>
                            <td class="text-left">
                                <select name="attendType" id="attendType" class="form-item">
                                    <option value="">All</option>
                                    @foreach( config('site.registration.attendType') as $key => $val )
                                    <option value="{{ $key }}" {{ request()->query('attendType') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">결제방법</th>
                            <td class="text-left">
                                <select name="payMethod" id="payMethod" class="form-item">
                                    <option value="">All</option>
                                    @foreach( config('site.registration.payMethod') as $key => $val )
                                    <option value="{{ $key }}" {{ request()->query('payMethod') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <th scope="row">결제상태</th>
                            <td class="text-left">
                                <select name="payStatus" id="payStatus" class="form-item">
                                    <option value="">All</option>
                                    @foreach( config('site.registration.payStatus') as $key => $val )
                                    <option value="{{ $key }}" {{ request()->query('payStatus') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </caption>
            </table>
        </div> --}}
        
        <div class="table-wrap">
            <table class="cst-table">
                <caption class="hide">기간 등록</caption>
                <colgroup>
                    <col style="width: 20%;">
                    <col style="width: 30%;">
                    <col style="width: 20%;">
                    <col style="width: 30%;">
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">등록 시작 일시</th>
                        <td class="text-left">
                            <div class="form-group has-btn">
                                <input type="text" class="form-item dateTimeCalendar" readonly value="{{ $period['sdate'] ?? '' }}">
                                <span class="material-symbols-outlined" style="font-size:30px; cursor: pointer;" onclick="dbChange('{{ encrypt('1') }}', 'lecture_periods', 'sdate', this);">save_as</span>    
                            </div>
                        </td>
                        <th scope="row">등록 종료 일시</th>
                        <td class="text-left">
                            <div class="form-group has-btn">
                                <input type="text" class="form-item dateTimeCalendar" readonly value="{{ $period['edate'] ?? '' }}">
                                <span class="material-symbols-outlined" style="font-size:30px; cursor: pointer;" onclick="dbChange('{{ encrypt('1') }}', 'lecture_periods', 'edate', this);">save_as</span>    
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="btn-wrap text-center">
            <button type="submit" class="btn btn-type1 color-type4">검색</button>
            <button type="reset" class="btn btn-type1 color-type6" onclick="location.href='{{ route('admin.lecture.list') }}'">검색 초기화</button>
            <a href="{{ route('admin.lecture.excel', request()->except('page')) }}" class="btn btn-type1 color-type10" target="_blank">Get Excel File</a>
        </div>
    </fieldset>
</form>

<div class="list-contop text-right cf">
    <span class="cnt full-left">
        [총 <strong>{{ $lists->count() }}</strong>명]
    </span>
    <select name="" id="" class="form-item" onchange="location.href='/admin/lecture/?paginate='+$(this).val()">
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
            <col style="width: 2%;">
            <col style="width: 4%;">
            <col style="width: *">
            <col style="width: 6%;">
            
            <col style="width: 8%;">
            <col style="width: 6%;">
            <col style="width: 8%;">
            <col style="width: 6%;">
            <col style="width: 6%;">

            <col style="width: 8%;">
            <col style="width: 8%;">

            <col style="width: 6%;">
            <col style="width: 6%;">
            <col style="width: 6%;">
            <col style="width: 3%;">
            <col style="width: 5%;">
        </colgroup>
        <thead>
            <tr>
                {{-- <th scope="col">
                    <div class="checkbox-wrap cst">
                        <label for="chk2" class="checkbox-group"><input type="checkbox" name="chk2" id="chk2"></label>
                    </div>
                </th> --}}
                <th scope="col">No</th>
                <th scope="col">접수번호</th>
                <th scope="col">Email</th>
                <th scope="col">Name<br>(Kor)</th>
                <th scope="col">Country</th>
                <th scope="col">Category</th>
                <th scope="col">Attendance Type</th>
                <th scope="col">등록비</th>
                <th scope="col">접수시작일<br>(접수완료일)</th>
                <th scope="col">결제방법</th>
                <th scope="col">결제상태</th>
                <th scope="col">입금 예정일<br>(입금자)</th>
                <th scope="col">입금완료일</th>
                <th scope="col">Mail 재발송</th>
                <th scope="col">메모</th>
                <th scope="col">관리</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $lists as $index => $d )
            <tr>
                {{-- <td>
                    <div class="checkbox-wrap cst">
                        <label for="" class="checkbox-group"><input type="checkbox" name="" id=""></label>
                    </div>
                </td> --}}
                <td>{{ $d->seq }}</td>
                <td>
                    @if( $d->status == 'Y' )
                    <a href="{{ route('admin.registration.modifyForm', ['sid'=>encrypt($d->sid), 'step'=>'1']) }}" class="Load_Base_fix" Wsize="1500" Hsize="900" Tsize="2%" Reload="Y">{{ $d->rnum }}</a>
                    @else
                    {{ $d->rnum }}
                    @endif
                </td>
                <td>{{ $d->email }}</td>
                <td>{{ $d->firstName.' '.$d->lastName }} {!! $d->lang == 'KOR' ? '<br>'.'( '.$d->name.' )' : '' !!}</td>
                <td>{{ $d->country->cn }}</td>
                <td>
                    {{ $d->category ? config('site.registration.category')[$d->category] : '' }}
                    @if( $d->category == 'B' )
                    <a href="{{ route('download', ['type'=>'only', 'tbl'=>'registration', 'sid'=>encrypt($d->sid)]) }}" class="btn btn-small color-type8">다운로드</a>
                    @endif
                </td>
                <td>{{ $d->attendType ? config('site.registration.attendType')[$d->attendType] : '' }}</td>
                <td>{{ config('site.registration.unit')[$d->lang] }} {{ number_format($d->price) }}</td>
                <td>{{ $d->created_at->toDateString() }} {!! $d->complete_at ? '<br>'.'( '.$d->complete_at->toDateString().' )' : '' !!}</td>
                <td>
                    @if( $d->status == 'Y' )
                        @if( $d->payMethod )
                        <select onchange="dbChange('{{ encrypt($d->sid) }}', 'registration', 'payMethod', this);" class="form-item">  
                            @foreach( config('site.registration.payMethod') as $key => $val )
                            <option value="{{ $key }}" {{ $d->payMethod == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                        @endif
                    @else
                    {{ $d->payMethod ? config('site.registration.payMethod')[$d->payMethod] : '-' }}
                    @endif    
                </td>
                <td>
                    @if( $d->status == 'Y' )
                        @if( $d->payMethod )
                        <select onchange="dbChange('{{ encrypt($d->sid) }}', 'registration', 'payStatus', this);" class="form-item">  
                            @foreach( config('site.registration.payStatus') as $key => $val )
                            <option value="{{ $key }}" {{ $d->payStatus == $key ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                        @if( $d->payStatus == 'Y' )
                        <a href="{{ route('registration.receipt', ['sid'=>encrypt($d->sid)]) }}" class="btn btn-small color-type4" onclick="window.open(this.href,'receipt','width=800,height=852,scrollbars=yes'); return false;">Receipt</a>
                        @endif
                        @endif
                    @else
                    {{ $d->payMethod ? config('site.registration.payStatus')[$d->payStatus] : '-' }}
                    @endif    
                </td>
                <td>{!! $d->payMethod == 'B' ? $d->payDate.'<br>'.'( '.$d->payName.' )' : '-' !!}</td>
                <td>{{ $d->payComplete_at ? $d->payComplete_at->toDateString() : '-' }}</td>
                <td>
                    @if( $d->status == 'Y' )
                    <a href="{{ route('admin.registration.sendMailForm', ['sid'=>encrypt($d->sid)]) }}" class="btn btn-small color-type7 Load_Base_fix" Wsize="730" Hsize="900" Tsize="2%" Reload="N">메일발송</a>
                    @else
                    -
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.registration.memoForm', ['sid'=>encrypt($d->sid)]) }}" class="Load_Base_fix" Wsize="730" Hsize="900" Tsize="2%" Reload="Y">
                        <span class="material-symbols-outlined">
                            content_paste{{ !$d->memo ? '_off' : ''}}
                        </span>
                    </a>
                </td>
                <td>
                    @if( request()->query('del') == 'Y' )
                    <a href="#n" class="btn btn-small color-type4 btn-recovery" onclick="swalConfirm('복구 처리하시겠습니까?', '', function(){ dbChange('{{ encrypt($d->sid) }}','registration','delete',$('.btn-recovery')); })" data-status="N">복구</a>
                    @else
                        <a href="{{ route('admin.registration.modifyForm', ['sid'=>encrypt($d->sid), 'step'=>'1']) }}" class="btn-admin btn-modify Load_Base_fix" Wsize="1500" Hsize="900" Tsize="2%" Reload="Y"><img src="/devAdmin/assets/image/admin/ic_modify.png" alt="수정"></a>
                        <a href="#n" class="btn-admin btn-del" onclick="swalConfirm('삭제 처리하시겠습니까?', '', function(){ dbChange('{{ encrypt($d->sid) }}','registration','delete',$('.btn-del')); })" data-status="Y"><img src="/devAdmin/assets/image/admin/ic_del.png" alt="삭제"></a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $lists->links('paginate', ['list'=>$lists]) }}

</div>
@endsection   
