<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ApiCommentServiceImpl;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Response;
use Session;

class ApiCommentController extends Controller
{
    private $request;
    private $apiCommentService;


    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->apiCommentService = new ApiCommentServiceImpl();
    }

    public function getCommentList()
    {
        $params = $this->request->input();

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['wr_idx'] = $params['wr_idx'] ?? 0;
        $params['wr_type'] = $params['wr_type'] ?? '';
        $params['mem_id'] = $params['mem_id'] ?? '';

        if($params['wr_idx'] == 0 || $params['wr_type'] == ''){

            $returnData['code'] = 2;
            $returnData['message'] = "입력하지 않은 필수 값이 있습니다. 필수 값을 입력해 주세요";

        }else{

            $resultData = $this->apiCommentService->getCommentList($params);
            $total = $this->apiCommentService->getCommentTotal($params);

            $i = 0;
            foreach($resultData as $data){
                $diff = time() - strtotime($data->created_at);

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

                $resultData[$i]->created_at = $result;
                $i++;
            }

            $returnData['code'] = 0;
            $returnData['message'] = "댓글 리스트";
            $returnData['total'] = $total->cnt;
            $returnData['response'] = $resultData;
        }

        return json_encode($returnData);
    }

    public function getCommentDataList()
    {
        date_default_timezone_set('Asia/Seoul');
        $params = $this->request->input();

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['wr_idx'] = $params['wr_idx'] ?? 0;
        $params['wr_type'] = $params['wr_type'] ?? '';

        if($params['wr_idx'] == 0 || $params['wr_type'] == ''){

            $returnData['code'] = 2;
            $returnData['message'] = "입력하지 않은 필수 값이 있습니다. 필수 값을 입력해 주세요";

        }else{


            $resultData = $this->apiCommentService->getCommentDataList($params);
            $total = $this->apiCommentService->getCommentTotal($params);

            $i = 0;
            foreach($resultData as $data){
                $diff = time() - strtotime($data->created_at);

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

                $resultData[$i]->created_at_re = $result;
                $i++;
            }

            $returnData['code'] = 0;
            $returnData['message'] = "댓글 리스트";
            $returnData['total'] = $total->cnt;
            $returnData['response'] = $resultData;
        }

        return json_encode($returnData);
    }

    public function getCommentChildList()
    {
        $params = $this->request->input();

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['cm_idx'] = $params['cm_idx'] ?? 0;

        if($params['cm_idx'] == 0){

            $returnData['code'] = 2;
            $returnData['message'] = "입력하지 않은 필수 값이 있습니다. 필수 값을 입력해 주세요";

        }else{

            $resultData = $this->apiCommentService->getCommentChildList($params);

            $i = 0;
            foreach($resultData as $data){
                $diff = time() - strtotime($data->created_at);

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

                $resultData[$i]->created_at = $result;
                $i++;
            }

            $returnData['code'] = 0;
            $returnData['message'] = "대댓글 리스트";
            $returnData['response'] = $resultData;
        }

        return json_encode($returnData);
    }

    public function commentAdd()
    {

        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['wr_idx'] = $params['wr_idx'] ?? 0;
            $params['cm_idx'] = $params['cm_idx'] ?? 0;
            $params['dir_cm_idx'] = $params['dir_cm_idx'] ?? 0;
            $params['cm_main'] = $params['cm_main'] ?? 0;
            $params['cm_depth'] = $params['cm_depth'] ?? 1;
            $params['cm_content'] = $params['cm_content'] ?? '';
            $params['wr_type'] = $params['wr_type'] ?? '';
            $params['music_idx'] = $params['music_idx'] ?? '0';

            if($params['mem_id'] == 0 || $params['wr_idx'] == 0 || $params['cm_main'] == 0 || $params['cm_content'] == '' || $params['wr_type'] == ''){

                $returnData['code'] = 2;
                $returnData['message'] = "입력하지 않은 필수 값이 있습니다. 필수 값을 입력해 주세요";

            }else{
                $result = $this->apiCommentService->commentAdd($params);

                $returnData['code'] = 0;
                $returnData['message'] = "댓글 등록 완료";
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function commentSoundSourceAdd()
    {

        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['wr_idx'] = $params['wr_idx'] ?? 0;
            $params['cm_idx'] = $params['cm_idx'] ?? 0;
            $params['dir_cm_idx'] = $params['dir_cm_idx'] ?? 0;
            $params['cm_main'] = $params['cm_main'] ?? 0;
            $params['cm_depth'] = $params['cm_depth'] ?? 1;
            $params['cm_content'] = $params['cm_content'] ?? '';
            $params['wr_type'] = $params['wr_type'] ?? '';
            $params['music_idx'] = $params['music_idx'] ?? '0';
            $params['record'] = $params['record'] ?? '';

            //$files = $this->request->file('record');


            if($params['mem_id'] == 0 || $params['wr_idx'] == 0 || $params['cm_main'] == 0 || $params['cm_content'] == '' || $params['wr_type'] == ''){

                $returnData['code'] = 2;
                $returnData['message'] = "입력하지 않은 필수 값이 있습니다. 필수 값을 입력해 주세요";

            }else{
                $resultData1 = $this->apiCommentService->commentAdd($params);

                //if(count($files) > 0){
                //    $resultData2 = $this->apiCommentService->setRecordFileUpdate($resultData1,$files);
                //}

                $returnData['code'] = 0;
                $returnData['message'] = "댓글 등록 완료";
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }




    public function commentUpdate()
    {

        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['cm_idx'] = $params['cm_idx'] ?? 0;
            $params['cm_content'] = $params['cm_content'] ?? '';

            if($params['cm_idx'] == 0 || $params['cm_content'] == ''){

                $returnData['code'] = 2;
                $returnData['message'] = "입력하지 않은 필수 값이 있습니다. 필수 값을 입력해 주세요";

            }else{
                $result = $this->apiCommentService->commentUpdate($params);

                $returnData['code'] = 0;
                $returnData['message'] = "댓글 수정 완료";
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function commentDelete()
    {

        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['cm_idx'] = $params['cm_idx'] ?? 0;

            if($params['cm_idx'] == 0){

                $returnData['code'] = 2;
                $returnData['message'] = "입력하지 않은 필수 값이 있습니다. 필수 값을 입력해 주세요";

            }else{
                $result = $this->apiCommentService->commentDelete($params);

                $returnData['code'] = 0;
                $returnData['message'] = "댓글 삭제 완료";
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }
}
