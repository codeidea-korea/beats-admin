<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ApiFeedServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Response;
use Session;

class ApiFeedController extends Controller
{
    private $request;
    private $apiFeedService;


    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->apiFeedService = new ApiFeedServiceImpl();
    }

    public function getFeedList()
    {
        $params = $this->request->input();

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        //정렬 최신순 1 비트 많은 순 2 댓글 많은순 3
        $params['sorting'] = $params['sorting'] ?? '';
        $params['mem_id'] = $params['mem_id'] ?? 0;

        $resultData = $this->apiFeedService->getFeedList($params);

        $returnData['code'] = 0;
        $returnData['message'] = "피드 리스트";
        $returnData['response'] = $resultData;

        return json_encode($returnData);
    }

    public function getFeedView()
    {
        $params = $this->request->input();

        $params['type'] = $params['type'] ?? 0;
        $params['idx'] = $params['idx'] ?? 0;
        $params['mem_id'] = $params['mem_id'] ?? 0;

        $resultData1 = $this->apiFeedService->getFeedView($params);
        $resultData2 = $this->apiFeedService->getFeedFile($params);

        $diff = time() - strtotime($resultData1[0]->created_at);

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

        $resultData1[0]->created_at = $result;
        
        $returnData['code'] = 0;
        $returnData['message'] = "피드 상세";
        $returnData['response']['detail'] = $resultData1;
        $returnData['response']['file'] = $resultData2;

        return json_encode($returnData);
    }

    public function feedFileUpdate()
    {

        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['wr_title'] = $params['wr_title'] ?? null;

            $main_files = $this->request->file('main_file');
            $sub_files = $this->request->file('sub_file');

            if($sub_files == null){
                $params['wr_file'] = 1;
            }else{
                $params['wr_file'] = count($sub_files) + 1;
            }

            if($params['wr_file'] == $params['content_cnt']){
                // 음원파일 헤드 등록
                $resultData1 = $this->apiFeedService->setFeedUpdate($params,$main_files);

                if($sub_files != null){    
                    $params['feed_idx'] = $resultData1;
                    
                    // 첨부파일 db 등록 및 서버 저장
                    $resultData2 = $this->apiFeedService->setFeedFileUpdate($params,$sub_files);
                }

                $returnData['code'] = 0;
                $returnData['message'] = "피드 등록 완료";
                $returnData['response']['idx'] = $resultData1;
            }else{
                $returnData['code'] = 1;
                $returnData['message'] = "등록하신 이미지가 누락되었습니다. 다시 한번 확인해주세요";
            }
            

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function feedDelete()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{

            $params = $this->request->input();
            $params['idx'] = $params['idx'] ?? 0;
            
            $result = $this->apiFeedService->feedDelete($params);
            $result2 = $this->apiFeedService->feedFileDelete($params);

            if($result == -1 || $result == 0){
                $returnData['code'] = 1;
                $returnData['message'] = "피드 삭제 실패";
                $returnData['response'] = $result;
            }else{
                $returnData['code'] = 0;
                $returnData['message'] = "피드 삭제 완료";
                $returnData['response'] = $result;
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function feedUpdate()
    {

        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['feed_idx'] = $params['feed_idx'] ?? 0;
            $params['file_idx'] = $params['file_idx'] ?? [];

            $main_files = $this->request->file('main_file');
            $sub_files = $this->request->file('sub_file');

            // 음원파일 헤드 수정
            $resultData1 = $this->apiFeedService->feedUpdate($params,$main_files);

            // 첨부파일 db 수정 및 서버 저장
            $resultData2 = $this->apiFeedService->feedFileUpdate($params,$sub_files);

            $returnData['code'] = 0;
            $returnData['message'] = "피드 수정 완료";
            $returnData['response'] = $resultData2;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }
}
