@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#office').select2({
        tags: true
    }); 

    @isset($apply)
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

<div class="sub-tit-wrap mt-0">
    <h4 class="sub-tit">접수정보</h4>
    @if( checkUrl() != 'admin' )
    <div class="btn-wrap text-right mt-0">
        <a href="{{ route('lecture.search') }}" class="btn btn-type1 color-type9">강의원고 수정 및 확인</a>
    </div>
    @endif
</div>
<div class="write-wrap">
    <ul>
        <li>
            <div class="form-tit">성명 <strong class="required">*</strong></div>
            <div class="form-con">
                <input type="text" name="name" id="name" value="{{ $apply->name ?? '' }}" class="form-item">
            </div>
        </li>
        @if( isset($apply) )
        <li>
            <div class="form-tit">이메일 <strong class="required">*</strong></div>
            <div class="form-con">{{ $apply->email }}</div>
        </li>
        @else
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
            <div class="form-tit">소속 (병원) <strong class="required">*</strong></div>
            <div class="form-con">
                <select class="form-item" name="office" id="office">
                    <option value="">선택</option>
                    @foreach( $hospitals as $hospital )
                    <option value="{{ $hospital->hospital }}" {{ ( $apply->office ?? '' ) == $hospital->hospital ? 'selected' : '' }}>{{ $hospital->hospital }}</option>
                    @endforeach
                </select>
            </div>
        </li>
        <li>
            <div class="form-tit">휴대폰번호 <strong class="required">*</strong></div>
            <div class="form-con">
                <input type="text" name="phone" id="phone" value="{{ $apply->phone ?? '' }}" class="form-item numOnly phoneHyphen">
            </div>
        </li>
        <li>
            <div class="form-tit">전화번호</div>
            <div class="form-con">
                <input type="text" name="tel" id="tel" value="{{ $apply->tel ?? '' }}" class="form-item numOnly">
            </div>
        </li>
        <li>
            <div class="form-tit">강의원고 파일 <strong class="required">*</strong></div>
            <div class="form-con">
                <div class="filebox">
                    <input class="upload-name form-item" id="filenameText" placeholder="File Upload" readonly="readonly">
                    <label for="userfile">파일선택</label>
                    <input type="file" id="userfile" name="userfile" class="file-upload" onclick="return file_check('{{ $apply['filename'] ?? '' }}','delfile')">
                    @if( isset($apply->realfile) )
                    <div class="attach-file">
                        <a href="{{ route('download', ['type'=>'only', 'tbl'=>'lectures', 'sid'=>encrypt($apply->sid), 'kind'=>'realfile']) }}">{{ $apply->filename }}</a>
                        <input type="checkbox" name="delfile" id="delfile" value="{{ $apply->realfile ?? '' }}" style="position: relative; top:2px" class="ml-10"/><span class="file-link ml-5">Please check if you wish to delete</span>
                    </div>
                    @endif
                </div>
            </div>
        </li>
        <li>
            <div class="form-tit">이력 (CV) <strong class="required">*</strong></div>
            <div class="form-con">
                <div class="filebox">
                    <input class="upload-name form-item" id="filenameText2" placeholder="File Upload" readonly="readonly">
                    <label for="userfile2">파일선택</label>
                    <input type="file" id="userfile2" name="userfile2" class="file-upload" onclick="return file_check('{{ $apply['filename2'] ?? '' }}','delfile2')">
                    @if( isset($apply->realfile2) )
                    <div class="attach-file">
                        <a href="{{ route('download', ['type'=>'only', 'tbl'=>'lectures', 'sid'=>encrypt($apply->sid), 'kind'=>'realfile2']) }}">{{ $apply->filename2 }}</a>
                        <input type="checkbox" name="delfile2" id="delfile2" value="{{ $apply->realfile2 ?? '' }}" style="position: relative; top:2px" class="ml-10"/><span class="file-link ml-5">Please check if you wish to delete</span>
                    </div>
                    @endif
                </div>
            </div>
        </li>
        <li>
            <div class="form-tit">발표 슬라이드 <strong class="required">*</strong></div>
            <div class="form-con">
                <div class="filebox">
                    <input class="upload-name form-item" id="filenameText3" placeholder="File Upload" readonly="readonly">
                    <label for="userfile3">파일선택</label>
                    <input type="file" id="userfile3" name="userfile3" class="file-upload" onclick="return file_check('{{ $apply['filename3'] ?? '' }}','delfile3')">
                    @if( isset($apply->realfile3) )
                    <div class="attach-file">
                        <a href="{{ route('download', ['type'=>'only', 'tbl'=>'lectures', 'sid'=>encrypt($apply->sid), 'kind'=>'realfile3']) }}">{{ $apply->filename3 }}</a>
                        <input type="checkbox" name="delfile3" id="delfile3" value="{{ $apply->realfile3 ?? '' }}" style="position: relative; top:2px" class="ml-10"/><span class="file-link ml-5">Please check if you wish to delete</span>
                    </div>
                    @endif
                </div>
            </div>
        </li>
        <li>
            <div class="form-tit">비밀번호 <strong class="required">*</strong></div>
            <div class="form-con">
                <input type="password" name="password" id="password" class="form-item">
            </div>
        </li>
    </ul>
</div>