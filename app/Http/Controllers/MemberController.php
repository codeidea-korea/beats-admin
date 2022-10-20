<?php

namespace App\Http\Controllers;

use App\Service\MemberServiceImpl;
use App\Service\ApiHomeServiceImpl;
use App\Service\ApiSoundSourceServiceImpl;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserPoint;

use Response;
use Illuminate\Http\Request;
use Session;

class MemberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $memberService;
    private $apiHomeService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->memberService = new MemberServiceImpl();
        $this->apiHomeService = new ApiHomeServiceImpl();
        $this->apiSoundSorceService = new ApiSoundSourceServiceImpl();

        $this->middleware('auth');
    }

    public function getMemberList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD030100";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['class'] = $params['class'] ?? '';
        $params['gubun'] = $params['gubun'] ?? '';
        $params['channel'] = $params['channel'] ?? '';
        $params['nationality'] = $params['nationality'] ?? '';
        $params['mem_status'] = $params['mem_status'] ?? '';
        $params['sWord'] = $params['sWord'] ?? '';
        $params['searchDate'] = $params['searchDate'] ?? "2022-01-01 - ".date("Y-m-d");
        $params['mem_regdate'] = $params['mem_regdate'] ?? "2022-01-01 - ".date("Y-m-d");
        $tempData = trim(str_replace('-','',$params['searchDate']));
        $params['sDate']=substr($tempData,0,8);
        $params['eDate']=substr($tempData,8,16);
        $params['eDate'] = date("Ymd",strtotime($params['eDate'].' +1 days'));
        //$sample = $this->memberService->bannerSample($params);

        $params['codeIndex'] = $params['codeIndex'] ?? 'CT000000';
        $nationality = $this->apiHomeService->getCodeList($params);

        $memberList = $this->memberService->getMemberList($params);
        $memberTotal = $this->memberService->getMemberTotal($params);
        $totalCount = $memberTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('member.memberList',[
            'params' => $params
            ,'searchData' => $params
            ,'memberList' => $memberList
            ,'totalCount' => $totalCount
            ,'nationality' => $nationality
        ]);
    }

    public function getPointMemberList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD030100";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        //$sample = $this->memberService->bannerSample($params);

        if($params['mem_regdate'] != ''){
            $atexplode = explode(' - ',$params['mem_regdate']);
            $params['fr_search_at'] = $atexplode[0];
            $params['bk_search_at'] = date("Y-m-d",strtotime($atexplode[1].' +1 days'));
        }

        $memberList = $this->memberService->getPointMemberList($params);
        $memberTotal = $this->memberService->getPointMemberTotal($params);
        $totalCount = $memberTotal->cnt;
        $params['totalCnt'] = $totalCount;

        $result = array(
            'resultCode' => 'SUCCESS'
        );

        if($memberList && $memberTotal){
            $result['totalCount'] = $totalCount;
            $result['memberList'] = $memberList;
        }else{
            $result['resultCode'] = "FAIL";
            $result['resultMessage'] = "회원 리스트 불러오기가 실패하였습니다. 다시 시도해주세요";
        }

        return json_encode($result);
    }

    public function sendPoint()
    {
        $params = $this->request->input();
        //$sample = $this->memberService->bannerSample($params);
        $params['increase'] = $params['increase'] ?? '';
        $params['amount'] = $params['amount'] ?? 0;
        $params['reason'] = $params['reason'] ?? '';

        $result = array(
            'resultCode' => 'SUCCESS'
        );

        $sendPoint = $this->memberService->sendPoint($params);

        $result['resultSuccess'] = $sendPoint['success'];
        $result['resultFails'] = $sendPoint['fails'];
        if($sendPoint['fails'] > 0){
            $result['resultMessage'] = "포인트 지급에 ".$sendPoint['success']."명 성공 ".$sendPoint['fails']."명 실패하였습니다.";
        }else{
            $result['resultMessage'] = "포인트가 모두 지급되었습니다.";
        }

        return json_encode($result);
    }

    public function getPaging()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD030100";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['totalCnt'] = $params['totalCount'] ?? 0;
        //$sample = $this->memberService->bannerSample($params);

        $result = array(
            'resultCode' => 'SUCCESS'
        );

        $result['paging'] = view('vendor.pagination.paging',[
            'params' => $params
            ,'searchData' => $params
        ])->render();

        return json_encode($result);
    }

    public function getMusicList($idx)
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD030100";
        $params['idx'] = $idx ?? '';
        $params['mem_id'] = $params['idx'];
        $params['progress_rate'] = $params['progress_rate'] ?? '';
        $params['common_composition'] = $params['common_composition'] ?? '';
        $params['sales_status'] = $params['sales_status'] ?? '';
        $params['open_status'] = $params['open_status'] ?? '';
        $params['search_text'] = $params['search_text'] ?? '';

        $musicList = $this->apiSoundSorceService->setSoundSourceList($params);

        return view('member.musicList',[
            'params' => $params
            ,'searchData' => $params
            ,'musicList' => $musicList
        ]);
    }

    public function getMemberView($idx){
        $params = $this->request->input();
        $params['menuCode'] = "AD030100";
        $params['idx'] =$idx;
        $memberData = $this->memberService->getMemberData($params);

        return view('member.memberView',[
            'params' => $params
            ,'memberData' => $memberData

        ]);
    }

    public function memberUpdate(){
        $params = $this->request->input();
        $data = array();

        $data['mem_id'] = $params['mem_id'];
        $data['mem_status'] = $params['mem_status'];

        $result = $this->memberService->setMemberUpdate($data);

        if($result){
            $rData['result']="SUCCESS";
        }else{
            $rData['result']="FAIL";
        }
        return json_encode($rData);
    }


    public function getInviteList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD030200";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['class'] = $params['class'] ?? '';
        $params['gubun'] = $params['gubun'] ?? '';
        $params['channel'] = $params['channel'] ?? '';
        $params['nationality'] = $params['nationality'] ?? '';
        $params['mem_status'] = $params['mem_status'] ?? '';
        $params['sWord'] = $params['sWord'] ?? '';
        $params['searchDate'] = $params['searchDate'] ?? "2022-01-01 - ".date("Y-m-d");
        $tempData = trim(str_replace('-','',$params['searchDate']));
        $params['sDate']=substr($tempData,0,8);
        $params['eDate']=substr($tempData,8,16);
        $params['eDate'] = date("Ymd",strtotime($params['eDate'].' +1 days'));

        $params['codeIndex'] = $params['codeIndex'] ?? 'CT000000';
        $nationality = $this->apiHomeService->getCodeList($params);

        //$memberList = $this->memberService->getMemberList($params);
        //$memberTotal = $this->memberService->getMemberTotal($params);
        //$totalCount = $memberTotal->cnt;
        //$params['totalCnt'] = $totalCount;
        $params['totalCnt'] = 0;

        return view('member.inviteList',[
            'params' => $params
            ,'searchData' => $params
            //,'memberList' => $memberList
            ,'totalCount' => $params['totalCnt']
            ,'nationality' => $nationality
        ]);
    }

    public function getWithdrawalList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD030300";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['class'] = $params['class'] ?? '';
        $params['gubun'] = $params['gubun'] ?? '';
        $params['channel'] = $params['channel'] ?? '';
        $params['nationality'] = $params['nationality'] ?? '';
        $params['mem_status'] = $params['mem_status'] ?? '';
        $params['sWord'] = $params['sWord'] ?? '';
        $params['searchDate'] = $params['searchDate'] ?? "2022-01-01 - ".date("Y-m-d");
        $tempData = trim(str_replace('-','',$params['searchDate']));
        $params['sDate']=substr($tempData,0,8);
        $params['eDate']=substr($tempData,8,16);
        $params['eDate'] = date("Ymd",strtotime($params['eDate'].' +1 days'));

        $params['codeIndex'] = $params['codeIndex'] ?? 'CT000000';
        $nationality = $this->apiHomeService->getCodeList($params);

        //$memberList = $this->memberService->getMemberList($params);
        //$memberTotal = $this->memberService->getMemberTotal($params);
        //$totalCount = $memberTotal->cnt;
        //$params['totalCnt'] = $totalCount;
        $params['totalCnt'] = 0;

        return view('member.withdrawalList',[
            'params' => $params
            ,'searchData' => $params
            //,'memberList' => $memberList
            ,'totalCount' => $params['totalCnt']
            ,'nationality' => $nationality
        ]);
    }
    public function getNotifyList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD030400";
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['class'] = $params['class'] ?? '';
        $params['gubun'] = $params['gubun'] ?? '';
        $params['channel'] = $params['channel'] ?? '';
        $params['nationality'] = $params['nationality'] ?? '';
        $params['mem_status'] = $params['mem_status'] ?? '';
        $params['sWord'] = $params['sWord'] ?? '';
        $params['searchDate'] = $params['searchDate'] ?? "2022-01-01 - ".date("Y-m-d");
        $tempData = trim(str_replace('-','',$params['searchDate']));
        $params['sDate']=substr($tempData,0,8);
        $params['eDate']=substr($tempData,8,16);
        $params['eDate'] = date("Ymd",strtotime($params['eDate'].' +1 days'));

        $params['codeIndex'] = $params['codeIndex'] ?? 'CT000000';


        //$memberList = $this->memberService->getMemberList($params);
        //$memberTotal = $this->memberService->getMemberTotal($params);
        //$totalCount = $memberTotal->cnt;
        //$params['totalCnt'] = $totalCount;
        $params['totalCnt'] = 0;

        return view('member.notifyList',[
            'params' => $params
            ,'searchData' => $params
            //,'memberList' => $memberList
            ,'totalCount' => $params['totalCnt']

        ]);
    }

    public function getMemoList(){
        $params = $this->request->input();
        $params['menuCode'] = "AD120100";

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['mem_id'] = $params['mem_id'] ?? 0;
        $memoList = $this->memberService->getMemoList($params);
        $memoTotal = $this->memberService->getMemoTotal($params);
        $totalCount = $memoTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('member.ajax.memoList',[
            'params' => $params
            ,'searchData' => $params
            ,'memoList' => $memoList
            ,'totalCount' => $totalCount

        ]);
    }

    public function setMemoInsert(){

        $params = $this->request->input();
        $data = array();
        $data['mem_id'] = $params['mem_id'];
        $data['adminindex'] = $params['adminindex'];
        $data['memo'] = $params['memo'];




        $result = $this->memberService->setMemoInsert($data);

        if($result){
            $rData['result']="SUCCESS";
        }else{
            $rData['result']="FAIL";
        }
        return json_encode($rData);
    }

    public function setMemoDel(){

        $params = $this->request->input();
        $data = array();
        $data['idx'] = $params['idx'];

        $result = $this->memberService->setMemoDelete($data);

        if($result){
            $rData['result']="SUCCESS";
        }else{
            $rData['result']="FAIL";
        }
        return json_encode($rData);
    }

    public function excelUpload(){

        $params = $this->request->input();
        $folderName = '/excel/'.date("Y/m/d").'/';
        $files = $this->request->file('excelFile');

        $sqlData['file_name'] = $files->getClientOriginalName();
        $sqlData['ext'] = $files->getClientOriginalExtension();
        $sqlData['hash_name'] = $files->hashName();
        $sqlData['file_url'] =  $folderName;
        $files->storeAs($folderName, $files->getClientOriginalName(), 'public');
        $path =  storage_path('app/public'.$sqlData['file_url'].$sqlData['file_name']);
        $excel = Excel::toArray(new UserPoint, $path)[0];
        $params['excel'] = array();
        foreach($excel as $rs){
            array_push($params['excel'],$rs[0]);
        }

        $result = $this->memberService->sendPointMember($params);

        return json_encode($result);
    }
}
