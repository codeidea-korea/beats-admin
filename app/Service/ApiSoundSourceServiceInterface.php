<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiSoundSourceServiceInterface
{

    //음원등록 1step
    public function setSoundFileUpdate($params,$files);

    //음원데이터 업로드
    public function setDataUpdate($params,$files);

    //음원 정보 업로드 (상세정보)
    public function setSoundDataUpdate($params);
}
