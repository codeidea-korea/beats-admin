@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">회원 현황</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">



                    <div class="intro-y box">
                        <div class="p-5">
                            <div class="overflow-x-auto">
                                <form name="searchForm" id="searchForm" class="form-horizontal" role="form"   method="get" action="">
                                    <input type="hidden" name="page" value="{{$searchData['page']}}">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="bg-primary/10 whitespace-nowrap w-13 text-center">분류</th>
                                            <td class="whitespace-nowrap">
                                                <select class="form-select w-13" aria-label=".form-select-lg" name="class">
                                                    <option value=""  @if($params['class'] == "")  selected @endif  >전체</option>
                                                    <option value="3" @if($params['class'] == "3") selected @endif >통합회원</option>
                                                    <option value="2" @if($params['class'] == "2") selected @endif >임시회원</option>
                                                    <option value="1" @if($params['class'] == "1") selected @endif >비트썸원</option>
                                                    <option value="0" @if($params['class'] == "0") selected @endif >휴면회원</option>
                                                </select>
                                                <!--<button class="btn btn-primary w-24">대상 설정</button>-->
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
                                                <!--<button class="btn btn-primary w-24">대상 설정</button>-->
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
                                                <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                            </td>
                                            <th class="bg-primary/10 whitespace-nowrap w-13 text-center">국적</th>
                                            <td class="whitespace-nowrap">
                                                <select class="form-select w-13" aria-label=".form-select-lg" name="nationality" style="width:120px;">
                                                    <option value="" @if($params['nationality'] == "")  selected @endif >전체</option>
                                                    @foreach($nationality as $rs)
                                                        <option value="{{$rs->codeName}}" @if($rs->codeName == $params['nationality']) selected @endif >{{$rs->codeValue}}</option>
                                                    @endforeach
                                                </select>
                                                <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                            </td>
                                            <th class="bg-primary/10 whitespace-nowrap w-13 text-center">상태</th>
                                            <td class="whitespace-nowrap">
                                                <select class="form-select w-13" aria-label=".form-select-lg" name="mem_status">
                                                    <option value=""  @if($params['mem_status'] == "")  selected @endif>전체</option>
                                                    <option value="0" @if($params['mem_status'] == "0") selected @endif>임시</option>
                                                    <option value="1" @if($params['mem_status'] == "1") selected @endif>정상</option>
                                                    <option value="2" @if($params['mem_status'] == "2") selected @endif>제재</option>
                                                </select>
                                                <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-primary/10 whitespace-nowrap w-13 text-center">검색</th>
                                            <td class="whitespace-nowrap" colspan="3">
                                                <input id="regular-form-1" id="sWord" name="sWord" value="{{$params['sWord']}}" type="text">
                                            </td>
                                            <th class="bg-primary/10 whitespace-nowrap w-13 text-center">가입일</th>
                                            <td class="whitespace-nowrap" colspan="5">
                                                <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                                    <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                                    <input type="text" class="datepicker form-control sm:w-56 box pl-10" name="searchDate" id="searchDate" value="{{$params['searchDate']}}">
                                                </div>
                                            </td>

                                        </tr>
                                    </table>
                                </form>
                                <div style="float:right;">
                                    <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/member/memberList';">
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

                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}명의 회원이 있습니다.</h2>
                        <a href="javascript:;" class="btn btn-primary mr-1 mb-2" id="excelDownload">엑셀 다운로드</a>
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview2" class="btn btn-primary mr-1 mb-2" id="pointOpen">포인트 지급</a>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">No.</th>
                                    <th class="whitespace-nowrap text-center">분류</th>
                                    <th class="whitespace-nowrap text-center">회원 구분</th>
                                    <th class="whitespace-nowrap text-center">가입 채널</th>
                                    <th class="whitespace-nowrap text-center">국적</th>

                                    <th class="whitespace-nowrap text-center">고유 ID</th>
                                    <th class="whitespace-nowrap text-center">닉네임</th>
                                    <th class="whitespace-nowrap text-center">제재</th>
                                    <th class="whitespace-nowrap text-center">상태</th>
                                    <th class="whitespace-nowrap text-center">가입일</th>

                                    <th class="whitespace-nowrap text-center">최근 접속일</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $i=0; @endphp
                                @foreach($memberList as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center">
                                            <a href="/member/memberView/{{$rs->mem_id}}">
                                                {{$totalCount-($i+(($params['page']-1)*10))}}
                                            </a>
                                        </td>
                                        <td class="whitespace-nowrap text-center">
                                            <a href="/member/memberView/{{$rs->mem_id}}">
                                                {{$rs->classValue}}
                                            </a>
                                        </td>
                                        <td class="whitespace-nowrap text-center">
                                            <a href="/member/memberView/{{$rs->mem_id}}">
                                                {{$rs->gubunValue}}
                                            </a>
                                        </td>
                                        <td class="whitespace-nowrap text-center">
                                            <a href="/member/memberView/{{$rs->mem_id}}">
                                                {{$rs->channelValue}}
                                            </a>
                                        </td>
                                        <td class="whitespace-nowrap text-center">
                                            <a href="/member/memberView/{{$rs->mem_id}}">
                                                {{$rs->nati}}
                                            </a>
                                        </td>
                                        <td class="whitespace-nowrap text-center">
                                            <a href="/member/memberView/{{$rs->mem_id}}">
                                                {{$rs->mem_id}}
                                            </a>
                                        </td>
                                        <td class="whitespace-nowrap text-center">
                                            <a href="/member/memberView/{{$rs->mem_id}}">
                                                {{$rs->mem_nickname}}
                                            </a>
                                        </td>
                                        <td class="whitespace-nowrap text-center">{{$rs->mem_sanctions}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->statusValue}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->mem_regdate}}</td>

                                        <td class="whitespace-nowrap text-center">{{$rs->last_login_at}}</td>
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

    <!-- 포인트지급 설정 모달 시작 -->
    <div id="superlarge-modal-size-preview2" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-2xl">
            <div class="modal-content">
                <div class="modal-body p-10 text-center">
                    <div class="overflow-x-auto">
                        <table class="table table-bordered">
                            <tr>
                                <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">포인트 설정</th>
                                <th class="whitespace-nowrap text-center bg-primary/10">증감선택</th>
                                <th class="whitespace-nowrap text-center bg-primary/10">지급/차감</th>
                                <th class="whitespace-nowrap text-center bg-primary/10">지급내용</th>
                                <th class="whitespace-nowrap text-center bg-primary/10">관리자</th>
                            </tr>
                            <tr>
                                <td>
                                    <select name="increase" class="form-select w-56" aria-label=".form-select-lg example">
                                        <option value="0">+</option>
                                        <option value="1">-</option>
                                    </select>
                                </td>
                                <td>
                                    <input name="amount" id="regular-form-1" type="text" class="form-control" placeholder="금액 입력">
                                </td>
                                <td>
                                    <input name="reason" id="regular-form-1" type="text" class="form-control" placeholder="사유 입력">
                                </td>
                                <td>
                                    <input name="mem_id" id="regular-form-1" type="text" class="form-control" placeholder="사유 입력" value="{{auth()->user()->name}}" readonly>
                                    <!-- <div class="form-check inline-block ml-5">
                                        <input id="checkbox-switch-1" class="form-check-input" type="checkbox" value="">
                                        <label class="form-check-label" for="checkbox-switch-1">Chris Evans</label>
                                    </div>
                                    <div class="form-check inline-block ml-5">
                                        <input id="radio-switch-1" class="form-check-input" type="radio" name="vertical_radio_button" value="vertical-radio-chris-evans">
                                        <label class="form-check-label" for="radio-switch-1">Chris Evans</label>
                                    </div> -->
                                </td>
                            </tr>
                        </table>

                        <div class="intro-y box mt-5">
                            <div class="flex items-center w-full">
                                <div class="flex items-center mr-5">
                                    <span class="mr-2">가입 채널</span>
                                    <select name="point_channel" class="form-select w-32" aria-label=".form-select-lg example">
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
                                </div>

                                <div class="flex items-center mr-5">
                                    <span class="mr-2">국적</span>
                                    <select name="point_nationality" class="form-select w-32" aria-label=".form-select-lg example">
                                        <option value="">전체</option>
                                        <option value="kr">한국</option>
                                        <option value="en">미국</option>
                                        <option value="ch">중국</option>
                                        <option value="jp">일본</option>
                                    </select>
                                </div>

                                <div class="flex items-center mr-5">
                                    <span class="mr-2">검색</span>
                                    <input name="point_search_text" id="regular-form-1" type="text" class="form-control w-52" placeholder="검색어 입력">
                                </div>

                                <div class="flex items-center mr-5">
                                    <span class="mr-2">가입일</span>
                                    <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                                        <i data-lucide="calendar" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                                        <input name="point_mem_regdate" type="text" class="datepicker form-control sm:w-56 box pl-10" value="{{$params['mem_regdate']}}">
                                    </div>
                                </div>
                            </div>

                            <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                                <div class="mr-5">
                                    <a href="/dist/excel/excel_sample.xlsx" download>
                                        <button class="btn btn-primary ml-2" onClick="excelDownload()">sample Download</button>
                                    </a>
                                </div>
                                <button class="btn box flex items-center text-slate-600 border border-slate-400 mr-5" onclick="validateForm()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="file-text" data-lucide="file-text" class="lucide lucide-file-text hidden sm:block w-4 h-4 mr-2">
                                        <path d="M14.5 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V7.5L14.5 2z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <line x1="10" y1="9" x2="8" y2="9"></line>
                                    </svg> Excel Upload
                                </button>
                                <form id="excelUpload">
                                    @csrf
                                    <input type="file" name="excelFile" id="excelFile" onChange="checkFile(this)" >
                                </form>
                                <button class="btn btn-primary w-24 ml-2" id="searchPointBtn">검색</button>
                                <button class="btn btn-secondary w-24 ml-2">초기화</button>
                            </div>

                            <div class="flex justify-between items-center mt-5">
                                <div class="w-full">
                                    <div class="flex flex-col sm:flex-row items-center border-b border-slate-200/60">
                                        <h2 class="font-medium text-base mr-auto text-primary">총 <span id="pointMemCnt">0</span>명의 회원이 있습니다</h2>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th class="whitespace-nowrap text-center bg-primary/10">
                                                    <div class="form-check">
                                                        <input id="checkbox-switch-1" class="form-check-input all_check" type="checkbox" value="">
                                                    </div>
                                                </th>
                                                <th class="whitespace-nowrap text-cente bg-primary/10">가입 채널</th>
                                                <th class="whitespace-nowrap text-center bg-primary/10">고유 ID</th>
                                                <th class="whitespace-nowrap text-center bg-primary/10">닉네임</th>
                                            </tr>
                                            </thead>
                                            <tbody id="pointMemList">
                                            <!-- <tr>
                                                <td class="whitespace-nowrap text-center">
                                                    <div class="form-check">
                                                        <input id="checkbox-switch-1" class="form-check-input" type="checkbox" value="">
                                                    </div>
                                                </td>
                                                <td class="whitespace-nowrap text-center">바이비츠</td>
                                                <td class="whitespace-nowrap text-center">작곡가</td>
                                                <td class="whitespace-nowrap text-center">카카오</td>
                                            </tr> -->
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- 페이징처리 시작 -->
                                    <div id="MemAllPaging">
                                    </div>
                                    <!-- 페이징처리 종료 -->
                                </div>

                                <!-- 가운데 화살표 시작 -->
                                <div class="ml-5 mr-5">
                                    <i data-lucide="fast-forward" id="sendMemMove"></i>
                                    <i data-lucide="rewind" class="mt-5" id="sendMemBackMove"></i>
                                </div>
                                <!-- 가운데 화살표 끝 -->

                                <!-- 오른쪽 테이블 시작 -->
                                <div class="w-full">
                                    <div class="flex flex-col sm:flex-row items-center border-b border-slate-200/60">
                                        <h2 class="font-medium text-base mr-auto text-primary">총 <span id="sendPointMemCnt">0</span>의 회원이 있습니다</h2>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th class="whitespace-nowrap text-center bg-primary/10">
                                                    <div class="form-check">
                                                        <input id="checkbox-switch-1" class="form-check-input all_back_check" type="checkbox" value="">
                                                    </div>
                                                </th>
                                                <th class="whitespace-nowrap text-cente bg-primary/10">가입 채널</th>
                                                <th class="whitespace-nowrap text-center bg-primary/10">고유 ID</th>
                                                <th class="whitespace-nowrap text-center bg-primary/10">닉네임</th>
                                            </tr>
                                            </thead>
                                            <tbody id="sendPointMemList">
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- 페이징처리 시작 -->
                                    <div id="sendPointMemPaging">
                                    </div>
                                    <!-- 페이징처리 종료 -->
                                </div>
                                <!-- 오른쪽 테이블 끝 -->
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center mt-5">
                        <button class="btn btn-primary w-32 mr-5 sendPointBtn">설정</button>
                        <button class="btn btn-secondary w-32 modalCancel" data-tw-dismiss="modal">닫기</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>


        $(".formSearchBtn").on('click', function(){
            $("#searchForm").attr("action", "/member/memberList");
            //document.forms["searchForm"].attr("action", "/member/memberList");
            document.forms["searchForm"].submit();

        });
        $("#excelDownload").on('click', function(){
            $("#searchForm").attr("action", "/member/memberDownloadExcel");
            //document.forms["searchForm"].attr("action", "/member/memberList");
            document.forms["searchForm"].submit();

        });
        function change(page) {
            $("input[name=page]").val(page);
            $("#searchForm").attr("action", "/member/memberList");
            document.forms["searchForm"].submit();
        }
        $(function (){
            //$('#superlarge-modal-size-preview2').modal({ keyboard: false, backdrop: 'static' })
        });

        var ajax_checked = true;

        var g_page = 1;
        var g_send_page = 1;

        var send_member = [];

        var send_member_data = {};

        var point_channel = "";
        var search_nationality = "";
        var search_text = "";
        var search_mem_regdate = "";

        $(document).on('click','.all_check',function(){
            if($(this).is(':checked') == true){
                $('.send_check').attr('checked',true);
            }else{
                $('.send_check').removeAttr('checked');
            }
        });

        $(document).on('click','.all_back_check',function(){
            if($(this).is(':checked') == true){
                $('.send_back_check').attr('checked',true);
            }else{
                $('.send_back_check').removeAttr('checked');
            }
        });

        $(document).on('click','#pointOpen',function(){
            if(ajax_checked){
                ajax_checked = false;
                $("#pointMemList")[0].innerHTML = '';
                getPointMemList(g_page);
            }
        });

        $(document).on('click','#sendMemMove',function(){

            if($('input[name="send_check"]:checked').length <= 0){
                alert('먼저 포인트를 보낼 회원을 선택해주세요');
            }else{

                $('input[name="send_check"]:checked').each(function(){
                    var idx = $(this).val();
                    var channel = $(this).data("channel");
                    var u_id = $(this).data("u_id");
                    var mem_nickname = $(this).data("mem_nickname");

                    send_member_data[idx] = {
                            channel : channel,
                            u_id : u_id,
                            mem_nickname : mem_nickname,
                    };

                    send_member.push(idx);
                });

                getSendPointMemList(g_send_page);

                $("#pointMemList")[0].innerHTML = '';
                getPointMemList(g_page);
            }
        });

        $(document).on('click','#sendMemBackMove',function(){

            if($('input[name="send_back_check"]:checked').length <= 0){
                alert('먼저 포인트를 보내지 않을 회원을 선택해주세요');
            }else{

                $('input[name="send_back_check"]:checked').each(function(){
                    var idx = $(this).val();

                    delete send_member_data[idx];

                    console.log(send_member.find(v => v === idx))

                    send_member = send_member.filter(function(data) {return data != idx;});
                });

                getSendPointMemList(g_send_page);

                getPointMemList(g_page);
            }
        });

        $(document).on('click','.sendPointBtn', function(){

            var increase = $('select[name="increase"]').val();
            var amount = $('input[name="amount"]').val();
            var reason = $('input[name="reason"]').val();

            if(send_member.length <= 0){
                alert('먼저 포인트를 보낼 회원을 선택해주세요.');
                return false;
            }

            if(increase == ""){
                alert('포인트의 증감을 선택해주세요.');
                return false;
            }

            if(amount == ""){
                alert('포인트의 금액을 입력해주세요.');
                return false;
            }

            if(reason == ""){
                alert('포인트 지급 내용를 입력해주세요.');
                return false;
            }

            jQuery.ajax({
                cache: false,
                dataType:'json',
                data: {
                    send_member : send_member,
                    increase : increase,
                    amount : amount,
                    reason : reason,
                },
                url: '/member/ajax/sendPoint',
                success: function (data) {
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
                    //alert('로딩 중 오류가 발생 하였습니다.');
                }
            });
        });

        $(document).on('click',"#searchPointBtn",function(){

            point_channel = $('select[name="point_channel"]').val();
            search_nationality = $('select[name="point_nationality"]').val();
            search_text = $('input[name="point_search_text"]').val();
            search_mem_regdate = $('input[name="point_mem_regdate"]').val();

            getPointMemList(1);
        });

        function getPointMemList(page){
            $("#pointMemList")[0].innerHTML = '';

            jQuery.ajax({
                type:"get",
                dataType:'json',
                data: {
                    page : page,
                    limit : 10,
                    send_member_data : send_member,
                    channel : point_channel,
                    nationality : search_nationality,
                    search_text : search_text,
                    mem_regdate : search_mem_regdate,
                },
                url: "{{ url('/member/ajax/memberList') }}",
                success: function searchSuccess(data) {

                    if(data.resultCode=="SUCCESS"){

                        data.memberList.forEach(function(item,index){
                            var dom = document.createElement('tr');
                            var ihtml = "";
                            var mem_class = "";
                            var gubun = "";

                            ihtml =  '<tr>'
                            ihtml +=    '<td class="whitespace-nowrap text-center">';
                            ihtml +=    '<div class="form-check">';
                            ihtml +=    '<input name="send_check" id="checkbox-switch-1" class="form-check-input send_check" type="checkbox" value="'+item.idx+'" data-channel="'+item.channel+'" data-u_id="'+item.u_id+'" data-mem_nickname="'+item.mem_nickname+'">';
                            ihtml +=    '</div>';
                            ihtml +=    '<td class="whitespace-nowrap text-center">'+item.channel+'</td>';
                            ihtml +=    '<td class="whitespace-nowrap text-center">'+item.u_id+'</td>';
                            ihtml +=    '<td class="whitespace-nowrap text-center">'+item.mem_nickname+'</td>';
                            ihtml +=    '</tr>';
                            dom.innerHTML = ihtml;

                            $("#pointMemList").append(dom);
                        });

                        $("#pointMemCnt")[0].innerHTML = data.totalCount;

                        $("#MemAllPaging")[0].innerHTML = '';

                        jQuery.ajax({
                            cache: false,
                            dataType:'json',
                            data: {
                                page : page,
                                totalCount : data.totalCount,
                                functionName : 'pointMemChange',
                            },
                            url: '/member/ajax/memberPaging',
                            success: function (pagingdata) {
                                if(pagingdata.resultCode=="SUCCESS"){
                                    $("#MemAllPaging").append(pagingdata.paging);
                                }else{
                                    console.log(pagingdata.resultMessage);
                                }
                            },
                            error: function (e) {
                                console.log('start');
                                console.log(e);
                                //alert('로딩 중 오류가 발생 하였습니다.');
                            }
                        });
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

        function pointMemChange(pointpage){
            getPointMemList(pointpage);
            g_page = pointpage;
        }

        function getSendPointMemList(page){
            $("#sendPointMemList")[0].innerHTML = '';
            var Listobj = sliceObj(send_member_data, page);
            Object.keys(Listobj).forEach(function(key){

                var dom = document.createElement('tr');

                var ihtml = "";

                var channel = Listobj[key].channel;
                var u_id = Listobj[key].u_id;
                var mem_nickname = Listobj[key].mem_nickname;

                ihtml =  '<tr>'
                ihtml +=    '<td class="whitespace-nowrap text-center">';
                ihtml +=    '<div class="form-check">';
                ihtml +=    '<input name="send_back_check" id="checkbox-switch-1" class="form-check-input send_back_check" type="checkbox" value="'+key+'">';
                ihtml +=    '</div>';
                ihtml +=    '<td class="whitespace-nowrap text-center">'+channel+'</td>';
                ihtml +=    '<td class="whitespace-nowrap text-center">'+u_id+'</td>';
                ihtml +=    '<td class="whitespace-nowrap text-center">'+mem_nickname+'</td>';
                ihtml +=    '</tr>';

                dom.innerHTML = ihtml;

                $('#sendPointMemList').append(dom);
            });

            $("#sendPointMemPaging")[0].innerHTML = '';

            $("#sendPointMemCnt")[0].innerHTML = Object.keys(send_member_data).length;

            jQuery.ajax({
                cache: false,
                dataType:'json',
                data: {
                    page : page,
                    totalCount : Object.keys(send_member_data).length,
                    functionName : 'pointMemDelete',
                },
                url: '/member/ajax/memberPaging',
                success: function (pagingdata) {
                    if(pagingdata.resultCode=="SUCCESS"){
                        $("#sendPointMemPaging").append(pagingdata.paging);
                    }else{
                        console.log(pagingdata.resultMessage);
                    }
                },
                error: function (e) {
                    console.log('start');
                    console.log(e);
                    //alert('로딩 중 오류가 발생 하였습니다.');
                }
            });
        }

        function pointMemDelete(pointpage){
            g_send_page = pointpage;
            getSendPointMemList(pointpage)
        }

        function sliceObj(obj, sliceCount){
            let newObj = {};
            for(let i=0 ; i < Object.keys(obj).length ; i++){
                if(!(i >= (sliceCount-1)*10 && i <= ((sliceCount-1)*10)+9)){break};
                let key = Object.keys(obj)[i];
                newObj[key] = obj[key]
            }
            return newObj
        }

        function checkFile(f){
            var file = f.files;
            if(!/\.(xlsx)$/i.test(file[0].name)) alert('xlsx 파일만 선택해 주세요.\n\n현재 파일 : ' + file[0].name);
            else return;
            if(/\.(xls)$/i.test(file[0].name)) alert('xls 파일은 xlsx로 변경하여 올려주세요.\n\n현재 파일 : ' + file[0].name);
            else return;
            f.outerHTML = f.outerHTML;
        }

        function validateForm(){

            var excelFileValue = document.getElementById('excelFile').value;

            if(excelFileValue==""){
                alert('첨부파일이 없습니다.');
                return false;
            }

            var formData = new FormData($("#excelUpload")[0]);

            jQuery.ajax({
                cache: false,
                contentType: false,
                processData: false,
                type : 'post',
                dataType:'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/member/ajax/excelupload',
                success: function (data) {

                    if(empty == "empty"){
                        alert('엑셀이 비어있습니다.');
                    }else{
                        send_member = [];
                        send_member_data = {};
                        g_send_page = 1;
                        g_page = 1;

                        data.forEach(rs => {
                            send_member.push(rs.idx);
                            send_member_data[rs.idx] = {
                                    channel : rs.channel,
                                    u_id : rs.u_id,
                                    mem_nickname : rs.mem_nickname,
                            };
                        });

                        getSendPointMemList(g_send_page);

                        $("#pointMemList")[0].innerHTML = '';
                        getPointMemList(g_page);
                    }
                },
                error: function (e) {
                    console.log('start');
                    console.log(e);
                    //alert('로딩 중 오류가 발생 하였습니다.');
                }
            });
        }

        function chTab(no){
            if(no==1){
                $(".tabform2").hide();
                $(".tabform1").show();
                document.getElementById('excelCode').value = '01';
            }else if(no==2){
                $(".tabform1").hide();
                $(".tabform2").show();
                document.getElementById('excelCode').value = '02';
            }else{
                alert("스크립트 오류입니다.");
            }
        }

        function excelDownload(){
            var scode = document.getElementById('excelCode').value;
            location.href = '/multilingual/menuDownloadExcel?siteCode='+scode;
        }
    </script>
@endsection
