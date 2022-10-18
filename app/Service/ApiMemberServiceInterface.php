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

    //회원가입 확인
    public function joinCheck($params);

    //회원가입 이메일 확인
    public function joinEmailCheck($params);

    //로그인 유지 확인
    public function loginCheck($params);

    //약관 코드 배열로 반환
    public function getTermsCode($params);

    //약관 리스트
    public function getTerms($params);


    //고유 id값 체크
    public function getUidCheck($tempUid);

    //고유 id값 난수 생성
    public function getRandStr();

}
