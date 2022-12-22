<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ApiHomeServiceImpl;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
            $params['bannerCode'] = isset($params['bannerCode']) ? $params['bannerCode'] : ''; // 사이트 구분 =>  bb:byBeats , bs:Beat Someone
            $params['lang'] = isset($params['lang']) ? $params['lang'] : 'kr';


            if($params['bannerCode']==""){
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

    public function noticeList()
    {
        try{
            $params = $this->request->input();
            $params['page'] = $params['page'] ?? 1;
            $params['limit'] = $params['limit'] ?? 10;

            $noticeList = $this->apiHomeService->getNoticeList($params);

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']['count']=count($noticeList);
            $returnData['response']['data']=$noticeList;


            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

    public function getNoticeView()
    {
        try{
            $params = $this->request->input();
            $params['idx'] = isset($params['idx']) ? $params['idx'] : ''; // 사이트 구분 =>  bb:byBeats , bs:Beat Someone


            if($params['idx']==""){
                $returnData['code']=-1;
                $returnData['message']="고유번호가 누락되었습니다.";
            }else{

                $noticeView = $this->apiHomeService->getNoticeView($params);

                if($noticeView->isEmpty()){
                    $returnData['code'] = 1;
                    $returnData['message'] = "유효하지 않은 고유번호입니다.";
                }else{
                    $returnData['code'] = 0;
                    $returnData['message'] = "complete";
                    $returnData['response'] = $noticeView;
                }
            }


            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

    public function eventList()
    {
        try{
            $params = $this->request->input();
            $params['page'] = $params['page'] ?? 1;
            $params['limit'] = $params['limit'] ?? 10;

            $eventList = $this->apiHomeService->getEventList($params);
            $total = $this->apiHomeService->getEventTotal($params);

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']['total']=$total->cnt;
            $returnData['response']['count']=count($eventList);
            $returnData['response']['data']=$eventList;


            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

    public function getEventView()
    {
        try{
            $params = $this->request->input();
            $params['idx'] = isset($params['idx']) ? $params['idx'] : '';


            if($params['idx']==""){
                $returnData['code']=-1;
                $returnData['message']="고유번호가 누락되었습니다.";
            }else{

                $eventView = $this->apiHomeService->getEventView($params);

                if($eventView->isEmpty()){
                    $returnData['code'] = 1;
                    $returnData['message'] = "유효하지 않은 고유번호입니다.";
                }else{
                    $returnData['code'] = 0;
                    $returnData['message'] = "complete";
                    $returnData['response'] = $eventView;
                }
            }


            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

    public function beatAdd()
    {
        try{
            $params = $this->request->input();
            $params['mem_id'] = isset($params['mem_id']) ? $params['mem_id'] : '';
            $params['service_name'] = isset($params['service_name']) ? $params['service_name'] : '';
            $params['service_idx'] = isset($params['service_idx']) ? $params['service_idx'] : '';
            $params['beat'] = isset($params['beat']) ? $params['beat'] : 1;


            if($params['mem_id']=="" || $params['service_idx']=="" || $params['service_name']==""){
                $returnData['code']=-1;
                $returnData['message']="필수 입력 값이 누락되었습니다.";
            }else{

                $beat = $this->apiHomeService->beatAdd($params);

                $returnData['code'] = 0;
                $returnData['message'] = "complete";
                $returnData['response'] = $beat;
            }


            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

    public function beatDelete()
    {
        try{
            $params = $this->request->input();
            $params['mem_id'] = isset($params['mem_id']) ? $params['mem_id'] : '';
            $params['service_name'] = isset($params['service_name']) ? $params['service_name'] : '';
            $params['service_idx'] = isset($params['service_idx']) ? $params['service_idx'] : '';


            if($params['mem_id']=="" || $params['service_idx']=="" || $params['service_name']==""){
                $returnData['code']=-1;
                $returnData['message']="필수 입력 값이 누락되었습니다.";
            }else{

                $beat = $this->apiHomeService->beatDelete($params);

                $returnData['code'] = 0;
                $returnData['message'] = "complete";
                $returnData['response'] = $beat;
            }


            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

    public function getPopup()
    {
        try{
            $params = $this->request->input();
            $params['site_type'] = $params['site_type'] ?? 'beatsomeone';

            $popup = $this->apiHomeService->getPopup($params);

            $returnData['code'] = 0;
            $returnData['message'] = "complete";
            $returnData['response'] = $popup;

            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

    public function getTermsApplyData()
    {
        try{
            $params = $this->request->input();
            $params['terms_type'] = $params['terms_type'] ?? '';

            if($params['terms_type'] == ''){
                $returnData['code']=-1;
                $returnData['message']="필수 입력 값이 누락되었습니다.";
            }else{
                $apply_date = $this->apiHomeService->getTermsApplyData($params);

                $returnData['code'] = 0;
                $returnData['message'] = "complete";
                $returnData['response'] = $apply_date;
            }

            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

    public function getTermsContent()
    {
        try{
            $params = $this->request->input();
            $params['idx'] = $params['idx'] ?? '';

            if($params['idx'] == ''){
                $returnData['code']=-1;
                $returnData['message']="필수 입력 값이 누락되었습니다.";
            }else{
                $content = $this->apiHomeService->getTermsContent($params);

                $returnData['code'] = 0;
                $returnData['message'] = "complete";
                $returnData['response'] = $content;
            }

            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

    public function trendList()
    {
        try{
            $params = $this->request->input();
            $params['page'] = $params['page'] ?? 1;
            $params['limit'] = $params['limit'] ?? 10;
            //정렬 최신순 1 비트 많은 순(인기순) 2 높은 조회수 3
            $params['sorting'] = $params['sorting'] ?? '';
            $params['mem_id'] = $params['mem_id'] ?? 0;

            $trendList = $this->apiHomeService->getTrendList($params);
            $total = $this->apiHomeService->getTrendTotal($params);

            foreach($trendList as $key => $rs){
                $photoData = $this->apiHomeService->setProfilePhotoList($rs);
                $trendList[$key]->photo = array(
                    'profilePhotoListCount' => count($photoData),
                    'profilePhotoList' => $photoData,
                );
            }

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']['total']=$total->cnt;
            $returnData['response']['count']=count($trendList);
            $returnData['response']['data']=$trendList;


            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

    public function getTrendView()
    {
        try{
            $params = $this->request->input();
            $params['idx'] = isset($params['idx']) ? $params['idx'] : '';
            $params['mem_id'] = $params['mem_id'] ?? 0;


            if($params['idx']==""){
                $returnData['code']=-1;
                $returnData['message']="고유번호가 누락되었습니다.";
            }else{

                $trendView = $this->apiHomeService->getTrendView($params);

                if($trendView->isEmpty()){
                    $returnData['code'] = 1;
                    $returnData['message'] = "유효하지 않은 고유번호입니다.";
                }else{

                    $photoData = $this->apiHomeService->setProfilePhotoList($trendView[0]);
                    $trendView[0]->photo = array(
                        'profilePhotoListCount' => count($photoData),
                        'profilePhotoList' => $photoData,
                    );

                    $diff = strtotime($trendView[0]->now_date) - strtotime($trendView[0]->created_at);

                    $s = 60; //1분 = 60초
                    $h = $s * 60; //1시간 = 60분
                    $d = $h * 24; //1일 = 24시간
                    $y = $d * 30; //1달 = 30일 기준
                    $a = $y * 12; //1년

                    if ($diff < $s) {
                        $result = $diff . '초전';
                    } elseif ($h > $diff && $diff >= $s) {
                        $result = round($diff/$s) . '분전';
                    } elseif ($d > $diff && $diff >= $h) {
                        $result = round($diff/$h) . '시간전';
                    } elseif ($y > $diff && $diff >= $d) {
                        $result = round($diff/$d) . '일전';
                    } elseif ($a > $diff && $diff >= $y) {
                        $result = round($diff/$y) . '달전';
                    } else {
                        $result = round($diff/$a) . '년전';
                    }

                    $trendView[0]->created_at = $result;

                    $returnData['code'] = 0;
                    $returnData['message'] = "complete";
                    $returnData['response'] = $trendView;
                }
            }


            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

    public function setTrendHitAdd()
    {
        try{
            $params = $this->request->input();
            //정렬 최신순 1 비트 많은 순(인기순) 2 높은 조회수 3
            $params['idx'] = $params['idx'] ?? '';

            if($params['idx'] == ''){
                $returnData['code']=1;
                $returnData['message']="고유번호가 누락되었습니다";
            }else{
                
                $HitAdd = $this->apiHomeService->setTrendHitAdd($params);

                if($HitAdd){    
                    $returnData['code']=0;
                    $returnData['message']="complete";
                    $returnData['response']['data']=$HitAdd;
                }else{
                    $returnData['code']=2;
                    $returnData['message']="fail";
                    $returnData['response']['data']=$HitAdd;
                }
            }

            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
    }

}
