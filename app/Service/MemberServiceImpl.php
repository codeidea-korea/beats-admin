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
                'member_data.phoneno',
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

        if($params['increase'] == 0){
            $increase = $this->statDB->table('member_data')
                ->whereIn('mem_id',$params['send_member'])
                ->increment('mem_point',$params["amount"]);
        }else{
            $increase = $this->statDB->table('member_data')
                ->whereIn('mem_id',$params['send_member'])
                ->decrement('mem_point',$params["amount"]);
        }

        foreach($params['send_member'] as $value){
            $point_log = $this->statDB->table('point_log')
            ->insert([
                'increase' => $params['increase'], 'amount' => $params['amount'], 'reason' => $params['reason'],
                'mem_id' => auth()->user()->idx, 'created_at' => \Carbon\Carbon::now(),
            ]);
        }

        if($point_log && $increase){
            $result = 1;
        }else{
            $result = 0;
        }

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
