<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;

class MainManageServiceImpl extends DBConnection  implements MainManageServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getBannerList($params) {

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
            ON adm_banner.banner_code = adm_banner_data.banner_code 
            ORDER BY created_at desc'
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
            adm_banner.updated_at,
            IFNULL(adm_banner_data.downcontents,0) AS downcontents 
            FROM adm_banner
            LEFT JOIN (SELECT banner_code,COUNT(idx) as downcontents FROM adm_banner_data GROUP BY banner_code) as adm_banner_data 
            ON adm_banner.banner_code = adm_banner_data.banner_code
            WHERE adm_banner.banner_code = "'.$banner_code.'"
            ORDER BY created_at desc');
           // ->groupBy('name')

        return $result;

    }

    public function getBannerDataList($params, $banner_code) {


        $result = $this->statDB->table('adm_banner_data')
            ->select(
                'adm_banner_data.idx',
                'adm_banner_data.br_title',
                'adm_banner_data.isuse',
                'adm_banner_data.contents',
                'adm_banner_data.br_seq',
                'adm_banner_data.created_at',
                DB::raw('IFNULL(LAG(adm_banner_data.idx) OVER (ORDER BY adm_banner_data.br_seq),"") as af_idx'),
                DB::raw('IFNULL(LEAD(adm_banner_data.idx) OVER (ORDER BY adm_banner_data.br_seq),"") as bf_idx'),
                DB::raw('IFNULL(LAG(adm_banner_data.br_seq) OVER (ORDER BY adm_banner_data.br_seq),"") as af_br_seq'),
                DB::raw('IFNULL(LEAD(adm_banner_data.br_seq) OVER (ORDER BY adm_banner_data.br_seq),"") as bf_br_seq'),
                //DB::raw('IFNULL(COUNT(adm_banner_data.idx),0) as downcontents'),
            )
            ->where('adm_banner_data.banner_code',$banner_code)
            ->orderby('br_seq','desc')
           // ->groupBy('name')
            ->get();
        
        return $result;

    }

    public function getBannerDataTotal() {

        $result = $this->statDB->table('adm_banner_data')
            ->select(DB::raw("COUNT(idx) AS cnt"))
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
                'adm_banner_data.br_seq',
                'adm_banner_data.created_at',
                DB::raw('IFNULL(LAG(adm_banner_data.idx) OVER (ORDER BY adm_banner_data.br_seq),"") as af_idx'),
                DB::raw('IFNULL(LEAD(adm_banner_data.idx) OVER (ORDER BY adm_banner_data.br_seq),"") as bf_idx'),
                DB::raw('IFNULL(LAG(adm_banner_data.br_seq) OVER (ORDER BY adm_banner_data.br_seq),"") as af_br_seq'),
                DB::raw('IFNULL(LEAD(adm_banner_data.br_seq) OVER (ORDER BY adm_banner_data.br_seq),"") as bf_br_seq'),
                //DB::raw('IFNULL(COUNT(adm_banner_data.idx),0) as downcontents'),
            )
            ->where('adm_banner_data.banner_code',$params['banner_code'])
            ->orderby('br_seq','desc')
           // ->groupBy('name')
            ->get();
        return $result;
    }

    public function BannerAdd($params,$file) {
        
        if($file != ""){
            $cfilename = $file->getClientOriginalName();
            $cfilesource = $file->hashName();
            $folderName = '/banner/';
            $file->storeAs($folderName, $file->hashName(), 'public');
            $params['banner_file'] = $cfilename;
            $params['banner_source'] = $cfilesource;
        }

        $result = $this->statDB->table('adm_banner_data')
            ->insert([
                'br_title' => $params['br_title'], 'contents' => $params['contents'], 'contents_url' => $params['contents_url'],
                'banner_file' => $params['banner_file'], 'banner_source' => $params['banner_source'], 'banner_code' => $params['banner_code'],
                'isuse' => $params['isuse'], 'mem_id' => auth()->user()->idx, 'created_at' => \Carbon\Carbon::now(),
            ]);

        if($result > 0){
            $bannercode = $params['banner_code'];
        }else{
            $bannercode = "fails";
        }

        return $bannercode;

    }

    public function BoardUpdate($params) {

        $result = $this->statDB->table('notice_board')
            ->where('idx',$params['idx'])
            ->update([
                'wr_title' => $params['wr_title'], 'wr_content' => $params['wr_content'], 'wr_open' => $params['wr_open'],
                'updated_at' => \Carbon\Carbon::now()
            ]);

        return $result;

    }

    public function BoardDelete($params) {

        $result = $this->statDB->table('notice_board')->where('idx', $params['idx'])->delete();

        return $result;

    }

}
