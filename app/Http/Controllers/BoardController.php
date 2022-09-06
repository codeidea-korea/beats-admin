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
        $params['search_created_at'] = $params['created_at'] ?? '';
        $params['search_wr_open'] = $params['wr_open'] ?? '';

        if($params['search_created_at'] != ''){
            $atexplode = explode(' - ',$params['created_at']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = $atexplode[1];
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
            return redirect('/service/board/view/'.$result)->with('alert', '등록되었습니다.');
        }else{
            return redirect()->back()->with('alert', '등록/수정에 실패하였습니다. \n관리자에게 문의 바랍니다.');
        }
    }

    public function BoardUpdate()
    {
        $params = $this->request->input();
        $result = $this->adminBoardService->BoardUpdate($params);

        if($result){
            return redirect('/service/board/list')->with('alert', '수정되었습니다.');
        }else{
            return redirect()->back()->with('alert', '등록/수정에 실패하였습니다. \n관리자에게 문의 바랍니다.');
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
            $result['result'] = "컨텐츠 삭제에 실패하였습니다. 다시 시도해주세요";
        }

        return json_encode($result);
    }

    public function upload()
    {
        $file = $this->request;
        $uploaddata = $this->adminBoardService->upload($file);

        return $uploaddata;
    }
}
