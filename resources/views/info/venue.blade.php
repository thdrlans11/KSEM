@extends('include.layout')

@section('content')
<div class="map-wrap">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3262.3934962396343!2d126.83793387624047!3d35.1468059591455!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357189168167b455%3A0x2bbb70f7350eb0b1!2z6rSR7KO86rSR7Jet7IucIOyEnOq1rCDsg4HrrLTriITrpqzroZwgMzA!5e0!3m2!1sko!2skr!4v1739947513787!5m2!1sko!2skr"></iframe>
    <a href="#n" class="btn btn-type1 color-type7">오시는길 자세히보기 <img src="/assets/image/sub/ic_btn_arrow_wh.png" alt=""></a>
</div>
<div class="map-info">
    <div class="map-box top">
        <div class="map-info-box">
            <img src="/assets/image/sub/ico_map01.png" alt="">
            <p><strong>김대중컨벤션센터</strong> 광주광역시 서구 상무누리로 30</p>
        </div>
        <div class="map-info-box">
            <img src="/assets/image/sub/ico_map02.png" alt="">
            <p><strong>전화번호</strong> <a href="tel:062-611-200">062-611-2000</a></p>
        </div>
    </div>
    <div class="map-box bottom">
        <div class="map-info-box">
            <p class="tit"><img src="/assets/image/sub/ico_map03.png" alt="">지하철</p>
            <p>김대중컨벤션센터(마륵)역 하차 -> 5번출구로 나와서 직진(3분 소요)</p>
        </div>
        <div class="map-info-box">
            <p class="tit"><img src="/assets/image/sub/ico_map04.png" alt="">버스노선</p>
            <div class="table-wrap">
                <table class="cst-table">
                    <caption class="hide">버스노선</caption>
                    <colgroup>
                        <col style="width: 50%;">
                        <col>
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>GATE 5에서 가까운 정류장</th>
                            <td>[김대중컨벤션센터] : 일곡 38, 상무 64</td>
                        </tr>
                        <tr>
                            <th>컨벤션동, GATE 1,2와 가까운 정류장</th>
                            <td>[김대중컨벤션센터 후문] : 마을 799</td>
                        </tr>
                        <tr>
                            <th>GATE 3, 컨벤션동과 가까운 정류장</th>
                            <td>[전남고] : 운림 50, 지원 25</td>
                        </tr>
                        <tr>
                            <th>GATE 4에서 가까운 정류장</th>
                            <td>[518 자유공원] : 518, 상무 63, 순환 01, 좌석 02</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection