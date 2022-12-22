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

    //메인 팝업
    public function getPopup($params);

    //약관 샘플 적용날짜 리스트
    public function getTermsApplyData($params);

    //약관 내용
    public function getTermsContent($params);

    //트렌드 리스트
    public function getTrendList($params);

    //트렌드 상세
    public function getTrendView($params);

    //트렌드 리스트 총 수
    public function getTrendTotal($params);

    //트렌드 조회수 업
    public function setTrendHitAdd($params);


}
