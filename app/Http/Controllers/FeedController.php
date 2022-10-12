<?php

namespace App\Http\Controllers;

use App\Service\FeedServiceImpl;
use Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Session;

class FeedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $adminFeedService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->adminFeedService = new FeedServiceImpl();

        $this->middleware('auth');
    }

    public function getFeedList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD060100";

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;

        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['search_created_at'] = $params['created_at'] ?? '';
        $params['search_wr_open'] = $params['wr_open'] ?? '';
        $params['search_wr_lng'] = $params['wr_lng'] ?? '';
        $params['search_wr_type'] = $params['wr_type'] ?? '';

        if($params['search_created_at'] != ''){
            $atexplode = explode(' - ',$params['created_at']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = $atexplode[1];
        }

        $feedData = $this->adminFeedService->getFeedList($params);
        $feedTotal = $this->adminFeedService->getFeedTotal($params);
        $totalCount = $feedTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('contents.feed.feedList',[
            'feedList' => $feedData
            ,'params' => $params
            ,'searchData' => $params
            ,'totalCount' => $totalCount
        ]);
    }

    public function getFeedView($idx)
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD060100";

        $feedData = $this->adminFeedService->getFeedView($idx);

        $feedFileData = $this->adminFeedService->getFeedFile($idx);
        return view('contents.feed.feedView',[
            'feedData' => $feedData
            ,'feedFileData' => $feedFileData
            ,'params' => $params
        ]);
    }

    public function getFeedBeatView($idx)
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD060100";

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;

        $params['search_nationality'] = $params['nationality'] ?? '';
        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['search_created_at'] = $params['created_at'] ?? '';
        if($params['search_created_at'] != ''){
            $atexplode = explode(' - ',$params['created_at']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = $atexplode[1];
        }

        $feedBeatData = $this->adminFeedService->getFeedBeatView($params,$idx);
        $feedBeatTotal = $this->adminFeedService->getFeedBeatTotal($params,$idx);
        $totalCount = $feedBeatTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('contents.feed.feedBeatView',[
            'feedBeatData' => $feedBeatData
            ,'idx' => $idx
            ,'searchData' => $params
            ,'params' => $params
            ,'totalCount' => $totalCount
        ]);
    }

    public function getFeedCommentView($idx)
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD060100";

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;

        $params['search_cm_open'] = $params['cm_open'] ?? '';
        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['search_created_at'] = $params['created_at'] ?? '';
        if($params['search_created_at'] != ''){
            $atexplode = explode(' - ',$params['created_at']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = $atexplode[1];
        }

        $feedCommentData = $this->adminFeedService->getFeedCommentView($params,$idx);
        $feedBeatTotal = $this->adminFeedService->getFeedCommentTotal($params,$idx);
        $totalCount = $feedBeatTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('contents.feed.feedCommentView',[
            'feedCommentData' => $feedCommentData
            ,'idx' => $idx
            ,'searchData' => $params
            ,'params' => $params
            ,'totalCount' => $totalCount
        ]);
    }

    public function feedUpdate()
    {
        $params = $this->request->input();
        $result = $this->adminFeedService->feedUpdate($params);

        if($result == 0){
            return redirect()->back()->with('alert', '등록/수정에 실패하였습니다. \n관리자에게 문의 바랍니다.');
        }else{
            return redirect('/contents/feedView/'.$result);
        }
    }
}
