<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface MemberServiceInterface
{

    // 회원 총수
    public function getMemberTotal($params);
    // 회원 리스트
    public function getMemberList($params);

    //셈플
    public function bannerSample();
    //포인트 지급 시 회원 리스트
    public function getPointMemberList($params);
    //포인트 회원 총수
    public function getPointMemberTotal($params);
    //포인트 보내기
    public function sendPoint($params);

}
