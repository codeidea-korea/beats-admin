<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiHomeController;
use App\Http\Controllers\Api\ApiMemberController;
use App\Http\Controllers\Api\ApiSmsController;
use App\Http\Controllers\Api\ApiSoundSourceController;
use App\Http\Controllers\Api\ApiFeedController;
use App\Http\Controllers\Api\ApiCommentController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Api\ApiMentoController;
use App\Http\Controllers\Api\ApiMemberNoticeController;
use App\Http\Controllers\Api\ApiContentController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiCoComposerController;
use App\Http\Controllers\Api\ApiPlanController;
use App\Http\Controllers\Api\ApiSubscriptionPaymentController;
use App\Http\Controllers\Api\ApiStudentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('/v1/')->group(function () {
    // HOME > 언어
    Route::get('lang', [ApiHomeController::class, 'langList']);
    // HOME > 메뉴
    Route::get('menuList', [ApiHomeController::class, 'menuList']);
    // HOME > 메뉴
    Route::get('bannerList', [ApiHomeController::class, 'bannerList']);
    // 공지사항 리스트
    Route::get('noticeList', [ApiHomeController::class, 'noticeList']);
    // 공지사항 상세
    Route::get('noticeView', [ApiHomeController::class, 'getNoticeView']);
    // 이벤트 리스트
    Route::get('eventList', [ApiHomeController::class, 'eventList']);
    // 이벤트 상세
    Route::get('eventView', [ApiHomeController::class, 'getEventView']);
    // 비트 추가
    Route::post('beatAdd', [ApiHomeController::class, 'beatAdd']);
    // 비트 삭제
    Route::delete('beatDelete', [ApiHomeController::class, 'beatDelete']);
    // 메인 팝업
    Route::get('getPopup', [ApiHomeController::class, 'getPopup']);
    // 약관 적용날짜 리스트
    Route::get('getTermsApplyData', [ApiHomeController::class, 'getTermsApplyData']);
    // 약관 내용
    Route::get('getTermsContent', [ApiHomeController::class, 'getTermsContent']);
    // 트랜드 리스트
    Route::get('trendList', [ApiHomeController::class, 'trendList']);
    // 트랜드 상세
    Route::get('trendView', [ApiHomeController::class, 'getTrendView']);
    // 트랜드 트랜드 조회수 업
    Route::put('TrendHitAdd', [ApiHomeController::class, 'setTrendHitAdd']);
    // 음원 삭제 알림
    Route::get('SoundDelNotice', [ApiMemberNoticeController::class, 'SoundDelNotice']);

    Route::group(['prefix' => 'member'], function() {
        Route::put('login', [ApiMemberController::class, 'apiLogin']);
        Route::put('loginCheck', [ApiMemberController::class, 'loginCheck']);
        Route::get('joinCheck', [ApiMemberController::class, 'joinCheck']);
        Route::get('joinEmailCheck', [ApiMemberController::class, 'joinEmailCheck']);
        Route::get('nickNameCheck', [ApiMemberController::class, 'nickNameCheck']);
        Route::get('memberBriefData', [ApiMemberController::class, 'memberBriefData']);
        Route::post('join', [ApiMemberController::class, 'apiJoin']);
        Route::get('nationality', [ApiMemberController::class, 'getNationality']);
        Route::post('chMemberPrp', [ApiMemberController::class, 'chMemberPrp']);
        Route::put('chMemberNickName', [ApiMemberController::class, 'chMemberNickName']);
        Route::get('getProfile', [ApiMemberController::class, 'getProfile']);
        Route::get('getMyData', [ApiMemberController::class, 'getMyData']);
        Route::post('setMyData', [ApiMemberController::class, 'setMyData']);
        Route::put('chPassword', [ApiMemberController::class, 'chPassword']);
        Route::put('chPassword2', [ApiMemberController::class, 'chPassword2']);
        Route::put('deleteAccount', [ApiMemberController::class, 'deleteAccount']);
    });

    Route::group(['prefix' => 'sms'], function() {
        Route::get('send_one_message', [ApiSmsController::class, 'send_one_message']);
    });

    //멘토 뮤지션 관리
    Route::group(['prefix' => 'mento'], function()
    {
        // 분야 List
        Route::get('fieldList', [ApiMentoController::class, 'getFieldList']);
        // 멘토 뮤지션 전환
        Route::post('chMento', [ApiMentoController::class, 'chMento']);
        // 멘토 뮤지션 소개
        Route::get('getIntroduction', [ApiMentoController::class, 'getIntroduction']);
        // 멘토 뮤지션 소개 수정
        Route::put('introduction', [ApiMentoController::class, 'setIntroduction']);
        // 멘토 뮤지션 엘범 List
        Route::get('getAlbunm', [ApiMentoController::class, 'getAlbumm']);
        // 멘토 뮤지션 엘범 추가
        Route::post('setAlbunm', [ApiMentoController::class, 'setAlbumm']);
        // 멘토 뮤지션 엘범 삭제
        Route::delete('delAlbunm', [ApiMentoController::class, 'delAlbumm']);
        // 멘토 뮤지션 엘범 수정
        Route::post('upAlbunm', [ApiMentoController::class, 'upAlbumm']);
        // 멘토 뮤지션 모든 엘범 수정
        Route::post('upAllAlbunm', [ApiMentoController::class, 'upAllAlbunm']);
        // 멘토 추천 태그
        Route::get('tag', [ApiMentoController::class, 'getTag']);

        // 멘토 뮤지션 수상이력 List
        Route::get('getAward', [ApiMentoController::class, 'getAward']);
        // 멘토 뮤지션 수상이력 추가
        Route::post('setAward', [ApiMentoController::class, 'setAward']);
        // 멘토 뮤지션 수상이력 삭제
        Route::delete('delAward', [ApiMentoController::class, 'delAward']);
        // 멘토 뮤지션 수상이력 수정
        Route::put('upAward', [ApiMentoController::class, 'upAward']);
        // 멘토 뮤지션 모든 수상이력 수정
        Route::post('upAllAward', [ApiMentoController::class, 'upAllAward']);

        // 멘토 뮤지션 경력사항 List
        Route::get('getCareer', [ApiMentoController::class, 'getCareer']);
        // 멘토 뮤지션 경력사항 추가
        Route::post('setCareer', [ApiMentoController::class, 'setCareer']);
        // 멘토 뮤지션 경력사항 삭제
        Route::delete('delCareer', [ApiMentoController::class, 'delCareer']);
        // 멘토 뮤지션 경력사항 수정
        Route::put('upCareer', [ApiMentoController::class, 'upCareer']);
        // 멘토 뮤지션 모든 경력사항 수정
        Route::post('upAllCareer', [ApiMentoController::class, 'upAllCareer']);

    });

    Route::group(['prefix' => 'soundSource'], function() {
        Route::post('soundFileAdd', [ApiSoundSourceController::class, 'soundFileAdd']);
        Route::post('soundFileUpdate', [ApiSoundSourceController::class, 'soundFileUpdate']);
        Route::post('soundDataUpdate', [ApiSoundSourceController::class, 'soundDataUpdate']);
        Route::get('soundSourceList', [ApiSoundSourceController::class, 'soundSourceList']);
        Route::get('soundSourceData', [ApiSoundSourceController::class, 'soundSourceData']);
        Route::put('soundSourceDel', [ApiSoundSourceController::class, 'soundSourceDel']);
        Route::put('soundFileDel', [ApiSoundSourceController::class, 'soundFileDel']);
        Route::put('soundSourceDelCancel', [ApiSoundSourceController::class, 'soundSourceDelCancel']);
        Route::put('soundFileDelCancel', [ApiSoundSourceController::class, 'soundFileDelCancel']);
        Route::put('soundSourceDelAll', [ApiSoundSourceController::class, 'soundSourceDelAll']);
        Route::put('soundFileDelAll', [ApiSoundSourceController::class, 'soundFileDelAll']);
        Route::get('contract', [ApiSoundSourceController::class, 'contract']);

        // 음원 다음버전의 파일 업로드
        Route::post('soundFileUpLoad', [ApiSoundSourceController::class, 'soundFileUpLoad']);

        // 대표음원 지정
        Route::put('representativeMusic', [ApiSoundSourceController::class, 'representativeMusic']);

        // 테그 상세 검색용 list
        Route::get('searchTag', [ApiSoundSourceController::class, 'searchTag']);

    });

    Route::group(['prefix' => 'coComposer'], function() {
        //공동작곡가 초대
        Route::post('invite', [MailController::class,'coComposerInvite']);
        //공동작곡가 재발송setCoComposer
        Route::post('inviteRe', [MailController::class,'coComposerInviteRe']);
        //공동작고가 초대리스트
        Route::get('inviteList', [ApiCoComposerController::class,'getInviteList']);
        //공동작고가 삭제
        Route::delete('inviteDel', [ApiCoComposerController::class,'inviteDel']);

        Route::get('checkEmail', [ApiCoComposerController::class,'checkEmail']);

        Route::post('setCoComposer', [ApiCoComposerController::class,'setCoComposer']);
        //권리비율 등록
        Route::post('setCopyRight', [ApiCoComposerController::class,'setCopyRight']);
        //공동작곡가 리스트
        Route::get('getCoComposer', [ApiCoComposerController::class,'getCoComposer']);
        //권리비율 승인
        Route::post('copyRightOk', [ApiCoComposerController::class,'copyRightOk']);
        //공동작곡가 해지 신청
        Route::post('cancellation',[ApiCoComposerController::class,'cancellation']);

        Route::post('cancelDecision',[ApiCoComposerController::class,'cancelDecision']);

    });
    // 요금제 학생인증
    Route::group(['prefix' => 'student'], function() {
        //학생 인증 신청
        Route::post('chStudent', [ApiStudentController::class,'chStudent']);
    });

    // 정기 구독
    Route::group(['prefix' => 'subscriptionPayment'], function() {
        //구독 등록
        Route::get('sPayment', [ApiSubscriptionPaymentController::class,'sPayment']);
    });

    Route::group(['prefix' => 'feed'], function() {
        Route::get('feedList', [ApiFeedController::class, 'getFeedList']);
        Route::get('myFeedList', [ApiFeedController::class, 'getMyFeedList']);
        Route::get('feedView', [ApiFeedController::class, 'getFeedView']);
        Route::post('feedFileUpdate', [ApiFeedController::class, 'feedFileUpdate']);
        Route::post('feedUpdate', [ApiFeedController::class, 'feedUpdate']);
        Route::delete('feedDelete', [ApiFeedController::class, 'feedDelete']);
    });

    Route::group(['prefix' => 'content'], function() {
        Route::get('reviewList', [ApiContentController::class, 'getReviewList']);
        Route::get('myReviewList', [ApiContentController::class, 'getMyReviewList']);
        Route::get('reviewView', [ApiContentController::class, 'getReviewView']);
        Route::post('reviewFileUpdate', [ApiContentController::class, 'reviewFileUpdate']);
        Route::post('reviewUpdate', [ApiContentController::class, 'reviewUpdate']);
        Route::delete('reviewDelete', [ApiContentController::class, 'reviewDelete']);
    });

    Route::group(['prefix' => 'comment'], function() {
        Route::get('getCommentList', [ApiCommentController::class, 'getCommentList']);
        Route::get('getCommentDataList', [ApiCommentController::class, 'getCommentDataList']);
        Route::get('getCommentChildList', [ApiCommentController::class, 'getCommentChildList']);
        Route::post('commentAdd', [ApiCommentController::class, 'commentAdd']);
        Route::post('commentSoundSourceAdd', [ApiCommentController::class, 'commentSoundSourceAdd']);
        Route::put('commentUpdate', [ApiCommentController::class, 'commentUpdate']);
        Route::put('commentDelete', [ApiCommentController::class, 'commentDelete']);
    });

    Route::group(['prefix' => 'alarm'], function() {
        Route::get('myAlarmList', [ApiMemberNoticeController::class, 'setMyAlarmList']);
        Route::put('checkMyAlarm', [ApiMemberNoticeController::class, 'setCheckMyAlarm']);
    });

    //제품 관리
    Route::group(['prefix' => 'pdt'], function()
    {
        // 상품상세
        Route::get('productData', [ApiProductController::class, 'getProductData']);
    });

    //요금제 리스트
    Route::get('planList', [ApiPlanController::class, 'getPlanList']);


    Route::get('getTerms', [ApiMemberController::class, 'getTerms']);

    // email send sample  : 이후 해당 파일 및 소스코드 지울것
    Route::get('mail', [MailController::class,'send']);

    // 비밀번호 변경을 위한 이메일 전송
    Route::put('chPasswordEmail', [MailController::class,'setNewPassword']);

    // 비밀번호 변경을 위한 이메일 토큰 유효성 검사
    Route::get('findPwTokenCheck', [ApiMemberController::class,'findPwTokenCheck']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
