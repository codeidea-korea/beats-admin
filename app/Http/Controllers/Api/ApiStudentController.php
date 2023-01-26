<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ApiStudentServiceImpl;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Response;
use Session;
use Illuminate\Support\Facades\Storage;

class ApiStudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $apiStudentService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->apiStudentService = new ApiStudentServiceImpl();
    }

    public function chStudent(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";
        $sqlData = array();

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['first_name'] = $params['first_name'] ?? '';
            $params['last_name'] = $params['last_name'] ?? '';
            $params['year'] = $params['year'] ?? '';
            $params['month'] = $params['month'] ?? '';
            $params['day'] = $params['day'] ?? '';
            $params['send_email'] = $params['send_email'] ?? '';

            $result = $this->apiStudentService->setChStudent($params);
            $sqlData['sa_idx'] = $result;
            $files = $this->request->file('student_files');
            $folderName = '/studentFile/'.date("Y/m/d").'/';
            if($files != "" && $files !=null){
                foreach($files as $fa){
                    $sqlData['mem_id'] =$params['mem_id'];
                    $sqlData['file_name'] = $fa->getClientOriginalName();
                    $sqlData['hash_name'] = $fa->hashName();
                    $sqlData['file_url'] =  $folderName;
                    $this->apiStudentService->studentFileInsert($sqlData);
                    $path = Storage::disk('s3')->put($folderName. $sqlData['hash_name'], file_get_contents($fa));
                    $path = Storage::disk('s3')->url($path);
                }
            }

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']=$result;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

}
