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
                        <table class="table table-bordered table-hover"  >
                            <thead>
                            <tr>
                                <th class="whitespace-nowrap text-center">No.</th>
                                <th class="whitespace-nowrap text-center">언어</th>
                                <th class="whitespace-nowrap text-center">관리</th>
                            </tr>
                            </thead>
                            <tbody id="langTable">
                            @foreach($langList as $rs)
                                <tr>
                                    <td class="w-10 text-center">1</td>
                                    <td>
                                        <div class="mt-2">
                                            <select data-placeholder="Select your favorite actors" class="tom-select w-full">
                                                <option value=''>언어선택</option>
                                                <option value='kr' @if($rs->lang_code=='kr') selected @endif >한국어</option>
                                                <option value='en' @if($rs->lang_code=='en') selected @endif >영어</option>
                                                <option value='jp' @if($rs->lang_code=='jp') selected @endif >일본어</option>
                                                <option value='ch' @if($rs->lang_code=='ch') selected @endif >중국어</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="md:w-60 w-32">
                                        <button class="btn btn-primary w-24">완료</button>
                                    </td>
                                </tr>
                            @endforeach

                            {{--
                            <tr>
                                <td class="w-10 text-center">1</td>
                                <td>
                                     BEGIN: Basic Select
                                    <div class="mt-2">
                                        <select data-placeholder="Select your favorite actors" class="tom-select w-full">
                                            <option value="1">한국어</option>
                                            <option value="2">영어</option>
                                            <option value="3">일본어</option>
                                            <option value="4">중국어</option>
                                            <option value="5">프랑스어</option>
                                        </select>
                                    </div>
                                     END: Basic Select
                                </td>
                                <td class="md:w-60 w-32">
                                    <button class="btn btn-primary w-24">완료</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td>
                                    <input id="regular-form-1" type="text" class="form-control" placeholder="Input text">
                                </td>
                                <td>
                                    <button class="btn btn-outline-dark w-24 inline-block">수정</button>
                                    <button class="btn btn-danger w-24">삭제</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td>일본어</td>
                                <td>
                                    <button class="btn btn-outline-dark w-24 inline-block">수정</button>
                                    <button class="btn btn-danger w-24">삭제</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td>
                                    BEGIN: Basic Select
                                    <div class="mt-2">
                                        <select data-placeholder="Select your favorite actors" class="tom-select w-full">
                                            <option value="1">언어선택</option>
                                            <option value="2">영어</option>
                                            <option value="3">일본어</option>
                                            <option value="4">중국어</option>
                                            <option value="5">프랑스어</option>
                                        </select>
                                    </div>
                                     END: Basic Select
                                </td>
                                <td>
                                    <button class="btn btn-outline-pending w-24 inline-block">취소</button>
                                </td>
                            </tr>
                            --}}
                            </tbody>
                        </table>
                        <button onClick="addLangFrom();" class="btn btn-primary mt-5 intro-y w-full block text-center rounded-md py-4 border-slate-400">언어 추가</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function (){

            })

            function addLangFrom() {

                var ihtml = "";

                ihtml =  "<tr>"
                + "<td class='text-center'>4</td>"
                + "<td>"
                + "<div class='mt-2'>"
                + "<select data-placeholder='Select your favorite actors' class='tom-select w-full'>"
                + "<option value=''>언어선택</option>"
                + "<option value='kr'>한국어</option>"
                + "<option value='en'>영어</option>"
                + "<option value='jp'>일본어</option>"
                + "<option value='ch'>중국어</option>"
                + "</select>"
                + "</div>"
                + "</td>"
                + "<td><button class='btn btn-outline-pending w-24 inline-block'>취소</button></td>"
                + "</tr>";
                console.log(ihtml);
                document.getElementById('langTable').append(ihtml);
                //$("table tbody").append(ihtml);
                //$('#langTable').append(ihtml);
            }
        </script>
@endsection


