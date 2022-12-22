<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class PlanServiceImpl extends DBConnection implements PlanServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    //요금제 리스트 (list)
    public function getPlanList($params)
    {
        $result = $this->statDB->table('plan')
            ->select(
                'idx',
                'gubun',
                'name',
                'contents',
                'fee',
                DB::raw("CASE
                WHEN is_yn = 'Y' THEN '사용'
                WHEN is_yn = 'N' THEN '미사용'
                ELSE ' - ' END AS isYnView"),
                'create_date',
                'admin_name',
                DB::raw("(select count(idx) from plan_benefits where plan_idx = plan.idx) as benefitsCnt"),
            )
            ->orderby('idx','desc')
            ->get();
        return $result;
    }

    //요금제 total (total)
    public function getPlanTotal($params)
    {
        $result = $this->statDB->table('plan')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->first();
        return $result;
    }

    //요금제 등록 (Data)
    public function setPlan($params)
    {
        $result = $this->statDB->table('plan')
            ->insertGetId([
                'name' => $params['name']
                , 'gubun' => $params['gubun']
                , 'contents' => $params['contents']
                , 'fee' => $params['fee']
                , 'is_yn' => $params['is_yn']
                , 'admin_idx' => $params['admin_idx']
                , 'admin_name' => $params['admin_name']
            ]);
        return $result;
    }


    //요금제 혜택 등록
    public function setPlanBenefits($params)
    {
        $result = $this->statDB->table('plan_benefits')
            ->insert([
                'plan_idx' => $params['plan_idx']
                , 'sort_no' => $params['sort_no']
                , 'benefits' => $params['benefits']
            ]);

        return $result;
    }

    //요금제 데이터 (Data)
    public function getPlanData($params,$bidx)
    {
        $result = $this->statDB->table('plan')
            ->select(
                'idx'
                ,'gubun'
                ,'name'
                ,'contents'
                ,'fee'
                ,'create_date'
                ,'mode_date'
                ,'is_yn'
                ,'admin_idx'
                ,'admin_name'
            )
            ->where('idx','=',$bidx)
            ->first();
        return $result;
    }

    //요금제 혜택 (list)
    public function getPlanBenefits($params,$bidx)
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

    //요금제 수정
    public function putPlan($params)
    {
        $result = $this->statDB->table('plan')
            ->where('idx',$params['idx'])
            ->update(
                [
                    'gubun'                  => $params['gubun']
                    ,'name'               => $params['name']
                    ,'contents'            => $params['contents']
                    ,'fee'            => $params['fee']
                    ,'is_yn'            => $params['is_yn']
                    ,'admin_idx'          => $params['admin_idx']
                    ,'admin_name'         => $params['admin_name']
                    ,'mode_date' => DB::raw("now()")
                ]
            );
        return $result;
    }


    //혜택 삭제
    public function delBenefits($params)
    {
        $result = $this->statDB->table('plan_benefits')
            ->where('plan_idx',$params['plan_idx'])
            ->delete();
        return $result;
    }

}
