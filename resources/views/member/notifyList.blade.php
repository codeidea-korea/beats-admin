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
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">분류</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="class">
                                                <option value=""  @if($params['class'] == "")  selected @endif  >전체</option>
                                                <option value="3" @if($params['class'] == "3") selected @endif >통합회원</option>
                                                <option value="1" @if($params['class'] == "2") selected @endif >임시회원</option>
                                                <option value="2" @if($params['class'] == "1") selected @endif >비트썸원</option>
                                                <option value="0" @if($params['class'] == "0") selected @endif >휴면회원</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">처리상태</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg">
                                                <option>전체</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">신고사유</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg">
                                                <option>전체</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">검색</th>
                                        <td class="whitespace-nowrap" colspan="3">
                                            <input id="regular-form-1" id="sWord" name="sWord" value="{{$params['sWord']}}" type="text">
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">신고일</th>
                                        <td class="whitespace-nowrap" colspan="5">
                                            <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                                <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                                <input type="text" class="datepicker form-control sm:w-56 box pl-10" name="searchDate" id="searchDate" value="{{$params['searchDate']}}">
                                            </div>
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




                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{--number_format($totalCount)--}}0명의 신고 내역이 있습니다.</h2>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">No.</th>
                                    <th class="whitespace-nowrap text-center">서비스</th>
                                    <th class="whitespace-nowrap text-center">신고대상</th>
                                    <th class="whitespace-nowrap text-center">신고자</th>
                                    <th class="whitespace-nowrap text-center">신고 사유</th>

                                    <th class="whitespace-nowrap text-center">콘텐츠 구분</th>
                                    <th class="whitespace-nowrap text-center">처리상태</th>
                                    <th class="whitespace-nowrap text-center">누적 신고</th>
                                    <th class="whitespace-nowrap text-center">신고일</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="whitespace-nowrap text-center"> - </td>
                                    <td class="whitespace-nowrap text-center"> - </td>
                                    <td class="whitespace-nowrap text-center"> - </td>
                                    <td class="whitespace-nowrap text-center"> - </td>
                                    <td class="whitespace-nowrap text-center"> - </td>

                                    <td class="whitespace-nowrap text-center"> - </td>
                                    <td class="whitespace-nowrap text-center"> - </td>
                                    <td class="whitespace-nowrap text-center"> - </td>
                                    <td class="whitespace-nowrap text-center"> - </td>

                                </tr>
                                </tbody>
                            </table>
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
