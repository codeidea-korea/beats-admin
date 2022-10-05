<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ApiSoundSourceServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\HttpException;
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
            $returnData['response']['idx']=$resultData1['idx'];

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }
}
