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
                                        <input type="text" class="form-control" name="name" value="" placeholder="이름 표기 영역">
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">아이디</th>
                                    <td>
                                        <input type="text" class="form-control" name="id" value="" placeholder="이름 표기 영역">
                                        <button class="btn btn-purple" type="button">중복 확인</button>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">비밀번호</th>
                                    <td>
                                        <input type="text" class="form-control" name="password" value="" placeholder="이름 표기 영역">
                                    </td>
                                </tr>




                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">tkd</th>
                                    <td>
                                        <input id="regular-form-1" type="text" class="form-control" placeholder="제품명 표기 영역">
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">(영어)제품영</th>
                                    <td >
                                        <input id="regular-form-1" type="text" class="form-control" placeholder="(영어) 제품명 표기 영역">

                                    </td>
                                </tr>


                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">관리자</th>
                                    <td>조정훈</td>
                                </tr>
                            </table>
                            <!-- 테이블 끝 -->
                            <div class="flex justify-between w-full p-5">
                                <div>
                                    <button class="btn btn-dark w-24">목록</button>
                                </div>
                                <div>
                                    <button class="btn btn-secondary w-24">삭제</button>
                                    <button class="btn btn-primary w-24 ml-2">수정</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <!-- 공지사항 -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">관리자 등록</h3>
            </div>
            <div class="panel-body">
                <form name="RegForm" class="form-horizontal" role="form" id="RegForm"  method="post" action="{{ url('/admin/ajax/adminAdd') }}">
                    @csrf


                    <div class="form-group" >
                        <label class="col-sm-2 control-label" for="field-1">이름</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="">
                        </div>
                    </div>
                    <div class="form-group-separator"></div>



                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="field-1">아이디</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="id" value="">
                            <button class="btn btn-purple" type="button">중복 확인</button>
                        </div>
                    </div>
                    <div class="form-group-separator"></div>
                    <div class="form-group" >
                        <label class="col-sm-2 control-label" for="field-1">비밀번호</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" name="password" value="">
                        </div>
                        <label class="col-sm-2 control-label" for="field-1">비밀번호 확인</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" name="password2" value="">
                        </div>
                    </div>
                    <div class="form-group-separator"></div>

                    <div class="form-group" >
                        <label class="col-sm-2 control-label" for="field-1">연락처</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="phoneno" value="">
                        </div>
                    </div>
                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="field-1">Email</label>

                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" value="">
                        </div>
                    </div>
                    <div class="form-group-separator"></div>
                    <div style="float:right;">
                        <button class="btn btn-purple btn_create" type="submit">등록</button>
                        <button class="btn btn-red" type="button" onClick="alert();">취소</button>
                        <button class="btn btn-blue" type="button" onClick="javascript:location.href = '/admin/list';">목록</button>
                    </div>

                </form>

            </div>

        </div>
        <script>
            /*
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
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type:"post",
                        //contentType: "application/json; charset=utf-8",
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType:'json',

                        data: data,
                        url: '{{ url('/admin/ajax/adminAdd') }}',
                        success: function searchSuccess(data) {
                            if(data.result=="SUCCESS"){
                                alert('관리자계정이 추가되었습니다.');
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
                    });

                });
            */

        </script>
@endsection
