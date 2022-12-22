<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;

class MemberNoticeServiceImpl extends DBConnection implements MemberNoticeServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    /*
    ==  gubun ==
    01:  회원
    02 : 음원 관리
    03 : 음원 삭제
    04 : 앨범 퍼블리싱
    05 : 코칭 피드백
    06 : 결제 완료
    07 : 판매 완료
    08 : 정산
    09 : 파일 등록 요청
    10 : 파일 등록 완료
    11 : 알림
    12 : 프로필
    */


    public function setMemberNotice($params)
    {
        $result = $this->statDB->table('member_notice')
            ->insert([
                'mem_id' => $params['mem_id']
                ,'gubun' => $params['gubun']
                ,'message' => $params['message']
                ,'url' => $params['url']
            ]);

        return $result;
    }

    public function getMemberNickname($params)
    {
        $result = $this->statDB->table('member_data')
            ->select(
                'member_data.mem_nickname'
            )
            ->where('member_data.mem_id',$params['mem_id'])
            ->first();

        return $result;
    }

    public function getMusicTitle($params)
    {
        $result = $this->statDB->table('music_head')
            ->select(
                'music_head.music_title'
                ,'music_head.mem_id'
            )
            ->whereIn('music_head.idx',$params['music_head_idx'])
            ->get();

        return $result;
    }

    public function getSoundSoruce($params)
    {
        $result = $this->statDB->table('music_head')
            ->select(
                'music_head.music_title'
                ,'music_head.mem_id'
            )
            ->where('music_head.mem_id',$params['mem_id'])
            ->get();

        return $result;
    }

    public function getMyNoticeList($params)
    {

        $result = $this->statDB->table('member_notice')
            ->select(
                'idx'
                ,'gubun'
                ,DB::raw("CASE
                    WHEN gubun = '01' THEN '회원'
                    WHEN gubun = '02' THEN '음원 관리'
                    WHEN gubun = '03' THEN '음원 삭제'
                    WHEN gubun = '04' THEN '앨범 퍼블리싱'
                    WHEN gubun = '05' THEN '코칭 피드백'
                    WHEN gubun = '06' THEN '결제 완료'
                    WHEN gubun = '07' THEN '판매 완료'
                    WHEN gubun = '08' THEN '정산'
                    WHEN gubun = '09' THEN '파일 등록 요청'
                    WHEN gubun = '10' THEN '파일 등록 완료'
                    WHEN gubun = '11' THEN '알림'
                    WHEN gubun = '12' THEN '프로필'
                ELSE ' - ' END AS gubunVal")
                ,'message'
                ,'url'
                ,'create_date as createDate'
                ,'read_yn as readYn'
                ,'read_date as readDate'
                ,DB::raw('now() as nowDate')
            )
            ->where('mem_id',$params['mem_id'])
            ->when(isset($params['gubun']), function($query) use ($params){
                return $query->whereIn('gubun',$params['gubun']);
            })
            ->when(isset($params['limit']), function($query) use ($params){
                return $query->limit($params['limit']);
            })
            ->orderby('create_date','desc')
            ->get();
        return $result;
    }

    public function getMyNotReadCnt($params)
    {

        $result = $this->statDB->table('member_notice')
            ->select(DB::raw("COUNT(member_notice.idx) AS cnt"))
            ->where('mem_id',$params['mem_id'])
            ->where('read_yn','N')
            ->first();
        return $result;
    }

    public function setCheckNotice($params)
    {
        if($params['member_Notice_idx']==0){
            //알람 전체 확인
            $result = $this->statDB->table('member_notice')
                ->where('mem_id',$params['mem_id'])
                ->where('read_yn','N')
                ->update(
                    [
                        'read_yn' => 'Y'
                        ,'read_date' => DB::raw('now()')
                    ]
                );
        }else{
            //알람 개발확인
            $result = $this->statDB->table('member_notice')
                ->where('idx',$params['member_Notice_idx'])
                ->where('mem_id',$params['mem_id'])
                ->where('read_yn','N')
                ->update(
                    [
                        'read_yn' => 'Y'
                        ,'read_date' => DB::raw('now()')
                    ]
                );
        }
        return $result;
    }
}
