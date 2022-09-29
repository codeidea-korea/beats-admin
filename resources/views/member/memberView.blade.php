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
                                    <button class="nav-link w-full py-2 active" type="button" role="tab">기본 정보</button>
                                </li>
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
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">콘텐츠 현황</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">콘텐츠 현황</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">결제 내역</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">문의 내역</button>
                                </li>
                            </ul>
                        </div>
                    </div>


                        <div class="p-5">
                            <div class="">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">음원 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select name="progress_rate" class="form-select" aria-label=".form-select-lg example">
                                                <option value="">전체</option>
                                                <option value="!=">작업 중</option>
                                                <option value="=">최종본</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10">작업 방식</th>
                                        <td class="whitespace-nowrap">
                                            <select name="common_composition" class="form-select" aria-label=".form-select-lg example">
                                                <option value="">전체</option>
                                                <option value="Y">개인 작업</option>
                                                <option value="N">공동 작업</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10">판매 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select name="sales_status" class="form-select" aria-label=".form-select-lg example">
                                                <option value="">전체</option>
                                                <option value="Y">판매중</option>
                                                <option value="N">미 판매중</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10">공개 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select name="open_status" class="form-select" aria-label=".form-select-lg example">
                                                <option value="">전체</option>
                                                <option value="Y">공개</option>
                                                <option value="N">비 공개</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">검색</th>
                                        <td colspan="7">
                                            <input name="search_text" id="regular-form-1" type="text" class="form-control">
                                        </td>
                                    </tr>
                                </table>
                                <div class="flex w-full box pt-5">
                                    <div class="ml-auto">
                                        <button class="btn btn-secondary w-24">초기화</button>
                                        <button class="btn btn-primary w-24 ml-2">검색</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 개의 음원이 있습니다.</h2>
                    </div>

                </div>
            </div>
            <!-- 페이징처리 시작 -->
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-5">
                <nav class="w-full">



                </nav>
            </div>
            <!-- 페이징처리 종료 -->
        </div>

    </div>

    <script>
        $(function (){
            //$('#superlarge-modal-size-preview2').modal({ keyboard: false, backdrop: 'static' })
        })
    </script>
@endsection
