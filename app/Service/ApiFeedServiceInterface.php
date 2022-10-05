<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiFeedServiceInterface
{

    //음원등록 1step
    public function setFeedFileUpdate($params,$files);

    //음원데이터 업로드
    public function setFeedUpdate($params,$files);
}
