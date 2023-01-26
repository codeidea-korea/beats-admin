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
                'lang',
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
                , 'lang' => $params['lang']
                , 'gubun' => $params['gubun']
                , 'contents' => $params['contents']
                , 'fee' => $params['fee']
                , 'sale' => $params['sale']
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
                ,'lang'
                ,'name'
                ,'contents'
                ,'fee'
                ,'sale'
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
                    ,'lang'               => $params['lang']
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

    //학생 승인 신청 리스트 (list)
    public function getStudentList($params)
    {
        $result = $this->statDB->table('student_authentication')
            ->leftJoin('member_data', 'student_authentication.mem_id', '=', 'member_data.mem_id')
            ->leftJoin('members', 'members.idx', '=', 'member_data.mem_id')
            ->select(
                'student_authentication.idx as sa_idx',
                DB::raw("CASE
                    WHEN student_authentication.status = 'H' THEN '대기'
                    WHEN student_authentication.status = 'Y' THEN '승인완료'
                    WHEN student_authentication.status = 'N' THEN '반려'
                    END AS statusValue"),
                'member_data.channel',
                DB::raw("CASE
                    WHEN member_data.gubun = '1' THEN '일반'
                    WHEN member_data.gubun = '2' THEN '작곡가'
                    WHEN member_data.gubun = '3' THEN '음원구매자'
                    WHEN member_data.gubun = '4' THEN '멘토뮤지션'
                    ELSE '미지정' END AS gubunValue"),
                'member_data.channel',
                'member_data.nationality',
                'members.email_id',
                'member_data.mem_nickname',
                'student_authentication.first_name',
                'student_authentication.last_name',
                'student_authentication.year',
                'student_authentication.month',
                'student_authentication.day',
                'student_authentication.send_email',
                'student_authentication.credate'
            )
            ->where('student_authentication.status','!=','Y')
            ->orderby('student_authentication.idx','desc')
            ->get();
        return $result;
    }

    //학생 승인 신청 total (total)
    public function getStudentTotal($params)
    {
        $result = $this->statDB->table('student_authentication')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->first();
        return $result;
    }

    //학생 승인여부 승인 처리
    public function setStudentStatusUp($params)
    {
        $mem_id_arr = array();
        $result = $this->statDB->table('student_authentication')
            ->select(
                'mem_id'
            )
            ->whereIn('idx',$params['idx_arr'])
            ->groupBy('mem_id')
            ->get();
        $ij=0;
        foreach($result as $rs){
            $mem_id_arr[$ij] = $rs->mem_id;
        }

        $this->statDB->table('student_authentication')
            ->whereIn('idx',$params['idx_arr'])
            ->update([
                'status' => 'Y'
                ,'mode_date' => DB::raw("now()")
            ]);

        $result2 = $this->statDB->table('member_data')
            ->whereIn('mem_id',$mem_id_arr)
            ->update([
                'student_status' => 'Y'
                ,'mem_moddate' => DB::raw("now()")
            ]);

        return $result2;
    }

    //학생 승인여부 반려 처리
    public function setStudentStatusUp2($params)
    {

        $result = $this->statDB->table('student_authentication')
            ->whereIn('idx',$params['idx_arr'])
            ->update([
                'status' => 'N'
                ,'student_reject' => $params['student_reject']
                ,'mode_date' => DB::raw("now()")
            ]);

        return $result;
    }

}
