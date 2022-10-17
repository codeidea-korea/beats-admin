@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">메뉴관리</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="flex w-full box pt-5">
                    <div class="ml-auto">
                        <button class="btn btn-primary w-24 ml-2" onClick="excelDownload()">Excel Download</button>

                    </div>
                    <form id="boardWriteForm" name="boardWriteForm" method="post" action="/multilingual/menuUploadExcel"  enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="excelCodeUp" id="excelCodeUp" >
                        <input type="button" class="btn btn-primary w-24 ml-2" value="Excel Upload" onClick="validateForm();">
                        <input type="file" name="excelFile" id="excelFile" onChange="checkFile(this)" >
                    </form>
                </div>
                <div class="intro-y box">
                    <!-- BEGIN: Boxed Tab -->
                    <div id="boxed-tab" class="p-5">
                        <div class="preview">
                            <ul class="nav nav-boxed-tabs" role="tablist">
                                <li class="nav-item flex-1" role="presentation" onClick="chTab(1);">
                                    <button class="nav-link w-full py-2 @if($params['siteCode']=="01") active @endif " type="button" role="tab"> 바이비츠 </button>
                                </li>
                                <li class="nav-item flex-1" role="presentation" onClick="chTab(2);">
                                    <button class="nav-link w-full py-2 @if($params['siteCode']=="02") active @endif " type="button" role="tab" > 비트썸원 </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END: Boxed Tab -->
                    <form name="tabform1" class="form-horizontal tabform1" role="form" id="RegForm"  method="post" action="{{ url('/multilingual/updateMenuManage') }}" @if($params['siteCode']=="02") style="display:none;" @endif >
                    @csrf
                        <input type="hidden" name="siteCode" value="01">
                    <!-- table 시작 -->
                    <div class="p-5 tab1">
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
                            @foreach($bybeatMenuList as $rs)
                            <tr>
                                <td class="w-10 text-center">{{$rs->menu_index}}<input type="hidden" name="menu_index[]" value="{{$rs->menu_index}}"></td>
                                <td class="text-center">{{$rs->menu_code}}</td>
                                <td><input id="regular-form" type="text" class="form-control" name="lang_kr[]" placeholder="입력" value="{{$rs->lang_kr}}"></td>
                                <td><input id="regular-form" type="text" class="form-control" name="lang_en[]" placeholder="입력" value="{{$rs->lang_en}}"></td>
                                <td><input id="regular-form" type="text" class="form-control" name="lang_ch[]" placeholder="입력" value="{{$rs->lang_ch}}"></td>
                                <td><input id="regular-form" type="text" class="form-control" name="lang_jp[]" placeholder="입력" value="{{$rs->lang_jp}}"></td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- table 끝-->
                        <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end p-5">
                            <button class="btn btn-primary w-24 ml-2" onClick="submit();">수정</button>
                        </div>

                    </form>
                    <form name="tabform2" class="form-horizontal tabform2" role="form" id="RegForm"  method="post" action="{{ url('/multilingual/updateMenuManage') }}"  @if($params['siteCode']=="01") style="display:none;" @endif>
                    @csrf
                        <input type="hidden" name="siteCode" value="02">
                    <!-- table 시작 -->
                    <div class="p-5 tab2" >
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
                            <tr> @foreach($beatSomeoneMenuList as $rs)
                                <tr>
                                    <td class="w-10 text-center">{{$rs->menu_index}}<input type="hidden" name="menu_index[]" value="{{$rs->menu_index}}"></td>
                                    <td class="text-center">{{$rs->menu_code}}</td>
                                    <td><input id="regular-form" type="text" class="form-control" name="lang_kr[]" placeholder="입력" value="{{$rs->lang_kr}}"></td>
                                    <td><input id="regular-form" type="text" class="form-control" name="lang_en[]" placeholder="입력" value="{{$rs->lang_en}}"></td>
                                    <td><input id="regular-form" type="text" class="form-control" name="lang_ch[]" placeholder="입력" value="{{$rs->lang_ch}}"></td>
                                    <td><input id="regular-form" type="text" class="form-control" name="lang_jp[]" placeholder="입력" value="{{$rs->lang_jp}}"></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- table 끝-->

                    <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end p-5">
                        <button class="btn btn-primary w-24 ml-2">수정</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <input type="hidden" id="excelCode" value="01">
        <script>
            function checkFile(f){
                var file = f.files;
                if(!/\.(xlsx)$/i.test(file[0].name)) alert('xlsx 파일만 선택해 주세요.\n\n현재 파일 : ' + file[0].name);
                else return;
                if(/\.(xls)$/i.test(file[0].name)) alert('xls 파일은 xlsx로 변경하여 올려주세요.\n\n현재 파일 : ' + file[0].name);
                else return;
                f.outerHTML = f.outerHTML;
            }
            function validateForm(){

                var scode = document.getElementById('excelCode').value;

                document.getElementById('excelCodeUp').value = scode;
                var excelFileValue = document.getElementById('excelFile').value;

                if(excelFileValue==""){
                    alert('첨부파일이 없습니다.');
                    return false;
                }
                document.forms["boardWriteForm"].submit();
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
            $(document).ready(function (e) {
                @if(session('message'))
                alert('엑셀 업로드 및 적용이 완료되었습니다.');
                @endif
            });

        </script>
@endsection


