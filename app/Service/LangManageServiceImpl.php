<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;

class LangManageServiceImpl extends DBConnection  implements LangManageServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getLangList($params) {

        $result = $this->statDB->table('lang_data')
            ->select(
                'idx',
                'lang_code',
                'lang_value',
            )
            ->orderby('idx','asc')
            ->get();
        return $result;

    }

    public function getLangTotal($params) {

        $result = $this->statDB->table('lang_data')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->first();
        return $result;

    }



    public function getLangAdd($params) {

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

    public function getBeatSomeoneMenuList($params) {

        $result = $this->statDB->table('beat_someone_menu')
            ->select(
                'menu_index',
                'menu_code',
                'lang_kr',
                'lang_en',
                'lang_ch',
                'lang_jp',
            )
            ->orderby('menu_index','asc')
            ->get();
        return $result;

    }

    public function getByBeatMenuList($params) {

        $result = $this->statDB->table('bybeat_menu')
            ->select(
                'menu_index',
                'menu_code',
                'lang_kr',
                'lang_en',
                'lang_ch',
                'lang_jp',
            )
            ->orderby('menu_index','asc')
            ->get();
        return $result;

    }

    public function setBeatSomeoneMenuList($params) {

        $result = $this->statDB->table('beat_someone_menu')
            ->where('menu_index',$params['menu_index'])
            ->update([
                'lang_kr'=>$params['lang_kr'],
                'lang_en'=>$params['lang_en'],
                'lang_ch'=>$params['lang_ch'],
                'lang_jp'=>$params['lang_jp'],
                ]);
        return $result;

    }

    public function setByBeatMenuList($params) {

        $result = $this->statDB->table('bybeat_menu')
            ->where('menu_index',$params['menu_index'])
            ->update([
                'lang_kr'=>$params['lang_kr'],
                'lang_en'=>$params['lang_en'],
                'lang_ch'=>$params['lang_ch'],
                'lang_jp'=>$params['lang_jp'],
            ]);
        return $result;

    }



}
