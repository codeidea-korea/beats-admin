@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">이벤트</h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-12">

            <div class="intro-y box">

                <div class="p-5">
                    <div class="overflow-x-auto">
                        <form id="boardWriteForm" method="post" action="/service/event/add" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="title" id="regular-form-1" type="text" class="form-control" placeholder="Input text">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">대표 이미지</th>
                                    <td>
                                        <input type="file" name="event_img" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
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
                                            <textarea class="form-control" id="editor1" name="editor1"></textarea>
                                        </div>
                                        <textarea name="content" id="content" class="hidden"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">이벤트기간</th>
                                    <td colspan="3">
                                        <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                            <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                            <input name="event_date" type="text" class="datepicker form-control sm:w-56 box pl-10" value="">
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

    <script src="/dist/js/ckeditor.js"></script>
    <script src="/dist/js/ck.upload.adapter.js"></script>

    <script>

        var ajax_checked = false;
        let editor;

        ClassicEditor
        .create( document.querySelector( '#editor1' ), {
            ckfinder: {
                uploadUrl: "{{route('ckeditor.upload').'?_token='.csrf_token()}}"
            }
        })
        .then(newEditor => {
            editor = newEditor;
        })
        .catch( error => {
            console.error( error );
        } );
        
        // 값 가져오기

        $(document).on('click','.boardAddbtn', function(){

            if($("input[name='title']").val() == ""){
                alert("제목을 입력해주세요.");
                return false;
            }

            if($("input[name='event_img']").val() == ""){
                alert("대표 이미지를 입력해주세요.");
                return false;
            }

            if(editor.getData() == ""){
                alert("내용을 입력해주세요.");
                return false;
            }

            if($("input[name='event_date']").val() == ""){
                alert("이벤트 기간을 입력해주세요.");
                return false;
            }

            if($("select[name='open_status']").val() == ""){
                alert("노출 여부를 선택해주세요.");
                return false;
            }

            $("#content").val(editor.getData());

            $('#boardWriteForm').submit();

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
