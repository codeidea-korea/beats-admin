<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiHomeController;
use App\Http\Controllers\Api\ApiMemberController;
use App\Http\Controllers\Api\ApiSmsController;
use App\Http\Controllers\Api\ApiSoundSourceController;
use App\Http\Controllers\Api\ApiFeedController;
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

    Route::get('noticeList', [ApiHomeController::class, 'noticeList']);

    Route::get('noticeView', [ApiHomeController::class, 'getNoticeView']);

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
    });

    Route::group(['prefix' => 'feed'], function() {
        Route::get('feedList', [ApiFeedController::class, 'getFeedList']);
        Route::post('feedFileUpdate', [ApiFeedController::class, 'feedFileUpdate']);
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

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::fallback(function () {
    return "유효한 값이 아닙니다.";
});
