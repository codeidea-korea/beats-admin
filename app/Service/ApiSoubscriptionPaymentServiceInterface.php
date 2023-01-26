<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiSoubscriptionPaymentServiceInterface
{
    public function checkSPayment($params);
    //구독 신청 내용 등록
    public function setSPayment($params);
    public function setSPayment2($params);

}
