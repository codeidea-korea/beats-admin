@extends('layouts.Default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">팝업관리</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">

                <form id="searchData" name="searchData" action="/mainmanage/popup/list" method="get">
                    <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                    <div class="intro-y box mt-5">
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-25 text-center">서비스</th>
                                        <td class="">
                                            <select name="popup_type" class="form-select w-60" aria-label=".form-select-lg example">
                                                <option value=''>전체</option>
                                                <option value="bybeats" @if($params['search_type'] == 'bybeats') selected @endif>바이비츠</option>
                                                <option value="beatsomeone" @if($params['search_type'] == 'beatsomeone') selected @endif>비트썸원</option>
                                            </select>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-25 text-center">검색</th>
                                        <td class="">
                                            <div class="relative inline-block w-56">
                                                <input type="text" name="search_text" class="form-control" data-single-mode="true" value="{{$params['fr_search_text']}}">
                                            </div>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-25 text-center">상태</th>
                                        <td class="">
                                            <select name="isuse" class="form-select w-60" aria-label=".form-select-lg example">
                                                <option value=''>전체</option>
                                                <option value="Y" @if($params['search_isuse'] == 'Y') selected @endif>사용</option>
                                                <option value="N" @if($params['search_isuse'] == 'N') selected @endif>미 사용</option>
                                            </select>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-25 text-center">등록일</th>
                                        <td class="">
                                            <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                                <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                                <input name="created_at" type="text" class="datepicker form-control sm:w-56 box pl-10" value="{{$params['search_created_at']}}">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                                <button class="btn btn-primary w-24 ml-2" onclick="$('#searchData').submit();">검색</button>
                                <button class="btn btn-secondary w-24">초기화</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}개의 팝업이 있습니다.</h2>
                        <button class="btn box flex items-center text-slate-600 border border-slate-400" onclick="location.href='/mainmanage/popup/write'">
                            등록
                        </button>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">No.</th>
                                    <th class="whitespace-nowrap text-center">서비스</th>
                                    <th class="whitespace-nowrap text-center">제목</th>
                                    <th class="whitespace-nowrap text-center">상태</th>
                                    <th class="whitespace-nowrap text-center">최근 등록일</th>
                                    <th class="whitespace-nowrap text-center">관리자</th>
                                    <th class="whitespace-nowrap text-center">노출기간</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=0; @endphp
                                @foreach($popupList as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center">{{$totalCount-($i+(($params['page']-1)*10))}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->type}}</td>
                                        <td class="whitespace-nowrap text-center"><a href="/mainmanage/popup/view/{{$rs->idx}}">{{$rs->pp_title}}</a></td>
                                        <td class="whitespace-nowrap text-center">@if($rs->isuse === 'Y') 사용 @else 미 사용 @endif</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->created_at}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->name}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->fr_show_date}} ~ {{$rs->bk_show_date}}</td>
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
@endsection

@section('scripts')
    <script>
        function change(page) {
            $("input[name=page]").val(page);
            $("form[name=searchData]").submit();
        }
    </script>
@endsection

