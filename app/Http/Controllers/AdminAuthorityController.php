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

}
