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

    //음원파일 업로드
    public function setFeedFileUpdate($params,$files)
    {

        $sqlData['file_cnt'] = count($files);
        $sqlData['idx'] = $params['idx'];

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

    //음원데이터 업로드
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
                , 'wr_open' => $params['wr_open']
                , 'wr_type' => $params['wr_type']
                , 'wr_file' => $params['wr_file']
                , 'feed_source' => $params['file_source']
                , 'feed_file' => $params['feed_file']
                , 'file_url' => $folderName
                , 'created_at' => \Carbon\Carbon::now()
            ]);

        return $result;
    }


}
