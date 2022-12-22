<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ApiContentServiceImpl extends DBConnection  implements ApiContentServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    //리뷰 리스트
    public function getReviewList($params) {

        $result = $this->statDB->table('products_review')
            ->leftJoin('member_data', 'products_review.mem_id', '=', 'member_data.mem_id')
            ->select(
                'products_review.idx',
                'products_review.wr_title',
                DB::raw("(select count(idx) from beat_data where service_name = 'review' and service_idx = products_review.idx and is_beat = 1) as wr_bit"),
                DB::raw("(select count(idx) from comment where wr_type = 'review' and wr_idx = products_review.idx and del_status = 'N') as wr_comment"),
                DB::raw("(select count(idx) from beat_data where service_name = 'review' and service_idx = products_review.idx and mem_id = {$params['mem_id']} and is_beat = 1) as like_status"),
                DB::raw("((select count(idx) from beat_data where service_name = 'review' and service_idx = products_review.idx and is_beat = 1)
                + (select count(idx) from comment where wr_type = 'review' and wr_idx = products_review.idx)) as wr_popular"),
                'products_review.wr_content',
                'products_review.review_source',
                'products_review.file_url',
                'products_review.grade',
                DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',products_review.file_url,products_review.review_source) AS reviewfullUrl"),
                DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',member_data.profile_photo_url,member_data.profile_photo_hash_name) AS urlLink"),
                'member_data.mem_nickname',
            )
            ->where('products_review.wr_open','open')
            ->where('products_review.del_status','N')
            ->when($params['sorting'] == 2, function($query) use ($params){
                return $query->orderby('wr_popular','desc');
            })
            ->when($params['sorting'] == 3, function($query) use ($params){
                return $query->orderby('wr_comment','desc');
            })
            ->orderby('products_review.idx','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();
            
        return $result;

    }

    public function getReviewTotal($params) {

        $result = $this->statDB->table('products_review')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->where('products_review.wr_open','open')
            ->where('products_review.del_status','N')
            ->first();
        return $result;

    }

    //리뷰 활동내역 리스트
    public function getMyReviewList($params) {

        $result = $this->statDB->table('products_review')
            ->leftJoin('member_data', 'products_review.mem_id', '=', 'member_data.mem_id')
            ->select(
                'products_review.idx',
                'products_review.wr_title',
                DB::raw("(select count(idx) from beat_data where service_name = 'review' and service_idx = products_review.idx and is_beat = 1) as wr_bit"),
                DB::raw("(select count(idx) from comment where wr_type = 'review' and wr_idx = products_review.idx and del_status = 'N') as wr_comment"),
                DB::raw("(select count(idx) from beat_data where service_name = 'review' and service_idx = products_review.idx and mem_id = {$params['mem_id']} and is_beat = 1) as like_status"),
                DB::raw("((select count(idx) from beat_data where service_name = 'review' and service_idx = products_review.idx and is_beat = 1)
                + (select count(idx) from comment where wr_type = 'review' and wr_idx = products_review.idx)) as wr_popular"),
                'products_review.wr_content',
                'products_review.review_source',
                'products_review.file_url',
                'products_review.grade',
                DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',products_review.file_url,products_review.review_source) AS reviewfullUrl"),
                DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',member_data.profile_photo_url,member_data.profile_photo_hash_name) AS urlLink"),
                'member_data.mem_nickname',
            )
            ->where('products_review.wr_open','open')
            ->where('products_review.del_status','N')
            ->where('products_review.mem_id',$params['mem_id'])
            ->when(isset($params['wr_type']), function($query) use ($params){
                return $query->where('wr_type',$params['wr_type']);
            })
            ->when($params['sorting'] == 2, function($query) use ($params){
                return $query->orderby('wr_popular','desc');
            })
            ->when($params['sorting'] == 3, function($query) use ($params){
                return $query->orderby('wr_comment','desc');
            })
            ->orderby('products_review.idx','desc')
            ->skip(($params['page']-1)*$params['limit'])
            ->take($params['limit'])
            ->get();
            
        return $result;

    }

    public function getMyReviewTotal($params) {

        $result = $this->statDB->table('products_review')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->where('products_review.wr_open','open')
            ->where('products_review.del_status','N')
            ->where('products_review.mem_id',$params['mem_id'])
            ->when(isset($params['wr_type']), function($query) use ($params){
                return $query->where('wr_type',$params['wr_type']);
            })
            ->first();
        return $result;

    }

    //리뷰 상세
    public function getReviewView($params) {

        $result = $this->statDB->table('products_review')
            ->leftJoin('member_data', 'products_review.mem_id', '=', 'member_data.mem_id')
            ->select(
                'products_review.idx',
                'products_review.mem_id',
                'products_review.wr_title',
                DB::raw("(select count(idx) from beat_data where service_name = 'review' and service_idx = products_review.idx and is_beat = 1) as wr_bit"),
                DB::raw("(select count(idx) from comment where wr_type = 'review' and wr_idx = products_review.idx and del_status = 'N') as wr_comment"),
                DB::raw("(select count(idx) from beat_data where service_name = 'review' and service_idx = products_review.idx and mem_id = {$params['mem_id']} and is_beat = 1) as like_status"),
                'products_review.wr_content',
                'products_review.review_source',
                'products_review.file_url',
                'products_review.created_at',
                DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',products_review.file_url,products_review.review_source) AS reviewfullUrl"),
                'member_data.mem_nickname',
                DB::raw('now() as now_date'),
                DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',member_data.profile_photo_url,member_data.profile_photo_hash_name) AS fullUrl"),
            )
            ->where('products_review.idx',$params['idx'])
            ->where('products_review.wr_open','open')
            ->get();
            
        return $result;

    }

    public function setProfilePhotoList($params){

        $result = $this->statDB->select("
            SELECT
                b.mem_nickname as commentNickName
            ,CONCAT_WS('', '/storage', b.profile_photo_url, b.profile_photo_hash_name) AS profile_photo_file_urlgi
            ,CONCAT('".env('AWS_CLOUD_FRONT_URL')."',b.profile_photo_url,b.profile_photo_hash_name) AS urlLink
            FROM
            comment a LEFT JOIN member_data b ON a.mem_id=b.mem_id
            where a.wr_type = 'review' and a.wr_idx = ".$params->idx." and a.del_status = 'N'
            GROUP BY b.mem_nickname ,b.profile_photo_url,b.profile_photo_hash_name
            ORDER BY a.idx asc Limit 5
        ");
         return $result;
    }

    public function getReviewFile($params) {

        $result = $this->statDB->table('products_review_file')
            ->select(
                'products_review_file.idx',
                'products_review_file.file_no',
                'products_review_file.content as wr_content',
                'products_review_file.hash_name as review_source',
                'products_review_file.file_name',
                'products_review_file.file_url',
                DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',products_review_file.file_url,products_review_file.hash_name) AS reviewfullUrl"),
            )
            ->where('products_review_file.review_idx',$params['idx'])
            ->get();
            
        return $result;
    }

    //리뷰 삭제
    public function reviewDelete($params) {

        // $products_review = DB::table('products_review')->where('idx', $params['idx'])->first();

        // if ($products_review->review_file != ""){
        //     $dir = storage_path('app/public');
        //     $path = "$dir"."$products_review->file_url"."$products_review->review_source";
        //     if(!File::exists($path)) { return -1; }
        //     File::delete($path);
        // }

        // $result = $this->statDB->table('products_review')->where('idx', $params['idx'])->delete();

        $result = $this->statDB->table('products_review')
            ->where('idx',$params['idx'])
            ->update([
                'del_status' => 'Y'
                , 'updated_at' => DB::raw('now()')
            ]);

        return $result;
    }

    public function reviewFileDelete($params) {
        
        // $review_file = DB::table('products_review_file')->where('review_idx', $params['idx'])->get();

        // foreach ($review_file as $file){
        //     $dir = storage_path('app/public');
        //     $path = "$dir"."$file->file_url"."$file->hash_name";
        //     if(!File::exists($path)) { return -1; }
        //     File::delete($path);
        // }

        $result = $this->statDB->table('products_review_file')->where('review_idx', $params['idx'])->delete();

        return $result;
    }

    //리뷰데이터 업로드
    public function setReviewUpdate($params,$files)
    {

        if($files != ""){
            $cfilename = $files->getClientOriginalName();
            $cfilesource = $files->hashName();
            $folderName = '/review/'.date("Y/m/d").'/';
            $path = Storage::disk('s3')->put($folderName. $cfilesource, file_get_contents($files));
            $path = Storage::disk('s3')->url($path);
            //$files->storeAs($folderName, $files->hashName(), 'public');
            $params['review_file'] = $cfilename;
            $params['review_source'] = $cfilesource;
        }

        $result = $this->statDB->table('products_review')
            ->insertGetId([
                'mem_id' => $params['mem_id']
                , 'wr_title' => $params['wr_title']
                , 'wr_content' => $params['review_content'][0]
                , 'wr_open' => 'open'
                , 'review_source' => $params['review_source']
                , 'review_file' => $params['review_file']
                , 'grade' => $params['grade']
                , 'file_url' => $folderName
                , 'created_at' => DB::raw('now()')
            ]);

        return $result;
    }

    //리뷰파일 업로드
    public function setReviewFileUpdate($params,$files)
    {

        $sqlData['file_cnt'] = count($files);
        $sqlData['idx'] = $params['idx'];

        $folderName = '/review/'.date("Y/m/d").'/';
        if($files != "" && $files !=null){
            $i=1;
            foreach($files as $fa){

                $sqlData['file_name'] = $fa->getClientOriginalName();
                $sqlData['hash_name'] = $fa->hashName();
                $sqlData['file_url'] =  $folderName;
                $path = Storage::disk('s3')->put($folderName. $sqlData['hash_name'], file_get_contents($fa));
                $path = Storage::disk('s3')->url($path);
                //$fa->storeAs($folderName, $fa->hashName(), 'public');

                $result = $this->statDB->table('products_review_file')
                    ->insert([
                        'review_idx' => $sqlData['idx']
                        , 'file_name' => $sqlData['file_name']
                        , 'hash_name' => $sqlData['hash_name']
                        , 'file_url' => $sqlData['file_url']
                        , 'content' => $params['review_content'][$i]
                        , 'file_no' => $i
                    ]);
                $i++;
            }
        }

        return $result;

    }

    //리뷰데이터 수정
    public function reviewUpdate($params,$files)
    {

        $products_review = DB::table('products_review')->where('idx', $params['idx'])->first();

        if ($products_review->review_file != "" && $files != ""){
            // $dir = storage_path('app/public');
            // $path = "$dir"."$products_review->file_url"."$products_review->review_source";
            // if(!File::exists($path)) { return 1; }
            // File::delete($path);

            $cfilename = $files->getClientOriginalName();
            $cfilesource = $files->hashName();
            $folderName = '/review/'.date("Y/m/d").'/';
            $path = Storage::disk('s3')->put($folderName. $cfilesource, file_get_contents($files));
            $path = Storage::disk('s3')->url($path);
            //$files->storeAs($folderName, $files->hashName(), 'public');
            $params['review_file'] = $cfilename;
            $params['review_source'] = $cfilesource;
            $params['file_url'] = $folderName;
        }else{
            $params['review_file'] = $products_review->review_file;
            $params['review_source'] = $products_review->review_source;
            $params['file_url'] = $products_review->file_url;
        }

        $result = $this->statDB->table('products_review')
            ->where('idx',$params['idx'])
            ->update([
                'wr_content' => $params['review_content'][0]
                , 'review_source' => $params['review_source']
                , 'review_file' => $params['review_file']
                , 'file_url' => $params['file_url']
                , 'grade' => $params['grade']
                , 'updated_at' => DB::raw('now()')
            ]);

        return $result;
    }

    //리뷰데이터 수정
    public function reviewFileUpdate($params,$files)
    {

        // $review_file = DB::table('products_review_file')->whereIn('idx', $params['file_idx'])->get();

        // if(!$review_file->isEmpty()){
        //     foreach ($review_file as $file){
        //         $dir = storage_path('app/public');
        //         $path = "$dir"."$file->file_url"."$file->hash_name";
        //         if(!File::exists($path)) { return -1; }
        //         File::delete($path);
        //     }
        // }

        $result = DB::table('products_review_file')->whereIn('idx', $params['file_idx'])->delete();

        $file_content = DB::table('products_review_file')->where('review_idx', $params['idx'])->whereNotIn('idx', $params['file_idx'])->get();
        $i = 1;

        foreach($file_content as $content){
            DB::table('products_review_file')->where('idx', $content->idx)
            ->update([
                'content' => $params['review_content'][$i]
                , 'file_no' => $i
            ]);
            $i++;
        }

        $sqlData['idx'] = $params['idx'];

        $folderName = '/review/'.date("Y/m/d").'/';
        if($files != "" && $files !=null){
            foreach($files as $fa){

                $sqlData['file_name'] = $fa->getClientOriginalName();
                $sqlData['hash_name'] = $fa->hashName();
                $sqlData['file_url'] =  $folderName;
                $path = Storage::disk('s3')->put($folderName. $sqlData['hash_name'], file_get_contents($fa));
                $path = Storage::disk('s3')->url($path);
                //$fa->storeAs($folderName, $fa->hashName(), 'public');

                $result = $this->statDB->table('products_review_file')
                    ->insert([
                        'review_idx' => $sqlData['idx']
                        , 'file_name' => $sqlData['file_name']
                        , 'hash_name' => $sqlData['hash_name']
                        , 'file_url' => $sqlData['file_url']
                        , 'review_content' => $params['review_content'][$i]
                        , 'file_no' => $i
                        , 'review_file_type' => 'content'
                    ]);
                $i++;
            }
        }

        return $result;
    }
}
