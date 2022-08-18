<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;

class AdminAuthorityServiceImpl extends DBConnection  implements AdminAuthorityServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAdmGroupList($params) {

        $result = $this->statDB->table('adm_group')
            ->select(
                'idx',
                'group_code',
                'group_name',
                'adm_personal_data',
            )
            ->where('isuse', 'Y')
            ->orderby('group_code','asc')
            ->get();
        return $result;

    }


    public function getAdminList($params) {

        $result = $this->statDB->table('users')
            ->leftJoin('adm_group', 'users.group_code', '=', 'adm_group.group_code')
            ->select(
                'users.idx',
                'users.name',
                'users.group_code',
                'adm_group.group_name',
                'users.phoneno',
                'users.email',
                'users.isuse',
                'users.created_at',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->where('type', $params['type'])
            ->orderby('created_at','desc')
           // ->groupBy('name')
            ->get();
        return $result;

    }

    public function getAdminData($params) {

        $result = $this->statDB->table('users')
            ->leftJoin('adm_group', 'users.group_code', '=', 'adm_group.group_code')
            ->select(
                'users.idx',
                'users.id',
                'users.name',
                'users.group_code',
                'adm_group.group_name',
                'users.phoneno',
                'users.email',
                'users.isuse',
                'users.created_at',
                'users.adminid',
            // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->where('users.type', $params['type'])
            ->where('users.idx', $params['idx'])
            ->first();
        return $result;

    }

    public function getAdminAdd($params) {

        $result = $this->statDB->table('users')
            ->insertGetId([
                'id' => $params['id']
                ,'group_code' => $params['group_code']
                ,'name' => $params['name']
                ,'phoneno' => $params['phoneno']
                ,'isuse' => $params['isuse']
                ,'email' => $params['email']
                ,'password' => bcrypt($params['password'])
                ,'type' => 0
                ,'created_at' => now()
            ]);

        return $result;

    }

}
