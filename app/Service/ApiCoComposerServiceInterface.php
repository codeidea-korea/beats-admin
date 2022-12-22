<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiCoComposerServiceInterface
{
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

}
