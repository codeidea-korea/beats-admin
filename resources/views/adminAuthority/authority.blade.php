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
                        <form id="authForm" name="authForm" method="post">
                            <input type="hidden" name="gCode" id="gCode" value="{{$params['group_code']}}">
                            <table class="table table-bordered">


                                @foreach(session('ADMINMENULIST') as $rs)

                                @if($rs->depth == 1 && $rs->lcnt==0)
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10" style="text-align:left;" colspan ='2' >{{$rs->menuname}} / {{$rs->menucode}}</th>
                                        </tr>
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10" style="text-align:left;width:120px;"><input type="checkbox" > {{$rs->menuname}} / {{$rs->menucode}}</th>
                                            <td>
                                                <input type="checkbox" > 읽기
                                            </td>
                                        </tr>
                                @elseif($rs->depth == 1&&$rs->lcnt > 0)
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10" style="text-align:left;" colspan ='2' >{{$rs->menuname}} / {{$rs->menucode}}</th>
                                        </tr>
                                @elseif($rs->depth == 2)
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10" style="text-align:left;width:120px;"><input type="checkbox" id="{{$rs->menucode}}_all" onClick="changeCheck('{{$rs->menucode}}');"> {{$rs->menuname}} / {{$rs->menucode}}</th>
                                            <td>
                                                <input type="checkbox" id="{{$rs->menucode}}_s" name="{{$rs->menucode}}_s" value="{{$rs->menucode}}_s"> 읽기 <input type="checkbox" name="{{$rs->menucode}}_i"> 등록 <input type="checkbox" name="{{$rs->menucode}}_u"> 수정 <input type="checkbox" name="{{$rs->menucode}}_d"> 삭제
                                            </td>
                                        </tr>
                                @endif
                            @endforeach
                            </table>
                        </form>
                        <div class="flex justify-between w-full p-5">
                            <div>
                                <button class="btn btn-primary w-24 ml-2 btn_create" >저장</button>
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
        $(".btn_create").on('click', function(){
            alert(1);

            var formData = $("#authForm").serialize();
            alert(2);
            jQuery.ajax({

                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"post",
                dataType:'json',
                data: formData,
                url: '{{ url('/admin/authUpdate') }}',
                success: function searchSuccess(data) {
                    alert();

                },
                error: function (e) {
                    console.log('start');
                    console.log(e);
                    alert('로딩 중 오류가 발생 하였습니다.');
                }
            });
        });
        function changeCheck(code){
            //$("input:checkbox[name='AD000100_s']").prop("checked", true);
            //$('#AD000100_ss').prop("checked", true);


            if($('#'+code+'_all').is(":checked") == true){
                var codeName= code+'_s';

                $('#'+codeName).is('checked');

                //$("input:checkbox[id='"+code+"_s']").prop("checked",true);

                //$("input:checkbox[name='AD000100_s']").prop("checked", true);
                //$("input:checkbox[id='AD000100_s']").prop("checked", true);
                //$("input:checkbox[id='"+code+"_s']").prop("checked", true);
                //$("input:checkbox[id='"+code+"_i']").prop("checked", true);
                //$("input:checkbox[id='"+code+"_u']").prop("checked", true);
                //$("input:checkbox[id='"+code+"_d']").prop("checked", true);
            }else{
                alert('nop!');
            }
        }
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
                 //           url: '{{-- url('/admin/ajax/adminAdd') --}}',
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
