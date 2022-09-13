<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;

class ApiMemberServiceImpl extends DBConnection  implements ApiMemberServiceInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMemberData($params){

        $result = $this->statDB->table('members')
            ->leftJoin('member_data', 'members.idx', '=', 'member_data.mem_id')
            ->select(
                'members.idx as idx',
                'member_data.name as name',
                'member_data.phone_number as phoneNumber',
                'member_data.email as email',
                'member_data.mem_nickname as nickName',
            )
            ->where('member_data.mem_status','1')
            ->when($params['sns']=="email", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('members.email_id',$params['emailId']);
                });
            })
            ->when($params['sns']=="apple", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('members.apple_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="naver", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('members.naver_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="kakao", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('members.kakao_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="google", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('members.google_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="facebook", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('members.facebook_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="twitter", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('members.twitter_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="soundcloud", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('members.soundcloud_key',$params['snsKey']);
                });
            })
            ->first();
        return $result;
    }

    public function getLogin($params){
        $result = $this->statDB->table('members')
            ->select(
                'idx as idx',
                'email_id as emailId',
                'password as password',
            )
            ->where('isuse',"Y")
            ->when($params['sns']=="email", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('email_id',$params['emailId']);
                });
            })
            ->when($params['sns']=="apple", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('apple_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="naver", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('naver_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="kakao", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('kakao_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="google", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('google_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="facebook", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('facebook_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="twitter", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('twitter_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="soundcloud", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('soundcloud_key',$params['snsKey']);
                });
            })
            ->first();
        return $result;
    }

    public function putLogin($params){
        $result = $this->statDB->table('members')
            ->where('isuse',"Y")
            ->when($params['sns']=="email", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('email_id',$params['emailId']);
                });
            })
            ->when($params['sns']=="apple", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('apple_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="naver", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('naver_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="kakao", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('kakao_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="google", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('google_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="facebook", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('facebook_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="twitter", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('twitter_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="soundcloud", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('soundcloud_key',$params['snsKey']);
                });
            })
            ->update(
                [
                    'login_token' => $params['_token']
                    ,'last_login_at' => DB::raw('DATE_ADD(NOW(), INTERVAL 1 HOUR)')
                ]
            );
        return $result;
    }

    public function loginCheck($params){

        $result = $this->statDB->table('members')
            ->where('isuse',"Y")
            ->where('login_token',$params['_token'])
            ->where('last_login_at', "<", "NOW()")
            ->when($params['sns']=="email", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('email_id',$params['emailId']);
                });
            })
            ->when($params['sns']=="apple", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('apple_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="naver", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('naver_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="kakao", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('kakao_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="google", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('google_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="facebook", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('facebook_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="twitter", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('twitter_key',$params['snsKey']);
                });
            })
            ->when($params['sns']=="soundcloud", function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->where('soundcloud_key',$params['snsKey']);
                });
            })
            ->update(
                [
                    'last_login_at' => DB::raw('DATE_ADD(NOW(), INTERVAL 1 HOUR)'),
                ]
            );
        return $result;
    }

    public function getTermsCode($params){

        $result = $this->statDB->table('adm_code')
            ->select(
                'adm_code.codename',
            )
            ->where('adm_code.depth',3)
            ->get();

        $result = array_map(function ($value) {
            return $value->codename;
        }, $result->toArray());

        return $result;
    }

    public function getTerms($params){
        $group_terms = $this->statDB->table('adm_terms')
            ->select(
                'adm_terms.terms_type',
                DB::raw('MAX(adm_terms.version) as version'),
            )
            ->where('apply_date', '<=', DB::raw("(DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i:%s'))"))
            ->when(isset($params['termsType']), function($query) use ($params){
                return $query->where(function($query) use ($params) {
                    $query->whereIn('adm_terms.terms_type',  $params['termsType']);
                });
            })
            ->groupBy('adm_terms.terms_type');

        $result = $this->statDB->table('adm_terms')
            ->joinSub($group_terms, 'group_terms', function ($join) {
                $join->on('adm_terms.terms_type', '=', 'group_terms.terms_type')->on('adm_terms.version', '=', 'group_terms.version');
            })
            ->leftJoin('adm_code as gubun', 'adm_terms.gubun', '=', 'gubun.codename')
            ->leftJoin('adm_code as terms_type', 'adm_terms.terms_type', '=', 'terms_type.codename')
            ->select(
                'adm_terms.idx',
                'gubun.codevalue as gubun',
                'terms_type.codevalue as termsType',
                'adm_terms.content',
            )
            ->get();

        return $result;
    }


}
