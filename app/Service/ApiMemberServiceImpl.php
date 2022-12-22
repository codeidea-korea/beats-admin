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
                'member_data.class',
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

    public function getMemberDataNaver($params){

        $explode_naver_id = explode( '@' , $params['emailId']);

        $result = $this->statDB->table('members')
            ->leftJoin('member_data', 'members.idx', '=', 'member_data.mem_id')
            ->select(
                'members.idx as idx',
                'member_data.name as name',
                'member_data.phone_number as phoneNumber',
                'member_data.email as email',
                'member_data.mem_nickname as nickName',
                'member_data.mem_status as memStatus',
                'member_data.class',
            )
            ->where('naver_key',$explode_naver_id[0])
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

    public function getLoginNaver($params){

        $explode_naver_id = explode( '@' , $params['emailId']);

        $result = $this->statDB->table('members')
            ->select(
                'idx as idx',
                'email_id as emailId',
                'password as password',
            )
            ->where('isuse',"Y")
            ->where('naver_key',$explode_naver_id[0])
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
                    ,'last_login_ip' => $params['last_login_ip']
                    ,'last_login_at' => DB::raw('DATE_ADD(NOW(), INTERVAL 1 HOUR)')
                ]
            );
        return $result;
    }

    public function putLoginNaver($params){

        $explode_naver_id = explode( '@' , $params['emailId']);

        $result = $this->statDB->table('members')
            ->where('isuse',"Y")
            ->where('naver_key',$explode_naver_id[0])
            ->update(
                [
                    'login_token' => $params['_token']
                    ,'last_login_ip' => $params['last_login_ip']
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
                DB::raw("date_format(members.created_at, '%Y년 %m월 %d일' ) as createdAt"),
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

    public function joinEmailCheck($params){

        $result = $this->statDB->table('members')
            ->leftJoin('member_data','members.idx','member_data.mem_id')
            ->where('members.email_id',$params['emailId'])
            //->where('member_data.channel',$params['sns'])
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
                    'last_login_ip' => $params['last_login_ip'],
                    'login_cnt' => DB::raw('login_cnt + 1'),
                ]
            );
        return $result;
    }

    public function loginCheckNaver($params){

        $explode_naver_id = explode( '@' , $params['emailId']);

        $result = $this->statDB->table('members')
            ->where('isuse',"Y")
            ->where('login_token',$params['_token'])
            ->where('last_login_at', ">=", DB::raw('NOW()'))
            ->where('naver_key',$explode_naver_id[0])
            ->update(
                [
                    'last_login_at' => DB::raw('DATE_ADD(NOW(), INTERVAL 1 HOUR)'),
                    'last_login_ip' => $params['last_login_ip'],
                    'login_cnt' => DB::raw('login_cnt + 1'),
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
                'class' => 3, 'gubun' => $params['gubun'], 'marketing_consent' => $params['marketing_consent'], 'mem_moddate' => DB::raw('now()')
            ]);

        return $result;
    }

    public function integratedTransformNaver($params) {

        $explode_naver_id = explode( '@' , $params['emailId']);

        $members_id = $this->statDB->table('members')
            ->where('naver_key',$explode_naver_id[0])
            ->first();

        $result = $this->statDB->table('member_data')
            ->where('mem_id',$members_id->idx)
            ->update([
                'class' => 3, 'gubun' => $params['gubun'], 'marketing_consent' => $params['marketing_consent'], 'mem_moddate' => DB::raw('now()')
            ]);

        return $result;
    }

    public function memberStatusTransform($params){
        $result = $this->statDB->table('members')
            ->where('email_id',$params['existingEmailId'])
            ->update([
                'isuse' => 'N', 'updated_at' => DB::raw('now()')
            ]);

        return $result;
    }

    public function apiJoin($params) {

        $members_id = $this->statDB->table('members')
            ->insertGetId([
                'email_id' => $params['emailId'], 'apple_key' => $params['apple_key'], 'naver_key' => $params['naver_key'],
                'kakao_key' => $params['kakao_key'], 'google_key' => $params['google_key'], 'facebook_key' => $params['facebook_key'],
                'twitter_key' => $params['twitter_key'], 'soundcloud_key' => $params['soundcloud_key'], 'isuse' => 'Y',
                'password' => Hash::make($params['password']), 'sign_site' => $params['sign_site'], 'created_at' => DB::raw('now()'),
                'created_ip' => $params['created_ip'],
            ]);

        $result = $this->statDB->table('member_data')
            ->insert([
                'name' => $params['name'], 'phone_number' => $params['phone_number'], 'email' => $params['email'], 'gubun' => 2,
                'nationality' => $params['nationality'], 'mem_nickname' => $params['mem_nickname'], 'marketing_consent' => $params['marketing_consent'],
                'class' => 3,'mem_sanctions' => 0,'mem_status' => 1,'mem_level' => 1,'mem_id' => $members_id, 'mem_regdate' => DB::raw('now()'),
                'u_id' => $params['u_id'],
                'channel' => $params['channel']
            ]);

        return $members_id;

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


    public function getUidCheck($tempData){
        $result = $this->statDB->table('member_data')
            ->select(DB::raw("COUNT(idx) AS cnt"))
            ->where('u_id',$tempData['u_id'])
            ->first();
        return $result;
    }

    public function getRandStr(){

        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function profileUpdate($params){
        $result = $this->statDB->table('member_data')
            ->where('mem_id',$params['mem_id'])
            ->update(
                [
                    'profile_photo_name' => $params['file_name'],
                    'profile_photo_hash_name' => $params['hash_name'],
                    'profile_photo_url' => $params['photo_url'],
                    'mem_moddate' => DB::raw('now()'),
                ]
            );

        return $result;
    }

    public function nickNameUpdate($params){
        $result = $this->statDB->table('member_data')
            ->where('mem_id',$params['mem_id'])
            ->update(
                [
                    'mem_nickname' => $params['mem_nickname'],
                    'label' => $params['label'],
                    'mem_moddate' => DB::raw('now()'),
                ]
            );

        return $result;
    }

    public function Profile($params){

        $result = $this->statDB->table('member_data')
            ->select(
                'mem_id',
                'gubun',
                'mem_nickname as nickName',
                'profile_photo_url as imgUrl',
                'profile_photo_hash_name as imgFileName',
                DB::raw("CONCAT('".env('AWS_CLOUD_FRONT_URL')."',profile_photo_url,profile_photo_hash_name) AS fullUrl"),
                'label',
                'mento_status as mentoStatus',
                DB::raw("(DATE_FORMAT(mem_moddate, '%Y. %m. %d %H:%i')) as mentoDate"),
                DB::raw("(DATE_FORMAT(memto_approvaldate, '%Y. %m. %d %H:%i')) as mentoApprovalDate"),
                DB::raw("(select count(idx) from member_album where mem_id = member_data.mem_id) as album_cnt"),
                DB::raw("(select count(idx) from member_award_history where mem_id = member_data.mem_id) as award_cnt"),
                DB::raw("(select count(idx) from member_career where mem_id = member_data.mem_id) as career_cnt"),
            )
            ->where('mem_id',$params['mem_id'])
            ->first();


        return $result;
    }

    public function getMyData($params)
    {
        $result = $this->statDB->table('member_data')
            ->leftJoin('international_code', 'member_data.nationality', '=', 'international_code.international_code2')
            ->leftJoin('adm_field as adm_field1', 'member_data.field1', '=', 'adm_field1.code')
            ->leftJoin('adm_field as adm_field2', 'member_data.field2', '=', 'adm_field2.code')
            ->leftJoin('adm_field as adm_field3', 'member_data.field3', '=', 'adm_field3.code')
            ->select(
                'member_data.email',
                'member_data.name',
                'member_data.gubun',
                'member_data.mem_nickname as memNickName',
                'member_data.nationality',
                'member_data.phone_number as phoneNumber',
                'member_data.marketing_consent as marketingConsent',
                'international_code.name_kr',
                'international_code.international_number',
                'international_code.country_img',
                'member_data.mento_status as mentoStatus',
                'member_data.field1',
                'member_data.field2',
                'member_data.field3',
                'adm_field1.field_name as field_name1',
                'adm_field2.field_name as field_name2',
                'adm_field3.field_name as field_name3',
            )
            ->where('mem_id',$params['mem_id'])
            ->first();

        return $result;
    }

    public function getMyMentoFile($params)
    {
        $result = $this->statDB->table('mento_file')
            ->select(
                'mento_file.idx',
                'mento_file.hash_name',
                'mento_file.file_name',
                'mento_file.file_url',
            )
            ->where('mem_id',$params['mem_id'])
            ->get();

        return $result;
    }

    public function setMyData($params)
    {
        $result = $this->statDB->table('member_data')
            ->where('mem_id',$params['mem_id'])
            ->update(
                [
                    'email'                                  => $params['email'],
                    //'name' => $params['name'],
                    'mem_nickname' => $params['memNickName'],
                    'nationality' => $params['nationality'],
                    'phone_number' => $params['phoneNumber'],
                    'marketing_consent' => $params['marketingConsent'],
                    'mem_moddate' => DB::raw('now()'),
                ]
            );

        if($params['gubun'] == 4){
            $this->statDB->table('member_data')
                ->where('mem_id',$params['mem_id'])
                ->update(
                    [
                        'field1'=> $params['field1'],
                        'field2' => $params['field2'],
                        'field3' => $params['field3'],
                    ]
                );
        }

        return $result;

    }

    public function setChangePassword($params)
    {
        $result = $this->statDB->table('members')
            ->where('idx',$params['mem_id'])
            ->where('login_token',$params['_token'])
            ->update(
                [
                    'password' => Hash::make($params['password']),
                    'updated_at' => DB::raw('now()'),
                ]
            );

        return $result;
    }

    public function setChangePassword2($params)
    {
        $result = $this->statDB->table('members')
            ->where('idx',$params['mem_id'])
            ->where('login_token',$params['_token'])
            ->update(
                [
                    'password' => Hash::make($params['chPassword']),
                    'updated_at' => DB::raw('now()'),
                ]
            );

        return $result;
    }

    public function getPasswordCheck($params){
        $result = $this->statDB->table('members')
            ->select('password')
            ->where('idx',$params['mem_id'])
            ->first();
        return $result;
    }

    public function setDeleteAccount($params){
        $result = $this->statDB->table('members')
            ->where('idx',$params['mem_id'])
            ->where('login_token',$params['_token'])
            ->update(
                [
                    'isuse' => 'N',
                    'login_token' => '',
                    'updated_at' => DB::raw('now()'),
                    'del_site' => $params['site_code'],
                ]
            );

        $result2 = $this->statDB->table('member_data')
            ->where('mem_id',$params['mem_id'])
            ->update(
                [
                    'mem_status' => '-1',
                ]
            );

        return $result;
    }

    public function putFindPwToken($params){
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
                    'findpw_token' => $params['_token']
                    ,'findpw_at' => DB::raw('DATE_ADD(NOW(), INTERVAL 24 HOUR)')
                ]
            );
        return $result;
    }

    public function findPwTokenCheck($params){

        $result = $this->statDB->table('members')
            ->where('isuse',"Y")
            ->where('findpw_token',$params['_token'])
            ->where('idx',$params['idx'])
            ->where('findpw_at', ">=", DB::raw('NOW()'))
            ->first();

        return $result;
    }

    //public function insertAdisonPostbackLog($params)
    //{
    //    return $this->statDB
    //        ->table('adison_postback_log')
    //        ->insert([
    //            'advertiser_token' => $params['advertiser_token'] ?? '',
    //            'click_key' => $params['click_key'] ?? '',
    //            'u_id' => $params['u_id'] ?? '',
    //            'response_message' => $params['response_message'] ?? '',
    //        ]);
    //}


}
