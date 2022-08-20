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
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
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
            return redirect('/admin/list');
        }else{
            return redirect('/admin/write');
        }

    }

}
