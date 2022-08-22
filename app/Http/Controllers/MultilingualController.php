<?php

namespace App\Http\Controllers;

use App\Service\LangManageServiceImpl;
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
        $this->langManageService = new LangManageServiceImpl();

        $this->middleware('auth');
    }
    public function langManage()
    {
        $params = $this->request->input();
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $langList = $this->langManageService->getLangList($params);
        $langTotal = $this->langManageService->getLangTotal($params);
        //$totalCount = $adminTotal->cnt;
        $params['totalCnt'] = $langTotal->cnt;
        return view('multilingual.langManage',[
            'params' => $params
            ,'langList' => $langList
        ]);
    }
    public function addLangForm(){
        $params = $this->request->input();

        return view('multilingual.ajax.addLangForm',[
            'params' => $params
        ]);
    }


    public function menuManage()
    {
        $params = $this->request->input();

        return view('multilingual.menuMange',[
            'params' => $params
        ]);
    }

}
