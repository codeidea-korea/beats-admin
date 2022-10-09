<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiCommentServiceInterface
{

    //댓글 리스트
    public function getCommentList($params);
    
    //댓글등록
    public function commentAdd($params);

    //댓글 개수 더하기
    public function feedCommentCntAdd($params);
}
