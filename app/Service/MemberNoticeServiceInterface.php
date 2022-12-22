<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface MemberNoticeServiceInterface
{
    // 회원 데이터
    public function setMemberNotice($params);

    //회원 닉네임
    public function getMemberNickname($params);

    //음원 이름
    public function getMusicTitle($params);

    //회원 음원
    public function getSoundSoruce($params);

    //My 알람리스트
    public function getMyNoticeList($params);

    //My 알림 확인 처리
    public function setCheckNotice($params);

    //안 읽은 알람 개수
    public function getMyNotReadCnt($params);

}
