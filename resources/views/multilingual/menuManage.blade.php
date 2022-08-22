@extends('layouts.Default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">메뉴관리</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">
                    <!-- BEGIN: Boxed Tab -->
                    <div id="boxed-tab" class="p-5">
                        <div class="preview">
                            <ul class="nav nav-boxed-tabs" role="tablist">
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2 active" type="button" role="tab" > 바이비츠 </button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab" > 비트썸원 </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END: Boxed Tab -->

                    <!-- table 시작 -->
                    <div class="p-5">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="whitespace-nowrap text-center">No.</th>
                                <th class="whitespace-nowrap text-center">코드</th>
                                <th class="whitespace-nowrap text-center">한글</th>
                                <th class="whitespace-nowrap text-center">영어</th>
                                <th class="whitespace-nowrap text-center">중국어</th>
                                <th class="whitespace-nowrap text-center">일본어</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="w-10 text-center">1</td>
                                <td class="text-center">GNB_lang1</td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력" value="요금제"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                            </tr>
                            <tr>
                                <td class="w-10 text-center">2</td>
                                <td class="text-center">GNB_lang2</td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력" value="멘토 뮤지션 코칭"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                            </tr>
                            <tr>
                                <td class="w-10 text-center">3</td>
                                <td class="text-center"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력" value="활동중인 멘토 뮤지션"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                            </tr>
                            <tr>
                                <td class="w-10 text-center">4</td>
                                <td class="text-center"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력" value="메시지"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                            </tr>
                            <tr>
                                <td class="w-10 text-center">5</td>
                                <td class="text-center"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력" value="알림"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                                <td><input id="regular-form" type="text" class="form-control" placeholder="입력"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- table 끝-->
                    <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end p-5">
                        <button class="btn btn-primary w-24 ml-2">수정</button>
                    </div>
                </div>
            </div>
        </div>
@endsection


