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
                    <h2 class="font-medium text-base mr-auto" onclick="location.href='/mainmanage/popup/write'">팝업 등록</h2>
                </div>

                <div class="p-5">
                    <div class="overflow-x-auto">
                        <form id="PopupWriteForm" method="post" action="/mainmanage/popup/add" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">서비스</th>
                                    <td class="whitespace-nowrap">
                                        <select name="type" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="">선택</option>
                                            <option value="bybeats">바이비츠</option>
                                            <option value="beatsomeone" >비트썸원</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="pp_title" id="regular-form-1" type="text" class="form-control" placeholder="Input text">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">이미지</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <input name="popup_img" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="formFile">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">노출기간</th>
                                    <td colspan="3">
                                        <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                            <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                            <input name="show_date" type="text" class="datepicker form-control sm:w-56 box pl-10" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">연결 화면</th>
                                    <td class="whitespace-nowrap">
                                        <select id="connect_type" name="connect_type" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="menu">메뉴선택</option>
                                            <option value="url" >URL 입력</option>
                                        </select>
                                        <div class="inline items-center w-60 mt-3 ml-2" id="menu_area">
                                            <select name="menu_connect_url" class="form-select w-60 none" aria-label=".form-select-lg example">
                                                <option value="">메뉴 선택</option>
                                                <option value="feed">피드</option>
                                                <option value="soundtrack" >음원제작</option>
                                                <option value="question" >질문/답변</option>
                                                <option value="review" >제품 리뷰</option>
                                                <option value="trand" >트렌드</option>
                                                <option value="event" >이벤트</option>
                                                <option value="notice" >공지사항</option>
                                                <option value="faq" >FAQ</option>
                                            </select>
                                            <select name="connect_contents" class="form-select w-60" aria-label=".form-select-lg example">
                                                <option value="">콘텐츠 선택</option>
                                                <option value="contents">콘텐츠</option>
                                            </select>
                                        </div>
                                        <div class="hidden items-center mt-3 ml-2" id="url_area">
                                            http:// <input name="url_connect_url" id="regular-form-1" type="text" class="form-control w-72" placeholder="Input text">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">상태</th>
                                    <td class="whitespace-nowrap">
                                        <select name="isuse" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="Y">사용</option>
                                            <option value="N" >미 사용</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <div class="flex items-center justify-center mt-5">
                                <button class="btn btn-primary w-32 ml-2 mr-2 popupAddbtn">등록</button>
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

        $(document).on('click','.popupAddbtn', function(){

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

            if($("input[name='popup_img']").val() == ""){
                alert("팝업 이미지를 선택해주세요.");
                return false;
            }

            $('#PopupWriteForm').submit();

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
