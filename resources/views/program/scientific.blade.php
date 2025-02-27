@extends('include.layout')

@section('content')
<ul class="sub-tab-menu">
    <li><a href="{{ route('program.glance') }}"><span>전체프로그램</span></a></li>
    <li class="on"><a href="{{ route('program.scientific') }}"><span>세부프로그램</span></a></li>
</ul>

<div class="btn-wrap text-right mt-0">
    <a href="#" class="btn btn-type1 color-type10">전체프로그램 다운로드 <img src="/assets/image/sub/ic_btn_down.png" alt="" class="right"></a>
    <a href="#" class="btn btn-type1 color-type7">구연프로그램 다운로드 <img src="/assets/image/sub/ic_btn_down.png" alt="" class="right"></a>
</div>
<div class="border-box bg-orange text-center mt-20">
    * 학회프로그램은 수시로 업데이트 되어 게시될 예정입니다.
</div>

<div class="sch-form-wrap">
    <form action="" method="">
        <fieldset>
            <legend class="hide">검색</legend>
            <div class="sch-wrap">
                <div class="form-group">
                    <select name="search_key" id="search_key" class="form-item sch-cate">
                        <option value="all" selected="">All</option>
                            <option value="theme">Topic</option>
                            <option value="speaker">Speaker</option>
                            <option value="chair">Chair</option>
                            <option value="title">Title</option>
                    </select>
                    <input type="text" name="" id="" class="form-item sch-key" placeholder="강의명, 연자를 입력해주세요">
                    <button type="submit" class="btn btn-sch">검색</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>

<div class="sub-tab-wrap">
    <ul class="sub-tab-menu">
        <li class="on all"><a href="#n">전체</a></li>
        <li><a href="#n">4월 17일</a></li>
        <li><a href="#n">4월 18일</a></li>
    </ul>
</div>
<div class="sub-tab-wrap">
    <ul class="room-tab-menu">
        <li class="all on"><a href="#n">All Room</a></li>
        <li class="room-a"><a href="#n">Room A</a></li>
        <li class="room-b"><a href="#n">Room B</a></li>
        <li class="room-c"><a href="#n">Room C</a></li>
    </ul>
</div>

<div class="table-wrap scroll-x touch-help room-a">
    <table class="cst-table session-table">
        <caption class="hide">Session V (A). Small Cell Lung Cancer Recent Update</caption>
        <colgroup>
            <col style="width: 20%;">
            <col>
            <col style="width: 20%;">
        </colgroup>
        <thead>
            <tr>
                <th scope="col" class="text-left" colspan="2"><span class="bbs-cate">연수강좌</span>Cardiovascular 1</th>
                <th scope="col" class="room">그랜드홀 A+B</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row" class="text-left">시간</th>
                <td class="text-left" colspan="2"><strong>09:00-10:20</strong></td>
            </tr>
            <tr>
                <th scope="row" class="text-left">Moderator</th>
                <td class="text-left" colspan="2">김원(제주한라병원), 강구현(한림대학교 강남성심병원)</td>
            </tr>
            <tr>
                <th scope="row" class="text-left">Speaker</th>
                <td class="text-left" colspan="2">
                    <div class="inner-table-wrap">
                        <table class="cst-table">
                            <caption class="hide">Speakers</caption>
                            <colgroup>
                                <col>
                                <col style="width: 25%;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td class="text-left">Ischemic ECG that is easy to miss</td>
                                    <td class="text-center">신승렬 (인하대학교병원)</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Ischemic ECG that is easy to miss</td>
                                    <td class="text-center">신승렬 (인하대학교병원)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-wrap scroll-x touch-help room-a">
    <table class="cst-table session-table">
        <caption class="hide">Session V (A). Small Cell Lung Cancer Recent Update</caption>
        <colgroup>
            <col style="width: 20%;">
            <col>
            <col style="width: 20%;">
        </colgroup>
        <thead>
            <tr>
                <th scope="col" class="text-left" colspan="2"><span class="bbs-cate">연수강좌</span>Cardiovascular 1</th>
                <th scope="col" class="room">그랜드홀 A+B</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row" class="text-left">시간</th>
                <td class="text-left" colspan="2"><strong>09:00-10:20</strong></td>
            </tr>
            <tr>
                <th scope="row" class="text-left">Moderator</th>
                <td class="text-left" colspan="2">김원(제주한라병원), 강구현(한림대학교 강남성심병원)</td>
            </tr>
            <tr>
                <th scope="row" class="text-left">Speaker</th>
                <td class="text-left" colspan="2">
                    <div class="inner-table-wrap">
                        <table class="cst-table">
                            <caption class="hide">Speakers</caption>
                            <colgroup>
                                <col>
                                <col style="width: 25%;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td class="text-left">Ischemic ECG that is easy to miss</td>
                                    <td class="text-center">신승렬 (인하대학교병원)</td>
                                </tr>
                                <tr>
                                    <td class="text-left">Ischemic ECG that is easy to miss</td>
                                    <td class="text-center">신승렬 (인하대학교병원)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection