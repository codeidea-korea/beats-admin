<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface FeedServiceInterface
{
    //피드 리스트
    public function getFeedList($params);
    // 피드 리스트 총 수
    public function getFeedTotal($params);
    // 피드 상세
    public function getFeedView($idx);
    //피드 비트 내역
    public function getFeedBeatView($params,$idx);
    //피드 비트 총 수
    public function getFeedBeatTotal($params,$idx);
    //피드 댓글 내역
    public function getFeedCommentView($params,$idx);
    //피드 댓글 총 수
    public function getFeedCommentTotal($params,$idx);
    //피드 파일 내역
    public function getFeedFile($idx,$feed_file_type);
    //피드 수정
    public function feedUpdate($params);
    //피드 댓글 상세
    public function getCommentDetail($params);
    //피드 노출 상태 수정
    public function commentUpdate($params);
}
