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
                DB::raw("(select count(idx) from beat_data where service_name = 'feed' and service_idx = feed_board.idx and is_beat = 1) as wr_bit"),
                DB::raw("(select count(idx) from comment where wr_type = 'feed' and wr_idx = feed_board.idx) as wr_comment"),
                DB::raw("(select count(idx) from beat_data where service_name = 'feed' and service_idx = feed_board.idx and mem_id = {$params['mem_id']} and is_beat = 1) as like_status"),
                'feed_board.wr_content',
                'feed_board.feed_source',
                DB::raw("CONCAT_WS('', '/storage', feed_board.file_url) AS file_url"),
                DB::raw("CASE WHEN feed_board.wr_type = 'daily' THEN '일상' WHEN feed_board.wr_type = 'cover' THEN '커버곡' ELSE '자작곡' END AS wr_type"),
                'member_data.mem_nickname',
            )
            ->where('feed_board.wr_open','open')
            ->where('feed_board.del_status','N')
            ->when(isset($params['wr_type']), function($query) use ($params){
                return $query->where('wr_type',$params['wr_type']);
            })
            ->when($params['sorting'] == 2, function($query) use ($params){
                return $query->orderby('wr_bit','desc');
            })
            ->when($params['sorting'] == 3, function($query) use ($params){
                return $query->orderby('wr_comment','desc');
            })
            ->orderby('feed_board.idx','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();
            
        return $result;

    }

    public function getFeedTotal($params) {

        $result = $this->statDB->table('feed_board')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->where('feed_board.wr_open','open')
            ->where('feed_board.del_status','N')
            ->when(isset($params['wr_type']), function($query) use ($params){
                return $query->where('wr_type',$params['wr_type']);
            })
            ->first();
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
                DB::raw("(select count(idx) from beat_data where service_name = 'feed' and service_idx = feed_board.idx and is_beat = 1) as wr_bit"),
                DB::raw("(select count(idx) from comment where wr_type = 'feed' and wr_idx = feed_board.idx) as wr_comment"),
                DB::raw("(select count(idx) from beat_data where service_name = 'feed' and service_idx = feed_board.idx and mem_id = {$params['mem_id']} and is_beat = 1) as like_status"),
                'feed_board.wr_content',
                'feed_board.feed_source',
                'feed_board.created_at',
                DB::raw("CONCAT_WS('', '/storage', feed_board.file_url) AS file_url"),
                DB::raw("CASE WHEN feed_board.wr_type = 'daily' THEN '일상' WHEN feed_board.wr_type = 'cover' THEN '커버곡' ELSE '자작곡' END AS wr_type"),
                'member_data.mem_nickname',
                DB::raw('now() as now_date'),
            )
            ->where('feed_board.idx',$params['idx'])
            ->where('feed_board.wr_open','open')
            ->get();
            
        return $result;

    }

    public function getFeedFile($params) {

        $result = $this->statDB->table('feed_file')
            ->select(
                'feed_file.idx',
                'feed_file.file_no',
                'feed_file.feed_content as wr_content',
                'feed_file.hash_name as feed_source',
                DB::raw("CONCAT_WS('', '/storage', feed_file.file_url) AS file_url"),
            )
            ->where('feed_file.feed_idx',$params['idx'])
            ->get();
            
        return $result;
    }

    //피드 삭제
    public function feedDelete($params) {

        // $feed_board = DB::table('feed_board')->where('idx', $params['idx'])->first();

        // if ($feed_board->feed_file != ""){
        //     $dir = storage_path('app/public');
        //     $path = "$dir"."$feed_board->file_url"."$feed_board->feed_source";
        //     if(!File::exists($path)) { return -1; }
        //     File::delete($path);
        // }

        // $result = $this->statDB->table('feed_board')->where('idx', $params['idx'])->delete();

        $result = $this->statDB->table('feed_board')
            ->where('idx',$params['idx'])
            ->update([
                'del_status' => 'Y'
                , 'updated_at' => DB::raw('now()')
            ]);

        return $result;
    }

    public function feedFileDelete($params) {
        
        $feed_file = DB::table('feed_file')->where('feed_idx', $params['idx'])->get();

        foreach ($feed_file as $file){
            $dir = storage_path('app/public');
            $path = "$dir"."$file->file_url"."$file->hash_name";
            if(!File::exists($path)) { return -1; }
            File::delete($path);
        }

        $result = $this->statDB->table('feed_file')->where('feed_idx', $params['idx'])->delete();

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
                , 'feed_source' => $params['feed_source']
                , 'feed_file' => $params['feed_file']
                , 'file_url' => $folderName
                , 'created_at' => DB::raw('now()')
            ]);

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

    //피드데이터 수정
    public function feedUpdate($params,$files)
    {

        $feed_board = DB::table('feed_board')->where('idx', $params['feed_idx'])->first();

        if ($feed_board->feed_file != "" && $files != ""){
            $dir = storage_path('app/public');
            $path = "$dir"."$feed_board->file_url"."$feed_board->feed_source";
            if(!File::exists($path)) { return 1; }
            File::delete($path);

            $cfilename = $files->getClientOriginalName();
            $cfilesource = $files->hashName();
            $folderName = '/feed/'.date("Y/m/d").'/';
            $files->storeAs($folderName, $files->hashName(), 'public');
            $params['feed_file'] = $cfilename;
            $params['feed_source'] = $cfilesource;
            $params['file_url'] = $folderName;
        }else{
            $params['feed_file'] = $feed_board->feed_file;
            $params['feed_source'] = $feed_board->feed_source;
            $params['file_url'] = $feed_board->file_url;
        }

        $result = $this->statDB->table('feed_board')
            ->where('idx',$params['feed_idx'])
            ->update([
                'wr_content' => $params['feed_content'][0]
                , 'feed_source' => $params['feed_source']
                , 'feed_file' => $params['feed_file']
                , 'file_url' => $params['file_url']
                , 'updated_at' => DB::raw('now()')
            ]);

        return $result;
    }

    //피드데이터 수정
    public function feedFileUpdate($params,$files)
    {

        $feed_file = DB::table('feed_file')->whereIn('idx', $params['file_idx'])->get();

        if(!$feed_file->isEmpty()){
            foreach ($feed_file as $file){
                $dir = storage_path('app/public');
                $path = "$dir"."$file->file_url"."$file->hash_name";
                if(!File::exists($path)) { return -1; }
                File::delete($path);
            }
        }

        $result = DB::table('feed_file')->whereIn('idx', $params['file_idx'])->delete();

        $file_content = DB::table('feed_file')->where('feed_idx', $params['feed_idx'])->whereNotIn('idx', $params['file_idx'])->get();
        $i = 1;

        foreach($file_content as $content){
            DB::table('feed_file')->where('idx', $content->idx)
            ->update([
                'feed_content' => $params['feed_content'][$i]
                , 'file_no' => $i
            ]);
            $i++;
        }

        $sqlData['idx'] = $params['feed_idx'];

        $folderName = '/feed/'.date("Y/m/d").'/';
        if($files != "" && $files !=null){
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
}
