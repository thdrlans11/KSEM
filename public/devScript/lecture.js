var emailCheckValue = false;

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
        url: '/lecture/emailCheck',
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

function lectureCheck(f)
{
    if( !$(f.name).val() ){
        swalAlert("성명을 입력해주세요.", "", "warning", "name");
        return false;
    }
    if( !$("input:hidden[name='sid']").val() ){
        if( !$(f.email).val() ){
            swalAlert("이메일을 입력해주세요.", "", "warning", "email");
            return false;
        }
        if( !emailCheckValue ){
            swalAlert("이메일 중복확인을 진행해주세요.", "", "warning", "email");
            return false;
        }
    }   
    if( !$(f.office).val() ){
        swalAlert("소속(병원)을 입력해주세요.", "", "warning", "office");
        return false;
    }
    if( !$(f.phone).val() ){
        swalAlert("휴대폰번호를 입력해주세요.", "", "warning", "phone");
        return false;
    }

    if( $("#delfile").length > 0 ){
        if( $(f.userfile).val() == "" && $("#delfile").is(":checked") ){
            swalAlert("강의원고 파일을 제출 해주세요.", "", "warning", "userfile");
            return false;
        }
    }else{
        if( $(f.userfile).val() == "" ){
            swalAlert("강의원고 파일을 제출 해주세요.", "", "warning", "userfile");
            return false;
        }
    }

    if( $("#delfile2").length > 0 ){
        if( $(f.userfile2).val() == "" && $("#delfile2").is(":checked") ){
            swalAlert("이력(CV) 파일을 제출 해주세요.", "", "warning", "userfile2");
            return false;
        }
    }else{
        if( $(f.userfile2).val() == "" ){
            swalAlert("이력(CV) 파일을 제출 해주세요.", "", "warning", "userfile2");
            return false;
        }
    }

    if( $("#delfile3").length > 0 ){
        if( $(f.userfile3).val() == "" && $("#delfile3").is(":checked") ){
            swalAlert("발표 슬라이드 파일을 제출 해주세요.", "", "warning", "userfile3");
            return false;
        }
    }else{
        if( $(f.userfile3).val() == "" ){
            swalAlert("발표 슬라이드 파일을 제출 해주세요.", "", "warning", "userfile3");
            return false;
        }
    }

    if( !$(f.password).val() && !$("input:hidden[name='sid']").val() ){
        swalAlert("비밀번호를 입력해주세요.", "", "warning", "password");
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

function lectureSearchCheck(f)
{
    if( !$(f.name).val() ){
        swalAlert("성명을 입력해주세요.", "", "warning", "name");
        return false;
    }
    if( !$(f.email).val() ){
        swalAlert("이메일을 입력해주세요.", "", "warning", "email");
        return false;
    }  
    if( !$(f.password).val() ){
        swalAlert("비밀번호를 입력해주세요.", "", "warning", "password");
        return false;
    }   
}