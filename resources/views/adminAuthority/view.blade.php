@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">관리자 등록</h2>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">
                    <input type="hidden" name="idckYN" id="idckYN" value="N">
                    <input type="hidden" name="idx" id="idx" value="{{$params['idx']}}">
                    <!-- table 시작 -->
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">상태</th>
                                    <td>
                                        <select class="form-select w-60" aria-label=".form-select-lg" name="isuse">
                                            <option value="Y" @if($adminData->isuse=="Y") selected @endif>활성화</option>
                                            <option value="N" @if($adminData->isuse=="N") selected @endif>비활성화</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">그룹</th>
                                    <td>
                                        <select class="form-select w-60" aria-label=".form-select-lg" name="group_code">
                                            @foreach($groupList as $rs)
                                                <option value="{{$rs->group_code}}" @if($adminData->group_code==$rs->group_code) selected @endif >{{$rs->group_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">이름</th>
                                    <td>
                                        <input type="text" class="form-control" name="name" style="width:420px;" value="{{$adminData->name}}">
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">아이디</th>
                                    <td>
                                        {{$adminData->id}}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">비밀번호 재설정</th>
                                    <td>
                                        <input type="button" class="btn btn-primary w-24 ml-2" name="rePassword" value="비밀번호 재설정" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview3" style="width:220px;">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">연락처</th>
                                    <td>
                                        <input id="regular-form-1" type="text" class="form-control" style="width:420px;" name="phoneno" value="{{$adminData->phoneno}}">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">이메일</th>
                                    <td>
                                        <input id="regular-form-1" type="email"class="form-control" style="width:420px;" name="email" value="{{$adminData->email}}">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">등록자</th>
                                    <td>
                                        {{$adminData->adminid}}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">등록일</th>
                                    <td>
                                        {{$adminData->created_at}}
                                    </td>
                                </tr>
                            </table>
                            <!-- 테이블 끝 -->
                            <div class="flex justify-between w-full p-5">
                                <div>
                                    <button class="btn btn-dark w-24" type="button" onClick="javascript:location.href = '/admin/list';">목록</button>
                                </div>
                                <div>
                                    <button class="btn btn-primary w-24 ml-2 btn_update" type="button">수정</button>
                                    <button class="btn btn-primary w-24 ml-2" type="button" onClick="alert();">삭제</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- 비밀번호 변경 모달 시작 -->
        <div id="superlarge-modal-size-preview3" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header pl-10 pr-10 pt-10">
                        <h2 class="font-medium text-base mr-auto">비밀번호 변경</h2>
                    </div>
                    <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->
                    <div class="modal-body p-10 grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12">
                            <label for="modal-form-1" class="form-label">새로운 비밀번호</label>
                            <input id="modal-form-1" type="password" name="password" id="password" class="form-control" placeholder="변경하실 비밀번호를 입력해주세요.">
                        </div>
                        <div class="col-span-12">
                            <label for="modal-form-2" class="form-label">새로운 비밀번호 재입력</label>
                            <input id="modal-form-2" type="password" name="password2" class="form-control" placeholder="새로운 비밀번호 재입력">
                        </div>
                        <div class="col-span-12">
                            <div class="flex items-center justify-center mt-5">
                                <button class="btn btn-primary w-32 mr-5 pwCahnge">변경하기</button>
                                <button class="btn btn-secondary w-32 modalCancel" data-tw-dismiss="modal">취소</button>
                            </div>
                        </div>
                    </div>
                    <!-- END: Modal Body -->
                </div>
            </div>
        </div>
        <!-- 비밀번호 변경 modal 끝 -->



        <script>


            $(".btn_update").on('click', function(){
                 var isuse = $('select[name=isuse]').val();
                 var group_code = $('select[name=group_code]').val();
                 var name = $('input[name=name]').val();
                 var idx = $('input[name=idx]').val();
                 var phoneno = $('input[name=phoneno]').val();
                 var email = $('input[name=email]').val();


                 var data = {
                     isuse:isuse
                     ,group_code:group_code
                     ,name:name
                     ,idx:idx
                     ,phoneno:phoneno
                     ,email:email
                 };

                 jQuery.ajax({
                     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                     type:"post",
                     dataType:'json',
                     data: data,
                     url: '{{ url('/admin/ajax/adminUpdate') }}',
                     success: function searchSuccess(data) {
                         if(data.result=="SUCCESS"){
                             alert('관리자정보가 수정되었습니다.');
                             location.reload();
                         }else{
                             alert('처리 중 오류가 발생 하였습니다. 다시 시도해주세요.');
                         }
                     },
                     error: function (e) {
                         alert('로딩 중 오류가 발생 하였습니다.');
                     }
                 });
            });

            $(".pwCahnge").on('click', function(){

                var idx = $('input[name=idx]').val();
                var password = $('input[name=password]').val();
                var password2 = $('input[name=password2]').val();

                if(password != password2){
                    alert("비밀번호가 일치하지 않습니다.");
                    $('input[name=password]').val('');
                    $('input[name=password2]').val('');
                    return false;
                }

                var data = {
                    idx:idx
                    ,password:password
                };

                jQuery.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"post",
                    dataType:'json',
                    data: data,
                    url: '{{ url('/admin/ajax/changePw') }}',
                    success: function searchSuccess(data) {
                        if(data.result=="SUCCESS"){
                            alert('비밀번호가 변경되었습니다.');
                            location.reload();
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
