<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ProductServiceInterface
{
    //상품 리스트 (list)
    public function getProductList($params);



}
