@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#office').select2({
        tags: true
    }); 

    @isset($apply)
    makeLocalSub('{{ $apply->local_sub }}')

    //select에 없는 항목 추가
    var data = {
        id: '{{ $apply->office }}',
        text: '{{ $apply->office }}'
    };

    if ($('#office').find("option[value='" + data.id + "']").length) {
        $('#office').val(data.id).trigger('change');
    } else { 
        var newOption = new Option(data.text, data.id, true, true);
        $('#office').append(newOption).trigger('change');
    } 
    @endisset
});    
</script>
@endpush

<div class="sub-tit-wrap">
    <h4 class="sub-tit">등록자 정보</h4>
</div>
<div class="write-wrap">
    <ul>
        <li>
            <div class="form-tit">참석일 <strong class="required">*</strong></div>
            <div class="form-con">
                <div class="radio-wrap cst">
                    @foreach( config('site.registration.attendType') as $key => $val )
                    <label class="radio-group">
                        <input type="radio" name="attendType" id="attendType{{ $key }}" value="{{ $key }}" {{ ( $apply->attendType ?? '' ) == $key ? 'checked' : '' }} onclick="makePrice()">{{ $val }}
                    </label>
                    @endforeach
                </div>
            </div>
        </li>
        <li>
            <div class="form-tit">회원구분 <strong class="required">*</strong></div>
            <div class="form-con">
                <div class="radio-wrap cst">
                    @foreach( config('site.registration.category') as $key => $val )
                    <label class="radio-group">
                        <input type="radio" name="category" id="category{{ $key }}" value="{{ $key }}" {{ ( $apply->category ?? '' ) == $key ? 'checked' : '' }} {!! in_array( $key, config('site.registration.categoryAction') ) ? 'data-action="Y"' : 'N' !!} onclick="makePrice()">{{ $val }}
                        @if( $key == 'Z' )
                        <input type="text" name="category_etc" id="category_etc" value="{{ $apply->category_etc ?? '' }}" {{ ( $apply->category ?? '' ) != 'Z' ? 'readonly' : '' }} class="form-item">
                        @endif
                    </label>
                    @endforeach
                </div>
            </div>
        </li>
        <li>
            <div class="form-tit">성명 <strong class="required">*</strong></div>
            <div class="form-con">
                <input type="text" name="name" id="name" value="{{ $apply->name ?? '' }}" class="form-item">
            </div>
        </li>
        <li class="actionBox" {!! !in_array( ( $apply->category ?? '' ), config('site.registration.categoryAction') ) ? 'style="display:none"' : '' !!}>
            <div class="form-tit">면허번호 <strong class="required">*</strong></div>
            <div class="form-con">
                <input type="text" name="license_number" id="license_number" value="{{ $apply->license_number ?? '' }}" class="form-item">
            </div>
        </li>
        <li class="actionBox" {!! !in_array( ( $apply->category ?? '' ), config('site.registration.categoryAction') ) ? 'style="display:none"' : '' !!}>
            <div class="form-tit">전공과목 <strong class="required">*</strong></div>
            <div class="form-con">
                <input type="text" name="major" id="major" value="{{ $apply->major ?? '' }}" class="form-item">
            </div>
        </li>
        <li>
            <div class="form-tit">생년월일 <strong class="required">*</strong></div>
            <div class="form-con">
                <input type="text" name="birth" id="birth" value="{{ $apply->birth ?? '' }}" class="form-item dateCalendar" readonly>
            </div>
        </li>
        <li>
            <div class="form-tit">성별 <strong class="required">*</strong></div>
            <div class="form-con">
                <div class="radio-wrap cst">
                    @foreach( config('site.registration.sex') as $key => $val )
                    <label class="radio-group">
                        <input type="radio" name="sex" id="sex{{ $key }}" value="{{ $key }}" {{ ( $apply->sex ?? '' ) == $key ? 'checked' : '' }}>{{ $val }}
                    </label>
                    @endforeach
                </div>
            </div>
        </li>
        <li>
            <div class="form-tit">소속 (병원) <strong class="required">*</strong></div>
            <div class="form-con">
                <div class="form-group">
                    <select class="form-item" name="office" id="office">
                        <option value="">선택</option>
                        @foreach( $hospitals as $hospital )
                        <option value="{{ $hospital->hospital }}" {{ ( $apply->office ?? '' ) == $hospital->hospital ? 'selected' : '' }}>{{ $hospital->hospital }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="help-text mt-10">* 병원명이 검색되지 않으시는 경우 엔터를 눌러 등록하시면 됩니다.</p>
            </div>
        </li>
        @if( isset($apply) )
        <li>
            <div class="form-tit">휴대폰번호 <strong class="required">*</strong></div>
            <div class="form-con">{{ $apply->phone ?? '' }}</div>
        </li>
        <li>
            <div class="form-tit">이메일 <strong class="required">*</strong></div>
            <div class="form-con">{{ $apply->email ?? '' }}</div>
        </li>
        @else
        <li>
            <div class="form-tit">휴대폰번호 <strong class="required">*</strong></div>
            <div class="form-con">
                <div class="form-group has-btn">
                    <input type="text" name="phone" id="phone" value="{{ $apply->phone ?? '' }}" class="form-item numOnly phoneHyphen">
                    <a href="#n" onclick="phoneCheck();" class="btn btn-small color-type3">중복 확인</a>
                </div>
            </div>
        </li>
        <li>
            <div class="form-tit">이메일 <strong class="required">*</strong></div>
            <div class="form-con">
                <div class="form-group has-btn">
                    <input type="text" name="email" id="email" value="{{ $apply->email ?? '' }}" class="form-item emailOnly">
                    <a href="#n" onclick="emailCheck();" class="btn btn-small color-type3">중복 확인</a>
                </div>    
            </div>
        </li>
        @endif
        <li>
            <div class="form-tit">지역 <strong class="required">*</strong></div>
            <div class="form-con">
                <div class="form-group n2">
                    <select class="form-item" name="local" id="local" onchange="makeLocalSub()">
                        <option value="">선택</option>
                        @foreach( config('site.registration.local') as $key => $val )
                        <option value="{{ $key }}" {{ ( $apply->local ?? '' ) == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    <select class="form-item" name="local_sub" id="local_sub">
                        <option value="">선택</option>
                    </select>
                </div>
            </div>
        </li>
        <li>
            <div class="form-tit">첫 방문입니까? <strong class="required">*</strong></div>
            <div class="form-con">
                <div class="radio-wrap cst">
                    @foreach( config('site.registration.answer') as $key => $val )
                    <label class="radio-group">
                        <input type="radio" name="firstVisit" id="firstVisit{{ $key }}" value="{{ $key }}" {{ ( $apply->firstVisit ?? '' ) == $key ? 'checked' : '' }}>{{ $val }}
                    </label>
                    @endforeach
                </div>
            </div>
        </li>
        <li>
            <div class="form-tit">금액 <strong class="required">*</strong></div>
            <div class="form-con"><strong class="text-red totalPriceSpan">{{ isset($apply->price) ? ( $apply->price > 0 ? number_format($apply->price).'원' : '무료' ) : '0원'}}</strong></div>
            <input type="hidden" name="price" id="price" value="{{ $apply->price ?? '' }}" readonly/>
        </li>
    </ul>
</div>