<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\MemberServiceImpl;
use App\Service\ApiMemberServiceImpl;
use Illuminate\Http\Request;
use Response;
use Session;

class ApiMemberController extends Controller
{
    private $request;
    private $memberService;
    private $apiMemberService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->memberService = new MemberServiceImpl();
        $this->apiMemberService = new ApiMemberServiceImpl();
    }

    public function apiLogin()
    {

        try{

            $params = $this->request->input();
            $params['sns'] = $params['sns'] ?? "email";
            $params['snsKey'] = $params['snsKey'] ?? "";
            $params['emailId'] = $params['emailId'] ?? "";
            $params['password'] = $params['password'] ?? "";


            if($params['sns']=="email"){
                //이메일로 로그인할경우
                if($params['emailId']==""||$params['password']=="") {
                    $returnData['code'] = -1;
                    $returnData['message'] = "아이디 또는 비밀번호가 누락되었습니다.";
                }else{
                    $result = $this->apiMemberService->getLogin($params);

                    $returnData['code']=0;
                    $returnData['message']="messageSample!!";
                    $returnData['response']=$result;
                }
            }else{
                //sns로 로그인할경우

            }

            return json_encode($returnData);

            /* 토큰생성 old한 방법으로 front와는 상관없이 생성할경우 이용. 로그인 계정 연동시에는 front-end에서 생성한 토큰을 back-end에서 db에 저장 관리하는형식으로..  */
            // define('SECRET', now());
            // for ($i=0; $i<8; $i++) $str = 'A';//rand_alphanumeric();
            // $returnData['_token']=$str . md5($str . SECRET);
            /* 토큰값 종료*/


        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

    }

    public function testList()
    {

        try{
            $params = $this->request->input();

            $params['type'] = $params['type'] ?? 0;
            $params['page'] = $params['page'] ?? 1;
            $params['limit'] = $params['limit'] ?? 10;

            $memberList = $this->memberService->getMemberList($params);

            $returnData['code']=0;
            $returnData['message']="messageSample!!";
            $returnData['response']=$memberList;
            /* 토큰생성 old한 방법으로 front와는 상관없이 생성할경우 이용. 로그인 계정 연동시에는 front-end에서 생성한 토큰을 back-end에서 db에 저장 관리하는형식으로..  */
            // define('SECRET', now());
            // for ($i=0; $i<8; $i++) $str = 'A';//rand_alphanumeric();
            // $returnData['_token']=$str . md5($str . SECRET);
            /* 토큰값 종료*/


            return json_encode($returnData);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

    }
}
