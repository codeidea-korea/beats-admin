@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">공지사항</h2>
    </div>

    <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-12">

            <div class="intro-y box">

                <div class="p-5">
                    <div class="overflow-x-auto">
                        <form id="boardWriteForm" method="post" action="/service/board/add" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">구분</th>
                                    <td class="whitespace-nowrap">
                                        <select name="gubun" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="">선택</option>
                                            <option value="0">일반</option>
                                            <option value="1" >우선 노출</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="wr_title" id="regular-form-1" type="text" class="form-control" placeholder="Input text">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목(영어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="wr_title_en" id="regular-form-2" type="text" class="form-control" placeholder="Input text">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목(일어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="wr_title_jp" id="regular-form-3" type="text" class="form-control" placeholder="Input text">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목(중국어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="wr_title_ch" id="regular-form-4" type="text" class="form-control" placeholder="Input text">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="p-5" id="classic-editor">
                                            <textarea class="form-control" name="wr_content" id="wr_content" rows="20" cols="10" style="width:95%" placeholder="내용을 입력해주세요"></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용(영어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="p-5" id="classic-editor">
                                            <textarea class="form-control" name="wr_content_en" id="wr_content_en" rows="20" cols="10" style="width:95%" placeholder="내용을 입력해주세요"></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용(일어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="p-5" id="classic-editor">
                                            <textarea class="form-control" name="wr_content_jp" id="wr_content_jp" rows="20" cols="10" style="width:95%" placeholder="내용을 입력해주세요"></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용(중국어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="p-5" id="classic-editor">
                                            <textarea class="form-control" name="wr_content_ch" id="wr_content_ch" rows="20" cols="10" style="width:95%" placeholder="내용을 입력해주세요"></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">노출 여부</th>
                                    <td class="whitespace-nowrap">
                                        <select name="wr_open" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="open">노출</option>
                                            <option value="secret" >미 노출</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <div class="flex items-center justify-center mt-5">
                                <div class="btn btn-primary w-32 ml-2 mr-2 boardAddbtn">등록</div>
                                <button type="button" class="btn btn-secondary w-32" onclick="history.back(-1)">취소</button>
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

        $(document).ready(function() {
            nhn.husky.EZCreator.createInIFrame({
                oAppRef: oEditors,
                elPlaceHolder: "wr_content",
                sSkinURI: "/smarteditor2-2.8.2.3/SmartEditor2Skin.html",
                fCreator: "createSEditor2",
                htParams : {
                    bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                    fOnBeforeUnload : function(){
                    }
                },
                fOnAppLoad : function(){
                },
            })

            nhn.husky.EZCreator.createInIFrame({
                oAppRef: oEditors,
                elPlaceHolder: "wr_content_en",
                sSkinURI: "/smarteditor2-2.8.2.3/SmartEditor2Skin.html",
                fCreator: "createSEditor2",
                htParams : {
                    bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                    fOnBeforeUnload : function(){
                    }
                },
                fOnAppLoad : function(){
                },
            })

            nhn.husky.EZCreator.createInIFrame({
                oAppRef: oEditors,
                elPlaceHolder: "wr_content_jp",
                sSkinURI: "/smarteditor2-2.8.2.3/SmartEditor2Skin.html",
                fCreator: "createSEditor2",
                htParams : {
                    bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                    fOnBeforeUnload : function(){
                    }
                },
                fOnAppLoad : function(){
                },
            })

            nhn.husky.EZCreator.createInIFrame({
                oAppRef: oEditors,
                elPlaceHolder: "wr_content_ch",
                sSkinURI: "/smarteditor2-2.8.2.3/SmartEditor2Skin.html",
                fCreator: "createSEditor2",
                htParams : {
                    bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                    bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                    fOnBeforeUnload : function(){
                    }
                },
                fOnAppLoad : function(){
                },
            })
        })

        // 값 가져오기
        $(document).on('click','.boardAddbtn', function(){


            if($("select[name='gubun']").val() == ""){
                alert("구분을 선택해주세요.");
                return false;
            }

            if($("input[name='wr_title']").val() == ""){
                alert("제목을 입력해주세요.");
                return false;
            }

            if($("select[name='wr_open']").val() == ""){
                alert("노출 여부를 선택해주세요.");
                return false;
            }

            //$("#wr_content").val(editor.getData());

            oEditors.getById["wr_content"].exec("UPDATE_CONTENTS_FIELD", []);
            if($("textarea[name='wr_content']").val() == ""){
                alert("내용을 입력해주세요.");
                return false;
            }

            oEditors.getById["wr_content_en"].exec("UPDATE_CONTENTS_FIELD", []);

            oEditors.getById["wr_content_jp"].exec("UPDATE_CONTENTS_FIELD", []);

            oEditors.getById["wr_content_ch"].exec("UPDATE_CONTENTS_FIELD", []);

            //$('#boardWriteForm')[0].submit();

            var data = {
                gubun:$("select[name='gubun']").val()
                ,wr_title:$("input[name='wr_title']").val()
                ,wr_title_en:$("input[name='wr_title_en']").val()
                ,wr_title_jp:$("input[name='wr_title_jp']").val()
                ,wr_title_ch:$("input[name='wr_title_ch']").val()
                ,wr_open:$("select[name='wr_open']").val()
                ,wr_content:$("textarea[name='wr_content']").val()
                ,wr_content_en:$("textarea[name='wr_content_en']").val()
                ,wr_content_jp:$("textarea[name='wr_content_jp']").val()
                ,wr_content_ch:$("textarea[name='wr_content_ch']").val()
            };
            jQuery.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"post",
                dataType:'json',
                data: data,
                url: "{{ url('/service/board/add') }}",
                success: function searchSuccess(data) {
                    if(data.result=="SUCCESS"){
                        alert('등록되었습니다.');
                        location.href="/service/board/view/"+data.idx;
                    }else{
                        alert('등록/수정에 실패하였습니다. \n관리자에게 문의 바랍니다.');
                    }
                },
                error: function (e) {
                    console.log(e);
                    alert('로딩 중 오류가 발생 하였습니다.');
                }
            });


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
