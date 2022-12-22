@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">트렌드</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">
                    <div id="boxed-tab" class="p-5">
                        <div class="preview">
                            <ul class="nav nav-boxed-tabs" role="tablist">
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab" onClick="javascript:location.href = '/service/trend/view/{{$idx}}';">기본 정보</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab" onClick="javascript:location.href = '/service/trendBeatView/{{$idx}}';">비트 내역</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2 active" type="button" role="tab" onClick="javascript:location.href = '/service/trendCommentView/{{$idx}}';">댓글 내역</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <form name="searchForm"  id="searchForm" action="" method="get">
                                <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">노출 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select name="cm_open" class="form-select w-13" aria-label=".form-select-lg">
                                                <option value=''>전체</option>
                                                <option value="open" @if($params['search_cm_open'] == 'open') selected @endif>노출</option>
                                                <option value="secret" @if($params['search_cm_open'] == 'secret') selected @endif>비 노출</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-25 text-center">등록일</th>
                                        <td class="">
                                            <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                                <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                                <input name="created_at" type="text" class="datepicker form-control sm:w-56 box pl-10" value="{{$params['created_at']}}">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">검색</th>
                                        <td class="whitespace-nowrap" colspan="7">
                                            <input id="regular-form-1" name="search_text" value="{{$params['fr_search_text']}}" type="text">
                                        </td>

                                    </tr>
                                </table>
                            </form>
                            <div style="float:right;">
                                <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/contents/feedCommentView/{{$idx}}';">
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
                            <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}개의 댓글이 있습니다.</h2>
                        </div>
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="table table-bordered table-hover table-auto">
                                    <thead>
                                    <tr>
                                        <th class="whitespace-nowrap text-center">No.</th>
                                        <th class="whitespace-nowrap text-center">노출 상태</th>
                                        <th class="whitespace-nowrap text-center">고유 ID</th>
                                        <th class="whitespace-nowrap text-center">댓글 내용</th>
                                        <th class="whitespace-nowrap text-center">비트 수</th>
                                        <th class="whitespace-nowrap text-center">등록일</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=0; @endphp
                                    @foreach($trendCommentData as $rs)
                                        <tr class="@if($rs->cm_main != 1 ) bg-primary/10 @endif">
                                            <td class="whitespace-nowrap text-center">{{$totalCount-($i+(($params['page']-1)*10))}}</td>
                                            <td class="whitespace-nowrap text-center">@if($rs->cm_open == 'open') 노출 @else 비 노출 @endif</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->u_id}}</td>
                                            <td class="whitespace-nowrap text-center detailOpen" data-idx="{{$rs->idx}}" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview2">@if($rs->cm_main != 1 ) 답글 : @endif {{$rs->cm_content}}</td>
                                            <td class="whitespace-nowrap text-center">{{$rs->cm_bit}}</td>
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

    <!-- 포인트지급 설정 모달 시작 -->
    <div id="superlarge-modal-size-preview2" class="modal" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog modal-2xl">
            <div class="modal-content">
                <div class="modal-body p-10 text-center">
                    <div class="overflow-x-auto">
                        <table class="table table-bordered">
                        <tr>
                            <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">닉네임</th>
                            <td colspan="3" class="whitespace-nowrap" id="mem_nickname">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">댓글 내용</th>
                            <td colspan="3" class="whitespace-nowrap" id="cm_content">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">비트 수</th>
                            <td colspan="3" class="whitespace-nowrap" id="cm_bit">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">신고</th>
                            <td colspan="3" class="whitespace-nowrap" id="cm_report">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최초 등록일</th>
                            <td colspan="1" class="whitespace-nowrap" id="created_at">
                            </td>
                            <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최근 수정일</th>
                            <td colspan="1" class="whitespace-nowrap" id="updated_at">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">상태</th>
                            <td colspan="3" class="whitespace-nowrap">
                                <select name="cm_open" class="form-select w-60" aria-label=".form-select-lg example" id="cm_open">
                                    <option value="open">노출</option>
                                    <option value="secret">비 노출</option>
                                </select>
                            </td>
                        </tr>
                        </table>
                    <div class="flex items-center justify-center mt-5">
                        <button class="btn btn-primary w-32 mr-5 commentUpdateBtn">설정</button>
                        <button class="btn btn-secondary w-32 modalCancel" data-tw-dismiss="modal">닫기</button>
                    </div>
                </div>
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

        var idx = 0;

        $(document).on('click','.detailOpen',function(){
            idx = $(this).data('idx');

            jQuery.ajax({
                cache: false,
                dataType:'json',
                data: {
                    idx : idx,
                },
                url: '/contents/comment/commentDetail',
                success: function (data) {
                    if(data.resultCode=="SUCCESS"){
                        $('#mem_nickname')[0].innerHTML = data['response'][0].mem_nickname;
                        $('#cm_content')[0].innerHTML = data['response'][0].cm_content;
                        $('#cm_bit')[0].innerHTML = data['response'][0].cm_bit;
                        $('#cm_report')[0].innerHTML = 0;//data['response'][0].cm_report;
                        $('#created_at')[0].innerHTML = data['response'][0].created_at;
                        $('#updated_at')[0].innerHTML = data['response'][0].updated_at;
                        $('#cm_open').val(data['response'][0].cm_open);
                    }else{
                        alert(data.resultMessage);
                    }
                },
                error: function (e) {
                    console.log('start');
                    console.log(e);
                    //alert('로딩 중 오류가 발생 하였습니다.');
                }
            });
        });

        $(document).on('click','.commentUpdateBtn',function(){
            var cm_open = $('#cm_open').val();
            
            jQuery.ajax({
                cache: false,
                dataType:'json',
                data: {
                    idx : idx,
                    cm_open : cm_open,
                },
                url: '/contents/comment/commentUpdate',
                success: function (data) {
                    if(data.resultCode=="SUCCESS"){
                        alert(data.resultMessage);
                        location.reload();
                    }else{
                        alert(data.resultMessage);
                    }
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
