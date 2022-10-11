@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">약관 관리</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">

                <form id="searchData" name="searchData" action="/service/terms/list" method="get">
                    <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                    <div class="intro-y box mt-5">
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-25 text-center">구분</th>
                                        <td class="">
                                            <select id="gubun" name="gubun" class="form-select w-25" aria-label=".form-select-lg example">
                                                <option value=''>전체</option>
                                                @foreach($gubun as $rs)
                                                    <option value="{{$rs->codename}}" @if($params['search_gubun'] == $rs->codename) selected @endif>{{$rs->codevalue}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-25 text-center">약관 종류</th>
                                        <td class="">
                                            <select id="terms_type" name="terms_type" class="form-select w-25" aria-label=".form-select-lg example">
                                                <option value=''>전체</option>
                                                @foreach($terms_type as $rs)
                                                    <option value="{{$rs->codename}}" @if($params['search_terms_type'] == $rs->codename) selected @endif>{{$rs->codevalue}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-25 text-center">검색</th>
                                        <td class="">
                                            <div class="relative inline-block w-56">
                                                <input type="text" name="search_text" class="form-control" data-single-mode="true" value="{{$params['fr_search_text']}}">
                                            </div>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-25 text-center">적용일자</th>
                                        <td class="">
                                            <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                                <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                                <input name="created_at" type="text" class="datepicker form-control sm:w-56 box pl-10" value="{{$params['search_apply_date']}}">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                                <button class="btn btn-primary w-24 ml-2" onclick="$('#searchData').submit();">검색</button>
                                <div class="btn btn-secondary w-24 ml-5" onClick="javascript:location.href = '/service/terms/list';">초기화</div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}개의 약관이 있습니다.</h2>
                        <button class="btn box flex items-center text-slate-600 border border-slate-400" onclick="location.href='/service/terms/write'">
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
                                    <th class="whitespace-nowrap text-center">약관 종류</th>
                                    <th class="whitespace-nowrap text-center">버전</th>
                                    <th class="whitespace-nowrap text-center">관리자</th>
                                    <th class="whitespace-nowrap text-center">적용날짜</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=0; @endphp
                                @foreach($termsData as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center">{{$totalCount-($i+(($params['page']-1)*10))}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->gubun}}</td>
                                        <td class="whitespace-nowrap text-center"><a href="/service/terms/view/{{$rs->idx}}">{{$rs->terms_type}}</a></td>
                                        <td class="whitespace-nowrap text-center">{{$rs->version}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->name}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->apply_date}}</td>
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

    var ajax_checked = false;

    $(document).on('change','#gubun',function(){

        $("#terms_type option").remove();

        jQuery.ajax({
            cache: false,
            dataType:'json',
            data: {
                gubun : $(this).val()
            },
            url: '/service/terms/termstype',
            success: function (data) {
                data.forEach(function(item,index) {

                    var dom = document.createElement('option');
                    dom.value = item.codename;
                    dom.text = item.codevalue;

                    $("#terms_type").append(dom);
                });
            },
            error: function (e) {
                console.log('start');
                console.log(e);
                //alert('로딩 중 오류가 발생 하였습니다.');
            }
        });
    });
</script>

@endsection

@section('scripts')
    <script>
        function change(page) {
            $("input[name=page]").val(page);
            $("form[name=searchData]").submit();
        }
    </script>
@endsection

