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

    // 공지사항 list
    public function getNoticeList($params);

    // 공지사항 view
    public function getNoticeView($params);

    // 이벤트 list
    public function getEventList($params);

    // 이벤트 view
    public function getEventView($params);

    //비트 추가
    public function beatAdd($params);

    //비트 삭제
    public function beatDelete($params);

}
