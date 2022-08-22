<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface MainManageServiceInterface
{
    public function getBannerList($params);
}
