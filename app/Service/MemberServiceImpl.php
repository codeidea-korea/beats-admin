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
                'member_data.gubun',
                'member_data.channel',
                'member_data.nationality',
                'member_data.mem_nickname',
                'member_data.mem_sanctions',
                'member_data.mem_status',
                'member_data.mem_regdate',
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
