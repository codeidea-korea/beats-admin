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
        $_where = "";
        //음원상태 및 진행율   (10단위 증가임 이에 select박스 주성 유무 문의)
        if (trim($params['progress_rate']) == "") {
            $_where = "";
        } elseif ($params['progress_rate'] == "100") {
            $_where .= " AND H.progress_rate = '100'";
        } else {

            $_where .= " AND H.progress_rate != '100'";
        }
        //작업방식
        if (trim($params['common_composition']) == "") {
            $_where .= "";
        } else {
            $_where .= " AND H.common_composition = '" . $params['common_composition'] . "' ";
        }

        //판매상태
        if (trim($params['sales_status']) == "") {
            $_where .= "";
        } else {
            $_where .= " AND H.sales_status = '" . $params['sales_status'] . "' ";
        }

        //공개상태
        if (trim($params['open_status']) == "") {
            $_where .= "";
        } else {
            $_where .= " AND H.open_status = '" . $params['open_status'] . "' ";
        }

        //검색
        if (trim($params['search_text']) == "") {
            $_where .= "";
        } else {
            $_where .= " AND ( H.tag like '%" . $params['search_text'] . "%' or H.music_title like '%" . $params['search_text'] . "%')";
        }


        $result = $this->statDB->select(
            "
                    SELECT
                        H.idx
                        ,H.mem_id
                        ,H.file_cnt
                        ,H.music_title
                        ,H.play_time
                        ,H.open_status
                        ,H.sales_status
                        ,H.contract
                        ,H.tag
                        ,H.progress_rate
                        ,H.common_composition
                        ,H.crdate
                        ,H.copyright
                        ,M.mem_id AS fMemId
                        ,M.mem_nickname AS fNickName
                        ,F.representative_music
                        ,F.file_name
                        ,F.file_no
                        ,F.hash_name
                        ,F.file_url
                        ,H.moddate
                        ,H.file_version
                    FROM
                    music_head H LEFT JOIN music_file F ON H.idx = F.music_head_idx
                    LEFT JOIN member_data M ON F.mem_id=M.mem_id
                    WHERE
                    F.representative_music = 'Y'
                    AND F.version = H.file_version
                    " . $_where . "
                    ORDER BY H.idx desc"
        );

        return $result;
    }



}
