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

	if( db == 'registration_periods' ){
		if( !$(f).prev().val() ){
            swalAlert('날짜를 입력해주세요.', '', 'warning');			
			return false;
		}else{
            value = $(f).prev().val();
        }
	}else if( db == 'registrations' && field == 'delete' ){
        value = $(f).data('status');
    }else{
        value = $(f).val();
    }

    $.ajax({
        type: 'POST',
        url: '{{ route('admin.registration.dbChange') }}',
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

@includeWhen($tabMode!='N', 'admin.registration.inc.avg')

<div class="sub-tab-wrap">
    <ul class="sub-tab-menu cf">
        <li {!! $tabMode == 'E' ? 'class="on"' : '' !!}><a href="{{ route('admin.registration.list', ['tabMode'=>'E']) }}">사전등록</a></li>
        <li {!! $tabMode == 'S' ? 'class="on"' : '' !!}><a href="{{ route('admin.registration.list', ['tabMode'=>'S']) }}">현장등록</a></li>
        <li {!! $tabMode == 'I' ? 'class="on"' : '' !!}><a href="{{ route('admin.registration.list', ['tabMode'=>'I']) }}">임의등록</a></li>
        <li {!! $tabMode == 'N' ? 'class="on"' : '' !!}><a href="{{ route('admin.registration.list', ['tabMode'=>'N']) }}">휴지통</a></li>
    </ul>
</div>

<form action="{{ route('admin.registration.list', ['tabMode'=>$tabMode]) }}" method="get">
    <fieldset>
        <legend class="hide">검색</legend>
        <div class="table-wrap">
            <table class="cst-table">
                <caption class="hide">
                    <colgroup>
                        <col style="width: 16.6%;">
                        <col style="width: 16.6%;">
                        <col style="width: 16.6%;">
                        <col style="width: 16.6%;">
                        <col style="width: 16.6%;">
                        <col style="width: 16.6%;">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th scope="row">이름</th>
                            <td class="text-left">
                                <input type="text" name="name" id="name" value="{{ request()->query('name') }}" class="form-item">
                            </td>
                            <th scope="row">이메일</th>
                            <td class="text-left">
                                <input type="text" name="email" id="email" value="{{ request()->query('email') }}" class="form-item">
                            </td>
                            <th scope="row">등록번호</th>
                            <td class="text-left">
                                <input type="text" name="rnum" id="rnum" value="{{ request()->query('rnum') }}" class="form-item">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">면허번호</th>
                            <td class="text-left">
                                <input type="text" name="license_number" id="license_number" value="{{ request()->query('license_number') }}" class="form-item">
                            </td>
                            <th scope="row">핸드폰번호</th>
                            <td class="text-left">
                                <input type="text" name="phone" id="phone" value="{{ request()->query('phone') }}" class="form-item">
                            </td>
                            <th scope="row">소속</th>
                            <td class="text-left">
                                <input type="text" name="office" id="office" value="{{ request()->query('office') }}" class="form-item">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">등록구분</th>
                            <td class="text-left">
                                <select name="category" id="category" class="form-item">
                                    <option value="">All</option>
                                    @foreach( config('site.registration.category') as $key => $val )
                                    <option value="{{ $key }}" {{ request()->query('category') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                    @endforeach
                                </select>
                            </td>
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
        </div>
        
        @if( $tabMode != 'N' )
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
                    @foreach( config('site.registration.cha') as $key => $val )
                    <tr>
                        <th scope="row">{{ $val }} 등록 시작 일시</th>
                        <td class="text-left">
                            <div class="form-group has-btn">
                                <input type="text" class="form-item dateTimeCalendar" readonly value="{{ $period[$key.'sdate'] ?? '' }}">
                                <span class="material-symbols-outlined" style="font-size:30px; cursor: pointer;" onclick="dbChange('{{ encrypt('1') }}', 'registration_periods', '{{ $key }}sdate', this);">save_as</span>    
                            </div>
                        </td>
                        <th scope="row">{{ $val }} 등록 종료 일시</th>
                        <td class="text-left">
                            <div class="form-group has-btn">
                                <input type="text" class="form-item dateTimeCalendar" readonly value="{{ $period[$key.'edate'] ?? '' }}">
                                <span class="material-symbols-outlined" style="font-size:30px; cursor: pointer;" onclick="dbChange('{{ encrypt('1') }}', 'registration_periods', '{{ $key }}edate', this);">save_as</span>    
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div class="btn-wrap text-center">
            <button type="submit" class="btn btn-type1 color-type4">검색</button>
            <button type="reset" class="btn btn-type1 color-type6" onclick="location.href='{{ route('admin.registration.list', ['tabMode'=>$tabMode]) }}'">검색 초기화</button>
            <a href="{{ route('admin.registration.excel', ['tabMode'=>$tabMode] + request()->except('page')) }}" class="btn btn-type1 color-type10" target="_blank">Get Excel File</a>
        </div>
    </fieldset>
</form>

<div class="list-contop text-right cf">
    <span class="cnt full-left">
        [총 <strong>{{ $lists->count() }}</strong>명]
    </span>
    <select name="" id="" class="form-item" onchange="location.href='/admin/registration/?paginate='+$(this).val()">
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
            <col style="width: 4%;">
            <col style="width: 7%">
            
            <col style="width: 6%;">
            <col style="width: *;">
            <col style="width: 10%;">
            <col style="width: 8%;">

            <col style="width: 6%;">
            <col style="width: 7%;">
            <col style="width: 7%;">

            <col style="width: 6%;">
            <col style="width: 6%;">
            <col style="width: 5%;">
            <col style="width: 3%;">
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
                <th scope="col">등록번호</th>
                <th scope="col">등록타입</th>
                <th scope="col">등록구분</th>
                <th scope="col">이름<br>(면허번호)</th>
                <th scope="col">소속</th>
                <th scope="col">이메일</th>
                <th scope="col">휴대폰번호</th>
                <th scope="col">금액</th>
                <th scope="col">결제방법</th>
                <th scope="col">결제상태</th>
                <th scope="col">입금완료일</th>
                <th scope="col">등록일<br>(접수완료일)</th>
                <th scope="col">Mail 재발송</th>
                <th scope="col">VIP</th>
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
                    <a href="{{ route('admin.registration.modifyForm', ['sid'=>encrypt($d->sid), 'step'=>'1']) }}" class="Load_Base_fix" Wsize="1500" Hsize="900" Tsize="2%" Reload="Y">{{ $d->rnum }}</a>
                </td>
                <td>{{ config('site.registration.type')[$d->type] }}</td>
                <td>{{ $d->category == 'Z' ? $d->category_etc : config('site.registration.category')[$d->category] }}</td>
                <td>{{ $d->name }} {!! $d->license_number ? '<br>('.$d->license_number.')' : '' !!}</td>
                
                <td>{{ $d->office }}</td>
                <td>{{ $d->email }}</td>
                <td>{{ $d->phone }}</td>              
                
                <td>{{ number_format($d->price) }}</td>
                <td>
                    @if( $d->payMethod )
                    <select onchange="dbChange('{{ encrypt($d->sid) }}', 'registrations', 'payMethod', this);" class="form-item">  
                        @foreach( config('site.registration.payMethod') as $key => $val )
                        <option value="{{ $key }}" {{ $d->payMethod == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    {!! $d->payMethod == 'B' ? '<div class="mt-10">'.$d->payDate.'<br>'.'( '.$d->payName.' )'.'</div>' : '' !!}
                    @endif
                </td>
                <td>
                    @if( $d->payMethod )
                    <select onchange="dbChange('{{ encrypt($d->sid) }}', 'registrations', 'payStatus', this);" class="form-item">  
                        @foreach( config('site.registration.payStatus') as $key => $val )
                        <option value="{{ $key }}" {{ $d->payStatus == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    @if( $d->payStatus == 'Y' )
                    {{-- <a href="{{ route('registration.receipt', ['sid'=>encrypt($d->sid)]) }}" class="btn btn-small color-type4" onclick="window.open(this.href,'receipt','width=800,height=852,scrollbars=yes'); return false;">Receipt</a> --}}
                    @endif
                    @endif
                </td>
                <td>{{ $d->payComplete_at && $d->payMethod != 'F' ? $d->payComplete_at->toDateString() : '-' }}</td>
                <td>{{ $d->created_at->toDateString() }} {!! $d->complete_at ? '<br>'.'( '.$d->complete_at->toDateString().' )' : '' !!}</td>
                
                <td>
                    @if( $d->status == 'Y' )
                    <a href="{{ route('admin.registration.sendMailForm', ['sid'=>encrypt($d->sid)]) }}" class="btn btn-small color-type7 Load_Base_fix" Wsize="730" Hsize="900" Tsize="2%" Reload="N">발송</a>
                    @else
                    -
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.registration.vipForm', ['sid'=>encrypt($d->sid)]) }}" class="Load_Base_fix {{ $d->vip ? 'text-red' : '' }}" Wsize="800" Hsize="400" Tsize="15%" Reload="Y">
                        <span class="material-symbols-outlined">
                            {{ $d->vip ? 'stars' : 'cancel' }}
                        </span>
                    </a>
                </td>
                <td>
                    <a href="{{ route('admin.registration.memoForm', ['sid'=>encrypt($d->sid)]) }}" class="Load_Base_fix" Wsize="730" Hsize="900" Tsize="2%" Reload="Y">
                        <span class="material-symbols-outlined">
                            content_paste{{ !$d->memo ? '_off' : ''}}
                        </span>
                    </a>
                </td>
                <td>
                    @if( $tabMode == 'N' )
                    <a href="#n" class="btn btn-small color-type4 btn-recovery" onclick="swalConfirm('복구 처리하시겠습니까?', '', function(){ dbChange('{{ encrypt($d->sid) }}','registrations','delete',$('.btn-recovery')); })" data-status="N">복구</a>
                    @else
                        <a href="{{ route('admin.registration.modifyForm', ['sid'=>encrypt($d->sid), 'step'=>'1']) }}" class="btn-admin btn-modify Load_Base_fix" Wsize="1200" Hsize="900" Tsize="2%" Reload="Y"><img src="/devAdmin/image/admin/ic_modify.png" alt="수정"></a>
                        <a href="#n" class="btn-admin btn-del" onclick="swalConfirm('삭제 처리하시겠습니까?', '', function(){ dbChange('{{ encrypt($d->sid) }}','registrations','delete',$('.btn-del')); })" data-status="Y"><img src="/devAdmin/image/admin/ic_del.png" alt="삭제"></a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $lists->links('paginate', ['list'=>$lists]) }}

</div>
@endsection   
