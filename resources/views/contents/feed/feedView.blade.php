@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">피드 관리</h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-12">

            <div class="intro-y box">

                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                    <h2 class="font-medium text-base mr-auto">피드 상세</h2>
                </div>

                <div class="p-5">
                    <div class="overflow-x-auto">
                    <form id="feedUpdateForm" method="post" action="/contents/feedUpdate" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input name="idx" type="hidden" value="{{$feedData[0]->idx}}">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">서비스</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        @if($feedData[0]->wr_type == 'daily') 일상
                                        @elseif($feedData[0]->wr_type == 'cover') 커버곡
                                        @else 자작곡 @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제목</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{$feedData[0]->wr_title}}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($feedData[0]->feed_source != null && $feedData[0]->feed_source != '')
                                                @php 
                                                    $feed_source = $feedData[0]->feed_source;
                                                    $ext = explode('.', $feed_source); 
                                                    $ext = end($ext);
                                                @endphp
                                                @if($ext == 'jpg' || $ext == 'png' || $ext == 'svg' || $ext == 'jpeg')
                                                    <img src="{{$feedData[0]->file_url.$feedData[0]->feed_source}}" alt="메인 이미지">
                                                @elseif($ext == 'mp4')
                                                    <video controls width="250">
                                                        <source src="{{$feedData[0]->file_url.$feedData[0]->feed_source}}" type="video/mp4">
                                                    </video>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="mt-3">
                                            {{$feedData[0]->wr_content}}
                                        </div>
                                        @php $i=0; @endphp
                                        @foreach($feedFileData as $rs)
                                            <div class="flex items-center">
                                                @if($rs->hash_name != null && $rs->hash_name != '')
                                                    @php 
                                                        $feed_source = $rs->hash_name;
                                                        $ext = explode('.', $feed_source);
                                                        $ext = end($ext);
                                                    @endphp
                                                    @if($ext == 'jpg' || $ext == 'png' || $ext == 'svg' || $ext == 'jpeg')
                                                        <img src="{{$rs->file_url.$rs->hash_name}}" alt="메인 이미지">
                                                    @elseif($ext == 'mp4')
                                                        <video controls width="250">
                                                            <source src="{{$rs->file_url.$rs->hash_name}}" type="video/mp4">
                                                        </video>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="mt-3">
                                                {{$rs->feed_content}}
                                            </div>
                                            @php $i++; @endphp
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">비트</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$feedData[0]->wr_bit}} (회)
                                    </td>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">댓글</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$feedData[0]->wr_comment}} (개)
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">신고</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        {{$feedData[0]->wr_report}} (회)
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">작성자</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$feedData[0]->email_id}}
                                    </td>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">언어</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$feedData[0]->wr_lng}}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최초 등록일</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$feedData[0]->created_at}}
                                    </td>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최근 수정일</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$feedData[0]->updated_at}}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">노출 상태</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <select name="wr_open" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="open" @if($feedData[0]->wr_open == 'open') selected @endif>노출</option>
                                            <option value="secret" @if($feedData[0]->wr_open == 'secret') selected @endif>비 노출</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <div class="flex items-center justify-center mt-5">
                                <button class="btn btn-primary w-32 ml-2 mr-2 feedUpdatebtn">수정</button>
                                <button type="button" class="btn btn-secondary w-32" onclick="location.href='/contents/feedList'">취소</button>
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

        $(document).on('click','.feedUpdatebtn', function(){

            if($("select[name='wr_open']").val() == ""){
                alert("노출기간을 입력해주세요.");
                return false;
            }

            $('#feedUpdateForm').submit();

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
