<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ProductServiceImpl;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Storage;

class ApiProductController extends Controller
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
    }

    public function getProductData(){

        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();
        $params['idx'] = $params['idx'] ?? 0;



        if($params['idx']==0){
            $returnData['code'] = 302;
            $returnData['message'] = "제품 고유키값이 누락되어 있습니다.";
        }else{
            try{
                $productData = $this->productService->getProductData($params, $params['idx']);
                $optionData = $this->productService->getProductOption($params, $params['idx']);
                $returnData['productData']=$productData;
                $returnData['optionData']=$optionData;
                $returnData['code']=0;
                $returnData['message']="complete";

            } catch(\Exception $exception){
                throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
            }
        }


        return json_encode($returnData);

    }

}
