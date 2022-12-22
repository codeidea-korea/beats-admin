<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ProductServiceInterface
{
    //상품 리스트 (list)
    public function getProductList($params);

    //상품 total (total)
    public function getProductTotal($params);

    //상품 등록
    public function setProduct($params);

    //상품 등록 (이미지)
    public function setProductImage($params);

    //상품 등록 (옵션)
    public function setProductOption($params);

    //상품 데이터 (Data)
    public function getProductData($params,$bidx);

    //옵션 리스트 (list)
    public function getProductOption($params,$bidx);

    //상품 수정
    public function putProduct($params);

    //이미지 삭제
    public function delProductImage($params);

    //옵션 삭제
    public function delProductOption($params);



}
