<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;

interface LangManageServiceInterface
{
    // 언어관리 리스트
    public function getLangList($params);

    // 언어관리 총수
    public function getLangTotal($params);

    // 언어관리 등록
    public function getLangAdd($params);

    // BeatSomeone 메뉴 리스트
    public function getBeatSomeoneMenuList($params);

    // ByBeat 메뉴 리스트
    public function getByBeatMenuList($params);

    // BeatSomeone 메뉴 수정
    public function setBeatSomeoneMenuList($params);

    // ByBeat 메뉴 수정
    public function setByBeatMenuList($params);
}
