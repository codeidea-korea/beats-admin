<?php

namespace App\Http\Controllers;
use App\Service\ProductServiceImpl;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Maatwebsite\Excel\Facades\Excel;

use Response;
use Illuminate\Http\Request;
use Session;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $productService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->productService = new ProductServiceImpl();

        $this->middleware('auth');
    }
    public function getProductList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD070000";

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['search_gubun'] = $params['gubun'] ?? '';
        $params['fr_search_text'] = $params['search_text'] ?? '';
        $params['searchDate'] = $params['searchDate'] ?? "2022-01-01 - ".date("Y-m-d");
        $params['search_wr_open'] = $params['wr_open'] ?? '';

        if($params['searchDate'] != ''){
            $atexplode = explode(' - ',$params['searchDate']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = date("Y-m-d",strtotime($atexplode[1].' +1 days'));
        }
        $boardData=array();
        //$boardData = $this->adminBoardService->getBoardList($params);
        //$boardTotal = $this->adminBoardService->getBoardTotal($params);
        //$totalCount = $boardTotal->cnt;
        //$params['totalCnt'] = $totalCount;

        return view('products.productList',[
            'boardData' => $boardData
            ,'params' => $params
            ,'searchData' => $params
            //,'totalCount' => $totalCount
        ]);
    }

    public function getProductWrite(){
        $params = $this->request->input();
        $params['menuCode'] = "AD070000";

        return view('products.productWrite',[
                'params' => $params
        ]);
    }
}
