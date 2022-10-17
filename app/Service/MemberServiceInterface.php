<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface MemberServiceInterface
{
    // 회원 데이터
    public function getMemberData($params);
    // 회원 총수
    public function getMemberTotal($params);
    // 회원 리스트
    public function getMemberList($params);
    //포인트 회원 총수
    public function getPointMemberTotal($params);
    //포인트 지급 시 회원 리스트
    public function getPointMemberList($params);
    //포인트 보내기
    public function sendPoint($params);
    //음원리스트 보내기
    public function getMusicList($params);
    //음원 총수
    public function getMusicTotal($params);
    //회원정보 수정
    public function setMemberUpdate($params);

    //셈플
    public function bannerSample();

    //메모 list
    public function getMemoList($params);

    //메모 total
    public function getMemoTotal($params);

    //메모 등록
    public function setMemoInsert($params);
}
