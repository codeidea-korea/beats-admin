@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">전환신청</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">

                <div class="intro-y box">
                    <div id="boxed-tab" class="p-5">
                        <div class="preview">
                            <ul class="nav nav-boxed-tabs" role="tablist">
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2 " type="button" role="tab" onClick="javascript:location.href = '{{ url('/mento/mentoList') }}';">전환 신청</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2 active" type="button" role="tab" onClick="javascript:location.href = '{{ url('/mento/mentoChLog') }}';">반려 내역</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <form name="searchForm" id="searchForm" class="form-horizontal" role="form"  method="get" action="">
                    <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                </form>

                <div class="intro-y box mt-5">
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">No.</th>
                                    <th class="whitespace-nowrap text-center">상태</th>
                                    <th class="whitespace-nowrap text-center">서비스</th>
                                    <th class="whitespace-nowrap text-center">회원 구분</th>
                                    <th class="whitespace-nowrap text-center">이메일 ID</th>
                                    <th class="whitespace-nowrap text-center">닉네임</th>
                                    <th class="whitespace-nowrap text-center">핸드폰 번호</th>
                                    <th class="whitespace-nowrap text-center">제재</th>
                                    <th class="whitespace-nowrap text-center">반려일</th>
                                </tr>
                                </thead>
                                <tbody>


                                @php $i=0; @endphp
                                @foreach($memberList as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center">{{$totalCount-($i+(($params['page']-1)*10))}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->mentoStValue}}</td>
                                        <td class="whitespace-nowrap text-center">바이비츠</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->gubunValue}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->email_id}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->mem_nickname}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->phone_number}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->mem_sanctions}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->crdate}}</td>
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
            document.forms["searchForm"].submit();
        }
    </script>
@endsection
