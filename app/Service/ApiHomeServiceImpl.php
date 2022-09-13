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

    public function getBannerList($params){

              $result = $this->statDB->table('adm_banner')
                  ->leftJoin('adm_banner_data', 'adm_banner.banner_code', '=', 'adm_banner_data.banner_code')
                  ->select(
                      'adm_banner.banner_name as bannerName',
                     'adm_banner.banner_code as bannerCode',
                     'adm_banner.type as bannerType',
                     'adm_banner_data.br_title as brTitle',
                     'adm_banner_data.contents as contents',
                     'adm_banner_data.contents_url as contnetsUrl',
                     'adm_banner_data.banner_file as banenrFile',
                     'adm_banner_data.banner_source as bannerSource',
                  )
                  ->where('adm_banner_data.isuse','Y')
                  ->where('adm_banner.banner_code',$params['bannerCode'])
                  ->orderby('adm_banner_data.br_seq','asc')
                  ->get();
        return $result;
    }

    public function getCodeList($params){
        $result = $this->statDB->table('adm_code')
            ->select(
                'codeindex as codeIndex',
                'codename as codeName',
                'codevalue as codeValue',
            )
            ->where('parentindex',$params['codeIndex'])
            ->orderby('codevalue','asc')
            ->get();
        return $result;

    }

}
