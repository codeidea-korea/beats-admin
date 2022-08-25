<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface MemberServiceInterface
{

    // 회원 총수
    public function getMemberTotal($params);
    // 회원 리스트
    public function getMemberList($params);

    //셈플
    public function bannerSample();

}
