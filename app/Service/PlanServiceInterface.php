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

}
