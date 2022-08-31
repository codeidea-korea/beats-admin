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
                    {{--
                    <form name="RegForm" class="form-horizontal" role="form" id="RegForm"  method="post" action="{{ url('/admin/ajax/adminAdd') }}">
                        <input type="hidden" name="idckYN" id="idckYN" value="N">
                    @csrf
                    --}}
                    <input type="hidden" name="idckYN" id="idckYN" value="N">
                    <!-- table 시작 -->
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">상태</th>
                                    <td>
                                        <select class="form-select w-60" aria-label=".form-select-lg" name="isuse">
                                            <option value="Y" >활성화</option>
                                            <option value="N" >비활성화</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">그룹</th>
                                    <td>
                                        <select class="form-select w-60" aria-label=".form-select-lg" name="group_code">
                                            @foreach($groupList as $rs)
                                                <option value="{{$rs->group_code}}" >{{$rs->group_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">이름</th>
                                    <td>
                                        <input type="text" class="form-control" name="name" value="" style="width:420px;" placeholder="이름 표기 영역">
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">아이디</th>
                                    <td>
                                        <input type="text" class="form-control" name="id" value="" style="width:420px;" placeholder="아이디 표기 영역">
                                        <button class="btn btn-purple idck" type="button">중복 확인</button>
                                        <label class="idck_y" style="color:red;display:none;">중복확인 완료</label><label class="idck_n" style="color:red;display:none;">중복된 아이디 입니다.</label>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">비밀번호</th>
                                    <td>
                                        <input type="password" class="form-control" name="password" value="" style="width:420px;" placeholder="비밀번호 표기 영역">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">비밀번호 확인</th>
                                    <td>
                                        <input type="password" class="form-control" name="password2" value="" style="width:420px;" placeholder="비밀번호와 동일한 비밀번호 입력">
                                    </td>
                                </tr>



                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">연락처</th>
                                    <td>
                                        <input id="regular-form-1" type="text" class="form-control" style="width:420px;" name="phoneno" value="">
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">이메일</th>
                                    <td>
                                        <input id="regular-form-1" type="email"class="form-control" style="width:420px;" name="email">
                                    </td>
                                </tr>
                            </table>
                            <!-- 테이블 끝 -->
                            <div class="flex justify-between w-full p-5">
                                <div>
                                    <button class="btn btn-dark w-24" type="button" onClick="javascript:location.href = '/admin/list';">목록</button>
                                </div>
                                <div>
                                    <button class="btn btn-primary w-24 ml-2 btn_create" type="submit">등록</button>
                                    <button class="btn btn-primary w-24 ml-2" type="button" onClick="alert();">취소</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--
                    </form>
                    --}}
                </div>
            </div>
        </div>



        <script>
            $(".idck").on('click', function(){

                $(".idck_y").hide();
                $(".idck_n").hide();
                $("#idckYN").val("N");
                var data = {
                    id:$('input[name=id]').val()
                };
                jQuery.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"get",
                    dataType:'json',
                    data: data,
                    url: '{{ url('/admin/ajax/adminIdCheck') }}',
                    success: function searchSuccess(data) {

                        if(data == 1){
                            alert("중복 있음");
                            $(".idck_y").hide();
                            $(".idck_n").show();
                            $("#idckYN").val("N");

                        }else{
                            alert("중복 없음");
                            $(".idck_y").show();
                            $(".idck_n").hide();
                            $("#idckYN").val("Y");
                        }
                    },
                    error: function (e) {
                        console.log('start');
                        console.log(e);
                        alert('로딩 중 오류가 발생 하였습니다.');
                    }
                });

            });


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
