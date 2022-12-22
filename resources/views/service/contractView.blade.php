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

                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">약식 계약서 상세</h2>
                    </div>

                    <div class="p-5">
                        <div class="overflow-x-auto">

                                <table class="table table-bordered">

                                    <tr>
                                        <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">버전</th>
                                        <td colspan="3" class="whitespace-nowrap">
                                            <div class="flex items-center">
                                                {{$data->version}}v
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
                                            >{{$data->contents}}</textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">관리자</th>
                                        <td colspan="3" class="whitespace-nowrap">
                                            {{$data->name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최초 등록일</th>
                                        <td colspan="1" class="whitespace-nowrap">
                                            {{$data->crdate}}
                                        </td>
                                        <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">적용날짜</th>
                                        <td colspan="1" class="whitespace-nowrap">
                                            {{$data->start_date}}
                                        </td>
                                    </tr>
                                </table>
                            <form id="boardUpdateForm" method="post" action="/service/board/update" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input name="idx" type="hidden" value="{{$data->idx}}">
                            </form>
                                <div class="flex items-center justify-center mt-5">
                                    <button class="btn btn-primary w-32 ml-2 mr-2" style="width:180px">이전 약식 계약서</button>
                                    <button type="button" class="btn btn-primary w-32 ml-2 mr-2 deletebtn">삭제</button>
                                    <button type="button" class="btn btn-secondary w-32" onclick="location.href='/service/contract/list'">목록</button>
                                </div>

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

        $(document).on('click','.deletebtn',function(){
            var idx = $("input[name='idx']").val();
            var data = {
                idx:idx
            };
            if(confirm("계약서를 삭제하시겠습니까?")){
                jQuery.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"post",
                    dataType:'json',
                    data: data,
                    url: '{{ url('/service/contract/delete') }}',
                    success: function (data) {
                        if(data.result == "SUCCESS"){
                            alert('계약서가 삭제되었습니다.');
                            location.href='{{ url('/service/contract/list') }}';
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

