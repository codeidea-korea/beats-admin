<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiHomeServiceInterface
{
    // 언어 list
    public function getLangList();

    // 메뉴 list
    public function getMenuList($params);

    // 배너 list
    public function getBannerList($params);

    // 코드 list
    public function getCodeList($params);

}
