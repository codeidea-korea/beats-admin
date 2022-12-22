@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">제품리뷰</h2>
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
                                                <option value="">전체</option>
                                                <option value="open" @if($params['search_wr_open'] == 'open') selected @endif>노출</option>
                                                <option value="secret" @if($params['search_wr_open'] == 'secret') selected @endif>비 노출</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">별점</th>
                                        <td class="whitespace-nowrap">
                                            <select name="grade" class="form-select w-13" aria-label=".form-select-lg">
                                                <option value="">전체</option>
                                                <option value="0" @if($params['search_grade'] == '0') selected @endif>0</option>
                                                <option value="0.5" @if($params['search_grade'] == '0.5') selected @endif>0.5</option>
                                                <option value="1" @if($params['search_grade'] == '1') selected @endif>1</option>
                                                <option value="1.5" @if($params['search_grade'] == '1.5') selected @endif>1.5</option>
                                                <option value="2" @if($params['search_grade'] == '2') selected @endif>2</option>
                                                <option value="2.5" @if($params['search_grade'] == '2.5') selected @endif>2.5</option>
                                                <option value="3" @if($params['search_grade'] == '3') selected @endif>3</option>
                                                <option value="3.5" @if($params['search_grade'] == '3.5') selected @endif>3.5</option>
                                                <option value="4" @if($params['search_grade'] == '4') selected @endif>4</option>
                                                <option value="4.5" @if($params['search_grade'] == '4.5') selected @endif>4.5</option>
                                                <option value="5" @if($params['search_grade'] == '5') selected @endif>5</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">제품 지정</th>
                                        <td class="whitespace-nowrap">
                                            <select name="wr_product" class="form-select w-13" aria-label=".form-select-lg">
                                                <option value="">전체</option>
                                                <option value="Y" @if($params['search_wr_product'] == 'Y') selected @endif>지정</option>
                                                <option value="N" @if($params['search_wr_product'] == 'N') selected @endif>미 지정</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">언어</th>
                                        <td class="whitespace-nowrap">
                                            <select name="wr_lng" class="form-select w-13" aria-label=".form-select-lg">
                                                <option value="">전체</option>
                                                <option value="한국어" @if($params['search_wr_lng'] == 'kr') selected @endif>한국어</option>
                                                <option value="English" @if($params['search_wr_lng'] == 'kr') selected @endif>English</option>
                                                <option value="日本" @if($params['search_wr_lng'] == 'kr') selected @endif>日本</option>
                                                <option value="中文" @if($params['search_wr_lng'] == 'kr') selected @endif>中文</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">검색</th>
                                        <td class="whitespace-nowrap" colspan="5">
                                            <input id="regular-form-1" name="search_text" value="{{$params['fr_search_text']}}" type="text">
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-25 text-center">등록일</th>
                                        <td class="">
                                            <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                                <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                                <input name="created_at" type="text" class="datepicker form-control sm:w-56 box pl-10" value="{{$params['created_at']}}">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <div style="float:right;">
                                <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/contents/feedList';">
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
                                        <th class="whitespace-nowrap text-center">별점</th>
                                        <th class="whitespace-nowrap text-center">내용</th>
                                        <th class="whitespace-nowrap text-center">제품명</th>
                                        <th class="whitespace-nowrap text-center">제품 지정</th>
                                        <th class="whitespace-nowrap text-center">고유 ID</th>
                                        <th class="whitespace-nowrap text-center">언어</th>
                                        <th class="whitespace-nowrap text-center">비트 수</th>
                                        <th class="whitespace-nowrap text-center">댓글 수</th>
                                        <th class="whitespace-nowrap text-center">등록일</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=0; @endphp
                                    @foreach($reviewList as $rs)
                                        <tr>
                                            <td class="whitespace-nowrap text-center">{{$totalCount-($i+(($params['page']-1)*10))}}</td>
                                            <td class="whitespace-nowrap text-center">@if($rs->wr_open == 'open') 노출 @else 비 노출 @endif</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->grade}}</td>
                                            <td class="whitespace-nowrap text-center"><a href="/contents/reviewView/{{$rs->idx}}">{{$rs->wr_content}}</a></td>
                                            <td class="whitespace-nowrap text-center">{{$rs->wr_title}}</td>
                                            <td class="whitespace-nowrap text-center">@if($rs->product_idx == 0) 미 지정 @else 지정 @endif</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->u_id}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->wr_lng}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->wr_bit}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->wr_comment}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->created_at}}</td>
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
