@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">탈퇴 관리</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">


                <div class="intro-y box">
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <form name="searchForm"  id="searchForm" action="" method="get">
                                <input type="hidden" name="page" value="{{ $searchData['page'] }}">
                                <table class="table table-bordered">
                                    <tr>
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
                                <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '/member/withdrawalList';">
                                    초기화
                                </button>
                            </div>
                            <div style="float:right;">
                                &nbsp;
                            </div>
                            <div style="float:right;">
                                <button class="btn box flex items-center text-slate-600 border border-slate-400 formSearchBtn">
                                    검색
                                </button>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format($totalCount)}}명의 탈퇴한 회원이 있습니다.</h2>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">No.</th>
                                    <th class="whitespace-nowrap text-center">서비스</th>
                                    <th class="whitespace-nowrap text-center">회원 구분</th>
                                    <th class="whitespace-nowrap text-center">가입 채널</th>
                                    <th class="whitespace-nowrap text-center">국적</th>
                                    <th class="whitespace-nowrap text-center">고유 ID</th>
                                    <th class="whitespace-nowrap text-center">닉네임</th>
                                    <th class="whitespace-nowrap text-center">제재</th>
                                    <th class="whitespace-nowrap text-center">상태</th>
                                    <th class="whitespace-nowrap text-center">가입일</th>
                                    <th class="whitespace-nowrap text-center">탈퇴일</th>
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
                                        {{$rs->delSiteValue}}
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
                                            {{$rs->u_id}}
                                        </a>
                                    </td>
                                    <td class="whitespace-nowrap text-center">
                                        <a href="/member/memberView/{{$rs->mem_id}}">
                                            {{$rs->mem_nickname}}
                                        </a>
                                    </td>
                                    <td class="whitespace-nowrap text-center">
                                        <a href="/member/memberView/{{$rs->mem_id}}">
                                            {{$rs->mem_sanctions}}
                                        </a>
                                    </td>
                                    <td class="whitespace-nowrap text-center">{{$rs->statusValue}}</td>
                                    <td class="whitespace-nowrap text-center">
                                        <a href="/member/memberView/{{$rs->mem_id}}">
                                            {{$rs->created_at}}
                                        </a>
                                    </td>
                                    <td class="whitespace-nowrap text-center">{{$rs->updated_at}}</td>
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
        $(".formSearchBtn").on('click', function(){
            document.forms["searchForm"].submit();
        });
        function change(page) {
            $("input[name=page]").val(page);
            document.forms["searchForm"].submit();
        }

    </script>
@endsection
