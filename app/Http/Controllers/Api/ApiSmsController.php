<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    public function request($method, $resource, $data = false, $headers = null)
    {
        $url = "https://api.coolsms.co.kr";
        $url .= $resource;

        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            switch ($method) {
                case "POST":
                case "PUT":
                case "DELETE":
                    if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                    break;
                default: // GET
                    if ($data) $url = sprintf("%s?%s", $url, http_build_query($data));
            }
            $http_headers = array($this->get_header(), "Content-Type: application/json");
            if (is_array($headers)) $http_headers = array_merge($http_headers, $headers);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $http_headers);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            if (curl_error($curl)) {
                print curl_error($curl);
            }
            $result = curl_exec($curl);
            curl_close($curl);
            return json_decode($result);
        } catch (Exception $err) {
            return $err;
        }
    }

    public function send_one_message()
    {
        $request = $this->request->input();
        $params = new stdClass();
        $message = new stdClass();
        $message->text = $request['text'];
        $message->to = $request['to'];
        $message->from = "010-3210-8045"; // $from
        $request['subject'] = $request['subject'] ?? "";
        $request['imageId'] = $request['imageId'] ?? "";
        if ($request['subject'] != '') $message->subject = $request['subject'];
        if ($request['imageId'] != '') $message->imageId = $request['imageId'];
        $params->agent = array(
            "sdkVersion" => 'php/4.0.1',
            "osPlatform" => 'Linux | '.phpversion()
        );
        $params->message = $message;
        return $this->send_one_message_params($params);
    }

    public function send_one_message_params($params)
    {
        return $this->request("POST", "/messages/v4/send", $params);
    }
}
