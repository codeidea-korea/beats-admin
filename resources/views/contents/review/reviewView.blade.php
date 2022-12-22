@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">리뷰 관리</h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="intro-y col-span-12 lg:col-span-12">

            <div class="intro-y box">

                <div id="boxed-tab" class="p-5">
                    <div class="preview">
                        <ul class="nav nav-boxed-tabs" role="tablist">

                            <li class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2 active" type="button" role="tab" onClick="javascript:location.href = '/contents/reviewView/{{$reviewData[0]->idx}}';">기본 정보</button>
                            </li>
                            <li class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-full py-2" type="button" role="tab" onClick="javascript:location.href = '/contents/reviewCommentView/{{$reviewData[0]->idx}}';">댓글 내역</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="p-5">
                    <div class="overflow-x-auto">
                    <form id="reviewUpdateForm" method="post" action="/contents/reviewUpdate" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input name="idx" type="hidden" value="{{$reviewData[0]->idx}}">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제품명</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        {{$reviewData[0]->wr_title}}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">내용</th>
                                    <td colspan="3">

                                        <div class="flex items-center">
                                            @if($reviewData[0]->review_source != null && $reviewData[0]->review_source != '')
                                                @php
                                                    $review_source = $reviewData[0]->review_source;
                                                    $ext = explode('.', $review_source);
                                                    $ext = end($ext);
                                                @endphp
                                                @if($ext == 'jpg' || $ext == 'png' || $ext == 'svg' || $ext == 'jpeg')
                                                    <img src="{{$reviewData[0]->reviewfullUrl}}" alt="메인 이미지">
                                                @elseif($ext == 'mp4')
                                                    <video controls width="250">
                                                        <source src="{{$reviewData[0]->reviewfullUrl}}" type="video/mp4">
                                                    </video>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="mt-3" style="word-break:break-all">
                                            {{$reviewData[0]->wr_content}}
                                        </div>
                                        @php $i=0; @endphp
                                        @foreach($reviewFileData as $rs)
                                            <div class="flex items-center">
                                                @if($rs->hash_name != null && $rs->hash_name != '')
                                                    @php
                                                        $review_source = $rs->hash_name;
                                                        $ext = explode('.', $review_source);
                                                        $ext = end($ext);
                                                    @endphp
                                                    @if($ext == 'jpg' || $ext == 'png' || $ext == 'svg' || $ext == 'jpeg' || $ext == 'jfif')
                                                        <img src="{{$reviewData[0]->reviewfullUrl}}" alt="메인 이미지">
                                                    @elseif($ext == 'mp4')
                                                        <video controls width="250">
                                                            <source src="{{$reviewData[0]->reviewfullUrl}}" type="video/mp4">
                                                        </video>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="mt-3" style="word-break:break-all">
                                                {{$rs->content}}
                                            </div>
                                            @php $i++; @endphp
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">제품 지정</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        @if($reviewData[0]->product_idx == 0)
                                            미 지정
                                        @else
                                            지정 <div class="btn btn-primary w-32 ml-2 mr-2" onclick="window.open('/products/productView/{{$reviewData[0]->product_idx}}')">자세히 보기</div>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">비트</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$reviewData[0]->wr_bit}} (회)
                                    </td>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">댓글</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$reviewData[0]->wr_comment}} (개)
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">고유 ID</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$reviewData[0]->u_id}}<div class="btn btn-primary w-32 ml-2 mr-2" onclick="window.open('/member/memberView/{{$reviewData[0]->mem_id}}')">자세히 보기</div>
                                    </td>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">언어</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$reviewData[0]->wr_lng}}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최초 등록일</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$reviewData[0]->created_at}}
                                    </td>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">최근 수정일</th>
                                    <td colspan="1" class="whitespace-nowrap">
                                        {{$reviewData[0]->updated_at}}
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="1" class="bg-primary/10 whitespace-nowrap w-32 text-center">노출 상태</th>
                                    <td colspan="3" class="whitespace-nowrap">
                                        <select name="wr_open" class="form-select w-60" aria-label=".form-select-lg example">
                                            <option value="open" @if($reviewData[0]->wr_open == 'open') selected @endif>노출</option>
                                            <option value="secret" @if($reviewData[0]->wr_open == 'secret') selected @endif>비 노출</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <div class="flex items-center justify-center mt-5">
                                <button class="btn btn-primary w-32 ml-2 mr-2 reviewUpdatebtn">수정</button>
                                <button type="button" class="btn btn-secondary w-32" onclick="location.href='/contents/reviewList'">취소</button>
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

        $(document).on('click','.reviewUpdatebtn', function(){

            if($("select[name='wr_open']").val() == ""){
                alert("노출기간을 입력해주세요.");
                return false;
            }

            $('#reviewUpdateForm').submit();

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
    <script>
        function change(page) {
            $("input[name=page]").val(page);
            $("form[name=searchData]").submit();
        }
    </script>
@endsection
