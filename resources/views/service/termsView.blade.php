@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">약관 관리</h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-12">

            <div class="intro-y box">

                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                    <h2 class="font-medium text-base mr-auto">약관 상세</h2>
                </div>

                <div class="p-5">
                    <div class="overflow-x-auto">
                    <form id="termsUpdateForm" method="post" action="/service/terms/update" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input name="idx" type="hidden" value="{{$termsData[0]->idx}}">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">구분</th>
                                    <td class="whitespace-nowrap">
                                        <select id="gubun" name="gubun" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="">선택</option>
                                            @foreach($gubun as $rs)
                                                <option value="{{$rs->codename}}" @if($termsData[0]->gubun == $rs->codename) selected @endif>{{$rs->codevalue}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-primary/10 whitespace-nowrap w-32 text-center">약관 종류</th>
                                    <td class="whitespace-nowrap">
                                        <select id="terms_type" name="terms_type" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="">선택</option>
                                            @foreach($terms_type as $rs)
                                                <option value="{{$rs->codename}}" @if($termsData[0]->terms_type == $rs->codename) selected @endif>{{$rs->codevalue}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">버전</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            V&nbsp&nbsp<input name="version" id="regular-form-1" type="text" class="form-control" placeholder="Input text" value="{{$termsData[0]->version}}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
                                        <textarea class="form-control" name="content" id="content" style="width:95%"
                                                  rows="20" cols="10"
                                                  placeholder="내용을 입력해주세요"
                                        >{{$termsData[0]->content}}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">관리자</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        {{$termsData[0]->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">적용날짜</th>
                                    <td colspan="3">
                                        <div class="relative inline-block w-56">
                                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                            </div>
                                            <input id="apply_date" name="apply_date" type="text" class="datepicker form-control pl-12" data-single-mode="true" value="{{$termsData[0]->apply_date}}">
                                        </div>

                                        @php
                                            $apply_date_hour = date("H", strtotime($termsData[0]->apply_date));
                                            $apply_date_min = date("i", strtotime($termsData[0]->apply_date));
                                        @endphp

                                        <select name="apply_date_hour" class="form-select w-56" aria-label=".form-select-lg example">
                                            @for ($i = 0; $i <= 24; $i++)
                                                @if($i < 10)
                                                    <option value="0{{$i}}" @if($apply_date_hour == '0'.$i) selected @endif>0{{$i}}</option>
                                                @else
                                                    <option value="{{$i}}" @if($apply_date_hour == $i) selected @endif>{{$i}}</option>
                                                @endif
                                            @endfor
                                        </select>시
                                        <select name="apply_date_min" class="form-select w-56" aria-label=".form-select-lg example">
                                            @for ($i = 0; $i <= 59; $i++)
                                                @if($i < 10)
                                                    <option value="0{{$i}}" @if($apply_date_min == '0'.$i) selected @endif>0{{$i}}</option>
                                                @else
                                                    <option value="{{$i}}" @if($apply_date_min == $i) selected @endif>{{$i}}</option>
                                                @endif
                                            @endfor
                                        </select>분
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최초 등록일</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$termsData[0]->created_at}}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최근 수정일</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$termsData[0]->updated_at}}
                                    </td>
                                </tr>
                            </table>

                            <div class="flex items-center justify-center mt-5">
                                @if($termsData[0]->crVal)
                                <button type="button" class="btn btn-secondary w-32 termsDeletebtn">삭제</button>
                                <div class="btn btn-primary w-32 ml-2 mr-2 termsUpdatebtn">수정</div>
                                @endif
                                <button type="button" class="btn btn-secondary w-32" onclick="location.href='/service/terms/list'">취소</button>
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


        $(document).on('change','#gubun',function(){

            $("#terms_type option").remove();

            jQuery.ajax({
                cache: false,
                dataType:'json',
                data: {
                    gubun : $(this).val()
                },
                url: '/service/terms/termstype',
                success: function (data) {
                    data.forEach(function(item,index) {

                        var dom = document.createElement('option');
                        dom.value = item.codename;
                        dom.text = item.codevalue;

                        $("#terms_type").append(dom);
                    });
                },
                error: function (e) {
                    console.log('start');
                    console.log(e);
                    //alert('로딩 중 오류가 발생 하였습니다.');
                }
            });
        });

        $(document).on('click','.termsUpdatebtn', function(){

            if($("select[name='gubun']").val() == ""){
                alert("구분을 선택해주세요.");
                return false;
            }

            if($("select[name='terms_type']").val() == ""){
                alert("약관 종류를 선택해주세요.");
                return false;
            }

            if($("input[name='version']").val() == ""){
                alert("버전을 입력해주세요.");
                return false;
            }

            if(editor.getData() == ""){
                alert("내용을 입력해주세요.");
                return false;
            }

            if($("#apply_date").val() == ""){
                alert("적용 날짜를 선택해주세요.");
                return false;
            }

            oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
            if($("textarea[name='content']").val() == ""){
                alert("내용을 입력해주세요.");
                return false;
            }
            $('#termsUpdateForm')[0].submit();

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

        $(document).on('click','.termsDeletebtn',function(){
            var idx = $("input[name='idx']").val();
            if(confirm("약관을 삭제하시겠습니까?")){
                jQuery.ajax({
                    cache: false,
                    dataType:'json',
                    data: {
                        idx : idx
                    },
                    url: '/service/terms/delete',
                    success: function (data) {
                        if(data.result == "SUCCESS"){
                            alert('약관이 삭제되었습니다.');
                            location.href="/service/terms/list"
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
