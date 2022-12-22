<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ApiMentoServiceImpl;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Response;
use Session;
use Illuminate\Support\Facades\Storage;

class ApiMentoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;
    private $apiMentoService;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->apiMentoService = new ApiMentoServiceImpl();
    }

    public function getFieldList()
    {
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

            try{
                $params = $this->request->input();
                $result = $this->apiMentoService->getFieldList($params);
                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$result;

            } catch(\Exception $exception){
                throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
            }

        return json_encode($returnData);

    }

    public function chMento(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['field1'] = $params['field1'] ?? '';
            $params['field2'] = $params['field2'] ?? '';
            $params['field3'] = $params['field3'] ?? '';



            $result = $this->apiMentoService->setChMento($params);

            $files = $this->request->file('mento_files');
            $folderName = '/mentoFile/'.date("Y/m/d").'/';

            if($files != "" && $files !=null){

                foreach($files as $fa){

                    $sqlData['mem_id'] =$params['mem_id'];
                    $sqlData['file_name'] = $fa->getClientOriginalName();
                    $sqlData['hash_name'] = $fa->hashName();
                    $sqlData['file_url'] =  $folderName;
                    $this->apiMentoService->mentoFileInsert($sqlData);
                    $path = Storage::disk('s3')->put($folderName. $sqlData['hash_name'], file_get_contents($fa));
                    $path = Storage::disk('s3')->url($path);
                }
            }


            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['mento_status']=2;
            $returnData['response']=$result;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function getIntroduction(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;

            $result = $this->apiMentoService->getIntroduction($params);

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']=$result;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function setIntroduction(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['introduction'] = $params['introduction'] ?? '';

            $result = $this->apiMentoService->setIntroduction($params);

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']=$result;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function getAlbumm(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;

            $result = $this->apiMentoService->getAlbum($params);

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']=$result;
            $returnData['total']=count($result);

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function setAlbumm(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            //$params['sort_no'] = $params['sort_no'] ?? 0;
            $params['release_date'] = $params['release_date'] ?? '';
            $params['title'] = $params['title'] ?? '';
            $params['tag'] = $params['tag'] ?? '';
            $params['release_date'] = trim(str_replace('-','',$params['release_date']));

            $file = $this->request->file('album_file');
            $folderName = '/mentoAlbum/'.date("Y/m/d").'/';

            if($params['mem_id']!=0&&$params['release_date']!=""&&$params['title']!=""){
                if($file != "" && $file !=null){
                    $params['file_name'] = $file->getClientOriginalName();
                    $params['hash_name'] = $file->hashName();
                    $params['file_url'] =  $folderName;
                    $path = Storage::disk('s3')->put($folderName. $params['hash_name'], file_get_contents($file));
                    $path = Storage::disk('s3')->url($path);

                }else{
                    $params['file_name'] = null;
                    $params['hash_name'] = null;
                    $params['file_url'] =  null;
                }
                //var_dump($params);exit();
                $result = $this->apiMentoService->setAlbum($params);

                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$result;
            }else{
                $returnData['code']=300;
                $returnData['message']="누락된 값이 존제합니다.";
            }




        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function delAlbumm(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['album_idx'] = $params['album_idx'] ?? 0;
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['sort_no'] = $params['sort_no'] ?? 0;

            $result = $this->apiMentoService->delAlbum($params);

            if($result){
                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$result;
            }else{
                $returnData['code']=1;
                $returnData['message']="삭제된 데이터가 없습니다.";
                $returnData['response']=$result;
            }


        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function upAlbumm(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['album_idx'] = $params['album_idx'] ?? 0;
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['release_date'] = $params['release_date'] ?? '';
            $params['title'] = $params['title'] ?? '';
            $params['tag'] = $params['tag'] ?? '';
            $params['release_date'] = trim(str_replace('-','',$params['release_date']));

            $file = $this->request->file('album_file');
            $folderName = '/mentoAlbum/'.date("Y/m/d").'/';

            if($params['mem_id']!=0&&$params['release_date']!=""&&$params['title']!=""&&$params['album_idx']!=0){
                if($file != "" && $file !=null){
                    $params['file_name'] = $file->getClientOriginalName();
                    $params['hash_name'] = $file->hashName();
                    $params['file_url'] =  $folderName;
                    $path = Storage::disk('s3')->put($folderName. $params['hash_name'], file_get_contents($file));
                    $path = Storage::disk('s3')->url($path);

                }else{
                    $params['file_name'] = null;
                    $params['hash_name'] = null;
                    $params['file_url'] =  null;
                }

                $result = $this->apiMentoService->upAlbum($params);

                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$result;
            }else{
                $returnData['code']=300;
                $returnData['message']="누락된값이 존재합니다.";
            }


        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function upAllAlbunm(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['album_idx'] = $params['album_idx'] ?? [];
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['release_date'] = $params['release_date'] ?? [];
            $params['title'] = $params['title'] ?? [];
            $params['tag'] = $params['tag'] ?? [];
            $params['sort_idx'] = $params['sort_idx'] ?? [];

            $file = $this->request->file('album_file');
            $folderName = '/mentoAlbum/'.date("Y/m/d").'/';

            if($params['mem_id']!=0&&$params['release_date']!=""&&$params['title']!=""&&$params['album_idx']!=0){
                if($file != "" && $file !=null){
                    $params['file_name'] = $file->getClientOriginalName();
                    $params['hash_name'] = $file->hashName();
                    $params['file_url'] =  $folderName;
                    $path = Storage::disk('s3')->put($folderName. $params['hash_name'], file_get_contents($file));
                    $path = Storage::disk('s3')->url($path);

                }else{
                    $params['file_name'] = null;
                    $params['hash_name'] = null;
                    $params['file_url'] =  null;
                }

                $sqlData['mem_id'] = $params['mem_id'];

                $sqlData['file_name'] = null;
                $sqlData['hash_name'] = null;
                $sqlData['file_url'] =  null;

                foreach($params['album_idx'] as $key => $rs){
                    $sqlData['album_idx'] = $rs;
                    $sqlData['release_date'] = trim(str_replace('-','',$params['release_date'][$key]));
                    $sqlData['title'] = $params['title'][$key];
                    $sqlData['tag'] = $params['tag'][$key];
                    $sqlData['sort_idx'] = $params['sort_idx'][$key];

                    $result = $this->apiMentoService->upAllAlbum($sqlData);
                }

                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$result;
            }else{
                $returnData['code']=300;
                $returnData['message']="누락된값이 존재합니다.";
            }


        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function getTag(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;

            $result = $this->apiMentoService->getTag();

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']=$result;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }


    public function getAward(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;

            $result = $this->apiMentoService->getAward($params);

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']=$result;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function setAward(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['award_date'] = $params['award_date'] ?? '';
            $params['title'] = $params['title'] ?? '';
            $params['award_date'] = trim(str_replace('-','',$params['award_date']));

            if($params['mem_id']!=0&&$params['award_date']!=""&&$params['title']!="") {

                $result = $this->apiMentoService->setAward($params);
                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$result;

            }else{
                $returnData['code']=300;
                $returnData['message']="누락된값이 존재합니다.";
            }


        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function delAward(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['award_idx'] = $params['award_idx'] ?? 0;
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['sort_no'] = $params['sort_no'] ?? 0;

            $result = $this->apiMentoService->delAward($params);

            if($result){
                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$result;
            }else{
                $returnData['code']=1;
                $returnData['message']="삭제된 데이터가 없습니다.";
                $returnData['response']=$result;
            }


        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function upAward(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['award_idx'] = $params['award_idx'] ?? 0;
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['award_date'] = $params['award_date'] ?? '';
            $params['title'] = $params['title'] ?? '';
            $params['award_date'] = trim(str_replace('-','',$params['award_date']));

            if($params['award_idx']!=0&&$params['mem_id']!=0&&$params['award_date']!=""&&$params['title']!="") {
                $result = $this->apiMentoService->upAward($params);

                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$result;
            }else{
                $returnData['code']=300;
                $returnData['message']="누락된값이 존재합니다.";
            }



        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function upAllAward(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['award_idx'] = $params['award_idx'] ?? [];
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['award_date'] = $params['award_date'] ?? [];
            $params['title'] = $params['title'] ?? [];
            $params['sort_idx'] = $params['sort_idx'] ?? [];
            //$params['award_date'] = trim(str_replace('-','',$params['award_date']));

            if($params['award_idx']!=[]&&$params['mem_id']!=0&&$params['award_date']!=[]&&$params['title']!=[]) {

                $sqlData['mem_id'] = $params['mem_id'];

                foreach($params['award_idx'] as $key => $rs){
                    $sqlData['award_idx'] = $rs;
                    $sqlData['award_date'] = trim(str_replace('-','',$params['award_date'][$key]));
                    $sqlData['title'] = $params['title'][$key];
                    $sqlData['sort_idx'] = $params['sort_idx'][$key];

                    $result = $this->apiMentoService->upAllAward($sqlData);
                }

                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$result;
            }else{
                $returnData['code']=300;
                $returnData['message']="누락된값이 존재합니다.";
            }



        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function getCareer(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;

            $result = $this->apiMentoService->getCareer($params);

            $returnData['code']=0;
            $returnData['message']="complete";
            $returnData['response']=$result;

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function setCareer(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['s_date'] = $params['s_date'] ?? '';
            $params['e_date'] = $params['e_date'] ?? '';
            $params['s_date'] = trim(str_replace('-','',$params['s_date']));
            $params['e_date'] = trim(str_replace('-','',$params['e_date']));
            $params['title'] = $params['title'] ?? '';
            $params['career'] = $params['career'] ?? '';

            if($params['mem_id']!=0&&$params['s_date']!=""&&$params['e_date']!=""&&$params['career']!=""&&$params['title']!="") {
                $result = $this->apiMentoService->setCareer($params);
                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$result;
            }else{
                $returnData['code']=300;
                $returnData['message']="누락된값이 존재합니다.";
            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function delCareer(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['career_idx'] = $params['career_idx'] ?? 0;
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['sort_no'] = $params['sort_no'] ?? 0;

            $result = $this->apiMentoService->delCareer($params);

            if($result){
                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$result;
            }else{
                $returnData['code']=1;
                $returnData['message']="삭제된 데이터가 없습니다.";
                $returnData['response']=$result;
            }


        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function upCareer(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['career_idx'] = $params['career_idx'] ?? 0;
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['s_date'] = $params['s_date'] ?? '';
            $params['e_date'] = $params['e_date'] ?? '';
            $params['s_date'] = trim(str_replace('-','',$params['s_date']));
            $params['e_date'] = trim(str_replace('-','',$params['e_date']));
            $params['title'] = $params['title'] ?? '';
            $params['career'] = $params['career'] ?? '';

            if($params['career_idx']!=0&&$params['mem_id']!=0&&$params['s_date']!=""&&$params['e_date']!=""&&$params['career']!=""&&$params['title']!="") {
                $result = $this->apiMentoService->upCareer($params);

                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$result;
            }else{
                $returnData['code']=300;
                $returnData['message']="누락된값이 존재합니다.";

            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

    public function upAllCareer(){
        $returnData['code'] = -1;
        $returnData['message'] = "시스템 장애";

        try{
            $params = $this->request->input();
            $params['career_idx'] = $params['career_idx'] ?? [];
            $params['mem_id'] = $params['mem_id'] ?? 0;
            $params['s_date'] = $params['s_date'] ?? [];
            $params['e_date'] = $params['e_date'] ?? [];
            // $params['s_date'] = trim(str_replace('-','',$params['s_date']));
            // $params['e_date'] = trim(str_replace('-','',$params['e_date']));
            $params['title'] = $params['title'] ?? [];
            $params['career'] = $params['career'] ?? [];
            $params['sort_idx'] = $params['sort_idx'] ?? [];

            if($params['career_idx']!=[]&&$params['mem_id']!=0&&$params['s_date']!=[]&&$params['e_date']!=[]&&$params['career']!=[]&&$params['title']!=[]) {

                $sqlData['mem_id'] = $params['mem_id'];

                foreach($params['career_idx'] as $key => $rs){
                    $sqlData['career_idx'] = $rs;
                    $sqlData['s_date'] = trim(str_replace('-','',$params['s_date'][$key]));
                    $sqlData['e_date'] = trim(str_replace('-','',$params['e_date'][$key]));
                    $sqlData['title'] = $params['title'][$key];
                    $sqlData['career'] = $params['career'][$key];
                    $sqlData['sort_idx'] = $params['sort_idx'][$key];

                    $result = $this->apiMentoService->upAllCareer($sqlData);
                }

                $returnData['code']=0;
                $returnData['message']="complete";
                $returnData['response']=$result;
            }else{
                $returnData['code']=300;
                $returnData['message']="누락된값이 존재합니다.";

            }

        } catch(\Exception $exception){
            throw new HttpException(400,"Invalid data -{$exception->getMessage()}");
        }

        return json_encode($returnData);
    }

}
