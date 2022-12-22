<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Service\MemberServiceImpl;
use App\Service\ApiMemberServiceImpl;
use App\Service\ApiCoComposerServiceImpl;

class MailController extends Controller
{
    /**
     * 메일 전송 소스 입니다. 테스트 용으로 하드코딩을 했습니다.
     *
     * @return string
     */
    private $request;
    private $memberService;
    private $apiMemberService;
    private $apiCocomposerService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->memberService = new MemberServiceImpl();
        $this->apiMemberService = new ApiMemberServiceImpl();
        $this->apiCocomposerService = new ApiCoComposerServiceImpl();
    }

    public function send()
    {
        $user = array(
            'email' => 'jyk586@gmail.com',
            'name'  => 'ykjung'
        );

        $data = array(
            'detail'=> 'Your awesome detail here !!!!',
            'name'  => $user['name']
        );

        Mail::send('emails.welcome', $data, function($message) use ($user)
        {
            $message->from('beatsomeone@gmail.com', 'Betanews Master');
            $message->to($user['email'], $user['name'])->subject('Welcome!');
        });

        return 'Done!';
    }

    public function setNewPassword()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";
        define('SECRET', now());

        $params = $this->request->input();
        $params['email_id'] = $params['email_id'] ?? '';
        $params['site_code'] = $params['site_code'] ?? 'APP_URL1';

        if($params['email_id']==''){
            $returnData['code'] = -1;
            $returnData['message'] = "잘못된 정보 입니다.";
        }else{



            $memberData = $this->memberService->getMemberEmailFind($params);

            if($memberData!=null){

                for ($i=0; $i<8; $i++) $str = 'E';
                $params['_token']=$str . md5($str . SECRET);
                $params['sns'] = $params['sns'] ?? "email";
                $params['snsKey'] = $params['snsKey'] ?? "";
                $params['mem_id'] = $memberData->idx;
                $params['emailId'] = $memberData->memEmail;

                $result2 = $this->apiMemberService->putFindPwToken($params);
                //var_dump($params);exit();
                if($result2){

                    $user = array(
                        'email' => $memberData->memEmail,
                        'nickName'  => $memberData->memNickName
                    );

                    $data = array(
                        'name'  => $user['nickName']
                        ,'idx'  => $params['mem_id']
                        ,'_token'  => $params['_token']
                        ,'site_code'  => $params['site_code']
                    );


                    Mail::send('emails.chPasswordEmail', $data, function($message) use ($user)
                    {
                        $message->from('beatsomeone@gmail.com', 'beatsomeone');
                        $message->to($user['email'], $user['nickName'])->subject('BEATSOMEONE 비밀번호 재설정');
                    });

                    $returnData['code']=0;
                    $returnData['message']="이메일전송 완료";
                }else{
                    $returnData['code'] = -1;
                    $returnData['message'] = "시스템 장애";
                }



            }else{
                $returnData['code']=300;
                $returnData['message']="해당 id로 등록되어있는 계정이 존재하지 않습니다.";
            }

        }

        return $returnData;
    }


    //공동작곡가 초대
    public function coComposerInvite(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";
        define('SECRET', now());

        $params = $this->request->input();
        $params['music_head_idx'] = $params['music_head_idx'] ?? 0;
        $params['send_emails'] = $params['send_emails'] ?? array();



        if($params['send_emails']==null||$params['music_head_idx']==0){
            $returnData['code'] = -1;
            $returnData['message'] = "잘못된 정보 입니다.";
        }else{

            $result = $this->apiCocomposerService->setCoComposerInvite($params);

            if($result){
                foreach($params['send_emails'] as $rs){
                    $user = array(
                        'email' => $rs
                    );
                    $data = array(
                        'music_head_idx'  => $user['music_head_idx']
                    );
                    Mail::send('emails.coComposerEmail', $data, function($message) use ($user)
                    {
                        $message->from('beatsomeone@gmail.com', 'Betanews Master');
                        $message->to($user['email'])->subject('ByBeat 공동작곡가 초대');
                    });
                }
                $returnData['code']=0;
                $returnData['message']="이메일전송 완료";
            }else{
                $returnData['code'] = -1;
                $returnData['message'] = "시스템 장애";
            }

            $returnData['code']=0;
            $returnData['message']="테스트 완료";

        }

        return $returnData;
    }
}
