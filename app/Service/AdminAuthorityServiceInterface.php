<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface AdminAuthorityServiceInterface
{
    // 메뉴 리스트
    public function getAdmMenuList();

    // 관리자 그룹코드 리스트
    public function getAdmGroupList($params);

    // 관리자 총수
    public function getAdminTotal($params);

    // 관리자 리스트
    public function getAdminList($params);

    // 관리자 데이터
    public function getAdminData($params);

    // 관리자 등록
    public function getAdminAdd($params);

    // 관리자 id 체크
    public function getAdminId($params);


}
