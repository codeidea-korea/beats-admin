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
    
    public function getBannerView($banner_code)
    {
        $params = $this->request->input();
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $bannerData = $this->adminMainmanageService->getBannerView($params, $banner_code);
        $bannerDataList = $this->adminMainmanageService->getBannerDataList($params, $banner_code);
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
        $file = $this->request->file('banner_img');
        $bannercode = $this->adminMainmanageService->BannerAdd($params,$file);

        return redirect('/mainmanage/banner/view/'.$bannercode);
    }
}
