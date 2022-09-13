<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiHomeController;
use App\Http\Controllers\Api\ApiMemberController;
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

    Route::group(['prefix' => 'member'], function() {
        Route::put('login', [ApiMemberController::class, 'apiLogin']);
        Route::put('loginCheck', [ApiMemberController::class, 'loginCheck']);
        Route::put('join', [ApiMemberController::class, 'apiJoin']);
        Route::get('nationality', [ApiMemberController::class, 'getNationality']);
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
