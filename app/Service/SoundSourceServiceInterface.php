<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface SoundSourceServiceInterface
{
    //음원 정보 리스트 (list)
    public function getSoundSourceList($params);

    //음원 정보 리스트 (list)
    public function getSoundSourceListPaging($params);

    //음원 정보 리스트 (totalCount)
    public function getSoundSourceTotal($params);


}
