<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ApiHomeServiceImpl;
use Illuminate\Http\Request;
use Response;
use Session;

class ApiHomeController extends Controller
{
    private $request;
    private $apiHomeService;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->apiHomeService = new ApiHomeServiceImpl();
    }

    public function langList()
    {
        try{
            $params = $this->request->input();
            $langList = $this->apiHomeService->getLangList($params);
            $returnData['code']=0;
            $returnData['message']="messageSample!!";
            $returnData['response']['count']=count($langList);
            $returnData['response']['data']=$langList;

            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

    public function menuList()
    {
        try{
            $params = $this->request->input();
            $params['site'] = isset($params['site']) ? $params['site'] : ''; // 사이트 구분 =>  bb:byBeats , bs:Beat Someone
            $params['lang'] = isset($params['lang']) ? $params['lang'] : 'kr';

            if($params['site']=="bb"){
                $menuList = $this->apiHomeService->getMenuList($params);
                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']['count']=count($menuList);
                $returnData['response']['data']=$menuList;
            }elseif($params['site']=="bs"){
                $menuList = $this->apiHomeService->getMenuList($params);
                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']['count']=count($menuList);
                $returnData['response']['data']=$menuList;
            }else{
                $returnData['code']=-1;
                $returnData['message']="사이트 구분이 잘못되었습니다.";
            }

            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

    public function bannerList()
    {
        try{
            $params = $this->request->input();
            $params['banner_code'] = isset($params['banner_code']) ? $params['banner_code'] : ''; // 사이트 구분 =>  bb:byBeats , bs:Beat Someone
            $params['lang'] = isset($params['lang']) ? $params['lang'] : 'kr';


            if($params['banner_code']==""){
                $returnData['code']=-1;
                $returnData['message']="배너코드값이 누락되었습니다.";
            }else{

                $bannerList = $this->apiHomeService->getBannerList($params);

                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']['count']=count($bannerList);
                $returnData['response']['data']=$bannerList;
            }


            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }


}
