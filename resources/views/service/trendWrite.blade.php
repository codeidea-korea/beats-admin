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

                <div class="p-5">
                    <div class="overflow-x-auto">
                        <form id="boardWriteForm" method="post" action="/service/trend/add" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">구분</th>
                                    <td class="whitespace-nowrap">
                                        <select name="gubun" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="국내 음악">국내 음악</option>
                                            <option value="해외 음악">해외 음악</option>
                                            <option value="음원 발매">음원 발매</option>
                                            <option value="공연">공연</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="title" id="regular-form-1" type="text" class="form-control" placeholder="Input text">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목(영어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="title_en" id="regular-form-2" type="text" class="form-control" placeholder="Input text">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목(일어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="title_jp" id="regular-form-3" type="text" class="form-control" placeholder="Input text">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목(중국어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="title_ch" id="regular-form-4" type="text" class="form-control" placeholder="Input text">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">대표 이미지</th>
                                    <td>
                                        <input type="file" name="trend_img" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="p-5" id="classic-editor">
                                            <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
                                            <textarea class="form-control" name="content" id="content" style="width:95%"
                                                      rows="20" cols="10"
                                                      placeholder="내용을 입력해주세요"
                                            ></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용(영어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="p-5" id="classic-editor">
                                            <textarea class="form-control" name="content_en" id="content_en" rows="20" cols="10" style="width:95%" placeholder="내용을 입력해주세요"></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용(일어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="p-5" id="classic-editor">
                                            <textarea class="form-control" name="content_jp" id="content_jp" rows="20" cols="10" style="width:95%" placeholder="내용을 입력해주세요"></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용(중국어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="p-5" id="classic-editor">
                                            <textarea class="form-control" name="content_ch" id="content_ch" rows="20" cols="10" style="width:95%" placeholder="내용을 입력해주세요"></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">노출 여부</th>
                                    <td class="whitespace-nowrap">
                                        <select name="open_status" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="Y">노출</option>
                                            <option value="N" >미 노출</option>
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

    <script src="/dist/js/ckeditor.js"></script>
    <script src="/dist/js/ck.upload.adapter.js"></script>

    <script>

        var ajax_checked = false;
        let oEditors = []

        $(document).ready(function() {
            nhn.husky.EZCreator.createInIFrame({
                oAppRef: oEditors,
                elPlaceHolder: "content",
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
                elPlaceHolder: "content_en",
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
                elPlaceHolder: "content_jp",
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
                elPlaceHolder: "content_ch",
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

            if($("input[name='title']").val() == ""){
                alert("제목을 입력해주세요.");
                return false;
            }

            if($("input[name='trend_img']").val() == ""){
                alert("대표 이미지를 입력해주세요.");
                return false;
            }

            oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
            if($("textarea[name='content']").val() == ""){
                alert("내용을 입력해주세요.");
                return false;
            }

            oEditors.getById["content_en"].exec("UPDATE_CONTENTS_FIELD", []);

            oEditors.getById["content_jp"].exec("UPDATE_CONTENTS_FIELD", []);

            oEditors.getById["content_ch"].exec("UPDATE_CONTENTS_FIELD", []);

            if($("select[name='open_status']").val() == ""){
                alert("노출 여부를 선택해주세요.");
                return false;
            }

            $('#boardWriteForm')[0].submit();

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
