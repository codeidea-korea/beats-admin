@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">전환 신청</h2>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">


                    <input type="hidden" name="mem_id" id="mem_id" value="{{$params['mem_id']}}">
                    <!-- table 시작 -->
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">서비스</th>
                                    <td colspan="3">
                                        바이비츠
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">이메일 ID</th>
                                    <td>
                                        {{$memberData->email_id}}
                                    </td>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">가입 채널</th>
                                    <td>
                                        {{$memberData->channelValue}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">닉네임</th>
                                    <td>
                                        {{$memberData->mem_nickname}}
                                    </td>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">회원구분</th>
                                    <td>
                                        {{$memberData->gubunValue}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">국적</th>
                                    <td>
                                        {{$memberData->nati}}
                                    </td>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">제재</th>
                                    <td>
                                        {{$memberData->mem_sanctions}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">가입일</th>
                                    <td colspan="3">
                                        {{$memberData->created_at}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">전문분야</th>
                                    <td colspan="3">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">전문 분야</th>
                                                <td>{{$memberData->field1Value}}</td>
                                            </tr>
                                            <tr>
                                                <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">추가 분야</th>
                                                <td>{{$memberData->field2Value}}</td>
                                            </tr>
                                            <tr>
                                                <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">추가 분야</th>
                                                <td>{{$memberData->field3Value}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">증빙자료</th>
                                    <td colspan="3">
                                        <form id="downFile">
                                            @php $i=1; @endphp
                                            @foreach($mentoFileData as $rs)
                                                <div style="line-height:25px;"><a href="javascript:download('{{$rs->mentoFileUrl}}','{{$rs->file_name}}');"><input type="hidden" name="file{{$i}}" id="file{{$i}}" value="{{$rs->mentoFileUrl}}" /><input type="hidden" name="fileName{{$i}}" id="fileName{{$i}}" value="{{$rs->file_name}}" /><label for="file{{$i}}">{{$rs->file_name}}</label></a></div>
                                            @php $i++; @endphp
                                            @endforeach
                                            <br>
                                            <div class="btn-primary w-52 btn " onclick="suffix=1;downloadAll();return false" style="">증빙자료 전체 다운로드</div>

                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">신청일</th>
                                    <td>
                                        {{$memberData->mem_moddate}}
                                    </td>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">상태</th>
                                    <td>
                                        <select class="form-select w-60 mentoStatus" aria-label=".form-select-lg" name="mento_status">
                                            <option value="2" @if($memberData->mento_status == 2) selected @endif >대기</option>
                                            <option value="3" @if($memberData->mento_status == 3) selected @endif >승인</option>
                                            <option value="1" @if($memberData->mento_status == 1) selected @endif >반려</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr id="rejects" @if($memberData->mento_status != 1) style="position:absolute; right:-9999px" @endif>
                                    <th class="whitespace-nowrap text-center bg-primary/10" >반려사유</th>
                                    <td colspan="3">
                                        <input type="text" class="form-control" style="width:600px;" id="reject" name="reject" value="{{$memberData->mento_reject}}">
                                    </td>
                                </tr>
                            </table>

                            <!-- 테이블 끝 -->
                            <div class="flex justify-between w-full p-5">
                                <div>
                                    <button class="btn btn-dark w-24" type="button" onClick="javascript:location.href = '/mento/mentoList';">목록</button>
                                </div>
                                <div>
                                    <button class="btn btn-primary w-24 ml-2 btn_update" type="button">수정</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script>
            function downloadAll() {
                var fCount = {{count($mentoFileData)}};
                for (var i = 1; i <= fCount; i++) {
                    window.open('/downloadFile?furl=' + $('input[name=file' + i + ']').val()+'&fileName='+$('input[name=fileName' + i + ']').val());
                }
            }
            function download(url,name) {
                    window.open('/downloadFile?furl=' + url+'&fileName='+name);
            }

            $(".mentoStatus").on('change', function(){
                var mStatus = $('select[name=mento_status]').val();
                if(mStatus == 1){
                    $('#rejects').css('position','relative');
                    $('#rejects').css('right','0px');
                }else{
                    $('#rejects').css('position','absolute');
                    $('#rejects').css('right','-9999px');
                }

            });

            $(".btn_update").on('click', function(){

                var formData = new FormData;
                var mento_status = $('select[name=mento_status]').val();
                var mem_id = $('input[name=mem_id]').val();
                formData.append('mento_status',mento_status);
                formData.append('mem_id',mem_id);
                if(mento_status == 1){
                    var reject = $('input[name=reject]').val();
                    formData.append('reject',reject);
                }

                jQuery.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"post",
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: formData,
                    url: '{{ url('/mento/ajax/mentoChUpdate') }}',
                    success: function searchSuccess(data) {
                        if(data.result=="SUCCESS"){
                            alert('수정되었습니다.');
                            location.href="/mento/mentoList";
                        }else{
                            alert('처리 중 오류가 발생 하였습니다. 다시 시도해주세요.');
                        }
                    },
                    error: function (e) {
                        alert('로딩 중 오류가 발생 하였습니다.');
                    }
                });
            });

        </script>
@endsection
