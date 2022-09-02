<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;

class BoardServiceImpl extends DBConnection  implements BoardServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getBoardList($params) {


        $result = $this->statDB->table('notice_board')
            ->leftJoin('users', 'notice_board.mem_id', '=', 'users.idx')
            ->select(
                'notice_board.idx',
                'notice_board.mem_id',
                'notice_board.gubun',
                'notice_board.wr_title',
                'notice_board.wr_content',
                'notice_board.wr_hit',
                'notice_board.wr_comment',
                'notice_board.wr_bit',
                'notice_board.wr_report',
                'notice_board.wr_open',
                'notice_board.wr_file',
                'notice_board.created_at',
                'users.name',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->when(isset($params['gubun']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('gubun',  $params['gubun']);
                });
            })
            ->when(isset($params['wr_open']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('wr_open',  $params['wr_open']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('wr_title', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('notice_board.created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->orderby('created_at','desc')
           // ->groupBy('name')
            ->get();
        return $result;

    }

    public function getBoardTotal($params) {

        $result = $this->statDB->table('notice_board')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->when(isset($params['gubun']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('gubun',  $params['gubun']);
                });
            })
            ->when(isset($params['wr_open']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('wr_open',  $params['wr_open']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('wr_title', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->first();
        return $result;

    }

    public function getBoardView($params, $bidx) {

        $result = $this->statDB->table('notice_board')
            ->leftJoin('users', 'notice_board.mem_id', '=', 'users.idx')
            ->select(
                'notice_board.idx',
                'notice_board.mem_id',
                'notice_board.gubun',
                'notice_board.wr_title',
                'notice_board.wr_content',
                'notice_board.wr_hit',
                'notice_board.wr_comment',
                'notice_board.wr_bit',
                'notice_board.wr_report',
                'notice_board.wr_open',
                'notice_board.wr_file',
                'notice_board.created_at',
                'notice_board.updated_at',
                'users.name',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->where('notice_board.idx',$bidx)
            ->orderby('created_at','desc')
           // ->groupBy('name')
           ->get();

        return $result;

    }

    public function BoardAdd($params) {

        $result = $this->statDB->table('notice_board')
            ->insertGetId([
                'wr_title' => $params['wr_title'], 'wr_content' => $params['wr_content'], 'wr_open' => $params['wr_open'],
                'gubun' => $params['gubun'], 'mem_id' => auth()->user()->idx, 'created_at' => \Carbon\Carbon::now(),
            ]);

        return $result;

    }

    public function BoardUpdate($params) {

        $result = $this->statDB->table('notice_board')
            ->where('idx',$params['idx'])
            ->update([
                'wr_title' => $params['wr_title'], 'wr_content' => $params['wr_content'], 'wr_open' => $params['wr_open'],
                'updated_at' => \Carbon\Carbon::now()
            ]);

        return $result;

    }

    public function BoardDelete($params) {

        $result = $this->statDB->table('notice_board')->where('idx', $params['idx'])->delete();

        return $result;

    }

}
