<?php
/**
 * Created by PhpStorm.
 * User: ykjung
 * Date: 2022-08-11
 * Time: 오전 10:30
 */

namespace App\Service;

use Illuminate\Support\Facades\DB;

class DBConnection
{
    public $statDB;

    public function __construct()
    {
        $this->statDB = DB::connection('beat');
    }
}
