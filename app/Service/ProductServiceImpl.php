<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ProductServiceImpl extends DBConnection implements ProductServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    //상품 리스트 (list)
    public function getProductList($params)
    {


        return 1;
    }



}
