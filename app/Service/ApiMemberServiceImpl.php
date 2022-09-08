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
                    ,'last_login_at' => DB::raw('NOW()')
                ]
            );
        return $result;
    }



}
