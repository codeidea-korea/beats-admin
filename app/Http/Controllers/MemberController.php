<?php

namespace App\Http\Controllers;

use App\Service\MemberServiceImpl;
use Response;
use Illuminate\Http\Request;
use Session;

class MemberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $memberService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->memberService = new MemberServiceImpl();

        $this->middleware('auth');
    }
    public function getMemberList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD030100";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        //$sample = $this->memberService->bannerSample($params);

        //$adminList = $this->memberService->getMemberList($params);
        //$adminTotal = $this->adminAuthorityService->getAdminTotal($params);

        return view('member.memberList',[
            'params' => $params
            ,'searchData' => $params


        ]);
    }



}
