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
                     'adm_banner_data.banner_text as bannerText',
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
        $result = $this->statDB->table('international_code')
            ->select(
                'idx as codeIndex',
                'name_kr as codeName',
                'international_code2 as codeValue',
                'international_number as telNo',
                'country_img as countryImg',
                'country_img as country_img',
            )
            ->orderby('idx','asc')
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
            ->where('lang_code',$params['lang_code'])
            ->where('isuse','Y')
            ->where('adm_terms.apply_date','<=',DB::raw('now()'))
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

    public function getTrendList($params) {

        $result = $this->statDB->table('adm_trend')
            ->select(
                'adm_trend.idx',
                'adm_trend.title',
                'adm_trend.gubun',
                'adm_trend.trand_source',
                DB::raw("(select count(idx) from beat_data where service_name = 'trend' and service_idx = adm_trend.idx and is_beat = 1) as wr_bit"),
                DB::raw("(select count(idx) from comment where wr_type = 'trend' and wr_idx = adm_trend.idx and del_status = 'N') as wr_comment"),
                DB::raw("(select count(idx) from beat_data where service_name = 'trend' and service_idx = adm_trend.idx and mem_id = {$params['mem_id']} and is_beat = 1) as like_status"),
                DB::raw("((select count(idx) from beat_data where service_name = 'trend' and service_idx = adm_trend.idx and is_beat = 1)
                + (select count(idx) from comment where wr_type = 'trend' and wr_idx = adm_trend.idx)) as wr_popular"),
            )
            ->where('adm_trend.open_status','Y')
            ->when(isset($params['gubun']), function($query) use ($params){
                return $query->where('gubun',$params['gubun']);
            })
            ->when($params['sorting'] == 2, function($query) use ($params){
                return $query->orderby('wr_bit','desc');
            })
            ->when($params['sorting'] == 3, function($query) use ($params){
                return $query->orderby('wr_hit','desc');
            })
            ->orderby('adm_trend.idx','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();

        return $result;

    }

    public function getTrendView($params) {

        $result = $this->statDB->table('adm_trend')
            ->leftJoin('users','adm_trend.mem_id','=','users.idx')
            ->select(
                'adm_trend.idx',
                'adm_trend.title',
                'adm_trend.gubun',
                'adm_trend.content',
                DB::raw("(select count(idx) from beat_data where service_name = 'trend' and service_idx = adm_trend.idx and is_beat = 1) as wr_bit"),
                DB::raw("(select count(idx) from comment where wr_type = 'trend' and wr_idx = adm_trend.idx and del_status = 'N') as wr_comment"),
                DB::raw("(select count(idx) from beat_data where service_name = 'trend' and service_idx = adm_trend.idx and mem_id = {$params['mem_id']} and is_beat = 1) as like_status"),
                'adm_trend.created_at',
                DB::raw('now() as now_date'),
                'users.name',
                DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',users.profile_photo_url,users.profile_photo_hash_name) AS fullUrl"),
            )
            ->where('adm_trend.idx',$params['idx'])
            ->get();

        return $result;

    }

    public function getTrendTotal($params){

        $result = $this->statDB->table('adm_trend')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->where('adm_trend.open_status','Y')
            ->when(isset($params['gubun']), function($query) use ($params){
                return $query->where('gubun',$params['gubun']);
            })
            ->first();
        return $result;

    }

    public function setTrendHitAdd($params){

        $result = $this->statDB->table('adm_trend')
            ->where('adm_trend.idx',$params['idx'])
            ->update([
                'wr_hit' => DB::raw('wr_hit + 1')
            ]);
        return $result;

    }

    public function setProfilePhotoList($params){

        $result = $this->statDB->select("
            SELECT
                b.mem_nickname as commentNickName
            ,CONCAT('".env('AWS_CLOUD_FRONT_URL')."',b.profile_photo_url,b.profile_photo_hash_name) AS urlLink
            FROM
            comment a LEFT JOIN member_data b ON a.mem_id=b.mem_id
            where a.wr_type = 'trend' and a.wr_idx = ".$params->idx." and a.del_status = 'N'
            GROUP BY b.mem_nickname ,b.profile_photo_url,b.profile_photo_hash_name
            ORDER BY b.mem_nickname asc Limit 5
        ");
         return $result;
    }

}
