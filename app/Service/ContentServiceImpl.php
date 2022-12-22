<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ContentServiceImpl extends DBConnection  implements ContentServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getReviewList($params) {

        $result = $this->statDB->table('products_review')
            ->leftJoin('member_data','products_review.mem_id','=','member_data.mem_id')
            ->select(
                'products_review.idx',
                'products_review.wr_title',
                'products_review.wr_content',
                'products_review.wr_lng',
                'products_review.wr_open',
                'products_review.grade',
                'products_review.product_idx',
                DB::raw("(select count(idx) from beat_data where service_name = 'review' and service_idx = products_review.idx and is_beat = 1) as wr_bit"),
                DB::raw("(select count(idx) from comment where wr_type = 'review' and wr_idx = products_review.idx and del_status = 'N') as wr_comment"),
                'products_review.wr_report',
                'products_review.created_at',
                'products_review.updated_at',
                'member_data.u_id',
            )
            ->where('products_review.del_status','N')
            ->when(isset($params['wr_open']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('products_review.wr_open',  $params['wr_open']);
                });
            })
            ->when(isset($params['grade']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('products_review.grade',  $params['grade']);
                });
            })
            ->when(isset($params['wr_product']), function($query) use ($params){
                if($params['wr_product'] == 'Y'){
                    return $query->where('products_review.product_idx','!=',0);
                }else{
                    return $query->where('products_review.product_idx',0);
                }
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('products_review.wr_title', 'like', '%'.$params['search_text'].'%')
                    ->orwhere('products_review.wr_content', 'like', '%'.$params['search_text'].'%')
                    ->orwhere('member_data.u_id', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['wr_lng']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('products_review.wr_lng', $params['wr_lng']);
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('products_review.created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->orderby('products_review.created_at','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();

        return $result;

    }

    public function getReviewTotal($params) {

        $result = $this->statDB->table('products_review')
            ->leftJoin('member_data','products_review.mem_id','=','member_data.mem_id')
            ->select(DB::raw("COUNT(products_review.idx) AS cnt"))
            ->where('products_review.del_status','N')
            ->when(isset($params['wr_open']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('products_review.wr_open',  $params['wr_open']);
                });
            })
            ->when(isset($params['grade']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('products_review.grade',  $params['grade']);
                });
            })
            ->when(isset($params['wr_product']), function($query) use ($params){
                if($params['wr_product'] == 'Y'){
                    return $query->where('products_review.product_idx','!=',0);
                }else{
                    return $query->where('products_review.product_idx',0);
                }
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('products_review.wr_title', 'like', '%'.$params['search_text'].'%')
                    ->orwhere('products_review.wr_content', 'like', '%'.$params['search_text'].'%')
                    ->orwhere('member_data.u_id', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['wr_lng']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('products_review.wr_lng', $params['wr_lng']);
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('products_review.created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->first();
        return $result;

    }

    public function getReviewView($idx) {

        $result = $this->statDB->table('products_review')
            ->leftJoin('member_data','products_review.mem_id','=','member_data.mem_id')
            ->select(
                'products_review.idx',
                'products_review.mem_id',
                'products_review.wr_title',
                'products_review.wr_content',
                'products_review.wr_open',
                DB::raw("(select count(idx) from beat_data where service_name = 'review' and service_idx = products_review.idx and is_beat = 1) as wr_bit"),
                DB::raw("(select count(idx) from comment where wr_type = 'review' and wr_idx = products_review.idx and del_status = 'N') as wr_comment"),
                'products_review.wr_report',
                'products_review.wr_lng',
                'products_review.product_idx',
                'products_review.review_file',
                'products_review.review_source',
                DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',products_review.file_url,products_review.review_source) AS reviewfullUrl"),
                'products_review.file_url',
                'products_review.created_at',
                'products_review.updated_at',
                'member_data.u_id'
            )
            ->where('products_review.idx',$idx)
            ->orderby('products_review.idx','desc')
            ->get();

        return $result;

    }

    public function getReviewBeatView($params,$idx) {

        $result = $this->statDB->table('beat_data')
            ->leftJoin('member_data','beat_data.mem_id','=','member_data.mem_id')
            ->select(
                'beat_data.idx',
                'beat_data.create_date',
                'member_data.u_id',
                'member_data.mem_nickname',
                'member_data.nationality',
            )
            ->where('beat_data.service_name','review')
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

    public function getReviewBeatTotal($params,$idx) {

        $result = $this->statDB->table('beat_data')
            ->leftJoin('member_data','beat_data.mem_id','=','member_data.mem_id')
            ->select(DB::raw("COUNT(beat_data.idx) AS cnt"))
            ->where('beat_data.service_name','review')
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

    public function getReviewCommentView($params,$idx) {

        $result = $this->statDB->table('comment')
            ->leftJoin('member_data','comment.mem_id','=','member_data.mem_id')
            ->select(
                'comment.idx',
                'comment.cm_open',
                'member_data.u_id',
                'comment.cm_content',
                'comment.cm_main',
                'comment.product_idx',
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and is_beat = 1) as cm_bit"),
                'comment.created_at',
            )
            ->where('comment.wr_idx',$idx)
            ->where('comment.wr_type','review')
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

    public function getReviewCommentTotal($params,$idx) {

        $result = $this->statDB->table('comment')
            ->leftJoin('member_data','comment.mem_id','=','member_data.mem_id')
            ->select(DB::raw("COUNT(comment.idx) AS cnt"))
            ->where('comment.wr_idx',$idx)
            ->where('comment.wr_type','review')
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

    public function getReviewFile($idx) {

        $result = $this->statDB->table('products_review_file')
            ->select(
                'products_review_file.idx',
                'products_review_file.file_name',
                'products_review_file.hash_name',
                'products_review_file.file_url',
                'products_review_file.file_type',
                'products_review_file.content',
                DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',products_review_file.file_url,products_review_file.hash_name) AS reviewfullUrl"),
            )
            ->where('products_review_file.review_idx',$idx)
            ->orderby('products_review_file.file_no','asc')
            ->get();

        return $result;

    }

    public function reviewUpdate($params) {

        $result = $this->statDB->table('products_review')
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
                'comment.product_idx',
                'member_data.u_id',
            )
            ->where('comment.idx',$params['idx'])
            ->get();

        return $result;

    }

    public function getProductsList($params) {

        $result = $this->statDB->table('products')
            ->select(
                'products.idx',
                'products.name'
            )
            ->get();

        return $result;

    }

    public function commentUpdate($params) {

        $fix_comment = $this->statDB->table('comment')
        ->select('idx')
        ->where('wr_idx',$params['review_idx'])
        ->where('wr_type','review')
        ->where('product_idx','!=',0)
        ->first();

        if($fix_comment){
            $this->statDB->table('comment')
            ->where('idx',$fix_comment->idx)
            ->update([
                'product_idx' => 0, 'updated_at' => DB::raw('now()'),
            ]);
        }

        $result = $this->statDB->table('comment')
            ->where('idx',$params['idx'])
            ->update([
                'product_idx' => $params['product_idx'],'cm_open' => $params['cm_open'], 'updated_at' => DB::raw('now()'),
            ]);

        return $result;
    }
}
