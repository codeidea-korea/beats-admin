<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiMemberServiceInterface
{
    // 회원정보
    public function getMemberData($params);

    // 로그인
    public function getLogin($params);

    // 로그인 토큰 등록
    public function putLogin($params);



}
