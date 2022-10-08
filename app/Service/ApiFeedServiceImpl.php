<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ApiFeedServiceImpl extends DBConnection  implements ApiFeedServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    //피드 리스트
    public function getFeedList($params) {

        $result = $this->statDB->table('feed_board')
            ->leftJoin('member_data', 'feed_board.mem_id', '=', 'member_data.mem_id')
            ->select(
                'feed_board.idx',
                'feed_board.wr_title',
                'feed_board.wr_bit',
                'feed_board.wr_comment',
                'feed_board.wr_content',
                'feed_board.feed_source',
                DB::raw("CONCAT_WS('', '/storage', feed_board.file_url) AS file_url"),
                DB::raw("CASE WHEN feed_board.wr_type = 'daily' THEN '일상' WHEN feed_board.wr_type = 'cover' THEN '커버곡' ELSE '자작곡' END AS wr_type"),
                'member_data.mem_nickname',
            )
            ->where('feed_board.wr_open','open')
            ->when($params['sorting'] == 2, function($query) use ($params){
                return $query->orderby('feed_board.wr_bit','desc');
            })
            ->when($params['sorting'] == 3, function($query) use ($params){
                return $query->orderby('feed_board.wr_comment','desc');
            })
            ->orderby('feed_board.idx','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();
            
        return $result;

    }

    //피드 상세
    public function getFeedView($params) {

        $result = $this->statDB->table('feed_board')
            ->leftJoin('member_data', 'feed_board.mem_id', '=', 'member_data.mem_id')
            ->select(
                'feed_board.idx',
                'feed_board.mem_id',
                'feed_board.wr_title',
                'feed_board.wr_bit',
                'feed_board.wr_comment',
                'feed_board.wr_content',
                'feed_board.feed_source',
                'feed_board.created_at',
                DB::raw("CONCAT_WS('', '/storage', feed_board.file_url) AS file_url"),
                DB::raw("CASE WHEN feed_board.wr_type = 'daily' THEN '일상' WHEN feed_board.wr_type = 'cover' THEN '커버곡' ELSE '자작곡' END AS wr_type"),
                'member_data.mem_nickname',
            )
            ->where('feed_board.idx',$params['idx'])
            ->where('feed_board.wr_open','open')
            ->get();
            
        return $result;

    }

    public function getFeedFile($params) {

        $result = $this->statDB->table('feed_file')
            ->select(
                'feed_file.file_no',
                'feed_file.feed_content as wr_content',
                'feed_file.hash_name as feed_source',
                DB::raw("CONCAT_WS('', '/storage', feed_file.file_url) AS file_url"),
            )
            ->where('feed_file.feed_idx',$params['idx'])
            ->get();
            
        return $result;
    }

    //피드파일 업로드
    public function setFeedFileUpdate($params,$files)
    {

        $sqlData['file_cnt'] = count($files);
        $sqlData['idx'] = $params['feed_idx'];

        $folderName = '/feed/'.date("Y/m/d").'/';
        if($files != "" && $files !=null){
            $i=1;
            foreach($files as $fa){

                $sqlData['file_name'] = $fa->getClientOriginalName();
                $sqlData['hash_name'] = $fa->hashName();
                $sqlData['file_url'] =  $folderName;
                $fa->storeAs($folderName, $fa->hashName(), 'public');

                $result = $this->statDB->table('feed_file')
                    ->insert([
                        'feed_idx' => $sqlData['idx']
                        , 'file_name' => $sqlData['file_name']
                        , 'hash_name' => $sqlData['hash_name']
                        , 'file_url' => $sqlData['file_url']
                        , 'feed_content' => $params['feed_content'][$i]
                        , 'file_no' => $i
                    ]);
                $i++;
            }
        }

        return $result;

    }

    //피드데이터 업로드
    public function setFeedUpdate($params,$files)
    {

        if($files != ""){
            $cfilename = $files->getClientOriginalName();
            $cfilesource = $files->hashName();
            $folderName = '/feed/'.date("Y/m/d").'/';
            $files->storeAs($folderName, $files->hashName(), 'public');
            $params['feed_file'] = $cfilename;
            $params['feed_source'] = $cfilesource;
        }

        $result = $this->statDB->table('feed_board')
            ->insertGetId([
                'mem_id' => $params['mem_id']
                , 'wr_title' => $params['wr_title']
                , 'wr_content' => $params['feed_content'][0]
                , 'wr_open' => 'open'
                , 'wr_type' => $params['wr_type']
                , 'wr_file' => $params['wr_file']
                , 'feed_source' => $params['feed_source']
                , 'feed_file' => $params['feed_file']
                , 'file_url' => $folderName
                , 'created_at' => \Carbon\Carbon::now()
            ]);

        return $result;
    }


}
