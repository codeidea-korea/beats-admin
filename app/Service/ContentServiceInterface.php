<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ContentServiceInterface
{
    //피드 리스트
    public function getReviewList($params);
    // 피드 리스트 총 수
    public function getReviewTotal($params);
    // 피드 상세
    public function getReviewView($idx);
    //피드 비트 내역
    public function getReviewBeatView($params,$idx);
    //피드 비트 총 수
    public function getReviewBeatTotal($params,$idx);
    //피드 댓글 내역
    public function getReviewCommentView($params,$idx);
    //피드 댓글 총 수
    public function getReviewCommentTotal($params,$idx);
    //피드 파일 내역
    public function getReviewFile($idx);
    //피드 수정
    public function reviewUpdate($params);
    //피드 댓글 상세
    public function getCommentDetail($params);
    //상품 지정 리스트
    public function getProductsList($params);
    //피드 노출 상태 수정
    public function commentUpdate($params);
}
