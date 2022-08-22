@extends('layouts.Default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">배너 관리</h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-12">

            <div class="intro-y box">

                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                    <h2 class="font-medium text-base mr-auto">배너 상세</h2>
                </div>

                <div class="p-5">
                    <div class="overflow-x-auto">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">서비스</th>
                                <td colspan="3" class="whitespace-nowrap">
                                    <span>{{$bannerData[0]->type}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">구분</th>
                                <td colspan="3" class="whitespace-nowrap">
                                    <span>{{$bannerData[0]->banner_name}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">하위 컨텐츠</th>
                                <td colspan="3" class="whitespace-nowrap">
                                    <span>{{$bannerData[0]->downcontents}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최근 수정일자</th>
                                <td colspan="3" class="whitespace-nowrap">
                                    <span>{{$bannerData[0]->created_at}}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
            <form name="searchData" action="" method="get">
                <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                <div class="intro-y box mt-5">
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">구분</th>
                                    <td class="">
                                        <select class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="">전체</option>
                                            <option value="notice">공지사항</option>
                                            <option value="event">이벤트</option>
                                            <option value="url">URL 등록</option>
                                        </select>
                                    </td>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">검색</th>
                                    <td class="">
                                        <div class="relative inline-block w-56">
                                            <input type="text" name="search_text" class="form-control" data-single-mode="true">
                                        </div>
                                    </td>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">등록일</th>
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
            </form>

            <div class="intro-y box mt-5">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                    <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}개의 컨텐츠가 있습니다.</h2>
                    <button class="btn box flex items-center text-slate-600 border border-slate-400 mr-2" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview">
                        등록
                    </button>
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
                                    <th class="whitespace-nowrap text-center">구분</th>
                                    <th class="whitespace-nowrap text-center">제목</th>
                                    <th class="whitespace-nowrap text-center">상태</th>
                                    <th class="whitespace-nowrap text-center">등록일</th>
                                    <th class="whitespace-nowrap text-center">순서</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=0; @endphp
                                @foreach($bannerDataList as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center">{{$totalCount-($i+(($params['page']-1)*10))}}</td>
                                        <td class="whitespace-nowrap text-center">@if($rs->contents === 'notice') 공지사항 @elseif($rs->contents === 'event') 이벤트 @else URL 등록 @endif</td>
                                        <td class="whitespace-nowrap text-center"><a href="">{{$rs->br_title}}</a></td>
                                        <td class="whitespace-nowrap text-center">@if($rs->isuse === "Y") 사용 @else 미 사용 @endif</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->created_at}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->br_seq}}</td>
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

    <!-- 등록 모달 시작 -->
    <div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-2xl">
            <div class="modal-content">
                <div class="modal-body p-10 text-center">

                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">컨텐츠 등록</h2>
                    </div>

                    <div class="overflow-x-auto">
                    <table class="table table-bordered">
                        <tr>
                            <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">제목</th>
                        </tr>
                        <tr>
                            <td>
                                <input id="regular-form-1" type="text" class="form-control" placeholder="제목을 입력해주세요.">
                            </td>
                        </tr>
                        <tr>
                            <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">컨텐츠 구분</th>
                        </tr>
                        <tr>
                            <td>
                                <select name="contents" class="form-select w-56" aria-label=".form-select-lg example">
                                    <option value="">선택</option>
                                    <option value="notice">공지사항</option>
                                    <option value="event">이벤트</option>
                                    <option value="url">URL 등록</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">연결 컨텐츠</th>
                        </tr>
                        <tr>
                            <td>
                                <input name="contents_url"id="regular-form-1" type="text" class="form-control" placeholder="연결할 컨텐츠를 입력해주세요.">
                            </td>
                        </tr>
                        <tr>
                            <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">배너 이미지</th>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" name="banner_img">
                            </td>
                        </tr>
                        <tr>
                            <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">상태</th>
                        </tr>
                        <tr>
                            <td>
                                <select name="isuse" class="form-select w-56" aria-label=".form-select-lg example">
                                    <option value="Y">사용</option>
                                    <option value="N">미 사용</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    </div>

                    <div class="flex items-center justify-center mt-5">
                        <button class="btn btn-primary w-32 ml-2 mr-2">등록</button>
                        <button class="btn btn-secondary w-32" data-tw-dismiss="modal">닫기</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 등록 모달 끝 -->
@endsection

@section('scripts')
    <script>
        function change(page) {
            $("input[name=page]").val(page);
            $("form[name=searchData]").submit();
        }
    </script>
@endsection

