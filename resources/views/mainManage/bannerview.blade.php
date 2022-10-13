@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">배너 관리</h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-12">

            <div class="intro-y box">

                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                    <h2 class="font-medium text-base mr-auto">배너 상세</h2>
                </div>

                <div class="p-5">
                    <div class="overflow-x-auto">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">서비스</th>
                                <td colspan="3" class="whitespace-nowrap">
                                    <span>{{$bannerData[0]->type}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">구분</th>
                                <td colspan="3" class="whitespace-nowrap">
                                    <span>{{$bannerData[0]->banner_name}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">하위 컨텐츠</th>
                                <td colspan="3" class="whitespace-nowrap">
                                    <span>{{$bannerData[0]->downcontents}}</span>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최근 수정일자</th>
                                <td colspan="3" class="whitespace-nowrap">
                                    <span>{{$bannerData[0]->updated_at}}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
            <form id="searchData" name="searchData" action="/mainmanage/banner/view/{{$bannerData[0]->banner_code}}" method="get">
                <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                <div class="intro-y box mt-5">
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">구분</th>
                                    <td class="">
                                        <select name="s_contents" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value=''>전체</option>
                                            <option value="notice" @if($params['search_contents'] == 'notice') selected @endif>공지사항</option>
                                            <option value="event" @if($params['search_contents'] == 'event') selected @endif>이벤트</option>
                                            <option value="url" @if($params['search_contents'] == 'url') selected @endif>URL 등록</option>
                                        </select>
                                    </td>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">검색</th>
                                    <td class="">
                                        <div class="relative inline-block w-56">
                                            <input type="text" name="search_text" class="form-control" data-single-mode="true" value="{{$params['fr_search_text']}}">
                                        </div>
                                    </td>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">등록일</th>
                                    <td class="">
                                        <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                            <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                            <input name="created_at" type="text" class="datepicker form-control sm:w-56 box pl-10" value="{{$params['created_at']}}">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                            <button class="btn btn-primary w-24 ml-2" onclick="$('#searchData').submit();">검색</button>
                                <div class="btn btn-secondary w-24 ml-5" onClick="javascript:location.href = '/mainmanage/banner/view/{{$bannerData[0]->banner_code}}';">초기화</div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="intro-y box mt-5">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                    <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}개의 컨텐츠가 있습니다.</h2>
                    <button class="btn box flex items-center text-slate-600 border border-slate-400 mr-2" id="select_delete">
                        선택 삭제
                    </button>
                    <button class="btn box flex items-center text-slate-600 border border-slate-400 mr-2" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview">
                        등록
                    </button>
                    <button class="btn box flex items-center text-slate-600 border border-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="file-text" data-lucide="file-text" class="lucide lucide-file-text hidden sm:block w-4 h-4 mr-2">
                            <path d="M14.5 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V7.5L14.5 2z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <line x1="10" y1="9" x2="8" y2="9"></line>
                        </svg> Export to Excel
                    </button>
                </div>
                <div class="p-5">
                    <div class="overflow-x-auto">
                        <table class="table table-bordered table-hover table-auto">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center"><input type="checkbox" class="all_check" name="all_check"></th>
                                    <th class="whitespace-nowrap text-center">구분</th>
                                    <th class="whitespace-nowrap text-center">제목</th>
                                    <th class="whitespace-nowrap text-center">상태</th>
                                    <th class="whitespace-nowrap text-center">등록일</th>
                                    <th class="whitespace-nowrap text-center">순서</th>
                                </tr>
                            </thead>
                            <tbody id="banner_data_list">
                                @php $i=0; @endphp
                                @foreach($bannerDataList as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center"><input type="checkbox" class="del_check" name="del_check" value="{{$rs->idx}}"></td>
                                        <td class="whitespace-nowrap text-center">@if($rs->contents === 'notice') 공지사항 @elseif($rs->contents === 'event') 이벤트 @else URL 등록 @endif</td>
                                        <td class="whitespace-nowrap text-center bannerUpdate" data-idx="{{$rs->idx}}" data-contents="{{$rs->contents}}" data-contents_url="{{$rs->contents_url}}" data-br_title="{{$rs->br_title}}" data-isuse="{{$rs->isuse}}" data-banner_file="{{$rs->banner_file}}" data-banner_source="{{$rs->banner_source}}" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-update">{{$rs->br_title}}</td>
                                        <td class="whitespace-nowrap text-center">@if($rs->isuse === "Y") 사용 @else 미 사용 @endif</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->created_at}}</td>
                                        <td class="whitespace-nowrap text-center">
                                            <button class="btn box items-center text-slate-600 border border-slate-400 mr-2 seqchange" data-idx="{{$rs->idx}}" data-change_idx="{{$rs->bf_idx}}" data-br_seq="{{$rs->br_seq}}" data-change_seq="{{$rs->bf_br_seq}}" @if($rs->bf_idx == "") disabled @endif>
                                                @if($rs->bf_idx == "")
                                                    △
                                                @else
                                                    ▲
                                                @endif
                                            </button>
                                            <button class="btn box items-center text-slate-600 border border-slate-400 seqchange" data-idx="{{$rs->idx}}" data-change_idx="{{$rs->af_idx}}" data-br_seq="{{$rs->br_seq}}" data-change_seq="{{$rs->af_br_seq}}"@if($rs->af_idx == "") disabled @endif>
                                                @if($rs->af_idx == "")
                                                    ▽
                                                @else
                                                    ▼
                                                @endif
                                            </button>
                                        </td>
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

    <!-- 등록 모달 시작 -->
    <div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-2xl">
            <div class="modal-content">
                <div class="modal-body p-10 text-center">

                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">컨텐츠 등록</h2>
                    </div>

                    <form id="BannerWriteForm" method="post" action="/mainmanage/banner/add" enctype="multipart/form-data">
                        <div class="overflow-x-auto">
                            {{ csrf_field() }}
                            <input type="hidden" name="banner_code" value="{{$bannerData[0]->banner_code}}"/>
                            <table class="table table-bordered">
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">제목</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input name="br_title" id="regular-form-1" type="text" class="form-control" placeholder="제목을 입력해주세요.">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">컨텐츠 구분</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="contents" class="form-select w-56" aria-label=".form-select-lg example">
                                            <option value="">선택</option>
                                            <option value="notice">공지사항</option>
                                            <option value="event">이벤트</option>
                                            <option value="url">URL 등록</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">연결 컨텐츠</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input name="contents_url"id="regular-form-1" type="text" class="form-control" placeholder="연결할 컨텐츠를 입력해주세요.">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">배너 이미지</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="file" name="banner_img" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">상태</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="isuse" class="form-select w-56" aria-label=".form-select-lg example">
                                            <option value="Y">사용</option>
                                            <option value="N">미 사용</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="flex items-center justify-center mt-5">
                            <button class="btn btn-primary w-32 ml-2 mr-2 bannerAddbtn">등록</button>
                            <button type="button" class="btn btn-secondary w-32" data-tw-dismiss="modal">닫기</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 등록 모달 끝 -->

    <!-- 등록 모달 시작 -->
    <div id="superlarge-modal-size-update" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-2xl">
            <div class="modal-content">
                <div class="modal-body p-10 text-center">

                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">컨텐츠 수정</h2>
                    </div>

                    <form id="BannerUpdateForm" method="post" action="/mainmanage/banner/update" enctype="multipart/form-data">
                        <div class="overflow-x-auto">
                            {{ csrf_field() }}
                            <input type="hidden" name="up_idx" value=""/>
                            <table class="table table-bordered">
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">제목</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input name="up_br_title" id="regular-form-1" type="text" class="form-control" placeholder="제목을 입력해주세요.">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">컨텐츠 구분</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="up_contents" class="form-select w-56" aria-label=".form-select-lg example">
                                            <option value="">선택</option>
                                            <option value="notice">공지사항</option>
                                            <option value="event">이벤트</option>
                                            <option value="url">URL 등록</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">연결 컨텐츠</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input name="up_contents_url"id="regular-form-1" type="text" class="form-control" placeholder="연결할 컨텐츠를 입력해주세요.">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">배너 이미지</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="file" name="up_banner_img" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                        <img class="up_banner_img" src="" alt="배너 이미지">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">상태</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="up_isuse" class="form-select w-56" aria-label=".form-select-lg example">
                                            <option value="Y">사용</option>
                                            <option value="N">미 사용</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="flex items-center justify-center mt-5">
                            <button class="btn btn-primary w-32 ml-2 mr-2 bannerUpdatebtn">수정</button>
                            <button type="button" class="btn btn-secondary w-32" data-tw-dismiss="modal">닫기</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 등록 모달 끝 -->

    <script>

        var ajax_checked = false;

        $(document).on('click','.bannerAddbtn', function(){

            if($("input[name='br_title']").val() == ""){
                alert("제목을 입력해주세요.");
                return false;
            }

            if($("select[name='contents']").val() == ""){
                alert("컨텐츠 구분을 선택해주세요.");
                return false;
            }

            if($("input[name='contents_url']").val() == ""){
                alert("연결할 컨텐츠를 입력해주세요.");
                return false;
            }

            if($("input[name='banner_img']").val() == ""){
                alert("배너 이미지를 선택해주세요.");
                return false;
            }

            $('#BannerWriteForm').submit();

            /*var BannerWriteForm = $("#BannerWriteForm")[0];
            var formData = new FormData(BannerWriteForm);

            $.ajax({
                type:"post",
                contentType: false,
                cache: false,
                processData: false,
                dataType:'json',
                data: formData,
                url: '/mainmanage/banner/add',
                success: function (data) {
                    if(data.result=="SUCCESS"){
                        alert('컨텐츠가 등록되었습니다.');
                        location.reload();
                    }else{
                        alert(data.result);
                    }
                },
                error: function (e) {
                    console.log('start');
                    console.log(e);
                    alert('로딩 중 오류가 발생 하였습니다.');
                }
            });*/

        });

        $(document).on('click','.all_check',function(){
            if($(this).is(':checked') == true){
                $('.del_check').attr('checked',true);
            }else{
                $('.del_check').removeAttr('checked');
            }
        });

        $(document).on('click','#select_delete',function(){
            var del_check = [];
            if(confirm("선택하신 목록들을 삭제하시겠습니까?")){
                if($("input[name='del_check']:checked").length > 0){

                    $("input[name='del_check']:checked").each(function(e){
                        del_check.push($(this).val());
                    })

                    jQuery.ajax({
                        cache: false,
                        dataType:'json',
                        data: {
                            del_check : del_check
                        },
                        url: '/mainmanage/banner/selectdelete',
                        success: function (data) {
                            if(data == "SUCCESS"){
                                alert('컨텐츠가 삭제되었습니다.');
                                location.reload();
                            }else{
                                alert(data);
                                //console.log(data);
                            }
                        },
                        error: function (e) {
                            console.log('start');
                            console.log(e);
                            //alert('로딩 중 오류가 발생 하였습니다.');
                        }
                    });
                }else{
                    alert('선택한 목록이 없습니다');
                }
            }
        });

        $(document).on('click','.bannerUpdate',function(){
            var idx = $(this).data('idx');
            var br_title = $(this).data('br_title');
            var contents = $(this).data('contents');
            var contents_url = $(this).data('contents_url');
            var banner_file = $(this).data('banner_file');
            var banner_source = $(this).data('banner_source');
            var isuse = $(this).data('isuse');

            $("input[name='up_idx']").val(idx);
            $("input[name='up_br_title']").val(br_title);
            $("select[name='up_contents']").val(contents);
            $("input[name='up_contents_url']").val(contents_url);
            $("select[name='up_isuse']").val(isuse);
            $('.up_banner_img').attr('src','/storage/banner/'+banner_source);
        });

        $(document).on('click','.bannerUpdatebtn', function(){

            if($("input[name='up_br_title']").val() == ""){
                alert("제목을 입력해주세요.");
                return;
            }

            if($("select[name='up_contents']").val() == ""){
                alert("컨텐츠 구분을 선택해주세요.");
                return;
            }

            if($("input[name='up_contents_url']").val() == ""){
                alert("연결할 컨텐츠를 입력해주세요.");
                return;
            }

            $('#BannerUpdateForm').submit();

            /*var BannerWriteForm = $("#BannerWriteForm")[0];
            var formData = new FormData(BannerWriteForm);

            $.ajax({
                type:"post",
                contentType: false,
                cache: false,
                processData: false,
                dataType:'json',
                data: formData,
                url: '/mainmanage/banner/add',
                success: function (data) {
                    if(data.result=="SUCCESS"){
                        alert('컨텐츠가 등록되었습니다.');
                        location.reload();
                    }else{
                        alert(data.result);
                    }
                },
                error: function (e) {
                    console.log('start');
                    console.log(e);
                    alert('로딩 중 오류가 발생 하였습니다.');
                }
            });*/

        });

        $(document).on('click','.seqchange', function(){
            var idx = $(this).data("idx");
            var change_idx = $(this).data("change_idx");
            var br_seq = $(this).data("br_seq");
            var change_seq = $(this).data("change_seq");
            var contents = "{{$params['search_contents']}}";
            var search_text = "{{$params['fr_search_text']}}";
            var created_at = "{{$params['created_at']}}";
            var banner_code = "{{$bannerData[0]->banner_code}}";
            var page = $("input[name=page]").val();

            if(ajax_checked == false){
                ajax_checked = true;
                jQuery.ajax({
                    cache: false,
                    dataType:'json',
                    data: {
                        idx:idx,
                        change_idx:change_idx,
                        br_seq:br_seq,
                        change_seq:change_seq,
                        banner_code:banner_code,
                        page:page,
                        contents:contents,
                        search_text:search_text,
                        created_at:created_at,
                    },
                    url: '/mainmanage/banner/seqchange',
                    success: function (data) {

                        $("#banner_data_list")[0].innerHTML = '';

                        data.forEach(function(item,index) {

                            var dom = document.createElement('tr');

                            if(item.contents == "notice"){
                                item.contents = "공지사항";
                            }else if(item.contents == "event"){
                                item.contents = "이벤트";
                            }else{
                                item.contents = "URL 등록";
                            }

                            if(item.isuse == "Y"){
                                item.isuse = "사용";
                            }else{
                                item.isuse = "미 사용";
                            }

                            var bf_disabled = "", af_disabled = "",bf_up = "", af_down = "";

                            if(item.bf_idx == ""){
                                bf_disabled = "disabled";
                                bf_up = "△";
                            }else{
                                bf_up = "▲";
                            }

                            if(item.af_idx == ""){
                                af_disabled = "disabled";
                                af_down = "▽";
                            }else{
                                af_down = "▼";
                            }


                            var hitem = '<tr>'
                                +'<td class="whitespace-nowrap text-center"><input type="checkbox" class="del_check" name="del_check" value="'+item.idx+'"></td>'
                                +'<td class="whitespace-nowrap text-center">'+item.contents+'</td>'
                                +'<td class="whitespace-nowrap text-center bannerUpdate" data-idx="'+item.idx+'" data-contents="'+item.contents+'" data-contents_url="'+item.contents_url+'" data-br_title="'+item.br_title+'" data-isuse="'+item.isuse+'" data-banner_file="'+item.banner_file+'" data-banner_source="'+item.banner_source+'" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-update">'+item.br_title+'</td>'
                                +'<td class="whitespace-nowrap text-center">'+item.isuse+'</td>'
                                +'<td class="whitespace-nowrap text-center">'+item.created_at+'</td>'
                                +'<td class="whitespace-nowrap text-center">'
                                +    '<button class="btn box items-center text-slate-600 border border-slate-400 mr-2 seqchange" data-idx="'+item.idx+'" data-change_idx="'+item.bf_idx+'" data-br_seq="'+item.br_seq+'" data-change_seq="'+item.bf_br_seq+'" '+bf_disabled+'>'
                                +    bf_up
                                +    '</button>'
                                +    '<button class="btn box items-center text-slate-600 border border-slate-400 mr-2 seqchange" data-idx="'+item.idx+'" data-change_idx="'+item.af_idx+'" data-br_seq="'+item.br_seq+'" data-change_seq="'+item.af_br_seq+'" '+af_disabled+'>'
                                +    af_down
                                +    '</button>'
                                +'</td>'
                                +'</tr>'

                            dom.innerHTML = hitem;

                            $("#banner_data_list").append(dom);

                            ajax_checked = false;
                        });
                        /*if(data.result=="SUCCESS"){
                            alert('컨텐츠가 등록되었습니다.');
                        }else{
                            //alert(data.result);
                            console.log(data.result);
                        }*/
                    },
                    error: function (e) {
                        console.log('start');
                        console.log(e);
                        //alert('로딩 중 오류가 발생 하였습니다.');
                    }
                });
            }
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
