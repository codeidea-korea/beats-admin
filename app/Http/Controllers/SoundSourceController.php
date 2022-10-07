<?php

namespace App\Http\Controllers;

use App\Service\MemberServiceImpl;
use App\Service\ApiHomeServiceImpl;
use Response;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreFileRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SoundSourceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $memberService;
    private $apiHomeService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->memberService = new MemberServiceImpl();
        $this->apiHomeService = new ApiHomeServiceImpl();

        $this->middleware('auth');
    }

    public function getSoundSourceList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD060600";

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

        return view('contents.soundSource.soundSourceList',[
            'params' => $params
            ,'searchData' => $params
           //,'adminList' => $adminList
           //,'adminTotal' => $adminTotal
           //,'totalCount' => $totalCount
           //,'groupList' => $groupList
        ]);
    }

}
