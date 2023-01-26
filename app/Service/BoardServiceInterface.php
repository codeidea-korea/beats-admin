<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface BoardServiceInterface
{
    public function getBoardList($params);

    public function getBoardView($params, $bidx);

    public function BoardAdd($params);

    public function BoardUpdate($params);

    public function BoardDelete($params);

    public function getEventList($params);

    public function getEventTotal($params);

    public function getEventView($params, $bidx);

    public function EventAdd($params, $file);

    public function EventUpdate($params, $file);

    public function EventDelete($params);

    public function getTermsList($params);

    public function getGubun($params);

    public function getTermsType($params);

    public function getTermsTotal($params);

    public function getTermsView($params, $tidx);

    public function getMaxVersion($params);

    public function TermsAdd($params);

    public function TermsUpdate($params);

    public function TermsDelete($params);

    public function upload($params);

    public function getContractList($params);

    public function getContractTotal($params);

    public function setContractAdd($params);

    public function getContractView($idx);

    public function getTrendList($params);

    public function getTrendTotal($params);

    public function getTrendView($params, $bidx);

    public function TrendAdd($params, $file);

    public function TrendUpdate($params, $file);

    public function TrendDelete($params);

    public function getTrendBeatView($params,$idx);

    public function getTrendBeatTotal($params,$idx);

    public function getTrendCommentView($params,$idx);

    public function getTrendCommentTotal($params,$idx);

    public function getLangData();
}
