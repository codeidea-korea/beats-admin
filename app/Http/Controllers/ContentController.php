<?php

namespace App\Http\Controllers;

use App\Service\ContentServiceImpl;
use Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Session;

class ContentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $adminContentService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->adminContentService = new ContentServiceImpl();

        $this->middleware('auth');
    }

    public function getReviewList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD060500";

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;

        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['created_at'] = $params['created_at'] ?? "2022-01-01 - ".date("Y-m-d");
        $params['search_wr_open'] = $params['wr_open'] ?? '';
        $params['search_wr_lng'] = $params['wr_lng'] ?? '';
        $params['search_wr_product'] = $params['wr_product'] ?? '';
        $params['search_grade'] = $params['grade'] ?? '';

        if($params['created_at'] != ''){
            $atexplode = explode(' - ',$params['created_at']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = date("Y-m-d",strtotime($atexplode[1].' +1 days'));
        }

        $reviewData = $this->adminContentService->getReviewList($params);
        $reviewTotal = $this->adminContentService->getReviewTotal($params);
        $totalCount = $reviewTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('contents.review.reviewList',[
            'reviewList' => $reviewData
            ,'params' => $params
            ,'searchData' => $params
            ,'totalCount' => $totalCount
        ]);
    }

    public function getReviewView($idx)
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD060500";

        $reviewData = $this->adminContentService->getReviewView($idx);

        $reviewFileData = $this->adminContentService->getReviewFile($idx);

        return view('contents.review.reviewView',[
            'reviewData' => $reviewData
            ,'reviewFileData' => $reviewFileData
            ,'params' => $params
        ]);
    }

    public function getReviewCommentView($idx)
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD060500";

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;

        $params['search_cm_open'] = $params['cm_open'] ?? '';
        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['created_at'] = $params['created_at'] ?? "2022-01-01 - ".date("Y-m-d");
        if($params['created_at'] != ''){
            $atexplode = explode(' - ',$params['created_at']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = date("Y-m-d",strtotime($atexplode[1].' +1 days'));
        }

        $reviewCommentData = $this->adminContentService->getReviewCommentView($params,$idx);
        $reviewBeatTotal = $this->adminContentService->getReviewCommentTotal($params,$idx);
        $productsData = $this->adminContentService->getProductsList($params);
        $totalCount = $reviewBeatTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('contents.review.reviewCommentView',[
            'reviewCommentData' => $reviewCommentData
            ,'productsData' => $productsData
            ,'idx' => $idx
            ,'searchData' => $params
            ,'params' => $params
            ,'totalCount' => $totalCount
        ]);
    }

    public function reviewUpdate()
    {
        $params = $this->request->input();
        $result = $this->adminContentService->reviewUpdate($params);

        if($result == 0){
            return redirect()->back()->with('alert', '등록/수정에 실패하였습니다. \n관리자에게 문의 바랍니다.');
        }else{
            return redirect('/contents/reviewView/'.$result);
        }
    }

    public function getCommentDetail()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD060500";

        $commentData = $this->adminContentService->getCommentDetail($params);

        $returnData['resultCode']='SUCCESS';
        $returnData['response']=$commentData;

        return json_encode($returnData);
    }

    public function commentUpdate()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD060500";

        $commentData = $this->adminContentService->commentUpdate($params);

        if($commentData > 0){
            $returnData['resultCode']='SUCCESS';
            $returnData['resultMessage']='수정되었습니다.';
        }else{
            $returnData['resultCode']='FAIL';
            $returnData['resultMessage']='수정 중 오류가 발생하였습니다. 다시 시도해 주세요.';
        }

        return json_encode($returnData);
    }
}
