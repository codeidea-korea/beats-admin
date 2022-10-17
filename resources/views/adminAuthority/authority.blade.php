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
                                        <select class="form-select w-60" aria-label=".form-select-lg" name="group_code" id="group_code">
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
                        <form id="authForm2" name="authForm2" class="form-horizontal" role="form"  method="post">
                            <input type="hidden" name="gCode" id="gCode" value="{{$params['group_code']}}">
                            <table class="table table-bordered">


                                @foreach(session('ADMINMENULIST') as $rs)

                                @if($rs->depth == 1 && $rs->lcnt==0)
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10" style="text-align:left;width:120px;">

                                                {{$rs->menuname}}
                                            </th>
                                            <td>
                                                <input type="checkbox" name="menuAuthCheck" value="{{$rs->menucode}}_s" id="{{$rs->menucode}}_s" @if(strpos($auth_arr,$rs->menucode."_s") !== false) checked @endif > 읽기
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10" style="text-align:left;width:120px;"><input type="checkbox" id="{{$rs->menucode}}_all" onClick="changeCheck('{{$rs->menucode}}');"> {{$rs->menuname}}</th>
                                            <td>
                                                <input type="checkbox" name="menuAuthCheck" value="{{$rs->menucode}}_s" id="{{$rs->menucode}}_s" @if(strpos($auth_arr,$rs->menucode."_s") !== false) checked @endif > 읽기
                                                @if($rs->menucode != "AD010000")
                                                <input type="checkbox" name="menuAuthCheck" value="{{$rs->menucode}}_i" id="{{$rs->menucode}}_i" @if(strpos($auth_arr,$rs->menucode."_i") !== false) checked @endif > 등록
                                                <input type="checkbox" name="menuAuthCheck" value="{{$rs->menucode}}_u" id="{{$rs->menucode}}_u" @if(strpos($auth_arr,$rs->menucode."_u") !== false) checked @endif > 수정
                                                <input type="checkbox" name="menuAuthCheck" value="{{$rs->menucode}}_d" id="{{$rs->menucode}}_d" @if(strpos($auth_arr,$rs->menucode."_d") !== false) checked @endif > 삭제
                                                @endif
                                            </td>
                                        </tr>
                                @elseif($rs->depth == 1&&$rs->lcnt > 0)
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10" style="text-align:left;width:120px;">
                                                {{$rs->menuname}}
                                            </th>
                                            <td>
                                                <input type="checkbox" name="menuAuthCheck" value="{{$rs->menucode}}_s" id="{{$rs->menucode}}_s" @if(strpos($auth_arr,$rs->menucode."_s") !== false) checked @endif > 읽기
                                            </td>
                                        </tr>
                                @elseif($rs->depth == 2)
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10" style="text-align:left;width:120px;"><input type="checkbox" id="{{$rs->menucode}}_all" onClick="changeCheck('{{$rs->menucode}}');"> {{$rs->menuname}}</th>
                                            <td>
                                                <input type="checkbox" name="menuAuthCheck" value="{{$rs->menucode}}_s" id="{{$rs->menucode}}_s" @if(strpos($auth_arr,$rs->menucode."_s") !== false) checked @endif > 읽기
                                                @if($rs->menucode != "AD120200")
                                                <input type="checkbox" name="menuAuthCheck" value="{{$rs->menucode}}_i" id="{{$rs->menucode}}_i" @if(strpos($auth_arr,$rs->menucode."_i") !== false) checked @endif > 등록
                                                @endif
                                                <input type="checkbox" name="menuAuthCheck" value="{{$rs->menucode}}_u" id="{{$rs->menucode}}_u" @if(strpos($auth_arr,$rs->menucode."_u") !== false) checked @endif > 수정
                                                @if($rs->menucode != "AD120200")
                                                <input type="checkbox" name="menuAuthCheck" value="{{$rs->menucode}}_d" id="{{$rs->menucode}}_d" @if(strpos($auth_arr,$rs->menucode."_d") !== false) checked @endif > 삭제
                                                @endif
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

            var chk_arr=[];
            $("input[name=menuAuthCheck]:checked").each(function(){
                var chk = $(this).val();
                chk_arr.push(chk);
            })

            console.log(chk_arr);
            var data = {
                gCode:$("#gCode").val()
                ,chk_arr:chk_arr
            };

            jQuery.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"post",
                dataType:'json',
                data: data,
                url: '{{ url('/admin/authUpdate') }}',
                success: function searchSuccess(data) {
                   if(data.result=="SUCCESS"){
                       alert('권한이 수정되었습니다.');
                   }else if(data.result=="FAIL"){
                       alert('권한 부여 처리중 문제가 발생하였습니다.');
                   }

                },
                error: function (e) {
                    console.log('start');
                    console.log(e);
                    alert('로딩 중 오류가 발생 하였습니다.');
                }
            });
        });
        function changeCheck(code){

            var codeId_s= code+'_s';
            var codeId_i= code+'_i';
            var codeId_u= code+'_u';
            var codeId_d= code+'_d';

            if($('#'+code+'_all').is(":checked") == true){
                if(code=='AD010000') {
                    document.getElementById(codeId_s).checked = true;
                }else if(code=='AD120200'){
                    document.getElementById(codeId_s).checked = true;
                    document.getElementById(codeId_u).checked = true;
                }else{
                    document.getElementById(codeId_s).checked = true;
                    document.getElementById(codeId_i).checked = true;
                    document.getElementById(codeId_u).checked = true;
                    document.getElementById(codeId_d).checked = true;
                }

            }else{
                if(code=='AD010000'){
                    document.getElementById(codeId_s).checked = false;
                }else if(code=='AD120200'){
                    document.getElementById(codeId_s).checked = false;
                    document.getElementById(codeId_u).checked = false;
                }else{
                    document.getElementById(codeId_s).checked = false;
                    document.getElementById(codeId_i).checked = false;
                    document.getElementById(codeId_u).checked = false;
                    document.getElementById(codeId_d).checked = false;
                }

            }
        }

    </script>
@endsection
