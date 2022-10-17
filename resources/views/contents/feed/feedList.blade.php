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
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <form name="searchForm"  id="searchForm" action="" method="get">
                                <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">노출 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select name="wr_open" class="form-select w-13" aria-label=".form-select-lg">
                                                <option>전체</option>
                                                <option value="open" @if($params['search_wr_open'] == 'open') selected @endif>노출</option>
                                                <option value="secret" @if($params['search_wr_open'] == 'secret') selected @endif>비 노출</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">구분</th>
                                        <td class="whitespace-nowrap">
                                            <select name="wr_type" class="form-select w-13" aria-label=".form-select-lg">
                                                <option>전체</option>
                                                <option value="daliy" @if($params['search_wr_type'] == 'daliy') selected @endif>일상</option>
                                                <option value="cover" @if($params['search_wr_type'] == 'cover') selected @endif>커버곡</option>
                                                <option value="self" @if($params['search_wr_type'] == 'self') selected @endif>자작곡</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">언어</th>
                                        <td class="whitespace-nowrap">
                                            <select name="wr_lng" class="form-select w-13" aria-label=".form-select-lg">
                                                <option>전체</option>
                                                <option value="kr" @if($params['search_wr_lng'] == 'kr') selected @endif>한국어</option>
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
                            <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}개의 피드가 있습니다.</h2>
                        </div>
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="table table-bordered table-hover table-auto">
                                    <thead>
                                    <tr>
                                        <th class="whitespace-nowrap text-center">No.</th>
                                        <th class="whitespace-nowrap text-center">노출 상태</th>
                                        <th class="whitespace-nowrap text-center">구분</th>
                                        <th class="whitespace-nowrap text-center">제목</th>
                                        <th class="whitespace-nowrap text-center">고유 ID</th>
                                        <th class="whitespace-nowrap text-center">언어</th>
                                        <th class="whitespace-nowrap text-center">음원 수</th>
                                        <th class="whitespace-nowrap text-center">비트 수</th>
                                        <th class="whitespace-nowrap text-center">댓글 수</th>
                                        <th class="whitespace-nowrap text-center">신고</th>
                                        <th class="whitespace-nowrap text-center">등록일</th>
                                        <th class="whitespace-nowrap text-center">최근 수정일</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=0; @endphp
                                    @foreach($feedList as $rs)
                                        <tr>
                                            <td class="whitespace-nowrap text-center">{{$totalCount-($i+(($params['page']-1)*10))}}</td>
                                            <td class="whitespace-nowrap text-center">@if($rs->wr_open == 'open') 노출 @else 비 노출 @endif</td>
                                            <td class="whitespace-nowrap text-center">@if($rs->wr_type == 'daily') 일상 @elseif($rs->wr_type == 'cover') 커버곡 @else 자작곡 @endif</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->wr_title}}</td>
                                            <td class="whitespace-nowrap text-center"><a href="/contents/feedView/{{$rs->idx}}">{{$rs->email_id}}</a></td>
                                            <td class="whitespace-nowrap text-center">{{$rs->wr_lng}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->wr_file}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->wr_bit}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->wr_comment}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->wr_report}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->created_at}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->updated_at}}</td>
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
