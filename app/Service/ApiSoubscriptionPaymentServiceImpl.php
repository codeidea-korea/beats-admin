<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ApiSoubscriptionPaymentServiceImpl extends DBConnection  implements ApiSoubscriptionPaymentServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }
    public function checkSPayment($params){
        $result = $this->statDB->table('subscription_payment')
            ->select(
                'idx'
            )
            ->where('service',2)
            ->where('plan_idx',$params['plan_idx'])
            ->where('gubun','M')
            ->where('subscription_name',$params['subscription_name'])
            ->where('mem_id',$params['mem_id'])
            ->get();
        return $result;
    }

    //피드 리스트
    public function setSPayment($params) {
        $result = $this->statDB->table('subscription_payment')
            ->insertGetId([
                'service' => 2
                , 'plan_idx' => $params['plan_idx']
                , 'gubun' => 'M'
                , 'subscription_name' => $params['subscription_name']
                , 'mem_id' => $params['mem_id']
                , 'pg' => $params['pg']
                , 'payment_method' => $params['payment_method']
            ]);
        $result2 = $this->statDB->table('subscription_payment_data')
            ->insert([
                'sp_idx' => $result
                , 'contents' => $params['contents']
                , 'pay_status' => $params['pay_status']
                , 'payment_amount' => $params['payment_amount']
                , 'pay_date' => DB::raw('now()')
            ]);
        return $result;
    }

    //피드 리스트
    public function setSPayment2($params) {

        $result = $this->statDB->table('subscription_payment')
            ->where('idx',$params['sp_idx'])
            ->update(
                [
                    'payment_method' => $params['payment_method']
                    ,'mod_date' =>  DB::raw('now()')
                ]
            );

        $result2 = $this->statDB->table('subscription_payment_data')
            ->insert([
                'sp_idx' => $params['sp_idx']
                , 'contents' => $params['contents']
                , 'pay_status' => $params['pay_status']
                , 'payment_amount' => $params['payment_amount']
                , 'pay_date' => DB::raw('now()')
            ]);

        return $result;

    }

}
