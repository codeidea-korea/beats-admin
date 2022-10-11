<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiCommentServiceInterface
{

    //댓글 리스트
    public function getCommentList($params);

    //댓글 리스트
    public function getCommentDataList($params);

    //댓글 리스트
    public function getCommentChildList($params);
    
    //댓글등록
    public function commentAdd($params);

    //댓글수정
    public function commentUpdate($params);

    //댓글 삭제
    public function commentDelete($params);
}
