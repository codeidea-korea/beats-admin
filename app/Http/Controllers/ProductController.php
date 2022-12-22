<?php

namespace App\Http\Controllers;
use App\Service\ProductServiceImpl;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Storage;

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
        $productList=array();
        $productList = $this->productService->getProductList($params);
        $productTotal = $this->productService->getProductTotal($params);
        //$boardData = $this->adminBoardService->getBoardList($params);
        //$boardTotal = $this->adminBoardService->getBoardTotal($params);
        $totalCount = $productTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('products.productList',[
            'productList' => $productList
            ,'params' => $params
            ,'searchData' => $params
            ,'totalCount' => $totalCount
        ]);
    }

    public function getProductWrite(){
        $params = $this->request->input();
        $params['menuCode'] = "AD070000";

        return view('products.productWrite',[
                'params' => $params
        ]);
    }

    public function setProductInsert(){

        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();

            $params['bj']                = $params['bj'] ?? '';
            $params['name']                = $params['name'] ?? '';
            $params['name_en']             = $params['name_en'] ?? '';
            $params['name_jp']             = $params['name_jp'] ?? '';
            $params['name_ch']             = $params['name_ch'] ?? '';
            $params['price']               = $params['price'] ?? 0;
            $params['information']         = $params['information'] ?? '';
            $params['information_en']      = $params['information_en'] ?? '';
            $params['information_jp']      = $params['information_jp'] ?? '';
            $params['information_ch']      = $params['information_ch'] ?? '';
            $params['delivery_charge']     = $params['delivery_charge'] ?? 0;
            $params['delivery_charge_re']  = $params['delivery_charge_re'] ?? 0;
            $params['delivery_charge_ch']  = $params['delivery_charge_ch'] ?? 0;
            $params['delivery_charge_jj']  = $params['delivery_charge_jj'] ?? 0;
            $params['delivery_charge_ex']  = $params['delivery_charge_ex'] ?? 0;
            $params['policy']              = $params['policy'] ?? '';
            $params['policy_en']           = $params['policy_en'] ?? '';
            $params['policy_jp']           = $params['policy_jp'] ?? '';
            $params['policy_ch']           = $params['policy_ch'] ?? '';
            $params['is_display']          = $params['is_display'] ?? 'N';
            $params['admin_idx']           = auth()->user()->idx;
            $params['admin_name']          = auth()->user()->name;
            $params['products_idx'] = $this->productService->setProduct($params);

            //상품 대표이미지 파일 처리
            $file = $this->request->file('productImg');
            if(isset($file)){
                $folderName = '/product/'.date("Y/m/d").'/';
                $params['file_name'] = $file->getClientOriginalName();
                $params['hash_name'] = $file->hashName();
                $params['file_url'] =  $folderName;
                $path = Storage::disk('s3')->put($folderName. $params['hash_name'], file_get_contents($file));
                $path = Storage::disk('s3')->url($path);
                $resultImg = $this->productService->setProductImage($params);
            }

            $params['option_no'] = $params['option_no'] ?? array();
            $params['option_title'] = $params['option_title'] ?? array();
            $params['option_price'] = $params['option_price'] ?? array();
            $params['option_stock'] = $params['option_stock'] ?? array();

            if($params['option_title'][0]!=null){

                // 옵션 데이터 처리
                $qrParam['products_idx']=$params['products_idx'];
                $opCnt=count($params['option_no']);

                for($i=0;$i<$opCnt;$i++){
                    $qrParam['products_idx']= $params['products_idx'];
                    $qrParam['option_no']=$params['option_no'][$i];
                    $qrParam['option_title']=$params['option_title'][$i];
                    $qrParam['option_price']=$params['option_price'][$i];
                    $qrParam['option_stock']=$params['option_stock'][$i];

                    $result = $this->productService->setProductOption($qrParam);
                }
            }
            $returnData['code']=0;
            $returnData['message']="상품 등록 완료";

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return $returnData;

    }

    public function getProductView($bidx){
        $params = $this->request->input();
        $params['menuCode'] = "AD070000";
        $params['idx'] = $bidx;

        $productData = $this->productService->getProductData($params, $bidx);
        $optionData = $this->productService->getProductOption($params, $bidx);

        return view('products.productView',[
            'productData' => $productData
            ,'optionData' => $optionData
            ,'params' => $params
        ]);
    }

    public function putProductUpdate(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();

            $params['idx']                = $params['idx'] ?? '';
            $params['bj']                = $params['bj'] ?? '';
            $params['name']                = $params['name'] ?? '';
            $params['name_en']             = $params['name_en'] ?? '';
            $params['name_jp']             = $params['name_jp'] ?? '';
            $params['name_ch']             = $params['name_ch'] ?? '';
            $params['price']               = $params['price'] ?? 0;
            $params['information']         = $params['information'] ?? '';
            $params['information_en']      = $params['information_en'] ?? '';
            $params['information_jp']      = $params['information_jp'] ?? '';
            $params['information_ch']      = $params['information_ch'] ?? '';
            $params['delivery_charge']     = $params['delivery_charge'] ?? 0;
            $params['delivery_charge_re']  = $params['delivery_charge_re'] ?? 0;
            $params['delivery_charge_ch']  = $params['delivery_charge_ch'] ?? 0;
            $params['delivery_charge_jj']  = $params['delivery_charge_jj'] ?? 0;
            $params['delivery_charge_ex']  = $params['delivery_charge_ex'] ?? 0;
            $params['policy']              = $params['policy'] ?? '';
            $params['policy_en']           = $params['policy_en'] ?? '';
            $params['policy_jp']           = $params['policy_jp'] ?? '';
            $params['policy_ch']           = $params['policy_ch'] ?? '';
            $params['is_display']          = $params['is_display'] ?? 'N';
            $params['admin_idx']           = auth()->user()->idx;
            $params['admin_name']          = auth()->user()->name;
            $params['products_idx']        = $params['idx'];
            $this->productService->putProduct($params);

            //상품 대표이미지 파일 처리
            $file = $this->request->file('productImg');
            if(isset($file)){
                $this->productService->delProductImage($params);

                $folderName = '/product/'.date("Y/m/d").'/';
                $params['file_name'] = $file->getClientOriginalName();
                $params['hash_name'] = $file->hashName();
                $params['file_url'] =  $folderName;
                $path = Storage::disk('s3')->put($folderName. $params['hash_name'], file_get_contents($file));
                $path = Storage::disk('s3')->url($path);
                $resultImg = $this->productService->setProductImage($params);
            }

            $this->productService->delProductOption($params);
            $params['option_no'] = $params['option_no'] ?? array();
            $params['option_title'] = $params['option_title'] ?? array();
            $params['option_price'] = $params['option_price'] ?? array();
            $params['option_stock'] = $params['option_stock'] ?? array();



            if($params['option_title'][0]!=null){

                // 옵션 데이터 처리
                $qrParam['products_idx']=$params['products_idx'];
                $opCnt=count($params['option_no']);

                for($i=0;$i<$opCnt;$i++){
                    $qrParam['products_idx']= $params['products_idx'];
                    $qrParam['option_no']=$params['option_no'][$i];
                    $qrParam['option_title']=$params['option_title'][$i];
                    $qrParam['option_price']=$params['option_price'][$i];
                    $qrParam['option_stock']=$params['option_stock'][$i];

                    $result = $this->productService->setProductOption($qrParam);
                }
            }
            $returnData['code']=0;
            $returnData['message']="상품 수정 완료";

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return $returnData;
    }

}
