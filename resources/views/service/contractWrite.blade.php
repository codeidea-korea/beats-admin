@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">약식 계약서</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">

                <div class="intro-y box">

                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <form id="boardWriteForm" method="post" action="/service/contract/add" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <table class="table table-bordered">
                                    <tr>
                                        <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">버전</th>
                                        <td colspan="3" class="whitespace-nowrap">
                                            <div class="flex items-center">
                                                <input type="text" name="version" id="regular-form-1"  class="form-control" style="width:20%" placeholder="버전 입력 (예 : 1.5)">V
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용</th>
                                        <td colspan="3" class="whitespace-nowrap">
                                            <div class="p-5" id="classic-editor">
                                                <!-- <div class="preview">
                                                    <div class="editor">
                                                    </div>
                                                </div>
                                                <div class="source-code hidden">
                                                    <button data-target="#copy-classic-editor" class="copy-code btn py-1 px-2 btn-outline-secondary"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Copy example code </button>
                                                    <div class="overflow-y-auto mt-3 rounded-md">
                                                        <pre class="source-preview" id="copy-classic-editor"> <code class="javascript"> import ClassicEditor from &quot;@ckeditor/ckeditor5-build-classic&quot;; $(&quot;.editor&quot;).each(function () { const el = this;  ClassicEditor.create(el).then( newEditor => {editor = newEditor;} ).catch((error) =HTMLCloseTag { console.error(error); }); }); </code> </pre>
                                                    </div>
                                                </div> -->
                                                <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
                                                <textarea class="form-control" name="content" id="content"
                                                          rows="20" cols="10"
                                                          placeholder="내용을 입력해주세요"
                                                ></textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">관리자</th>
                                        <td colspan="3">
                                            {{auth()->user()->name}}
                                            <input type="hidden" name="adminidx" value="{{auth()->user()->idx}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">적용기간</th>
                                        <td colspan="3">
                                            <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                                <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                                <input name="start_date" type="text" class="datepicker form-control sm:w-56 box pl-10" data-single-mode="true" value="">
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                                <div class="flex items-center justify-center mt-5">
                                    <button class="btn btn-primary w-32 ml-2 mr-2 boardAddbtn">등록</button>
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
        })

        // 값 가져오기

        $(document).on('click','.boardAddbtn', function(){

            if($("input[name='version']").val() == ""){
                alert("버전을 입력해주세요.");
                return false;
            }

            oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
            if($("textarea[name='content']").val() == ""){
                alert("내용을 입력해주세요.");
                return false;
            }

            $('#boardWriteForm').submit();

        });
    </script>
@endsection
