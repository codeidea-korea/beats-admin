<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ApiSoundSourceServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Response;
use Session;

class ApiSoundSourceController extends Controller
{
    private $request;
    private $apiSoundSorceService;


    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->apiSoundSorceService = new ApiSoundSourceServiceImpl();
    }

    public function soundFileUpdate()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";
        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;

            $files = $this->request->file('music_file');

            // 음원파일 헤드 등록
            $resultData1 = $this->apiSoundSorceService->setDataUpdate($params,$files);

            // 첨부파일 db 등록 및 서버 저장
            $resultData2 = $this->apiSoundSorceService->setSoundFileUpdate($resultData1,$files);

            $returnData['code']=0;
            $returnData['message']="음원파일 등록 완료";
            $returnData['response']['music_head_idx']=$resultData1['idx'];

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function soundDataUpdate()
    {

        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['music_head_idx'] = $params['music_head_idx'] ?? 1;
            $params['music_title'] = $params['music_title'] ?? "";
            $params['progress_rate'] = $params['progress_rate'] ?? "10"; // 작업 진행율 10단위
            $params['sales_status'] = $params['sales_status'] ?? "Y"; // 판매상태
            $params['open_status'] = $params['open_status'] ?? "Y"; // 음원공개여부
            $params['tag'] = $params['tag'] ?? "";
            $params['common_composition'] = $params['common_composition'] ?? "N"; // 공동 작곡가 유무
            $params['contract'] = $params['contract'] ?? "N"; // 공동 계약서 서명여부

            // 음원파일 헤드 등록
            $resultData1 = $this->apiSoundSorceService->setSoundDataUpdate($params);


            $returnData['code']=0;
            $returnData['message']="변경 사항이 저장되었습니다.";

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function soundSourceList(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();
        $params['mem_id'] = $params['mem_id'] ?? 0;
        $params['progress_rate'] = $params['progress_rate'] ?? '';
        $params['common_composition'] = $params['common_composition'] ?? '';
        $params['sales_status'] = $params['sales_status'] ?? '';
        $params['open_status'] = $params['open_status'] ?? '';
        $params['search_text'] = $params['search_text'] ?? '';

        if($params['mem_id']==0){
            $returnData['code'] = 302;
            $returnData['message'] = "회원 고유키값이 누락되어 있습니다.";
        }else{
            try{

                $resultData = $this->apiSoundSorceService->setSoundSourceList($params);
                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$resultData;

            } catch(\Exception $exception){
                throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
            }
        }

        return json_encode($returnData);
    }

    public function soundSourceData(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();
        $params['music_head_idx'] = $params['music_head_idx'] ?? 0;

        if($params['music_head_idx']==0){
            $returnData['code'] = 302;
            $returnData['message'] = "회원 고유키값이 누락되어 있습니다.";
        }else{
            try{
                $returnData['code']=0;
                $returnData['message']="complete";

                $resultData = $this->apiSoundSorceService->getSoundSourceData($params);
                $returnData['response']['data']=$resultData;

                $params['file_vesrsion'] = $resultData->file_vesrsion;

                $fileData = $this->apiSoundSorceService->getMusicFileList($params);
                $returnData['response']['fileData']=$fileData;

                if($resultData->commonComposition=="Y"){
                    $ccList = $this->apiSoundSorceService->getCommonCompositionList($params);
                    $returnData['response']['commonCompositionList']=$ccList;
                }else{
                    $returnData['response']['commonCompositionList'] = null;
                }


            } catch(\Exception $exception){
                throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
            }
        }

        return json_encode($returnData);
    }
}
