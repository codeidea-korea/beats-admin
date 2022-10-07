<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminAuthorityController;
use App\Http\Controllers\MultilingualController;
use App\Http\Controllers\MainManageController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SoundSourceController;
use App\Http\Controllers\FeedController;
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
    Route::get('/test', [HomeController::class, 'test']);

    //관리자 관리
    Route::group(['prefix' => 'admin'], function()
    {
        Route::get('/', [AdminAuthorityController::class, 'getAdminList']);
        Route::get('list', [AdminAuthorityController::class, 'getAdminList']);
        Route::get('view', [AdminAuthorityController::class, 'getAdminView']);
        Route::get('write', [AdminAuthorityController::class, 'getAdminWrite']);
        Route::get('ajax/adminIdCheck', [AdminAuthorityController::class, 'getAdminIdCheck']);
        Route::post('ajax/adminAdd', [AdminAuthorityController::class, 'setAdminAdd']);
        Route::post('ajax/changePw', [AdminAuthorityController::class, 'setChangePw']);
        Route::post('ajax/adminUpdate', [AdminAuthorityController::class, 'setAdminUpdate']);
        Route::post('ajax/adminDel', [AdminAuthorityController::class, 'setAdminDel']);
        Route::get('authority', [AdminAuthorityController::class, 'getAdminAuthority']);
        Route::post('authUpdate', [AdminAuthorityController::class, 'getAuthUpdate']);
    });

    //메인 관리
    Route::group(['prefix' => 'mainmanage'], function()
    {
        Route::get('banner/list', [MainManageController::class, 'getBannerList']);
        Route::get('banner/view/{bidx}', [MainManageController::class, 'getBannerView']);
        Route::post('banner/add', [MainManageController::class, 'BannerAdd']);
        Route::post('banner/update', [MainManageController::class, 'BannerUpdate']);
        Route::post('banner/delete', [MainManageController::class, 'BannerDelete']);
        Route::get('banner/seqchange', [MainManageController::class, 'SeqChange']);
        Route::get('banner/selectdelete', [MainManageController::class, 'SelectDelete']);

        Route::get('popup/list', [MainManageController::class, 'getPopupList']);
        Route::get('popup/view/{bidx}', [MainManageController::class, 'getPopupView']);
        Route::get('popup/write', [MainManageController::class, 'PopupWrite']);
        Route::post('popup/add', [MainManageController::class, 'PopupAdd']);
        Route::post('popup/update', [MainManageController::class, 'PopupUpdate']);
        Route::get('popup/delete', [MainManageController::class, 'PopupDelete']);
    });

    Route::group(['prefix' => 'service'], function()
    {
        Route::get('/board/list', [BoardController::class, 'getBoardList']);
        Route::get('/board/view/{bidx}', [BoardController::class, 'getBoardView']);
        Route::get('/board/write', [BoardController::class, 'getBoardWrite']);
        Route::post('/board/add', [BoardController::class, 'BoardAdd']);
        Route::post('/board/update', [BoardController::class, 'BoardUpdate']);
        Route::get('/board/delete', [BoardController::class, 'BoardDelete']);

        Route::get('/event/list', [BoardController::class, 'getEventList']);
        Route::get('/event/view/{bidx}', [BoardController::class, 'getEventView']);
        Route::get('/event/write', [BoardController::class, 'getEventWrite']);
        Route::post('/event/add', [BoardController::class, 'EventAdd']);
        Route::post('/event/update', [BoardController::class, 'EventUpdate']);
        Route::get('/event/delete', [BoardController::class, 'EventDelete']);

        Route::get('/terms/list', [BoardController::class, 'getTermsList']);
        Route::get('/terms/view/{bidx}', [BoardController::class, 'getTermsView']);
        Route::get('/terms/write', [BoardController::class, 'getTermsWrite']);
        Route::post('/terms/add', [BoardController::class, 'TermsAdd']);
        Route::post('/terms/update', [BoardController::class, 'TermsUpdate']);
        Route::get('/terms/delete', [BoardController::class, 'TermsDelete']);
        Route::get('/terms/termstype', [BoardController::class, 'getTermsType']);
    });

    //다국어설정
    Route::group(['prefix' => 'multilingual'], function()
    {
        Route::get('/', [MultilingualController::class, 'langManage']);
        Route::get('langManage', [MultilingualController::class, 'langManage']);
        Route::post('ajax/langUpdate', [MultilingualController::class, 'setLangUpdate']);
        Route::get('menuManage/{siteCode}', [MultilingualController::class, 'menuManage']);
        Route::post('updateMenuManage', [MultilingualController::class, 'setMenuManage']);
        Route::get('menuDownloadExcel', [MultilingualController::class, 'menuDownloadExcel']);

    });


    //회원관리
    Route::group(['prefix' => 'member'], function()
    {
        Route::get('/', [MemberController::class, 'getMemberList']);
        Route::get('memberList', [MemberController::class, 'getMemberList']);
        Route::get('musicList/{idx}', [MemberController::class, 'getMusicList']);
        Route::get('/ajax/memberList', [MemberController::class, 'getPointMemberList']);
        Route::get('/ajax/memberPaging', [MemberController::class, 'getPaging']);
        Route::get('/ajax/sendPoint', [MemberController::class, 'sendPoint']);
        Route::get('memberView/{idx}', [MemberController::class, 'getMemberView']);

        // 초대 내역
        Route::get('inviteList', [MemberController::class, 'getInviteList']);

        // 탈퇴 관리
        Route::get('withdrawalList', [MemberController::class, 'getWithdrawalList']);

        // 신고 내역
        Route::get('notifyList', [MemberController::class, 'getNotifyList']);

    });

    //콘텐츠 관리
    Route::group(['prefix' => 'contents'], function()
    {
        Route::get('/', [MemberController::class, 'getMemberList']);

        // 음원관리
        Route::get('soundSourceList', [SoundSourceController::class, 'getSoundSourceList']);

        //피드관리
        Route::get('feedList', [FeedController::class, 'getFeedList']);

    });



    Route::post('ckeditor/upload', [BoardController::class, 'upload'])->name('ckeditor.upload');
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
