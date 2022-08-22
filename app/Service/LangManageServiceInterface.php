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
}
