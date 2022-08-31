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
                                        <input type="text" class="form-control" name="id" style="width:420px;" value="{{$adminData->id}}" readonly>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">비밀번호 재설정</th>
                                    <td>
                                        <input type="password" class="form-control" name="password" value="" style="width:420px;" placeholder="비밀번호 표기 영역">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">비밀번호 재설정 확인</th>
                                    <td>
                                        <input type="password" class="form-control" name="password2" value="" style="width:420px;" placeholder="비밀번호와 동일한 비밀번호 입력">
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
                                        <input id="regular-form-1" type="text" class="form-control" style="width:420px;"  value="{{$adminData->adminid}}">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">등록일</th>
                                    <td>
                                        <input id="regular-form-1" type="text" class="form-control" style="width:420px;"  value="{{$adminData->created_at}}" readonly>
                                    </td>
                                </tr>
                            </table>
                            <!-- 테이블 끝 -->
                            <div class="flex justify-between w-full p-5">
                                <div>
                                    <button class="btn btn-dark w-24" type="button" onClick="javascript:location.href = '/admin/list';">목록</button>
                                </div>
                                <div>
                                    <button class="btn btn-primary w-24 ml-2 btn_update" type="submit">수정</button>
                                    <button class="btn btn-primary w-24 ml-2" type="button" onClick="alert();">삭제</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <script>


            $(".btn_create").on('click', function(){

                var isuse = $('select[name=isuse]').val();
                var group_code = $('select[name=group_code]').val();
                var name = $('input[name=name]').val();
                var id = $('input[name=id]').val();
                var password = $('input[name=password]').val();
                var password2 = $('input[name=password2]').val();
                var phoneno = $('input[name=phoneno]').val();
                var email = $('input[name=email]').val();

                var data = {
                    isuse:isuse
                    ,group_code:group_code
                    ,name:name
                    ,id:id
                    ,password:password
                    ,password2:password2
                    ,phoneno:phoneno
                    ,email:email
                };

                jQuery.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"post",
                    dataType:'json',
                    data: data,
                    url: '{{ url('/admin/ajax/adminAdd') }}',
                    success: function searchSuccess(data) {
                        if(data.result=="SUCCESS"){
                            alert('관리자계정이 추가되었습니다.');
                            location.reload();
                        }else{
                            alert('로딩 중 오류가 발생 하였습니다. 다시 시도해주세요.');
                        }
                    },
                    error: function (e) {
                        alert('로딩 중 오류가 발생 하였습니다.');
                    }
                });
            });

        </script>
@endsection
