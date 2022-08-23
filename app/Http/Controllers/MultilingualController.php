<?php

namespace App\Http\Controllers;

use App\Service\LangManageServiceImpl;
use Response;
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


    public function menuManage($siteCode)
    {
        $params = $this->request->input();
        $params['siteCode'] = $siteCode;
        $params['menuCode'] = "AD000200";

        $beatSomeoneMenuList = $this->langManageService->getBeatSomeoneMenuList($params);
        $bybeatMenuList = $this->langManageService->getByBeatMenuList($params);

        return view('multilingual.menuManage',[
            'params' => $params
            ,'beatSomeoneMenuList' => $beatSomeoneMenuList
            ,'bybeatMenuList' => $bybeatMenuList
        ]);
    }

    public function setMenuManage(){
        $params = $this->request->input();
        $sqlParam = array();
        $result=0;

        $arDataCount = count($params['lang_kr']);

        for($i=0;$i<$arDataCount;$i++){
            $sqlParam = null;
            $sqlParam['menu_index'] = $params['menu_index'][$i];
            $sqlParam['lang_kr'] = $params['lang_kr'][$i];
            $sqlParam['lang_en'] = $params['lang_en'][$i];
            $sqlParam['lang_ch'] = $params['lang_ch'][$i];
            $sqlParam['lang_jp'] = $params['lang_jp'][$i];

            if($params['siteCode']=="01"){
                $result =  $this->langManageService->setByBeatMenuList($sqlParam);
            }elseif($params['siteCode']=="02"){
                $result =  $this->langManageService->setBeatSomeoneMenuList($sqlParam);
            }
        }
        if($result){
            return redirect('/multilingual/menuManage/'.$params['siteCode'])->with('alert', '수정되었습니다.');
        }else{
            return redirect()->back()->with('alert', '등록/수정에 실패하였습니다. \n관리자에게 문의 바랍니다.');
        }

    }

}
