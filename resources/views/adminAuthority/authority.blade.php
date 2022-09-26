@extends('layouts.default')
@section('content')

<div class="content">
    <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">권한 관리</h2>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box">
                    <!-- table 시작 -->
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <form name="RegForm" class="form-horizontal" role="form" id="RegForm"  method="get" action="{{url('/admin/authority')}}">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="width:220px;">그룹</th>
                                    <td>
                                        <select class="form-select w-60" aria-label=".form-select-lg" name="group_code" id="group_code" onChange="chGroup();">
                                            @foreach($groupList as $rs)
                                                <option value="{{$rs->group_code}}" @if($rs->group_code==$params['group_code']) selected @endif>{{$rs->group_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            </form>
                        </div>
                    </div>
            </div>

            <div class="intro-y box">

                <div class="p-5">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">권한설정</h2>
                    </div>
                    <div class="overflow-x-auto">
                            <!-- 테이블 끝 -->
                            <table class="table table-bordered">
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="text-align:left;width:120px;"><input type="checkbox" > 대시보드</th>
                                    <td>
                                        <input type="checkbox" > 읽기
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" style="text-align:left;" colspan ='2' ><input type="checkbox" > 메인관리</th>

                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" ><input type="checkbox" > 배너 관리</th>
                                    <td>
                                        <input type="checkbox" > 읽기
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" ><input type="checkbox" > 팝업 관리</th>
                                    <td>
                                        <input type="checkbox" > 읽기
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10" ><input type="checkbox" > 푸시 관리</th>
                                    <td>
                                        <input type="checkbox" > 읽기
                                    </td>
                                </tr>
                            </table>
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



            </div>
        </div>
    </div>



    <script>
        $("#group_code").on('change', function(){
            document.forms["RegForm"].submit();
        });
     //
     //   $(".idck").on('click', function(){
//
     //       $(".idck_y").hide();
     //       $(".idck_n").hide();
     //       $("#idckYN").val("N");
     //       var data = {
     //           id:$('input[name=id]').val()
     //       };
     //       jQuery.ajax({
     //           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
     //           type:"get",
     //           dataType:'json',
     //           data: data,
     //           url: '{{ url('/admin/ajax/adminIdCheck') }}',
     //           success: function searchSuccess(data) {
//
     //               if(data == 1){
     //                   alert("중복 있음");
     //                   $(".idck_y").hide();
     //                   $(".idck_n").show();
     //                   $("#idckYN").val("N");
//
     //               }else{
     //                   alert("중복 없음");
     //                   $(".idck_y").show();
     //                   $(".idck_n").hide();
     //                   $("#idckYN").val("Y");
     //               }
     //           },
     //           error: function (e) {
     //               console.log('start');
     //               console.log(e);
     //               alert('로딩 중 오류가 발생 하였습니다.');
     //           }
     //       });
//
     //   });
//
//
     //   $(".btn_create").on('click', function(){
//
     //       var isuse = $('select[name=isuse]').val();
     //       var group_code = $('select[name=group_code]').val();
     //       var name = $('input[name=name]').val();
     //       var id = $('input[name=id]').val();
     //       var password = $('input[name=password]').val();
     //       var password2 = $('input[name=password2]').val();
     //       var phoneno = $('input[name=phoneno]').val();
     //       var email = $('input[name=email]').val();
//
     //       var data = {
     //           isuse:isuse
     //           ,group_code:group_code
     //           ,name:name
     //           ,id:id
     //           ,password:password
     //           ,password2:password2
     //           ,phoneno:phoneno
     //           ,email:email
     //       };
//
     //       jQuery.ajax({
     //           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
     //           type:"post",
     //           dataType:'json',
     //           data: data,
     //           url: '{{ url('/admin/ajax/adminAdd') }}',
     //           success: function searchSuccess(data) {
     //               if(data.result=="SUCCESS"){
     //                   alert('관리자계정이 추가되었습니다.');
     //                   location.reload();
     //               }else{
     //                   alert('로딩 중 오류가 발생 하였습니다. 다시 시도해주세요.');
     //               }
     //           },
     //           error: function (e) {
     //               alert('로딩 중 오류가 발생 하였습니다.');
     //           }
     //       });
     //   });

    </script>
    @endsection
