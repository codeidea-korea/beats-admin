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
            $params['seconds'] = $params['seconds'] ?? array();


            $pData = json_encode($params);

            $resultData1 = $this->apiSoundSorceService->setLog($pData);


            // 음원파일 헤드 등록
            $resultData1 = $this->apiSoundSorceService->setDataUpdate($params,$files);

            // 첨부파일 db 등록 및 서버 저장
            $resultData2 = $this->apiSoundSorceService->setSoundFileUpdate($resultData1,$files,$params);

            $returnData['code']=0;
            $returnData['message']="음원파일 등록 완료";
            $returnData['response']['music_head_idx']=$resultData1['idx'];
            $returnData['response']['last_file']=$resultData2;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function soundFileUpLoad()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['music_head_idx'] = $params['music_head_idx'] ?? 0;
            $params['seconds'] = $params['seconds'] ?? array();
            //$params['file_version'] = $params['file_version'] ?? 0;
            //$params['file_version_next'] =  $params['file_version']+1;

            $files = $this->request->file('music_file');

            // 음원파일 헤드 등록
            $resultData1 = $this->apiSoundSorceService->setDataUpLoad($params,$files);

            $returnData['code']=0;
            $returnData['message']="음원파일 등록 완료";
            $returnData['response']['music_head_idx']=$params['music_head_idx'];
            $returnData['response']['params']=$params;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function representativeMusic(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['music_file_idx'] = $params['music_file_idx'] ?? 0;
            $params['music_head_idx'] = $params['music_head_idx'] ?? 0;


            // 음원파일 헤드 등록
            $this->apiSoundSorceService->setRepresentativeMusic($params);

            $returnData['code']=0;
            $returnData['message']="음원파일 등록 완료";
            $returnData['response']['music_head_idx']=$params['music_head_idx'];
            $returnData['response']['params']=$params;

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
        $params['page'] = $params['page'] ?? '1';
        $params['limit'] = $params['limit'] ?? '10';
        $params['sDate'] = $params['sDate'] ?? '';
        $params['eDate'] = $params['eDate'] ?? '';
        $params['tag'] = $params['tag'] ?? '';
        if($params['eDate'] !=""){
            $params['eDate'] = date("Ymd",strtotime($params['eDate'].' +1 days'));
        }

        $params['sProgressRate'] = $params['sProgressRate'] ?? '';
        $params['eProgressRate'] = $params['eProgressRate'] ?? '';

        if($params['mem_id']==0){
            $returnData['code'] = 302;
            $returnData['message'] = "회원 고유키값이 누락되어 있습니다.";
        }else{
            try{

                $resultData = $this->apiSoundSorceService->setSoundSourceListPaging($params);
                $dataList=array();
                $i=0;
                foreach($resultData as $rs){
                    $dataList[$i]['idx']  =$rs->idx;
                    $dataList[$i]['mem_id']  =$rs->mem_id;
                    $dataList[$i]['file_cnt']  =$rs->file_cnt;
                    $dataList[$i]['music_title']  =$rs->music_title;
                    $dataList[$i]['play_time']  =$rs->play_time;
                    $dataList[$i]['open_status']  =$rs->open_status;
                    $dataList[$i]['sales_status']  =$rs->sales_status;
                    $dataList[$i]['contract']  =$rs->contract;
                    $dataList[$i]['tag']  =$rs->tag;
                    $dataList[$i]['progress_rate']  =$rs->progress_rate;
                    $dataList[$i]['common_composition']  =$rs->common_composition;
                    $dataList[$i]['crdate']  =$rs->crdate;
                    $dataList[$i]['copyright']  =$rs->copyright;
                    $dataList[$i]['fMemId']  =$rs->fMemId;
                    $dataList[$i]['fNickName']  =$rs->fNickName;
                    $dataList[$i]['representative_music']  =$rs->representative_music;
                    $dataList[$i]['file_name']  =$rs->file_name;
                    $dataList[$i]['file_no']  =$rs->file_no;
                    $dataList[$i]['hash_name']  =$rs->hash_name;
                    $dataList[$i]['file_url']  =$rs->file_url;
                    $dataList[$i]['moddate']  =$rs->moddate;
                    $dataList[$i]['file_version']  =$rs->file_version;
                    $dataList[$i]['HeadDelStatus']  =$rs->HeadDelStatus;
                    $dataList[$i]['HeadDelDate']  =$rs->HeadDelDate;
                    $dataList[$i]['wr_comment']  =$rs->wr_comment;
                    $dataList[$i]['totalSeconds']  =gmdate("i:s", $rs->totalSeconds);

                    $resultData2 = $this->apiSoundSorceService->setProfilePhotoList($dataList[$i]);
                    $dataList[$i]['profilePhotoListCount']=count($resultData2);
                    $dataList[$i]['profilePhotoList']=$resultData2;
                    $i++;
                }

                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$dataList;

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

                $resultData = $this->apiSoundSorceService->getSoundSourceData($params);

                $returnData['response']['data']['idx']  =$resultData->idx;
                $returnData['response']['data']['memId']  =$resultData->memId;
                $returnData['response']['data']['memName']  =$resultData->memName;
                $returnData['response']['data']['fileCnt']  =$resultData->fileCnt;
                $returnData['response']['data']['musicTitle']  =$resultData->musicTitle;
                $returnData['response']['data']['playTime']  =$resultData->playTime;
                $returnData['response']['data']['openStatus']  =$resultData->openStatus;
                $returnData['response']['data']['salesStatus']  =$resultData->salesStatus;
                $returnData['response']['data']['contract']  =$resultData->contract;
                $returnData['response']['data']['tag']  =$resultData->tag;
                $returnData['response']['data']['progressRate']  =$resultData->progressRate;
                $returnData['response']['data']['commonComposition']  =$resultData->commonComposition;
                $returnData['response']['data']['crdate']  =$resultData->crdate;
                $returnData['response']['data']['copyright']  =$resultData->copyright;
                $returnData['response']['data']['moddate']  =$resultData->moddate;
                $returnData['response']['data']['file_version']  =$resultData->file_version;
                $returnData['response']['data']['modDay']  =$resultData->modDay;
                $returnData['response']['data']['modHour']  =$resultData->modHour;
                $returnData['response']['data']['modMinute']  =$resultData->modMinute;
                $returnData['response']['data']['modSecond']  =$resultData->modSecond;

                $diff = strtotime($resultData->now_date) - strtotime($resultData->moddate);
                $s = 60; //1분 = 60초
                $h = $s * 60; //1시간 = 60분
                $d = $h * 24; //1일 = 24시간
                $y = $d * 30; //1달 = 30일 기준
                $a = $y * 12; //1년

                if ($diff < $s) {
                    $resultTime = $diff . '초전';
                } elseif ($h > $diff && $diff >= $s) {
                    $resultTime = round($diff/$s) . '분전';
                } elseif ($d > $diff && $diff >= $h) {
                    $resultTime = round($diff/$h) . '시간전';
                } elseif ($y > $diff && $diff >= $d) {
                    $resultTime = round($diff/$d) . '일전';
                } elseif ($a > $diff && $diff >= $y) {
                    $resultTime = round($diff/$y) . '달전';
                } else {
                    $resultTime = round($diff/$a) . '년전';
                }

                $returnData['response']['data']['created_at_re']  =$resultTime;
                $params['file_version'] = $resultData->file_version;

                $fileData = $this->apiSoundSorceService->getMusicFileList($params);
                $returnData['response']['fileData']=$fileData;

                if($resultData->commonComposition=="Y"){
                    $ccList = $this->apiSoundSorceService->getCommonCompositionList($params);
                    $returnData['response']['commonCompositionList']=$ccList;
                }else{
                    $returnData['response']['commonCompositionList'] = null;
                }
                $returnData['code']=0;
                $returnData['message']="complete";


            } catch(\Exception $exception){
                throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
            }
        }


        return json_encode($returnData);
    }

    public function soundSourceDel()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();

        $params['music_head_idx'] = $params['music_head_idx'] ?? array();


        try{
            if(count($params['music_head_idx']) == 0){
                $returnData['code'] = -1;
                $returnData['message'] = "파라메터값 오류";
            }else{

                $qData['music_head_idx'] = $params['music_head_idx'];
                $qData['del_date'] = date("Y-m-d H:m:s",strtotime(now().' +10 days'));
                $resultData = $this->apiSoundSorceService->setSoundSourceDel($qData);
                if($resultData){
                    $returnData['code']=0;
                    $returnData['message']="complete";
                }else{
                    $returnData['code']=300;
                    $returnData['message']="처리된 내용이 없습니다.";
                }

            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);

    }

    public function soundFileDel()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();

        $params['music_file_idx'] = $params['music_file_idx'] ?? array();


        try{
            if($params['music_file_idx'] ==""||$params['music_file_idx'] == null){
                $returnData['code'] = -1;
                $returnData['message'] = "파라메터값 오류";
            }else{
                $qData['music_file_idx'] = $params['music_file_idx'];
                $qData['del_date'] = date("Y-m-d H:m:s",strtotime(now().' +10 days'));
                $resultData = $this->apiSoundSorceService->setMusicFileDel($qData);
                if($resultData){
                    $returnData['code']=0;
                    $returnData['message']="complete";
                }else{
                    $returnData['code']=300;
                    $returnData['message']="처리된 내용이 없습니다.";
                }

            }


        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);

    }

    public function soundSourceDelAll()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();

        $params['mem_id'] = $params['mem_id'] ?? 0;


        try{
            if($params['mem_id'] == 0 || $params['mem_id'] == null){
                $returnData['code'] = -1;
                $returnData['message'] = "파라메터값 오류";
            }else{

                $qData['mem_id'] = $params['mem_id'];
                $qData['del_date'] = date("Y-m-d H:m:s",strtotime(now().' +10 days'));
                $resultData = $this->apiSoundSorceService->setSoundSourceDelAll($qData);
                if($resultData){
                    $returnData['code']=0;
                    $returnData['message']="complete";
                }else{
                    $returnData['code']=300;
                    $returnData['message']="처리된 내용이 없습니다.";
                }

            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);

    }

    public function soundFileDelAll()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();

        $params['music_head_idx'] = $params['music_head_idx'] ?? 0;


        try{
            if($params['music_head_idx'] ==""||$params['music_head_idx'] == null){
                $returnData['code'] = -1;
                $returnData['message'] = "파라메터값 오류";
            }else{
                $qData['music_head_idx'] = $params['music_head_idx'];
                $qData['del_date'] = date("Y-m-d H:m:s",strtotime(now().' +10 days'));
                $resultData = $this->apiSoundSorceService->setMusicFileDelAll($qData);
                if($resultData){
                    $returnData['code']=0;
                    $returnData['message']="complete";
                }else{
                    $returnData['code']=300;
                    $returnData['message']="처리된 내용이 없습니다.";
                }

            }


        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function soundSourceDelCancel()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();

        $params['music_head_idx'] = $params['music_head_idx'] ?? array();


        try{
            if(count($params['music_head_idx']) == 0){
                $returnData['code'] = -1;
                $returnData['message'] = "파라메터값 오류";
            }else{

                $qData['music_head_idx'] = $params['music_head_idx'];
                $qData['del_date'] = date("Y-m-d H:m:s",strtotime(now().' +10 days'));
                $resultData = $this->apiSoundSorceService->setSoundSourceDelCancle($qData);
                if($resultData){
                    $returnData['code']=0;
                    $returnData['message']="complete";
                }else{
                    $returnData['code']=300;
                    $returnData['message']="처리된 내용이 없습니다.";
                }

            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);

    }

    public function soundFileDelCancle()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        $params = $this->request->input();

        $params['music_file_idx'] = $params['music_file_idx'] ?? array();


        try{
            if($params['music_file_idx'] ==""||$params['music_file_idx'] == null){
                $returnData['code'] = -1;
                $returnData['message'] = "파라메터값 오류";
            }else{
                $qData['music_file_idx'] = $params['music_file_idx'];
                $qData['del_date'] = date("Y-m-d H:m:s",strtotime(now().' +10 days'));
                $resultData = $this->apiSoundSorceService->setMusicFileDelCancle($qData);
                if($resultData){
                    $returnData['code']=0;
                    $returnData['message']="complete";
                }else{
                    $returnData['code']=300;
                    $returnData['message']="처리된 내용이 없습니다.";
                }

            }


        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);

    }


    public function contract(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $resultData = $this->apiSoundSorceService->getContract();
            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']=$resultData;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function searchTag(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";
        $params = $this->request->input();

        $params['mem_id'] = $params['mem_id'] ?? 0;

        try{
            $resultData = $this->apiSoundSorceService->getTag($params);
            $tempString ="";
            foreach ($resultData as $rs){
                $tempString .= $rs->tag.',';
            }
            $tagArray = explode(',', $tempString);
            $tagArray = array_filter($tagArray);

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']=$tagArray;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }
}
