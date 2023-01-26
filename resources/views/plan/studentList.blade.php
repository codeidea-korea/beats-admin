@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">학생 요금제 관리</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">
                <form name="searchData" action="" method="get">
                    <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                    <div class="intro-y box">
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-32 text-center">상태</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-60" aria-label=".form-select-lg" name="group_code">
                                                <option value="">전체</option>
                                                <option value="">대기</option>
                                                <option value="">반려</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-32 text-center">회원 구분</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-60" aria-label=".form-select-lg" name="group_code">
                                                <option value="">전체</option>
                                                <option value="">일반</option>
                                                <option value="">작곡가</option>
                                            </select>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-32 text-center">국적</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-60" aria-label=".form-select-lg" name="group_code">
                                                <option value="">전체</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-32 text-center">검색</th>
                                        <td class="whitespace-nowrap">
                                               <input id="regular-form-1" type="text" name="sWord" value="">
                                        </td>

                                        <th class="bg-primary/10 whitespace-nowrap w-32 text-center">등록일</th>
                                        <td class="whitespace-nowrap" colspan="3">
                                            <input type="text" class="datepicker form-control sm:w-56 box pl-10" value="" name="searchDate">
                                        </td>
                                    </tr>
                                </table>
                                <div style="float:right;">
                                    <a href="javascript:location.href = '/plan/studentList';" class="btn box flex items-center text-slate-600 border border-slate-400" > 초기화</a>

                                </div>
                                <div style="float:right;">
                                    &nbsp;
                                </div>
                                <div style="float:right;">
                                    <button class="btn box flex items-center text-slate-600 border border-slate-400 formSearchBtn" >
                                        검색
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{$totalCount}}명의 학생 승인 신청 내역이 있습니다.</h2>
                        <div id="check_cnt">
                            <h2 class="font-medium text-base mr-auto text-primary" >선택된 인원수 0명의 회원을</h2>
                        </div>

                        <a href="javascript:;" class="btn btn-primary mr-1 mb-2" id="excelDownload" onClick="stStatusY();">학생인증승인</a>
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview" class="btn btn-primary mr-1 mb-2">학생인증반려</a>
                        <a href="javascript:;" class="btn btn-primary mr-1 mb-2" id="excelDownload">Excel Download</a>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">
                                        <div class="form-check">
                                            <input id="checkbox-switch-1" class="form-check-input all_check" name="selectall" onClick="setCheckAll(this)" type="checkbox" value="">
                                        </div>
                                    </th>
                                    <th class="whitespace-nowrap text-center">상태</th>
                                    <th class="whitespace-nowrap text-center">회원 구분</th>
                                    <th class="whitespace-nowrap text-center">국적</th>
                                    <th class="whitespace-nowrap text-center">ID</th>
                                    <th class="whitespace-nowrap text-center">닉네임</th>
                                    <th class="whitespace-nowrap text-center">이름 성</th>
                                    <th class="whitespace-nowrap text-center">생년월일</th>
                                    <th class="whitespace-nowrap text-center">학교명</th>
                                    <th class="whitespace-nowrap text-center">학번</th>
                                    <th class="whitespace-nowrap text-center">이메일</th>
                                    <th class="whitespace-nowrap text-center">신청일</th>
                                    <th class="whitespace-nowrap text-center">파일</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($studentList as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center">
                                            <div class="form-check">
                                                <input id="checkbox-switch-1" class="form-check-input all_check" type="checkbox" name="chkUser" value="{{$rs->sa_idx}}" onClick="checkCountVal()">
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap text-center">{{$rs->statusValue}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->gubunValue}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->nationality}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->email_id}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->mem_nickname}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->last_name}} {{$rs->first_name}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->year}}-{{$rs->month}}-{{$rs->day}}</td>
                                        <td class="whitespace-nowrap text-center"> - </td>
                                        <td class="whitespace-nowrap text-center"> - </td>
                                        <td class="whitespace-nowrap text-center">{{$rs->send_email}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->credate}}</td>
                                        <td class="whitespace-nowrap text-center">
                                            <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="alert()">
                                                파일
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- 페이징처리 시작 -->
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-5">
                    <nav class="w-full">
                        @include('vendor.pagination.default')
                    </nav>
                </div>
                <!-- 페이징처리 종료 -->
            </div>

        </div>

    </div>
    <!-- 비밀번호 변경 모달 시작 -->
    <div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- BEGIN: Modal Header -->
                <div class="modal-header pl-10 pr-10 pt-10">
                    <h2 class="font-medium text-base mr-auto">반려사유 등록</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body p-10 grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12">
                        <label for="modal-form-2" class="form-label">반려사유</label>
                        <input id="modal-form-2" type="text" name="student_reject" class="form-control" placeholder="사유 등록">
                    </div>
                    <div class="col-span-12">
                        <label for="modal-form-2" class="form-label">* 작성한 반려사유는 반려사유 안내 메일에 기재되어 신청회원에게 발송됩니다.</label>
                    </div>
                    <div class="col-span-12">
                        <div class="flex items-center justify-center mt-5">
                            <button class="btn btn-primary w-32 mr-5 stStatusN">저장</button>
                            <button class="btn btn-secondary w-32 modalCancel" data-tw-dismiss="modal">닫기</button>
                        </div>
                    </div>

                </div>
                <!-- END: Modal Body -->
            </div>
        </div>
    </div>
    <!-- 비밀번호 변경 modal 끝 -->

    <script>
        function change(page) {
            $("input[name=page]").val(page);
            document.forms["searchData"].submit();
        }
        function checkCountVal(){
            let chk_arr=[];
            $("input[name=chkUser]:checked").each(function(){
                var chk = $(this).val();
                chk_arr.push(chk);
            });
            var check_count = chk_arr.length;
            const element = document.getElementById('check_cnt');
            element.innerHTML= '<h2 class="font-medium text-base mr-auto text-primary" >' +
                '선택된 인원수 ' +
                check_count +
                '명의 회원을' +
                '</h2>';
        }

        function setCheckAll(selectAll) {
            const checkboxes
                = document.getElementsByName('chkUser');

            checkboxes.forEach((checkbox) => {
                checkbox.checked = selectAll.checked
            })
            checkCountVal();
        }
        function stStatusY(){
            let chk_arr=[];
            $("input[name=chkUser]:checked").each(function(){
                var chk = $(this).val();
                chk_arr.push(chk);
            });
            console.log('chk_arr',chk_arr);
            if(chk_arr.length > 0){
                var data = {
                    idx_arr: chk_arr
                    ,status: 'Y'
                };
                jQuery.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"post",
                    dataType:'json',
                    data: data,
                    url: "{{ url('/plan/studentStatusUp') }}",
                    success: function searchSuccess(data) {
                        if(data.result=="SUCCESS"){
                            alert('총 '+chk_arr.length+'명의 학생인증승인이 완료되었습니다.');
                            location.reload();
                        }else{
                            alert('승인처리가 실패하였습니다. \n관리자에게 문의 바랍니다.');
                        }
                    },
                    error: function (e) {
                        console.log(e);
                        alert('로딩 중 오류가 발생 하였습니다.');
                    }
                });
            }else{
                alert('선택된 학생 인증 신청 내역이 없습니다. 인증 승인할 회원을 선택해주세요');
            }
        }

        $(".stStatusN").on('click', function(){
            let chk_arr=[];
            var student_reject = $("input[name='student_reject']").val();
            if(student_reject == ""){
                alert("반려사유를 등록해주세요.");
                return false;
            }

            $("input[name=chkUser]:checked").each(function(){
                var chk = $(this).val();
                chk_arr.push(chk);
            });
            console.log('chk_arr',chk_arr);
            if(chk_arr.length > 0){
                var data = {
                    idx_arr: chk_arr
                    ,status: 'N'
                    ,student_reject:student_reject
                };
                jQuery.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"post",
                    dataType:'json',
                    data: data,
                    url: "{{ url('/plan/studentStatusUp') }}",
                    success: function searchSuccess(data) {
                        if(data.result=="SUCCESS"){
                            alert('총 '+chk_arr.length+'명의 학생인증승인이 반려되었습니다.');
                            location.reload();
                        }else{
                            alert('반려처리가 실패하였습니다. \n관리자에게 문의 바랍니다.');
                        }
                    },
                    error: function (e) {
                        console.log(e);
                        alert('로딩 중 오류가 발생 하였습니다.');
                    }
                });
            }else{
                alert('선택된 학생 인증 신청 내역이 없습니다. 인증 반려할 회원을 선택해주세요');
            }
        });


    </script>
@endsection
