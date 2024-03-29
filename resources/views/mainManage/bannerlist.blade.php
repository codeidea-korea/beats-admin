@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="mt-5">
            <form id="searchData" name="searchData" action="/mainmanage/banner/list" method="get">
                <input name="banner_type" type="radio" value="" onChange="change(1)" @if($params['banner_type'] == '') checked @endif> 전체
                <input name="banner_type" class="ml-5" type="radio" value="beatsomeone" onChange="change(1)" @if($params['banner_type'] == 'beatsomeone') checked @endif> 비트썸원
                <input name="banner_type" class="ml-5" type="radio" value="bybeats" onChange="change(1)" @if($params['banner_type'] == 'bybeats') checked @endif> 바이비츠
            </form>
        </div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">배너관리</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">

                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}개의 배너영역이 있습니다.</h2>
                        <!-- <button class="btn box flex items-center text-slate-600 border border-slate-400" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview">
                            등록
                        </button> -->
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">No.</th>
                                    <th class="whitespace-nowrap text-center">서비스</th>
                                    <th class="whitespace-nowrap text-center">구분</th>
                                    <th class="whitespace-nowrap text-center">하위 컨텐츠</th>
                                    <th class="whitespace-nowrap text-center">최근 등록일</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=0; @endphp
                                @foreach($bannerList as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center"><a href="/mainmanage/banner/view/{{$rs->banner_code}}">{{$totalCount-($i+(($params['page']-1)*10))}}</a></td>
                                        <td class="whitespace-nowrap text-center"><a href="/mainmanage/banner/view/{{$rs->banner_code}}">{{$rs->type}}</a></td>
                                        <td class="whitespace-nowrap text-center"><a href="/mainmanage/banner/view/{{$rs->banner_code}}">{{$rs->banner_name}}</a></td>
                                        <td class="whitespace-nowrap text-center"><a href="/mainmanage/banner/view/{{$rs->banner_code}}">{{$rs->downcontents}}</a></td>
                                        <td class="whitespace-nowrap text-center"><a href="/mainmanage/banner/view/{{$rs->banner_code}}">{{$rs->created_at}}</a></td>
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

