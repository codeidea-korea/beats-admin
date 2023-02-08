<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

class ApiCoComposerServiceImpl extends DBConnection  implements ApiCoComposerServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCheckEmailSetData($params){
        $result = $this->statDB->table('music_head')
            ->leftJoin('member_data', 'member_data.mem_id', '=', 'member_data.mem_id')
            ->select(
                'music_head.music_title as title',
                'member_data.mem_nickname as nickname',
            )
            ->where('music_head.idx',$params['music_head_idx'] )
            ->first();
        return $result;
    }

    public function setCoComposerInvite($params) {

        $result = $this->statDB->table('co_composer_invite')
            ->insert([
                'music_head_idx' => $params['music_head_idx'],
                'send_email' => $params['send_emails']
            ]);

        return $result;
    }

    public function getCheckEmail($params) {

        $result = $this->statDB->table('co_composer_invite')
            ->select(
                DB::raw("count(idx) AS cnt"),
            )
            ->where('music_head_idx',$params['music_head_idx'])
            ->where('send_email',$params['send_email'])
            ->where('isStatus','E')
            ->first();

        return $result;

    }

    public function setCoComposer($params) {

        $result = $this->statDB->table('co_composer')
            ->insert([
                'music_head_idx' => $params['music_head_idx'],
                'co_composer_mem_id' => $params['mem_id'],
                'send_email' => $params['send_email'],
                'contract_no' => $params['contract_no']
            ]);

        $result2 = $this->statDB->table('co_composer_invite')
            ->where('music_head_idx',$params['music_head_idx'])
            ->where('send_email',$params['send_email'])
            ->update(
                [
                    'isStatus' => 'Y'
                ]
            );


        $result3 = $this->statDB->table('music_head')
            ->where('idx',$params['music_head_idx'])
            ->update(
                [
                    'common_composition' => 'Y',
                    'moddate' =>  DB::raw('now()')
                ]
            );

        return $result;

    }

    public function setCopyRight($params) {
        $result = $this->statDB->table('music_head')
            ->where('idx',$params['music_head_idx'])
            ->update(
                [
                    'copyright' => $params['copyright'],
                    'moddate' =>  DB::raw('now()')
                ]
            );


        $mCnt=count($params['co_composer_mem_id']);

        for($i=0;$i < $mCnt; $i++){

            $result2 = $this->statDB->table('co_composer')
                ->where('music_head_idx',$params['music_head_idx'])
                ->where('co_composer_mem_id',$params['co_composer_mem_id'][$i])
                ->update(
                    [
                        'copyright' => $params['co_composer_copyright'][$i],
                        'moddate' =>  DB::raw('now()'),
                        'isCopyRight' =>  'I'
                    ]
                );

        }
        return $result;

    }

    public function getCoComposer($params) {
        $result = $this->statDB->table('co_composer')
            ->leftJoin('member_data', 'co_composer.co_composer_mem_id', '=', 'member_data.mem_id')
            ->select(
                'co_composer.idx',
                'co_composer.music_head_idx',
                'co_composer.co_composer_mem_id',
                'co_composer.send_email',
                'co_composer.contract_no',
                'co_composer.copyright',
                'co_composer.isUse',
                'co_composer.isCopyRight',
                'member_data.mem_nickname'
            )
            ->where('co_composer.music_head_idx',$params['music_head_idx'])
            ->orderby('idx','asc')
            ->get();
        return $result;
    }

    public function getMainCopyRight($params){
        $result = $this->statDB->table('music_head')
            ->leftJoin('member_data', 'music_head.mem_id', '=', 'member_data.mem_id')
            ->select(
                'member_data.mem_id',
                'member_data.mem_nickname',
                'music_head.copyright',
            )
            ->where('music_head.idx',$params['music_head_idx'])
            ->first();
        return $result;
    }

    public function putCopyRightOk($params) {

        $result = $this->statDB->table('co_composer')
            ->where('music_head_idx',$params['music_head_idx'])
            ->where('co_composer_mem_id',$params['co_composer_mem_id'])
            ->update(
                [
                    'isCopyRight' => $params['isCopyRight'],
                    'moddate' =>  DB::raw('now()')
                ]
            );


        return $result;

    }

    public function inviteList($params){
        $result = $this->statDB->table('co_composer_invite')
            ->select(
                'idx as inviteIdx',
                'music_head_idx as musicHeadIdx',
                'send_email as email',
                'isStatus',
                DB::raw("CASE WHEN isStatus = 'E' THEN '요청' WHEN isStatus = 'Y' THEN '승인'  WHEN isStatus = 'D' THEN '반려' ELSE '' END AS isStatusValue"),
            )
            ->where('music_head_idx',$params['music_head_idx'] )
            ->get();
        return $result;
    }
    public function inviteList2($params){
        $result = $this->statDB->table('co_composer')
            ->select(
                'idx as inviteIdx',
                'music_head_idx as musicHeadIdx',

                'co_composer_mem_id as coComposerMemId',
                'send_email as sendEmail',
                'contract_no as contractNo',
                'music_head_idx as musicHeadIdx',
                'music_head_idx as musicHeadIdx',
                'music_head_idx as musicHeadIdx',
                'isUse',
                DB::raw("CASE
                WHEN isUse = 'Y' THEN '권한있음'
                WHEN isUse = 'E' THEN '권한해지신청'
                WHEN isUse = 'N' THEN '권한해지'
                ELSE '' END AS isUseValue"),
                'copyright',
                'isCopyRight',
                DB::raw("CASE
                WHEN isCopyRight = 'Y' THEN '권한있음'
                WHEN isCopyRight = 'E' THEN '권한해지신청'
                WHEN isCopyRight = 'N' THEN '권한해지'
                ELSE '' END AS isCopyRightValue"),
            )
            ->where('isUse','!=','N')
            ->where('music_head_idx',$params['music_head_idx'] )
            ->get();
        return $result;
    }

    public function inviteDel($params){
        $result = $this->statDB->table('co_composer_invite')
            ->where('idx',$params['idx'])
            ->delete();
        return $result;
    }

    public function cancellation($params){
        // authority_cancellation 테이블에 공동작곡가 mem_id 기초 데이터를 등록
        $result = $this->statDB->insert(
            "
                    INSERT INTO authority_cancellation (
                        music_head_idx
                        ,target_mem_id
                        ,co_composer_mem_id
                    )
                    select
                        co_composer.music_head_idx
                        ,".$params['target_mem_id']."
                        ,co_composer.co_composer_mem_id
                    from
                        co_composer
                    where
                        co_composer.music_head_idx = ".$params['music_head_idx']
        );
        // co_composer 테이블에 타겟 co_composer_mem_id 이 일치한 isUse 의 값을 E 로 변경
        $result2 = $this->statDB->table('co_composer')
            ->where('music_head_idx',$params['music_head_idx'])
            ->where('co_composer_mem_id',$params['target_mem_id'])
            ->update([
                'isUse' => 'E'
                ,'moddate' => DB::raw('now()')
            ]);
        return $result;
    }

    public function cancelDecision($params){
        $result = $this->statDB->table('authority_cancellation')
            ->where('music_head_idx',$params['music_head_idx'])
            ->where('target_mem_id',$params['target_mem_id'])
            ->where('co_composer_mem_id',$params['co_composer_mem_id'])
            ->update([
                'isYN' => $params['isYN']
                ,'moddate' => DB::raw('now()')
            ]);
        return $result;
    }


    public function coComposerDel($params){

        $result = $this->statDB->table('authority_cancellation')
            ->select(
                DB::raw("COUNT(idx) AS T1")
                ,DB::raw("SUM(CASE WHEN isYN='Y' THEN 1 ELSE 0 END) AS T2")
            )
            ->where('music_head_idx', $params['music_head_idx'])
            ->where('target_mem_id', $params['target_mem_id'])
            ->first();
        if($result->T1 == $result->T2){
            $result2 = $this->statDB->table('co_composer')
                ->where('music_head_idx',$params['music_head_idx'])
                ->where('co_composer_mem_id',$params['target_mem_id'])
                ->update([
                    'isUse' => 'N'
                    ,'moddate' => DB::raw('now()')
                ]);
        }
        return $result;
    }

}
