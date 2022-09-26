<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\MemberServiceImpl;
use App\Service\ApiHomeServiceImpl;
use App\Service\ApiMemberServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\HttpException;
use Response;
use Session;

class ApiMemberController extends Controller
{
    private $request;
    private $memberService;
    private $apiMemberService;
    private $apiHomeService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->memberService = new MemberServiceImpl();
        $this->apiMemberService = new ApiMemberServiceImpl();
        $this->apiHomeService = new ApiHomeServiceImpl();
    }

    public function apiLogin()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";
        define('SECRET', now());

        try{

            $params = $this->request->input();
            $params['sns'] = $params['sns'] ?? "email";
            $params['snsKey'] = $params['snsKey'] ?? "";
            $params['emailId'] = $params['emailId'] ?? "";
            $params['password'] = $params['password'] ?? "";


            if($params['sns']=="email"){
                //이메일로 로그인할경우
                if($params['emailId']==""||$params['password']=="") {
                    $returnData['code'] = 301;
                    $returnData['message'] = "아이디 또는 비밀번호가 누락되었습니다.";
                }else{


                    for ($i=0; $i<8; $i++) $str = 'E';
                    $params['_token']=$str . md5($str . SECRET);

                    $result = $this->apiMemberService->getLogin($params);
                    if($result==null){
                        $returnData['code'] = 303;
                        $returnData['message'] = "존재하지 않는  EMAIL 입니다.";
                    }else{
                        $ckPw = Hash::check($params['password'], $result->password);
                        if($ckPw==1){

                            $result2 = $this->apiMemberService->putLogin($params);
                            if($result2){

                                $result3 = $this->apiMemberService->getMemberData($params);

                                $returnData['code']=0;
                                $returnData['message']="로그인 완료";
                                $returnData['response']=$result3;
                                $returnData['_token']=$params['_token'];
                            }else{
                                $returnData['code'] = 600;
                                $returnData['message'] = "시스템 장애가 발생하였습니다. 다시 시도해 주세요.";
                            }

                        }else{
                            $returnData['code'] = 302;
                            $returnData['message'] = "비밀번호가 일치하지 않습니다.";
                        }
                    }

                }
            }else{

                //SNS로 로그인할경우 ||$params['password']==""
                if($params['snsKey']=="") {
                    $returnData['code'] = 301;
                    $returnData['message'] = "SNS 키값이 누락되었습니다.";

                }else{


                    for ($i=0; $i<8; $i++) $str = 'E';
                    $params['_token']=$str . md5($str . SECRET);

                    $result = $this->apiMemberService->getLogin($params);

                    if($result==null){
                        $returnData['code'] = 303;
                        $returnData['message'] = "존재하지 않는  SNS 입니다.";
                    }else{
                        //$ckPw = Hash::check($params['password'], $result->password);
                        //if($ckPw==1){

                        $result2 = $this->apiMemberService->putLogin($params);
                        if($result2){
                            $result3 = $this->apiMemberService->getMemberData($params);
                            $returnData['code']=0;
                            $returnData['message']="로그인 완료";
                            $returnData['response']=$result3;
                            $returnData['_token']=$params['_token'];
                        }else{
                            $returnData['code'] = 600;
                            $returnData['message'] = "시스템 장애가 발생하였습니다. 다시 시도해 주세요.";
                        }

                        /*}else{
                            $returnData['code'] = 302;
                            $returnData['message'] = "비밀번호가 일치하지 않습니다.";
                        }*/
                    }

                }

            }

            /* 토큰생성 old한 방법으로 front와는 상관없이 생성할경우 이용. 로그인 계정 연동시에는 front-end에서 생성한 토큰을 back-end에서 db에 저장 관리하는형식으로..  */
            // define('SECRET', now());
            // for ($i=0; $i<8; $i++) $str = 'A';//rand_alphanumeric();
            // $returnData['_token']=$str . md5($str . SECRET);
            /* 토큰값 종료*/


        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function loginCheck()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['sns'] = $params['sns'] ?? "email";
            $params['snsKey'] = $params['snsKey'] ?? "";
            $params['emailId'] = $params['emailId'] ?? "";
            $params['_token'] = $params['_token'] ?? "";

            $result = $this->apiMemberService->loginCheck($params);

            $returnData['code']=0;
            $returnData['message']="로그인 유지 확인";
            $returnData['response']=$result;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function joinCheck()
    {
        $params = $this->request->input();
        $params['sns'] = $params['sns'] ?? "email";
        $params['snsKey'] = $params['snsKey'] ?? "";
        $params['emailId'] = $params['emailId'] ?? "";

        if(($params['sns'] != '' && $params['snsKey'] != '') || ($params['sns'] != '' && $params['emailId'] != '')){
            $result = $this->apiMemberService->joinCheck($params);

            if(empty($result)){
                $response = 0;
            }else{
                $response = $result->class;
            }

            $returnData['code']=0;
            $returnData['message']="회원가입 확인";
            $returnData['response']=$response;

        }else{

            $returnData['code']=1;
            $returnData['message']="회원가입 확인 실패";
        }

        return json_encode($returnData);
    }

    public function nicknameCheck()
    {
        $params = $this->request->input();
        $params['nickName'] = $params['nickName'] ?? "";

        $result = $this->apiMemberService->nicknameCheck($params);

        if(empty($result)){
            $returnData['code']=1;
            $returnData['message']="닉네임 중복 없음";
        }else{
            $returnData['code']=0;
            $returnData['message']="닉네임 중복";
        }

        return json_encode($returnData);
    }

    public function apiJoin()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['existing_yn'] = $params['existing_yn'] ?? "";
            $params['sns'] = $params['sns'] ?? "email";
            $params['snsKey'] = $params['snsKey'] ?? "";
            $params['emailId'] = $params['emailId'] ?? "";
            $params['password'] = $params['password'] ?? "";
            $params['sign_site'] = $params['signSite'] ?? "";
            $params['apple_key'] = $params['appleKey'] ?? null;
            $params['naver_key'] = $params['naverKey'] ?? null;
            $params['kakao_key'] = $params['kakaoKey'] ?? null;
            $params['google_key'] = $params['googleKey'] ?? null;
            $params['facebook_key'] = $params['facebookKey'] ?? null;
            $params['twitter_key'] = $params['twitterKey'] ?? null;
            $params['soundcloud_key'] = $params['soundcloudKey'] ?? null;
            $params['gubun'] = $params['gubun'] ?? 2;
            $params['email'] = $params['email'] ?? $params['emailId'];
            $params['name'] = $params['name'] ?? "";
            $params['mem_nickname'] = $params['memNickname'] ?? "";
            $params['nationality'] = $params['nationality'] ?? "";
            $params['phone_number'] = $params['phoneNumber'] ?? "";
            $params['marketing_consent'] = $params['marketingConsent'] ?? "";
            $params['existingEmailId'] = $params['existingEmailId'] ?? "";

            if($params['existing_yn'] == ''){
                $returnData['code'] = 1;
                $returnData['message'] = "기존회원과 통합회원을 구분해 주세요";
            }else{
                if($params['existing_yn'] == 'Y'){

                    $result = $this->apiMemberService->integratedTransform($params);

                    $returnData['code']=0;
                    $returnData['message']="통합회원 전환 완료";
                    $returnData['response']=$result;

                }else{
                    if(($params['snsKey'] == "" && $params['emailId'] == "") || $params['password'] == "" || $params['sign_site'] == "" || $params['name'] == "" || $params['mem_nickname'] == "" || $params['nationality'] == ""
                    || $params['phone_number'] == "" || $params['marketing_consent'] == ""){

                        $returnData['code'] = 2;
                        $returnData['message'] = "입력하지 않은 필수 값이 있습니다. 필수 값을 입력해 주세요";

                    }else{

                        if($params['sns'] != 'email'){
                            $params[$params['sns'].'_key'] = $params['snsKey'];
                        }

                        $result = $this->apiMemberService->apiJoin($params);

                        if($params['existingEmailId'] != ""){
                            $memberStatusTransform = $this->apiMemberService->memberStatusTransform($params);
                        }

                        $returnData['code']=0;
                        $returnData['message']="회원가입 완료";
                        $returnData['response']=$result;
                    }
                }
            }
        } catch(\Exception $exception){
            //throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
            echo $exception;
        }

        return json_encode($returnData);
    }

    public function getTerms()
    {
        $params = $this->request->input();
        $params['termsType'] = $params['termsType'] ?? 'all';

        if($params['termsType'] == 'all'){
            $params['termsType'] = $this->apiMemberService->getTermsCode($params);
            //$params['termsType'] = array('TE010100','TE010200','TE010300','TE020100','TE020200','TE020300');
        }

        $result = $this->apiMemberService->getTerms($params);

        $returnData['code']=0;
        $returnData['message']="messageSample!!";
        $returnData['response']=$result;

        return json_encode($returnData);
    }

    public function getNationality(){
        $params = $this->request->input();
        $params['codeIndex'] = $params['codeIndex'] ?? 'CT000000';

        $result = $this->apiHomeService->getCodeList($params);


        $returnData['code']=0;
        $returnData['message']="messageSample!!";
        $returnData['response']=$result;

        return json_encode($returnData);
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
