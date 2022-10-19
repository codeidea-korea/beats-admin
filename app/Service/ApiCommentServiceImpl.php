<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

class ApiCommentServiceImpl extends DBConnection  implements ApiCommentServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    //피드 리스트
    public function getCommentList($params) {

        $result = $this->statDB->table('comment')
            ->leftJoin('member_data', 'comment.mem_id', '=', 'member_data.mem_id')
            ->select(
                'comment.idx'
            )
            ->where('wr_idx', $params['wr_idx'])
            ->where('wr_type', $params['wr_type'])
            ->where('cm_main', 1)
            ->orderby('cm_seq','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();

            $cm_idx = $result->pluck('idx');

        $result2 = $this->statDB->table('comment')
            ->leftJoin('member_data', 'comment.mem_id', '=', 'member_data.mem_id')
            ->select(
                'comment.idx',
            )
            ->whereIn('cm_idx', $cm_idx->all())
            ->get();

            $cm_idx2 = $result2->pluck('idx');

        $result3 = Arr::collapse([$cm_idx, $cm_idx2]);

        $resultData = $this->statDB->table('comment')
            ->leftJoin('member_data', 'comment.mem_id', '=', 'member_data.mem_id')
            ->select(
                'comment.idx',
                DB::raw('CASE WHEN comment.cm_idx = 0 THEN comment.idx ELSE comment.cm_idx END as sort_idx'),
                'comment.mem_id',
                'comment.cm_idx',
                'comment.dir_cm_idx',
                DB::raw('(select b.mem_nickname from comment a left join member_data b ON a.mem_id = b.mem_id where a.idx = comment.dir_cm_idx ) as dir_nickname'),
                'comment.cm_content',
                'comment.cm_depth',
                'comment.cm_open',
                'comment.cm_content',
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and is_beat = 1) as cm_bit"),
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and mem_id = {$params['mem_id']} and is_beat = 1) as like_status"),
                'comment.created_at',
                'comment.del_status',
                'member_data.mem_nickname',
            )
            ->whereIn('comment.idx', $result3)
            ->orderby('sort_idx','desc')
            ->orderby('comment.cm_depth','asc')
            ->orderby('comment.cm_seq','desc')
            ->get();

        return $resultData;

    }

    //피드 리스트
    public function getCommentDataList($params) {

        $result = $this->statDB->table('comment')
            ->leftJoin('member_data', 'comment.mem_id', '=', 'member_data.mem_id')
            ->select(
                'comment.idx',
                'comment.cm_idx',
                'comment.dir_cm_idx',
                'comment.cm_content',
                'comment.cm_depth',
                'comment.cm_open',
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and is_beat = 1) as cm_bit"),
                'comment.created_at',
                'comment.del_status',
                'member_data.mem_id as mem_idx',
                'member_data.mem_nickname',
            )
            ->where('wr_idx', $params['wr_idx'])
            ->where('wr_type', $params['wr_type'])
            ->where('cm_main', 1)
            ->orderby('cm_seq','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();

        return $result;

    }

    //피드 리스트
    public function getCommentChildList($params) {

        $result = $this->statDB->table('comment')
            ->leftJoin('member_data', 'comment.mem_id', '=', 'member_data.mem_id')
            ->select(
                'comment.idx',
                'comment.cm_idx',
                'comment.dir_cm_idx',
                'comment.cm_content',
                'comment.cm_depth',
                'comment.cm_open',
                'comment.cm_content',
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and is_beat = 1) as cm_bit"),
                'comment.created_at',
                'comment.del_status',
                'member_data.mem_nickname',
            )
            ->where('dir_cm_idx', $params['cm_idx'])
            ->orderBy('comment.created_at','desc')
            ->get();

        return $result;

    }

    public function getCommentTotal($params) {

        $result = $this->statDB->table('comment')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->where('wr_idx', $params['wr_idx'])
            ->where('wr_type', $params['wr_type'])
            ->where('cm_main', 1)
            ->first();
        return $result;

    }

    //댓글 업로드
    public function commentAdd($params)
    {
        $comment_seq = DB::table('comment')
            ->select('cm_seq')
            ->where('cm_idx', $params['cm_idx'])
            ->where('dir_cm_idx', $params['dir_cm_idx'])
            ->where('cm_depth', $params['cm_depth'])
            ->where('wr_type', $params['wr_type'])
            ->orderBy('cm_seq','desc')
            ->first();

        if(empty($comment_seq)){
            $cm_seq = 0;
        }else{
            if($comment_seq->cm_seq === null){
                $cm_seq = 0;
            }else{
                $cm_seq = $comment_seq->cm_seq + 1;
            }
        }

        $result = $this->statDB->table('comment')
            ->insert([
                'mem_id' => $params['mem_id']
                , 'wr_idx' => $params['wr_idx']
                , 'cm_idx' => $params['cm_idx']
                , 'dir_cm_idx' => $params['dir_cm_idx']
                , 'cm_main' => $params['cm_main']
                , 'cm_depth' => $params['cm_depth']
                , 'cm_seq' => $cm_seq
                , 'cm_content' => $params['cm_content']
                , 'wr_type' => $params['wr_type']
                , 'created_at' => DB::raw('now()')
            ]);

        return $result;

    }

    public function commentUpdate($params)
    {

        $result = $this->statDB->table('comment')
            ->where('idx', $params['cm_idx'])
            ->update([
                'cm_content' => $params['cm_content']
                , 'updated_at' => DB::raw('now()')
            ]);

        return $result;

    }

    public function commentDelete($params)
    {
        $result = $this->statDB->table('comment')
            ->where('idx', $params['cm_idx'])
            ->update([
                'del_status' => 'Y'
                , 'updated_at' => DB::raw('now()')
            ]);

        return $result;

    }
}
