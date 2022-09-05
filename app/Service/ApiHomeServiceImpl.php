<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;

class ApiHomeServiceImpl extends DBConnection  implements ApiHomeServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getLangList(){
        $result = $this->statDB->table('lang_data')
            ->select(
                'idx',
                'lang_code as langCode',
                'lang_value as langValue',
            )
            ->orderby('idx','asc')
            ->get();
        return $result;
    }

    public function getMenuList($params){
        if($params['site']=="bb"){
            $result = $this->statDB->table('bybeat_menu')
                ->select(
                    'menu_index as idx',
                    'menu_code as menuCode',
                    'lang_'.$params['lang'].' as menuValue',
                )
                ->orderby('menu_index','asc')
                ->get();
            return $result;
        }else if($params['site']=="bs"){
            $result = $this->statDB->table('beat_someone_menu')
                ->select(
                    'menu_index as idx',
                    'menu_code as menuCode',
                    'lang_'.$params['lang'].' as menuValue',
                )
                ->orderby('menu_index','asc')
                ->get();
            return $result;
        }
    }

}
