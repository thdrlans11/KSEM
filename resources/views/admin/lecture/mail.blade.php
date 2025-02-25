@extends('include.layoutPopup')

@section('content')
    
    <div class="write-form-wrap">
        <form id="mailForm" action="{{ route('admin.registration.sendMail', ['sid'=>encrypt($apply->sid)]) }}" method="post">
            {{ csrf_field() }}
            <fieldset>
                <legend class="hide">Mail</legend>

                {!! $mailBody !!}               

                <div class="border-box mt-20" style="padding: 30px 30px;">
                    <ul class="list-type list-type-dot text-red">
                        <li>발송 이메일 입력하지 않고 메일 발송 버튼 클릭 시 해당 접수자에게 메일이 발송됩니다.</li>
                        <li>발송 이메일 입력 후 메일 발송 클릭 시 입력한 메일 계정으로만 해당 메일이 발송 됩니다.</li>
                    </ul>
            
                    <div class="form-con mt-20">
                        <div class="form-group has-btn">
                            <input type="text" name="email" id="email" value="" class="form-item w-90p">
                            <a href="#n" onclick="swalConfirm('정말 발송하시겠습니까?', '', function(){ $('#mailForm').submit() })" class="btn btn-small color-type3">메일 발송</a>
                        </div>
                    </div>
                </div>

                <div class="btn-wrap text-center">
                    <a href="" class="btn btn-type1 color-type2 colorClose">Close</a>
                </div>
            </fieldset>
        </form>
    </div>
@endsection
