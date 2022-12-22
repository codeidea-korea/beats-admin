<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ApiCoComposerServiceImpl;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Storage;

class ApiCoComposerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $apiCocomposerService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->apiCocomposerService = new ApiCoComposerServiceImpl();
    }

    public function checkEmail(){

        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();
        $params['music_head_idx'] = $params['music_head_idx'] ?? 0;
        $params['send_email'] = $params['send_email'] ?? "";

        if($params['music_head_idx']==0){
            $returnData['code'] = 302;
            $returnData['message'] = "키값이 누락되어 있습니다.";
        }else{
            try{

                $result = $this->apiCocomposerService->getCheckEmail($params);
                if($result->cnt == 1){
                    $returnData['code']=0;
                    $returnData['message']="complete";
                }else{
                    $returnData['code']=300;
                    $returnData['message']="인증실패";
                }

            } catch(\Exception $exception){
                throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
            }
        }


        return json_encode($returnData);

    }

    public function setCoComposer(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();
        $params['music_head_idx'] = $params['music_head_idx'] ?? 0;
        $params['mem_id'] = $params['mem_id'] ?? 0;
        $params['send_email'] = $params['send_email'] ?? "";


        if($params['music_head_idx']==0){
            $returnData['code'] = 302;
            $returnData['message'] = "키값이 누락되어 있습니다.";
        }else{
            try{

                $result = $this->apiCocomposerService->setCoComposer($params);


                if($result){
                    $returnData['code']=0;
                    $returnData['message']="complete";
                }else{
                    $returnData['code']=300;
                    $returnData['message']="승인 실패";
                }

            } catch(\Exception $exception){
                throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
            }
        }


        return json_encode($returnData);
    }

    public function setCopyRight(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();
        $params['music_head_idx'] = $params['music_head_idx'] ?? 0;
        $params['copyright'] = $params['copyright'] ?? 0;
        $params['co_composer_mem_id'] = $params['co_composer_mem_id'] ?? array();
        $params['co_composer_copyright'] = $params['co_composer_copyright'] ?? array();

        if($params['music_head_idx']==0){
            $returnData['code'] = 302;
            $returnData['message'] = "키값이 누락되어 있습니다.";
        }else{
            try{
                $result = $this->apiCocomposerService->setCopyRight($params);
                $returnData['code']=0;
                $returnData['message']="complete";

            } catch(\Exception $exception){
                throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
            }
        }

        return json_encode($returnData);
    }

    public function getCoComposer(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();
        $params['music_head_idx'] = $params['music_head_idx'] ?? 0;

        if($params['music_head_idx']==0){
            $returnData['code'] = 302;
            $returnData['message'] = "회원 고유키값이 누락되어 있습니다.";
        }else{
            try{
                $result1 = $this->apiCocomposerService->getMainCopyRight($params);

                $result2 = $this->apiCocomposerService->getCoComposer($params);

                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']['data']['mainData']=$result1;
                $returnData['response']['data']['coComposerData']=$result2;

            } catch(\Exception $exception){
                throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
            }
        }

        return json_encode($returnData);
    }

    public function copyRightOk(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();
        $params['music_head_idx'] = $params['music_head_idx'] ?? 0;
        $params['co_composer_mem_id'] = $params['co_composer_mem_id'] ?? 0;
        $params['isCopyRight'] = $params['isCopyRight'] ?? '';

        if($params['music_head_idx']==0||$params['co_composer_mem_id']==0||$params['isCopyRight']==""){
            $returnData['code'] = 302;
            $returnData['message'] = "키값이 누락되어 있습니다.";
        }else{
            try{
                $result = $this->apiCocomposerService->putCopyRightOk($params);
                $returnData['code']=0;
                $returnData['message']="complete";

            } catch(\Exception $exception){
                throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
            }
        }

        return json_encode($returnData);
    }

}
