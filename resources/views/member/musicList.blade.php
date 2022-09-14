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
                <form name="searchForm" id="searchForm" class="form-horizontal" role="form"   method="get" action="{{ url('/member/musicList') }}">

                    <input type="hidden" name="page" value="{{$searchData['page']}}">
                    <div class="intro-y box">
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">음원 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="class">
                                                <option value="">전체</option>
                                                <option value="Y">작업 중</option>
                                                <option value="N">최종본</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">작업 방식</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="gubun">
                                                <option value="">전체</option>
                                                <option value="Y">개인 작업</option>
                                                <option value="N">공동 작업</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">판매 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="channel">
                                                <option value="">전체</option>
                                                <option value="Y">판매중</option>
                                                <option value="N">미 판매중</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">공개 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="nationality">
                                                <option value="">전체</option>
                                                <option value="Y">공개</option>
                                                <option value="N">비 공개</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">검색</th>
                                        <td class="whitespace-nowrap" colspan="7">
                                            <input id="regular-form-1" type="text">
                                        </td>
                                    </tr>
                                </table>
                                <div style="float:right;">
                                    <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/admin/write';">
                                        초기화
                                    </button>
                                </div>
                                <div style="float:right;">
                                    &nbsp;
                                </div>
                                <div style="float:right;">
                                    <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/admin/write';">
                                        검색
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}개의 음원이 있습니다.</h2>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">제목</th>
                                    <th class="whitespace-nowrap text-center">작업 방식</th>
                                    <th class="whitespace-nowrap text-center">작업 진행률</th>
                                    <th class="whitespace-nowrap text-center">재생 시간</th>
                                    <th class="whitespace-nowrap text-center">판매 상태</th>
                                    <th class="whitespace-nowrap text-center">공개 상태</th>
                                    <th class="whitespace-nowrap text-center">태그</th>
                                    <th class="whitespace-nowrap text-center">최근 수정일</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=0; @endphp
                                @foreach($musicList as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center">{{$rs->music_title}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->common_composition}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->progress_rate}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->play_time}}</td>

                                        <td class="whitespace-nowrap text-center">{{$rs->sales_status}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->open_status}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->mem_sanctions}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->tag}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->moddate}}</td>
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
        $(function (){
            //$('#superlarge-modal-size-preview2').modal({ keyboard: false, backdrop: 'static' })
        })
    </script>
@endsection
