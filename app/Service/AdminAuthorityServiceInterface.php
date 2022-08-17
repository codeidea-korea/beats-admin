<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface AdminAuthorityServiceInterface
{
    // 관리자 그룹코드 리스트
    public function getAdmGroupList($params);

    // 관리자 리스트
    public function getAdminList($params);

    // 관리자 데이터
    public function getAdminData($params);

    // 관리자 등록
    public function getAdminAdd($params);
}
