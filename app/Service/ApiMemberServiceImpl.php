<?php

namespace App\Service;

use Agent;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'member_data.mem_status as memStatus',
            )
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

    public function nicknameCheck($params){

        $result = $this->statDB->table('member_data')
            ->where('mem_nickname',$params['nickName'])
            ->first();

        return $result;
    }

    public function memberBriefData($params){

        $result = $this->statDB->table('members')
            ->leftJoin('member_data','members.idx','member_data.mem_id')
            ->select(
                'member_data.mem_nickname as memNickname',
                'members.created_at as createdAt',
            )
            ->where('members.email_id',$params['emailId'])
            ->first();

        return $result;
    }

    public function joinCheck($params){

        $result = $this->statDB->table('members')
            ->leftJoin('member_data','members.idx','member_data.mem_id')
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

    public function loginCheck($params){

        $result = $this->statDB->table('members')
            ->where('isuse',"Y")
            ->where('login_token',$params['_token'])
            ->where('last_login_at', ">=", DB::raw('NOW()'))
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

    public function integratedTransform($params) {

        $members_id = $this->statDB->table('members')
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

        $result = $this->statDB->table('member_data')
            ->where('mem_id',$members_id->idx)
            ->update([
                'class' => 3, 'mem_moddate' => \Carbon\Carbon::now()
            ]);

        return $result;
    }

    public function memberStatusTransform($params){
        $result = $this->statDB->table('members')
            ->where('email_id',$params['existingEmailId'])
            ->update([
                'isuse' => 'N', 'mem_moddate' => \Carbon\Carbon::now()
            ]);

        return $result;
    }

    public function apiJoin($params) {

        $members_id = $this->statDB->table('members')
            ->insertGetId([
                'email_id' => $params['emailId'], 'apple_key' => $params['apple_key'], 'naver_key' => $params['naver_key'],
                'kakao_key' => $params['kakao_key'], 'google_key' => $params['google_key'], 'facebook_key' => $params['facebook_key'],
                'twitter_key' => $params['twitter_key'], 'soundcloud_key' => $params['soundcloud_key'], 'isuse' => 'Y',
                'password' => Hash::make($params['password']), 'sign_site' => $params['sign_site'], 'created_at' => \Carbon\Carbon::now(),
            ]);
        
        $result = $this->statDB->table('member_data')
            ->insert([
                'name' => $params['name'], 'phone_number' => $params['phone_number'], 'email' => $params['email'], 'gubun' => $params['gubun'],
                'nationality' => $params['nationality'], 'mem_nickname' => $params['mem_nickname'], 'marketing_consent' => $params['marketing_consent'],
                'class' => 3,'mem_sanctions' => 0,'mem_status' => 1,'mem_level' => 1,'mem_id' => $members_id, 'mem_regdate' => \Carbon\Carbon::now(),
            ]);

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
