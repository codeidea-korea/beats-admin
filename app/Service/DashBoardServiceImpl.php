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

    public function getNewMemeberCnt() {

        $result = $this->statDB->table('member_data')
            ->select(
                DB::raw('count(idx) as cnt')
            )
            ->where(DB::raw("DATE_FORMAT(mem_regdate,'%Y%m%d') = DATE_FORMAT(NOW(),'%Y%m%d')"))
            ->first();
        return $result;

    }

}
