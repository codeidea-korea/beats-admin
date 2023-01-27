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
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MentoController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DownloadController;

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

        //contract 계약서
        Route::get('/contract/list', [BoardController::class, 'getContractList']);
        Route::get('/contract/write', [BoardController::class, 'getContractWrite']);
        Route::post('/contract/add', [BoardController::class, 'setContractAdd']);
        Route::get('/contract/view/{idx}', [BoardController::class, 'getContractView']);
        Route::post('/contract/delete', [BoardController::class, 'setContractDelete']);

        //trend
        Route::get('/trend/list', [BoardController::class, 'getTrendList']);
        Route::get('/trend/write', [BoardController::class, 'getTrendWrite']);
        Route::post('/trend/add', [BoardController::class, 'setTrendAdd']);
        Route::get('/trend/view/{idx}', [BoardController::class, 'getTrendView']);
        Route::post('/trend/update', [BoardController::class, 'TrendUpdate']);
        Route::get('/trend/delete', [BoardController::class, 'TrendDelete']);
        Route::get('trendBeatView/{idx}', [BoardController::class, 'getTrendBeatView']);
        Route::get('trendCommentView/{idx}', [BoardController::class, 'getTrendCommentView']);

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
        Route::post('menuUploadExcel', [MultilingualController::class, 'menuUploadExcel']);

    });


    //회원관리
    Route::group(['prefix' => 'member'], function()
    {
        Route::get('/', [MemberController::class, 'getMemberList']);
        Route::get('memberList', [MemberController::class, 'getMemberList']);
        Route::get('musicList/{idx}', [MemberController::class, 'getMusicList']);
        Route::get('ajax/memberList', [MemberController::class, 'getPointMemberList']);
        Route::get('ajax/memberPaging', [MemberController::class, 'getPaging']);
        Route::get('ajax/sendPoint', [MemberController::class, 'sendPoint']);
        Route::post('ajax/excelupload', [MemberController::class, 'excelUpload']);
        Route::get('memberView/{idx}', [MemberController::class, 'getMemberView']);
        Route::post('ajax/memberUpdate', [MemberController::class, 'memberUpdate']);
        Route::post('ajax/memoInsert', [MemberController::class, 'setMemoInsert']);
        Route::post('ajax/memoDel', [MemberController::class, 'setMemoDel']);
        Route::get('ajax/memoList', [MemberController::class, 'getMemoList']);
        Route::get('memberDownloadExcel', [MemberController::class, 'memberDownloadExcel']);

        // 초대 내역
        Route::get('inviteList', [MemberController::class, 'getInviteList']);

        // 탈퇴 관리
        Route::get('withdrawalList', [MemberController::class, 'getWithdrawalList']);

        // 신고 내역
        Route::get('notifyList', [MemberController::class, 'getNotifyList']);

    });

    //멘토 뮤지션 관리
    Route::group(['prefix' => 'mento'], function()
    {
        // 멘토 전환신청
        Route::get('/', [MentoController::class, 'getFieldList']);
        // 멘토 전환신청 리스트
        Route::get('mentoList', [MentoController::class, 'getMentoList']);
        // 멘토 전환신청
        Route::post('ajax/mentoCh', [MentoController::class, 'setMentoCh']);
        // 멘토 전환신청 엑셀 다운로드
        Route::get('mentoChDownloadExcel', [MentoController::class, 'mentoChDownloadExcel']);
        // 멘토 전환신청 상세보기
        Route::get('mentoView/{idx}', [MentoController::class, 'getMentoView']);
        // 멘토 전환신청 상태변경 ( 승인 또는 반려 변경)
        Route::post('ajax/mentoChUpdate', [MentoController::class, 'setMentoChUpdate']);

        // 추천 멘토
        //Route::get('inviteList', [MentoController::class, 'getInviteList']);
        // 분야 관리
        Route::get('fieldList', [MentoController::class, 'getFieldList']);

        // 분야 수정
        Route::post('ajax/fieldUpdate', [MentoController::class, 'setFieldUpdate']);
        // 분야 등록
        Route::post('ajax/fieldInsert', [MentoController::class, 'setFieldInsert']);

        // 파일 다운로드
        Route::post('ajax/fileDownload', [MentoController::class, 'fileDownload']);
        // 분야 사용유무 전환
        Route::post('ajax/fieldStatus', [MentoController::class, 'fieldStatus']);


        // 멘토 전환신청 리스트
        Route::get('mentoChLog', [MentoController::class, 'getMentoChLog']);


    });


    //콘텐츠 관리
    Route::group(['prefix' => 'contents'], function()
    {
        Route::get('/', [MemberController::class, 'getMemberList']);

        // 음원관리
        Route::get('soundSourceList', [SoundSourceController::class, 'getSoundSourceList']);

        //피드관리
        Route::get('feedList', [FeedController::class, 'getFeedList']);
        Route::get('feedView/{idx}', [FeedController::class, 'getFeedView']);
        Route::get('feedBeatView/{idx}', [FeedController::class, 'getFeedBeatView']);
        Route::get('feedCommentView/{idx}', [FeedController::class, 'getFeedCommentView']);
        Route::post('feedUpdate', [FeedController::class, 'feedUpdate']);
        Route::get('/comment/commentDetail', [FeedController::class, 'getCommentDetail']);
        Route::get('/comment/commentUpdate', [FeedController::class, 'commentUpdate']);

        Route::get('reviewList', [ContentController::class, 'getReviewList']);
        Route::get('reviewView/{idx}', [ContentController::class, 'getReviewView']);
        Route::get('reviewCommentView/{idx}', [ContentController::class, 'getReviewCommentView']);
        Route::post('reviewUpdate', [ContentController::class, 'reviewUpdate']);
        Route::get('/comment/commentDetail', [ContentController::class, 'getCommentDetail']);
        Route::get('/comment/commentUpdate', [ContentController::class, 'commentUpdate']);
    });

    Route::post('ckeditor/upload', [BoardController::class, 'upload'])->name('ckeditor.upload');


    //제품 관리
    Route::group(['prefix' => 'products'], function()
    {
        Route::get('/', [ProductController::class, 'getProductList']);
        // 상품리스트
        Route::get('productList', [ProductController::class, 'getProductList']);
        // 상품등록화면
        Route::get('productWrite', [ProductController::class, 'getProductWrite']);
        // 상품등록
        Route::post('productInsert', [ProductController::class, 'setProductInsert']);
        // 상품상세
        Route::get('productView/{idx}', [ProductController::class, 'getProductView']);
        // 상품수정
        Route::post('productUpdate', [ProductController::class, 'putProductUpdate']);

    });

    //요금제 관리
    Route::group(['prefix' => 'plan'], function()
    {
        Route::get('/', [PlanController::class, 'getPlanList']);
        // 요금제 관리 리스트
        Route::get('planList', [PlanController::class, 'getPlanList']);
        // 요금제 관리 등록
        Route::get('planWrite', [PlanController::class, 'getPlanWrite']);
        // 요금제 등록
        Route::post('planInsert', [PlanController::class, 'setPlanInsert']);
        // 요금제 상세
        Route::get('planView/{idx}', [PlanController::class, 'getPlanView']);
        // 요금제 수정
        Route::post('planUpdate', [PlanController::class, 'putPlanUpdate']);

        // 학생 요금제 승인 신청내역 리스트
        Route::get('studentList', [PlanController::class, 'getStudentList']);
        // 학생 요금제 승인 및 반려
        Route::post('studentStatusUp', [PlanController::class, 'studentStatusUp']);

        // 학생 요금제 승인 및 반려
        Route::get('studentExcelDownLoad', [PlanController::class, 'studentExcelDownLoad']);

    });

});
Route::get('downloadFile', [DownloadController::class, 'downloadFile']);

