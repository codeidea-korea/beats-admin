<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;

class DashBoardServiceImpl extends DBConnection  implements DashBoardServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTestData($params) {


        $result = $this->statDB->table('users')
            ->select(
                'name',
                $this->statDB->raw('SUM(name) AS CNT')
            )
            ->where('type', $params['type'])
            ->groupBy('name')
            ->get();
        return $result;

    }

}
