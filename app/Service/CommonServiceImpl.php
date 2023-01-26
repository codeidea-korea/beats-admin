<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CommonServiceImpl
{
    public function test($str) {
        //디렉토리 경로
        $log_dir = $_SERVER["DOCUMENT_ROOT"].'/log/';
        //$log_dir = "/home/root...등의 절대경로 ";


        $log_txt = "\r\n";
        $log_txt .= '(' . date("Y-m-d H:i:s") . ')' . "\r\n";
        $log_txt .= $str;

        $log_file = fopen($log_dir . 'log.txt', 'a');
        fwrite($log_file, $log_txt . "\r\n\r\n");
        fclose($log_file);

        //생성 한지 7일 지난 파일 삭제
        //system("find ".$log_dir." -name '*.txt' -type f -ctime 6 -exec rm -f {} \;");
    }

}
