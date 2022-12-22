<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface MentoServiceInterface
{
    //분야 리스트
    public function getFieldList($params);

    //분야 수정
    public function setFildUpdate($params);

    //분야 등록
    public function setFildInsert($params);

    //멘토 전환신청 리스트
    public function getMentoChList($params);

    //멘토 전환신청 Total
    public function getMentoChTotal($params);

    //멘토 전환신청 view data
    public function getMentoChData($params);

    //멘토 전환신청 view File
    public function getMentoChFile($params);

    //멘토 전환신청 전환상태값 변경
    public function setMentoChData($params);

    //분야 사용우무 전환
    public function setFieldStatus($params);

    //멘토 반려기록 리스트
    public function getMentoChLog($params);
    //멘토 반려기록 토탈
    public function getMentoChLogTotal($params);
}
