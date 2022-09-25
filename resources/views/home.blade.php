@extends('layouts.default')
@section('content')
    <!-- BEGIN: Content -->
    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('include.topBarINC')
        <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">대시보드</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">
                    <!-- table 시작 -->
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10 w-24">음원상태</th>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="relative w-56">
                                                <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                                </div>
                                                <input type="text" class="datepicker form-control pl-12" data-single-mode="true">
                                            </div>
                                            <div class="relative w-56">
                                                <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                                </div>
                                                <input type="text" class="datepicker form-control pl-12" data-single-mode="true">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <!-- 테이블 끝 -->
                            <div class="flex w-full box pt-5">
                                <div class="ml-auto">
                                    <button class="btn btn-secondary w-24">초기화</button>
                                    <button class="btn btn-primary w-24 ml-2">검색</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="intro-y col-span-6">
                <div class="box border border-slate-200 zoom-in h-full">
                    <div class="flex flex-col items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">회원 가입</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-3">
                            <div class="flex w-full ">
                                <div class="flex items-center text-lg">신규 가입 회원</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(명)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">멘토 전환 신청</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(명)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">일반 회원</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(명)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">멘토 회원</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(명)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="intro-y col-span-6">
                <div class="box border border-slate-200 zoom-in h-full">
                    <div class="flex flex-col items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">회원 탈퇴</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-3">
                            <div class="flex w-full ">
                                <div class="flex items-center text-lg">탈퇴 대기 회원</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(명)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">탈퇴 완료</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(명)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="intro-y col-span-4">
                <div class="box border border-slate-200 zoom-in h-full">
                    <div class="flex flex-col items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">음원</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-3">
                            <div class="flex w-full ">
                                <div class="flex items-center text-lg">신규 등록</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">삭제 음원</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">판매 음원</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">전체 음원</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="intro-y col-span-4">
                <div class="box border border-slate-200 zoom-in h-full">
                    <div class="flex flex-col items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">앨범</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-3">
                            <div class="flex w-full ">
                                <div class="flex items-center text-lg">신규 등록</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">삭제 앨범</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">판매 앨범</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">전체 앨범</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="intro-y col-span-4">
                <div class="box border border-slate-200 zoom-in h-full">
                    <div class="flex flex-col items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">코칭</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-3">
                            <div class="flex w-full ">
                                <div class="flex items-center text-lg">이용권 등록</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">이용권 판매</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">진행 중인 코칭</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">누적 코칭</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="intro-y col-span-4">
                <div class="box border border-slate-200 zoom-in h-full">
                    <div class="flex flex-col items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">자작곡</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-3">
                            <div class="flex w-full ">
                                <div class="flex items-center text-lg">신규 등록</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">신규 콘텐츠</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">비트</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">전체 콘텐츠</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="intro-y col-span-4">
                <div class="box border border-slate-200 zoom-in h-full">
                    <div class="flex flex-col items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">커버곡</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-3">
                            <div class="flex w-full ">
                                <div class="flex items-center text-lg">신규 등록</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">삭제 콘텐츠</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">비트</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">전체 콘텐츠</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="intro-y col-span-4">
                <div class="box border border-slate-200 zoom-in h-full">
                    <div class="flex flex-col items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">일상</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-wrap gap-3">
                            <div class="flex w-full ">
                                <div class="flex items-center text-lg">신규 등록</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">삭제 콘텐츠</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">비트</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex items-center text-lg">전체 콘텐츠</div>
                                <div class="ml-auto text-lg">000 <span class="text-sm">(개)</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <script src="/dist/js/app.js"></script>
        <script src="/dist/js/ckeditor-classic.js"></script>
@endsection
