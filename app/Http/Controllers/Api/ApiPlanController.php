<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ApiPlanServiceImpl;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Storage;

class ApiPlanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $apiPlanService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->apiPlanService = new ApiPlanServiceImpl();
    }
    public function getPlanList()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";
        $data = array();

        try{
            $params = $this->request->input();
            $params['lang'] = $params['lang'] ?? 'KR';

            $result = $this->apiPlanService->planList($params);
            $i=0;
            foreach($result as $rs){
                $data['planData'][$i]['idx'] = $rs->idx;
                $data['planData'][$i]['lang'] = $rs->lang;
                $data['planData'][$i]['gubun'] = $rs->gubun;
                $data['planData'][$i]['name'] = $rs->name;
                $data['planData'][$i]['contents'] = $rs->contents;
                $data['planData'][$i]['fee'] = $rs->fee;
                $data['planData'][$i]['sale'] = $rs->sale;
                $result2 = $this->apiPlanService->planBenefits($params,$rs->idx);
                $j=0;
                foreach($result2 as $r2){
                    $data['planData'][$i]['benefits'][$j]['sort_no'] = $r2->sort_no;
                    $data['planData'][$i]['benefits'][$j]['benefits'] = $r2->benefits;
                    $j++;
                }
                $i++;
            }

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']=$data;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }


}
