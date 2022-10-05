<?php

namespace App\Http\Controllers;

use App\Service\FeedServiceImpl;
use Response;
use Illuminate\Http\Request;
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
}
