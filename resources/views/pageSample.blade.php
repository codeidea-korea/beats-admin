@extends('layouts.default')
@section('content')
    <div class="content">
    <!-- BEGIN: Top Bar -->
        @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">푸시 관리</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">

                <div class="intro-y box">

                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">푸시 발송</h2>
                    </div>

                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">발송대상</th>
                                    <td class="whitespace-nowrap">
                                        <span>선택된 회원이 없습니다.</span>
                                        <button class="btn btn-primary w-24">대상 설정</button>
                                    </td>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">서비스 선택</th>
                                    <td class="whitespace-nowrap">
                                        <select class="form-select w-60" aria-label=".form-select-lg example">
                                            <option>미 선택</option>
                                            <option>선택1</option>
                                            <option>선택2</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input id="regular-form-1" type="text" class="form-control" placeholder="Input text">
                                            <p class="ml-5">제목은 최대 000 글자까지 입력 가능합니다.</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input id="regular-form-1" type="text" class="form-control" placeholder="Input text">
                                            <p class="ml-5">제목은 최대 000 글자까지 입력 가능합니다.</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">이미지</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <input class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="formFile">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">발송 시간</th>
                                    <td colspan="3">
                                        <div class="relative inline-block w-56">
                                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                            </div>
                                            <input type="text" class="datepicker form-control pl-12" data-single-mode="true">
                                        </div>
                                        <select class="form-select w-56" aria-label=".form-select-lg example">
                                            <option>15시</option>
                                            <option>16시</option>
                                            <option>17시</option>
                                        </select>
                                        <select class="form-select w-56" aria-label=".form-select-lg example">
                                            <option>15시</option>
                                            <option>16시</option>
                                            <option>17시</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="intro-y box mt-5">
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">서비스</th>
                                    <td class="">
                                        <select class="form-select w-56" aria-label=".form-select-lg example">
                                            <option>전체</option>
                                            <option>전체1</option>
                                            <option>전체2</option>
                                        </select>
                                    </td>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">상태</th>
                                    <td class="">
                                        <select class="form-select w-56" aria-label=".form-select-lg example">
                                            <option>전체</option>
                                            <option>전체1</option>
                                            <option>전체2</option>
                                        </select>
                                    </td>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">발송일</th>
                                    <td class="">
                                        <div class="relative inline-block w-56">
                                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                            </div>
                                            <input type="text" class="datepicker form-control pl-12" data-single-mode="true">
                                        </div>
                                        <div class="relative inline-block w-56">
                                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                            </div>
                                            <input type="text" class="datepicker form-control pl-12" data-single-mode="true">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                            <button class="btn btn-primary w-24 ml-2">검색</button>
                            <button class="btn btn-secondary w-24">초기화</button>
                        </div>
                    </div>
                </div>

                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 000개의 발송 내역이 있습니다.</h2>
                        <button class="btn box flex items-center text-slate-600 border border-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="file-text" data-lucide="file-text" class="lucide lucide-file-text hidden sm:block w-4 h-4 mr-2">
                                <path d="M14.5 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V7.5L14.5 2z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <line x1="10" y1="9" x2="8" y2="9"></line>
                            </svg> Export to Excel
                        </button>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">No.</th>
                                    <th class="whitespace-nowrap text-center">상태</th>
                                    <th class="whitespace-nowrap text-center">서비스</th>
                                    <th class="whitespace-nowrap text-center">제목</th>
                                    <th class="whitespace-nowrap text-center">내용</th>
                                    <th class="whitespace-nowrap text-center">발송 대상</th>
                                    <th class="whitespace-nowrap text-center">발송일</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="whitespace-nowrap text-center">0</td>
                                    <td class="whitespace-nowrap text-center text-danger">발송 예약</td>
                                    <td class="whitespace-nowrap text-center">비트썸원</td>
                                    <td class="whitespace-nowrap text-center">(푸시 제목 표기)</td>
                                    <td class="whitespace-nowrap text-center">(푸시 내용 표기) 가나다라 마바사 아자차카</td>
                                    <td class="whitespace-nowrap text-center">3,092명</td>
                                    <td class="whitespace-nowrap text-center">yyyy.mm.dd. HH:MM:SS</td>
                                </tr>
                                <tr>
                                    <td class="whitespace-nowrap text-center">1</td>
                                    <td class="whitespace-nowrap text-center text-success">발송 중</td>
                                    <td class="whitespace-nowrap text-center">비트썸원</td>
                                    <td class="whitespace-nowrap text-center">(푸시 제목 표기)</td>
                                    <td class="whitespace-nowrap text-center">(푸시 내용 표기) 가나다라 마바사 아자차카</td>
                                    <td class="whitespace-nowrap text-center">(인원 수 )명</td>
                                    <td class="whitespace-nowrap text-center">yyyy.mm.dd. HH:MM:SS</td>
                                </tr>
                                <tr>
                                    <td class="whitespace-nowrap text-center">1</td>
                                    <td class="whitespace-nowrap text-center text-primary">발송 완료</td>
                                    <td class="whitespace-nowrap text-center">비트썸원</td>
                                    <td class="whitespace-nowrap text-center">(푸시 제목 표기)</td>
                                    <td class="whitespace-nowrap text-center">(푸시 내용 표기) 가나다라 마바사 아자차카</td>
                                    <td class="whitespace-nowrap text-center">(인원 수 )명</td>
                                    <td class="whitespace-nowrap text-center">yyyy.mm.dd. HH:MM:SS</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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

        </div>

    </div>

@endsection
