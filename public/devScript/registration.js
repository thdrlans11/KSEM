var emailCheckValue = false;
var phoneCheckValue = false;

$(document).ready(function(){

    $("input:radio[name='category']").click(function(){
        if( $(this).data("action") == "Y" ){
            $(".actionBox").show();
        }else{
            $(".actionBox").find("input:text").val("");
            $(".actionBox").hide();
        }

        if( $(this).val() == "Z" ){
            $("#category_etc").attr("readonly", false);
        }else{
            $("#category_etc").attr("readonly", true).val("");
        }
    });

    $("input:radio[name='payMethod']").click(function(){
        if( $(this).val() == "B" ){
            $(".Bbox").show();
        }else{
            $(".Bbox").find("input:text").val("");
            $(".Bbox").hide();
        }
    });

    $(".searchConditionLi").click(function(){
        var condition = $(this).data("condition");
        $("#searchCondition").val(condition);
    });

});

function emailCheck()
{
    let email = $("#email").val();

    if( !email ){
        swalAlert("이메일을 입력해주세요.", "", "warning", "email");
        return false;
    }

    if( !isCorrectEmail(email) ){
        swalAlert("이메일 규칙에 맞지 않습니다. (check @ and .’s)", "", "warning", "email");
        return false;
    }
    
    $.ajax({
        type: 'POST',
        url: '/registration/emailCheck',
        data: { email : email },
        async: false,
        success: function(data) {
			if( $.trim(data) == "already" ){
                swalAlert("이미 사용된 이메일입니다<br>다른 이메일로 다시 시도해주시기 바랍니다.", "", "warning", "email");
                emailCheckValue = false;
            }else{
                swalAlert("사용 가능합니다.", "", "success", "email");
                emailCheckValue = true;
            }
        }
    });

    return false;
}

function phoneCheck()
{
    let phone = $("#phone").val();

    if( !phone ){
        swalAlert("휴대폰번호를 입력해주세요.", "", "warning", "phone");
        return false;
    }

    $.ajax({
        type: 'POST',
        url: '/registration/phoneCheck',
        data: { phone : phone },
        async: false,
        success: function(data) {
			if( $.trim(data) == "already" ){
                swalAlert("이미 사용된 휴대폰번호입니다<br>다른 번호로 다시 시도해주시기 바랍니다.", "", "warning", "phone");
                phoneCheckValue = false;
            }else{
                swalAlert("사용 가능합니다.", "", "success", "phone");
                phoneCheckValue = true;
            }
        }
    });

    return false;
}

function makeLocalSub(localSub)
{
    var local = $("#local").val();
    localSub = typeof localSub !== 'undefined' ? localSub : '' ;

    $.ajax({
        type: 'POST',
        url: '/registration/makeLocalSub',
        data: { 
                local : local,
                localSub : localSub,
              },
        async: false,
        success: function(data) {
			$("#local_sub").html(data);
        }
    });   
}

function makePrice(lang)
{
    var type = $("input:hidden[name='type']").val();
    var category = $("input:radio[name='category']:checked").val();
    var attendType = $("input:radio[name='attendType']:checked").val();

    priceProcess(type, category, attendType);
}

function priceProcess(type, category, attendType)
{
    $.ajax({
        type: 'POST',
        url: '/registration/makePrice',
        data: { 
                type : type,
                category : category,
                attendType : attendType,
              },
        async: false,
        success: function(data) {
			$(".totalPriceSpan").html(data.priceUnit);
            $("#price").val(data.price);
        }
    });    
}

function registrationCheck_01(f)
{
    if( $("input:hidden[name='pageMode']").val() == "regist" ){
        if( !$("#agree").is(":checked") ){
            swalAlert("사전등록 안내 숙지여부를 확인해주세요.", "", "warning", "agree");
            return false;
        }
        if( !$("#agree2").is(":checked") ){
            swalAlert("개인정보 수집 및 이용에 동의해주세요.", "", "warning", "agreee");
            return false;
        }
    }
    if( !$("input:radio[name='attendType']").is(":checked") ){
        swalAlert("참석일을 선택해주세요.", "", "warning", "attendTypeA");
        return false;
    }
    if( !$("input:radio[name='category']").is(":checked") ){
        swalAlert("회원구분을 선택해주세요.", "", "warning", "categoryA");
        return false;
    }else{
        if( $("input:radio[name='category']:checked").val() == "Z" ){
            if( !$(f.category_etc).val() ){
                swalAlert("회원구분 기타를 입력해주세요.", "", "warning", "category_etc");
                return false;
            }
        }
    }
    if( !$(f.name).val() ){
        swalAlert("성명을 입력해주세요.", "", "warning", "name");
        return false;
    }
    if( $("input:radio[name='category']:checked").data('action') == "Y" ){
        if( !$(f.license_number).val() ){
            swalAlert("면허번호를 입력해주세요.", "", "warning", "license_number");
            return false;
        }
        if( !$(f.major).val() ){
            swalAlert("전공과목을 입력해주세요.", "", "warning", "major");
            return false;
        }
    }
    if( !$(f.birth).val() ){
        swalAlert("생년월일을 입력해주세요.", "", "warning", "birth");
        return false;
    }
    if( !$("input:radio[name='sex']").is(":checked") ){
        swalAlert("성별을 선택해주세요.", "", "warning", "sexM");
        return false;
    }
    if( !$(f.office).val() ){
        swalAlert("소속(병원)을 입력해주세요.", "", "warning", "office");
        return false;
    }

    if( !$("input:hidden[name='sid']").val() ){
        if( !$(f.phone).val() ){
            swalAlert("휴대폰번호를 입력해주세요.", "", "warning", "phone");
            return false;
        }
        if( !phoneCheckValue ){
            swalAlert("휴대폰번호 중복확인을 진행해주세요.", "", "warning", "phone");
            return false;
        }
        if( !$(f.email).val() ){
            swalAlert("이메일을 입력해주세요.", "", "warning", "email");
            return false;
        }
        if( !emailCheckValue ){
            swalAlert("이메일 중복확인을 진행해주세요.", "", "warning", "email");
            return false;
        }
    }    
    if( !$(f.local).val() ){
        swalAlert("지역을 선택해주세요.", "", "warning", "local");
        return false;
    }
    if( !$(f.local_sub).val() ){
        swalAlert("지역을 선택해주세요.", "", "warning", "local_sub");
        return false;
    }
    if( !$("input:radio[name='firstVisit']").is(":checked") ){
        swalAlert("첫 방문 여부를 선택해주세요.", "", "warning", "firstVisitY");
        return false;
    }

    var captcha = $("#captcha").val();
    var captchaCheck = true;

    if( !captcha ){
        swalAlert("자동화 프로그램 입력 방지 번호를 입력해주세요.", "", "warning", "captcha");
        return false;
    }

    $.ajax({
        type: 'POST',
        url: '/common/captcha-check',
        data: { captcha : captcha },
        async: false,
        success: function(data) {
			if( $.trim(data) == "fail" ){
                captchaCheck = false;
            }
        }
    });
    
    if( !captchaCheck ){
        swalAlert("자동화 프로그램 입력방지 인증에 실패하였습니다.", "", "warning", "captcha");
        return false;
    }
}

function registrationCheck_02(f)
{
    if( $("input:hidden[name='payMethod']").length <= 0  ){
        if( !$("input:radio[name='payMethod']").is(":checked") ){
            swalAlert("결제구분을 선택해주세요.", "", "warning", "payMethodC");
            return false;
        }else{
            if( $("input:radio[name='payMethod']:checked").val() == "B" ){  
                if( !$(f.payName).val() ){
                    swalAlert("입금자명을 입력해주세요.", "", "warning", "payName");
                    return false;
                }
                if( !$(f.payDate).val() ){
                    swalAlert("입금일을 입력해주세요.", "", "warning", "payDate");
                    return false;
                }
                if( !$(f.refundAccount).val() ){
                    swalAlert("환불계좌를 입력해주세요.", "", "warning", "refundAccount");
                    return false;
                }
                if( !$(f.refundBank).val() ){
                    swalAlert("환불은행을 입력해주세요.", "", "warning", "refundBank");
                    return false;
                }
                if( !$(f.refundHolder).val() ){
                    swalAlert("환불계좌 예금주를 입력해주세요.", "", "warning", "refundHolder");
                    return false;
                }
            }
        }
    }    

    var captcha = $("#captcha").val();
    var captchaCheck = true;

    if( !captcha ){
        swalAlert("자동화 프로그램 입력 방지 번호를 입력해주세요.", "", "warning", "captcha");
        return false;
    }

    $.ajax({
        type: 'POST',
        url: '/common/captcha-check',
        data: { captcha : captcha },
        async: false,
        success: function(data) {
			if( $.trim(data) == "fail" ){
                captchaCheck = false;
            }
        }
    });
    
    if( !captchaCheck ){
        swalAlert("자동화 프로그램 입력방지 인증에 실패하였습니다.", "", "warning", "captcha");
        return false;
    }

    if( $("input:radio[name='payMethod']:checked").val() == "C" && $("input:hidden[name='pageMode']").val() != "admin" ){

        const price = $("#price").val();
        const user_name = $("#user_name").val();
        const user_id = $("#user_id").val();

        $.ajax({
            type: 'POST',
            url: '/registration/payRegist',
            data: { price : price, user_name : user_name, user_id : user_id },
            async: false,
            success: function(data) {
                if( data['code'] != "0000" ){
                    alert("거래등록에 실패했습니다.");
                    return false;
                }else{
                    window.open(data['pay_url'], 'pay', 'toolbar=no,scrollbars=no,resizable=yes,status=no,menubar=no,width=820, height=600, top=0,left=0');
                }
            }
        });

        return false;
    }
}

function registrationSearchCheck(f)
{
    if( $(f.searchCondition).val() == 'P' ){
        if( !$(f.Pname).val() ){
            swalAlert("성명을 입력해주세요.", "", "warning", "Pname");
            return false;
        }
        if( !$(f.Pphone).val() ){
            swalAlert("휴대폰번호를 입력해주세요.", "", "warning", "Pphone");
            return false;
        }    
    }
    if( $(f.searchCondition).val() == 'E' ){
        if( !$(f.Ename).val() ){
            swalAlert("성명을 입력해주세요.", "", "warning", "Ename");
            return false;
        }
        if( !$(f.Eemail).val() ){
            swalAlert("이메일을 입력해주세요.", "", "warning", "Eemail");
            return false;
        }    
    }
}