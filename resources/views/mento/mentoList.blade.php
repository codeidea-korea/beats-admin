@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">전환신청</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">

                <div class="intro-y box">
                    <div id="boxed-tab" class="p-5">
                        <div class="preview">
                            <ul class="nav nav-boxed-tabs" role="tablist">
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2 active" type="button" role="tab" onClick="javascript:location.href = '{{ url('/mento/mentoList') }}';">전환 신청</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2 " type="button" role="tab" onClick="javascript:location.href = '{{ url('/mento/mentoChLog') }}';">반려 내역</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <form name="searchForm" id="searchForm" class="form-horizontal" role="form"  method="get" action="">
                    <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                    <div class="intro-y box">
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">상태</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="mento_status">
                                                <option value=""  @if($params['mento_status'] == "")  selected @endif>전체</option>
                                                <option value="1" @if($params['mento_status'] == "1") selected @endif>반려</option>
                                                <option value="2" @if($params['mento_status'] == "2") selected @endif>대기</option>
                                            </select>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">회원 구분</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="gubun">
                                                <option value=""  @if($params['gubun'] == "")  selected @endif >전체</option>
                                                <option value="1" @if($params['gubun'] == "1") selected @endif >일반</option>
                                                <option value="2" @if($params['gubun'] == "2") selected @endif >작곡가</option>
                                                <option value="3" @if($params['gubun'] == "3") selected @endif >음원 구매자</option>
                                                <option value="4" @if($params['gubun'] == "4") selected @endif >멘토 뮤지션</option>
                                            </select>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">가입 채널</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="channel">
                                                <option value=""           @if($params['channel'] == "")  selected @endif >전체</option>
                                                <option value="facebook"   @if($params['channel'] == "facebook") selected @endif >페이스북</option>
                                                <option value="twitter"    @if($params['channel'] == "twitter") selected @endif >트위터</option>
                                                <option value="google"     @if($params['channel'] == "google") selected @endif >구글</option>
                                                <option value="apple"      @if($params['channel'] == "apple") selected @endif >애플</option>
                                                <option value="naver"      @if($params['channel'] == "naver")  selected @endif >네이버</option>
                                                <option value="kakao"      @if($params['channel'] == "kakao") selected @endif >카카오</option>
                                                <option value="soundcloud" @if($params['channel'] == "soundcloud") selected @endif >사운드클라우드</option>
                                                <option value="email"      @if($params['channel'] == "email") selected @endif >직접가입</option>
                                            </select>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">국적</th>
                                        <td class="whitespace-nowrap">
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="nationality" style="width:120px;">
                                                <option value="" @if($params['nationality'] == "")  selected @endif >전체</option>
                                                @foreach($nationality as $rs)
                                                    <option value="{{$rs->codeName}}" @if($rs->codeName == $params['nationality']) selected @endif >{{$rs->codeValue}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">검색</th>
                                        <td class="whitespace-nowrap">
                                            <input id="regular-form-1" id="sWord" name="sWord" value="{{$params['sWord']}}" type="text">
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">가입일</th>
                                        <td class="whitespace-nowrap" colspan="3">
                                            <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                                <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                                <input type="text" class="datepicker form-control sm:w-56 box pl-10" name="created_at" id="created_at" value="{{$params['created_at']}}">
                                            </div>
                                        </td>
                                        <th class="bg-primary/10 whitespace-nowrap w-13 text-center">신청일</th>
                                        <td class="whitespace-nowrap" colspan="3">
                                            <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                                <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                                <input type="text" class="datepicker form-control sm:w-56 box pl-10" name="mem_moddate" id="mem_moddate" value="{{$params['mem_moddate']}}">
                                            </div>
                                        </td>

                                    </tr>
                                </table>
                                <div style="float:right;">
                                    <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/mento/mentoList';">
                                        초기화
                                    </button>
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
                        <h2 class="font-medium text-base mr-auto text-primary" id='resultCnt'>총 {{$totalCount}}명의 전환 신청내역이 있습니다.</h2>
                        <a href="javascript:chMento();" class="btn btn-primary mr-1 mb-2" id="">전환합니다.</a>
                        <a href="javascript:;" class="btn btn-primary mr-1 mb-2" id="excelDownload">엑셀 다운로드</a>

                    </div>

                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center"><input type="checkbox" name="allCheck" value="selectall" onClick="checkAll(this)"></th>
                                    <th class="whitespace-nowrap text-center">상태</th>
                                    <th class="whitespace-nowrap text-center">서비스</th>
                                    <th class="whitespace-nowrap text-center">회원 구분</th>
                                    <th class="whitespace-nowrap text-center">가입 채널</th>
                                    <th class="whitespace-nowrap text-center">국적</th>
                                    <th class="whitespace-nowrap text-center">이메일 ID</th>
                                    <th class="whitespace-nowrap text-center">닉네임</th>
                                    <th class="whitespace-nowrap text-center">제재</th>
                                    <th class="whitespace-nowrap text-center">가입일</th>
                                    <th class="whitespace-nowrap text-center">신청일</th>

                                </tr>
                                </thead>
                                <tbody>


                                @php $i=0; @endphp
                                @foreach($memberList as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center"><input type="checkbox" name="mid" value="{{$rs->mem_id}}" onClick="checkSingle()"></td>
                                        <td class="whitespace-nowrap text-center"><a href="/mento/mentoView/{{$rs->mem_id}}">{{$rs->mentoStValue}}</a></td>
                                        <td class="whitespace-nowrap text-center"><a href="/mento/mentoView/{{$rs->mem_id}}">바이비츠</a></td>
                                        <td class="whitespace-nowrap text-center"><a href="/mento/mentoView/{{$rs->mem_id}}">{{$rs->gubunValue}}</a></td>
                                        <td class="whitespace-nowrap text-center"><a href="/mento/mentoView/{{$rs->mem_id}}">{{$rs->channelValue}}</a></td>
                                        <td class="whitespace-nowrap text-center"><a href="/mento/mentoView/{{$rs->mem_id}}">{{$rs->nati}}</a></td>
                                        <td class="whitespace-nowrap text-center"><a href="/mento/mentoView/{{$rs->mem_id}}">{{$rs->email_id}}</a></td>
                                        <td class="whitespace-nowrap text-center"><a href="/mento/mentoView/{{$rs->mem_id}}">{{$rs->mem_nickname}}</a></td>
                                        <td class="whitespace-nowrap text-center">{{$rs->mem_sanctions}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->created_at}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->mem_moddate}}</td>
                                        {{--$totalCount-($i+(($params['page']-1)*10))--}}
                                    </tr>
                                    @php $i++; @endphp
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

    <script>
        function change(page) {
            $("input[name=page]").val(page);
            document.forms["searchForm"].submit();
        }

        function checkAll(selectAll)  {
            const checkboxes
                = document.getElementsByName('mid');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = selectAll.checked;
            })

            // 선택된 목록 가져오기
            const query = 'input[name="mid"]:checked';
            const selectedElements =
                document.querySelectorAll(query);
            // 선택된 목록의 갯수 세기
            const selectedElementsCnt =
                selectedElements.length;
            // 출력
            document.getElementById('resultCnt').innerText
                = "총 "+selectedElementsCnt+"명의 전환 신청내역이 있습니다.";
        }

        function checkSingle(){
            // 선택된 목록 가져오기
            const query = 'input[name="mid"]:checked';
            const selectedElements =
                document.querySelectorAll(query);
            // 선택된 목록의 갯수 세기
            const selectedElementsCnt =
                selectedElements.length;
            // 출력
            document.getElementById('resultCnt').innerText
                = "총 "+selectedElementsCnt+"명의 전환 신청내역이 있습니다.";
        }

        function chMento(){
            var chk_arr=[];
            $("input[name=mid]:checked").each(function(){
                var chk = $(this).val();
                chk_arr.push(chk);
            })
            console.log(chk_arr.length);
            if(chk_arr.length==0){
                alert('선택된 전환 신청내역이 없습니다. 멘토 뮤지션으로 전환할 회원을 선택해주세요.');
                return false;
            }
            var data = {
                mem_id_arr:chk_arr
            };
            jQuery.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"post",
                dataType:'json',
                data: data,
                url: '{{ url('/mento/ajax/mentoCh') }}',
                success: function searchSuccess(data) {
                    if(data.result=="SUCCESS"){
                        alert(data.message);
                        location.reload();
                    }else if(data.result=="not enough"){
                        alert(data.message);
                        location.reload();
                    }else if(data.result=="FAIL"){
                        alert(data.message);
                    }

                },
                error: function (e) {
                    console.log('start');
                    console.log(e);
                    alert('로딩 중 오류가 발생 하였습니다.');
                }
            });
        }

        $("#excelDownload").on('click', function(){
            $("#searchForm").attr("action", "/mento/mentoChDownloadExcel");
            //document.forms["searchForm"].attr("action", "/member/memberList");
            document.forms["searchForm"].submit();

        });
    </script>
@endsection
