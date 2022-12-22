<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\MemberServiceImpl;
use App\Service\MemberNoticeServiceImpl;
use App\Service\ApiHomeServiceImpl;
use App\Service\ApiMemberServiceImpl;
use App\Service\ApiMentoServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Response;
use Session;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class ApiMemberController extends Controller
{
    private $request;
    private $memberService;
    private $memberNoticeService;
    private $apiMemberService;
    private $apiHomeService;
    private $apiMentoService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->memberService = new MemberServiceImpl();
        $this->memberNoticeService = new MemberNoticeServiceImpl();
        $this->apiMemberService = new ApiMemberServiceImpl();
        $this->apiHomeService = new ApiHomeServiceImpl();
        $this->apiMentoService = new ApiMentoServiceImpl();

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
            $params['last_login_ip'] =$params['last_login_ip'] ?? "";


            if($params['sns']=="email"){
                //이메일로 로그인할경우
                if($params['emailId']==""||$params['password']=="") {
                    $returnData['code'] = 301;
                    $returnData['message'] = "아이디 또는 비밀번호가 누락되었습니다.";
                }else{


                    for ($i=0; $i<8; $i++) $str = 'E';
                    $params['_token']=$str . md5($str .$params['emailId']. SECRET);

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

                                if($result3->memStatus == 1 || $result3->memStatus == 0){
                                    $returnData['code']=0;
                                    $returnData['message']="로그인 완료";
                                    $returnData['response']=$result3;
                                    $returnData['_token']=$params['_token'];
                                }else{

                                    $returnData['code']=601;

                                    if($result3->memStatus == 2){
                                        $returnData['message'] = "제재된 회원입니다. 로그인 할 수 없습니다";
                                        $returnData['response'] = $result3;
                                    }else{
                                        $returnData['message'] = "휴면 회원입니다. 로그인 할 수 없습니다";
                                        $returnData['response'] = $result3;
                                    }
                                }
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
                    $params['_token']=$str . md5($str.$params['emailId'] . SECRET);

                    $result = $this->apiMemberService->getLogin($params);

                    $login_check = false;
                    $login_check_naver = false;

                    if($result==null){

                        if($params['sns'] == 'naver'){
                            $naver_result = $this->apiMemberService->getLoginNaver($params);
                            if($naver_result){
                                $login_check = true;
                                $login_check_naver = true;
                            }
                        }else{
                            $returnData['code'] = 303;
                            $returnData['message'] = "존재하지 않는  SNS 입니다.";
                        }
                    }else{
                        //$ckPw = Hash::check($params['password'], $result->password);
                        //if($ckPw==1){
                        $login_check = true;
                    }

                    if($login_check){
                        if($login_check_naver){
                            $result2 = $this->apiMemberService->putLoginNaver($params);
                        }else{
                            $result2 = $this->apiMemberService->putLogin($params);
                        }
                        if($result2){
                            if($login_check_naver){
                                $result3 = $this->apiMemberService->getMemberDataNaver($params);
                            }else{
                                $result3 = $this->apiMemberService->getMemberData($params);
                            }

                            if($result3->memStatus == 1 || $result3->memStatus == 0){
                                $returnData['code']=0;
                                $returnData['message']="로그인 완료";
                                $returnData['response']=$result3;
                                $returnData['_token']=$params['_token'];
                            }else{

                                $returnData['code']=601;

                                if($result3->memStatus == 2){
                                    $returnData['message'] = "제재된 회원입니다. 로그인 할 수 없습니다";
                                    $returnData['response'] = $result3;
                                }else{
                                    $returnData['message'] = "휴면 회원입니다. 로그인 할 수 없습니다";
                                    $returnData['response'] = $result3;
                                }
                            }
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
            $params['last_login_ip'] = $params['last_login_ip'] ?? "";


            $result = $this->apiMemberService->loginCheck($params);

            if($result==null){
                if($params['sns'] == 'naver'){
                    $result = $this->apiMemberService->loginCheckNaver($params);
                }
            }

            $returnData['code']=0;
            $returnData['message']="로그인 유지 확인";
            $returnData['response']=$result;

            // if($result){
            //     $result3 = $this->apiMemberService->getMemberData($params);
            //     $returnData['code']=0;
            //     $returnData['message']="로그인 유지 성공";
            //     $returnData['response']=$result3;
            // }else{
            //     $returnData['code']=1;
            //     $returnData['message']="로그인 유지 실패";
            // }

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

        if(($params['sns'] != '' && $params['snsKey'] != '') || ($params['sns'] != '' && $params['emailId'] != '' && $params['emailId'] != 'undefined')){
            $result = $this->apiMemberService->joinCheck($params);

            if(empty($result)){
                $response = 0;
            }else{
                if($result->isuse == 'Y'){
                    $response = $result->class;
                }else{
                    $response = 4;
                }
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

    public function joinEmailCheck()
    {
        $params = $this->request->input();
        $params['emailId'] = $params['emailId'] ?? "";
        $params['sns'] = $params['sns'] ?? "";

        if($params['emailId'] != ''&& $params['emailId'] != 'undefined'){
            $result = $this->apiMemberService->joinEmailCheck($params);

            if(empty($result)){
                $response = 0;
                $channel = null;
            }else{
                if($result->isuse == 'Y'){
                    $response = $result->class;
                    $channel = $result->channel;
                }else{
                    $response = 4;
                    $channel = null;
                }
            }

            $returnData['code']=0;
            $returnData['message']="회원가입 확인";
            $returnData['response']=$response;
            $returnData['channel']=$channel;

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

    public function memberBriefData()
    {
        $params = $this->request->input();
        $params['emailId'] = $params['emailId'] ?? "";

        $result = $this->apiMemberService->memberBriefData($params);

        if(empty($result)){
            $returnData['code']=1;
            $returnData['message']="일치하는 회원의 데이터가 없습니다";
        }else{
            $returnData['code']=0;
            $returnData['message']="간략한 회원 데이터 전송";
            $returnData['response']=$result;
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
            $params['password'] = $params['password'] ?? null;
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
            $params['field1'] = $params['field1'] ?? '';
            $params['field2'] = $params['field2'] ?? '';
            $params['field3'] = $params['field3'] ?? '';
            $params['adisonClickKey'] = $params['adisonClickKey'] ?? '';

            $params['channel'] = $params['sns'];

            $params['created_ip'] =$params['created_ip'] ?? "";

            // 고유id값 [u_id]추출 start
            do {
                $tempUid = $this->apiMemberService->getRandStr();
                $tempData['u_id']=$tempUid;

                $checkUid = $this->apiMemberService->getUidCheck($tempData);
            }while($checkUid->cnt > 0);
            $params['u_id'] = $tempData['u_id'];

            // 고유id값 [u_id]추출 end

            if($params['existing_yn'] == ''){
                $returnData['code'] = 1;
                $returnData['message'] = "기존회원과 통합회원을 구분해 주세요";
            }else{
                if($params['existing_yn'] == 'Y'){

                    $result = $this->apiMemberService->integratedTransform($params);

                    if($result==null){
                        if($params['sns'] == 'naver'){
                            $result = $this->apiMemberService->integratedTransformNaver($params);
                        }
                    }

                    $returnData['code']=0;
                    $returnData['message']="통합회원 전환 완료";
                    $returnData['response']=$result;

                }else{
                    if(($params['snsKey'] == "" && $params['emailId'] == "") || $params['sign_site'] == "" || $params['name'] == "" || $params['mem_nickname'] == "" || $params['nationality'] == ""
                        || $params['marketing_consent'] == ""){

                        $returnData['code'] = 2;
                        $returnData['message'] = "입력하지 않은 필수 값이 있습니다. 필수 값을 입력해 주세요";

                    }else{

                        $joinCheck = $this->apiMemberService->joinEmailCheck($params);

                        if($joinCheck){
                            $returnData['code']=3;
                            $returnData['message']="이미 가입된 이메일입니다.";
                        }else{
                            if($params['sns'] == 'email'){
                                if($params['password'] == null){
                                    $returnData['code'] = 2;
                                    $returnData['message'] = "비밀번호가 누락되었습니다.";
                                }else{
                                    $member_idx = $this->apiMemberService->apiJoin($params);

                                    $params['mem_id'] = $member_idx;

                                    if($params['existingEmailId'] != ""){
                                        $memberStatusTransform = $this->apiMemberService->memberStatusTransform($params);

                                        if($params['sign_site'] == 'bybeats'){
                                            $sqlData['mem_id'] = $params['mem_id'];
                                            $sqlData['gubun'] = '01';
                                            $sqlData['message'] = $params['mem_nickname'].'님, 통합회원으로 전환되었습니다.';
                                            $sqlData['url'] = '';

                                            $result = $this->memberNoticeService->setMemberNotice($sqlData);
                                        }
                                    }else{
                                        if($params['sign_site'] == 'bybeats'){
                                            $sqlData['mem_id'] = $params['mem_id'];
                                            $sqlData['gubun'] = '01';
                                            $sqlData['message'] = '환영해요. '.$params['mem_nickname'].' 작곡가님, 회원가입이 완료되었습니다.';
                                            $sqlData['url'] = '';

                                            $result = $this->memberNoticeService->setMemberNotice($sqlData);
                                        }
                                    }

                                    if($params['gubun'] == 4){

                                        $resultMento = $this->apiMentoService->setChMento($params);

                                        $files = $this->request->file('mento_file');
                                        $folderName = '/mentoFile/'.date("Y/m/d").'/';

                                        if($files != "" && $files !=null){

                                            foreach($files as $fa){

                                                $sqlData['mem_id'] =$params['mem_id'];
                                                $sqlData['file_name'] = $fa->getClientOriginalName();
                                                $sqlData['hash_name'] = $fa->hashName();
                                                $sqlData['file_url'] =  $folderName;
                                                $this->apiMentoService->mentoFileInsert($sqlData);
                                                $path = Storage::disk('s3')->put($folderName. $sqlData['hash_name'], file_get_contents($fa));
                                                $path = Storage::disk('s3')->url($path);
                                            }
                                        }
                                    }

                                    $returnData['code']=0;
                                    $returnData['message']="회원가입 완료";
                                    $returnData['response']=$member_idx;
                                }
                            }else{
                                $params[$params['sns'].'_key'] = $params['snsKey'];

                                $member_idx = $this->apiMemberService->apiJoin($params);

                                $params['mem_id'] = $member_idx;

                                if($params['existingEmailId'] != ""){
                                    $memberStatusTransform = $this->apiMemberService->memberStatusTransform($params);

                                    if($params['sign_site'] == 'bybeats'){
                                        $sqlData['mem_id'] = $params['mem_id'];
                                        $sqlData['gubun'] = '01';
                                        $sqlData['message'] = $params['mem_nickname'].'님, 통합회원으로 전환되었습니다.';
                                        $sqlData['url'] = '';

                                        $result = $this->memberNoticeService->setMemberNotice($sqlData);
                                    }
                                }else{
                                    if($params['sign_site'] == 'bybeats'){
                                        $sqlData['mem_id'] = $params['mem_id'];
                                        $sqlData['gubun'] = '01';
                                        $sqlData['message'] = '환영해요. '.$params['mem_nickname'].' 작곡가님, 회원가입이 완료되었습니다.';
                                        $sqlData['url'] = '';

                                        $result = $this->memberNoticeService->setMemberNotice($sqlData);
                                    }
                                }

                                if($params['gubun'] == 4){

                                    $resultMento = $this->apiMentoService->setChMento($params);

                                    $files = $this->request->file('mento_file');
                                    $folderName = '/mentoFile/'.date("Y/m/d").'/';

                                    if($files != "" && $files !=null){

                                        foreach($files as $fa){

                                            $sqlData['mem_id'] =$params['mem_id'];
                                            $sqlData['file_name'] = $fa->getClientOriginalName();
                                            $sqlData['hash_name'] = $fa->hashName();
                                            $sqlData['file_url'] =  $folderName;
                                            $this->apiMentoService->mentoFileInsert($sqlData);
                                            $path = Storage::disk('s3')->put($folderName. $sqlData['hash_name'], file_get_contents($fa));
                                            $path = Storage::disk('s3')->url($path);
                                        }
                                    }
                                }

                                $returnData['code']=0;
                                $returnData['message']="회원가입 완료";
                                $returnData['response']=$member_idx;
                            }
                        }
                    }
                }
            }
        } catch(\Exception $exception){
            //throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
            echo $exception;
        }

        //if ($returnData['code'] === 0 && $returnData['message'] === '회원가입 완료') {
        //    $this->callAdisonClickKey($params['u_id'], $params['adisonClickKey']);
        //}

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

    public function getNationality()
    {
        $params = $this->request->input();
        $params['codeIndex'] = $params['codeIndex'] ?? 'CT000000';

        $result = $this->apiHomeService->getCodeList($params);


        $returnData['code']=0;
        $returnData['message']="messageSample!!";
        $returnData['response']=$result;

        return json_encode($returnData);
    }

    public function chMemberPrp()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $files = $this->request->file('photo_file');

            $folderName = '/memberPhoto/'.date("Y/m/d").'/';
            $sqlData['file_name'] = $files->getClientOriginalName();
            $sqlData['hash_name'] = $files->hashName();
            $sqlData['photo_url'] = $folderName;
            $sqlData['mem_id'] = $params['mem_id'];

            $path = Storage::disk('s3')->put($folderName. $sqlData['hash_name'], file_get_contents($files));
            $path = Storage::disk('s3')->url($path);

            $result = $this->apiMemberService->profileUpdate($sqlData);

            $returnData['code']=0;
            $returnData['message']="프로필 사진 수정 완료";
            $returnData['response']=$result;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function chMemberNickName()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['mem_nickname'] = $params['mem_nickname'] ?? '';
            $params['label'] = $params['label'] ?? '';



            if($params['mem_id']==0||$params['mem_nickname']==""){
                $returnData['code']=300;
                $returnData['message']="누락된 데이터가 있습니다.";
            }else{
                $result = $this->apiMemberService->nickNameUpdate($params);

                $returnData['code']=0;
                $returnData['message']="닉네임 수정 완료";
                $returnData['response']=$result;
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);

    }

    public function getProfile()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;

            if($params['mem_id']==0){
                $returnData['code']=300;
                $returnData['message']="누락된 데이터가 있습니다.";
            }else{
                $result = $this->apiMemberService->Profile($params);

                $returnData['code']=0;
                $returnData['response']=$result;
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function getMyData()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;

            if($params['mem_id']!=0){

                $result = $this->apiMemberService->getMyData($params);

                $result2 = $this->apiMemberService->getMyMentoFile($params);

                $returnData['code']=0;
                $returnData['message'] = "조회완료";
                $returnData['response']=$result;
                $returnData['mentoFile']=$result2;
            }else{
                $returnData['code']=300;
                $returnData['message']="누락된 데이터가 있습니다.";
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function setMyData()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['email'] = $params['email'] ?? '';
            //$params['name'] = $params['name'] ?? '';
            $params['memNickName'] = $params['memNickName'] ?? '';
            $params['nationality'] = $params['nationality'] ?? '';
            $params['phoneNumber'] = $params['phoneNumber'] ?? '';
            $params['marketingConsent'] = $params['marketingConsent'] ?? 'N';
            $params['gubun'] = $params['gubun'] ?? 2;
            $params['field1'] = $params['field1'] ?? null;
            $params['field2'] = $params['field2'] ?? null;
            $params['field3'] = $params['field3'] ?? null;
            $params['file_idx'] = $params['file_idx'] ?? [];

            $mento_files = $this->request->file('mento_file');


            if($params['mem_id']!=0&&$params['email']!=""){
                $result = $this->apiMemberService->setMyData($params);

                if($params['gubun'] == 4){

                    $folderName = '/mentoFile/'.date("Y/m/d").'/';

                    $this->apiMentoService->delMentoFile($params);

                    if($mento_files != "" && $mento_files !=null){

                        foreach($mento_files as $fa){

                            $sqlData['mem_id'] =$params['mem_id'];
                            $sqlData['file_name'] = $fa->getClientOriginalName();
                            $sqlData['hash_name'] = $fa->hashName();
                            $sqlData['file_url'] =  $folderName;
                            $this->apiMentoService->mentoFileInsert($sqlData);
                            $path = Storage::disk('s3')->put($folderName. $sqlData['hash_name'], file_get_contents($fa));
                            $path = Storage::disk('s3')->url($path);
                        }
                    }

                }

                $returnData['code']=0;
                $returnData['message'] = "처리완료";
                $returnData['response']=$result;
            }else{
                $returnData['code']=300;
                $returnData['message']="누락된 데이터가 있습니다.";
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function chPassword()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['password'] = $params['password'] ?? '';
            $params['_token'] = $params['_token'] ?? '';

            if($params['mem_id']!=0&&$params['password']!=""){

                $result = $this->apiMemberService->setChangePassword($params);
                if($result){
                    $returnData['code']=0;
                    $returnData['message'] = "처리완료";
                    $returnData['response']=$result;
                }else{
                    $returnData['code']=300;
                    $returnData['message'] = "일치한 데이터가 없습니다.";
                    $returnData['response']=$result;
                }

            }else{
                $returnData['code']=300;
                $returnData['message']="누락된 데이터가 있습니다.";
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function chPassword2()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['password'] = $params['password'] ?? '';
            $params['chPassword'] = $params['chPassword'] ?? '';
            $params['_token'] = $params['_token'] ?? '';

            if($params['mem_id']!=0&&$params['password']!=""){

                $result = $this->apiMemberService->getPasswordCheck($params);

                $ckPw = Hash::check($params['password'], $result->password);

                if($ckPw){
                    $result2 = $this->apiMemberService->setChangePassword2($params);

                    if($result2){
                        $returnData['code']=0;
                        $returnData['message'] = "처리완료";
                        $returnData['response']=$result2;
                    }else{
                        $returnData['code']=300;
                        $returnData['message'] = "일치한 데이터가 없습니다.";
                        $returnData['response']=$result2;
                    }
                }else{
                    $returnData['code']=300;
                    $returnData['message'] = "비밀번호가 일치하지 않습니다.";
                    $returnData['response'] = $ckPw;
                }

            }else{
                $returnData['code']=300;
                $returnData['message']="누락된 데이터가 있습니다.";
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function deleteAccount(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['_token'] = $params['_token'] ?? '';
            $params['site_code'] = $params['site_code'] ?? '1';

            if($params['mem_id']!=0&&$params['_token']!=""){

                $result = $this->apiMemberService->setDeleteAccount($params);

                if($result){
                    $returnData['code']=0;
                    $returnData['message'] = "처리완료";
                    $returnData['response']=$result;
                }else{
                    $returnData['code']=300;
                    $returnData['message'] = "회원탈퇴 실패.";

                }

            }else{
                $returnData['code']=300;
                $returnData['message']="누락된 데이터가 있습니다.";
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function findPwTokenCheck()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['idx'] = $params['idx'] ?? "";
            $params['_token'] = $params['_token'] ?? "";


            $result = $this->apiMemberService->findPwTokenCheck($params);

            if($result){
                $returnData['code']=0;
                $returnData['message']="토큰 유효";
            }else{
                $returnData['code']=1;
                $returnData['message']="토큰 무효";
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    /*
    private function callAdisonClickKey($uId, $adisonClickKey)
    {
        $formParams = [
            'advertiser_token' => 'qJEJzmaQyy1zYPbk4jadrAvW',
            'click_key' => $adisonClickKey,
        ];

        if (empty($formParams['click_key'])) {
            return;
        }

        try {
            (new Client())->request('POST', 'https://postback-ao.adison.co/api/postbacks/server', [
                'form_params' => $formParams,
                RequestOptions::TIMEOUT => 5
            ]);
        } catch (\Exception $e) {
            $formParams['response_message'] = $e->getMessage();
        }

        try {
            $formParams['u_id'] = $uId;
            $this->apiMemberService->insertAdisonPostbackLog($formParams);
        } catch (\Exception $e) {
            //
        }
    }
    */


}
