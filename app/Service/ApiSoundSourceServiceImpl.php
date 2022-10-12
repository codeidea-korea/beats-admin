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

    //음원 정보 리스트 (list)
    public function setSoundSourceList($params)
    {
        $_where="";
        //음원상태 및 진행율   (10단위 증가임 이에 select박스 주성 유무 문의)
        if(trim($params['progress_rate'])==""){
            $_where = "";
        }elseif($params['progress_rate']=="100"){
            $_where .= " AND H.progress_rate = '100'";
        }else{

            $_where .= " AND H.progress_rate != '100'";
        }
        //작업방식
        if(trim($params['common_composition'])==""){
            $_where .= "";
        }else{
            $_where .= " AND H.common_composition = '".$params['common_composition']."' ";
        }

        //판매상태
        if(trim($params['sales_status'])==""){
            $_where .= "";
        }else{
            $_where .= " AND H.sales_status = '".$params['sales_status']."' ";
        }

        //공개상태
        if(trim($params['open_status'])==""){
            $_where .= "";
        }else{
            $_where .= " AND H.open_status = '".$params['open_status']."' ";
        }

        //검색
        if(trim($params['search_text'])==""){
            $_where .= "";
        }else{
            $_where .= " AND ( H.tag like '%".$params['search_text']."%' or H.music_title like '%".$params['search_text']."%')";
        }


        $result = $this->statDB->select(
            "
                    SELECT
                        H.idx
                        ,H.mem_id
                        ,H.file_cnt
                        ,H.music_title
                        ,H.play_time
                        ,H.open_status
                        ,H.sales_status
                        ,H.contract
                        ,H.tag
                        ,H.progress_rate
                        ,H.common_composition
                        ,H.crdate
                        ,H.copyright
                        ,F.file_name
                        ,F.file_no
                        ,F.hash_name
                        ,F.file_url
                        ,H.moddate
                        ,H.file_version
                    FROM
                    music_head H LEFT JOIN music_file F ON H.idx = F.music_head_idx
                    WHERE
                    H.mem_id = ".$params['mem_id']."
                    ".$_where."
                    AND H.file_cnt = F.file_no
                    ORDER BY idx desc"
        );

        return $result;
    }

    //음원 상세정보 (data)
    public function setSoundSourceData($params)
    {
        $result = $this->statDB->table('music_head')
            ->select(
                'idx'
                ,'mem_id'
                ,'file_cnt'
                ,'music_title'
                ,'play_time'
                ,'open_status'
                ,'sales_status'
                ,'contract'
                ,'tag'
                ,'progress_rate'
                ,'common_composition'
                ,'crdate'
                ,'copyright'
                ,'moddate'
                ,'file_version'
            )
            ->where('idx',$params['music_head_idx'])
            ->first();
        return $result;
    }

    //음원 파일 (data)
    public function getSoundSourceData($params)
    {
        $result = $this->statDB->table('music_head')
            ->select(
                'idx'
                ,'mem_id as  memId'
                ,'file_cnt as fileCnt'
                ,'music_title as musicTitle'
                ,'play_time as playTime'
                ,'open_status as openStatus'
                ,'sales_status as salesStatus'
                ,'contract as contract'
                ,'tag'
                ,'progress_rate as progressRate'
                ,'common_composition as commonComposition'
                ,'crdate'
                ,'copyright'
                ,'moddate'
                ,'file_version'
            )
            ->where('idx',$params['music_head_idx'])
            ->first();
        return $result;
    }

    public function getMusicFileList($params)
    {
        $result = $this->statDB->table('music_file')
            ->select(
                'idx',
                'file_no as fileNo',
                'file_name as fileName',
                'hash_name as hashName',
                'file_url as fileUrl',
                'crdate as crDate',
                'version',

            )
            ->where('music_head_idx',$params['music_head_idx'])
            ->where('version',$params['file_version'])
            ->orderby('file_no','asc')
            ->get();
        return $result;
    }

    public function getCommonCompositionList($params)
    {
        $result = $this->statDB->table('music_common_composition')
            ->select(
                'cc_idx',
                'mem_id as memId',
                'cc_email as fileName',
                'cc_nickname as nickname',
                'cc_name as name',
                'cc_status as status',
            )
            ->where('music_head_idx',$params['music_head_idx'])
            ->orderby('cc_idx','desc')
            ->get();
        return $result;
    }

}
