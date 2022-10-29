@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">공지사항</h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-12">

            <div class="intro-y box">

                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                    <h2 class="font-medium text-base mr-auto">공지사항 상세</h2>
                </div>

                <div class="p-5">
                    <div class="overflow-x-auto">
                    <form id="boardUpdateForm" method="post" action="/service/board/update" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input name="idx" type="hidden" value="{{$boardData[0]->idx}}">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">구분</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <select name="gubun" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="">선택</option>
                                            <option value="0" @if($boardData[0]->gubun == 0) selected @endif>일반</option>
                                            <option value="1" @if($boardData[0]->gubun == 1) selected @endif>우선 노출</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="wr_title" id="regular-form-1" type="text" class="form-control" placeholder="Input text" value="{{$boardData[0]->wr_title}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
                                        <textarea class="form-control" name="editor1" id="editor1"
                                                  rows="20" cols="10"
                                                  placeholder="내용을 입력해주세요"
                                        >{{$boardData[0]->wr_content}}</textarea>
                                        <textarea name="wr_content" id="wr_content" class="hidden"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">노출 여부</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <select name="wr_open" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="open" @if($boardData[0]->wr_open == 'open') selected @endif>노출</option>
                                            <option value="secret" @if($boardData[0]->wr_open == 'secret') selected @endif>미 노출</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">관리자</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        {{$boardData[0]->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최초 등록일</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$boardData[0]->created_at}}
                                    </td>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최근 수정일</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$boardData[0]->updated_at}}
                                    </td>
                                </tr>
                            </table>

                            <div class="flex items-center justify-center mt-5">
                                <button type="button" class="btn btn-secondary w-32 boardDeletebtn">삭제</button>
                                <button class="btn btn-primary w-32 ml-2 mr-2 boardUpdatebtn">수정</button>
                                <button type="button" class="btn btn-secondary w-32" onclick="location.href='/service/board/list'">취소</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

    </div>


    <script>

        let oEditors = []

        smartEditor = function() {
            console.log("Naver SmartEditor")
            nhn.husky.EZCreator.createInIFrame({
                oAppRef: oEditors,
                elPlaceHolder: "editor1",
                sSkinURI: "/smarteditor2-2.8.2.3/SmartEditor2Skin.html",
                fCreator: "createSEditor2"
            })
        }

        $(document).ready(function() {
            smartEditor()
        })

        $(document).on('click','.boardUpdatebtn', function(){

            if($("select[name='gubun']").val() == ""){
                alert("구분을 선택해주세요.");
                return false;
            }

            if($("input[name='wr_title']").val() == ""){
                alert("제목을 입력해주세요.");
                return false;
            }

            if(editor.getData() == ""){
                alert("내용을 입력해주세요.");
                return false;
            }

            if($("select[name='wr_open']").val() == ""){
                alert("노출 여부를 선택해주세요.");
                return false;
            }

            $("#wr_content").val(editor.getData());

            $('#boardUpdateForm').submit();

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

        $(document).on('click','.boardDeletebtn',function(){
            var idx = $("input[name='idx']").val();
            if(confirm("공지사항을 삭제하시겠습니까?")){
                jQuery.ajax({
                    cache: false,
                    dataType:'json',
                    data: {
                        idx : idx
                    },
                    url: '/service/board/delete',
                    success: function (data) {
                        if(data.result == "SUCCESS"){
                            alert('공지사항이 삭제되었습니다.');
                            location.href="/service/board/list"
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
