<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

class ApiCommentServiceImpl extends DBConnection  implements ApiCommentServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    //피드 리스트
    public function getCommentList($params) {

        $result = $this->statDB->table('comment')
            ->leftJoin('member_data', 'comment.mem_id', '=', 'member_data.mem_id')
            ->select(
                'comment.idx'
            )
            ->where('wr_idx', $params['wr_idx'])
            ->where('wr_type', $params['wr_type'])
            ->where('cm_main', 1)
            ->orderby('cm_seq','desc')
            ->when($params['wr_type']!="soundSource", function($query) use ($params){
                $query->skip(($params['page']-1)*$params['limit']);
                $query->take($params['limit']);
            })
            ->get();

            $cm_idx = $result->pluck('idx');

        $result2 = $this->statDB->table('comment')
            ->leftJoin('member_data', 'comment.mem_id', '=', 'member_data.mem_id')
            ->select(
                'comment.idx',
            )
            ->whereIn('cm_idx', $cm_idx->all())
            ->get();

            $cm_idx2 = $result2->pluck('idx');

        $result3 = Arr::collapse([$cm_idx, $cm_idx2]);

        $resultData = $this->statDB->table('comment')
            ->leftJoin('member_data', 'comment.mem_id', '=', 'member_data.mem_id')
            ->leftJoin('music_file', 'comment.music_idx', '=', 'music_file.idx')
            ->leftJoin('member_data AS M', 'music_file.mem_id', '=', 'M.mem_id')
            ->leftJoin('record_file AS R', 'comment.idx', '=', 'R.comment_idx')
            ->leftJoin('comment AS RC', 'comment.cm_idx', '=', 'RC.idx')
            ->leftJoin('member_data AS MC', 'MC.mem_id', '=', 'RC.mem_id')
            ->select(
                'comment.idx',
                DB::raw('CASE WHEN comment.cm_idx = 0 THEN comment.idx ELSE comment.cm_idx END as sort_idx'),
                'comment.mem_id',
                'comment.cm_idx',
                'comment.dir_cm_idx',
                DB::raw('(select b.mem_nickname from comment a left join member_data b ON a.mem_id = b.mem_id where a.idx = comment.dir_cm_idx ) as dir_nickname'),
                'comment.cm_content',
                'comment.cm_depth',
                'comment.cm_open',
                'comment.cm_content',
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and is_beat = 1) as cm_bit"),
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and mem_id = {$params['mem_id']} and is_beat = 1) as like_status"),
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and not_beat != 0) as cm_not_bit"),
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and is_beat = 1 and beat_data.mem_id = comment.mem_id) as checkedLike"),
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and not_beat !=0 and beat_data.mem_id = comment.mem_id) as unCheckedLike"),

                'comment.created_at',
                'comment.del_status',
                'member_data.mem_nickname',
                'comment.record',
                'music_file.idx as musicFileHeadIdx',
                'music_file.file_name as musicFileName',
                'music_file.hash_name as musicHashName',
                'music_file.file_url as  musicFileUrl',
                'music_file.version as  musicFileVersion',
                'M.mem_nickname as  fmNickName',

                'R.file_name as recordFileName',
                'R.hash_name as recordHashName',
                'R.file_url as  recordFileUrl',
                'MC.mem_nickname AS cmIdxNickname',
                DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',member_data.profile_photo_url,member_data.profile_photo_hash_name) AS fullUrl"),

                DB::raw('now() as now_date'),
            )
            ->when($params['wr_type']=="soundSource", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('comment.del_status','N');
                });
            })
            ->whereIn('comment.idx', $result3)
            ->orderby('sort_idx','desc')
            ->orderby('comment.cm_depth','asc')
            ->orderby('comment.cm_seq','desc')
            ->get();

        return $resultData;

    }

    //피드 리스트
    public function getCommentDataList($params) {

        $result = $this->statDB->table('comment')
            ->leftJoin('member_data', 'comment.mem_id', '=', 'member_data.mem_id')
            ->leftJoin('music_file', 'comment.music_idx', '=', 'music_file.idx')
            ->leftJoin('member_data AS M', 'music_file.mem_id', '=', 'M.mem_id')
            ->leftJoin('record_file AS R', 'comment.idx', '=', 'R.comment_idx')
            ->select(
                'comment.idx',
                'comment.cm_idx',
                'comment.dir_cm_idx',
                'comment.cm_content',
                'comment.cm_depth',
                'comment.cm_open',
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and is_beat = 1) as cm_bit"),
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and not_beat != 0) as cm_not_bit"),
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and is_beat = 1 and beat_data.mem_id = comment.mem_id) as checkedLike"),
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and not_beat !=0 and beat_data.mem_id = comment.mem_id) as unCheckedLike"),
                'comment.created_at',
                'comment.del_status',
                'member_data.mem_id as mem_idx',
                'member_data.mem_nickname',
                'comment.record',
                'music_file.music_head_idx as musicHeadIdx',
                'music_file.file_name as musicFileName',
                'music_file.hash_name as musicHashName',
                'music_file.file_url as  musicFileUrl',
                'music_file.version as  musicFileVersion',
                'M.mem_nickname as  fmNickName',
                'R.file_name as recordFileName',
                'R.hash_name as recordHashName',
                'R.file_url as  recordFileUrl',

                DB::raw('now() as now_date'),
            )
            ->when($params['wr_type']=="soundSource", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('comment.del_status','N');
                });
            })
            ->where('wr_idx', $params['wr_idx'])
            ->where('wr_type', $params['wr_type'])
            ->where('cm_main', 1)
            ->orderby('cm_seq','desc')
            ->when($params['wr_type']!="soundSource", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->skip(($params['page']-1)*$params['limit']);
                    $query->take($params['limit']);
                });
            })

            ->get();

        return $result;

    }

    //피드 리스트
    public function getCommentChildList($params) {

        $result = $this->statDB->table('comment')
            ->leftJoin('member_data', 'comment.mem_id', '=', 'member_data.mem_id')
            ->leftJoin('music_file', 'comment.music_idx', '=', 'music_file.idx')
            ->leftJoin('member_data AS M', 'music_file.mem_id', '=', 'M.mem_id')
            ->leftJoin('record_file AS R', 'comment.idx', '=', 'R.comment_idx')
            ->select(
                'comment.idx',
                'comment.cm_idx',
                'comment.dir_cm_idx',
                'comment.cm_content',
                'comment.cm_depth',
                'comment.cm_open',
                'comment.cm_content',
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and is_beat = 1) as cm_bit"),
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and not_beat != 0) as cm_not_bit"),
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and is_beat = 1 and beat_data.mem_id = comment.mem_id) as checkedLike"),
                DB::raw("(select count(idx) from beat_data where service_name = 'comment' and service_idx = comment.idx and not_beat !=0 and beat_data.mem_id = comment.mem_id) as unCheckedLike"),
                'comment.created_at',
                'comment.del_status',
                'member_data.mem_nickname',
                'music_file.music_head_idx as musicHeadIdx',
                'music_file.file_name as musicFileName',
                'music_file.hash_name as musicHashName',
                'music_file.file_url as  musicFileUrl',
                'music_file.version as  musicFileVersion',
                'M.mem_nickname as  fmNickName',

                'R.file_name as recordFileName',
                'R.hash_name as recordHashName',
                'R.file_url as  recordFileUrl',

                DB::raw('now() as now_date'),
            )
            ->when($params['wr_type']=="soundSource", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('comment.del_status','N');
                });
            })
            ->where('dir_cm_idx', $params['cm_idx'])
            ->orderBy('comment.created_at','desc')
            ->get();

        return $result;

    }

    public function getCommentTotal($params) {

        $result = $this->statDB->table('comment')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->where('wr_idx', $params['wr_idx'])
            ->where('wr_type', $params['wr_type'])
            ->where('cm_main', 1)
            ->first();
        return $result;

    }

    //댓글 업로드
    public function commentAdd($params)
    {
        $comment_seq = DB::table('comment')
            ->select('cm_seq')
            ->where('cm_idx', $params['cm_idx'])
            ->where('dir_cm_idx', $params['dir_cm_idx'])
            ->where('cm_depth', $params['cm_depth'])
            ->where('wr_type', $params['wr_type'])
            ->orderBy('cm_seq','desc')
            ->first();

        if(empty($comment_seq)){
            $cm_seq = 0;
        }else{
            if($comment_seq->cm_seq === null){
                $cm_seq = 0;
            }else{
                $cm_seq = $comment_seq->cm_seq + 1;
            }
        }

        $result = $this->statDB->table('comment')
            ->insertGetId([
                'mem_id' => $params['mem_id']
                , 'wr_idx' => $params['wr_idx']
                , 'cm_idx' => $params['cm_idx']
                , 'dir_cm_idx' => $params['dir_cm_idx']
                , 'cm_main' => $params['cm_main']
                , 'cm_depth' => $params['cm_depth']
                , 'cm_seq' => $cm_seq
                , 'cm_content' => $params['cm_content']
                , 'wr_type' => $params['wr_type']
                , 'music_idx' => $params['music_idx']
                , 'created_at' => DB::raw('now()')
            ]);
        $sqlData['idx']=$result;
        return $sqlData;

    }

    public function commentUpdate($params)
    {

        $result = $this->statDB->table('comment')
            ->where('idx', $params['cm_idx'])
            ->update([
                'cm_content' => $params['cm_content']
                , 'updated_at' => DB::raw('now()')
            ]);

        return $result;

    }

    public function commentDelete($params)
    {
        $result = $this->statDB->table('comment')
            ->where('idx', $params['cm_idx'])
            ->update([
                'del_status' => 'Y'
                , 'updated_at' => DB::raw('now()')
            ]);

        return $result;

    }

    //음원파일 업로드
    public function setRecordFileUpdate($params,$files)
    {

        $sqlData['file_cnt'] = count($files);
        $sqlData['idx'] = $params['idx'];

        $folderName = '/comment/record/'.date("Y/m/d").'/';
        if($files != "" && $files !=null){
            $cnt = count($files);
            $i=1;
            foreach($files as $fa){

                $sqlData['file_name'] = $fa->getClientOriginalName();
                $sqlData['hash_name'] = $fa->hashName();
                $sqlData['file_url'] =  $folderName;
                $fa->storeAs($folderName, $fa->hashName(), 'public');

                    $result = $this->statDB->table('record_file')
                        ->insert([
                            'comment_idx' => $sqlData['idx']
                            , 'file_name' => $sqlData['file_name']
                            , 'hash_name' => $sqlData['hash_name']
                            , 'file_url' => $sqlData['file_url']
                        ]);

                    $last_file['file_name'] = $sqlData['file_name'];
                    $last_file['hash_name'] = $sqlData['hash_name'];
                    $last_file['file_url'] = $sqlData['file_url'];


            }
        }

        return $last_file;

    }
}
