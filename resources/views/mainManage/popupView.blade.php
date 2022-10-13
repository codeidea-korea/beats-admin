@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">팝업 관리</h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-12">

            <div class="intro-y box">

                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                    <h2 class="font-medium text-base mr-auto">팝업 상세</h2>
                </div>

                <div class="p-5">
                    <div class="overflow-x-auto">
                    <form id="PopupWriteForm" method="post" action="/mainmanage/popup/update" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input name="idx" type="hidden" value="{{$popupData[0]->idx}}">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">서비스</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <select name="type" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="">선택</option>
                                            <option value="bybeats" @if($popupData[0]->type == 'bybeats') selected @endif>바이비츠</option>
                                            <option value="beatsomeone" @if($popupData[0]->type == 'beatsomeone') selected @endif>비트썸원</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="pp_title" id="regular-form-1" type="text" class="form-control" placeholder="Input text" value="{{$popupData[0]->pp_title}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">이미지</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <input name="popup_img" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="formFile">
                                        <img class="up_banner_img" src="/storage/popup/{{$popupData[0]->popup_source}}" alt="팝업 이미지">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">노출기간</th>
                                    <td colspan="3">
                                        <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                            <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                            <input name="show_date" type="text" class="datepicker form-control sm:w-56 box pl-10" value="{{$popupData[0]->fr_show_date}} - {{$popupData[0]->bk_show_date}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">연결 화면</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <select id="connect_type" name="connect_type" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="menu" @if($popupData[0]->connect_type == 'menu') selected @endif>메뉴선택</option>
                                            <option value="url" @if($popupData[0]->connect_type == 'url') selected @endif>URL 입력</option>
                                        </select>
                                        <div class="inline items-center w-60 mt-3 ml-2 @if($popupData[0]->connect_type == 'url') hidden @endif" id="menu_area">
                                            <select name="menu_connect_url" class="form-select w-60 none" aria-label=".form-select-lg example">
                                                <option value="">메뉴 선택</option>
                                                <option value="feed" @if($popupData[0]->connect_url == 'feed') selected @endif>피드</option>
                                                <option value="soundtrack" @if($popupData[0]->connect_url == 'soundtrack') selected @endif >음원제작</option>
                                                <option value="question" @if($popupData[0]->connect_url == 'question') selected @endif>질문/답변</option>
                                                <option value="review" @if($popupData[0]->connect_url == 'review') selected @endif>제품 리뷰</option>
                                                <option value="trand" @if($popupData[0]->connect_url == 'trand') selected @endif>트렌드</option>
                                                <option value="event" @if($popupData[0]->connect_url == 'event') selected @endif>이벤트</option>
                                                <option value="notice" @if($popupData[0]->connect_url == 'notice') selected @endif>공지사항</option>
                                                <option value="faq" @if($popupData[0]->connect_url == 'faq') selected @endif>FAQ</option>
                                            </select>
                                            <select name="connect_contents" class="form-select w-60" aria-label=".form-select-lg example">
                                                <option value="">콘텐츠 선택</option>
                                                <option value="contents" @if($popupData[0]->connect_contents == 'contents') selected @endif>콘텐츠</option>
                                            </select>
                                        </div>
                                        <div class="items-center mt-3 ml-2 @if($popupData[0]->connect_type == 'menu') hidden @endif" id="url_area">
                                            http:// <input name="url_connect_url" id="regular-form-1" type="text" class="form-control w-72" placeholder="Input text" value="{{$popupData[0]->connect_url}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">상태</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <select name="isuse" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="Y" @if($popupData[0]->isuse == 'Y') selected @endif>사용</option>
                                            <option value="N" @if($popupData[0]->isuse == 'N') selected @endif>미 사용</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">관리자</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        {{$popupData[0]->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최초 등록일</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$popupData[0]->created_at}}
                                    </td>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최근 수정일</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$popupData[0]->updated_at}}
                                    </td>
                                </tr>
                            </table>

                            <div class="flex items-center justify-center mt-5">
                                <button type="button" class="btn btn-secondary w-32 popupDeletebtn">삭제</button>
                                <button class="btn btn-primary w-32 ml-2 mr-2 popupUpdatebtn">수정</button>
                                <button type="button" class="btn btn-secondary w-32" onclick="location.href='/mainmanage/popup/list'">취소</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

    </div>

    <script>

        var ajax_checked = false;

        $(document).on('change','#connect_type',function(){
            if($(this).val() == "menu"){
                $("#menu_area").css("display","inline");
                $("#url_area").css("display","none");
            }else{
                $("#menu_area").css("display","none");
                $("#url_area").css("display","inline");
            }
        });

        $(document).on('click','.bannerUpdatebtn', function(){

            if($("input[name='pp_title']").val() == ""){
                alert("제목을 입력해주세요.");
                return false;
            }

            if($("select[name='type']").val() == ""){
                alert("서비스를 선택해주세요.");
                return false;
            }

            if($('#connect_type').val() == "menu"){
                if($("select[name='menu_connect_url']").val() == ""){
                    alert("연결할 메뉴를 선택해주세요.");
                    return false;
                }

                if($("select[name='connect_contents']").val() == ""){
                    alert("연결할 콘텐츠를 선택해주세요.");
                    return false;
                }
            }else{
                if($("input[name='url_connect_url']").val() == ""){
                    alert("연결할 화면을 선택해주세요.");
                    return false;
                }
            }

            if($("input[name='show_date']").val() == ""){
                alert("노출기간을 입력해주세요.");
                return false;
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

        $(document).on('click','.popupDeletebtn',function(){
            var idx = $("input[name='idx']").val();
            if(confirm("팝업을 삭제하시겠습니까?")){
                jQuery.ajax({
                    cache: false,
                    dataType:'json',
                    data: {
                        idx : idx
                    },
                    url: '/mainmanage/popup/delete',
                    success: function (data) {
                        if(data.result == "SUCCESS"){
                            alert('팝업이 삭제되었습니다.');
                            location.href="/mainmanage/popup/list"
                        }else{
                            alert(data.result);
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
