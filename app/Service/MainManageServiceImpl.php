<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class MainManageServiceImpl extends DBConnection  implements MainManageServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getBannerList($params) {

        $where = " where 1=1 ";

        if($params['banner_type'] != ''){
            $where .= " and type = '".$params['banner_type']."'";
        }

        $result = $this->statDB
            ->select('
            SELECT
            adm_banner.idx,
            adm_banner.mem_id,
            adm_banner.banner_code,
            adm_banner.banner_name,
            adm_banner.type,
            adm_banner.created_at,
            adm_banner.updated_at,
            IFNULL(adm_banner_data.downcontents,0) AS downcontents
            FROM adm_banner
            LEFT JOIN (SELECT banner_code,COUNT(idx) as downcontents FROM adm_banner_data GROUP BY banner_code) as adm_banner_data
            ON adm_banner.banner_code = adm_banner_data.banner_code'
            .$where.
            'ORDER BY created_at desc LIMIT '.$params['limit'].' OFFSET '.($params['page']-1)*$params['limit']
            );
           // ->groupBy('name')

        return $result;

    }

    public function getDownContents() {

        $result = $this->statDB->table('adm_banner_data')
            ->select(DB::raw("COUNT(idx) AS downcontents"))
            ->groupBy('banner_code')
            ->first();
        return $result;

    }

    public function getBannerTotal() {

        $result = $this->statDB->table('adm_banner')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->first();
        return $result;

    }

    public function getBannerView($params, $banner_code) {

        $result = $this->statDB
            ->select('SELECT
            adm_banner.idx,
            adm_banner.mem_id,
            adm_banner.banner_code,
            adm_banner.banner_name,
            adm_banner.type,
            adm_banner.created_at,
            banner_data.updated_at,
            IFNULL(adm_banner_data.downcontents,0) AS downcontents
            FROM adm_banner
            LEFT JOIN (SELECT updated_at,banner_code FROM adm_banner_data ORDER BY updated_at desc limit 1) as banner_data
            ON adm_banner.banner_code = banner_data.banner_code
            LEFT JOIN (SELECT banner_code,COUNT(idx) as downcontents FROM adm_banner_data GROUP BY banner_code) as adm_banner_data
            ON adm_banner.banner_code = adm_banner_data.banner_code
            WHERE adm_banner.banner_code = "'.$banner_code.'"
            ORDER BY created_at desc LIMIT '.$params['limit'].' OFFSET '.($params['page']-1)*$params['limit']);
           // ->groupBy('name')

        return $result;

    }

    public function getBannerDataList($params, $banner_code) {


        $result = $this->statDB->table('adm_banner_data')
            ->select(
                'adm_banner_data.idx',
                'adm_banner_data.br_title',
                'adm_banner_data.banner_text',
                'adm_banner_data.isuse',
                'adm_banner_data.contents',
                'adm_banner_data.contents_url',
                'adm_banner_data.banner_file',
                'adm_banner_data.banner_source',
                'adm_banner_data.banner_file_en',
                'adm_banner_data.banner_source_en',
                'adm_banner_data.banner_file_jp',
                'adm_banner_data.banner_source_jp',
                'adm_banner_data.banner_file_ch',
                'adm_banner_data.banner_source_ch',
                'adm_banner_data.br_seq',
                'adm_banner_data.created_at',
                DB::raw('IFNULL(LAG(adm_banner_data.idx) OVER (ORDER BY adm_banner_data.br_seq),"") as af_idx'),
                DB::raw('IFNULL(LEAD(adm_banner_data.idx) OVER (ORDER BY adm_banner_data.br_seq),"") as bf_idx'),
                DB::raw('IFNULL(LAG(adm_banner_data.br_seq) OVER (ORDER BY adm_banner_data.br_seq),"") as af_br_seq'),
                DB::raw('IFNULL(LEAD(adm_banner_data.br_seq) OVER (ORDER BY adm_banner_data.br_seq),"") as bf_br_seq'),
                //DB::raw('IFNULL(COUNT(adm_banner_data.idx),0) as downcontents'),
            )
            ->where('adm_banner_data.banner_code',$banner_code)
            ->when(isset($params['s_contents']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('contents',  $params['s_contents']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('br_title', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->orderby('br_seq','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
           // ->groupBy('name')
            ->get();

        return $result;

    }

    public function getBannerDataTotal($params, $banner_code) {

        $result = $this->statDB->table('adm_banner_data')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->where('adm_banner_data.banner_code',$banner_code)
            ->when(isset($params['s_contents']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('contents',  $params['s_contents']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('br_title', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->first();
        return $result;

    }

    public function SeqChange($params){
        $this->statDB->table('adm_banner_data')->where('idx',$params['idx'])->update(['br_seq' => $params['change_seq']]);
        $this->statDB->table('adm_banner_data')->where('idx',$params['change_idx'])->update(['br_seq' => $params['br_seq']]);

        $result = $this->statDB->table('adm_banner_data')
            ->select(
                'adm_banner_data.idx',
                'adm_banner_data.br_title',
                'adm_banner_data.isuse',
                'adm_banner_data.contents',
                'adm_banner_data.contents_url',
                'adm_banner_data.banner_file',
                'adm_banner_data.banner_source',
                'adm_banner_data.banner_file_en',
                'adm_banner_data.banner_source_en',
                'adm_banner_data.banner_file_jp',
                'adm_banner_data.banner_source_jp',
                'adm_banner_data.banner_file_ch',
                'adm_banner_data.banner_source_ch',
                'adm_banner_data.br_seq',
                'adm_banner_data.created_at',
                DB::raw('IFNULL(LAG(adm_banner_data.idx) OVER (ORDER BY adm_banner_data.br_seq),"") as af_idx'),
                DB::raw('IFNULL(LEAD(adm_banner_data.idx) OVER (ORDER BY adm_banner_data.br_seq),"") as bf_idx'),
                DB::raw('IFNULL(LAG(adm_banner_data.br_seq) OVER (ORDER BY adm_banner_data.br_seq),"") as af_br_seq'),
                DB::raw('IFNULL(LEAD(adm_banner_data.br_seq) OVER (ORDER BY adm_banner_data.br_seq),"") as bf_br_seq'),
                //DB::raw('IFNULL(COUNT(adm_banner_data.idx),0) as downcontents'),
            )
            ->where('adm_banner_data.banner_code',$params['banner_code'])
            ->when(isset($params['s_contents']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('contents',  $params['s_contents']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('br_title', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->orderby('br_seq','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
           // ->groupBy('name')
            ->get();
        return $result;
    }

    public function BannerAdd($params,$file,$file_en,$file_jp,$file_ch) {
        $params['banner_file_en']  = "";
        $params['banner_source_en'] = "";
        $params['banner_file_jp'] = "";
        $params['banner_source_jp'] = "";
        $params['banner_file_ch'] = "";
        $params['banner_source_ch'] = "";

        if($file != ""){
            $cfilename = $file->getClientOriginalName();
            $cfilesource = $file->hashName();
            $folderName = '/banner/';
            $file->storeAs($folderName, $file->hashName(), 'public');
            //Image::make(storage_path('public'.$folderName.$file->hashName()))->resize(650)->save(storage_path('public'.$folderName.$file->hashName()));

            $params['banner_file'] = $cfilename;
            $params['banner_source'] = $cfilesource;
        }

        if($file_en != ""&&$file_en!=null){
            $cfilename = $file_en->getClientOriginalName();
            $cfilesource = $file_en->hashName();
            $folderName = '/banner/';
            $file_en->storeAs($folderName, $file_en->hashName(), 'public');
            $params['banner_file_en'] = $cfilename;
            $params['banner_source_en'] = $cfilesource;
        }

        if($file_jp != ""&&$file_jp!=null){
            $cfilename = $file_jp->getClientOriginalName();
            $cfilesource = $file_jp->hashName();
            $folderName = '/banner/';
            $file_jp->storeAs($folderName, $file_jp->hashName(), 'public');
            $params['banner_file_jp'] = $cfilename;
            $params['banner_source_jp'] = $cfilesource;
        }

        if($file_ch != ""&&$file_ch!=null){
            $cfilename = $file_ch->getClientOriginalName();
            $cfilesource = $file_ch->hashName();
            $folderName = '/banner/';
            $file_ch->storeAs($folderName, $file_ch->hashName(), 'public');
            $params['banner_file_ch'] = $cfilename;
            $params['banner_source_ch'] = $cfilesource;
        }

        $seq = $this->statDB->table('adm_banner_data')
            ->select(DB::raw('MAX(br_seq) as br_seq'))
            ->where('banner_code',$params['banner_code'])
            ->orderby('br_seq','desc')
            ->first();

        $result = $this->statDB->table('adm_banner_data')
            ->insert([
                'br_title' => $params['br_title'],
                'banner_text' => $params['banner_text'],
                'contents' => $params['contents'],
                'contents_url' => $params['contents_url'],
                'banner_file' => $params['banner_file'],
                'banner_source' => $params['banner_source'],
                'isuse' => $params['isuse'],
                'banner_code' => $params['banner_code'],
                'mem_id' => auth()->user()->idx,
                'created_at' => DB::raw('now()'),
                'br_seq' => $seq->br_seq + 100,
                'banner_file_en' => $params['banner_file_en'],
                'banner_source_en' => $params['banner_source_en'],
                'banner_file_jp' => $params['banner_file_jp'],
                'banner_source_jp' => $params['banner_source_jp'],
                'banner_file_ch' => $params['banner_file_ch'],
                'banner_source_ch' => $params['banner_source_ch'],
            ]);

        if($result > 0){
            $bannercode = $params['banner_code'];
        }else{
            $bannercode = "fails";
        }

        return $bannercode;

    }

    public function BannerUpdate($params, $file,$file_en,$file_jp,$file_ch) {

        $adm_banner_data = DB::table('adm_banner_data')->where('idx', $params['up_idx'])->first();

        $params['banner_file_en']  = "";
        $params['banner_source_en'] = "";
        $params['banner_file_jp'] = "";
        $params['banner_source_jp'] = "";
        $params['banner_file_ch'] = "";
        $params['banner_source_ch'] = "";

        if($file != ""){
            $cfilename = $file->getClientOriginalName();
            $cfilesource = $file->hashName();
            $folderName = '/banner/';
            $file->storeAs($folderName, $file->hashName(), 'public');
            //Image::make(storage_path('public'.$folderName.$file->hashName()))->resize(650)->save(storage_path('public'.$folderName.$file->hashName()));
            $params['banner_file'] = $cfilename;
            $params['banner_source'] = $cfilesource;
        }else{
            $params['banner_file'] = $adm_banner_data->banner_file;
            $params['banner_source'] = $adm_banner_data->banner_source;
        }

        if($file_en != ""&&$file_en!=null){
            $cfilename = $file_en->getClientOriginalName();
            $cfilesource = $file_en->hashName();
            $folderName = '/banner/';
            $file_en->storeAs($folderName, $file_en->hashName(), 'public');
            $params['banner_file_en'] = $cfilename;
            $params['banner_source_en'] = $cfilesource;
        }else{
            $params['banner_file_en'] = $adm_banner_data->banner_file_en;
            $params['banner_source_en'] = $adm_banner_data->banner_source_en;
        }

        if($file_jp != ""&&$file_en!=null){
            $cfilename = $file_jp->getClientOriginalName();
            $cfilesource = $file_jp->hashName();
            $folderName = '/banner/';
            $file_jp->storeAs($folderName, $file_jp->hashName(), 'public');
            $params['banner_file_jp'] = $cfilename;
            $params['banner_source_jp'] = $cfilesource;
        }else{
            $params['banner_file_jp'] = $adm_banner_data->banner_file_jp;
            $params['banner_source_jp'] = $adm_banner_data->banner_source_jp;
        }

        if($file_ch != ""&&$file_en!=null){
            $cfilename = $file_ch->getClientOriginalName();
            $cfilesource = $file_ch->hashName();
            $folderName = '/banner/';
            $file_ch->storeAs($folderName, $file_ch->hashName(), 'public');
            $params['banner_file_ch'] = $cfilename;
            $params['banner_source_ch'] = $cfilesource;
        }else{
            $params['banner_file_ch'] = $adm_banner_data->banner_file_ch;
            $params['banner_source_ch'] = $adm_banner_data->banner_source_ch;
        }

        $result = $this->statDB->table('adm_banner_data')
            ->where('idx',$params['up_idx'])
            ->update([
                'br_title' => $params['up_br_title'],
                'banner_text' => $params['up_banner_text'],
                'contents' => $params['up_contents'],
                'contents_url' => $params['up_contents_url'],
                'banner_file' => $params['banner_file'],
                'banner_source' => $params['banner_source'],
                'isuse' => $params['up_isuse'],
                'updated_at' => DB::raw('now()'),
                'banner_file_en' => $params['banner_file_en'],
                'banner_source_en' => $params['banner_source_en'],
                'banner_file_jp' => $params['banner_file_jp'],
                'banner_source_jp' => $params['banner_source_jp'],
                'banner_file_ch' => $params['banner_file_ch'],
                'banner_source_ch' => $params['banner_source_ch'],
            ]);

        if($result > 0){
            $bannercode = $adm_banner_data->banner_code;
        }else{
            $bannercode = "fails";
        }

        return $bannercode;


    }

    public function SelectDelete($params) {

        $result = $this->statDB->table('adm_banner_data')->whereIn('idx', $params['del_check'])->delete();

        return $result;

    }

    public function getPopupList($params) {

        $result = $this->statDB->table('adm_popup')
            ->leftJoin('users','adm_popup.mem_id','=','users.idx')
            ->select(
                'adm_popup.idx',
                'adm_popup.pp_title',
                'adm_popup.isuse',
                'adm_popup.connect_url',
                'adm_popup.fr_show_date',
                'adm_popup.bk_show_date',
                'adm_popup.type',
                'adm_popup.created_at',
                'adm_popup.updated_at',
                'users.name'
            )
            ->when(isset($params['popup_type']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('adm_popup.type',  $params['popup_type']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('pp_title', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['isuse']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('adm_popup.isuse', $params['search_isuse']);
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('adm_popup.created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->orderby('adm_popup.idx','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();

        return $result;

    }

    public function getPopupTotal($params) {

        $result = $this->statDB->table('adm_popup')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->when(isset($params['popup_type']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('adm_popup.type',  $params['popup_type']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('pp_title', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['isuse']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('isuse', $params['search_isuse']);
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->first();
        return $result;

    }

    public function getPopupView($params, $pidx) {

        $result = $this->statDB->table('adm_popup')
            ->select(
                'adm_popup.idx',
                'adm_popup.pp_title',
                'adm_popup.pp_title_en',
                'adm_popup.pp_title_jp',
                'adm_popup.pp_title_ch',
                'adm_popup.isuse',
                'adm_popup.connect_type',
                'adm_popup.connect_url',
                'adm_popup.connect_contents',
                'adm_popup.fr_show_date',
                'adm_popup.bk_show_date',
                'adm_popup.popup_file',
                'adm_popup.popup_source',
                'adm_popup.popup_file_en',
                'adm_popup.popup_source_en',
                'adm_popup.popup_file_jp',
                'adm_popup.popup_source_jp',
                'adm_popup.popup_file_ch',
                'adm_popup.popup_source_ch',
                'adm_popup.type',
                'adm_popup.created_at',
                'adm_popup.updated_at',
                'users.name'
            )
            ->where('adm_popup.idx',$pidx)
            ->leftJoin('users','adm_popup.mem_id','=','users.idx')
            ->orderby('adm_popup.idx','desc')
            ->get();

        return $result;

    }

    public function PopupAdd($params,$file,$file_en,$file_jp,$file_ch) {

        if($file != ""){
            $cfilename = $file->getClientOriginalName();
            $cfilesource = $file->hashName();
            $folderName = '/popup/';
            $file->storeAs($folderName, $file->hashName(), 'public');
            $params['popup_file'] = $cfilename;
            $params['popup_source'] = $cfilesource;
        }

        if($file_en != ""){
            $cfilename = $file_en->getClientOriginalName();
            $cfilesource = $file_en->hashName();
            $folderName = '/popup/';
            $file_en->storeAs($folderName, $file_en->hashName(), 'public');
            $params['popup_file_en'] = $cfilename;
            $params['popup_source_en'] = $cfilesource;
        }

        if($file_jp != ""){
            $cfilename = $file_jp->getClientOriginalName();
            $cfilesource = $file_jp->hashName();
            $folderName = '/popup/';
            $file_jp->storeAs($folderName, $file_jp->hashName(), 'public');
            $params['popup_file_jp'] = $cfilename;
            $params['popup_source_jp'] = $cfilesource;
        }

        if($file_ch != ""){
            $cfilename = $file_ch->getClientOriginalName();
            $cfilesource = $file_ch->hashName();
            $folderName = '/popup/';
            $file_ch->storeAs($folderName, $file_ch->hashName(), 'public');
            $params['popup_file_ch'] = $cfilename;
            $params['popup_source_ch'] = $cfilesource;
        }

        if($params['connect_type'] == "menu"){
            $params['connect_url'] = $params['menu_connect_url'];
        }else{
            $params['connect_url'] = $params['url_connect_url'];
        }

        if($params['show_date'] != ''){
            $showexplode = explode(' - ',$params['show_date']);
            $params['fr_show_date'] = $showexplode[0];
            $params['bk_show_date'] = $showexplode[1];
        }

        $result = $this->statDB->table('adm_popup')
            ->insertGetId([
                'pp_title' => $params['pp_title'], 'pp_title_en' => $params['pp_title_en'], 'pp_title_jp' => $params['pp_title_jp'],
                'pp_title_ch' => $params['pp_title_ch'], 'connect_url' => $params['connect_url'], 'connect_type' => $params['connect_type'],
                'fr_show_date' => $params['fr_show_date'], 'connect_contents' => $params['connect_contents'], 'type' => $params['type'],
                'bk_show_date' => $params['bk_show_date'],'popup_file' => $params['popup_file'], 'popup_source' => $params['popup_source'],
                'popup_file_en' => $params['popup_file_en'], 'popup_source_en' => $params['popup_source_en'],'popup_file_jp' => $params['popup_file_jp'],
                'popup_source_jp' => $params['popup_source_jp'],'popup_file_ch' => $params['popup_file_ch'], 'popup_source_ch' => $params['popup_source_ch'],
                'isuse' => $params['isuse'], 'mem_id' => auth()->user()->idx, 'created_at' => DB::raw('now()'),
            ]);

        if($result > 0){
            $pidx = $result;
        }else{
            $pidx = "fails";
        }

        return $pidx;
    }

    public function PopupUpdate($params, $file,$file_en,$file_jp,$file_ch) {

        $adm_popup = DB::table('adm_popup')->where('idx', $params['idx'])->first();

        if($file != ""){
            $cfilename = $file->getClientOriginalName();
            $cfilesource = $file->hashName();
            $folderName = '/popup/';
            $file->storeAs($folderName, $file->hashName(), 'public');
            $params['popup_file'] = $cfilename;
            $params['popup_source'] = $cfilesource;
        }else{
            $params['popup_file'] = $adm_popup->popup_file;
            $params['popup_source'] = $adm_popup->popup_source;
        }

        if($file_en != ""){
            $cfilename = $file_en->getClientOriginalName();
            $cfilesource = $file_en->hashName();
            $folderName = '/banner/';
            $file_en->storeAs($folderName, $file_en->hashName(), 'public');
            $params['popup_file_en'] = $cfilename;
            $params['popup_source_en'] = $cfilesource;
        }else{
            $params['popup_file_en'] = $adm_popup->popup_file_en;
            $params['popup_source_en'] = $adm_popup->popup_source_en;
        }

        if($file_jp != ""){
            $cfilename = $file_jp->getClientOriginalName();
            $cfilesource = $file_jp->hashName();
            $folderName = '/banner/';
            $file_jp->storeAs($folderName, $file_jp->hashName(), 'public');
            $params['popup_file_jp'] = $cfilename;
            $params['popup_source_jp'] = $cfilesource;
        }else{
            $params['popup_file_jp'] = $adm_popup->popup_file_jp;
            $params['popup_source_jp'] = $adm_popup->popup_source_jp;
        }

        if($file_ch != ""){
            $cfilename = $file_ch->getClientOriginalName();
            $cfilesource = $file_ch->hashName();
            $folderName = '/banner/';
            $file_ch->storeAs($folderName, $file_ch->hashName(), 'public');
            $params['popup_file_ch'] = $cfilename;
            $params['popup_source_ch'] = $cfilesource;
        }else{
            $params['popup_file_ch'] = $adm_popup->popup_file_ch;
            $params['popup_source_ch'] = $adm_popup->popup_source_ch;
        }

        if($params['connect_type'] == "menu"){
            $params['connect_url'] = $params['menu_connect_url'];
        }else{
            $params['connect_url'] = $params['url_connect_url'];
        }

        if($params['show_date'] != ''){
            $showexplode = explode(' - ',$params['show_date']);
            $params['fr_show_date'] = $showexplode[0];
            $params['bk_show_date'] = $showexplode[1];
        }

        $result = $this->statDB->table('adm_popup')
            ->where('idx',$params['idx'])
            ->update([
                'pp_title' => $params['pp_title'], 'pp_title_en' => $params['pp_title_en'], 'pp_title_jp' => $params['pp_title_jp'],
                'pp_title_ch' => $params['pp_title_ch'], 'connect_url' => $params['connect_url'], 'connect_type' => $params['connect_type'],
                'fr_show_date' => $params['fr_show_date'], 'connect_contents' => $params['connect_contents'], 'type' => $params['type'],
                'bk_show_date' => $params['bk_show_date'],'popup_file' => $params['popup_file'], 'popup_source' => $params['popup_source'],
                'popup_file_en' => $params['popup_file_en'], 'popup_source_en' => $params['popup_source_en'],'popup_file_jp' => $params['popup_file_jp'],
                'popup_source_jp' => $params['popup_source_jp'],'popup_file_ch' => $params['popup_file_ch'], 'popup_source_ch' => $params['popup_source_ch'],
                'isuse' => $params['isuse'], 'updated_at' => DB::raw('now()'),
            ]);

        if($result > 0){
            $pidx = $adm_popup->idx;
        }else{
            $pidx = "fails";
        }

        return $pidx;


    }

    public function PopupDelete($params) {

        $adm_popup = DB::table('adm_popup')->where('idx', $params['idx'])->first();

        if ($adm_popup->popup_file != ""){
            $dir = storage_path('app/public/popup');
            $path = "$dir/$adm_popup->popup_source";
            if(!File::exists($path)) { return 1; }
            File::delete($path);
        }

        $result = $this->statDB->table('adm_popup')->where('idx', $params['idx'])->delete();

        return $result;

    }

}
