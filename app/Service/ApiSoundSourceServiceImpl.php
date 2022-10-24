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
            $cnt = count($files);
            $i=1;
            foreach($files as $fa){

                $sqlData['file_name'] = $fa->getClientOriginalName();
                $sqlData['hash_name'] = $fa->hashName();
                $sqlData['file_url'] =  $folderName;
                $fa->storeAs($folderName, $fa->hashName(), 'public');
                if($cnt==$i){
                    $result = $this->statDB->table('music_file')
                        ->insert([
                            'music_head_idx' => $sqlData['idx']
                            , 'mem_id' => $sqlData['mem_id']
                            , 'file_name' => $sqlData['file_name']
                            , 'hash_name' => $sqlData['hash_name']
                            , 'file_url' => $sqlData['file_url']
                            , 'file_no' => $i
                            , 'representative_music' => 'Y'
                        ]);

                    $last_file['file_name'] = $sqlData['file_name'];
                    $last_file['hash_name'] = $sqlData['hash_name'];
                    $last_file['file_url'] = $sqlData['file_url'];
                }else{
                    $result = $this->statDB->table('music_file')
                        ->insert([
                            'music_head_idx' => $sqlData['idx']
                            , 'mem_id' => $sqlData['mem_id']
                            , 'file_name' => $sqlData['file_name']
                            , 'hash_name' => $sqlData['hash_name']
                            , 'file_url' => $sqlData['file_url']
                            , 'representative_music' => 'N'
                        ]);
                }

                $i++;
            }
        }

        return $last_file;

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
                    ,'moddate' => DB::raw('now()')
                ]
            );
        return $result;
    }

    //음원 정보 리스트 (list) 페이징
    public function setSoundSourceListPaging($params)
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

        //생성일
        if(trim($params['sDate'])!=""&&trim($params['eDate'])!=""){
            $_where .= " AND H.crdate >= ".$params['sDate'];
            $_where .= " AND H.crdate <= ".$params['eDate'];
        }

        //진행율
        if(trim($params['sProgressRate'])!=""&&trim($params['eProgressRate'])!=""){
            $_where .= " AND H.progress_rate >= ".$params['sProgressRate'];
            $_where .= " AND H.progress_rate <= ".$params['eProgressRate'];
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
                        ,M.mem_id AS fMemId
                        ,M.mem_nickname AS fNickName
                        ,F.representative_music
                        ,F.file_name
                        ,F.file_no
                        ,F.hash_name
                        ,F.file_url
                        ,H.moddate
                        ,H.file_version
                        ,H.del_status as HeadDelStatus
                        ,H.del_date as HeadDelDate
                        ,(select count(idx) from comment where wr_type = 'soundSource' and wr_idx = H.idx) as wr_comment
                    FROM
                    music_head H LEFT JOIN music_file F ON H.idx = F.music_head_idx
                    LEFT JOIN member_data M ON F.mem_id=M.mem_id
                    WHERE
                    H.mem_id = ".$params['mem_id']."
                    AND F.representative_music = 'Y'
                    AND F.del_status = 'N'
                    AND ((H.del_date IS  NULL AND H.del_status = 'N') OR (H.del_date > NOW() AND H.del_status = 'Y'))
                    AND F.version = H.file_version
                    ".$_where."
                    ORDER BY idx desc"
                    //limit ".(($params['page']-1)*$params['limit']).",".$params['limit']
        );

        return $result;

    }

    public function setProfilePhotoList($params){

        $result = $this->statDB->select("
            SELECT
                b.mem_nickname as commentNickName
            FROM
            comment a LEFT JOIN member_data b ON a.mem_id=b.mem_id
            where a.wr_type = 'soundSource' and a.wr_idx = ".$params['idx']."
            GROUP BY b.mem_nickname
        ");
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
                        ,F.representative_music
                        ,F.file_name
                        ,F.file_no
                        ,F.hash_name
                        ,F.file_url
                        ,H.moddate
                        ,H.file_version
                        ,H.del_status as HeadDelStatus
                        ,H.del_date as HeadDelDate
                    FROM
                    music_head H LEFT JOIN music_file F ON H.idx = F.music_head_idx
                    WHERE
                    H.mem_id = ".$params['mem_id']."
                    AND F.representative_music = 'Y'
                    AND F.del_status = 'N'
                    AND ((H.del_date IS  NULL AND H.del_status = 'N') OR (H.del_date > NOW() AND H.del_status = 'Y'))
                    AND F.version = H.file_version
                    ".$_where."

                    ORDER BY idx desc"
        );

        return $result;
    }

    //음원 상세정보 (data)

    public function getSoundSourceData($params)
    {
        $result = $this->statDB->table('music_head')
            ->leftJoin('member_data', 'music_head.mem_id', '=', 'member_data.mem_id')
            ->select(
                'music_head.idx'
                ,'music_head.mem_id as  memId'
                ,'member_data.name as  memName'
                ,'music_head.file_cnt as fileCnt'
                ,'music_head.music_title as musicTitle'
                ,'music_head.play_time as playTime'
                ,'music_head.open_status as openStatus'
                ,'music_head.sales_status as salesStatus'
                ,'music_head.contract as contract'
                ,'music_head.tag'
                ,'music_head.progress_rate as progressRate'
                ,'music_head.common_composition as commonComposition'
                ,'music_head.crdate'
                ,'music_head.copyright'
                ,'music_head.moddate'
                ,'music_head.file_version'
            )
            ->where('music_head.idx',$params['music_head_idx'])
            ->first();
        return $result;
    }

    //음원 파일 정보 (data)
    public function getMusicFileList($params)
    {
        $result = $this->statDB->table('music_file')
            ->leftJoin('member_data', 'music_file.mem_id', '=', 'member_data.mem_id')
            ->select(
                'music_file.idx',
                'music_file.file_no as fileNo',
                'member_data.mem_nickname as fNickName',
                'music_file.file_name as fileName',
                'music_file.hash_name as hashName',
                'music_file.file_url as fileUrl',
                'music_file.crdate as crDate',
                'music_file.version',
                'music_file.representative_music',
                'music_file.del_status',
                'music_file.del_date',

            )
            ->where('music_file.music_head_idx',$params['music_head_idx'])
            //->where('version',$params['file_version'])
            ->orderby('version','desc')
            ->orderby('music_file.version','desc')
            ->get();

        return $result;
    }

    //공동 작곡가 (data)
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

    //음원데이터 삭제
    public function setSoundSourceDel($params){
        $result = $this->statDB->table('music_head')
            ->whereIn('idx',$params['music_head_idx'])
            ->update(
                [
                    'del_status' => 'Y'
                    ,'del_date' => $params['del_date']
                ]
            );
        return $result;
    }
    //음원파일 삭제
    public function setMusicFileDel($params){

        $result = $this->statDB->table('music_file')
            ->whereIn('idx',$params['music_file_idx'])
            ->update(
                [
                    'del_status' => 'Y'
                    ,'del_date' => $params['del_date']
                ]
            );
        return $result;
    }

    //음원데이터 전체삭제
    public function setSoundSourceDelAll($params){
        $result = $this->statDB->table('music_head')
            ->where('mem_id',$params['mem_id'])
            ->update(
                [
                    'del_status' => 'Y'
                    ,'del_date' => $params['del_date']
                ]
            );
        return $result;
    }

    //음원파일 전체삭제
    public function setMusicFileDelAll($params){

        $result = $this->statDB->table('music_file')
            ->where('music_head_idx',$params['music_head_idx'])
            ->update(
                [
                    'del_status' => 'Y'
                    ,'del_date' => $params['del_date']
                ]
            );
        return $result;
    }

    //음원데이터 삭제 취소
    public function setSoundSourceDelCancle($params){
        $result = $this->statDB->table('music_head')
            ->whereIn('idx',$params['music_head_idx'])
            ->update(
                [
                    'del_status' => 'N'
                    ,'del_date' => null
                ]
            );
        return $result;
    }

    //음원파일 삭제 취소
    public function setMusicFileDelCancle($params){

        $result = $this->statDB->table('music_file')
            ->whereIn('idx',$params['music_file_idx'])
            ->update(
                [
                    'del_status' => 'N'
                    ,'del_date' => null
                ]
            );
        return $result;
    }

    //간이계약서
    public function getContract(){
        $result = $this->statDB->table('contract')
            ->select(
                'contract.idx',
                'contract.contents',
                'contract.version',
                'contract.adminidx',
                'contract.crdate',
                'contract.start_date'
            )
            ->where('contract.start_date','<=',DB::raw('now()'))
            ->orderBy('version','desc')
            ->first();
        return $result;
    }

    // 음원 다음버전의 파일 업로드
    public function setDataUpLoad($params,$files)
    {

        $result = $this->statDB->table('music_file')
            ->select(
                DB::raw('max(version) as version_now')
            )
            ->where('music_head_idx',$params['music_head_idx'])
            ->first();

        $version_now = $result->version_now;
        $version_next = $version_now+1;


        $result = $this->statDB->table('music_file')
            ->where('music_head_idx',$params['music_head_idx'])
            //->where('version',$version_now)
            ->update(
                [
                    'representative_music' => 'N'
                ]
            );

        $sqlData['file_cnt'] = count($files);
        $sqlData['music_head_idx'] = $params['music_head_idx'];
        $sqlData['mem_id'] = $params['mem_id'];

        $folderName = '/soundSource/'.date("Y/m/d").'/';
        if($files != "" && $files !=null){
            $cnt = count($files);
            $i=1;
            foreach($files as $fa){


                $sqlData['file_name'] = $fa->getClientOriginalName();
                $sqlData['hash_name'] = $fa->hashName();
                $sqlData['file_url'] =  $folderName;

                $fa->storeAs($folderName, $fa->hashName(), 'public');

                if($cnt==$i){
                    $result = $this->statDB->table('music_file')
                        ->insert([
                            'music_head_idx' => $sqlData['music_head_idx']
                            , 'mem_id' => $sqlData['mem_id']
                            , 'file_name' => $sqlData['file_name']
                            , 'hash_name' => $sqlData['hash_name']
                            , 'file_url' => $sqlData['file_url']
                            , 'version' => $version_next
                            , 'file_no' => $i
                            , 'representative_music' => 'Y'
                        ]);
                }else{
                    $result = $this->statDB->table('music_file')
                        ->insert([
                            'music_head_idx' => $sqlData['music_head_idx']
                            , 'mem_id' => $sqlData['mem_id']
                            , 'file_name' => $sqlData['file_name']
                            , 'hash_name' => $sqlData['hash_name']
                            , 'file_url' => $sqlData['file_url']
                            , 'version' => $version_next
                            , 'file_no' => $i
                            , 'representative_music' => 'N'
                        ]);
                }

                $i++;
            }

            $result = $this->statDB->table('music_head')
                ->where('idx',$params['music_head_idx'])
                ->update(
                    [
                        'file_version' => $version_next
                        ,'moddate' => DB::raw('now()')
                    ]
                );
        }

        return $result;

    }

    // 음원 다음버전의 파일 업로드
    public function setRepresentativeMusic($params)
    {
        $this->statDB->table('music_file')
            ->where('music_head_idx',$params['music_head_idx'])
            ->update(
                [
                    'representative_music' => 'N'
                ]
            );

        $this->statDB->table('music_file')
            ->where('idx',$params['music_file_idx'])
            ->update(
                [
                    'representative_music' => 'Y'
                ]
            );

        $resultData = $this->statDB->table('music_file')
            ->select(
                'version',
            )
            ->where('idx',$params['music_file_idx'])
            ->first();


        $result = $this->statDB->table('music_head')
            ->where('idx',$params['music_head_idx'])
            ->update(
                [
                    'file_version' => $resultData->version
                ]
            );

        return $result;
    }

}
