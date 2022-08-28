<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\MemberServiceImpl;
use Illuminate\Http\Request;
use Response;
use Session;

class ApiMemberController extends Controller
{
    private $request;
    private $memberService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->memberService = new MemberServiceImpl();
    }
    public function testList()
    {
        $params = $this->request->input();

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;


        $memberList = $this->memberService->getMemberList($params);
        //$memberTotal = $this->memberService->getMemberTotal($params);
        //$totalCount = $memberTotal->cnt;
        //$params['totalCnt'] = $totalCount;


        $returnData['code']=0;
        $returnData['message']="messageSample!!";
        $returnData['response']=$memberList;
        $returnData['_token']=csrf_token();


        return json_encode($returnData);

    }
}
