<?php

namespace App\Http\Controllers;

use App\Service\AdminAuthorityServiceImpl;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Session;

class AdminAuthorityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $adminAuthorityService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->adminAuthorityService = new AdminAuthorityServiceImpl();

        $this->middleware('auth');
    }
    public function getAdminList()
    {
        $params = $this->request->input();
        $params['type'] = $params['type'] ?? 0;
        $adminList = $this->adminAuthorityService->getAdminList($params);

        return view('adminAuthority.list',[
            'adminList' => $adminList
        ]);
    }
    public function getAdminView()
    {
        $params = $this->request->input();
        $params['type'] = $params['type'] ?? 0;
        $params['id'] = $params['id'] ?? 0;
        $adminData = $this->adminAuthorityService->getAdminData($params);
        $groupList = $this->adminAuthorityService->getAdmGroupList($params);

        return view('adminAuthority.view',[
            'adminData' => $adminData,
            'groupList' => $groupList
        ]);
    }
    public function getAdminWrite()
    {
        $params = $this->request->input();
        $params['type'] = $params['type'] ?? 0;
        $groupList = $this->adminAuthorityService->getAdmGroupList($params);
        return view('adminAuthority.write',[
            'params' => $params,
            'groupList' => $groupList
        ]);
    }

    public function setAdminAdd(){
        $params = $this->request->input();
        $data = [];
        var_dump($params);exit();
        $data['id'] = $params['id'];
        $data['name'] = $params['name'];
        $data['phoneno'] = $params['phoneno'];
        $data['isuse'] = $params['isuse'];
        $data['email'] = $params['email'];
        $data['password'] = $params['password'];



        $result = $this->adminAuthorityService->getAdminAdd($data);

        var_dump($result);
        exit();

        /*
        $params['adverId'] = CommonLib::getUserId();
        $data = [];

        $data['platform']['android'] = $params['platform1'];
        $data['platform']['ios'] = $params['platform2'];
        $data['platform']['web'] = $params['platform3'];
        $data['appName'] = $params['appName'];
        $data['categoryCd'] = $params['category'];
        $data['timeZoneCd'] = $params['timeZone'];
        $jsonData = json_encode($data,JSON_UNESCAPED_UNICODE);



        $settingApi = CommonLib::postCurlJson(config('api.trackingApi').'/api/v1/management/advers/'.$params['adverId'].'/apps', $jsonData, true);

        if ($settingApi['httpCode'] == 200) {
            $result = 'SUCCESS';
        } else {
            $result = 'FAIL';
        }
        */
        return array(
            'result' => $result
        ,'params' => $params
        );
    }

    public function setAdminUpdate(){
        $params = $this->request->input();
        $params['adverId'] = CommonLib::getUserId();
        $data = [];
        $data['appName'] = $params['appName'];
        $data['categoryCd'] = $params['categoryCd'];
        if($params['platform1']=="true"){
            $data['platform']['android'] = true;
        }else{
            $data['platform']['android'] = false;
        }
        if($params['platform2']=="true"){
            $data['platform']['ios'] = true;
        }else{
            $data['platform']['ios'] = false;
        }
        if($params['platform3']=="true"){
            $data['platform']['web'] = true;
        }else{
            $data['platform']['web'] = false;
        }
        $data['timeZoneCd'] = $params['timezoneCd'];
        $jsonData = json_encode($data,JSON_UNESCAPED_UNICODE);
        CommonLib::putCurlJson(config('api.trackingApi').'/api/v1/management/advers/'.$params['adverId'].'/apps/'.$params['appKey'], $jsonData);
        return array(
            'result' => 'SUCCESS'
        ,'params' => $params
        );

    }


}
