@extends('layouts.Default')
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
                    <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                    <div class="intro-y box">
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-32 text-center">그룹</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-60" aria-label=".form-select-lg example">
                                                <option>미 선택</option>
                                                <option>선택1</option>
                                                <option>선택2</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>

                                        <th class="bg-primary/10 whitespace-nowrap w-32 text-center">등록일</th>
                                        <td class="whitespace-nowrap">
                                            <input type="text" class="datepicker form-control pl-12" data-single-mode="true">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-32 text-center">상태</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-60" aria-label=".form-select-lg example">
                                                <option>미 선택</option>
                                                <option>선택1</option>
                                                <option>선택2</option>
                                            </select>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-32 text-center">검색</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-60" aria-label=".form-select-lg example">
                                                <option>미 선택</option>
                                                <option>선택1</option>
                                                <option>선택2</option>
                                            </select>
                                            <input id="regular-form-1" type="text"  placeholder="Input text">
                                            <button class="btn box  text-slate-600 border border-slate-400">
                                                검색
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>



                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}명의 관리자가 있습니다.</h2>
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
                                    <th class="whitespace-nowrap text-center">그룹</th>
                                    <th class="whitespace-nowrap text-center">이름</th>
                                    <th class="whitespace-nowrap text-center">연락처</th>
                                    <th class="whitespace-nowrap text-center">E-mail</th>
                                    <th class="whitespace-nowrap text-center">상태</th>
                                    <th class="whitespace-nowrap text-center">등록일</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=0; @endphp
                                @foreach($adminList as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center">{{$totalCount-($i+(($params['page']-1)*10))}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->group_name}}</td>
                                        <td class="whitespace-nowrap text-center"><a href="/admin/view?idx={{$rs->idx}}">{{$rs->name}}</a></td>
                                        <td class="whitespace-nowrap text-center">@if($rs->phoneno==null) 000-0000-0000 @else {{$rs->phoneno}} @endif</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->email}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->isuse}}</td>
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
            $("form[name=searchData]").submit();
        }
    </script>
@endsection
