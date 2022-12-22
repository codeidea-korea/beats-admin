<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

interface ApiMemberServiceInterface
{
    // 회원정보
    public function getMemberData($params);
    
    //네이버 로그인 이메일 @ 앞에 확인
    public function getMemberDataNaver($params);

    // 로그인
    public function getLogin($params);

    //네이버 로그인 이메일 @ 앞에 확인
    public function getLoginNaver($params);

    // 로그인 토큰 등록
    public function putLogin($params);

    //네이버 로그인 이메일 @ 앞에 확인
    public function putLoginNaver($params);

    //회원가입 확인
    public function joinCheck($params);

    //회원가입 이메일 확인
    public function joinEmailCheck($params);

    //로그인 유지 확인
    public function loginCheck($params);
    
    //네이버 로그인 이메일 @ 앞에 확인
    public function loginCheckNaver($params);

    // 통합 회원 전환
    public function integratedTransform($params);
    
    //네이버 로그인 이메일 @ 앞에 확인
    public function integratedTransformNaver($params);

    //약관 코드 배열로 반환
    public function getTermsCode($params);

    //약관 리스트
    public function getTerms($params);

    //고유 id값 체크
    public function getUidCheck($tempUid);

    //고유 id값 난수 생성
    public function getRandStr();

    //프로필사진 수정
    public function profileUpdate($params);

    //닉네임 수정
    public function nickNameUpdate($params);

    //프로파일 데이터 조회
    public function Profile($params);

    //개인정보 수정용 데이터
    public function getMyData($params);

    //개인정보 수정용 멘토 첨부파일
    public function getMyMentoFile($params);

    //개인정보 수정
    public function setMyData($params);

    //비밀번호 변경
    public function setChangePassword($params);

    //로그인후 비밀번호 변경
    public function setChangePassword2($params);

    //비밀번호 체크
    public function getPasswordCheck($params);

    //회원 탈퇴
    public function setDeleteAccount($params);

    //비밀번호 찾기 토큰 저장
    public function putFindPwToken($params);

    //비밀번호 찾기 토큰 확인
    public function findPwTokenCheck($params);
}
