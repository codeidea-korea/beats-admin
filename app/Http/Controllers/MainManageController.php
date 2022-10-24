<?php

namespace App\Http\Controllers;

use Response;
use App\Service\MainManageServiceImpl;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Session;

class MainManageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $adminMainmanageService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->adminMainmanageService = new MainManageServiceImpl();

        $this->middleware('auth');
    }

    public function getBannerList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD020100";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['banner_type'] = $params['banner_type'] ?? '';
        $bannerList = $this->adminMainmanageService->getBannerList($params);
        $bannerTotal = $this->adminMainmanageService->getBannerTotal();
        $totalCount = $bannerTotal->cnt;
        $params['totalCnt'] = $totalCount;
        return view('mainManage.bannerlist',[
            'params' => $params
            ,'searchData' => $params
            ,'bannerList' => $bannerList
            ,'bannerTotal' => $bannerTotal
            ,'totalCount' => $totalCount
        ]);
    }
    
    public function getBannerView($banner_code)
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD020100";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        //왼쪽은 화면에서 보여주기 위한 변수 실제 검색할때는 오른쪽 값이 쓰인다
        $params['search_contents'] = $params['s_contents'] ?? '';
        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['created_at'] = $params['created_at'] ?? "2022-01-01 - ".date("Y-m-d");
        if($params['created_at'] != ''){
            $atexplode = explode(' - ',$params['created_at']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = date("Y-m-d",strtotime($atexplode[1].' +1 days'));
        }
        $bannerData = $this->adminMainmanageService->getBannerView($params, $banner_code);
        $bannerDataList = $this->adminMainmanageService->getBannerDataList($params, $banner_code);
        $bannerDataTotal = $this->adminMainmanageService->getBannerDataTotal($params, $banner_code);
        $totalCount = $bannerDataTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('mainManage.bannerview',[
            'bannerData' => $bannerData
            ,'params' => $params
            ,'searchData' => $params
            ,'bannerDataList' => $bannerDataList
            ,'bannerDataTotal' => $bannerDataTotal
            ,'totalCount' => $totalCount
        ]);
    }

    public function BannerAdd()
    {
        $params = $this->request->input();
        $file = $this->request->file('banner_img');
        $bannercode = $this->adminMainmanageService->BannerAdd($params,$file);

        if($bannercode == "fails"){
            return redirect()->back()->with('alert', '등록/수정에 실패하였습니다. \n관리자에게 문의 바랍니다.');
        }else{
            return redirect('/mainmanage/banner/view/'.$bannercode);
        }
    }

    public function BannerUpdate()
    {
        $params = $this->request->input();
        $file = $this->request->file('up_banner_img');
        $bannercode = $this->adminMainmanageService->BannerUpdate($params,$file);

        if($bannercode == "fails"){
            return redirect()->back()->with('alert', '등록/수정에 실패하였습니다. \n관리자에게 문의 바랍니다.');
        }else{
            return redirect('/mainmanage/banner/view/'.$bannercode);
        }
    }

    public function SeqChange()
    {
        $params = $this->request->input();
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        //왼쪽은 화면에서 보여주기 위한 변수 실제 검색할때는 오른쪽 값이 쓰인다
        $params['search_contents'] = $params['s_contents'] ?? '';
        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['created_at'] = $params['created_at'] ?? "2022-01-01 - ".date("Y-m-d");
        if($params['created_at'] != ''){
            $atexplode = explode(' - ',$params['created_at']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = date("Y-m-d",strtotime($atexplode[1].' +1 days'));
        }
        $bannerdata = $this->adminMainmanageService->SeqChange($params);

        return $bannerdata;
    }

    public function SelectDelete()
    {
        $params = $this->request->input();
        $bannerdata = $this->adminMainmanageService->SelectDelete($params);

        $result = "SUCCESS";

        if($bannerdata == 0){
            $result = "컨텐츠 삭제에 실패하였습니다. 다시 시도해주세요";
        }

        return json_encode($result);
    }

    public function getPopupList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD020200";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        //왼쪽은 화면에서 보여주기 위한 변수 실제 검색할때는 오른쪽 값이 쓰인다
        $params['search_type'] = $params['popup_type'] ?? '';
        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['search_isuse'] = $params['isuse'] ?? '';
        $params['created_at'] = $params['created_at'] ?? "2022-01-01 - ".date("Y-m-d");
        if($params['created_at'] != ''){
            $atexplode = explode(' - ',$params['created_at']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = date("Y-m-d",strtotime($atexplode[1].' +1 days'));
        }
        $popupList = $this->adminMainmanageService->getPopupList($params);
        $popupTotal = $this->adminMainmanageService->getPopupTotal($params);
        $totalCount = $popupTotal->cnt;
        $params['totalCnt'] = $totalCount;
        return view('mainManage.popupList',[
            'params' => $params
            ,'searchData' => $params
            ,'popupList' => $popupList
            ,'popupTotal' => $popupTotal
            ,'totalCount' => $totalCount
        ]);
    }
    
    public function getPopupView($pidx)
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD020200";
        $params['type'] = $params['type'] ?? 0;
        $popupData = $this->adminMainmanageService->getPopupView($params, $pidx);

        return view('mainManage.popupView',[
            'popupData' => $popupData
            ,'params' => $params
        ]);
    }

    public function PopupWrite()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD020200";
        $params['type'] = $params['type'] ?? 0;
        $popupData = $this->adminMainmanageService->getPopupTotal($params);

        return view('mainManage.popupWrite',[
            'popupData' => $popupData
            ,'params' => $params
        ]);
    }

    public function PopupAdd()
    {
        $params = $this->request->input();
        $file = $this->request->file('popup_img');
        $result = $this->adminMainmanageService->PopupAdd($params,$file);

        if($result == "fails"){
            return redirect()->back()->with('alert', '등록/수정에 실패하였습니다. \n관리자에게 문의 바랍니다.');
        }else{
            return redirect('/mainmanage/popup/view/'.$result);
        }
    }

    public function PopupUpdate()
    {
        $params = $this->request->input();
        $file = $this->request->file('popup_img');
        $result = $this->adminMainmanageService->PopupUpdate($params,$file);

        if($result == "fails"){
            return redirect()->back()->with('alert', '등록/수정에 실패하였습니다. \n관리자에게 문의 바랍니다.');
        }else{
            return redirect('/mainmanage/popup/view/'.$result);
        }
    }

    public function PopupDelete()
    {
        $params = $this->request->input();
        $popupdata = $this->adminMainmanageService->PopupDelete($params);

        $result = array(
            'result' => 'SUCCESS'
        );

        if(!$popupdata){
            $result['result'] = "팝업 삭제에 실패하였습니다. 다시 시도해주세요";
        }

        return json_encode($result);
    }
}
