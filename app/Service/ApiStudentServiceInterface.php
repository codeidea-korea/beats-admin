<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiStudentServiceInterface
{
    //학생 인증 신청
    public function setChStudent($params);
    //학생 인증 신청 첨부파일
    public function studentFileInsert($sqlData);

}
