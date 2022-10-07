<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiFeedServiceInterface
{

    //피드등록 1step
    public function setFeedFileUpdate($params,$files);

    //피드데이터 업로드
    public function setFeedUpdate($params,$files);
}
