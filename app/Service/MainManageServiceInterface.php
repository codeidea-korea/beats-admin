<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface MainManageServiceInterface
{
    //배너 리스트
    public function getBannerList($params);
    //하위 배너 총수
    public function getDownContents();
    //배너 총수
    public function getBannerTotal();
    //배너 상세
    public function getBannerView($params, $banner_code);
    //하위 배너 리스트
    public function getBannerDataList($params, $banner_code);
    //배너 상세 하위 배너 총수
    public function getBannerDataTotal($params, $banner_code);
    //순서 바꾸기
    public function SeqChange($params);
    //배너 등록
    public function BannerAdd($params,$file);
    //배너 수정
    public function BannerUpdate($params, $file);
    //배너 선택 삭제
    public function SelectDelete($params);
    
    //팝업 리스트
    public function getPopupList($params);
    //팝업 총수
    public function getPopupTotal();
    //팝업 상세
    public function getPopupView($params, $pidx);
    //팝업 등록
    public function PopupAdd($params,$file);
    //팝업 수정
    public function PopupUpdate($params, $file);
    //팝업 삭제
    public function PopupDelete($params);
}
