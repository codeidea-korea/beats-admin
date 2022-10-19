<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class FeedServiceImpl extends DBConnection  implements FeedServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getFeedList($params) {

        $result = $this->statDB->table('feed_board')
            ->leftJoin('member_data','feed_board.mem_id','=','member_data.mem_id')
            ->select(
                'feed_board.idx',
                'feed_board.wr_title',
                'feed_board.wr_type',
                'feed_board.wr_lng',
                DB::raw("(select count(idx)+1 from feed_file where feed_idx = feed_board.idx) as wr_file"),
                'feed_board.wr_open',
                DB::raw("(select count(idx) from beat_data where service_name = 'feed' and service_idx = feed_board.idx and is_beat = 1) as wr_bit"),
                DB::raw("(select count(idx) from comment where wr_type = 'feed' and wr_idx = feed_board.idx) as wr_comment"),
                'feed_board.wr_report',
                'feed_board.created_at',
                'feed_board.updated_at',
                'member_data.u_id'
            )
            ->where('feed_board.del_status','N')
            ->when(isset($params['wr_open']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('feed_board.wr_open',  $params['wr_open']);
                });
            })
            ->when(isset($params['wr_type']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('feed_board.wr_type',  $params['wr_type']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('feed_board.wr_title', 'like', '%'.$params['search_text'].'%')
                    ->orwhere('feed_board.wr_content', 'like', '%'.$params['search_text'].'%')
                    ->orwhere('member_data.u_id', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['wr_lng']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('feed_board.wr_lng', $params['wr_lng']);
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('feed_board.created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->orderby('feed_board.created_at','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();

        return $result;

    }

    public function getFeedTotal($params) {

        $result = $this->statDB->table('feed_board')
            ->leftJoin('member_data','feed_board.mem_id','=','member_data.mem_id')
            ->select(DB::raw("COUNT(feed_board.idx) AS cnt"))
            ->where('feed_board.del_status','N')
            ->when(isset($params['wr_open']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('feed_board.wr_open',  $params['wr_open']);
                });
            })
            ->when(isset($params['wr_type']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('feed_board.wr_type',  $params['wr_type']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('feed_board.wr_title', 'like', '%'.$params['search_text'].'%')
                    ->orwhere('feed_board.wr_content', 'like', '%'.$params['search_text'].'%')
                    ->orwhere('member_data.u_id', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['wr_lng']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('feed_board.wr_lng', $params['wr_lng']);
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('feed_board.created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->first();
        return $result;

    }

    public function getFeedView($idx) {

        $result = $this->statDB->table('feed_board')
            ->select(
                'feed_board.idx',
                'feed_board.mem_id',
                'feed_board.wr_title',
                'feed_board.wr_content',
                'feed_board.wr_open',
                'feed_board.wr_type',
                DB::raw("(select count(idx) from beat_data where service_name = 'feed' and service_idx = feed_board.idx and is_beat = 1) as wr_bit"),
                DB::raw("(select count(idx) from comment where wr_type = 'feed' and wr_idx = feed_board.idx) as wr_comment"),
                'feed_board.wr_report',
                'feed_board.wr_lng',
                'feed_board.feed_file',
                'feed_board.feed_source',
                'feed_board.file_url',
                'feed_board.created_at',
                'feed_board.updated_at',
                'member_data.u_id'
            )
            ->where('feed_board.idx',$idx)
            ->leftJoin('member_data','feed_board.mem_id','=','member_data.mem_id')
            ->orderby('feed_board.idx','desc')
            ->get();

        return $result;

    }

    public function getFeedBeatView($params,$idx) {

        $result = $this->statDB->table('beat_data')
            ->leftJoin('member_data','beat_data.mem_id','=','member_data.mem_id')
            ->select(
                'beat_data.idx',
                'beat_data.create_date',
                'member_data.u_id',
                'member_data.mem_nickname',
                'member_data.nationality',
            )
            ->where('beat_data.service_name','feed')
            ->where('beat_data.service_idx', $idx)
            ->when(isset($params['nationality']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.nationality',  $params['nationality']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.u_id', 'like', '%'.$params['search_text'].'%')
                    ->orwhere('member_data.mem_nickname', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('beat_data.create_date',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->orderby('beat_data.idx','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();

        return $result;

    }

    public function getFeedBeatTotal($params,$idx) {

        $result = $this->statDB->table('beat_data')
            ->leftJoin('member_data','beat_data.mem_id','=','member_data.mem_id')
            ->select(DB::raw("COUNT(beat_data.idx) AS cnt"))
            ->where('beat_data.service_name','feed')
            ->where('beat_data.service_idx', $idx)
            ->when(isset($params['nationality']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.nationality',  $params['nationality']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.u_id', 'like', '%'.$params['search_text'].'%')
                    ->orwhere('member_data.mem_nickname', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('beat_data.create_date',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->first();
        return $result;

    }

    public function getFeedCommentView($params,$idx) {

        $result = $this->statDB->table('comment')
            ->leftJoin('member_data','comment.mem_id','=','member_data.mem_id')
            ->select(
                'comment.idx',
                'comment.cm_open',
                'member_data.u_id',
                'comment.cm_content',
                'comment.cm_main',
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and is_beat = 1) as cm_bit"),
                'comment.created_at',
            )
            ->where('comment.wr_idx',$idx)
            ->when(isset($params['cm_open']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('comment.cm_open',  $params['cm_open']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.u_id', 'like', '%'.$params['search_text'].'%')
                    ->orwhere('member_data.mem_nickname', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('comment.created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->orderby('comment.idx','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();

        return $result;

    }

    public function getFeedCommentTotal($params,$idx) {

        $result = $this->statDB->table('comment')
        ->leftJoin('member_data','comment.mem_id','=','member_data.mem_id')
            ->select(DB::raw("COUNT(comment.idx) AS cnt"))
            ->where('comment.wr_idx',$idx)
            ->when(isset($params['cm_open']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('comment.cm_open',  $params['cm_open']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('member_data.u_id', 'like', '%'.$params['search_text'].'%')
                    ->orwhere('member_data.mem_nickname', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('comment.created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->first();
        return $result;

    }

    public function getFeedFile($idx) {

        $result = $this->statDB->table('feed_file')
            ->select(
                'feed_file.idx',
                'feed_file.hash_name',
                'feed_file.file_url',
                'feed_file.file_type',
                'feed_file.feed_content',
            )
            ->where('feed_file.feed_idx',$idx)
            ->orderby('feed_file.file_no','asc')
            ->get();

        return $result;

    }

    public function feedUpdate($params) {

        $result = $this->statDB->table('feed_board')
            ->where('idx',$params['idx'])
            ->update([
                'wr_open' => $params['wr_open'], 'updated_at' => DB::raw('now()'),
            ]);

        if($result > 0){
            $idx = $params['idx'];
        }else{
            $idx = "fails";
        }

        return $idx;
    }

    public function getCommentDetail($params) {

        $result = $this->statDB->table('comment')
            ->leftJoin('member_data','comment.mem_id','=','member_data.mem_id')
            ->select(
                'comment.idx',
                'comment.cm_open',
                'comment.cm_content',
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and is_beat = 1) as cm_bit"),
                'comment.created_at',
                'comment.updated_at',
                'comment.del_status',
                'member_data.mem_nickname',
            )
            ->where('comment.idx',$params['idx'])
            ->get();

        return $result;

    }

    public function commentUpdate($params) {

        $result = $this->statDB->table('comment')
            ->where('idx',$params['idx'])
            ->update([
                'cm_open' => $params['cm_open'], 'updated_at' => DB::raw('now()'),
            ]);

        return $result;
    }
}
