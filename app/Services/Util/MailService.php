<?php

namespace App\Services\Util;

use App\Services\dbService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class MailService
 * @package App\Services
 */
class MailService extends dbService
{
    public $receiver_name = "";
    public $receiver_email = "";
    public $sender_name = "";
    public $sender_email = "";
    public $subject = "";
    public $body = "";

    public function makeMail($data, $kind, $mode = null, $judgeGubun = null)
    {
        $this->sender_name = config('site.common.info.simpleName');
        $this->sender_email = config('site.common.info.email');

        switch($kind){
            case 'registrationComplete' :
                $this->receiver_name = $data->name;
                $this->receiver_email = $data->email;
                $this->subject = '['.config('site.common.info.simpleName').'] 춘계학술대회 사전등록이 완료되었습니다.';        

                if( $mode == 'preview' ){
                    return view('templetes.mailRegistration', ['apply'=>$data, 'kind'=>$kind])->render();
                }
                
                $this->body = view('templetes.mailRegistration', ['apply'=>$data, 'kind'=>$kind])->render();
            break;       
        }

        $this->wiseuSend($this);
        
        //사무국
        if( config('site.common.default.adminReceive') ){
            $this->receiver_name = config('site.common.info.siteName');
            $this->receiver_email = config('site.common.info.email');
            $this->wiseuSend($this);
        }

        //기획자
        if( config('site.common.default.mailReceive') ){
            $this->receiver_name = config('site.common.info.siteName');
            $this->receiver_email = config('site.common.info.email2');
            $this->wiseuSend($this);
        }
    }

    private function wiseuSend($mailData)
    {   
        $wiseUconnection = wiseuConnection();

        $now = Carbon::now();
        $seq = $now->timestamp . $now->micro;

        $stmt = $wiseUconnection->prepare("INSERT INTO NVREALTIMEACCEPT 
                    (ECARE_NO, RECEIVER_ID, CHANNEL, SEQ, REQ_DT, REQ_TM, TMPL_TYPE, RECEIVER_NM, RECEIVER, SENDER_NM, SENDER, SUBJECT, SEND_FG, DATA_CNT) 
                    VALUES (:ECARE_NO, :RECEIVER_ID, :CHANNEL, :SEQ, :REQ_DT, :REQ_TM, :TMPL_TYPE, :RECEIVER_NM, :RECEIVER, :SENDER_NM, :SENDER, :SUBJECT, :SEND_FG, :DATA_CNT)");

        $stmt->execute([
            ':ECARE_NO' => config('site.common.info.ecareNum'),
            ':RECEIVER_ID' => $seq,
            ':CHANNEL' => 'M',
            ':SEQ' => $seq,
            ':REQ_DT' => $now->format('Ymd'),
            ':REQ_TM' => $now->format('His'),
            ':TMPL_TYPE' => 'T',
            ':RECEIVER_NM' => $mailData->receiver_name,
            ':RECEIVER' => $mailData->receiver_email,
            ':SENDER_NM' => $mailData->sender_name,
            ':SENDER' => $mailData->sender_email,
            ':SUBJECT' => $mailData->subject,
            ':SEND_FG' => 'R',
            ':DATA_CNT' => 1,
        ]);

        $stmt = $wiseUconnection->prepare("INSERT INTO NVREALTIMEACCEPTDATA (SEQ, DATA_SEQ, ATTACH_YN, DATA) VALUES (:SEQ, :DATA_SEQ, :ATTACH_YN, :DATA)");

        $stmt->execute([
            'SEQ' => $seq,
            'DATA_SEQ' => 1,
            'ATTACH_YN' => 'N',
            'DATA' => $mailData->body,
        ]);
        
        // DB::connection('wiseu')->table('NVREALTIMEACCEPT')->insert($NVREALTIMEACCEPT);
        // DB::connection('wiseu')->table('NVREALTIMEACCEPTDATA')->insert($NVREALTIMEACCEPTDATA);
    }
}
