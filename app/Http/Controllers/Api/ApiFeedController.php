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
    private $apiSoundSorceService;


    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->apiSoundSorceService = new ApiFeedServiceImpl();
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
                $resultData1 = $this->apiSoundSorceService->setFeedUpdate($params,$main_files);

                if($sub_files != null){    
                    $params['feed_idx'] = $resultData1;
                    
                    // 첨부파일 db 등록 및 서버 저장
                    $resultData2 = $this->apiSoundSorceService->setFeedFileUpdate($params,$sub_files);
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
}
