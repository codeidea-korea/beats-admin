<?php

namespace App\Http\Controllers;

use App\Service\MemberServiceImpl;
use App\Service\ApiHomeServiceImpl;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
            $params['bk_search_at'] = $atexplode[1];
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
        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;
        $params['idx'] = $idx ?? '';
        //$sample = $this->memberService->bannerSample($params);

        $musicList = $this->memberService->getMusicList($params);
        $musicTotal = $this->memberService->getMusicTotal($params);
        $totalCount = $musicTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('member.musicList',[
            'params' => $params
            ,'searchData' => $params
            ,'musicList' => $musicList
            ,'totalCount' => $totalCount
        ]);
    }

    public function getMemberView($idx){
        $params = $this->request->input();
        $params['menuCode'] = "AD030100";
        $params['idx'] =$idx;
        $memberData = $this->memberService->getMemberData($params);
        var_dump($memberData);
        return view('member.memberView',[
            'params' => $params
            ,'memberData' => $memberData

        ]);
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

}
