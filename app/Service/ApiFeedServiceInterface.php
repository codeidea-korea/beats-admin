<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiFeedServiceInterface
{

    //피드 리스트
    public function getFeedList($params);

    //피드 상세
    public function getFeedView($params);

    public function getFeedFile($params);

    //피드 삭제
    public function feedDelete($params);
    
    //피드등록 1step
    public function setFeedFileUpdate($params,$files);

    //피드데이터 업로드
    public function setFeedUpdate($params,$files);

    //피드 데이터 수정
    public function feedUpdate($params,$files);

    //피드 데이터 수정
    public function feedFileUpdate($params,$files);
}
