<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiPlanServiceInterface
{
    //요금제 리스트 (list)
    public function planList($params);

    //요금제 혜택 (list)
    public function planBenefits($params,$bidx);
}
