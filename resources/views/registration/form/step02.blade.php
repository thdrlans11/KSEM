<div class="sub-tit-wrap mt-0">
    <h4 class="sub-tit">등록 정보 확인</h4>
</div>
<div class="table-wrap">
    <table class="cst-table">
        <caption class="hide">등록 정보 확인</caption>
        <colgroup>
            <col style="width: 20%;">
            <col>
        </colgroup>
        <tbody>
            <tr>
                <th>등록정보</th>
                <td>                    
                    구분 : {{ $apply->category == 'Z' ? $apply->category_etc : config('site.registration.category')[$apply->category] }} @if( in_array( $apply->category, config('site.registration.categoryAction')) ) ( 면허번호 : 123456, 전공과목 : 전공과목 ) @endif<br>
                    이름 : {{ $apply->name }}, 핸드폰번호 : {{ $apply->phone }}, 이메일 : {{ $apply->email }}<br>
                    금액 : {{ $apply->price > 0 ? number_format($apply->price).'원' : '무료' }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="sub-tit-wrap">
    <h4 class="sub-tit">입금정보 확인</h4>
</div>
<div class="write-wrap">
    <ul>
        <li>
            <div class="form-tit">총액</div>
            <div class="form-con"><strong class="text-red">{{ $apply->price > 0 ? number_format($apply->price).'원' : '무료' }}</strong></div>
        </li>
        
        @if( $apply->price > 0 )
        <li>
            <div class="form-tit">결제구분 <strong class="required">*</strong></div>
            <div class="form-con">
                <div class="radio-wrap cst">
                    @foreach( config('site.registration.payMethod') as $key => $val ) @if( ( $type == 'E' && ( $key == 'F' || $key == 'S' ) ) ) @continue @endif
                    <label class="radio-group">
                        <input type="radio" name="payMethod" id="payMethod{{ $key }}" value="{{ $key }}" {{ ( $apply->payMethod ?? '' ) == $key ? 'checked' : '' }}>{{ $val }}
                    </label>
                    @endforeach
                    <input type="hidden" id="price" value="{{ $apply->price }}"/>
                    <input type="hidden" id="user_id" value="{{ $apply->email }}"/>
                    <input type="hidden" id="user_name" value="{{ $apply->name }}"/>
                </div>
            </div>
        </li>
        <li class="Bbox" {!! ( $apply->payMethod ?? '' ) != 'B' ? 'style="display:none"' : '' !!}>
            <div class="form-tit">입금자명 <strong class="required">*</strong></div>
            <div class="form-con">
                <input type="text" name="payName" id="payName" value="{{ $apply->payName }}" class="form-item">
                <p class="help-text mt-10">* 입금하실 때, 이름/소속 혹은 이름만 입력하여 주시기 바립니다.. 예: 홍길동서울대병원, 홍길동등</p>
            </div>
        </li>
        <li class="Bbox" {!! ( $apply->payMethod ?? '' ) != 'B' ? 'style="display:none"' : '' !!}>
            <div class="form-tit">입금일 <strong class="required">*</strong></div>
            <div class="form-con">
                <input type="text" name="payDate" id="payDate" value="{{ $apply->payDate }}" class="form-item dateCalendar" readonly>
            </div>
        </li>
        <li class="Bbox" {!! ( $apply->payMethod ?? '' ) != 'B' ? 'style="display:none"' : '' !!}>
            <div class="form-tit">입금 계좌번호 <strong class="required">*</strong></div>
            <div class="form-con">신한은행 110-543-331734 김창선 대한응급의학회 재무이사</div>
        </li>
        <li class="Bbox" {!! ( $apply->payMethod ?? '' ) != 'B' ? 'style="display:none"' : '' !!}>
            <div class="form-tit">환불계좌 <strong class="required">*</strong></div>
            <div class="form-con">
                <input type="text" name="refundAccount" id="refundAccount" value="{{ $apply->refundAccount ?? '' }}" class="form-item">
            </div>
        </li>
        <li class="Bbox" {!! ( $apply->payMethod ?? '' ) != 'B' ? 'style="display:none"' : '' !!}>
            <div class="form-tit">환불은행 <strong class="required">*</strong></div>
            <div class="form-con">
                <input type="text" name="refundBank" id="refundBank" value="{{ $apply->refundBank ?? '' }}" class="form-item">
            </div>
        </li>
        <li class="Bbox" {!! ( $apply->payMethod ?? '' ) != 'B' ? 'style="display:none"' : '' !!}>
            <div class="form-tit">환불계좌 예금주 <strong class="required">*</strong></div>
            <div class="form-con">
                <input type="text" name="refundHolder" id="refundHolder" value="{{ $apply->refundHolder ?? '' }}" class="form-item">
            </div>
        </li>
        @else
        <input type="hidden" name="payMethod" value="F"/>
        @endif
    </ul>
</div>