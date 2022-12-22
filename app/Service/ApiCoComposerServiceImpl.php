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

    public function setCoComposerInvite($params) {

        foreach($params['send_emails'] as $email){

            $result = $this->statDB->table('co_composer_invite')
                ->insert([
                    'music_head_idx' => $params['music_head_idx'],
                    'send_email' => $email,
                ]);
        }

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
                'co_composer.isUse',
                'co_composer.isCopyRight',
                'member_data.mem_nickname'
            )
            ->orderby('idx','asc')
            ->get();
        return $result;
    }

    public function getMainCopyRight($params){
        $result = $this->statDB->table('music_head')
            ->leftJoin('member_data', 'music_head.mem_id', '=', 'member_data.mem_id')
            ->select(

                'member_data.mem_nickname',
                'music_head.copyright',
            )
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

}
