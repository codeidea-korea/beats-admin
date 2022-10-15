<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiHomeController;
use App\Http\Controllers\Api\ApiMemberController;
use App\Http\Controllers\Api\ApiSmsController;
use App\Http\Controllers\Api\ApiSoundSourceController;
use App\Http\Controllers\Api\ApiFeedController;
use App\Http\Controllers\Api\ApiCommentController;
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

    Route::group(['prefix' => 'member'], function() {
        Route::put('login', [ApiMemberController::class, 'apiLogin']);
        Route::put('loginCheck', [ApiMemberController::class, 'loginCheck']);
        Route::get('joinCheck', [ApiMemberController::class, 'joinCheck']);
        Route::get('nickNameCheck', [ApiMemberController::class, 'nickNameCheck']);
        Route::get('memberBriefData', [ApiMemberController::class, 'memberBriefData']);
        Route::put('join', [ApiMemberController::class, 'apiJoin']);
        Route::get('nationality', [ApiMemberController::class, 'getNationality']);
    });

    Route::group(['prefix' => 'sms'], function() {
        Route::get('send_one_message', [ApiSmsController::class, 'send_one_message']);
    });

    Route::group(['prefix' => 'soundSource'], function() {
        Route::post('soundFileUpdate', [ApiSoundSourceController::class, 'soundFileUpdate']);
        Route::post('soundDataUpdate', [ApiSoundSourceController::class, 'soundDataUpdate']);
        Route::get('soundSourceList', [ApiSoundSourceController::class, 'soundSourceList']);
        Route::get('soundSourceData', [ApiSoundSourceController::class, 'soundSourceData']);

        Route::put('soundSourceDel', [ApiSoundSourceController::class, 'soundSourceDel']);
        Route::put('soundFileDel', [ApiSoundSourceController::class, 'soundFileDel']);

        Route::put('soundSourceDelAll', [ApiSoundSourceController::class, 'soundSourceDelAll']);
        Route::put('soundFileDelAll', [ApiSoundSourceController::class, 'soundFileDelAll']);


    });

    Route::group(['prefix' => 'feed'], function() {
        Route::get('feedList', [ApiFeedController::class, 'getFeedList']);
        Route::get('feedView', [ApiFeedController::class, 'getFeedView']);
        Route::post('feedFileUpdate', [ApiFeedController::class, 'feedFileUpdate']);
        Route::post('feedUpdate', [ApiFeedController::class, 'feedUpdate']);
        Route::delete('feedDelete', [ApiFeedController::class, 'feedDelete']);
    });

    Route::group(['prefix' => 'comment'], function() {
        Route::get('getCommentList', [ApiCommentController::class, 'getCommentList']);
        Route::get('getCommentDataList', [ApiCommentController::class, 'getCommentDataList']);
        Route::get('getCommentChildList', [ApiCommentController::class, 'getCommentChildList']);
        Route::post('commentAdd', [ApiCommentController::class, 'commentAdd']);
        Route::put('commentUpdate', [ApiCommentController::class, 'commentUpdate']);
        Route::put('commentDelete', [ApiCommentController::class, 'commentDelete']);
    });

    // get
    Route::get('testList', [ApiMemberController::class, 'testList']);

    // post
    Route::post('testList', [ApiMemberController::class, 'testList']);

    // put  구형브라우저 X
    Route::put('testList', [ApiMemberController::class, 'testList']);

    // delete 구형브라우저 X
    Route::delete('testList', [ApiMemberController::class, 'testList']);

    Route::get('getTerms', [ApiMemberController::class, 'getTerms']);

    Route::get('test123', [ApiSoundSourceController::class, 'test123']);


});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



//Route::fallback(function () {
//    return "유효한 값이 아닙니다.";
//});
