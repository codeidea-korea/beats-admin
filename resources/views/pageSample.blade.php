@extends('layouts.default')

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


                </form>
                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 명의 관리자가 있습니다.</h2>
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview2" class="btn btn-primary mr-1 mb-2" id="pointOpen">포인트 지급</a>
                    </div>

                </div>


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
                                    <select name="increase" class="form-select w-56" aria-label=".form-select-lg example">
                                        <option value="0">+</option>
                                        <option value="1">-</option>
                                    </select>
                                </td>
                                <td>
                                    <input name="amount" id="regular-form-1" type="text" class="form-control" placeholder="금액 입력">
                                </td>
                                <td>
                                    <input name="reason" id="regular-form-1" type="text" class="form-control" placeholder="사유 입력">
                                </td>
                                <td>
                                    <input name="mem_id" id="regular-form-1" type="text" class="form-control" placeholder="사유 입력" value="{{auth()->user()->name}}" readonly>
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
                                    <select name="point_mem_class" class="form-select w-32" aria-label=".form-select-lg example">
                                        <option value="0">비트썸원</option>
                                        <option value="1">바이비트</option>
                                        <option value="2">통합회원</option>
                                    </select>
                                </div>

                                <div class="flex items-center mr-5">
                                    <span class="mr-2">국적</span>
                                    <select name="point_nationality" class="form-select w-32" aria-label=".form-select-lg example">
                                        <option value="">전체</option>
                                        <option value="kr">한국</option>
                                        <option value="en">미국</option>
                                        <option value="ch">중국</option>
                                        <option value="jp">일본</option>
                                    </select>
                                </div>

                                <div class="flex items-center mr-5">
                                    <span class="mr-2">검색</span>
                                    <input name="point_search_text" id="regular-form-1" type="text" class="form-control w-52" placeholder="검색어 입력">
                                </div>

                                <div class="flex items-center mr-5">
                                    <span class="mr-2">가입일</span>
                                    <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                        <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                        <input name="point_mem_regdate" type="text" class="datepicker form-control sm:w-56 box pl-10" value="">
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
                                <button class="btn btn-primary w-24 ml-2" id="searchPointBtn">검색</button>
                                <button class="btn btn-secondary w-24">초기화</button>
                            </div>

                            <div class="flex justify-between items-center mt-5">
                                <div class="w-full">
                                    <div class="flex flex-col sm:flex-row items-center border-b border-slate-200/60">
                                        <h2 class="font-medium text-base mr-auto text-primary">총 <span id="pointMemCnt">0</span>명의 회원이 있습니다</h2>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th class="whitespace-nowrap text-center bg-primary/10">
                                                    <div class="form-check">
                                                        <input id="checkbox-switch-1" class="form-check-input all_check" type="checkbox" value="">
                                                    </div>
                                                </th>
                                                <th class="whitespace-nowrap text-cente bg-primary/10">서비스</th>
                                                <th class="whitespace-nowrap text-center bg-primary/10">회원 구분</th>
                                                <th class="whitespace-nowrap text-center bg-primary/10">가입 채널</th>
                                            </tr>
                                            </thead>
                                            <tbody id="pointMemList">
                                            <!-- <tr>
                                                <td class="whitespace-nowrap text-center">
                                                    <div class="form-check">
                                                        <input id="checkbox-switch-1" class="form-check-input" type="checkbox" value="">
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap text-center">바이비츠</td>
                                                <td class="whitespace-nowrap text-center">작곡가</td>
                                                <td class="whitespace-nowrap text-center">카카오</td>
                                            </tr> -->
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- 페이징처리 시작 -->
                                    <div id="MemAllPaging">
                                    </div>
                                    <!-- 페이징처리 종료 -->
                                </div>

                                <!-- 가운데 화살표 시작 -->
                                <div class="ml-5 mr-5">
                                    <i data-lucide="fast-forward" id="sendMemMove"></i>
                                    <i data-lucide="rewind" class="mt-5" id="sendMemBackMove"></i>
                                </div>
                                <!-- 가운데 화살표 끝 -->

                                <!-- 오른쪽 테이블 시작 -->
                                <div class="w-full">
                                    <div class="flex flex-col sm:flex-row items-center border-b border-slate-200/60">
                                        <h2 class="font-medium text-base mr-auto text-primary">총 <span id="sendPointMemCnt">0</span>의 회원이 있습니다</h2>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th class="whitespace-nowrap text-center bg-primary/10">
                                                    <div class="form-check">
                                                        <input id="checkbox-switch-1" class="form-check-input all_back_check" type="checkbox" value="">
                                                    </div>
                                                </th>
                                                <th class="whitespace-nowrap text-cente bg-primary/10">서비스</th>
                                                <th class="whitespace-nowrap text-center bg-primary/10">회원 구분</th>
                                                <th class="whitespace-nowrap text-center bg-primary/10">가입 채널</th>
                                            </tr>
                                            </thead>
                                            <tbody id="sendPointMemList">
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- 페이징처리 시작 -->
                                    <div id="sendPointMemPaging">
                                    </div>
                                    <!-- 페이징처리 종료 -->
                                </div>
                                <!-- 오른쪽 테이블 끝 -->
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center mt-5">
                        <button class="btn btn-primary w-32 mr-5 sendPointBtn">설정</button>
                        <button class="btn btn-secondary w-32 modalCancel" data-tw-dismiss="modal">닫기</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>


        function testsubmit(){


            jQuery.ajax({
                cache: false,
                dataType:'json',
                data: {
                    page : page,
                    totalCount : Object.keys(send_member_data).length,
                    functionName : 'pointMemDelete',
                },
                url: '/member/ajax/memberPaging',
                success: function (pagingdata) {
                    if(pagingdata.resultCode=="SUCCESS"){
                        $("#sendPointMemPaging").append(pagingdata.paging);
                    }else{
                        console.log(pagingdata.resultMessage);
                    }
                },
                error: function (e) {
                    console.log('start');
                    console.log(e);
                    //alert('로딩 중 오류가 발생 하였습니다.');
                }
            });
        }


    </script>
@endsection
