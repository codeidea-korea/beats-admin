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

    public function getNoticeList($params) {

        $result = $this->statDB->table('notice_board')
            ->select(
                'notice_board.idx',
                'notice_board.wr_title',
                DB::raw("date_format(notice_board.created_at, '%Y-%m-%d' ) as created_at"),
            )
            ->where('notice_board.wr_open','open')
            ->when(isset($params['searchText']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('wr_title', 'like', '%'.$params['searchText'].'%')
                    ->orwhere('wr_content', 'like', '%'.$params['searchText'].'%');
                });
            })
            ->orderby('notice_board.gubun','desc')
            ->orderby('notice_board.created_at','desc')
            ->orderby('notice_board.idx','desc')
            ->get();
            
            // ->skip(($params['page']-1)*$params['limit'])
            // ->take($params['limit'])

        return $result;

    }

    public function getNoticeView($params) {

        $result = $this->statDB->table('notice_board')
            ->select(
                'notice_board.idx',
                'notice_board.wr_title',
                'notice_board.wr_content',
                DB::raw("date_format(notice_board.created_at, '%Y-%m-%d' ) as created_at"),
            )
            ->where('notice_board.idx',$params['idx'])
            ->get();

        return $result;

    }

    public function getEventList($params) {

        $result = $this->statDB->table('adm_event')
            ->select(
                'adm_event.idx',
                'adm_event.title',
                'adm_event.fr_event_date',
                'adm_event.bk_event_date',
                'adm_event.event_source',
                DB::raw('CASE WHEN adm_event.fr_event_date <= NOW() and adm_event.bk_event_date >= NOW() THEN 1
                WHEN adm_event.bk_event_date < NOW() THEN 2
                Else 0 END as gubun'),
            )
            ->when(isset($params['gubun']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    if($params['gubun'] == 'Y'){
                        $query->where('adm_event.fr_event_date', '<=', DB::raw('NOW()'))
                        ->where('adm_event.bk_event_date', '>=', DB::raw('NOW()'));
                    }else{
                        $query->where('adm_event.bk_event_date', '<' , DB::raw('NOW()'));
                    }
                });
            })
            ->where('adm_event.open_status','Y')
            ->orderby('adm_event.idx','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();

        return $result;

    }

    public function getEventView($params) {

        $result = $this->statDB->table('adm_event')
            ->select(
                'adm_event.idx',
                'adm_event.title',
                'adm_event.content',
                'adm_event.fr_event_date',
                'adm_event.bk_event_date',
                'adm_event.event_source',
                DB::raw('CASE WHEN adm_event.fr_event_date <= NOW() and adm_event.bk_event_date >= NOW() THEN 1
                WHEN adm_event.bk_event_date < NOW() THEN 2
                Else 0 END as gubun'),
            )
            ->where('adm_event.idx',$params['idx'])
            ->get();

        return $result;

    }

    public function getEventTotal($params){

        $result = $this->statDB->table('adm_event')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->when(isset($params['gubun']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    if($params['gubun'] == 'Y'){
                        $query->where('adm_event.fr_event_date', '<=', DB::raw('NOW()'))
                        ->where('adm_event.bk_event_date', '>=', DB::raw('NOW()'));
                    }else{
                        $query->where('adm_event.bk_event_date', '<' , DB::raw('NOW()'));
                    }
                });
            })
            ->where('adm_event.open_status','Y')
            ->first();
        return $result;

    }

    public function beatAdd($params){

        $beat_del = $this->statDB->table('beat_data')
            ->where('mem_id',$params['mem_id'])
            ->where('service_idx',$params['service_idx'])
            ->where('service_name',$params['service_name'])
            ->delete();

        if($params['beat'] == 1){
            $result = $this->statDB->table('beat_data')
            ->insert([
                'mem_id' => $params['mem_id'],
                'service_idx' => $params['service_idx'],
                'service_name' => $params['service_name'],
                'is_beat' => 1,
            ]);
        }else{
            $result = $this->statDB->table('beat_data')
            ->insert([
                'mem_id' => $params['mem_id'],
                'service_idx' => $params['service_idx'],
                'service_name' => $params['service_name'],
                'not_beat' => 1,
            ]);
        }
        
        return $result;
    }

    public function beatDelete($params){

        $result = $this->statDB->table('beat_data')
            ->where('mem_id',$params['mem_id'])
            ->where('service_idx',$params['service_idx'])
            ->where('service_name',$params['service_name'])
            ->delete();
        
        return $result;
    }

    public function getPopup($params){
        $result = $this->statDB->table('adm_popup')
            ->select(
                'adm_popup.idx',
                'adm_popup.popup_source',
            )
            ->where('type',$params['site_type'])
            ->whereBetween(DB::raw('now()'), [DB::raw('adm_popup.fr_show_date'),DB::raw('adm_popup.bk_show_date')])
            ->orderby('adm_popup.idx','desc')
            ->first();
        return $result;

    }

    public function getTermsApplyData($params){
        $result = $this->statDB->table('adm_terms')
            ->select(
                'adm_terms.idx',
                DB::raw("date_format(adm_terms.apply_date, '%Y-%m-%d' ) as apply_date"),
            )
            ->where('terms_type',$params['terms_type'])
            ->where('isuse','Y')
            ->orderby('adm_terms.apply_date','desc')
            ->get();
        return $result;

    }

    public function getTermsContent($params){
        $result = $this->statDB->table('adm_terms')
            ->select(
                'adm_terms.content',
            )
            ->where('idx',$params['idx'])
            ->first();
        return $result;

    }
}
