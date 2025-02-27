<?php 
$registrationAvg = (new app\Models\Registration)->registrationAvg($tabMode);
$optionAvg = $registrationAvg['optionAvg'];
?>
<ul class="write-wrap mb-50">
    <li class="full">
        <div class="form-tit text-center">
            <button type="button" class="btn btn-small color-type5  js-btn-toggle">통계현황 열기</button>
        </div>
        <div class="form-con js-toggle-con" style="display:none">
            <ul class="write-wrap">
                <li>
                    <div class="form-tit">접수현황</div>
                    <div class="form-con">
                        <ul class="bar-list">
                            <li>전체 : <a href="#n" class="text-red">{{ number_format($optionAvg->totalCount) }}건</a></li>
                            <li>접수중 : <a href="#n" class="text-red">{{ number_format($optionAvg->statusN) }}건</a></li>
                            <li>접수완료 : <a href="#n" class="text-red">{{ number_format($optionAvg->statusY) }}건</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="form-tit">Payment Status</div>
                    <div class="form-con">
                        <ul class="bar-list">
                            @foreach( config('site.registration.payStatus') as $key => $val )
                            <li>{{ $val }} : <a href="{{ route('admin.registration.list', ['tabMode'=>$tabMode, 'payStatus'=>$key]) }}" class="text-red">{{ number_format($optionAvg['payStatus'.$key]) }}건</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="form-tit">Payment Method</div>
                    <div class="form-con">
                        <ul class="bar-list">
                            @foreach( config('site.registration.payMethod') as $key => $val )
                            <li>{{ $val }} : <a href="{{ route('admin.registration.list', ['tabMode'=>$tabMode, 'payMethod'=>$key]) }}" class="text-red">{{ number_format($optionAvg['payMethod'.$key]) }}건</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="form-tit">등록구분</div>
                    <div class="form-con">
                        <ul class="bar-list">
                            @foreach( config('site.registration.category') as $key => $val )
                            <li>{{ $val }} : <a href="{{ route('admin.registration.list', ['tabMode'=>$tabMode, 'category'=>$key]) }}" class="text-red">{{ number_format($optionAvg['category'.$key]) }}건</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="form-tit">참석일</div>
                    <div class="form-con">
                        <ul class="bar-list">
                            @foreach( config('site.registration.attendType') as $key => $val )
                            <li>{{ $val }} : <a href="{{ route('admin.registration.list', ['tabMode'=>$tabMode, 'attendType'=>$key]) }}" class="text-red">{{ number_format($optionAvg['attendType'.$key]) }}건</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </li>
</ul>