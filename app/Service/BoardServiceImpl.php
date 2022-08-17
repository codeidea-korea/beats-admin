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
            ->leftJoin('members', 'notice_board.mem_id', '=', 'members.id')
            ->select(
                'notice_board.idx',
                'notice_board.mem_id',
                'notice_board.wr_title',
                'notice_board.wr_content',
                'notice_board.wr_hit',
                'notice_board.wr_comment',
                'notice_board.wr_bit',
                'notice_board.wr_report',
                'notice_board.wr_open',
                'notice_board.wr_file',
                'notice_board.created_at',
                'members.name',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->orderby('created_at','desc')
           // ->groupBy('name')
            ->get();
        return $result;

    }

    public function getBoardView($params, $bidx) {

        $result = $this->statDB->table('notice_board')
            ->leftJoin('members', 'notice_board.mem_id', '=', 'members.id')
            ->select(
                'notice_board.idx',
                'notice_board.mem_id',
                'notice_board.wr_title',
                'notice_board.wr_content',
                'notice_board.wr_hit',
                'notice_board.wr_comment',
                'notice_board.wr_bit',
                'notice_board.wr_report',
                'notice_board.wr_open',
                'notice_board.wr_file',
                'notice_board.created_at',
                'members.name',
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
                'mem_id' => auth()->user()->id, 'created_at' => \Carbon\Carbon::now(),
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
