<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MentoServiceImpl extends DBConnection  implements MentoServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getFieldList($params) {

        $result = $this->statDB->table('adm_field')
            ->select(
                'idx',
                'code',
                'field_name',
                'isuse'
            )
            //->where('isuse','Y')
            ->get();

        return $result;

    }

    public function setFildUpdate($params) {

        $result = $this->statDB->table('adm_field')
            ->where('idx',$params['idx'])
            ->update([
                'code' => $params['code'],
                'field_name' => $params['field_name'],
                'moddate' =>  DB::raw('now()')
            ]);

        return $result;

    }

    public function setFildInsert($params) {

        $result = $this->statDB->table('adm_field')
            ->insert([
                'code' => $params['code']
                ,'field_name' => $params['field_name']
            ]);

        return $result;

    }

    public function getMentoChList($params) {

        $result = $this->statDB->table('members')
            ->leftJoin('member_data', 'members.idx', '=', 'member_data.mem_id')
            ->select(
                'member_data.mem_id',
                'member_data.mento_status',
                DB::raw("CASE
                    WHEN member_data.mento_status = 0 THEN ' - '
                    WHEN member_data.mento_status = 1 THEN '반려'
                    WHEN member_data.mento_status = 2 THEN '대기'
                    WHEN member_data.mento_status = 3 THEN '전환완료'
                    ELSE '미지정' END AS mentoStValue"),
                'member_data.channel',
                'member_data.gubun',
                DB::raw("CASE
                    WHEN member_data.gubun = '1' THEN '일반'
                    WHEN member_data.gubun = '2' THEN '작곡가'
                    WHEN member_data.gubun = '3' THEN '음원구매자'
                    WHEN member_data.gubun = '4' THEN '멘토뮤지션'
                    ELSE '미지정' END AS gubunValue"),
                'member_data.channel',
                DB::raw("CASE
                    WHEN member_data.channel = 'facebook' THEN '페이스북'
                    WHEN member_data.channel = 'twitter' THEN '트위터'
                    WHEN member_data.channel = 'google' THEN '구글'
                    WHEN member_data.channel = 'apple' THEN '애플'
                    WHEN member_data.channel = 'naver' THEN '네이버'
                    WHEN member_data.channel = 'kakao' THEN '카카오'
                    WHEN member_data.channel = 'soundcloud' THEN '사운드클라우드'
                    WHEN member_data.channel = 'email' THEN '직접가입'
                ELSE ' - ' END AS channelValue"),
                'member_data.nationality',
                DB::raw("(select name_kr from international_code where international_code2 = member_data.nationality limit 1) AS nati" ),
                'member_data.u_id',
                'member_data.mem_nickname',
                'member_data.mem_sanctions',
                'members.created_at',
                'member_data.mem_moddate',
                'members.email_id'
            )
            ->where('members.isuse', 'Y')
            ->whereIn('member_data.mento_status',[1,2])
            ->where('members.created_at','>=', $params['sDate'])
            ->where('members.created_at','<=', $params['eDate'])
            ->where('member_data.mem_moddate','>=', $params['sDate2'])
            ->where('member_data.mem_moddate','<=', $params['eDate2'])
            ->when($params['mento_status']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.mento_status',$params['mento_status']);
                });
            })
            ->when($params['gubun']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.gubun',$params['gubun']);
                });
            })
            ->when($params['channel']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.channel',$params['channel']);
                });
            })
            ->when($params['nationality']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.nationality',$params['nationality']);
                });
            })
            ->when($params['sWord']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->orWhere('member_data.u_id', 'like', '%' . $params['sWord'] . '%');
                    $query->orWhere('member_data.mem_nickname', 'like', '%' . $params['sWord'] . '%');
                    $query->orWhere('members.email_id', 'like', '%' . $params['sWord'] . '%');
                });
            })
            ->orderby('members.created_at','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();
        return $result;

    }

    public function getMentoChTotal($params)
    {

        $result = $this->statDB->table('members')
            ->leftJoin('member_data', 'members.idx', '=', 'member_data.mem_id')
            ->select(DB::raw("COUNT(members.idx) AS cnt"))
            ->where('members.isuse', 'Y')
            ->whereIn('member_data.mento_status',[1,2])
            ->where('members.created_at','>=', $params['sDate'])
            ->where('members.created_at','<=', $params['eDate'])
            ->where('member_data.mem_moddate','>=', $params['sDate2'])
            ->where('member_data.mem_moddate','<=', $params['eDate2'])
            ->when($params['mento_status']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.mento_status',$params['mento_status']);
                });
            })
            ->when($params['gubun']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.gubun',$params['gubun']);
                });
            })
            ->when($params['channel']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.channel',$params['channel']);
                });
            })
            ->when($params['nationality']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.nationality',$params['nationality']);
                });
            })
            ->when($params['sWord']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->orWhere('member_data.u_id', 'like', '%' . $params['sWord'] . '%');
                    $query->orWhere('member_data.mem_nickname', 'like', '%' . $params['sWord'] . '%');
                    $query->orWhere('members.email_id', 'like', '%' . $params['sWord'] . '%');
                });
            })
            ->first();
        return $result;

    }

    public function getMentoChExcelList($params) {

        $result = $this->statDB->table('members')
            ->leftJoin('member_data', 'members.idx', '=', 'member_data.mem_id')
            ->select(
                'member_data.mem_id',
                'member_data.mento_status',
                DB::raw("CASE
                    WHEN member_data.mento_status = 0 THEN ' - '
                    WHEN member_data.mento_status = 1 THEN '반려'
                    WHEN member_data.mento_status = 2 THEN '대기'
                    WHEN member_data.mento_status = 3 THEN '전환완료'
                    ELSE '미지정' END AS mentoStValue"),
                'member_data.channel',
                'member_data.gubun',
                DB::raw("CASE
                    WHEN member_data.gubun = '1' THEN '일반'
                    WHEN member_data.gubun = '2' THEN '작곡가'
                    WHEN member_data.gubun = '3' THEN '음원구매자'
                    WHEN member_data.gubun = '4' THEN '멘토뮤지션'
                    ELSE '미지정' END AS gubunValue"),
                'member_data.channel',
                DB::raw("CASE
                    WHEN member_data.channel = 'facebook' THEN '페이스북'
                    WHEN member_data.channel = 'twitter' THEN '트위터'
                    WHEN member_data.channel = 'google' THEN '구글'
                    WHEN member_data.channel = 'apple' THEN '애플'
                    WHEN member_data.channel = 'naver' THEN '네이버'
                    WHEN member_data.channel = 'kakao' THEN '카카오'
                    WHEN member_data.channel = 'soundcloud' THEN '사운드클라우드'
                    WHEN member_data.channel = 'email' THEN '직접가입'
                ELSE ' - ' END AS channelValue"),
                'member_data.nationality',
                DB::raw("(select name_kr from international_code where international_code2 = member_data.nationality limit 1) AS nati" ),
                'member_data.u_id',
                'member_data.mem_nickname',
                'member_data.mem_sanctions',
                'members.created_at',
                'member_data.mem_moddate',
            )
            ->where('members.isuse', 'Y')
            ->whereIn('member_data.mento_status',[1,2])
            ->where('members.created_at','>=', $params['sDate'])
            ->where('members.created_at','<=', $params['eDate'])
            ->where('member_data.mem_moddate','>=', $params['sDate2'])
            ->where('member_data.mem_moddate','<=', $params['eDate2'])
            ->when($params['mento_status']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.mento_status',$params['mento_status']);
                });
            })
            ->when($params['gubun']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.gubun',$params['gubun']);
                });
            })
            ->when($params['channel']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.channel',$params['channel']);
                });
            })
            ->when($params['nationality']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.nationality',$params['nationality']);
                });
            })
            ->when($params['sWord']!="", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->orWhere('member_data.u_id', 'like', '%' . $params['sWord'] . '%');
                    $query->orWhere('member_data.mem_nickname', 'like', '%' . $params['sWord'] . '%');
                    $query->orWhere('members.email_id', 'like', '%' . $params['sWord'] . '%');
                });
            })
            ->orderby('members.created_at','desc')
            ->get();
        return $result;

    }

    public function getMentoChData($params) {

        $result = $this->statDB->table('members')
            ->leftJoin('member_data', 'members.idx', '=', 'member_data.mem_id')
            ->select(
                'member_data.mem_id',
                'member_data.mento_status',
                DB::raw("CASE
                    WHEN member_data.mento_status = 0 THEN ' - '
                    WHEN member_data.mento_status = 1 THEN '반려'
                    WHEN member_data.mento_status = 2 THEN '대기'
                    WHEN member_data.mento_status = 3 THEN '승인'
                    ELSE '미지정' END AS mentoStValue"),
                'member_data.channel',
                'member_data.gubun',
                DB::raw("CASE
                    WHEN member_data.gubun = '1' THEN '일반'
                    WHEN member_data.gubun = '2' THEN '작곡가'
                    WHEN member_data.gubun = '3' THEN '음원구매자'
                    WHEN member_data.gubun = '4' THEN '멘토뮤지션'
                    ELSE '미지정' END AS gubunValue"),
                'member_data.channel',
                DB::raw("CASE
                    WHEN member_data.channel = 'facebook' THEN '페이스북'
                    WHEN member_data.channel = 'twitter' THEN '트위터'
                    WHEN member_data.channel = 'google' THEN '구글'
                    WHEN member_data.channel = 'apple' THEN '애플'
                    WHEN member_data.channel = 'naver' THEN '네이버'
                    WHEN member_data.channel = 'kakao' THEN '카카오'
                    WHEN member_data.channel = 'soundcloud' THEN '사운드클라우드'
                    WHEN member_data.channel = 'email' THEN '직접가입'
                ELSE ' - ' END AS channelValue"),
                'member_data.nationality',
                DB::raw("(select name_kr from international_code where international_code2 = member_data.nationality limit 1) AS nati" ),
                'member_data.u_id',
                'member_data.mem_nickname',
                'member_data.mem_sanctions',
                'members.created_at',
                'member_data.mem_moddate',
                'member_data.mento_reject',
                DB::raw("(select field_name from adm_field where code = member_data.field1 limit 1) AS field1Value" ),
                DB::raw("(select field_name from adm_field where code = member_data.field2 limit 1) AS field2Value" ),
                DB::raw("(select field_name from adm_field where code = member_data.field3 limit 1) AS field3Value" ),
                'member_data.field1',
                'member_data.field2',
                'member_data.field3',
                'members.email_id'
            )
            ->where('members.isuse', 'Y')
            ->where('member_data.mem_id', $params['mem_id'])

            ->first();
        return $result;

    }

    public function getMentoChFile($params) {

        $result = $this->statDB->table('mento_file')
            ->select(
                'mem_id',
                'file_name',
                'hash_name',
                'file_url',
                DB::raw("CONCAT(file_url,hash_name) AS mentoFileUrl"),
            )
            ->where('mem_id', $params['mem_id'])
            ->where('mento_ch_log_idx', 0)
            ->get();
        return $result;

    }

    public function setMentoChData($params){
        if($params['gubun']==4){
            $result = $this->statDB->table('member_data')
                ->where('mem_id',$params['mem_id'])
                ->update([
                    'mento_status' => $params['mento_status'],
                    'gubun' => $params['gubun'],
                    'memto_approvaldate' => DB::raw('now()')
                ]);

            $this->statDB->table('member_notice')
            ->insert([
                'mem_id' => $params['mem_id']
                ,'gubun' => '01'
                ,'message' => '멘토 뮤지션 전환 신청이 승인되었습니다. 프로필을 수정해 주세요!'
                ,'url' => '/mypage/profile_management'
            ]);
        }else{
            if($params['mento_status']==1){
                $result = $this->statDB->table('member_data')
                    ->where('mem_id',$params['mem_id'])
                    ->update([
                        'mento_status' => $params['mento_status'],
                        'mento_reject' => $params['reject'],
                        'memto_approvaldate' => DB::raw('now()')
                    ]);
                $result2 = $this->statDB->table('mento_ch_log')
                    ->insertGetId([
                        'mem_id' => $params['mem_id']
                        ,'field1' => $params['field1']
                        ,'field2' => $params['field2']
                        ,'field3' => $params['field3']
                        ,'mento_reject' => $params['reject']
                        ,'mento_status' => $params['mento_status']
                    ]);

                $result3 = $this->statDB->table('mento_file')
                    ->where('mem_id',$params['mem_id'])
                    ->where('mento_ch_log_idx', 0)
                    ->update([
                        'mento_ch_log_idx' => $result2,
                    ]);

                $this->statDB->table('member_notice')
                ->insert([
                    'mem_id' => $params['mem_id']
                    ,'gubun' => '01'
                    ,'message' => '멘토 뮤지션 전환 신청이 반려되었습니다.'
                ]);

            }else{
                $result = $this->statDB->table('member_data')
                    ->where('mem_id',$params['mem_id'])
                    ->update([
                        'mento_status' => $params['mento_status'],
                        'mento_reject' => $params['reject'],
                        'memto_approvaldate' => DB::raw('now()')
                    ]);
            }

        }
        return $result;
    }

    public function setFieldStatus($params) {

        $result = $this->statDB->table('adm_field')
            ->where('idx',$params['idx'])
            ->update([
                'isuse' => $params['isuse']
            ]);

        return $result;

    }

    public function getMentoChLog($params) {

        $result = $this->statDB->table('mento_ch_log')
            ->leftJoin('member_data', 'mento_ch_log.mem_id', '=', 'member_data.mem_id')
            ->leftJoin('members', 'mento_ch_log.mem_id', '=', 'members.idx')
            ->select(
                'member_data.mem_id',
                'member_data.mento_status',
                DB::raw("CASE
                    WHEN member_data.mento_status = 0 THEN ' - '
                    WHEN member_data.mento_status = 1 THEN '반려'
                    WHEN member_data.mento_status = 2 THEN '대기'
                    WHEN member_data.mento_status = 3 THEN '전환완료'
                    ELSE '미지정' END AS mentoStValue"),
                'member_data.channel',
                'member_data.gubun',
                DB::raw("CASE
                    WHEN member_data.gubun = '1' THEN '일반'
                    WHEN member_data.gubun = '2' THEN '작곡가'
                    WHEN member_data.gubun = '3' THEN '음원구매자'
                    WHEN member_data.gubun = '4' THEN '멘토뮤지션'
                    ELSE '미지정' END AS gubunValue"),
                'member_data.channel',
                DB::raw("CASE
                    WHEN member_data.channel = 'facebook' THEN '페이스북'
                    WHEN member_data.channel = 'twitter' THEN '트위터'
                    WHEN member_data.channel = 'google' THEN '구글'
                    WHEN member_data.channel = 'apple' THEN '애플'
                    WHEN member_data.channel = 'naver' THEN '네이버'
                    WHEN member_data.channel = 'kakao' THEN '카카오'
                    WHEN member_data.channel = 'soundcloud' THEN '사운드클라우드'
                    WHEN member_data.channel = 'email' THEN '직접가입'
                ELSE ' - ' END AS channelValue"),
                'member_data.nationality',
                DB::raw("(select name_kr from international_code where international_code2 = member_data.nationality limit 1) AS nati" ),
                'member_data.u_id',
                'member_data.mem_nickname',
                'member_data.mem_sanctions',
                'member_data.mem_moddate',
                'members.email_id',
                'member_data.phone_number',
                'mento_ch_log.crdate'
            )
            ->orderby('mento_ch_log.crdate','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();
        return $result;

    }

    public function getMentoChLogTotal($params) {

        $result = $this->statDB->table('mento_ch_log')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->first();
        return $result;

    }
}
