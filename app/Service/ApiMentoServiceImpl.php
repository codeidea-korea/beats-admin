<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiMentoServiceImpl extends DBConnection  implements ApiMentoServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getFieldList($params) {

        $result = $this->statDB->table('adm_field')
            ->select(
                'idx',
                'code',
                'field_name',
                'isuse'
            )
            ->where('isuse','Y')
            ->get();

        return $result;

    }

    public function setChMento($params) {

        $result = $this->statDB->table('member_data')
            ->where('mem_id',$params['mem_id'])
            ->update(
                [
                    'field1' => $params['field1']
                    ,'field2' => $params['field2']
                    ,'field3' => $params['field3']
                    ,'mento_status' => 2
                    ,'mem_moddate' => DB::raw('now()')
                ]
            );

        $this->statDB->table('member_notice')
        ->insert([
            'mem_id' => $params['mem_id']
            ,'gubun' => '01'
            ,'message' => '멘토 뮤지션 전환 신청이 접수되었습니다.'
        ]);

        return $result;

    }

    public function mentoFileInsert($sqlData){

        $result = $this->statDB->table('mento_file')
            ->insert([
                'mem_id' => $sqlData['mem_id']
                , 'file_name' => $sqlData['file_name']
                , 'hash_name' => $sqlData['hash_name']
                , 'file_url' => $sqlData['file_url']
            ]);

        return $result;
    }

    public function delMentoFile($params)
    {
        $result = DB::table('mento_file')->whereIn('idx', $params['file_idx'])->delete();

        return $result;
    }

    public function getIntroduction($params){
        $result = $this->statDB->table('member_data')
            ->select(
                'mem_id',
                'mento_introduction as introduction',
            )
            ->where('mem_id',$params['mem_id'])
            ->first();
        return $result;
    }

    public function setIntroduction($params){
        $result = $this->statDB->table('member_data')
            ->where('mem_id',$params['mem_id'])
            ->update(
                [
                    'mento_introduction' => $params['introduction']
                    ,'mem_moddate' => DB::raw('now()')
                ]
            );
        return $result;
    }

    public function getAlbum($params){
        $result = $this->statDB->table('member_album')
            ->select(
                'idx',
                'mem_id',
                'sort_no',
                'release_date',
                'title',
                'tag',
                DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',file_url,hash_name) AS albumCoverUrl"),

            )
            ->where('mem_id',$params['mem_id'])
            ->orderby('sort_no','asc')
            ->get();
        return $result;
    }

    public function setAlbum($params){
        $result = $this->statDB->table('member_album')
            ->insert([
                'mem_id' => $params['mem_id']
                , 'sort_no' => 0
                , 'release_date' => $params['release_date']
                , 'title' => $params['title']
                , 'tag' => $params['tag']
                , 'hash_name' => $params['hash_name']
                , 'file_url' => $params['file_url']
                , 'file_name' => $params['file_name']
            ]);

        $result2 = $this->statDB->table('member_album')
            ->where('mem_id',$params['mem_id'])
            ->update(
                [
                    'sort_no' => DB::raw('sort_no+1')
                ]
            );

        return $result2;
    }

    public function delAlbum($params){

        $result = $this->statDB->table('member_album')
            ->where('idx',$params['album_idx'])
            ->where('mem_id',$params['mem_id'])
            ->where('sort_no',$params['sort_no'])
            ->delete();

        if($result){
            $result2 = $this->statDB->table('member_album')
                ->where('mem_id',$params['mem_id'])
                ->where('sort_no','>',$params['sort_no'])
                ->update(
                    [
                        'sort_no' => DB::raw('sort_no-1')
                    ]
                );
        }


        return $result;
    }

    public function upAlbum($params){
        if($params['hash_name']==null){
            $result = $this->statDB->table('member_album')
                ->where('idx',$params['album_idx'])
                ->where('mem_id',$params['mem_id'])
                ->update([
                    'release_date' => $params['release_date']
                    , 'title' => $params['title']
                    , 'tag' => $params['tag']
                ]);
        }else{
            $result = $this->statDB->table('member_album')
                ->where('idx',$params['album_idx'])
                ->where('mem_id',$params['mem_id'])
                ->update([
                    'release_date' => $params['release_date']
                    , 'title' => $params['title']
                    , 'tag' => $params['tag']
                    , 'hash_name' => $params['hash_name']
                    , 'file_url' => $params['file_url']
                    , 'file_name' => $params['file_name']
                ]);
        }

        return $result;
    }

    public function upAllAlbum($params){
        if($params['hash_name']==null){
            $result = $this->statDB->table('member_album')
                ->where('idx',$params['album_idx'])
                ->where('mem_id',$params['mem_id'])
                ->update([
                    'release_date' => $params['release_date']
                    , 'title' => $params['title']
                    , 'tag' => $params['tag']
                    , 'sort_no' => $params['sort_idx']
                ]);
        }else{
            $result = $this->statDB->table('member_album')
                ->where('idx',$params['album_idx'])
                ->where('mem_id',$params['mem_id'])
                ->update([
                    'release_date' => $params['release_date']
                    , 'title' => $params['title']
                    , 'tag' => $params['tag']
                    , 'sort_no' => $params['sort_idx']
                    , 'hash_name' => $params['hash_name']
                    , 'file_url' => $params['file_url']
                    , 'file_name' => $params['file_name']
                ]);
        }

        return $result;
    }

    public function getTag(){
        $result = $this->statDB->table('adm_tag')
            ->select(
                'tag'
            )
            ->orderby('idx','desc')
            ->get();
        return $result;
    }

    public function getAward($params){
        $result = $this->statDB->table('member_award_history')
            ->select(
                'idx',
                'mem_id',
                'sort_no',
                'award_date',
                'title',
                'regdate'
            )
            ->where('mem_id',$params['mem_id'])
            ->orderby('sort_no','asc')
            ->get();
        return $result;
    }

    public function setAward($params){
        $result = $this->statDB->table('member_award_history')
            ->insert([
                'mem_id' => $params['mem_id']
                , 'sort_no' => 0
                , 'award_date' => $params['award_date']
                , 'title' => $params['title']
            ]);

        $result2 = $this->statDB->table('member_award_history')
            ->where('mem_id',$params['mem_id'])
            ->update(
                [
                    'sort_no' => DB::raw('sort_no+1')
                ]
            );

        return $result2;
    }

    public function delAward($params){

        $result = $this->statDB->table('member_award_history')
            ->where('idx',$params['award_idx'])
            ->where('mem_id',$params['mem_id'])
            ->where('sort_no',$params['sort_no'])
            ->delete();

        if($result){
            $result2 = $this->statDB->table('member_award_history')
                ->where('mem_id',$params['mem_id'])
                ->where('sort_no','>',$params['sort_no'])
                ->update(
                    [
                        'sort_no' => DB::raw('sort_no-1')
                    ]
                );
        }

        return $result;
    }

    public function upAward($params){

        $result = $this->statDB->table('member_award_history')
            ->where('idx',$params['award_idx'])
            ->where('mem_id',$params['mem_id'])
            ->update([
                'award_date' => $params['award_date']
                , 'title' => $params['title']
            ]);


        return $result;
    }

    public function upAllAward($params){

        $result = $this->statDB->table('member_award_history')
            ->where('idx',$params['award_idx'])
            ->where('mem_id',$params['mem_id'])
            ->update([
                'award_date' => $params['award_date']
                , 'title' => $params['title']
                , 'sort_no' => $params['sort_idx']
            ]);


        return $result;
    }

    public function getCareer($params){
        $result = $this->statDB->table('member_career')
            ->select(
                'idx',
                'mem_id',
                'sort_no',
                's_date',
                'e_date',
                'title',
                'career',
                'regdate'
            )
            ->where('mem_id',$params['mem_id'])
            ->orderby('sort_no','asc')
            ->get();
        return $result;
    }

    public function setCareer($params){
        $result = $this->statDB->table('member_career')
            ->insert([
                'mem_id' => $params['mem_id']
                , 'sort_no' => 0
                , 's_date' => $params['s_date']
                , 'e_date' => $params['e_date']
                , 'title' => $params['title']
                , 'career' => $params['career']
            ]);

        $result2 = $this->statDB->table('member_award_history')
            ->where('mem_id',$params['mem_id'])
            ->update(
                [
                    'sort_no' => DB::raw('sort_no+1')
                ]
            );

        return $result2;
    }

    public function delCareer($params){

        $result = $this->statDB->table('member_career')
            ->where('idx',$params['career_idx'])
            ->where('mem_id',$params['mem_id'])
            ->where('sort_no',$params['sort_no'])
            ->delete();

        if($result){
            $result2 = $this->statDB->table('member_career')
                ->where('mem_id',$params['mem_id'])
                ->where('sort_no','>',$params['sort_no'])
                ->update(
                    [
                        'sort_no' => DB::raw('sort_no-1')
                    ]
                );
        }

        return $result;
    }

    public function upCareer($params){

        $result = $this->statDB->table('member_career')
            ->where('idx',$params['career_idx'])
            ->where('mem_id',$params['mem_id'])
            ->update([
                's_date' => $params['s_date']
                , 'e_date' => $params['e_date']
                , 'title' => $params['title']
                , 'career' => $params['career']
            ]);


        return $result;
    }

    public function upAllCareer($params){

        $result = $this->statDB->table('member_career')
            ->where('idx',$params['career_idx'])
            ->where('mem_id',$params['mem_id'])
            ->update([
                's_date' => $params['s_date']
                , 'e_date' => $params['e_date']
                , 'title' => $params['title']
                , 'career' => $params['career']
                , 'sort_no' => $params['sort_idx']
            ]);


        return $result;
    }
}
