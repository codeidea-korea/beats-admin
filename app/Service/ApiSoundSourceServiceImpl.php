<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ApiSoundSourceServiceImpl extends DBConnection  implements ApiSoundSourceServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    //음원파일 업로드
    public function setSoundFileUpdate($params,$files)
    {

        $sqlData['file_cnt'] = count($files);
        $sqlData['mem_id'] = $params['mem_id'];
        $sqlData['idx'] = $params['idx'];

        $folderName = '/soundSource/'.date("Y/m/d").'/';
        if($files != "" && $files !=null){
            $i=1;
            foreach($files as $fa){

                $sqlData['file_name'] = $fa->getClientOriginalName();
                $sqlData['hash_name'] = $fa->hashName();
                $sqlData['file_url'] =  $folderName;
                $fa->storeAs($folderName, $fa->hashName(), 'public');

                $result = $this->statDB->table('music_file')
                    ->insert([
                        'music_head_idx' => $sqlData['idx']
                        , 'file_name' => $sqlData['file_name']
                        , 'hash_name' => $sqlData['hash_name']
                        , 'file_url' => $sqlData['file_url']
                        , 'file_no' => $i
                    ]);
                $i++;
            }
        }

        return $result;

    }

    //음원데이터 업로드
    public function setDataUpdate($params,$files)
    {

        $sqlData = array();
        $sqlData['file_cnt'] = count($files);
        $sqlData['mem_id'] = $params['mem_id'];

        $result = $this->statDB->table('music_head')
            ->insertGetId([
                'mem_id' => $sqlData['mem_id']
                , 'file_cnt' => $sqlData['file_cnt']
            ]);
        $sqlData['idx']=$result;

        return $sqlData;
    }

    //음원 정보 업로드 (상세정보)
    public function setSoundDataUpdate($params)
    {
        //var_dump($params);exit();
        $result = $this->statDB->table('music_head')
            ->where('idx',$params['music_head_idx'])
            ->update(
                [
                    'music_title' => $params['music_title']
                    ,'progress_rate' => $params['progress_rate']
                    ,'sales_status' => $params['sales_status']
                    ,'open_status' => $params['open_status']
                    ,'tag' => $params['tag']
                    ,'common_composition' => $params['common_composition']
                    ,'contract' => $params['contract']
                    ,'moddate' => \Carbon\Carbon::now()
                ]
            );
        return $result;
    }

}
