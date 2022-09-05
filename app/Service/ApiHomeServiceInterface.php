<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiHomeServiceInterface
{
    // 언어 list
    public function getLangList();

    // 메뉴 list
    public function getMenuList($params);

}
