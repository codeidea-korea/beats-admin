<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface BoardServiceInterface
{
    public function getBoardList($params);
}
