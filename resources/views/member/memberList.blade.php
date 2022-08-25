`@extends('layouts.Default')
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

                <form name="searchData" action="" method="get">
                    <input type="hidden" name="page" value="{{-- $searchData['page'] 64 --}}">
                    <div class="intro-y box">
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">분류</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg example">
                                                <option>전체</option>
                                                <option>통합회원</option>
                                                <option>임시회원</option>
                                                <option>비트썸원</option>
                                                <option>휴면회원</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">회원 구분</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg example">
                                                <option>전체</option>
                                                <option>일반</option>
                                                <option>작곡가</option>
                                                <option>멘토 뮤지션</option>
                                                <option>음원 구매자</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">가입 채널</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg example">
                                                <option>전체</option>
                                                <option>페이스북</option>
                                                <option>트위터</option>
                                                <option>구글</option>
                                                <option>애플</option>
                                                <option>네이버</option>
                                                <option>카카오</option>
                                                <option>사운드클라우드</option>
                                                <option>직접가입</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">국적</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg example">
                                                <option>전체</option>
                                                <option>한국</option>
                                                <option>미국</option>
                                                <option>중국</option>
                                                <option>일본</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">상태</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg example">
                                                <option>전체</option>
                                                <option>임시</option>
                                                <option>정상</option>
                                                <option>제재</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">검색</th>
                                        <td class="whitespace-nowrap" colspan="3">
                                            <input id="regular-form-1" type="text"  placeholder="Input text">
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">가입일</th>
                                        <td class="whitespace-nowrap" colspan="5">
                                            <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                                <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                                <input type="text" class="datepicker form-control sm:w-56 box pl-10">
                                            </div>
                                        </td>

                                    </tr>
                                </table>
                                <div style="float:right;">
                                    <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/admin/write';">
                                        검색
                                    </button>
                                </div>
                                <div style="float:right;">
                                    &nbsp;
                                </div>
                                <div style="float:right;">
                                    <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/admin/write';">
                                        초기화
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{--number_format($totalCount----}}명의 관리자가 있습니다.</h2>
                        <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/admin/write';">
                            등록
                        </button>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">No.</th>
                                    <th class="whitespace-nowrap text-center">분류</th>
                                    <th class="whitespace-nowrap text-center">회원 구분</th>
                                    <th class="whitespace-nowrap text-center">가입 채널</th>
                                    <th class="whitespace-nowrap text-center">국적</th>

                                    <th class="whitespace-nowrap text-center">고유 ID</th>
                                    <th class="whitespace-nowrap text-center">닉네임</th>
                                    <th class="whitespace-nowrap text-center">제재</th>
                                    <th class="whitespace-nowrap text-center">상태</th>
                                    <th class="whitespace-nowrap text-center">가입일</th>

                                    <th class="whitespace-nowrap text-center">최근 접속일</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="whitespace-nowrap text-center">{{--$totalCount-($i+(($params['page']-1)*10))--}}</td>
                                        <td class="whitespace-nowrap text-center">{{--$rs->group_name--}}</td>
                                        <td class="whitespace-nowrap text-center"><a href="/admin/view?idx={{--$rs->idx--}}">{{--$rs->name--}}</a></td>
                                        <td class="whitespace-nowrap text-center">{{--@if($rs->phoneno==null) 000-0000-0000 @else {{$rs->phoneno}} @endif--}}</td>
                                        <td class="whitespace-nowrap text-center">{{--$rs->email--}}</td>

                                        <td class="whitespace-nowrap text-center">{{--$rs->isuse--}}</td>
                                        <td class="whitespace-nowrap text-center">{{--$rs->created_at--}}</td>
                                        <td class="whitespace-nowrap text-center">{{--$rs->isuse--}}</td>
                                        <td class="whitespace-nowrap text-center">{{--$rs->created_at--}}</td>
                                        <td class="whitespace-nowrap text-center">{{--$rs->isuse--}}</td>

                                        <td class="whitespace-nowrap text-center">{{--$rs->created_at--}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 페이징처리 시작 -->
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-5">
                    <nav class="w-full">

                        {{--@include('vendor.pagination.default')--}}

                    </nav>
                </div>
                <!-- 페이징처리 종료 -->
            </div>

        </div>

    </div>

    <script>
        function change(page) {
            $("input[name=page]").val(page);
            $("form[name=searchData]").submit();
        }
    </script>
@endsection
`
