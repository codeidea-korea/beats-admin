<?php

namespace App\Http\Controllers;

use Response;
use App\Service\AdminAuthorityServiceImpl;
use Illuminate\Http\Request;
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
        $params['menuCode'] = "AD120100";

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;

        $params['group_code'] = $params['group_code'] ?? "";
        $params['isuse'] = $params['isuse'] ?? "";
        $params['sType'] = $params['sType'] ?? "";
        $params['sWord'] = $params['sWord'] ?? "";
        $params['searchDate'] = $params['searchDate'] ?? "2022-01-01 - ".date("Y-m-d");
        $tempData = trim(str_replace('-','',$params['searchDate']));
        $params['sDate']=substr($tempData,0,8);
        $params['eDate']=substr($tempData,8,16);
        $params['eDate'] = date("Ymd",strtotime($params['eDate'].' +1 days'));
        $groupList = $this->adminAuthorityService->getAdmGroupList($params);
        $adminList = $this->adminAuthorityService->getAdminList($params);
        $adminTotal = $this->adminAuthorityService->getAdminTotal($params);
        $totalCount = $adminTotal->cnt;
        $params['totalCnt'] = $totalCount;
        return view('adminAuthority.list',[
            'params' => $params
            ,'searchData' => $params
            ,'adminList' => $adminList
            ,'adminTotal' => $adminTotal
            ,'totalCount' => $totalCount
            ,'groupList' => $groupList
        ]);
    }
    public function getAdminView()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD120100";
        $params['type'] = $params['type'] ?? 0;
        $params['id'] = $params['id'] ?? 0;
        $adminData = $this->adminAuthorityService->getAdminData($params);
        $groupList = $this->adminAuthorityService->getAdmGroupList($params);

        return view('adminAuthority.view',[
            'params' => $params,
            'adminData' => $adminData,
            'groupList' => $groupList
        ]);
    }
    public function getAdminWrite()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD120100";
        $params['type'] = $params['type'] ?? 0;
        $groupList = $this->adminAuthorityService->getAdmGroupList($params);
        return view('adminAuthority.write',[
            'params' => $params,
            'groupList' => $groupList
        ]);
    }

    public function setAdminAdd(){
        $params = $this->request->input();
        $data = array();
        $data['id'] = $params['id'];
        $data['name'] = $params['name'];
        $data['phoneno'] = $params['phoneno'];
        $data['isuse'] = $params['isuse'];
        $data['email'] = $params['email'];
        $data['password'] = $params['password'];
        $data['group_code'] = $params['group_code'];

        $result = $this->adminAuthorityService->getAdminAdd($data);

        if($result){
            $rData['result']="SUCCESS";
        }else{
            $rData['result']="FAIL";
        }
        return json_encode($rData);
    }

    public function getAdminIdCheck(){
        $params = $this->request->input();

        $result = $this->adminAuthorityService->getAdminId($params);

        return $result->cnt;
    }

    public function setChangePw(){
        $params = $this->request->input();
        $data = array();
        $data['idx'] = $params['idx'];
        $data['password'] = $params['password'];

        $result = $this->adminAuthorityService->setChangePassword($data);

        if($result){
            $rData['result']="SUCCESS";
        }else{
            $rData['result']="FAIL";
        }
        return json_encode($rData);
    }

    public function setAdminUpdate(){
        $params = $this->request->input();
        $data = array();
        $data['isuse'] = $params['isuse'];
        $data['group_code'] = $params['group_code'];
        $data['name'] = $params['name'];
        $data['idx'] = $params['idx'];
        $data['phoneno'] = $params['phoneno'];
        $data['email'] = $params['email'];

        $result = $this->adminAuthorityService->setAdminUpdate($data);

        if($result){
            $rData['result']="SUCCESS";
        }else{
            $rData['result']="FAIL";
        }
        return json_encode($rData);
    }

    public function setAdminDel(){
        $params = $this->request->input();
        $data = array();
        $data['idx'] = $params['idx'];

        $result = $this->adminAuthorityService->setAdminDelete($data);

        if($result){
            $rData['result']="SUCCESS";
        }else{
            $rData['result']="FAIL";
        }
        return json_encode($rData);
    }

    public function getAdminAuthority(){
        $params = $this->request->input();
        $params['menuCode'] = "AD120200";
        $params['group_code'] = $params['group_code'] ?? "AD000";

        $groupList = $this->adminAuthorityService->getAdmGroupList($params);

        return view('adminAuthority.authority',[
            'params' => $params
            ,'groupList' => $groupList
        ]);
    }

}
