`@extends('layouts.Default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">관리자 현황</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">
                <form name="searchForm" id="searchForm" class="form-horizontal" role="form"   method="get" action="{{ url('/member/memberList') }}">

                    <input type="hidden" name="page" value="{{$searchData['page']}}">
                    <div class="intro-y box">
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">분류</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="class">
                                                <option value="">전체</option>
                                                <option value="3">통합회원</option>
                                                <option value="1">임시회원</option>
                                                <option value="2">비트썸원</option>
                                                <option value="0">휴면회원</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">회원 구분</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="gubun">
                                                <option value="">전체</option>
                                                <option value="1">일반</option>
                                                <option value="2">작곡가</option>
                                                <option value="3">멘토 뮤지션</option>
                                                <option value="4">음원 구매자</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">가입 채널</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="channel">
                                                <option value="">전체</option>
                                                <option value="facebook">페이스북</option>
                                                <option value="twitter">트위터</option>
                                                <option value="google">구글</option>
                                                <option value="apple">애플</option>
                                                <option value="naver">네이버</option>
                                                <option value="kakao">카카오</option>
                                                <option value="soundcloud">사운드클라우드</option>
                                                <option value="email">직접가입</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">국적</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="nationality">
                                                <option value="">전체</option>
                                                <option value="kr">한국</option>
                                                <option value="en">미국</option>
                                                <option value="ch">중국</option>
                                                <option value="jp">일본</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">상태</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="mem_status">
                                                <option value="">전체</option>
                                                <option value="1">임시</option>
                                                <option value="2">정상</option>
                                                <option value="3">제재</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">검색</th>
                                        <td class="whitespace-nowrap" colspan="3">
                                            <input id="regular-form-1" type="text">
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">가입일</th>
                                        <td class="whitespace-nowrap" colspan="5">
                                            <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                                <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                                <input type="text" class="datepicker form-control sm:w-56 box pl-10">
                                            </div>
                                        </td>

                                    </tr>
                                </table>
                                <div style="float:right;">
                                    <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/admin/write';">
                                        초기화
                                    </button>
                                </div>
                                <div style="float:right;">
                                    &nbsp;
                                </div>
                                <div style="float:right;">
                                    <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/admin/write';">
                                        검색
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}명의 관리자가 있습니다.</h2>
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview2" class="btn btn-primary mr-1 mb-2">포인트 지급</a>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">No.</th>
                                    <th class="whitespace-nowrap text-center">분류</th>
                                    <th class="whitespace-nowrap text-center">회원 구분</th>
                                    <th class="whitespace-nowrap text-center">가입 채널</th>
                                    <th class="whitespace-nowrap text-center">국적</th>

                                    <th class="whitespace-nowrap text-center">고유 ID</th>
                                    <th class="whitespace-nowrap text-center">닉네임</th>
                                    <th class="whitespace-nowrap text-center">제재</th>
                                    <th class="whitespace-nowrap text-center">상태</th>
                                    <th class="whitespace-nowrap text-center">가입일</th>

                                    <th class="whitespace-nowrap text-center">최근 접속일</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=0; @endphp
                                @foreach($memberList as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center">{{$totalCount-($i+(($params['page']-1)*10))}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->class}}</td>
                                        <td class="whitespace-nowrap text-center"><a href="javascript:alert({{$rs->mem_id}});">{{$rs->gubun}}</a></td>
                                        <td class="whitespace-nowrap text-center">{{$rs->channel}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->nationality}}</td>

                                        <td class="whitespace-nowrap text-center">ip address</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->mem_nickname}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->mem_sanctions}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->mem_status}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->mem_regdate}}</td>

                                        <td class="whitespace-nowrap text-center">최근접속일</td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 페이징처리 시작 -->
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-5">
                    <nav class="w-full">

                        @include('vendor.pagination.default')

                    </nav>
                </div>
                <!-- 페이징처리 종료 -->
            </div>

        </div>

    </div>

    <!-- 포인트지급 설정 모달 시작 -->
    <div id="superlarge-modal-size-preview2" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-2xl">
            <div class="modal-content">
                <div class="modal-body p-10 text-center">
                    <div class="overflow-x-auto">
                        <table class="table table-bordered">
                            <tr>
                                <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">포인트 설정</th>
                                <th class="whitespace-nowrap text-center bg-primary/10">증감선택</th>
                                <th class="whitespace-nowrap text-center bg-primary/10">지급/차감</th>
                                <th class="whitespace-nowrap text-center bg-primary/10">지급내용</th>
                                <th class="whitespace-nowrap text-center bg-primary/10">관리자</th>
                            </tr>
                            <tr>
                                <td>
                                    <select class="form-select w-56" aria-label=".form-select-lg example">
                                        <option>+</option>
                                        <option>전체1</option>
                                        <option>전체2</option>
                                    </select>
                                </td>
                                <td>
                                    <input id="regular-form-1" type="text" class="form-control" placeholder="금액 입력">
                                </td>
                                <td>
                                    <input id="regular-form-1" type="text" class="form-control" placeholder="사유 입력">
                                </td>
                                <td>
                                    <select class="form-select w-56" aria-label=".form-select-lg example">
                                        <option>관리자</option>
                                        <option>전체1</option>
                                        <option>전체2</option>
                                    </select>

                                    <!-- <div class="form-check inline-block ml-5">
                                        <input id="checkbox-switch-1" class="form-check-input" type="checkbox" value="">
                                        <label class="form-check-label" for="checkbox-switch-1">Chris Evans</label>
                                    </div>
                                    <div class="form-check inline-block ml-5">
                                        <input id="radio-switch-1" class="form-check-input" type="radio" name="vertical_radio_button" value="vertical-radio-chris-evans">
                                        <label class="form-check-label" for="radio-switch-1">Chris Evans</label>
                                    </div> -->
                                </td>
                            </tr>
                        </table>

                        <div class="intro-y box mt-5">
                            <div class="flex items-center w-full">
                                <div class="flex items-center mr-5">
                                    <span class="mr-2">가입 채널</span>
                                    <select class="form-select w-32" aria-label=".form-select-lg example">
                                        <option>비트썸원</option>
                                        <option>전체1</option>
                                        <option>전체2</option>
                                    </select>
                                </div>

                                <div class="flex items-center mr-5">
                                    <span class="mr-2">국적</span>
                                    <select class="form-select w-32" aria-label=".form-select-lg example">
                                        <option>전체</option>
                                        <option>전체1</option>
                                        <option>전체2</option>
                                    </select>
                                </div>

                                <div class="flex items-center mr-5">
                                    <span class="mr-2">검색</span>
                                    <input id="regular-form-1" type="text" class="form-control w-52" placeholder="금액 입력">
                                </div>

                                <div class="flex items-center mr-5">
                                    <span class="mr-2">가입일</span>
                                    <div class="relative inline-block w-40">
                                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                            <i data-lucide="calendar" class="w-4 h-4"></i>
                                        </div>
                                        <input type="text" class="datepicker form-control pl-12" data-single-mode="true">
                                    </div>
                                    <div class="relative inline-block w-40">
                                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                            <i data-lucide="calendar" class="w-4 h-4"></i>
                                        </div>
                                        <input type="text" class="datepicker form-control pl-12" data-single-mode="true">
                                    </div>
                                </div>
                            </div>

                            <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                                <button class="btn box flex items-center text-slate-600 border border-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="file-text" data-lucide="file-text" class="lucide lucide-file-text hidden sm:block w-4 h-4 mr-2">
                                        <path d="M14.5 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V7.5L14.5 2z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <line x1="10" y1="9" x2="8" y2="9"></line>
                                    </svg> Excel Upload
                                </button>
                                <button class="btn btn-primary w-24 ml-2">검색</button>
                                <button class="btn btn-secondary w-24">초기화</button>
                            </div>

                            <div class="flex justify-between items-center mt-5">
                                <div class="w-full">
                                    <div class="flex flex-col sm:flex-row items-center border-b border-slate-200/60">
                                        <h2 class="font-medium text-base mr-auto text-primary">총 000명의 회원이 있습니다</h2>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th class="whitespace-nowrap text-center bg-primary/10">
                                                    <div class="form-check">
                                                        <input id="checkbox-switch-1" class="form-check-input" type="checkbox" value="">
                                                    </div>
                                                </th>
                                                <th class="whitespace-nowrap text-cente bg-primary/10">서비스</th>
                                                <th class="whitespace-nowrap text-center bg-primary/10">회원 구분</th>
                                                <th class="whitespace-nowrap text-center bg-primary/10">가입 채널</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="whitespace-nowrap text-center">
                                                    <div class="form-check">
                                                        <input id="checkbox-switch-1" class="form-check-input" type="checkbox" value="">
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap text-center">바이비츠</td>
                                                <td class="whitespace-nowrap text-center">작곡가</td>
                                                <td class="whitespace-nowrap text-center">카카오</td>
                                            </tr>
                                            <tr>
                                                <td class="whitespace-nowrap text-center">
                                                    <div class="form-check">
                                                        <input id="checkbox-switch-1" class="form-check-input" type="checkbox" value="">
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap text-center">바이비츠</td>
                                                <td class="whitespace-nowrap text-center">작곡가</td>
                                                <td class="whitespace-nowrap text-center">카카오</td>
                                            </tr>
                                            <tr>
                                                <td class="whitespace-nowrap text-center">
                                                    <div class="form-check">
                                                        <input id="checkbox-switch-1" class="form-check-input" type="checkbox" value="">
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap text-center">바이비츠</td>
                                                <td class="whitespace-nowrap text-center">작곡가</td>
                                                <td class="whitespace-nowrap text-center">카카오</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- 페이징처리 시작 -->
                                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-5">
                                        <nav class="w-full">
                                            <ul class="pagination justify-center">
                                                <li class="page-item">
                                                    <a class="page-link" href="#">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-left" class="lucide lucide-chevrons-left w-4 h-4" data-lucide="chevrons-left">
                                                            <polyline points="11 17 6 12 11 7"></polyline>
                                                            <polyline points="18 17 13 12 18 7"></polyline>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-left" class="lucide lucide-chevron-left w-4 h-4" data-lucide="chevron-left">
                                                            <polyline points="15 18 9 12 15 6"></polyline>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">...</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">1</a>
                                                </li>
                                                <li class="page-item active">
                                                    <a class="page-link" href="#">2</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">3</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">...</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right" class="lucide lucide-chevron-right w-4 h-4" data-lucide="chevron-right">
                                                            <polyline points="9 18 15 12 9 6"></polyline>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-right" class="lucide lucide-chevrons-right w-4 h-4" data-lucide="chevrons-right">
                                                            <polyline points="13 17 18 12 13 7"></polyline>
                                                            <polyline points="6 17 11 12 6 7"></polyline>
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <!-- 페이징처리 종료 -->
                                </div>

                                <!-- 가운데 화살표 시작 -->
                                <div class="ml-5 mr-5">
                                    <i data-lucide="fast-forward"></i>
                                    <i data-lucide="rewind" class="mt-5"></i>
                                </div>
                                <!-- 가운데 화살표 끝 -->

                                <!-- 오른쪽 테이블 시작 -->
                                <div class="w-full">
                                    <div class="flex flex-col sm:flex-row items-center border-b border-slate-200/60">
                                        <h2 class="font-medium text-base mr-auto text-primary">총 000명의 회원이 있습니다</h2>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th class="whitespace-nowrap text-center bg-primary/10">
                                                    <div class="form-check">
                                                        <input id="checkbox-switch-1" class="form-check-input" type="checkbox" value="">
                                                    </div>
                                                </th>
                                                <th class="whitespace-nowrap text-cente bg-primary/10">서비스</th>
                                                <th class="whitespace-nowrap text-center bg-primary/10">회원 구분</th>
                                                <th class="whitespace-nowrap text-center bg-primary/10">가입 채널</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="whitespace-nowrap text-center">
                                                    <div class="form-check">
                                                        <input id="checkbox-switch-1" class="form-check-input" type="checkbox" value="">
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap text-center">바이비츠</td>
                                                <td class="whitespace-nowrap text-center">작곡가</td>
                                                <td class="whitespace-nowrap text-center">카카오</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- 페이징처리 시작 -->
                                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-5">
                                        <nav class="w-full">
                                            <ul class="pagination justify-center">
                                                <li class="page-item">
                                                    <a class="page-link" href="#">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-left" class="lucide lucide-chevrons-left w-4 h-4" data-lucide="chevrons-left">
                                                            <polyline points="11 17 6 12 11 7"></polyline>
                                                            <polyline points="18 17 13 12 18 7"></polyline>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-left" class="lucide lucide-chevron-left w-4 h-4" data-lucide="chevron-left">
                                                            <polyline points="15 18 9 12 15 6"></polyline>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">...</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">1</a>
                                                </li>
                                                <li class="page-item active">
                                                    <a class="page-link" href="#">2</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">3</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">...</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-right" class="lucide lucide-chevron-right w-4 h-4" data-lucide="chevron-right">
                                                            <polyline points="9 18 15 12 9 6"></polyline>
                                                        </svg>
                                                    </a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevrons-right" class="lucide lucide-chevrons-right w-4 h-4" data-lucide="chevrons-right">
                                                            <polyline points="13 17 18 12 13 7"></polyline>
                                                            <polyline points="6 17 11 12 6 7"></polyline>
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <!-- 페이징처리 종료 -->
                                </div>
                                <!-- 오른쪽 테이블 끝 -->
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center mt-5">
                        <button class="btn btn-primary w-32 mr-5">설정</button>
                        <button class="btn btn-secondary w-32 modalCancel">닫기</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function (){
            // 폼삭제
            $(".modalCancel").on("click", function() {
                $("#superlarge-modal-size-preview2").hidden.true;
                //$(this).closest("tr").remove();superlarge-modal-size-preview2
                alert();
            });
        })

        function change(page) {
            $("input[name=page]").val(page);
            $("form[name=searchData]").submit();
        }
    </script>
@endsection
`
