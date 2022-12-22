<?php

namespace App\Http\Controllers;

use App\Service\ApiHomeServiceImpl;
use App\Service\MemberServiceImpl;
use App\Service\MentoServiceImpl;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserPoint;
use Illuminate\Support\Facades\File;

use Response;
use Illuminate\Http\Request;
use Session;

class MentoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $mentoService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->mentoService = new MentoServiceImpl();
        $this->memberService = new MemberServiceImpl();
        $this->apiHomeService = new ApiHomeServiceImpl();


        $this->middleware('auth');
    }

    public function getMentoList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD040100";

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['mento_status'] = $params['mento_status'] ?? '';
        $params['gubun'] = $params['gubun'] ?? '';
        $params['channel'] = $params['channel'] ?? '';
        $params['nationality'] = $params['nationality'] ?? '';
        $params['sWord'] = $params['sWord'] ?? '';
        $params['created_at'] = $params['created_at'] ?? "2022-01-01 - ".date("Y-m-d");
        $params['mem_moddate'] = $params['mem_moddate'] ?? "2022-01-01 - ".date("Y-m-d");

        $tempData = trim(str_replace('-','',$params['created_at']));
        $params['sDate']=substr($tempData,0,8);
        $params['eDate']=substr($tempData,8,16);
        $params['eDate'] = date("Ymd",strtotime($params['eDate'].' +1 days'));

        $tempData = trim(str_replace('-','',$params['mem_moddate']));
        $params['sDate2']=substr($tempData,0,8);
        $params['eDate2']=substr($tempData,8,16);
        $params['eDate2'] = date("Ymd",strtotime($params['eDate2'].' +1 days'));

        $nationality = $this->apiHomeService->getCodeList($params);
        $memberList = $this->mentoService->getMentoChList($params);
        $memberTotal = $this->mentoService->getMentoChTotal($params);
        $totalCount = $memberTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('mento.mentoList',[
            'params' => $params
            ,'searchData' => $params
            ,'nationality' => $nationality
            ,'memberList' => $memberList
            ,'totalCount' => $totalCount
        ]);
    }

    public function setMentoCh(){
        $params = $this->request->input();
        $params['mem_id_arr'] = $params['mem_id_arr'] ?? null;
        $sqlData = array();
        $memCnt=count($params['mem_id_arr']);
        $inCnt = 0;

        if($params['mem_id_arr'] != null){
            foreach($params['mem_id_arr'] as $rs){
                $sqlData['mem_id'] = $rs;
                $sqlData['gubun']='4';
                $sqlData['mento_status']=3;
                $result = $this->mentoService->setMentoChData($sqlData);
                if($result){$inCnt++;}
            }

        }
        if($inCnt > 0){
            if($inCnt == $memCnt){
                $rData['result']="SUCCESS";
                $rData['chCnt']=$inCnt;
                $rData['message']="총 ".$inCnt."명의 회원이 멘토 뮤지션 전환 승인이 완료되었습니다.";
            }else{
                $rData['result']="not enough";
                $rData['chCnt']=$inCnt;
                $rData['message']="총 ".$memCnt."명중 ".$inCnt."명의 회원만 멘토 뮤지션 전환 승인이 완료되었습니다.";
            }

        }else{
            $rData['result']="FAIL";
            $rData['chCnt']=0;
            $rData['message']="멘토뮤지션 승인 실패";
        }
        return json_encode($rData);

    }

    public function mentoChDownloadExcel(){
        $params = $this->request->input();

        $params['type'] = $params['type'] ?? 0;
        $params['mento_status'] = $params['mento_status'] ?? '';
        $params['gubun'] = $params['gubun'] ?? '';
        $params['channel'] = $params['channel'] ?? '';
        $params['nationality'] = $params['nationality'] ?? '';
        $params['sWord'] = $params['sWord'] ?? '';
        $params['created_at'] = $params['created_at'] ?? "2022-01-01 - ".date("Y-m-d");
        $params['mem_moddate'] = $params['mem_moddate'] ?? "2022-01-01 - ".date("Y-m-d");

        $tempData = trim(str_replace('-','',$params['created_at']));
        $params['sDate']=substr($tempData,0,8);
        $params['eDate']=substr($tempData,8,16);
        $params['eDate'] = date("Ymd",strtotime($params['eDate'].' +1 days'));

        $tempData = trim(str_replace('-','',$params['mem_moddate']));
        $params['sDate2']=substr($tempData,0,8);
        $params['eDate2']=substr($tempData,8,16);
        $params['eDate2'] = date("Ymd",strtotime($params['eDate2'].' +1 days'));

        $mentoChList = $this->mentoService->getMentoChExcelList($params);

        $params['fileName'] = 'mentoCh)'.date("YmdHms").'.xls';

        return view('mento.mentoChExcel',[
            'mentoChList' => $mentoChList
            ,'params' => $params
        ]);
    }

    public function getMentoView($idx)
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD040100";
        $params['mem_id'] = $idx ?? 0;
        $memberData = $this->mentoService->getMentoChData($params);
        $mentoFileData = $this->mentoService->getMentoChFile($params);

        return view('mento.mentoView',[
            'params' => $params
            ,'memberData' => $memberData
            ,'mentoFileData' => $mentoFileData
        ]);
    }

    public function setMentoChUpdate(){
        $params = $this->request->input();
        $params['mem_id'] = $params['mem_id'] ?? 0;
        $params['mento_status'] = $params['mento_status'] ?? 2;
        $params['gubun'] = $params['gubun'] ?? '';
        $params['reject'] = $params['reject'] ?? '';

        $qParams['idx'] = $params['mem_id'];
        $memberData = $this->memberService->getMemberData($qParams);


        $params['field1'] = $memberData->field1;
        $params['field2'] = $memberData->field2;
        $params['field3'] = $memberData->field3;


        $result=0;
        if($params['mem_id']!=0){

            if($params['mento_status']==1){
                // 반려
                $result = $this->mentoService->setMentoChData($params);
            }elseif($params['mento_status']==2){
                // 대기
                $result = $this->mentoService->setMentoChData($params);
            }elseif($params['mento_status']==3){
                // 승인
                $params['gubun']='4';
                $result = $this->mentoService->setMentoChData($params);
            }

            if($result){
                $rData['result']="SUCCESS";
            }else{
                $rData['result']="FAIL";
            }

        }else{
            $rData['result']="FAIL";
        }
        return $rData;
    }

    public function getFieldList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD040300";


        $fieldList = $this->mentoService->getFieldList($params);
        $params['totalCnt'] = count($fieldList);

        return view('mento.fieldList',[
            'params' => $params
            ,'fieldList' => $fieldList
        ]);
    }

    public function setFieldUpdate(){
        $params = $this->request->input();
        $sqlParam['idx'] = $params['idx'];
        $sqlParam['code'] = $params['code'];
        $sqlParam['field_name'] = $params['field_name'];

        $result =  $this->mentoService->setFildUpdate($sqlParam);
        if($result){
            return array(
                'resultCode' => 'SUCCESS'
                ,'resultMessage' => '분야 정보가 수정되었습니다.'
            );
        }else{
            return array(
                'resultCode' => 'FAIL'
                ,'resultMessage' => '처리 실패'
            );
        }
    }

    public function setFieldInsert(){
        $params = $this->request->input();
        $sqlParam['code'] = $params['code'];
        $sqlParam['field_name'] = $params['field_name'];

        $result =  $this->mentoService->setFildInsert($sqlParam);
        if($result){
            return array(
                'resultCode' => 'SUCCESS'
                ,'resultMessage' => '분야 정보가 등록되었습니다.'
            );
        }else{
            return array(
                'resultCode' => 'FAIL'
                ,'resultMessage' => '처리 실패'
            );
        }
    }

    public function fileDownload(){
        ##### 이미지 파일 다운로드_START
        $params = $this->request->input();

        if($params['cnt'] == 1){
            File::cleanDirectory(public_path('storage_mento'));
        }

        $image_url = $params['url'];
        $image_info = parse_url($image_url);
        $image_name = basename($image_info['path']); // top_logo.png
        file_put_contents('./storage_mento/'.$image_name,file_get_contents($image_url));
        return array(
            'url' => '/storage_mento/'.$image_name
        );
        ##### 이미지 파일 다운로드_END
    }

    public function fieldStatus(){
        $params = $this->request->input();
        $sqlParam['idx'] = $params['idx'];
        $sqlParam['isuse'] = $params['isuse'];

        $result =  $this->mentoService->setFieldStatus($sqlParam);
        if($result){
            return array(
                'resultCode' => 'SUCCESS'
                ,'resultMessage' => '분야 정보가 수정되었습니다.'
            );
        }else{
            return array(
                'resultCode' => 'FAIL'
            ,'resultMessage' => '처리 실패'
            );
        }
    }

    public function getMentoChLog()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD040100";

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['mento_status'] = $params['mento_status'] ?? '';
        $params['gubun'] = $params['gubun'] ?? '';
        $params['channel'] = $params['channel'] ?? '';
        $params['nationality'] = $params['nationality'] ?? '';
        $params['sWord'] = $params['sWord'] ?? '';
        $params['created_at'] = $params['created_at'] ?? "2022-01-01 - ".date("Y-m-d");
        $params['mem_moddate'] = $params['mem_moddate'] ?? "2022-01-01 - ".date("Y-m-d");

        $tempData = trim(str_replace('-','',$params['created_at']));
        $params['sDate']=substr($tempData,0,8);
        $params['eDate']=substr($tempData,8,16);
        $params['eDate'] = date("Ymd",strtotime($params['eDate'].' +1 days'));

        $tempData = trim(str_replace('-','',$params['mem_moddate']));
        $params['sDate2']=substr($tempData,0,8);
        $params['eDate2']=substr($tempData,8,16);
        $params['eDate2'] = date("Ymd",strtotime($params['eDate2'].' +1 days'));

        $memberList = $this->mentoService->getMentoChLog($params);
        $memberTotal = $this->mentoService->getMentoChLogTotal($params);
        $totalCount = $memberTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('mento.mentoChLog',[
            'params' => $params
            ,'searchData' => $params
            ,'memberList' => $memberList
            ,'totalCount' => $totalCount
        ]);
    }

}
