@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">요금제 관리</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">
                    <!-- table 시작 -->
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">언어 선택</th>
                                    <td colspan="3">
                                        <select name="lang" class="form-select w-56" aria-label=".form-select-lg">
                                            <option selected value="KR">한국어</option>
                                            <option value="EN">영어</option>
                                            <option value="JP">일본어</option>
                                            <option value="CH">중국어</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">요금제 구분</th>
                                    <td colspan="3">
                                        <select name="gubun" class="form-select w-56" aria-label=".form-select-lg">
                                            <option selected value="0">Free</option>
                                            <option  value="1">Premium</option>
                                            <option  value="2">학생요금</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">요금제 이름</th>
                                    <td colspan="3">
                                        <input  name="name" type="text" class="form-control" >
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">기본 문구</th>
                                    <td colspan="3">
                                        <input name="contents" type="text" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">이용 요금 (월)</th>
                                    <td>
                                        <input name="fee" id="" type="text" class="form-control w-64 mr-2" value="0"><span>(원)</span>
                                    </td>
                                    <th class="whitespace-nowrap text-center bg-primary/10">할인율</th>
                                    <td>
                                        <input name="sale" id="" type="text" class="form-control w-64 mr-2" value="0"><span>(%)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">이용 혜택</th>
                                    <td colspan="3">
                                        <div class="grid grid-cols-6 gap-6">
                                            <table class="table table-bordered">
                                                <tbody id="optionTable">
                                                <tr>
                                                    <td><span id="tText">총 (1)개 혜택</span></td>
                                                    <td><button class="btn btn-primary w-24" onClick="addOptionFrom();">추가</button></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" class='chk0'  name="sort_no[]" value="1">
                                                        <input name="benefits[]" type="text" class="form-control" placeholder="혜택 내용">
                                                    </td>
                                                    <td class="whitespace-nowrap text-left">
                                                        <button class="btn btn-danger w-24 btnCancle">삭제</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <input type="hidden" id="totalCnt" value="1">
                                            <script>
                                                function opCheckCnt(){
                                                    var count = 0;
                                                    $('.chk0').filter(function() {
                                                        if(this.value.trim().length > 0){ // 체크한 것의 개수
                                                            count++;
                                                        }
                                                    });
                                                    document.getElementById('tText').innerText = "총 ("+count+")개 혜택";
                                                }
                                                function addOptionFrom(){
                                                    var totalCnt = $("#totalCnt").val();
                                                    var nowCount = totalCnt*1+1;
                                                    $("#totalCnt").val(nowCount);
                                                    var dom = document.createElement('tr');
                                                    var ihtml = "";
                                                    ihtml =  "<tr>"
                                                    ihtml += "<td><input type='hidden' class='chk0'  name='sort_no[]' value='"+nowCount+"'><input name='benefits[]'  type='text' class='form-control' placeholder='혜택 내용'></td>"
                                                    ihtml += "<td class='whitespace-nowrap left'><button class='btn btn-danger w-24 btnCancle'>삭제</button></td>"
                                                    ihtml += "</tr>";
                                                    dom.innerHTML = ihtml;
                                                    $("#optionTable").append(dom);
                                                    opCheckCnt();
                                                }
                                                $(function (){
                                                    // 폼삭제
                                                    $("#optionTable").on("click", ".btnCancle", function() {
                                                        $(this).closest("tr").remove();
                                                        opCheckCnt();
                                                    });

                                                    $(".proIn").on('click', function(){

                                                        var formData = new FormData;

                                                        $("input[name='sort_no[]']").each(function(i) {
                                                            formData.append('sort_no[]',$(this).val());
                                                        });
                                                        $("input[name='benefits[]']").each(function(i) {
                                                            formData.append('benefits[]',$(this).val());
                                                        });
                                                        formData.append( "lang",$("select[name='lang']").val());
                                                        formData.append( "gubun",$("select[name='gubun']").val());
                                                        formData.append( "name", $('input[name=name]').val());
                                                        formData.append( "contents", $('input[name=contents]').val());
                                                        formData.append( "fee", $('input[name=fee]').val());
                                                        formData.append( "sale", $('input[name=sale]').val());
                                                        formData.append( "is_yn",$("select[name='is_yn']").val());

                                                        jQuery.ajax({
                                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                                            type:"post",
                                                            cache: false,
                                                            processData: false,
                                                            contentType: false,
                                                            data: formData,
                                                            url: '{{ url('/plan/planInsert') }}',
                                                            success: function searchSuccess(data) {
                                                                if(data.code==0){
                                                                    alert('요금제가 등록되었습니다.');
                                                                    location.href="/plan/planList";
                                                                }else{
                                                                    alert(data.message);
                                                                }
                                                            },
                                                            error: function (e) {
                                                                console.log(e);
                                                                alert('로딩 중 오류가 발생 하였습니다.');
                                                            }
                                                        });

                                                    });

                                                })

                                            </script>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">사용 여부</th>
                                    <td colspan="3">
                                        <select name="is_yn" class="form-select w-56" aria-label=".form-select-lg example">
                                            <option value="Y">공개</option>
                                            <option selected value="N">비공개</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <!-- 테이블 끝 -->
                            <div class="flex justify-between w-full p-5">
                                <div>
                                    <button class="btn btn-dark w-24" onClick="location.href='{{ url('/plan/planList') }}'">목록</button>
                                </div>
                                <div>
                                    <button class="btn btn-primary w-24 ml-2 proIn">저장</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
