<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiMentoServiceInterface
{
    //배너 리스트
    public function getFieldList($params);

    //멘토 전환신청
    public function setChMento($params);

    //멘토 파일 db저장
    public function mentoFileInsert($sqlData);

    //멘토 파일 db삭제
    public function delMentoFile($params);

    //멘토 뮤지션 소개 내용
    public function getIntroduction($params);

    //멘토 뮤지션 소개 내용 수정
    public function setIntroduction($params);

    //멘토 뮤지션 엘범 list
    public function getAlbum($params);

    //멘토 뮤지션 엘범 추가
    public function setAlbum($params);

    //멘토 뮤지션 엘범 삭제
    public function delAlbum($params);

    //멘토 뮤지션 엘범 수정
    public function upAlbum($params);

    //멘토 뮤지션 앨범 수정 전부 적용
    public function upAllAlbum($params);

    //멘토 뮤지션 추천 태그
    public function getTag();

    //멘토 뮤지션 수상 이력 list
    public function getAward($params);

    //멘토 뮤지션 수상 추가
    public function setAward($params);

    //멘토 뮤지션 수상 삭제
    public function delAward($params);

    //멘토 뮤지션 수상 수정
    public function upAward($params);

    //멘토 뮤지션 수상 전부 적용
    public function upAllAward($params);

    //멘토 뮤지션 경력사항 list
    public function getCareer($params);

    //멘토 뮤지션 경력사항 추가
    public function setCareer($params);

    //멘토 뮤지션 경력사항 삭제
    public function delCareer($params);

    //멘토 뮤지션 경력사항 수정
    public function upCareer($params);

    //멘토 뮤지션 경력사항 전부 적용
    public function upAllCareer($params);

}
