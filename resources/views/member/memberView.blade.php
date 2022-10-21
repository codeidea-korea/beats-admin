@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">회원관리</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">
                    <div id="boxed-tab" class="p-5">
                        <div class="preview">
                            <ul class="nav nav-boxed-tabs" role="tablist">

                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2 active" type="button" role="tab" onClick="javascript:location.href = '/member/memberView/{{$params['idx']}}';">기본 정보</button>
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
                                    <button class="nav-link w-full py-2" type="button" role="tab" onClick="javascript:location.href = '/member/musicList/{{$params['idx']}}';">음원</button>
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
                            <input type="hidden" name="mem_id" value="{{$memberData->mem_id}}" >
                                @if($memberData->gubun == 3) <!-- 3.음원 구매자 -->
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10">분류</th>
                                            <td colspan="3" class="whitespace-nowrap">
                                                {{$memberData->class_value}} /  {{$memberData->class_h_value}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10">고유 ID</th>
                                            <td colspan="3" class="whitespace-nowrap">
                                                {{$memberData->u_id}}
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
                                                {{$memberData->gubun_value}}
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
                                @endif
                                @if($memberData->gubun == 1) <!-- 1.일반 회원 -->
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10"  style="width:180px;">분류</th>
                                            <td style="width:380px;">
                                                {{$memberData->class_value}} /  {{$memberData->class_h_value}}
                                            </td>
                                            <th class="whitespace-nowrap text-center bg-primary/10" style="width:180px;">회원 상태</th>
                                            <td>
                                                <select class="form-select w-13" aria-label=".form-select-lg" name="mem_status" style="width:280px;">
                                                    <option value=""  @if($memberData->mem_status == "")  selected @endif>전체</option>
                                                    <option value="0" @if($memberData->mem_status == "0") selected @endif>임시</option>
                                                    <option value="1" @if($memberData->mem_status == "1") selected @endif>정상</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10">고유 ID</th>
                                            <td colspan="3" class="whitespace-nowrap">
                                                {{$memberData->u_id}}
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
                                                {{$memberData->gubun_value}}
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
                                                -
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                만 14세 이상 동의(필수)
                                            </td>
                                            <td colspan="2">
                                                -
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                이용약관(필수)
                                            </td>
                                            <td colspan="2">
                                                -
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                개인정보수집 및 이용동의(필수)
                                            </td>
                                            <td colspan="2">
                                                -
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                마케팅 정보 수신 동의(선택)
                                            </td>
                                            <td colspan="2">
                                                -
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10" rowspan="4">현황</th>
                                            <td>
                                                결제 내역
                                            </td>
                                            <td colspan="2">
                                                -
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                주문 내역
                                            </td>
                                            <td colspan="2">
                                                -
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                구독 내역
                                            </td>
                                            <td colspan="2">
                                                -
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                정산 내역
                                            </td>
                                            <td colspan="2">
                                                -
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
                                @endif
                                @if($memberData->gubun == 2) <!-- 2.작곡가 -->
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10"  style="width:180px;">분류</th>
                                            <td style="width:380px;">
                                                {{$memberData->class_value}} /  {{$memberData->class_h_value}}
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
                                                {{$memberData->u_id}}
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
                                                {{$memberData->gubun_value}}
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
                                                @if($memberData->marketing_consent == "Y") 동의 @else 미동의 @endif
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
                                @endif
                                @if($memberData->gubun == 4) <!-- 4.멘토뮤지션 -->
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10"  style="width:180px;">분류</th>
                                            <td style="width:380px;">
                                                {{$memberData->class_value}} /  {{$memberData->class_h_value}}
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
                                                {{$memberData->u_id}}
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
                                                {{$memberData->gubun_value}}
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
                                            <th class="whitespace-nowrap text-center bg-primary/10">멘토 뮤지션 전환일</th>
                                            <td> - </td>
                                            <th class="whitespace-nowrap text-center bg-primary/10">휴면 전환일</th>
                                            <td> @if(trim($memberData->mem_dormancy)=="") - @else {{$memberData->mem_dormancy}} @endif</td>
                                        </tr>

                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10" rowspan="3">전문 분야</th>
                                            <td>
                                                전문 분야
                                            </td>
                                            <td colspan="2">
                                               -
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                추가 분야
                                            </td>
                                            <td colspan="2">
                                                -
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                추가 분야
                                            </td>
                                            <td colspan="2">
                                                -
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10">증빙 자료</th>
                                            <td colspan="3" class="whitespace-nowrap">
                                                증빙자료가 없습니다.
                                                <!--
                                                    파일이름.확장자
                                                    파일이름.확장자
                                                     <button class="btn btn-primary w-24 ml-2 fileDownLoad">증빙자료 전체 다운로드</button>
                                                -->
                                            </td>
                                        </tr>


                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10">보유 포인트</th>
                                            <td colspan="3" class="whitespace-nowrap">
                                                {{$memberData->mem_point}} Point
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="whitespace-nowrap text-center bg-primary/10">보유 쿠폰</th>
                                            <td colspan="3" class="whitespace-nowrap">
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
                                @endif


                                <div class="intro-y box">
                                    <div class="p-5">
                                        <div class="overflow-x-auto">
                                            <div style="font-size:18px;">관리자메모</div>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th class="bg-primary/10 whitespace-nowrap w-8 text-center">작성자</th>
                                                        <td class="whitespace-nowrap">
                                                            {{auth()->user()->name}}
                                                            <input type="hidden" name="adminindex" id="adminindex" value="{{auth()->user()->idx}}" >
                                                        </td>
                                                    <tr>
                                                        <th class="bg-primary/10 whitespace-nowrap w-8 text-center">메모입력</th>
                                                        <td>
                                                            <input type="text" id="memo" name="memo" value="" style="width:80%;">
                                                            <button class="btn btn-primary w-24 ml-2 btn_memoin" >메모등록</button>
                                                        </td>
                                                    </tr>
                                                </table>
                                        </div>
                                    </div>

                                    <div class="p-5" id="memoList">

                                    </div>

                                </div>


                            <div class="flex w-full box pt-5">
                                <div class="ml-auto">
                                    <button class="btn btn-secondary w-24" onClick="javascript:location.href = '/member/memberList';">목록</button>
                                    <button class="btn btn-primary w-24 ml-2 btn_update">수정</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>


    </div>

    <script>

        function memoList(page){
            var mem_id = $('input[name=mem_id]').val();
            var data = {
                page:page
                , mem_id:mem_id
            };
            jQuery.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"GET",
                data: data,
                url: '{{ url('/member/ajax/memoList') }}',
                success: function searchSuccess(data) {
                    $("#memoList")[0].innerHTML = '';
                    $("#memoList").append(data);
                },
                error: function (e) {
                    alert('로딩 중 오류가 발생 하였습니다.');
                }
            });

        }

        function memoDel(idx){

            if (!confirm("삭제를 진행후 메모는 복구가 불가능합니다. 그래도 진행하시겠습니까?")) {
                return false;
            } else {
                var data = {
                    idx:idx
                };
                jQuery.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"post",
                    dataType:'json',
                    data: data,
                    url: '{{ url('/member/ajax/memoDel') }}',
                    success: function searchSuccess(data) {
                        if(data.result=="SUCCESS"){
                            alert('메모가 삭제되었습니다.');
                            memoList(1);
                        }else{
                            alert('처리 중 오류가 발생 하였습니다. 다시 시도해주세요.');
                        }
                    },
                    error: function (e) {
                        alert('로딩 중 오류가 발생 하였습니다.');
                    }
                });
            }

        }

        $(".btn_memoin").on('click', function(){

            var mem_id = $('input[name=mem_id]').val();
            var adminindex = $('input[name=adminindex]').val();
            var memo = $('input[name=memo]').val();
            if(memo.trim() == ""){
                alert('메모를 입력해주세요.');
                return false;
            }


            var data = {
                mem_id:mem_id
                ,adminindex:adminindex
                ,memo:memo
            };

            jQuery.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"post",
                dataType:'json',
                data: data,
                url: '{{ url('/member/ajax/memoInsert') }}',
                success: function searchSuccess(data) {
                    if(data.result=="SUCCESS"){
                        alert('메모가 등록되었습니다.');
                        $('input[name=memo]').val('');
                        memoList(1);
                    }else{
                        alert('처리 중 오류가 발생 하였습니다. 다시 시도해주세요.');
                    }
                },
                error: function (e) {
                    alert('로딩 중 오류가 발생 하였습니다.');
                }
            });
        });

        $(".btn_update").on('click', function(){

            var mem_id = $('input[name=mem_id]').val();
            var mem_status = $('select[name=mem_status]').val();


            var data = {
                mem_id:mem_id
                ,mem_status:mem_status
            };

            jQuery.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"post",
                dataType:'json',
                data: data,
                url: '{{ url('/member/ajax/memberUpdate') }}',
                success: function searchSuccess(data) {
                    if(data.result=="SUCCESS"){
                        alert('회원정보가 수정되었습니다.');
                        location.reload();
                    }else{
                        alert('처리 중 오류가 발생 하였습니다. 다시 시도해주세요.');
                    }
                },
                error: function (e) {
                    alert('로딩 중 오류가 발생 하였습니다.');
                }
            });
        });
        $(function() {
            memoList(1);
        });

    </script>
@endsection
