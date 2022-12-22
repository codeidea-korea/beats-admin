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
                                <button class="nav-link w-full py-2 active" type="button" role="tab" onClick="javascript:location.href = '/service/trendView/{{$trendData[0]->idx}}';">기본 정보</button>
                            </li>
                            <li class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2" type="button" role="tab" onClick="javascript:location.href = '/service/trendBeatView/{{$trendData[0]->idx}}';">비트 내역</button>
                            </li>
                            <li class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2" type="button" role="tab" onClick="javascript:location.href = '/service/trendCommentView/{{$trendData[0]->idx}}';">댓글 내역</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="p-5">
                    <div class="overflow-x-auto">
                    <form id="boardUpdateForm" method="post" action="/service/trend/update" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input name="idx" type="hidden" value="{{$trendData[0]->idx}}">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">구분</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <select name="gubun" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="국내 음악" @if($trendData[0]->gubun == '국내 음악') selected @endif>국내 음악</option>
                                            <option value="해외 음악" @if($trendData[0]->gubun == '해외 음악') selected @endif>해외 음악</option>
                                            <option value="음원 발매" @if($trendData[0]->gubun == '음원 발매') selected @endif>음원 발매</option>
                                            <option value="공연" @if($trendData[0]->gubun == '공연') selected @endif>공연</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="title" id="regular-form-1" type="text" class="form-control" placeholder="Input text" value="{{$trendData[0]->title}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목(영어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="title_en" id="regular-form-2" type="text" class="form-control" placeholder="Input text" value="{{$trendData[0]->title_en}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목(일어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="title_jp" id="regular-form-3" type="text" class="form-control" placeholder="Input text" value="{{$trendData[0]->title_jp}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목(중국어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input name="title_ch" id="regular-form-4" type="text" class="form-control" placeholder="Input text" value="{{$trendData[0]->title_ch}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">이미지</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <input name="trend_img" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="formFile">
                                        <img class="up_trend_img" src="/storage/trend/{{$trendData[0]->trand_source}}" alt="팝업 이미지">
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
                                        <textarea class="form-control" name="content" id="content" style="width:95%"
                                                  rows="20" cols="10"
                                                  placeholder="내용을 입력해주세요">{{$trendData[0]->content}}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용(영어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <textarea class="form-control" name="content_en" id="content_en" rows="20" cols="10" style="width:95%" placeholder="내용을 입력해주세요">{{$trendData[0]->content_en}}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용(일어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <textarea class="form-control" name="content_jp" id="content_jp" rows="20" cols="10" style="width:95%" placeholder="내용을 입력해주세요">{{$trendData[0]->content_jp}}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용(중국어)</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <textarea class="form-control" name="content_ch" id="content_ch" rows="20" cols="10" style="width:95%" placeholder="내용을 입력해주세요">{{$trendData[0]->content_ch}}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">노출 여부</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <select name="open_status" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="Y" @if($trendData[0]->open_status == 'Y') selected @endif>노출</option>
                                            <option value="N" @if($trendData[0]->open_status == 'N') selected @endif>미 노출</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">관리자</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        {{$trendData[0]->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최초 등록일</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$trendData[0]->created_at}}
                                    </td>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최근 수정일</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$trendData[0]->updated_at}}
                                    </td>
                                </tr>
                            </table>

                            <div class="flex items-center justify-center mt-5">
                                <button type="button" class="btn btn-secondary w-32 boardDeletebtn">삭제</button>
                                <div class="btn btn-primary w-32 ml-2 mr-2 boardUpdatebtn">수정</div>
                                <button type="button" class="btn btn-secondary w-32" onclick="location.href='/service/trend/list'">취소</button>
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

        $(document).on('click','.boardUpdatebtn', function(){

            if($("input[name='title']").val() == ""){
                alert("제목을 입력해주세요.");
                return false;
            }

            if($("select[name='open_status']").val() == ""){
                alert("노출 여부를 선택해주세요.");
                return false;
            }

            if($("select[name='gubun']").val() == ""){
                alert("구분을 선택해주세요.");
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


            $('#boardUpdateForm')[0].submit();

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
            if(confirm("트렌드를 삭제하시겠습니까?")){
                jQuery.ajax({
                    cache: false,
                    dataType:'json',
                    data: {
                        idx : idx
                    },
                    url: '/service/trend/delete',
                    success: function (data) {
                        if(data.result == "SUCCESS"){
                            alert('트렌드가 삭제되었습니다.');
                            location.href="/service/trend/list"
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
