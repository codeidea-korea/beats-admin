<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface FeedServiceInterface
{
    //피드 리스트
    public function getFeedList($params);
}
