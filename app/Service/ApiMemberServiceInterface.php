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

    //로그인 유지 확인
    public function loginCheck($params);

    //약관 코드 배열로 반환
    public function getTermsCode($params);

    //약관 리스트
    public function getTerms($params);
}
