<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BoardServiceImpl extends DBConnection  implements BoardServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getBoardList($params) {


        $result = $this->statDB->table('notice_board')
            ->leftJoin('users', 'notice_board.mem_id', '=', 'users.idx')
            ->select(
                'notice_board.idx',
                'notice_board.mem_id',
                'notice_board.gubun',
                'notice_board.wr_title',
                'notice_board.wr_content',
                'notice_board.wr_hit',
                'notice_board.wr_comment',
                'notice_board.wr_bit',
                'notice_board.wr_report',
                'notice_board.wr_open',
                'notice_board.wr_file',
                'notice_board.created_at',
                'users.name',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->when(isset($params['gubun']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('gubun',  $params['gubun']);
                });
            })
            ->when(isset($params['wr_open']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('wr_open',  $params['wr_open']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('wr_title', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('notice_board.created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->orderby('created_at','desc')
           // ->groupBy('name')
            ->get();
        return $result;

    }

    public function getBoardTotal($params) {

        $result = $this->statDB->table('notice_board')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->when(isset($params['gubun']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('gubun',  $params['gubun']);
                });
            })
            ->when(isset($params['wr_open']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('wr_open',  $params['wr_open']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('wr_title', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->first();
        return $result;

    }

    public function getBoardView($params, $bidx) {

        $result = $this->statDB->table('notice_board')
            ->leftJoin('users', 'notice_board.mem_id', '=', 'users.idx')
            ->select(
                'notice_board.idx',
                'notice_board.mem_id',
                'notice_board.gubun',
                'notice_board.wr_title',
                'notice_board.wr_content',
                'notice_board.wr_hit',
                'notice_board.wr_comment',
                'notice_board.wr_bit',
                'notice_board.wr_report',
                'notice_board.wr_open',
                'notice_board.wr_file',
                'notice_board.created_at',
                'notice_board.updated_at',
                'users.name',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->where('notice_board.idx',$bidx)
           // ->groupBy('name')
           ->get();

        return $result;

    }

    public function BoardAdd($params) {

        $result = $this->statDB->table('notice_board')
            ->insertGetId([
                'wr_title' => $params['wr_title'], 'wr_content' => $params['wr_content'], 'wr_open' => $params['wr_open'],
                'gubun' => $params['gubun'], 'mem_id' => auth()->user()->idx, 'created_at' => \Carbon\Carbon::now(),
            ]);

        return $result;

    }

    public function BoardUpdate($params) {

        $result = $this->statDB->table('notice_board')
            ->where('idx',$params['idx'])
            ->update([
                'wr_title' => $params['wr_title'], 'wr_content' => $params['wr_content'], 'wr_open' => $params['wr_open'],
                'updated_at' => \Carbon\Carbon::now()
            ]);

        return $result;

    }

    public function BoardDelete($params) {

        $result = $this->statDB->table('notice_board')->where('idx', $params['idx'])->delete();

        return $result;

    }

    public function getEventList($params) {


        $result = $this->statDB->table('adm_event')
            ->leftJoin('users', 'adm_event.mem_id', '=', 'users.idx')
            ->select(
                'adm_event.idx',
                'adm_event.mem_id',
                'adm_event.title',
                'adm_event.open_status',
                'adm_event.fr_event_date',
                'adm_event.bk_event_date',
                'adm_event.created_at',
                'users.name',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->when(isset($params['open_status']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('open_status',  $params['open_status']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('title', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('adm_event.created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->orderby('created_at','desc')
           // ->groupBy('name')
            ->get();
        return $result;

    }

    public function getEventTotal($params) {

        $result = $this->statDB->table('adm_event')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->when(isset($params['open_status']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('open_status',  $params['open_status']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('title', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('adm_event.created_at',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->first();
        return $result;

    }

    public function getEventView($params, $bidx) {

        $result = $this->statDB->table('adm_event')
            ->select(
                'adm_event.idx',
                'adm_event.mem_id',
                'adm_event.title',
                'adm_event.content',
                'adm_event.open_status',
                'adm_event.event_file',
                'adm_event.event_source',
                'adm_event.fr_event_date',
                'adm_event.bk_event_date',
                'adm_event.created_at',
                'adm_event.updated_at',
                'users.name',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->where('adm_event.idx',$bidx)
           // ->groupBy('name')
           ->get();

        return $result;

    }

    public function EventAdd($params, $file) {

        if($file != ""){
            $cfilename = $file->getClientOriginalName();
            $cfilesource = $file->hashName();
            $folderName = '/event/';
            $file->storeAs($folderName, $file->hashName(), 'public');
            $params['event_file'] = $cfilename;
            $params['event_source'] = $cfilesource;
        }

        if($params['event_date'] != ''){
            $showexplode = explode(' - ',$params['event_date']);
            $params['fr_event_date'] = $showexplode[0];
            $params['bk_event_date'] = $showexplode[1];
        }

        $result = $this->statDB->table('adm_event')
            ->insertGetId([
                'title' => $params['title'], 'content' => $params['content'], 'open_status' => $params['open_status'],
                'event_file' => $params['event_file'], 'event_source' => $params['event_source'], 'fr_event_date' => $params['fr_event_date'],
                'bk_event_date' => $params['bk_event_date'],'mem_id' => auth()->user()->idx, 'created_at' => \Carbon\Carbon::now(),
            ]);

        return $result;

    }

    public function EventUpdate($params, $file) {

        $adm_event = DB::table('adm_event')->where('idx', $params['idx'])->first();

        if ($adm_event->event_file != "" && $file != ""){
            $dir = storage_path('app/public/event');
            $path = "$dir/$adm_event->event_source";
            if(!File::exists($path)) { return 1; }
            File::delete($path);
        }else{
            $params['event_file'] = $adm_event->event_file;
            $params['event_source'] = $adm_event->event_source;
        }

        if($file != ""){
            $cfilename = $file->getClientOriginalName();
            $cfilesource = $file->hashName();
            $folderName = '/event/';
            $file->storeAs($folderName, $file->hashName(), 'public');
            $params['event_file'] = $cfilename;
            $params['event_source'] = $cfilesource;
        }

        if($params['event_date'] != ''){
            $showexplode = explode(' - ',$params['event_date']);
            $params['fr_event_date'] = $showexplode[0];
            $params['bk_event_date'] = $showexplode[1];
        }

        $result = $this->statDB->table('adm_event')
            ->where('idx',$params['idx'])
            ->update([
                'title' => $params['title'], 'content' => $params['content'], 'open_status' => $params['open_status'],
                'event_file' => $params['event_file'], 'event_source' => $params['event_source'], 'fr_event_date' => $params['fr_event_date'],
                'bk_event_date' => $params['bk_event_date'],'updated_at' => \Carbon\Carbon::now(),
            ]);

        return $result;

    }

    public function EventDelete($params) {

        $result = $this->statDB->table('adm_event')->where('idx', $params['idx'])->delete();

        return $result;

    }

    public function getTermsList($params) {


        $result = $this->statDB->table('adm_terms')
            ->leftJoin('users', 'adm_terms.mem_id', '=', 'users.idx')
            ->leftJoin('adm_code as gubun', 'adm_terms.gubun', '=', 'gubun.codename')
            ->leftJoin('adm_code as terms_type', 'adm_terms.terms_type', '=', 'terms_type.codename')
            ->select(
                'adm_terms.idx',
                'adm_terms.mem_id',
                'gubun.codevalue as gubun',
                'terms_type.codevalue as terms_type',
                'adm_terms.content',
                'adm_terms.version',
                'adm_terms.isuse',
                'adm_terms.apply_date',
                'users.name',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->when(isset($params['gubun']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('gubun',  $params['gubun']);
                });
            })
            ->when(isset($params['terms_type']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('terms_type',  $params['terms_type']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('content', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('adm_terms.apply_date',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->orderby('adm_terms.created_at','desc')
           // ->groupBy('name')
            ->get();
        return $result;

    }

    public function getGubun($params) {
        
        $result = $this->statDB->table('adm_code')
            ->select(
                'adm_code.codename',
                'adm_code.codevalue',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->where('parentindex','TE000000')
            ->where('depth',2)
           // ->groupBy('name')
            ->get();

        return $result;

    }

    public function getTermsType($params) {
        
        $result = $this->statDB->table('adm_code')
            ->select(
                'adm_code.codename',
                'adm_code.codevalue',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->where('parentindex',$params['gubun'])
            ->where('depth',3)
           // ->groupBy('name')
            ->get();

        return $result;

    }

    public function getTermsTotal($params) {

        $result = $this->statDB->table('adm_terms')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->when(isset($params['gubun']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('gubun',  $params['gubun']);
                });
            })
            ->when(isset($params['terms_type']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('terms_type',  $params['terms_type']);
                });
            })
            ->when(isset($params['search_text']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('content', 'like', '%'.$params['search_text'].'%');
                });
            })
            ->when(isset($params['fr_search_at']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereBetween('adm_terms.apply_date',  [$params['fr_search_at'],$params['bk_search_at']]);
                });
            })
            ->first();
        return $result;

    }

    public function getTermsView($params, $tidx) {

        $result = $this->statDB->table('adm_terms')
            ->leftJoin('users', 'adm_terms.mem_id', '=', 'users.idx')
            ->select(
                'adm_terms.idx',
                'adm_terms.mem_id',
                'adm_terms.gubun',
                'adm_terms.terms_type',
                'adm_terms.content',
                'adm_terms.version',
                'adm_terms.isuse',
                'adm_terms.apply_date',
                'adm_terms.created_at',
                'adm_terms.updated_at',
                'users.name',
               // $this->statDB->raw('SUM(name) AS CNT')
            )
            ->where('adm_terms.idx',$tidx)
           // ->groupBy('name')
           ->get();

        return $result;

    }

    public function TermsAdd($params) {

        $result = $this->statDB->table('adm_terms')
            ->insertGetId([
                'gubun' => $params['gubun'], 'terms_type' => $params['terms_type'], 'content' => $params['content'],
                'version' => $params['version'], 'apply_date' => $params['apply_date_time'], 'mem_id' => auth()->user()->idx, 'created_at' => \Carbon\Carbon::now(),
            ]);

        return $result;

    }

    public function TermsUpdate($params) {

        $result = $this->statDB->table('adm_terms')
            ->where('idx',$params['idx'])
            ->update([
                'gubun' => $params['gubun'], 'terms_type' => $params['terms_type'], 'content' => $params['content'],
                'version' => $params['version'], 'apply_date' => $params['apply_date_time'], 'updated_at' => \Carbon\Carbon::now()
            ]);

        return $result;

    }

    public function TermsDelete($params) {

        $result = $this->statDB->table('adm_terms')->where('idx', $params['idx'])->delete();

        return $result;

    }

    public function upload($params)
    {
        if (!$params->hasFile('upload')) {
            return response()->json([
                'message' => '파일이 정상적으로 업로드되지 않았습니다'
            ], 400);
        }
        $uploadFile = $params->file('upload');

        // 파일이 한개일때 배열에 담아줌 (아래 코드를 여러개일때도 같이 쓰게)
        if (!is_array($uploadFile)) {
            $uploadFile = [$uploadFile];
        }

        $urls = [];
        foreach ($uploadFile as $file) {
            $ext = $file->getClientOriginalExtension();
            $file_name = uniqid(rand(), false).'.'.$ext;

            $dirpath = 'editor/'.date('Ym');

            Storage::put('public/'.$dirpath.'/'.$file_name, file_get_contents($file));

            $urls[] = '/storage/'.$dirpath.'/'.$file_name;
        }

        return response()->json(['fileName' => $file_name, 'uploaded'=> 1, 'url' => $urls]);
    }

}
