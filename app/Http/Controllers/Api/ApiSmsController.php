<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use \stdClass;
use Response;
use Session;

class ApiSmsController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get_header()
    {
        $apiKey = "NCSPA98KLUYGU0UK";
        $apiSecret = "QFW7IZIIZNZJMRXO4AJURYZBBT7VYB0E";
        date_default_timezone_set('Asia/Seoul');
        $date = date('Y-m-d\TH:i:s.Z\Z', time());
        $salt = uniqid();
        $signature = hash_hmac('sha256', $date . $salt, $apiSecret);
        return "Authorization: HMAC-SHA256 apiKey={$apiKey}, date={$date}, salt={$salt}, signature={$signature}";
    }

    public function requestSms($method, $resource, $data = false, $headers = null)
    {
        $url = "http://api.coolsms.co.kr";
        $url .= $resource;

        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            $http_headers = array($this->get_header(), "Content-Type: application/json");
            if (is_array($headers)) $http_headers = array_merge($http_headers, $headers);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $http_headers);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            if (curl_error($curl)) {
                print curl_error($curl);
            }
            curl_close($curl);
            return json_decode($result);
        } catch (\Exception $err) {
            return $err;
        }
    }

    public function send_one_message()
    {
        $request = $this->request->input();
        $params = new stdClass();
        $message = new stdClass();
        $request['to'] = $request['to'] ?? '';
        $request['smsNumber'] = $request['smsNumber'] ?? '';

        $result = array(
            'resultCode' => 'SUCCESS'
        );

        if($request['to'] == '' || $request['smsNumber'] == ''){
            $result['resultCode'] = 'FAIL';
            $result['resultMassage'] = '문자를 보낼 휴대폰 번호와 인증번호를 입력해주세요.';
        }else{
            $message->text = "[Web발신] [BY BEATS X BEAT SOMEONE] 통합회원가입 인증번호는 ".$request['smsNumber']."입니다. 정확히 입력해주세요";
            $message->to = $request['to'];
            $message->from = "01032108045"; // $from
            $request['subject'] = $request['subject'] ?? "";
            $request['imageId'] = $request['imageId'] ?? "";
            if ($request['subject'] != '') $message->subject = $request['subject'];
            if ($request['imageId'] != '') $message->imageId = $request['imageId'];
            $params->agent = array(
                "sdkVersion" => 'php/4.0.1',
                "osPlatform" => 'Linux | '.phpversion()
            );
            $params->message = $message;

            $result['smsResult'] = $this->send_one_message_params($params);
        }

        return $result;
    }

    public function send_one_message_params($params)
    {
        return $this->requestSms("POST", "/messages/v4/send", $params);
    }
}
