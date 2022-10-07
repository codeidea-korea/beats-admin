@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">신고 내역</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">


                <div class="intro-y box">
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <form name="searchForm"  id="searchForm" action="" method="get">
                                <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                                <table class="table table-bordered">
                                    <tr>

                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">음원 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg">
                                                <option>전체</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">작업 방식</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg">
                                                <option>전체</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">판매 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg">
                                                <option>전체</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">공개 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg">
                                                <option>전체</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">검색</th>
                                        <td class="whitespace-nowrap" colspan="7">
                                            <input id="regular-form-1" id="sWord" name="sWord" value="{{$params['sWord']}}" type="text">
                                        </td>

                                    </tr>
                                </table>
                            </form>
                            <div style="float:right;">
                                <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/member/notiflyList';">
                                    초기화
                                </button>
                            </div>
                            <div style="float:right;">
                                &nbsp;
                            </div>
                            <div style="float:right;">
                                <button class="btn box flex items-center text-slate-600 border border-slate-400 formSearchBtn">
                                    검색
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="intro-y col-span-12 lg:col-span-12">
                    <div class="intro-y box">
                        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                            <h2 class="font-medium text-base mr-auto text-primary">총 000개의 음원이 있습니다.</h2>
                        </div>
                        <div class="p-2 bg-slate-200 flex flex-wrap gap-3">

                            <div class="intro-x box p-5">
                                <div class="w-full items-center flex gap-5">
                                    <div class="w-16 pl-5">
                                        <img src="/dist/images/play.svg" alt="">
                                    </div>
                                    <script src="https://unpkg.com/wavesurfer.js"></script>
                                    <div class="grow px-5">
                                        <div class="font-medium text-lg">사용자가 입력한 곡 제목 표기</div>
                                        <div class="text-slate-400 mt-1"> <span class="font-bold">최근 수정일 :</span>2022. 03. 17</div>
                                        <div class="text-slate-400 flex items-center mt-1">
                                            <i data-lucide="circle" class="w-4 h-4 mr-1"></i>
                                            47
                                        </div>
                                        <div class="font-medium text-lg" id="waveform"></div>
                                    </div>

                                    <audio controls  src="/music/Blueming.mp3">

                                    </audio>
                                    <div class="border-l flex gap-3 px-5">
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">작업 방식</div>
                                            <div class="btn-warning p-1 rounded-md">개인 작업</div>
                                        </div>
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">작업 진행률</div>
                                            <div class="btn-warning p-1 rounded-md">40%</div>
                                        </div>
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">재생 시간</div>
                                            <div class="btn-warning p-1 rounded-md">4:17</div>
                                        </div>
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">판매 상태</div>
                                            <div class="btn-secondary p-1 rounded-md">미 판매</div>
                                        </div>
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">공개 상태</div>
                                            <div class="btn-secondary p-1 rounded-md">비공개</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="border border-slate-300 rounde-md border-dashed p-2 rounded-md flex flex-wrap gap-3">
                                        <div data-theme="light" class="btn btn-secondary py-1 px-2">
                                            #태그1
                                        </div>
                                        <div data-theme="light" class="btn btn-secondary py-1 px-2">
                                            #태그2
                                        </div>
                                        <div data-theme="light" class="btn btn-secondary py-1 px-2">
                                            #태그1 Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                        </div>
                                        <div data-theme="light" class="btn btn-secondary py-1 px-2">
                                            #태그1 Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                        </div>
                                        <div data-theme="light" class="btn btn-secondary py-1 px-2">
                                            #태그1 Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="intro-x box p-5">
                                <div class="w-full items-center flex gap-5">
                                    <div class="grow px-5">
                                        <div class="font-medium text-lg">사용자가 입력한 곡 제목 표기</div>
                                        <div class="text-slate-400 mt-1"> <span class="font-bold">최근 수정일 :</span>2022. 03. 17</div>
                                        <div class="text-slate-400 flex items-center mt-1">
                                            <i data-lucide="circle" class="w-4 h-4 mr-1"></i>
                                            47
                                        </div>
                                    </div>
                                    <div class="border-l flex gap-3 px-5">
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">작업 방식</div>
                                            <div class="btn-warning p-1 rounded-md">개인 작업</div>
                                        </div>
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">작업 진행률</div>
                                            <div class="btn-warning p-1 rounded-md">40%</div>
                                        </div>
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">재생 시간</div>
                                            <div class="btn-warning p-1 rounded-md">4:17</div>
                                        </div>
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">판매 상태</div>
                                            <div class=" btn-primary p-1 rounded-md">판매</div>
                                        </div>
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">공개 상태</div>
                                            <div class="btn-primary p-1 rounded-md">공개</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="border border-slate-300 rounde-md border-dashed p-2 rounded-md flex flex-wrap gap-3">
                                        <div data-theme="light" class="btn btn-secondary py-1 px-2">
                                            #태그1
                                        </div>
                                        <div data-theme="light" class="btn btn-secondary py-1 px-2">
                                            #태그2
                                        </div>
                                        <div data-theme="light" class="btn btn-secondary py-1 px-2">
                                            #태그1 Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                        </div>
                                        <div data-theme="light" class="btn btn-secondary py-1 px-2">
                                            #태그1 Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                        </div>
                                        <div data-theme="light" class="btn btn-secondary py-1 px-2">
                                            #태그1 Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex box justify-between w-full p-5">
                                <div>
                                    <button class="btn btn-dark w-24">목록</button>
                                </div>
                                <div>
                                    <button class="btn btn-secondary w-24">삭제</button>
                                    <button class="btn btn-primary w-24 ml-2">수정</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 페이징처리 시작 -->
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-5">
                    <nav class="w-full">
                        {{-- @include('vendor.pagination.default') --}}
                    </nav>
                </div>
                <!-- 페이징처리 종료 -->
            </div>

        </div>

    </div>

    <script>
        $(".formSearchBtn").on('click', function(){
            document.forms["searchForm"].submit();
        });
        function change(page) {
            $("input[name=page]").val(page);
            document.forms["searchForm"].submit();
        }

    </script>
@endsection
