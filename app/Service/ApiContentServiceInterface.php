<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiContentServiceInterface
{

    //리뷰 리스트
    public function getReviewList($params);

    //리뷰 활동내역 리스트
    public function getMyReviewList($params);

    //리뷰 상세
    public function getReviewView($params);

    //리뷰 댓글 프로필
    public function setProfilePhotoList($params);

    public function getReviewFile($params);

    //리뷰 삭제
    public function reviewDelete($params);
    
    //리뷰등록 1step
    public function setReviewFileUpdate($params,$files);

    //리뷰데이터 업로드
    public function setReviewUpdate($params,$files);

    //리뷰 데이터 수정
    public function reviewUpdate($params,$files);

    //리뷰 데이터 수정
    public function reviewFileUpdate($params,$files);
}
