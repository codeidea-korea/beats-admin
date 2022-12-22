@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">제품 관리</h2>
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
                                        <th class="bg-primary/10 whitespace-nowrap w-12 text-center">노출상태</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-40" aria-label=".form-select-lg" name="group_code">
                                                <option value="">미 선택</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>

                                        <th class="bg-primary/10 whitespace-nowrap w-12 text-center">구분</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-40" aria-label=".form-select-lg" name="group_code">
                                                <option value="">미 선택</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-12 text-center">검색</th>
                                        <td class="whitespace-nowrap">
                                            <input id="regular-form-1" type="text" name="sWord" value="{{--$params['sWord']--}}">
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-12 text-center">등록일</th>
                                        <td class="whitespace-nowrap">
                                            <input type="text" class="datepicker form-control sm:w-45 box pl-10" value="{{$params['searchDate']}}" name="searchDate">
                                        </td>
                                    </tr>
                                </table>
                                <div style="float:right;">
                                    <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/member/memberList';">
                                        초기화
                                    </button>
                                </div>
                                <div style="float:right;">
                                    &nbsp;
                                </div>
                                <div style="float:right;">
                                    <button class="btn box flex items-center text-slate-600 border border-slate-400 formSearchBtn" >
                                        검색
                                    </button>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>



                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}개의 제품이 있습니다.</h2>
                        <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '{{ url('/products/productWrite') }}';">
                            Excel Download
                        </button>
                        <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '{{ url('/products/productWrite') }}';">
                            제품등록
                        </button>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">No.</th>
                                    <th class="whitespace-nowrap text-center">노출 상태</th>
                                    <th class="whitespace-nowrap text-center">구분</th>
                                    <th class="whitespace-nowrap text-center">제품명</th>
                                    <th class="whitespace-nowrap text-center">옵션</th>
                                    <th class="whitespace-nowrap text-center">가격</th>
                                    <th class="whitespace-nowrap text-center">배송비</th>
                                    <th class="whitespace-nowrap text-center">판매수</th>
                                    <th class="whitespace-nowrap text-center">관리자</th>
                                    <th class="whitespace-nowrap text-center">등록일</th>

                                </tr>
                                </thead>
                                <tbody>
                                @php $i=0; @endphp
                                @foreach($productList as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center">{{$totalCount-($i+(($params['page']-1)*10))}}</td>
                                        <td class="whitespace-nowrap text-center"><a href="/products/productView/{{$rs->idx}}">{{$rs->isDisplayView}}</a></td>
                                        <td class="whitespace-nowrap text-center"> - </td>
                                        <td class="whitespace-nowrap text-center"><a href="/products/productView/{{$rs->idx}}">{{$rs->name}}</a></td>
                                        <td class="whitespace-nowrap text-center">{{$rs->optionCnt}}</td>
                                        <td class="whitespace-nowrap text-center">{{number_format($rs->price)}}원</td>
                                        <td class="whitespace-nowrap text-center">{{number_format($rs->delivery_charge)}}원</td>
                                        <td class="whitespace-nowrap text-center"> - </td>
                                        <td class="whitespace-nowrap text-center">{{$rs->admin_name}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->create_date}}</td>
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
            document.forms["searchData"].submit();
        }
    </script>
@endsection
