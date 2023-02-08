<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface PlanServiceInterface
{
    //요금제 리스트 (list)
    public function getPlanList($params);

    //요금제 total (total)
    public function getPlanTotal($params);

    //요금제 등록 (Data)
    public function setPlan($params);

    //요금제 혜택 등록
    public function setPlanBenefits($params);

    //요금제 데이터 (Data)
    public function getPlanData($params,$bidx);

    //요금제 혜택 (list)
    public function getPlanBenefits($params,$bidx);

    //요금제 수정
    public function putPlan($params);

    //혜택 삭제
    public function delBenefits($params);

    //학생 승인 신청 리스트 (list)
    public function getStudentList($params);

    //학생 승인 신청 total (total)
    public function getStudentTotal($params);

    //학생 승인 신청 첨부파일
    public function getStudentFiles($params);

    //학생 승인여부 승인 처리
    public function setStudentStatusUp($params);

    //학생 승인여부 반려 처리
    public function setStudentStatusUp2($params);

    //학생 승인 신청 리스트 엑셀 다운로드
    public function getStudentListExcel($params);

}
