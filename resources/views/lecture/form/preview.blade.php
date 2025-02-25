<div class="sub-tit-wrap">
    <h4 class="sub-tit">접수정보</h4>
</div>
<div class="table-wrap">
    <table class="cst-table">
        <caption class="hide">접수정보</caption>
        <colgroup>
            <col style="width: 20%;">
            <col>
        </colgroup>
        <tbody>
            <tr>
                <th>성명 </th>
                <td>{{ $apply->name }}</td>
            </tr>
            <tr>
                <th>이메일</th>
                <td>{{ $apply->email }}</td>
            </tr>
            <tr>
                <th>소속 (병원) </th>
                <td>{{ $apply->office }}</td>
            </tr>
            <tr>
                <th>휴대폰번호 </th>
                <td>{{ $apply->phone }}</td>
            </tr>
            @if( $apply->tel )
            <tr>
                <th>전화번호 </th>
                <td>{{ $apply->tel }}</td>
            </tr>
            @endif
            <tr>
                <th>강의원고 파일</th>
                <td><a href="{{ route('download', ['type'=>'only', 'tbl'=>'lectures', 'sid'=>encrypt($apply->sid), 'kind'=>'realfile']) }}" class="underline" download>{{ $apply->filename }}</a></td>
            </tr>
            <tr>
                <th>이력 (CV)</th>
                <td><a href="{{ route('download', ['type'=>'only', 'tbl'=>'lectures', 'sid'=>encrypt($apply->sid), 'kind'=>'realfile2']) }}" class="underline" download>{{ $apply->filename2 }}</a></td>
            </tr>
            <tr>
                <th>발표 슬라이드</th>
                <td><a href="{{ route('download', ['type'=>'only', 'tbl'=>'lectures', 'sid'=>encrypt($apply->sid), 'kind'=>'realfile3']) }}" class="underline" download>{{ $apply->filename3 }}</a></td>
            </tr>
        </tbody>
    </table>
</div>