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

        $result = $this->statDB->table('adm_banner')
            ->select(
                'adm_banner.idx',
                'adm_banner.mem_id',
                'adm_banner.banner_code',
                'adm_banner.banner_name',
                'adm_banner.type',
                'adm_banner.downcontents',
                'adm_banner.created_at',
                'adm_banner.updated_at',
            )
            ->orderby('created_at','desc')
           // ->groupBy('name')
            ->get();
        
        return $result;

    }

    public function getDownContents() {

        $result = $this->statDB->table('adm_banner_data')
            ->select(DB::raw("COUNT(idx) AS downcontents"))
            ->groupBy('br_idx')
            ->first();
        return $result;

    }

    public function getBannerTotal() {

        $result = $this->statDB->table('adm_banner')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->first();
        return $result;

    }

    public function getBannerView($params, $bidx) {

        $result = $this->statDB->table('adm_banner')
            ->select(
                'adm_banner.idx',
                'adm_banner.mem_id',
                'adm_banner.banner_code',
                'adm_banner.banner_name',
                'adm_banner.type',
                'adm_banner.downcontents',
                'adm_banner.created_at',
                'adm_banner.updated_at',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->where('adm_banner.idx',$bidx)
           // ->groupBy('name')
           ->get();

        return $result;

    }

    public function getBannerDataList($params, $bidx) {


        $result = $this->statDB->table('adm_banner_data')
            ->select(
                'adm_banner_data.idx',
                'adm_banner_data.br_title',
                'adm_banner_data.isuse',
                'adm_banner_data.contents',
                'adm_banner_data.br_seq',
                'adm_banner_data.created_at',
                //DB::raw('IFNULL(COUNT(adm_banner_data.idx),0) as downcontents'),
            )
            ->where('adm_banner_data.br_idx',$bidx)
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

    public function BoardAdd($params) {

        $result = $this->statDB->table('notice_board')
            ->insertGetId([
                'wr_title' => $params['wr_title'], 'wr_content' => $params['wr_content'], 'wr_open' => $params['wr_open'],
                'mem_id' => auth()->user()->id, 'created_at' => \Carbon\Carbon::now(),
            ]);

        return $result;

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
