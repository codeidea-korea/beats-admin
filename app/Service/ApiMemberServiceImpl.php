<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;

class ApiMemberServiceImpl extends DBConnection  implements ApiMemberServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getLogin($params){
        $result = $this->statDB->table('members')
            ->select(
                'idx as idx',
                'email_id as emailId',
                'password as password',
            )
            ->get();
        return $result;
    }



}
