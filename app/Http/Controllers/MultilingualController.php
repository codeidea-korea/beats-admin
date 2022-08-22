<?php

namespace App\Http\Controllers;

use Response;
use App\Service\AdminAuthorityServiceImpl;
use Illuminate\Http\Request;
use Session;

class MultilingualController extends Controller
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
    public function langManage()
    {
        $params = $this->request->input();
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        //$adminList = $this->adminAuthorityService->getAdminList($params);
        //$adminTotal = $this->adminAuthorityService->getAdminTotal($params);
        //$totalCount = $adminTotal->cnt;
        //$params['totalCnt'] = $totalCount;
        return view('multilingual.langManage',[
            'params' => $params
        ]);
    }

}
