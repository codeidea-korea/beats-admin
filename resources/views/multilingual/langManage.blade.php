@extends('layouts.Default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">언어 관리</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">

                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{$params['totalCnt']}}개의 언어가 있습니다.</h2>
                    </div>

                    <!-- table 시작 -->
                    <div class="p-5">
                        <input type="hidden" id="totalCnt" name="totalCnt" value="{{$params['totalCnt']}}">
                        <table class="table table-bordered table-hover"  >
                            <thead>
                            <tr>
                                <th class="whitespace-nowrap text-center">No.</th>
                                <th class="whitespace-nowrap text-center">언어</th>
                                <th class="whitespace-nowrap text-center">관리</th>
                            </tr>
                            </thead>
                            <tbody id="langTable">
                            @php
                            $no = 1;
                            @endphp
                            @foreach($langList as $rs)
                                <tr>
                                    <td class="w-10 text-center">{{$no}}</td>
                                    <td>
                                        <div class="mt-2 s_{{$rs->idx}}" style="display:none;">
                                            <select data-placeholder="Select your favorite actors" class="tom-select w-full" name="langSelect_{{$rs->idx}}">
                                                <option value=''>언어선택</option>
                                                <option value='kr' @if($rs->lang_code=='kr') selected @endif >한국어</option>
                                                <option value='en' @if($rs->lang_code=='en') selected @endif >영어</option>
                                                <option value='jp' @if($rs->lang_code=='jp') selected @endif >일본어</option>
                                                <option value='ch' @if($rs->lang_code=='ch') selected @endif >중국어</option>
                                            </select>
                                        </div>
                                        <div class="mt-2 l_{{$rs->idx}}">
                                            <label> {{$rs->lang_value}} </label>
                                        </div>
                                    </td>
                                    <td class="md:w-60 w-32">
                                        <button class="btn btn-primary w-24 up_{{$rs->idx}}" style="display:none;" onClick="updateAd({{$rs->idx}});">완료</button>
                                        <button class="btn btn-outline-dark w-24 inline-block ch_{{$rs->idx}}" onClick="changeAd({{$rs->idx}});">수정</button>
                                        <button class="btn btn-danger w-24 dl_{{$rs->idx}}" onClick="alert('{{$rs->idx}} 삭제 임의로 막음');">삭제</button>
                                    </td>
                                </tr>
                                @php
                                    $no ++;
                                @endphp
                            @endforeach

                            </tbody>
                        </table>
                        <button onClick="addLangFrom();" class="btn btn-primary mt-5 intro-y w-full block text-center rounded-md py-4 border-slate-400">언어 추가</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            //  $(function (){
            //
            //  })

            function changeAd(no){
                $(".up_"+no).show();
                $(".ch_"+no).hide();
                $(".dl_"+no).hide();
                $(".s_"+no).show();
                $(".l_"+no).hide();
            }

            function updateAd(no){
                var lang_code = $("select[name=langSelect_"+no+"]").val();
                var lang_value = $("select[name=langSelect_"+no+"] option:checked").text();
                    var data = {
                        idx:no
                        ,lang_code:lang_code
                        ,lang_value:lang_value
                    };
                    jQuery.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type:"post",
                        dataType:'json',
                        data: data,
                        url: '{{ url('/multilingual/ajax/langUpdate') }}',
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
            // 폼추가
            function addLangFrom() {
                var totalCnt = $("#totalCnt").val();
                var nowCount = totalCnt*1+1;
                $("#totalCnt").val(nowCount);

                 var dom = document.createElement('tr');
                 var ihtml = "";
                 ihtml =  "<tr class='newLangTr_"+nowCount+"' >"+"<td class='text-center'>"+nowCount+"</td>"
                 ihtml += "<td>"
                 ihtml += "<div class='mt-2'>"
                 ihtml += "<select data-placeholder='Select your favorite actors' class='tom-select w-full' name='newLangSelect_"+nowCount+"' >"
                 ihtml += "<option value=''>언어선택</option>"
                 ihtml += "<option value='kr'>한국어</option>"
                 ihtml += "<option value='en'>영어</option>"
                 ihtml += "<option value='jp'>일본어</option>"
                 ihtml += "<option value='ch'>중국어</option>"
                 ihtml += "</select>"
                 ihtml += "</div>"
                 ihtml += "</td>"
                 ihtml += "<td><button class='btn btn-outline-pending w-24 inline-block newLangbtnCancle'>취소</button></td>"
                 ihtml += "</tr>";
                 dom.innerHTML = ihtml;

                 $("#langTable").append(dom);
            }
            // 폼삭제
            $("#langTable").on("click", ".newLangbtnCancle", function() {
                $(this).closest("tr").remove();
            });

            function cancleLangFrom() {
                $(".newLangSelect_"+no).remove();
            }
        </script>

@endsection


