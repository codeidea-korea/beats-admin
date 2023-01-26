<?php

namespace App\Http\Controllers;
use App\Service\PlanServiceImpl;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Storage;

class PlanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $planService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->planService = new PlanServiceImpl();

        $this->middleware('auth');
    }
    public function getPlanList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD050000";

        $planList = $this->planService->getPlanList($params);
        $planTotal = $this->planService->getPlanTotal($params);
        $totalCount = $planTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('plan.planList',[
            'planList' => $planList
            ,'params' => $params
            ,'searchData' => $params
            ,'totalCount' => $totalCount
        ]);
    }
    public function getPlanWrite(){
        $params = $this->request->input();
        $params['menuCode'] = "AD050000";

        return view('plan.planWrite',[
            'params' => $params
        ]);
    }

    public function setPlanInsert(){

        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['gubun']       = $params['gubun'] ?? '0';
            $params['lang']        = $params['lang'] ?? 'KR';
            $params['name']        = $params['name'] ?? '';
            $params['contents']    = $params['contents'] ?? '';
            $params['fee']         = $params['fee'] ?? 0;
            $params['sale']         = $params['sale'] ?? 0;
            $params['is_yn']       = $params['is_yn'] ?? 'N';
            $params['admin_idx']   = auth()->user()->idx;
            $params['admin_name']  = auth()->user()->name;

            $params['plan_idx'] = $this->planService->setPlan($params);

            $params['sort_no'] = $params['sort_no'] ?? array();
            $params['benefits'] = $params['benefits'] ?? array();
            if($params['benefits'][0]!=null){

                // 옵션 데이터 처리
                $qrParam['plan_idx']=$params['plan_idx'];
                $opCnt=count($params['sort_no']);

                for($i=0;$i<$opCnt;$i++){
                    $qrParam['plan_idx']= $params['plan_idx'];
                    $qrParam['sort_no']=$params['sort_no'][$i];
                    $qrParam['benefits']=$params['benefits'][$i];
                    $result = $this->planService->setPlanBenefits($qrParam);
                }
            }
            $returnData['code']=0;
            $returnData['message']="요금제 등록 완료";

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return $returnData;

    }

    public function getPlanView($bidx){
        $params = $this->request->input();
        $params['menuCode'] = "AD050000";
        $params['idx'] = $bidx;

        $planData = $this->planService->getPlanData($params, $bidx);
        $benefitsData = $this->planService->getPlanBenefits($params, $bidx);

        return view('plan.planView',[
            'planData' => $planData
            ,'benefitsData' => $benefitsData
            ,'params' => $params
        ]);
    }

    public function putPlanUpdate(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();

            $params['idx']         = $params['idx'] ?? '';
            $params['lang']       = $params['lang'] ?? 'KR';
            $params['gubun']       = $params['gubun'] ?? '0';
            $params['name']        = $params['name'] ?? '';
            $params['contents']    = $params['contents'] ?? '';
            $params['fee']         = $params['fee'] ?? 0;
            $params['sale']         = $params['sale'] ?? 0;
            $params['is_yn']       = $params['is_yn'] ?? 'N';
            $params['admin_idx']   = auth()->user()->idx;
            $params['admin_name']  = auth()->user()->name;
            $params['plan_idx']        = $params['idx'];
            $this->planService->putPlan($params);
            $this->planService->delBenefits($params);


            $params['sort_no'] = $params['sort_no'] ?? array();
            $params['benefits'] = $params['benefits'] ?? array();

            if($params['benefits'][0]!=null){

                // 옵션 데이터 처리
                $qrParam['plan_idx']=$params['plan_idx'];
                $opCnt=count($params['sort_no']);

                for($i=0;$i<$opCnt;$i++){
                    $qrParam['plan_idx']= $params['plan_idx'];
                    $qrParam['sort_no']=$params['sort_no'][$i];
                    $qrParam['benefits']=$params['benefits'][$i];
                    $result = $this->planService->setPlanBenefits($qrParam);
                }
            }

            $returnData['code']=0;
            $returnData['message']="요금제 수정 완료";

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return $returnData;
    }

    public function getStudentList()
    {
        $params = $this->request->input();
        $params['menuCode'] = "AD050000";

        $params['type'] = $params['type'] ?? 0;
        $params['page'] = $params['page'] ?? 1;
        $params['limit'] = $params['limit'] ?? 10;

        $studentList = $this->planService->getStudentList($params);
        $studentTotal = $this->planService->getStudentTotal($params);
        $totalCount = $studentTotal->cnt;
        $params['totalCnt'] = $totalCount;

        return view('plan.studentList',[
            'studentList' => $studentList
            ,'params' => $params
            ,'searchData' => $params
            ,'totalCount' => $totalCount
        ]);
    }

    public function studentStatusUp(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();

            $params['idx_arr'] = $params['idx_arr'] ?? array();
            $params['status'] = $params['status'] ?? '';
            $params['student_reject'] = $params['student_reject'] ?? '';


            if($params['idx_arr']!=null && count($params['idx_arr'])!=0){
                if($params['status']=="Y"){

                    $result = $this->planService->setStudentStatusUp($params);
                    var_dump($result);exit();
                    $returnData['code']=0;
                    $returnData['message']="학생인증 승인 완료";
                    //이메일 발송
                }else if($params['status']=="N"){
                    $result = $this->planService->setStudentStatusUp2($params);
                    $returnData['code']=0;
                    $returnData['message']="학생인증 반려 완료";
                    //이메일 발송
                }else{
                    $returnData['code']=306;
                    $returnData['message']="status 값이 잘봇되었습니다.";
                }
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }
        return $returnData;
    }


}
