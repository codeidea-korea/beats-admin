<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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
    Route::get('/admin/list', [\App\Http\Controllers\AdminAuthorityController::class, 'getAdminList']);
    Route::get('/admin/view', [\App\Http\Controllers\AdminAuthorityController::class, 'getAdminView']);
    Route::get('/admin/write', [\App\Http\Controllers\AdminAuthorityController::class, 'getAdminWrite']);
    Route::post('/admin/ajax/adminAdd', [\App\Http\Controllers\AdminAuthorityController::class, 'setAdminAdd']);

    Route::get('/admin/board/list', [\App\Http\Controllers\BoardController::class, 'getBoardList']);
    Route::get('/admin/board/view/{bidx}', [\App\Http\Controllers\BoardController::class, 'getBoardView']);
    Route::get('/admin/board/write', [\App\Http\Controllers\BoardController::class, 'getBoardWrite']);
    Route::post('/admin/board/add', [\App\Http\Controllers\BoardController::class, 'BoardAdd']);
    Route::post('/admin/board/update', [\App\Http\Controllers\BoardController::class, 'BoardUpdate']);
    Route::post('/admin/board/delete', [\App\Http\Controllers\BoardController::class, 'BoardDelete']);

    Route::get('/mainmanage/banner/list', [\App\Http\Controllers\MainManageController::class, 'getBannerList']);
    Route::get('/mainmanage/banner/view/{bidx}', [\App\Http\Controllers\MainManageController::class, 'getBannerView']);
    Route::get('/mainmanage/banner/write', [\App\Http\Controllers\MainManageController::class, 'getBannerWrite']);
    Route::post('/mainmanage/banner/add', [\App\Http\Controllers\MainManageController::class, 'BannerAdd']);
    Route::post('/mainmanage/banner/update', [\App\Http\Controllers\MainManageController::class, 'BannerUpdate']);
    Route::post('/mainmanage/banner/delete', [\App\Http\Controllers\MainManageController::class, 'BannerDelete']);
});

Route::get('/pageSample', function () {
    return view('pageSample');
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
