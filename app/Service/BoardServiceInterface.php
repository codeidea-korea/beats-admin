<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface BoardServiceInterface
{
    public function getBoardList($params);

    public function getBoardView($params, $bidx);

    public function BoardAdd($params);

    public function BoardUpdate($params);

    public function BoardDelete($params);

    public function upload($params);

    public function getContractList($params);

    public function getContractTotal($params);

    public function setContractAdd($params);

    public function getContractView($idx);

}
