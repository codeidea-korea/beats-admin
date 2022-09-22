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

    public function getAdmMenuList(){
        $result = $this->statDB->table('adm_menu')
            ->select(
                'menuindex',
                'menuname',
                'parentindex',
                'depth',
                'lcnt',
                'description',
                'url',
                'menucode',
                'sortorder',
                'rootindex',
            )
            ->where('isdisplay', 'Y')
            ->orderby('sortorder','asc')
            ->get();
        return $result;
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

    public function getAdminTotal($params) {

        $result = $this->statDB->table('users')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->where('type', $params['type'])
            ->first();
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
            //->limit(0,$params['limit'])
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
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

    public function setChangePassword($params) {

        $result = $this->statDB->table('users')
            ->where('idx',$params['idx'])
            ->update([
                'password'=>bcrypt($params['password'])
                ,'updated_at' => now()
            ]);
        return $result;

    }

    public function setAdminUpdate($params) {

        $result = $this->statDB->table('users')
            ->where('idx',$params['idx'])
            ->update([
                'isuse' => $params['isuse']
                ,'group_code' => $params['group_code']
                ,'name' => $params['name']
                ,'phoneno' => $params['phoneno']
                ,'email' => $params['email']
                ,'updated_at' => now()
            ]);
        return $result;

    }


    public function getAdminId($params) {

        $result = $this->statDB->table('users')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->where('id', $params['id'])
            ->first();
        return $result;
    }

}
