<?php

namespace App\Http\Controllers;

use Response;
use App\Service\MainManageServiceImpl;
use Illuminate\Http\Request;
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
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
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
    
    public function getBannerView($bidx)
    {
        $params = $this->request->input();
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $bannerData = $this->adminMainmanageService->getBannerView($params, $bidx);
        $bannerDataList = $this->adminMainmanageService->getBannerDataList($params, $bidx);
        $bannerDataTotal = $this->adminMainmanageService->getBannerDataTotal();
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
        $boardData = $this->adminBoardService->BannerAdd($params);

        if($boardData > 0){
            $data['result'] = "success";
        }else{
            $data['result'] = "등록에 실패하였습니다.다시 시도하거나 관리자에게 문의해주세요!";
        }

        return $data;
    }
}
