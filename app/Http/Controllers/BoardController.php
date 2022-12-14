<?php

namespace App\Http\Controllers;

use App\Service\BoardServiceImpl;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Session;

class BoardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $adminBoardService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->adminBoardService = new BoardServiceImpl();

        $this->middleware('auth');
    }

    public function getBoardList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD100300";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['search_gubun'] = $params['gubun'] ?? '';
        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['created_at'] = $params['created_at'] ?? "2022-01-01 - ".date("Y-m-d");
        $params['search_wr_open'] = $params['wr_open'] ?? '';

        if($params['created_at'] != ''){
            $atexplode = explode(' - ',$params['created_at']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = date("Y-m-d",strtotime($atexplode[1].' +1 days'));
        }

        $boardData = $this->adminBoardService->getBoardList($params);
        $boardTotal = $this->adminBoardService->getBoardTotal($params);
        $totalCount = $boardTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('service.noticeList',[
            'boardData' => $boardData
            ,'params' => $params
            ,'searchData' => $params
            ,'totalCount' => $totalCount
        ]);
    }

    public function getBoardView($bidx)
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD100300";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $boardData = $this->adminBoardService->getBoardView($params, $bidx);

        return view('service.noticeView',[
            'boardData' => $boardData
            ,'params' => $params
        ]);
    }

    public function getBoardWrite()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD100300";
        return view('service.noticeWrite',[
            'params'=> $params
        ]);
    }

    public function BoardAdd()
    {
        $params = $this->request->input();

        $result = $this->adminBoardService->BoardAdd($params);

        if($result){
            return redirect('/service/board/view/'.$result)->with('alert', '?????????????????????.');
        }else{
            return redirect()->back()->with('alert', '??????/????????? ?????????????????????. \n??????????????? ?????? ????????????.');
        }
    }

    public function BoardUpdate()
    {
        $params = $this->request->input();
        $result = $this->adminBoardService->BoardUpdate($params);

        if($result){
            return redirect('/service/board/list')->with('alert', '?????????????????????.');
        }else{
            return redirect()->back()->with('alert', '??????/????????? ?????????????????????. \n??????????????? ?????? ????????????.');
        }
    }

    public function BoardDelete()
    {
        $params = $this->request->input();
        $boardData = $this->adminBoardService->BoardDelete($params);

        $result = array(
            'result' => 'SUCCESS'
        );


        if(!$boardData){
            $result['result'] = "????????? ????????? ?????????????????????. ?????? ??????????????????";
        }

        return json_encode($result);
    }

    public function getEventList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD100200";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['created_at'] = $params['created_at'] ?? "2022-01-01 - ".date("Y-m-d");
        $params['search_open_status'] = $params['open_status'] ?? '';
        $params['search_duration_status'] = $params['duration_status'] ?? '';

        if($params['created_at'] != ''){
            $atexplode = explode(' - ',$params['created_at']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = date("Y-m-d",strtotime($atexplode[1].' +1 days'));
        }

        $eventData = $this->adminBoardService->getEventList($params);
        $eventTotal = $this->adminBoardService->getEventTotal($params);
        $totalCount = $eventTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('service.eventList',[
            'eventData' => $eventData
            ,'params' => $params
            ,'searchData' => $params
            ,'totalCount' => $totalCount
        ]);
    }

    public function getEventView($bidx)
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD100200";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $eventData = $this->adminBoardService->getEventView($params, $bidx);

        return view('service.eventView',[
            'eventData' => $eventData
            ,'params' => $params
        ]);
    }

    public function getEventWrite()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD100200";
        return view('service.eventWrite',[
            'params'=> $params
        ]);
    }

    public function EventAdd()
    {
        $params = $this->request->input();
        $file = $this->request->file('event_img');
        $result = $this->adminBoardService->EventAdd($params,$file);

        if($result){
            return redirect('/service/event/view/'.$result)->with('alert', '?????????????????????.');
        }else{
            return redirect()->back()->with('alert', '??????/????????? ?????????????????????. \n??????????????? ?????? ????????????.');
        }
    }

    public function EventUpdate()
    {
        $params = $this->request->input();
        $file = $this->request->file('event_img');
        //var_dump($params);exit();
        $result = $this->adminBoardService->EventUpdate($params,$file);

        if($result){
            return redirect('/service/event/list')->with('alert', '?????????????????????.');
        }else{
            return redirect()->back()->with('alert', '??????/????????? ?????????????????????. \n??????????????? ?????? ????????????.');
        }
    }

    public function EventDelete()
    {
        $params = $this->request->input();
        $eventData = $this->adminBoardService->EventDelete($params);

        $result = array(
            'result' => 'SUCCESS'
        );


        if(!$eventData){
            $result['result'] = "????????? ????????? ?????????????????????. ?????? ??????????????????";
        }

        return json_encode($result);
    }

    public function getTermsList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD100500";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['search_gubun'] = $params['gubun'] ?? '';
        $params['search_terms_type'] = $params['terms_type'] ?? '';
        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['apply_date'] = $params['apply_date'] ?? "2022-01-01 - ".date("Y-m-d");

        if($params['apply_date'] != ''){
            $atexplode = explode(' - ',$params['apply_date']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = date("Y-m-d",strtotime($atexplode[1].' +1 days'));
        }

        if($params['search_gubun'] != ''){
            $terms_type = $this->adminBoardService->getTermsType($params);
        }else{
            $terms_type = [];
        }

        $termsData = $this->adminBoardService->getTermsList($params);
        $termsTotal = $this->adminBoardService->getTermsTotal($params);
        $gubun = $this->adminBoardService->getGubun($params);
        $totalCount = $termsTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('service.termsList',[
            'termsData' => $termsData
            ,'terms_type' => $terms_type
            ,'gubun' => $gubun
            ,'params' => $params
            ,'searchData' => $params
            ,'totalCount' => $totalCount
        ]);
    }

    public function getTermsView($tidx)
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD100500";
        $termsData = $this->adminBoardService->getTermsView($params, $tidx);
        $gubun = $this->adminBoardService->getGubun($params);
        $terms_params['gubun'] = $termsData[0]->gubun;
        $terms_type = $this->adminBoardService->getTermsType($terms_params);

        $params2['gubun'] = $termsData[0]->gubun;
        $params2['terms_type'] = $termsData[0]->terms_type;

        $data = $this->adminBoardService->getMaxVersion($params2);
        $maxVersion =  $data->maxVersion;



        return view('service.termsView',[
            'termsData' => $termsData
            ,'gubun' => $gubun
            ,'terms_type' => $terms_type
            ,'params' => $params
            ,'maxVersion' =>$maxVersion
        ]);
    }

    public function getTermsType(){
        $params = $this->request->input();
        $termstype = $this->adminBoardService->getTermsType($params);

        return $termstype;
    }

    public function getTermsWrite()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD100500";
        $gubun = $this->adminBoardService->getGubun($params);
        return view('service.termsWrite',[
            'params'=> $params
            ,'gubun' => $gubun
        ]);
    }

    public function TermsAdd()
    {
        $params = $this->request->input();
        $params['apply_date_time'] = $params['apply_date']." ".$params['apply_date_hour'].":".$params['apply_date_hour'].":00";
        $result = $this->adminBoardService->TermsAdd($params);

        if($result){
            return redirect('/service/terms/view/'.$result)->with('alert', '?????????????????????.');
        }else{
            return redirect()->back()->with('alert', '??????/????????? ?????????????????????. \n??????????????? ?????? ????????????.');
        }
    }

    public function TermsUpdate()
    {
        $params = $this->request->input();
        $params['apply_date_time'] = $params['apply_date']." ".$params['apply_date_hour'].":".$params['apply_date_hour'].":00";
        $result = $this->adminBoardService->TermsUpdate($params);

        if($result){
            return redirect('/service/terms/list')->with('alert', '?????????????????????.');
        }else{
            return redirect()->back()->with('alert', '??????/????????? ?????????????????????. \n??????????????? ?????? ????????????.');
        }
    }

    public function TermsDelete()
    {
        $params = $this->request->input();
        $boardData = $this->adminBoardService->TermsDelete($params);

        $result = array(
            'result' => 'SUCCESS'
        );


        if(!$boardData){
            $result['result'] = "????????? ????????? ?????????????????????. ?????? ??????????????????";
        }

        return json_encode($result);
    }

    public function upload()
    {
        $file = $this->request;
        $uploaddata = $this->adminBoardService->upload($file);

        return $uploaddata;
    }


    public function getContractList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD100700";
        $params['gubun'] = $params['gubun'] ?? "02";
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['search_gubun'] = $params['gubun'] ?? '';
        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['created_at'] = $params['created_at'] ?? "2022-01-01 - ".date("Y-m-d");
        $tempData = trim(str_replace('-','',$params['created_at']));
        $params['sDate']=substr($tempData,0,8);
        $params['eDate']=substr($tempData,8,16);
        $params['eDate'] = date("Ymd",strtotime($params['eDate'].' +1 days'));


        $boardData = $this->adminBoardService->getContractList($params);
        $boardTotal = $this->adminBoardService->getContractTotal($params);
        $totalCount = $boardTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('service.contractList',[
            'boardData' => $boardData
            ,'params' => $params
            ,'searchData' => $params
            ,'totalCount' => $totalCount
        ]);
    }

    public function getContractWrite()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD100700";
        $params['gubun'] = $params['gubun'] ?? "02";
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['search_gubun'] = $params['gubun'] ?? '';
        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['created_at'] = $params['created_at'] ?? "2022-01-01 - ".date("Y-m-d");
        $tempData = trim(str_replace('-','',$params['created_at']));
        $params['sDate']=substr($tempData,0,8);
        $params['eDate']=substr($tempData,8,16);
        $params['eDate'] = date("Ymd",strtotime($params['eDate'].' +1 days'));


        $boardData = $this->adminBoardService->getContractList($params);
        $boardTotal = $this->adminBoardService->getContractTotal($params);
        $totalCount = $boardTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('service.contractWrite',[
            'params' => $params
        ]);
    }

    public function setContractAdd(){

        $params = $this->request->input();

        $params['adminidx'] = $params['adminidx'] ?? '';
        $params['version'] = $params['version'] ?? '';
        $params['contents'] = $params['contents'] ?? '';

        if($params['adminidx'] ==""||$params['version']==""||$params['editor1']==""){
            return redirect()->back()->with('alert', '????????? ????????? ????????????. \n??????????????? ?????? ????????????.');
        }

        $result = $this->adminBoardService->setContractAdd($params);


        if($result){
            return redirect('/service/contract/list')->with('alert', '?????????????????????.');
        }else{
            return redirect()->back()->with('alert', '??????/????????? ?????????????????????. \n??????????????? ?????? ????????????.');
        }
    }

    public function getContractView($idx){

        $params = $this->request->input();
        $params['menuCode'] = "AD100700";
        $data = $this->adminBoardService->getContractView($idx);

        return view('service.contractView',[
            'data' => $data
            ,'params' => $params
        ]);
    }

    public function setContractDelete(){
        $params = $this->request->input();

        $boardData = $this->adminBoardService->setContractDelete($params);

        $returnData = array(
            'result' => 'SUCCESS'
        );
        if(!$boardData){
            $returnData['result'] = "??????????????? ????????? ?????????????????????. ?????? ??????????????????";
        }

        return json_encode($returnData);
    }





}
