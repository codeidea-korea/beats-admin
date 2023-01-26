<?php
namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiStudentServiceImpl extends DBConnection  implements ApiStudentServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setChStudent($params) {

        $result = $this->statDB->table('student_authentication')
            ->insertGetId([
                'mem_id' => $params['mem_id']
                ,'first_name' => $params['first_name']
                ,'last_name' => $params['last_name']
                ,'year' => $params['year']
                ,'month' => $params['month']
                ,'day' => $params['day']
                ,'send_email' => $params['send_email']
            ]);

        // $this->statDB->table('member_notice')
        //     ->insert([
        //         'mem_id' => $params['mem_id']
        //         ,'gubun' => '01'
        //         ,'message' => '멘토 뮤지션 전환 신청이 접수되었습니다.'
        //     ]);

        return $result;

    }

    public function studentFileInsert($sqlData){

        $result = $this->statDB->table('student_file')
            ->insert([
                'mem_id' => $sqlData['mem_id']
                , 'sa_idx' => $sqlData['sa_idx']
                , 'file_name' => $sqlData['file_name']
                , 'hash_name' => $sqlData['hash_name']
                , 'file_url' => $sqlData['file_url']
            ]);

        return $result;
    }
}
