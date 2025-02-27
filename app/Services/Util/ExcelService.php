<?php

namespace App\Services\Util;

use Spatie\SimpleExcel\SimpleExcelWriter;
/**
 * Class ExcelService
 * @package App\Services
 */
class ExcelService
{
    private $row;
    
    public function RegistrationExcel($lists, $totCnt)
    {
        $excel = SimpleExcelWriter::streamDownload('registration.csv');
        $excel->noHeaderRow();

        // Header
        $header = [
            'No',
            '등록타입',
            '등록번호',
            '참가일',
            '등록구분',
            '이름',
            '면허번호',
            '전공과목',
            '생년월일',
            '성별',
            '소속',
            '이메일',
            '휴대폰번호',
            '지역',
            '지역세부',
            '첫방문 여부',
            '등록비',
            '결제방법',
            '입금자',
            '입금일',
            '환불계좌',
            '환불은행',
            '환불예금주',
            '입금상태',
            '실제입금일',
            '접수시작일',
            '접수완료일',
            '메모'
        ];

        // Add header to the CSV
        $excel->addRow($header);

        // Add data to the CSV
        foreach ($lists->lazy(3000) as $key => $apply) {
            $this->row[$key] = [
                ($totCnt - $key),
                config('site.registration.type')[$apply->type],
                $apply->rnum,
                config('site.registration.attendType')[$apply->attendType],
                $apply->category == 'Z' ? $apply->category_etc : config('site.registration.category')[$apply->category],
                $apply->name,
                $apply->license_number ?? '',
                $apply->major ?? '',
                $apply->birth,
                config('site.registration.sex')[$apply->sex],
                $apply->office,
                $apply->email,
                $apply->phone,
                config('site.registration.local')[$apply->local],
                config('site.registration.local_sub')[$apply->local][$apply->local_sub],
                config('site.registration.answer')[$apply->firstVisit],
                number_format($apply->price),
                config('site.registration.payMethod')[$apply->payMethod],
                $apply->payName ?? '',
                $apply->payDate ?? '',
                $apply->refundAccount ?? '',
                $apply->refundBank ?? '',
                $apply->refundHolder ?? '',
                config('site.registration.payStatus')[$apply->payStatus],
                $apply->payComplete_at ?? '',
                $apply->created_at ?? '',
                $apply->complete_at ?? '',
                $apply->memo ?? ''
            ];

            // 특수문자 때문에
            $this->row[$key] = excelEntity($this->row[$key]);

            $excel->addRow($this->row[$key]);
        }

        // Download the CSV
        return $excel->toBrowser();
    }

    public function LectureExcel($lists, $totCnt)
    {
        $excel = SimpleExcelWriter::streamDownload('lecture.csv');
        $excel->noHeaderRow();

        // Header
        $header = [
            'No',
            '접수번호',
            '이름',
            '이메일',
            '소속',
            '휴대폰번호',
            '전화번호',
            '강의원고',
            '이력(CV)',
            '발표슬라이드',
            '등록완료일',
            '메모'
        ];

        // Add header to the CSV
        $excel->addRow($header);

        // Add data to the CSV
        foreach ($lists->lazy(3000) as $key => $apply) {
            $this->row[$key] = [
                ($totCnt - $key),
                $apply->rnum,
                $apply->name,
                $apply->email,
                $apply->office,
                $apply->phone,
                $apply->tel ?? '',
                $apply->filename,
                $apply->filename2,
                $apply->filename3,
                $apply->complete_at ?? '',
                $apply->memo ?? ''
            ];

            // 특수문자 때문에
            $this->row[$key] = excelEntity($this->row[$key]);

            $excel->addRow($this->row[$key]);
        }

        // Download the CSV
        return $excel->toBrowser();
    }
}
