<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;

class MemberServiceImpl extends DBConnection  implements MemberServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMemberData($params){
        $result = $this->statDB->table('members')
            ->leftJoin('member_data', 'members.idx', '=', 'member_data.mem_id')
            ->select(
                DB::raw("CASE
                    WHEN member_data.channel = 'apple'      THEN members.apple_key
                    WHEN member_data.channel = 'naver'      THEN members.naver_key
                    WHEN member_data.channel = 'kakao'      THEN members.kakao_key
                    WHEN member_data.channel = 'google'     THEN members.google_key
                    WHEN member_data.channel = 'facebook'   THEN members.facebook_key
                    WHEN member_data.channel = 'twitter'    THEN members.twitter_key
                    WHEN member_data.channel = 'soundcloud' THEN members.soundcloud_key
                ELSE email_id END AS uid"),
                'members.email_id',
                'member_data.mem_id',
                'member_data.name',
                'member_data.phone_number',
                'member_data.email',
                'member_data.class',
                'member_data.gubun',
                'member_data.channel',
                'member_data.nationality',
                'member_data.mem_nickname',
                'member_data.mem_sanctions',
                'member_data.mem_status',
                'member_data.mem_regdate',
                'member_data.mem_point',
                'member_data.mem_dormancy',
                'members.last_login_at',
            )
            ->where('members.idx', $params['idx'])
            ->first();
        return $result;
    }

    public function getMemberTotal($params) {

        $result = $this->statDB->table('members')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->where('isuse', 'Y')
            ->first();
        return $result;

    }

    public function getMemberList($params){
        $result = $this->statDB->table('members')
            ->leftJoin('member_data', 'members.idx', '=', 'member_data.mem_id')
            ->select(
                'member_data.mem_id',
                'member_data.name',
                'member_data.phone_number',
                'member_data.email',
                'member_data.class',
                DB::raw("CASE WHEN member_data.class = '0' THEN '휴면회원' WHEN member_data.class = '2' THEN '임시회원' WHEN member_data.class = '1' THEN '비트썸원회원' WHEN member_data.class = '3' THEN '통합회원' ELSE '미지정' END AS classValue"),
                'member_data.gubun',
                DB::raw("CASE WHEN member_data.gubun = '1' THEN '일반' WHEN member_data.gubun = '2' THEN '작곡가' WHEN member_data.gubun = '3' THEN '음원구매자' WHEN member_data.gubun = '4' THEN '멘토뮤지션' ELSE '미지정' END AS gubunValue"),
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
                DB::raw("(select codevalue from adm_code where codename = member_data.nationality limit 1) AS nati" ),
                'member_data.mem_nickname',
                'member_data.mem_sanctions',
                'member_data.mem_status',
                DB::raw("CASE
                    WHEN member_data.mem_status = '0' THEN '임시'
                    WHEN member_data.mem_status = '1' THEN '정상'
                    WHEN member_data.mem_status = '2' THEN '제재'
                ELSE ' - ' END AS statusValue"),
                'member_data.mem_regdate',
                DB::raw("CASE WHEN member_data.class = '0' THEN '휴면회원' WHEN member_data.class = '1' THEN '임시회원' WHEN member_data.class = '2' THEN '비트썸원회원' WHEN member_data.class = '3' THEN '통합회원' ELSE '미지정' END AS classValue")
            )
            ->where('members.isuse', 'Y')
            ->orderby('mem_regdate','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();
        return $result;
    }

    public function getPointMemberTotal($params) {

        $result = $this->statDB->table('members')
            ->select(DB::raw("COUNT(members.idx) AS cnt"))
            ->leftJoin('member_data', 'members.idx', '=', 'member_data.mem_id')
            ->where('members.isuse', 'Y')
            ->when(isset($params['send_member_data']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereNotIn('members.idx',  $params['send_member_data']);
                });
            })
            ->when(isset($params['class']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.class',  $params['class']);
                });
            })
            ->when(isset($params['nationality']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.nationality',  $params['nationality']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.email', 'like' , '%'.$params['search_text'].'%')
                    ->orWhere('member_data.mem_nickname', 'like' , '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('member_data.mem_regdate',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->first();
        return $result;

    }

    public function getPointMemberList($params){
        $result = $this->statDB->table('members')
            ->leftJoin('member_data', 'members.idx', '=', 'member_data.mem_id')
            ->select(
                'members.idx',
                'member_data.mem_id',
                'member_data.class',
                'member_data.email',
                'member_data.mem_nickname',
            )
            ->where('members.isuse', 'Y')
            ->when(isset($params['send_member_data']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereNotIn('members.idx',  $params['send_member_data']);
                });
            })
            ->when(isset($params['class']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.class',  $params['class']);
                });
            })
            ->when(isset($params['nationality']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.nationality',  $params['nationality']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.email', 'like' , '%'.$params['search_text'].'%')
                    ->orWhere('member_data.mem_nickname', 'like' , '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('member_data.mem_regdate',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->orderby('mem_regdate','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();
        return $result;
    }

    public function sendPoint($params) {

        // if($params['increase'] == 0){
        //     $increase = $this->statDB->table('member_data')
        //         ->whereIn('mem_id',$params['send_member'])
        //         ->increment('mem_point',$params["amount"]);
        // }else{
        //     $increase = $this->statDB->table('member_data')
        //         ->whereIn('mem_id',$params['send_member'])
        //         ->decrement('mem_point',$params["amount"]);
        // }

        $success = 0;
        $fails = 0;

        foreach($params['send_member'] as $value){
            DB::select('call INSERT_SEND_POINT(?,?,?,?,?, @result)',array($params['increase'],$params['amount'],$params['reason'],$value,auth()->user()->idx));
            $result = DB::select('select @result as result');

            if($result[0]->result == 0){
                $fails += 1;
            }else{
                $success += 1;
            }
            // $point_log = $this->statDB->table('point_log')
            // ->insert([
            //     'increase' => $params['increase'], 'amount' => $params['amount'], 'reason' => $params['reason'],
            //     'send_mem_id' => $value,'mem_id' => auth()->user()->idx, 'created_at' => \Carbon\Carbon::now(),
            // ]);
        }

        $result = array(
            'success' => $success,
            'fails' => $fails
        );

        return $result;
    }

    public function getMusicList($params){
        $result = $this->statDB->table('music_head')
            ->select(
                'music_head.idx',
                'music_head.music_title',
                'music_head.play_time',
                'music_head.open_status',
                'music_head.sales_status',
                'music_head.tag',
                'music_head.common_composition',
                'music_head.progress_rate',
                'music_head.moddate',
            )
            ->where('music_head.mem_id', $params['idx'])
            ->when(isset($params['progress_rate']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('members.progress_rate',  $params['progress_rate'] , '100');
                });
            })
            ->when(isset($params['common_composition']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('members.common_composition',  $params['common_composition']);
                });
            })
            ->when(isset($params['sales_status']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.sales_status',  $params['sales_status']);
                });
            })
            ->when(isset($params['open_status']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.open_status',  $params['open_status']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('music_head.music_title', 'like' , '%'.$params['search_text'].'%');
                });
            })
            ->orderby('crdate','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();
        return $result;
    }

    public function getMusicTotal($params) {

        $result = $this->statDB->table('music_head')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->where('music_head.mem_id', $params['idx'])
            ->when(isset($params['progress_rate']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('members.progress_rate',  $params['progress_rate'] , '100');
                });
            })
            ->when(isset($params['common_composition']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('members.common_composition',  $params['common_composition']);
                });
            })
            ->when(isset($params['sales_status']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.sales_status',  $params['sales_status']);
                });
            })
            ->when(isset($params['open_status']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.open_status',  $params['open_status']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('music_head.music_title', 'like' , '%'.$params['search_text'].'%');
                });
            })
            ->first();
        return $result;

    }

    public function bannerSample(){
        $result = $this->statDB->select(
            "SELECT
                        tb1.idx
                        ,tb1.mem_id
                        ,tb1.banner_code
                        ,tb1.banner_name
                        ,case when tb2.banner_cnt IS NULL then 0 ELSE tb2.banner_cnt END AS banner_count
                        ,tb1.downcontents
                        ,tb1.type
                        ,tb1.created_at
                    FROM
                    adm_banner tb1 LEFT JOIN
                            (
                                SELECT
                            banner_code
                            ,COUNT(banner_code) AS banner_cnt
                        FROM
                        adm_banner_data
                        GROUP BY banner_code
                    ) tb2 ON tb1.banner_code = tb2.banner_code
                    "
            );
        return $result;
    }

}
