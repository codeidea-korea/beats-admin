<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\MemberNoticeServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiMemberNoticeController extends Controller
{
    private $request;
    private $memberNoticeService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->memberNoticeService = new MemberNoticeServiceImpl();

    }

    public function SoundDelNotice()
    {
        $alram_1day_delete = DB::table('music_head')
        ->select(
            'music_head.idx',
            'music_head.mem_id',
            'music_head.music_title'
        )
        ->where('music_head.del_status','Y')
        ->where('music_head.alram_status','!=',1)
        ->whereBetween(DB::raw('now()'), [DB::raw('DATE_ADD(music_head.del_date, INTERVAL -1 DAY)'),DB::raw('music_head.del_date')])
        ->get();

        foreach($alram_1day_delete as $rs){
            DB::table('member_notice')
            ->insert([
                'mem_id' => $rs->mem_id
                ,'gubun' => '03'
                ,'message' => $rs->music_title.'(음원)이 삭제되기 1일 전입니다.'
                ,'url' => '/mypage/music_management_list'
            ]);

            DB::table('music_head')
            ->where('idx',$rs->idx)
            ->update([
                'alram_status' => 1
            ]);
        }

        $alram_delete = DB::table('music_head')
        ->select(
            'music_head.idx',
            'music_head.mem_id',
            'music_head.music_title'
        )
        ->where('music_head.del_status','Y')
        ->where('music_head.alram_status','!=',2)
        ->where(DB::raw('now()') ,'>=' ,DB::raw('music_head.del_date'))
        ->get();

        foreach($alram_delete as $rs){
            DB::table('member_notice')
            ->insert([
                'mem_id' => $rs->mem_id
                ,'gubun' => '03'
                ,'message' => $rs->music_title.'(음원)이 완전히 삭제되었습니다.'
                ,'url' => '/mypage/music_management_list'
            ]);

            DB::table('music_head')
            ->where('idx',$rs->idx)
            ->update([
                'alram_status' => 2
            ]);
        }

        echo $alram_delete;
    }

    public function setMyAlarmList()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;

            $resultData = $this->memberNoticeService->getMyNoticeList($params);
            $notReadCnt = $this->memberNoticeService->getMyNotReadCnt($params);

            foreach($resultData as $key => $data){
                $diff = strtotime($data->nowDate) - strtotime($data->createDate);

                $s = 60; //1분 = 60초
                $h = $s * 60; //1시간 = 60분
                $d = $h * 24; //1일 = 24시간
                $y = $d * 30; //1달 = 30일 기준
                $a = $y * 12; //1년

                if ($diff < $s) {
                    $result = $diff . '초전';
                } elseif ($h > $diff && $diff >= $s) {
                    $result = round($diff/$s) . '분전';
                } elseif ($d > $diff && $diff >= $h) {
                    $result = round($diff/$h) . '시간전';
                } elseif ($y > $diff && $diff >= $d) {
                    $result = round($diff/$d) . '일전';
                } elseif ($a > $diff && $diff >= $y) {
                    $result = round($diff/$y) . '달전';
                } else {
                    $result = round($diff/$a) . '년전';
                }

                $resultData[$key]->createDate_re = $result; //db 갖어오는 값에서 중복 문제로 아래와 같이 수정
            }

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']['data']=$resultData;
            $returnData['response']['totalCnt']=count($resultData);
            $returnData['response']['notReadCnt']=$notReadCnt->cnt;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }

    public function setCheckMyAlarm()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['member_Notice_idx'] = $params['member_Notice_idx'] ?? 0;

            $result = $this->memberNoticeService->setCheckNotice($params);

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']=$result;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return json_encode($returnData);
    }


}
