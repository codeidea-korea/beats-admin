<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ProductServiceImpl extends DBConnection implements ProductServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    //상품 리스트 (list)
    public function getProductList($params)
    {
        $result = $this->statDB->table('products')
            ->select(
                'idx',
                'is_display',
                DB::raw("CASE
                WHEN is_display = 'Y' THEN '공개'
                WHEN is_display = 'N' THEN '비공개'
                ELSE '미지정' END AS isDisplayView"),
                'name',
                DB::raw("(select count(idx) from products_option where products_idx = products.idx) as optionCnt"),
                'price',
                'delivery_charge',
                'admin_name',
                'create_date',

            // $this->statDB->raw('SUM(name) AS CNT')
            )
           //->when(isset($params['gubun']), function($query) use ($params){
           //    return $query->where(function($query) use ($params) {
           //        $query->where('gubun',  $params['gubun']);
           //    });
           //})
           //->when(isset($params['wr_open']), function($query) use ($params){
           //    return $query->where(function($query) use ($params) {
           //        $query->where('wr_open',  $params['wr_open']);
           //    });
           //})
           //->when(isset($params['search_text']), function($query) use ($params){
           //    return $query->where(function($query) use ($params) {
           //        $query->where('wr_title', 'like', '%'.$params['search_text'].'%');
           //    });
           //})
           //->when(isset($params['fr_search_at']), function($query) use ($params){
           //    return $query->where(function($query) use ($params) {
           //        $query->whereBetween('notice_board.created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
           //    });
           //})
            //->orderby('notice_board.gubun','desc')
            ->orderby('idx','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            // ->groupBy('name')
            ->get();
        return $result;
    }

    //상품 total (total)
    public function getProductTotal($params)
    {
        $result = $this->statDB->table('products')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->first();
        return $result;
    }

    //상품 등록 (Data)
    public function setProduct($params)
    {
        $result = $this->statDB->table('products')
            ->insertGetId([
                'bj' => $params['bj']
                , 'name' => $params['name']
                , 'name_en' => $params['name_en']
                , 'name_jp' => $params['name_jp']
                , 'name_ch' => $params['name_ch']
                , 'price' => $params['price']
                , 'information' => $params['information']
                , 'information_en' => $params['information_en']
                , 'information_jp' => $params['information_jp']
                , 'information_ch' => $params['information_ch']
                , 'delivery_charge' => $params['delivery_charge']
                , 'delivery_charge_re' => $params['delivery_charge_re']
                , 'delivery_charge_ch' => $params['delivery_charge_ch']
                , 'delivery_charge_jj' => $params['delivery_charge_jj']
                , 'delivery_charge_ex' => $params['delivery_charge_ex']
                , 'policy' => $params['policy']
                , 'policy_en' => $params['policy_en']
                , 'policy_jp' => $params['policy_jp']
                , 'policy_ch' => $params['policy_ch']
                , 'is_display' => $params['is_display']
                , 'admin_idx' => $params['admin_idx']
                , 'admin_name' => $params['admin_name']
            ]);
        return $result;
    }
    //상품 등록 (이미지)
    public function setProductImage($params)
    {
        $result = $this->statDB->table('products_file')
            ->insert([
                'products_idx' => $params['products_idx']
                , 'file_name' => $params['file_name']
                , 'hash_name' => $params['hash_name']
                , 'file_url' => $params['file_url']
            ]);
        return $result;
    }

    //상품 등록 (옵션)
    public function setProductOption($params)
    {
        $result = $this->statDB->table('products_option')
            ->insert([
                'products_idx' => $params['products_idx']
                , 'option_no' => $params['option_no']
                , 'option_title' => $params['option_title']
                , 'option_price' => $params['option_price']
                , 'option_stock' => $params['option_stock']
            ]);

        return $result;
    }

    //상품 데이터 (Data)
    public function getProductData($params,$bidx)
    {
        $result = $this->statDB->table('products')
            ->leftJoin('products_file', 'products.idx', '=', 'products_file.products_idx')
            ->select(
                'products.idx'
                ,'products.bj'
                ,'products.name'
                ,'products.name_en'
                ,'products.name_jp'
                ,'products.name_ch'
                ,'products.price'
                ,'products.information'
                ,'products.information_en'
                ,'products.information_jp'
                ,'products.information_ch'
                ,'products.delivery_charge'
                ,'products.delivery_charge_re'
                ,'products.delivery_charge_jj'
                ,'products.delivery_charge_ch'
                ,'products.delivery_charge_ex'
                ,'products.policy'
                ,'products.policy_en'
                ,'products.policy_jp'
                ,'products.policy_ch'
                ,'products.create_date'
                ,'products.mode_date'
                ,'products.is_display'
                ,'products.admin_idx'
                ,'products.admin_name'
                ,'products_file.file_name'
                ,'products_file.hash_name'
                ,'products_file.file_url'
                ,DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',products_file.file_url,products_file.hash_name) AS urlLink")

            )
            ->where('products.idx','=',$bidx)
            ->first();
        return $result;
    }


    //옵션 리스트 (list)
    public function getProductOption($params,$bidx)
    {
        $result = $this->statDB->table('products_option')
            ->select(
                'idx',
                'option_no',
                'option_title',
                'option_price',
                'option_stock',
            )
            ->where('products_idx','=',$bidx)
            ->orderBy('option_no','asc')
            ->get();
        return $result;
    }

    //상품 수정
    public function putProduct($params)
    {
        $result = $this->statDB->table('products')
            ->where('idx',$params['idx'])
            ->update(
                [
                    'bj'                  => $params['bj']
                    ,'name'               => $params['name']
                    ,'name_en'            => $params['name_en']
                    ,'name_jp'            => $params['name_jp']
                    ,'name_ch'            => $params['name_ch']
                    ,'price'              => $params['price']
                    ,'information'        => $params['information']
                    ,'information_en'     => $params['information_en']
                    ,'information_jp'     => $params['information_jp']
                    ,'information_ch'     => $params['information_ch']
                    ,'delivery_charge'    => $params['delivery_charge']
                    ,'delivery_charge_re' => $params['delivery_charge_re']
                    ,'delivery_charge_ch' => $params['delivery_charge_ch']
                    ,'delivery_charge_jj' => $params['delivery_charge_jj']
                    ,'delivery_charge_ex' => $params['delivery_charge_ex']
                    ,'policy'             => $params['policy']
                    ,'policy_en'          => $params['policy_en']
                    ,'policy_jp'          => $params['policy_jp']
                    ,'policy_ch'          => $params['policy_ch']
                    ,'is_display'         => $params['is_display']
                    ,'admin_idx'          => $params['admin_idx']
                    ,'admin_name'         => $params['admin_name']
                    ,'mode_date' => DB::raw("now()")
                ]
            );
        return $result;
    }

    //이미지 삭제
    public function delProductImage($params)
    {
        $result = $this->statDB->table('products_file')
            ->where('products_idx',$params['idx'])
            ->delete();
        return $result;
    }

    //옵션 삭제
    public function delProductOption($params)
    {
        $result = $this->statDB->table('products_option')
            ->where('products_idx',$params['idx'])
            ->delete();
        return $result;
    }

}
