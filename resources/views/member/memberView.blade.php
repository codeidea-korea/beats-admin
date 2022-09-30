@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">회원관리{{$memberData->class}}</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">
                    <div id="boxed-tab" class="p-5">
                        <div class="preview">
                            <ul class="nav nav-boxed-tabs" role="tablist">

                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2 active" type="button" role="tab">기본 정보</button>
                                </li>
                                @if($memberData->class == 3)
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">코칭 상품</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">코칭 후기</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">포트폴리오</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">음원</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">앨범</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">코칭 내역</button>
                                </li>
                                @endif
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">콘텐츠 현황</button>
                                </li>
                                @if($memberData->class == 3)
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">결제 내역</button>
                                </li>
                                @endif
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">문의 내역</button>
                                </li>
                            </ul>
                        </div>
                    </div>

                        <div class="p-5">
                            <div class="">
                            <!-- 임시 회원
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">분류</th>
                                        <td colspan="3" class="whitespace-nowrap">
                                           임시 회원
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">고유 ID</th>
                                        <td colspan="3" class="whitespace-nowrap">
                                            {{$memberData->uid}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">아이디</th>
                                        <td>
                                            -
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10">가입체널</th>
                                        <td>
                                            -
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">닉네임</th>
                                        <td>
                                            -
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10">회원 구분</th>
                                        <td>
                                            {{$memberData->gubun}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">가입일</th>
                                        <td>
                                            {{$memberData->mem_regdate}}
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10">초대 회원</th>
                                        <td>
                                            -
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">최근 접속일</th>
                                        <td td colspan="3" class="whitespace-nowrap">
                                            {{$memberData->last_login_at}}
                                        </td>
                                    </tr>
                                </table>
                            -->
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10"  style="width:180px;">분류</th>
                                        <td style="width:380px;">
                                            통합회원
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10" style="width:180px;">회원 상태</th>
                                        <td>
                                            <select class="form-select w-13" aria-label=".form-select-lg" name="mem_status" style="width:280px;">
                                                <option value=""  @if($memberData->mem_status == "")  selected @endif>전체</option>
                                                <option value="0" @if($memberData->mem_status == "0") selected @endif>임시</option>
                                                <option value="1" @if($memberData->mem_status == "1") selected @endif>정상</option>
                                                <option value="2" @if($memberData->mem_status == "2") selected @endif>제재</option>
                                                <option value="3" @if($memberData->mem_status == "3") selected @endif>휴면</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">고유 ID</th>
                                        <td colspan="3" class="whitespace-nowrap">
                                            {{$memberData->uid}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">아이디</th>
                                        <td>
                                            {{$memberData->email_id}}
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10">가입체널</th>
                                        <td>
                                            {{$memberData->channel}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">닉네임</th>
                                        <td>
                                            {{$memberData->mem_nickname}}
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10">회원 구분</th>
                                        <td>
                                            {{$memberData->gubun}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">비밀번호 초기화</th>
                                        <td colspan="3" class="whitespace-nowrap">
                                            <input type="button" class="btn btn-primary w-36 ml-2" value="비밀번호 초기화">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">국적</th>
                                        <td>
                                            {{$memberData->nationality}}
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10">신고</th>
                                        <td>
                                            - (회)
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">연락처</th>
                                        <td colspan="3" class="whitespace-nowrap">
                                            {{$memberData->phone_number}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">가입일</th>
                                        <td>
                                            {{$memberData->mem_regdate}}
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10">초대 회원</th>
                                        <td>
                                            -
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10" rowspan="5">약관 동의</th>
                                        <td>
                                            통합계정 가입 통의(필수)
                                        </td>
                                        <td colspan="2">
                                            동의
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            만 14세 이상 동의(필수)
                                        </td>
                                        <td colspan="2">
                                            동의
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                           이용약관(필수)
                                        </td>
                                        <td colspan="2">
                                            동의
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            개인정보수집 및 이용동의(필수)
                                        </td>
                                        <td colspan="2">
                                            동의
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            마케팅 정보 수신 동의(선택)
                                        </td>
                                        <td colspan="2">
                                            미동의
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10" rowspan="4">현황</th>
                                        <td>
                                            결제 내역
                                        </td>
                                        <td colspan="2">
                                            00(건) <input type="button" class="btn btn-primary w-24 ml-2" value="자세히 보기">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            주문 내역
                                        </td>
                                        <td colspan="2">
                                            00(건) <input type="button" class="btn btn-primary w-24 ml-2" value="자세히 보기">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            구독 내역
                                        </td>
                                        <td colspan="2">
                                            00(건) <input type="button" class="btn btn-primary w-24 ml-2" value="자세히 보기">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            정산 내역
                                        </td>
                                        <td colspan="2">
                                            00(건) <input type="button" class="btn btn-primary w-24 ml-2" value="자세히 보기">
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">보유 포인트</th>
                                        <td>
                                            {{$memberData->mem_point}} Point
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10" rowspan="2">휴면 전환일</th>
                                        <td rowspan="2">
                                            {{$memberData->mem_dormancy}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">보유 쿠폰</th>
                                        <td>
                                            {{$memberData->nationality}}
                                        </td>
                                    </tr>


                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">최근 접속일</th>
                                        <td td colspan="3" class="whitespace-nowrap">
                                            {{$memberData->last_login_at}}
                                        </td>
                                    </tr>
                                </table>

                                <div class="flex w-full box pt-5">
                                    <div class="ml-auto">
                                        <button class="btn btn-secondary w-24">목록</button>
                                        <button class="btn btn-primary w-24 ml-2">수정</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>

        </div>

    </div>

    <script>
        $(function (){
            //$('#superlarge-modal-size-preview2').modal({ keyboard: false, backdrop: 'static' })
        })
    </script>
@endsection
