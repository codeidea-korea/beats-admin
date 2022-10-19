@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">이벤트</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">

                <form id="searchData" name="searchData" action="/service/event/list" method="get">
                    <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                    <div class="intro-y box mt-5">
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap text-center">구분</th>
                                        <td class="whitespace-nowrap">
                                            <select name="duration_status" class="form-select" aria-label=".form-select-lg example">
                                                <option value=''>전체</option>
                                                <option value="Y" @if($params['search_duration_status'] == 'Y') selected @endif>진행 중</option>
                                                <option value="N" @if($params['search_duration_status'] == 'N') selected @endif>종료</option>
                                            </select>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap text-center">검색</th>
                                        <td class="whitespace-nowrap">
                                            <div class="relative inline-block">
                                                <input type="text" name="search_text" class="form-control" data-single-mode="true" value="{{$params['fr_search_text']}}">
                                            </div>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap text-center">노출 여부</th>
                                        <td class="whitespace-nowrap">
                                            <select name="open_status" class="form-select" aria-label=".form-select-lg example">
                                                <option value=''>전체</option>
                                                <option value="Y" @if($params['search_open_status'] == 'Y') selected @endif>노출</option>
                                                <option value="N" @if($params['search_open_status'] == 'N') selected @endif>미 노출</option>
                                            </select>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap text-center">등록일</th>
                                        <td class="whitespace-nowrap">
                                            <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                                <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                                <input name="created_at" type="text" class="datepicker form-control sm:w-56 box pl-10" value="{{$params['created_at']}}">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                                <button class="btn btn-primary w-24 ml-2" onclick="$('#searchData').submit();">검색</button>
                                <div class="btn btn-secondary w-24 ml-5" onClick="javascript:location.href = '/service/event/list';">초기화</div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}개의 이벤트가 있습니다.</h2>
                        <button class="btn box flex items-center text-slate-600 border border-slate-400" onclick="location.href='/service/event/write'">
                            등록
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
                                    <th class="whitespace-nowrap text-center">운영 기간</th>
                                    <th class="whitespace-nowrap text-center">관리자</th>
                                    <th class="whitespace-nowrap text-center">노출 여부</th>
                                    <th class="whitespace-nowrap text-center">등록일</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=0; @endphp
                                @foreach($eventData as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center">{{$totalCount-($i+(($params['page']-1)*10))}}</td>
                                        <td class="whitespace-nowrap text-center">@if($rs->gubun === 1) 진행중 @elseif($rs->gubun === 2) 종료 @else 대기중 @endif</td>
                                        <td class="whitespace-nowrap text-center"><a href="/service/event/view/{{$rs->idx}}">{{$rs->title}}</a></td>
                                        <td class="whitespace-nowrap text-center">{{$rs->fr_event_date}} ~ {{$rs->bk_event_date}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->name}}</td>
                                        <td class="whitespace-nowrap text-center">@if($rs->open_status === 'Y') 노출 @else 미 노출 @endif</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->created_at}}</td>
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
    <script>
        function change(page) {
            $("input[name=page]").val(page);
            $("form[name=searchData]")[0].submit();
        }
    </script>
@endsection
