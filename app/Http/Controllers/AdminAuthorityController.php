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
        $adminData = $this->adminAuthorityService->getAdminList($params);

        return view('adminAuthority.list',[
            'adminData' => $adminData
        ]);
    }
    public function getAdminView()
    {
        $params = $this->request->input();
        $params['type'] = $params['type'] ?? 0;
        $adminData = $this->adminAuthorityService->getAdminList($params);

        return view('adminAuthority.list',[
            'adminData' => $adminData
        ]);
    }
}
