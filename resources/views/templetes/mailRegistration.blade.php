
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{{ config('site.common.info.simpleName') }} 학술대회 </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0;">
    <table style="width:100%; max-width:650px; margin:0 auto; padding:0; border:1px solid #e2e2e2; border-collapse:collapse; border-spacing:0; text-align:center; 
        font-family:'맑은 고딕',Arial,sans-serif; line-height:1.4; font-size:15px; font-weight:400; letter-spacing:-0.5px; word-break:keep-all; box-sizing:border-box; ">
        <tbody>
            <tr>
                <td style="padding:0;">
                    <img src="{{ env('APP_URL') }}/assets/image/mail/mail_header.png" alt="" style="display:block; margin:0 auto;">
                </td>
            </tr>
            <tr>
                <td style="padding:15px 40px; font-size:20px; font-weight:bold; color:#fff; background-color:#13245c;">
                    {{ config('site.common.info.simpleName') }} 학술대회 사전등록 메일 
                </td>
            </tr>
            <tr>
                <td style="padding:20px 40px; font-size:25px; font-weight:bold; letter-spacing:-1.5px;">
                    {{ $apply->name }} 님의 대한응급의학회 학술대회 <br>
                    사전등록이 완료되었습니다.
                </td>
            </tr>
            {{-- <tr>
                <td style="padding:0 40px 30px; font-size:15px; font-weight:400; text-align:left;">
                    text text text text text text text text text text text text text text text text text text text text text text 
                </td>
            </tr> --}}
            <tr>
                <td style="padding:0 40px;">
                    <table style="width:100%; border-collapse:collapse; border-spacing:0;">
                        <colgroup>
                            <col style="width:200px;">
                            <col>
                        </colgroup>
                        <tbody>
                            <tr>
                                <th scope="row" style="padding:12px 20px; background-color:#f4f4f4; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; 
                                    text-align:left; font-size:15px; font-weight:400;">
                                    등록정보
                                </th>
                                <td style="padding:12px 20px; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; border-left:1px solid #e2e2e2; text-align:left; font-size:15px; font-weight:400;">
                                    구분 : {{ $apply->category == 'Z' ? $apply->category_etc : config('site.registration.category')[$apply->category] }} @if( in_array( $apply->category, config('site.registration.categoryAction')) ) ( 면허번호 : 123456, 전공과목 : 전공과목 ) @endif<br>
                                    이름 : {{ $apply->name }}, 핸드폰번호 : {{ $apply->phone }}, 이메일 : {{ $apply->email }}<br>
                                    금액 : {{ $apply->price > 0 ? number_format($apply->price).'원' : '무료' }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="padding:12px 20px; background-color:#f4f4f4; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; 
                                    text-align:left; font-size:15px; font-weight:400;">
                                    총액
                                </th>
                                <td style="padding:12px 20px; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; border-left:1px solid #e2e2e2;
                                    text-align:left; font-size:15px; font-weight:400;">
                                    {{ number_format($apply->price) }}원
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="padding:12px 20px; background-color:#f4f4f4; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; 
                                    text-align:left; font-size:15px; font-weight:400;">
                                    결제구분 
                                </th>
                                <td style="padding:12px 20px; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; border-left:1px solid #e2e2e2;
                                    text-align:left; font-size:15px; font-weight:400;">
                                    {{ config('site.registration.payMethod')[$apply->payMethod] }}
                                </td>
                            </tr>
                            @if( $apply->payMethod == 'B' )
                            <tr>
                                <th scope="row" style="padding:12px 20px; background-color:#f4f4f4; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; 
                                    text-align:left; font-size:15px; font-weight:400;">
                                    입금자명 
                                </th>
                                <td style="padding:12px 20px; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; border-left:1px solid #e2e2e2;
                                    text-align:left; font-size:15px; font-weight:400;">
                                    {{ $apply->payName }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="padding:12px 20px; background-color:#f4f4f4; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; 
                                    text-align:left; font-size:15px; font-weight:400;">
                                    입금일 
                                </th>
                                <td style="padding:12px 20px; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; border-left:1px solid #e2e2e2;
                                    text-align:left; font-size:15px; font-weight:400;">
                                    {{ $apply->payDate }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="padding:12px 20px; background-color:#f4f4f4; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; 
                                    text-align:left; font-size:15px; font-weight:400;">
                                    입금 계좌번호
                                </th>
                                <td style="padding:12px 20px; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; border-left:1px solid #e2e2e2;
                                    text-align:left; font-size:15px; font-weight:400;">
                                    신한은행 110-543-331734 김창선 대한응급의학회 재무이사
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="padding:12px 20px; background-color:#f4f4f4; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; 
                                    text-align:left; font-size:15px; font-weight:400;">
                                    환불계좌 
                                </th>
                                <td style="padding:12px 20px; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; border-left:1px solid #e2e2e2;
                                    text-align:left; font-size:15px; font-weight:400;">
                                    {{ $apply->refundAccount }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="padding:12px 20px; background-color:#f4f4f4; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; 
                                    text-align:left; font-size:15px; font-weight:400;">
                                    환불은행  
                                </th>
                                <td style="padding:12px 20px; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; border-left:1px solid #e2e2e2;
                                    text-align:left; font-size:15px; font-weight:400;">
                                    {{ $apply->refundBank }}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" style="padding:12px 20px; background-color:#f4f4f4; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; 
                                    text-align:left; font-size:15px; font-weight:400;">
                                    환불계좌 예금주 
                                </th>
                                <td style="padding:12px 20px; border-top:1px solid #e2e2e2; border-bottom:1px solid #e2e2e2; border-left:1px solid #e2e2e2;
                                    text-align:left; font-size:15px; font-weight:400;">
                                    {{ $apply->refundHolder }}
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding:90px 0 30px;">
                    <a href="{{ env('APP_URL') }}" target="_blank"><img src="{{ env('APP_URL') }}/assets/image/mail/btn_mail_home.png" alt=""></a>
                </td>
            </tr>
            <tr>
                <td style="padding:0 40px 20px; text-align:left; color:red; font-size:15px; font-weight:400;">
                    ※ 정보 유출 방지를 위하여 메일을 확인 하신 후 삭제 하시기 바랍니다.
                </td>
            </tr>
            <tr>
                <td style="padding:0; background-color: #3a3e49;">
                    <img src="{{ env('APP_URL') }}/assets/image/mail/mail_footer.png" alt="" style="display:block; margin:0 auto;">
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>