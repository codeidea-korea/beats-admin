<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiCoComposerServiceInterface
{
    // 공동작곡가 초대를 위한 기초 데이터
    public function getCheckEmailSetData($params);
    // 공동작곡가 초대
    public function setCoComposerInvite($params);
    // 초대이메일 인증확인
    public function getCheckEmail($params);
    // 공동작곡가 승인
    public function setCoComposer($params);
    //권리비율 등록
    public function setCopyRight($params);

    //공동작곡가 list
    public function getCoComposer($params);

    //대표작곡가 권리비율 정보
    public function getMainCopyRight($params);

    //공동작곡가 초대 리스트
    public function inviteList($params);

    public function inviteList2($params);

    //공동작곡가 초대 삭제
    public function inviteDel($params);

    //공동작곡가 권한 해지 신청
    public function cancellation($params);

    //공동작곡가 권한 해지 선택 (Y/N)
    public function cancelDecision($params);

    //공동작곡가 권한 해지 확인 및 마무리
    public function coComposerDel($params);

}
