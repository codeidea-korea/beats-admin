@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">피드</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">
                    <div id="boxed-tab" class="p-5">
                        <div class="preview">
                            <ul class="nav nav-boxed-tabs" role="tablist">

                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab" onClick="javascript:location.href = '/contents/feedView/{{$idx}}';">기본 정보</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2 active" type="button" role="tab" onClick="javascript:location.href = '/contents/feedBeatView/{{$idx}}';">비트 내역</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab" onClick="javascript:location.href = '/contents/feedCommentView/{{$idx}}';">댓글 내역</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" onClick="alert('서비스 준비중입니다.');">신고 내역</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <form name="searchForm"  id="searchForm" action="" method="get">
                                <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">국적</th>
                                        <td class="whitespace-nowrap">
                                            <select name="nationality" class="form-select w-13" aria-label=".form-select-lg">
                                                <option value=''>전체</option>
                                                <option value="kr" @if($params['search_nationality'] == 'kr') selected @endif>한국</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-25 text-center">등록일</th>
                                        <td class="">
                                            <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                                <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                                <input name="created_at" type="text" class="datepicker form-control sm:w-56 box pl-10" value="{{$params['created_at']}}">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">검색</th>
                                        <td class="whitespace-nowrap" colspan="7">
                                            <input id="regular-form-1" name="search_text" value="{{$params['fr_search_text']}}" type="text">
                                        </td>

                                    </tr>
                                </table>
                            </form>
                            <div style="float:right;">
                                <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/contents/feedBeatView/{{$idx}}';">
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
                            <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}개의 비트가 있습니다.</h2>
                        </div>
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="table table-bordered table-hover table-auto">
                                    <thead>
                                    <tr>
                                        <th class="whitespace-nowrap text-center">No.</th>
                                        <th class="whitespace-nowrap text-center">국적</th>
                                        <th class="whitespace-nowrap text-center">고유 ID</th>
                                        <th class="whitespace-nowrap text-center">닉네임</th>
                                        <th class="whitespace-nowrap text-center">등록일</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=0; @endphp
                                    @foreach($feedBeatData as $rs)
                                        <tr>
                                            <td class="whitespace-nowrap text-center">{{$totalCount-($i+(($params['page']-1)*10))}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->nationality}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->u_id}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->mem_nickname}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->create_date}}</td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
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
