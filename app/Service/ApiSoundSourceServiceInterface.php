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

    //음원 정보 리스트 (list)
    public function setSoundSourceList($params);

    //음원 상세정보 (data)
    public function getSoundSourceData($params);

    //음원 파일 정보 (data)
    public function getMusicFileList($params);

    //공동 작곡가 (data)
    public function getCommonCompositionList($params);

    //음원데이터 삭제
    public function setSoundSourceDel($params);

    //음원파일 삭제
    public function setMusicFileDel($params);
}
