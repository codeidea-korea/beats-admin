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
            ->select(
                'name',
                'phoneno',
                'email',
                'created_at',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->where('type', $params['type'])
           // ->groupBy('name')
            ->paginate();
        return $result;

    }

}
