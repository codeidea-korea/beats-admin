<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface AdminAuthorityServiceInterface
{
    public function getAdminList($params);
}
