@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">분야 관리</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">

                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{$params['totalCnt']}}개의 분야가 있습니다.</h2>
                    </div>

                    <!-- table 시작 -->
                    <div class="p-5">
                        <input type="hidden" id="totalCnt" name="totalCnt" value="{{$params['totalCnt']}}">
                        <table class="table table-bordered table-hover"  >
                            <thead>
                            <tr>
                                <th class="whitespace-nowrap text-center">No.</th>
                                <th class="whitespace-nowrap text-center">코드</th>
                                <th class="whitespace-nowrap text-center">분야</th>
                                <th class="whitespace-nowrap text-center" colspan="2">관리</th>
                            </tr>
                            </thead>
                            <tbody id="langTable">
                            @php
                                $no = 1;
                            @endphp
                            @foreach($fieldList as $rs)
                                <tr>
                                    <td class="w-10 text-center">{{$no}}</td>
                                    <td>
                                        <div class="mt-2 s_{{$rs->idx}}" style="display:none;">
                                            <input type="text" class="form-control" style="width:320px;" name="code_{{$rs->idx}}" value="{{$rs->code}}">
                                        </div>
                                        <div class="mt-2 l_{{$rs->idx}}">
                                            <label> {{$rs->code}} </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mt-2 s_{{$rs->idx}}" style="display:none;">
                                            <input type="text" class="form-control" style="width:320px;" name="field_{{$rs->idx}}" value="{{$rs->field_name}} ">
                                        </div>
                                        <div class="mt-2 l_{{$rs->idx}}">
                                            <label> {{$rs->field_name}} </label>
                                        </div>
                                    </td>
                                    <td class="md:w-60 w-60">
                                        <div class="flex items-center gap-2">
                                            <button class="btn btn-primary w-w-1/2 up_{{$rs->idx}}" style="display:none;" onClick="updateField({{$rs->idx}});">완료</button>
                                            <button class='btn btn-outline-pending w-1/2 inline-block cl_{{$rs->idx}}' style="display:none;" onClick="changeCd({{$rs->idx}});">취소</button>
                                            <button class="btn btn-outline-dark w-1/2 inline-block ch_{{$rs->idx}}" onClick="changeAd({{$rs->idx}});">수정</button>
                                        </div>
                                    </td>
                                    <td class="md:w-60 w-60">
                                        <div class="form-check form-switch">
                                            <input id="checkbox-switch-7" class="form-check-input" name="stCh1_{{$rs->idx}}" id="stCh1_{{$rs->idx}}" @if($rs->isuse=="Y") checked @endif type="checkbox" onClick="delField('{{$rs->idx}}')">
                                            <label class="form-check-label" for="checkbox-switch-7">사용유무</label>
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $no ++;
                                @endphp
                            @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-primary mt-5 intro-y w-full block text-center rounded-md py-4 border-slate-400 addLangFrom">항목 추가</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(function (){
                // 폼삭제
                $("#langTable").on("click", ".newLangbtnCancle", function() {
                    $(this).closest("tr").remove();
                });

                // 폼추가
                $(".addLangFrom").on("click", function() {
                    var totalCnt = $("#totalCnt").val();
                    var nowCount = totalCnt*1+1;
                    $("#totalCnt").val(nowCount);

                    var dom = document.createElement('tr');
                    var ihtml = "";
                    ihtml =  "<tr class='newLangTr_"+nowCount+"' >"+"<td class='text-center'>"+nowCount+"</td>";
                    ihtml += "<td>";
                    ihtml += "<div class='mt-2'>";
                    ihtml += "<input type='text' class='form-control' style='width:420px;' name='newCode_"+nowCount+"' value=''>";
                    ihtml += "</div>";
                    ihtml += "</td>";
                    ihtml += "<td>";
                    ihtml += "<div class='mt-2'>";
                    ihtml += "<input type='text' class='form-control' style='width:420px;' name='newField_"+nowCount+"' value=''>";
                    ihtml += "</div>";
                    ihtml += "</td>";
                    ihtml += "<td class='md:w-60 w-60'><button class='btn btn-primary w-24 inline-block' onClick='addField("+nowCount+");'>완료</button></td>";
                    ihtml += "<td class='md:w-60 w-60'><button class='btn btn-outline-pending w-24 inline-block newLangbtnCancle'>취소</button></td>";
                    ihtml += "</tr>";
                    dom.innerHTML = ihtml;

                    $("#langTable").append(dom);
                });
            })

            function changeAd(no){
                $(".up_"+no).show();
                $(".ch_"+no).hide();
                $(".dl_"+no).hide();
                $(".s_"+no).show();
                $(".l_"+no).hide();
                $(".cl_"+no).show();
            }
            function changeCd(no){
                $(".up_"+no).hide();
                $(".ch_"+no).show();
                $(".dl_"+no).show();
                $(".s_"+no).hide();
                $(".l_"+no).show();
                $(".cl_"+no).hide();
            }

            function updateField(no){
                var code = $("input[name=code_"+no+"]").val();
                var field = $("input[name=field_"+no+"]").val();
                var data = {
                    idx:no
                    ,code:code
                    ,field_name:field
                };
                jQuery.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"post",
                    dataType:'json',
                    data: data,
                    url: '{{ url('/mento/ajax/fieldUpdate') }}',
                    success: function searchSuccess(data) {

                        if(data.resultCode=="SUCCESS"){
                            alert(data.resultMessage);
                            location.reload();
                        }else{
                            alert(data.resultMessage);
                        }
                    },
                    error: function (e) {
                        console.log('start');
                        console.log(e);
                        alert('로딩 중 오류가 발생 하였습니다.');
                    }
                });

            }
            // 필드 등록
            function addField(no) {
                var code = $("input[name=newCode_"+no+"]").val();
                var field = $("input[name=newField_"+no+"]").val();
                if(code == ""){
                    alert("코드를 입력해주세요.");
                    return false;
                }
                if(field == ""){
                    alert("분야명을 입력해주세요.");
                    return false;
                }
                var data = {
                    code:code
                    ,field_name:field
                };
                jQuery.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"post",
                    dataType:'json',
                    data: data,
                    url: '{{ url('/mento/ajax/fieldInsert') }}',
                    success: function searchSuccess(data) {

                        if(data.resultCode=="SUCCESS"){
                            alert(data.resultMessage);
                            location.reload();
                        }else{
                            alert(data.resultMessage);
                        }
                    },
                    error: function (e) {
                        console.log('start');
                        console.log(e);
                        alert('로딩 중 오류가 발생 하였습니다.');
                    }
                });
            }


            function cancleLangFrom() {
                $(".newLangSelect_"+no).remove();
            }

            function delField(no){
                var isuse = "Y";
                if($("input[name=stCh1_"+no+"]").is(':checked') == true){
                    isuse = "Y";
                }else{
                    isuse = "N";
                }
                var data = {
                    idx:no
                    ,isuse:isuse
                };
                jQuery.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"post",
                    dataType:'json',
                    data: data,
                    url: '{{ url('/mento/ajax/fieldStatus') }}',
                    success: function searchSuccess(data) {

                        if(data.resultCode=="SUCCESS"){
                            //alert(data.resultMessage);
                            //location.reload();
                        }else{
                            //alert(data.resultMessage);
                        }
                    },
                    error: function (e) {
                        console.log('start');
                        console.log(e);
                        alert('로딩 중 오류가 발생 하였습니다.');
                    }
                });

            }
        </script>

@endsection


