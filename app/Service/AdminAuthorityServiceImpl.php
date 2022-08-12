<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;

class AdminAuthorityServiceImpl extends DBConnection  implements AdminAuthorityServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAdminList($params) {


        $result = $this->statDB->table('users')
            ->leftJoin('adm_group', 'users.group_code', '=', 'adm_group.group_code')
            ->select(
                'users.name',
                'adm_group.group_name',
                'users.phoneno',
                'users.email',
                'users.isuse',
                'users.created_at',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->where('type', $params['type'])
            ->orderby('created_at','desc')
           // ->groupBy('name')
            ->get();
        return $result;

    }

}
