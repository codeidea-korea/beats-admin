<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminAuthorityController;
use App\Http\Controllers\MultilingualController;
use App\Http\Controllers\BoardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//http://127.0.0.1:8000/register  관리자 가입
/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // dbConnect 및 Service 별도 분리 테스트
    //Route::get('/test', [HomeController::class, 'test']);

    //관리자 관리
    Route::group(['prefix' => 'admin'], function()
    {
        Route::get('/', [AdminAuthorityController::class, 'getAdminList']);
        Route::get('list', [AdminAuthorityController::class, 'getAdminList']);
        Route::get('view', [AdminAuthorityController::class, 'getAdminView']);
        Route::get('write', [AdminAuthorityController::class, 'getAdminWrite']);
        Route::post('ajax/adminAdd', [AdminAuthorityController::class, 'setAdminAdd']);

    });


    Route::get('/mainmanage/banner/list', [\App\Http\Controllers\MainManageController::class, 'getBannerList']);
    Route::get('/mainmanage/banner/view/{bidx}', [\App\Http\Controllers\MainManageController::class, 'getBannerView']);
    Route::get('/mainmanage/banner/write', [\App\Http\Controllers\MainManageController::class, 'getBannerWrite']);
    Route::post('/mainmanage/banner/add', [\App\Http\Controllers\MainManageController::class, 'BannerAdd']);
    Route::post('/mainmanage/banner/update', [\App\Http\Controllers\MainManageController::class, 'BannerUpdate']);
    Route::post('/mainmanage/banner/delete', [\App\Http\Controllers\MainManageController::class, 'BannerDelete']);

    Route::get('/admin/board/list', [BoardController::class, 'getBoardList']);
    Route::get('/admin/board/view/{bidx}', [BoardController::class, 'getBoardView']);
    Route::get('/admin/board/write', [BoardController::class, 'getBoardWrite']);
    Route::post('/admin/board/add', [BoardController::class, 'BoardAdd']);
    Route::post('/admin/board/update', [BoardController::class, 'BoardUpdate']);
    Route::post('/admin/board/delete', [BoardController::class, 'BoardDelete']);

    //다국어설정
    Route::group(['prefix' => 'multilingual'], function()
    {
        Route::get('/', [MultilingualController::class, 'langManage']);
        Route::get('/langManage', [MultilingualController::class, 'langManage']);

    });

});

Route::get('/pageSample', function () {
    return view('pageSample');
});

Route::get('/test', function () {
    return view('test');
});
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
//Route::middleware(['auth', 'user-access:admin'])->group(function () {

//    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
//});

//Route::middleware(['auth', 'user-access:manager'])->group(function () {

//    Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
//});
