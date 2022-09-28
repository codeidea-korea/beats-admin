<!DOCTYPE html>
<!--
Template Name: Midone - HTML Admin Dashboard Template
Author: Left4code
Website: http://www.left4code.com/
Contact: muhammadrizki@left4code.com
Purchase: https://themeforest.net/user/left4code/portfolio
Renew Support: https://themeforest.net/user/left4code/portfolio
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="ko" class="light">
<!-- BEGIN: Head -->
<head>
    <meta charset="utf-8">
    <link href="./dist/images/logo.svg" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Midone admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Midone Admin Template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">
    <title>비트썸원-바이비츠 통합관리자</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="./dist/css/app.css" />
    <!-- END: CSS Assets-->
</head>
<!-- END: Head -->
<body class="py-5">
<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="Midone - HTML Admin Template" class="w-6" src="./dist/images/logo.svg">
        </a>
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <div class="scrollable">
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        <ul class="scrollable__content py-2">
            <li>
                <a href="javascript:;.html" class="menu menu--active">
                    <div class="menu__icon"> <i data-lucide="home"></i> </div>
                    <div class="menu__title"> 다국어 설정 <i data-lucide="chevron-down" class="menu__sub-icon transform rotate-180"></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu menu--active">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 언어 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu menu--active">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 메뉴 관리 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="box"></i> </div>
                    <div class="menu__title"> 대시보드 <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="shopping-bag"></i> </div>
                    <div class="menu__title"> 메인관리 <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 배너 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 팝업 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 푸시 관리 <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="inbox"></i> </div>
                    <div class="menu__title"> 회원 관리 </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 회원 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 초대 내역 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 탈퇴 관리 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 신고 내역 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 휴면 관리 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="hard-drive"></i> </div>
                    <div class="menu__title"> 멘토 뮤지션 관리 </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 전환 신청 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 추천 멘토 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 분야 관리 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="credit-card"></i> </div>
                    <div class="menu__title"> 요금제 관리 </div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="message-square"></i> </div>
                    <div class="menu__title">
                        콘텐츠 관리
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 피드 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 음원제작 의뢰 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 질문/답변 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 명예의 전당 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 제품 리뷰 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 음원 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 앨범 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 코칭 상품 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 코칭 내역 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 코칭 후기 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="file-text"></i> </div>
                    <div class="menu__title"> 제품 관리 </div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="calendar"></i> </div>
                    <div class="menu__title"> 결제 및 정산 </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 결제 내역 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 구독 내역 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 주문 관리 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 정산 내역 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 환율 관리 <i data-lucide="activity"></i> </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="edit"></i> </div>
                    <div class="menu__title"> 포인트 및 쿠폰 <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 포인트 내역 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 포인트 설정 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 쿠폰 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 미사용쿠폰 관리 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="users"></i> </div>
                    <div class="menu__title"> 서비스 관리 <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 트랜드 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 이벤트 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 공지사항 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 1:1문의 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 약관 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 태그 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 약식 계약서 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="trello"></i> </div>
                    <div class="menu__title"> 알림톡 관리 <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-lucide="layout"></i> </div>
                    <div class="menu__title"> 관리자 관리 <i data-lucide="chevron-down" class="menu__sub-icon "></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 관리자 현황 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title"> 권한 관리 </div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- END: Mobile Menu -->
<div class="flex mt-[4.7rem] md:mt-0">
    <!-- BEGIN: Side Menu -->
    <nav class="side-nav">
        <a href="" class="intro-x flex items-center pl-5 pt-4">
            <img alt="Midone - HTML Admin Template" class="w-6" src="dist/images/logo.svg">
            <span class="hidden xl:block text-white text-lg ml-3"> 통합관리자 </span>
        </a>
        <div class="side-nav__devider my-6"></div>
        <ul>
            <li>
                <a href="javascript:;" class="side-menu side-menu--active">
                    <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                    <div class="side-menu__title">
                        다국어 설정
                        <div class="side-menu__sub-icon transform rotate-180"> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="side-menu__sub-open">
                    <li>
                        <a href="javascript:;" class="side-menu side-menu--active">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 언어 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 메뉴 관리 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                    <div class="side-menu__title">
                        대시보드
                    </div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="shopping-bag"></i> </div>
                    <div class="side-menu__title">
                        메인관리
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 배너 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 팝업 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 푸시 관리 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="inbox"></i> </div>
                    <div class="side-menu__title">
                        회원 관리
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 회원 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 초대 내역 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 탈퇴 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 신고 내역 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 휴면 관리 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="hard-drive"></i> </div>
                    <div class="side-menu__title">
                        멘토 뮤지션 관리
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 전환 신청 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 추천 멘토 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 분야 관리 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="credit-card"></i> </div>
                    <div class="side-menu__title"> 요금제 관리 </div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="message-square"></i> </div>
                    <div class="side-menu__title">
                        콘텐츠 관리
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 피드 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 음원제작 의뢰 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 질문/답변 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 명예의 전당 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 제품 리뷰 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 음원 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 앨범 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 코칭 상품 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 코칭 내역 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 코칭 후기 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                    <div class="side-menu__title">
                        제품 관리
                    </div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="calendar"></i> </div>
                    <div class="side-menu__title">
                        결제 및 정산
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 결제 내역 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 구독 내역 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 주문 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 정산 내역 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 환율 관리 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="edit"></i> </div>
                    <div class="side-menu__title">
                        포인트 및 쿠폰
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 포인트 내역 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 포인트 설정 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 쿠폰 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 미사용 쿠폰 관리 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                    <div class="side-menu__title">
                        서비스 관리
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 트렌드 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 이벤트 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 공지사항 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 1:1 문의 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 약관 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 태그 관리 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 약식 계약서 </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="trello"></i> </div>
                    <div class="side-menu__title">
                        알림톡 관리
                    </div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-lucide="layout"></i> </div>
                    <div class="side-menu__title">
                        관리자 관리
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 관리자 현황 </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="side-menu__title"> 권한 관리 </div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- END: Side Menu -->





    <div class="content">




        <!-- top bar -->

        <!-- BEGIN: Top Bar -->
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Application</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            <!-- END: Breadcrumb -->

            <!-- BEGIN: Account Menu -->
            <div class="intro-x dropdown w-8 h-8">
                <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false" data-tw-toggle="dropdown">
                    <img alt="Midone - HTML Admin Template" src="dist/images/profile-5.jpg">
                </div>
                <div class="dropdown-menu w-56">
                    <ul class="dropdown-content bg-primary text-white">
                        <li class="p-2">
                            <div class="font-medium">Kevin Spacey</div>
                            <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">Software Engineer</div>
                        </li>
                        <li>
                            <hr class="dropdown-divider border-white/[0.08]">
                        </li>
                        <li>
                            <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> Profile </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Add Account </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="help-circle" class="w-4 h-4 mr-2"></i> Help </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider border-white/[0.08]">
                        </li>
                        <li>
                            <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- END: Account Menu -->
        </div>
        <!-- END: Top Bar -->

        <!-- top bar end -->





<!--footer.php -->


</div>
<!-- BEGIN: Dark Mode Switcher-->
<!---<div data-url="side-menu-dark-dashboard-overview-1.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
    <div class="mr-4 text-slate-600 dark:text-slate-200">Dark Mode</div>
    <div class="dark-mode-switcher__toggle border"></div>
</div>-->
<!-- END: Dark Mode Switcher-->

<!-- BEGIN: JS Assets-->
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>
<script src="dist/js/app.js"></script>
<!-- END: JS Assets-->
</body>
</html>
