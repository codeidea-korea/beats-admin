<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ApiPlanServiceImpl extends DBConnection implements ApiPlanServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }
    //요금제 리스트 (list)
    public function planList($params)
    {
        $result = $this->statDB->table('plan')
            ->select(
                'idx',
                'lang',
                'gubun',
                'name',
                'contents',
                'fee',
                'sale'
            )
            ->where('is_yn','Y')
            ->where('lang',$params['lang'])
            ->orderby('idx','desc')
            ->get();
        return $result;
    }

    //요금제 혜택 (list)
    public function planBenefits($params,$bidx)
    {
        $result = $this->statDB->table('plan_benefits')
            ->select(
                'idx',
                'plan_idx',
                'sort_no',
                'benefits',
            )
            ->where('plan_idx','=',$bidx)
            ->orderBy('sort_no','asc')
            ->get();
        return $result;
    }

}
