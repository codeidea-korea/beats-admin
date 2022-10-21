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

        $result =$this->statDB->select(
            "
                    SELECT
                        SUM(A.newMemberVal) AS newMemberCnt
                        ,SUM(A.normal) AS normalCnt
                        ,SUM(A.mento) AS mentoCnt
                    FROM
                    (
                        SELECT
                            case when DATE_FORMAT(mem_regdate,'%Y%m%d') = DATE_FORMAT(NOW(),'%Y%m%d') then 1 ELSE 0 END newMemberVal
                            ,case when gubun =1 then 1 ELSE 0 END normal
                            ,case when gubun =4 then 1 ELSE 0 END mento
                        FROM
                            member_data
                    ) AS A
            ");

        return $result;

    }

}
