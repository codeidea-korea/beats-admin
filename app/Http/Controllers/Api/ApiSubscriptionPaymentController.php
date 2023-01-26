<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ApiSoubscriptionPaymentServiceImpl;
use App\Service\CommonServiceImpl;  //로그 및 공통 service
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Response;
use Session;
use Illuminate\Support\Facades\Log;

class ApiSubscriptionPaymentController extends Controller
{
    private $request;
    private $commonService;
    private $apiSoubscriptionPaymentService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->commonService = new CommonServiceImpl();
        $this->apiSoubscriptionPaymentService = new ApiSoubscriptionPaymentServiceImpl();
    }

    public function sPayment()
    {

        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";
        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['plan_idx'] = $params['plan_idx'] ?? 0;  //(요금제 idx)
            $params['subscription_name'] = $params['subscription_name'] ?? '';  //이용권 (요금제) 이름
            $params['pg'] = $params['pg']  ?? ''; // pg사
            $params['payment_method'] = $params['payment_method'] ?? ''; // 결제수단 (카드번호)

            $params['contents'] = $params['contents'] ?? ''; // 결제 내용
            $params['pay_status'] = $params['pay_status'] ?? ''; // 결제여부
            $params['payment_amount'] = $params['payment_amount']  ?? 0; // 결제금액

            //결제완료후 pg사에서 받은 result 값 log 찍기
            //Log::notice('결제 완료 json: '.json_encode($returnData));
            $this->commonService->test('결제 완료 json: '.json_encode($returnData));

            //pg 구독 결제후 받은 result 값을 필요에 따라 테이블 컬럼으로 추가를 한다.

            $firstStatus = $this->apiSoubscriptionPaymentService->checkSPayment($params);

            if(count($firstStatus) == 0){
                // insert 및 update
                $result = $this->apiSoubscriptionPaymentService->setSPayment($params);
            }else{
                $params['sp_idx'] = $firstStatus[0]->idx;
                $result = $this->apiSoubscriptionPaymentService->setSPayment2($params);
            }
            $returnData['code']=0;
            $returnData['message']="message";

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }
}
