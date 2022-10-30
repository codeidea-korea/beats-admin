@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">제품 등록</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">
                    <!-- BEGIN: Boxed Tab -->
                    <div id="boxed-tab" class="p-5">
                        <div class="preview">
                            <ul class="nav nav-boxed-tabs" role="tablist">
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2 active" type="button" role="tab">기본 정보</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">실 사용자 리뷰</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">구매자 리뷰</button>
                                </li>
                                <li class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-2" type="button" role="tab">판매 내역</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END: Boxed Tab -->

                    <!-- table 시작 -->
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">구분</th>
                                    <td colspan="3">
                                        <div class="form-check inline-block ml-5">
                                            <input name="gubun" id="" class="form-check-input" type="checkbox" value="">
                                            <label class="form-check-label" for="checkbox-switch-1">최저가</label>
                                        </div>
                                        <div class="form-check inline-block ml-5">
                                            <input name="gubun" id="" class="form-check-input" type="checkbox" value="">
                                            <label class="form-check-label" for="checkbox-switch-2">추천</label>
                                        </div>
                                        <div class="form-check inline-block ml-5">
                                            <input name="gubun" id="" class="form-check-input" type="checkbox" value="">
                                            <label class="form-check-label" for="checkbox-switch-3">구분 값 표기</label>
                                        </div>
                                        <!--

                                        <div class="form-check inline-block ml-5">
                                            <input id="radio-switch-1" class="form-check-input" type="radio" name="vertical_radio_button" value="vertical-radio-chris-evans">
                                            <label class="form-check-label" for="radio-switch-1">최저가</label>
                                        </div>
                                        <div class="form-check inline-block ml-5">
                                            <input id="radio-switch-2" class="form-check-input" type="radio" name="vertical_radio_button" value="vertical-radio-liam-neeson">
                                            <label class="form-check-label" for="radio-switch-2">추천</label>
                                        </div>
                                        <div class="form-check inline-block ml-5">
                                            <input id="radio-switch-3" class="form-check-input" type="radio" name="vertical_radio_button" value="vertical-radio-daniel-craig">
                                            <label class="form-check-label" for="radio-switch-3">구분 값 표기</label>
                                        </div>
                                        -->
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">제품영</th>
                                    <td colspan="3">
                                        <input  name="prName" type="text" class="form-control" placeholder="제품명 표기 영역">
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">(영어)제품영</th>
                                    <td colspan="3">
                                        <input name="prNameEng" type="text" class="form-control" placeholder="(영어) 제품명 표기 영역">
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">대표이미지</th>
                                    <td colspan="3">
                                        <form data-single="true" action="/file-upload" class="dropzone">
                                            <div class="fallback">
                                                <input name="file" type="file" />
                                            </div>
                                            <div class="dz-message" data-dz-message>
                                                <div class="text-lg font-medium">Drop files here or click to upload.</div>
                                                <div class="text-slate-500">
                                                    This is just a demo dropzone. Selected files are <span class="font-medium">not</span> actually uploaded.
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">가격 설정</th>
                                    <td colspan="3">
                                        <div class="flex items-center">
                                            <input name="price" id="" type="text" class="form-control w-64 mr-2" placeholder=""><span>(원)</span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">옵션 설정</th>
                                    <td colspan="3">
                                        <div class="grid grid-cols-6 gap-6">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th class="whitespace-nowrap text-center w-32">옵션 구분</th>
                                                    <td>
                                                        <input id="regular-form-1" type="text" class="form-control" placeholder="형태">
                                                    </td>
                                                    <th class="whitespace-nowrap text-center w-32">옵션 구분</th>
                                                    <td>
                                                        <input id="regular-form-1" type="text" class="form-control" placeholder="색상">
                                                    </td>
                                                    <th class="whitespace-nowrap text-center w-32">추가 금액</th>
                                                    <th class="whitespace-nowrap text-center w-32">재고 수량</th>
                                                    <th class="whitespace-nowrap text-center w-32">-</th>
                                                </tr>

                                                <tr>
                                                    <th class="whitespace-nowrap text-center">옵션#1</th>
                                                    <td>
                                                        <input id="regular-form-1" type="text" class="form-control" placeholder="기본형">
                                                    </td>
                                                    <th class="whitespace-nowrap text-center">옵션#2</th>
                                                    <td>
                                                        <input id="regular-form-1" type="text" class="form-control" placeholder="Black">
                                                    </td>
                                                    <td class="whitespace-nowrap">
                                                        <input id="regular-form-1" type="text" class="form-control" placeholder="0">
                                                    </td>
                                                    <td class="whitespace-nowrap">
                                                        <input id="regular-form-1" type="text" class="form-control" placeholder="10,000">
                                                    </td>
                                                    <td class="whitespace-nowrap text-center">
                                                        <button class="btn btn-primary w-24">추가</button>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th class="whitespace-nowrap text-center">옵션#1</th>
                                                    <td>
                                                        <input id="regular-form-1" type="text" class="form-control" placeholder="기본형">
                                                    </td>
                                                    <th class="whitespace-nowrap text-center">옵션#2</th>
                                                    <td>
                                                        <input id="regular-form-1" type="text" class="form-control" placeholder="Red">
                                                    </td>
                                                    <td class="whitespace-nowrap">
                                                        <input id="regular-form-1" type="text" class="form-control" placeholder="0">
                                                    </td>
                                                    <td class="whitespace-nowrap">
                                                        <input id="regular-form-1" type="text" class="form-control" placeholder="10,000">
                                                    </td>
                                                    <td class="whitespace-nowrap text-center">
                                                        <button class="btn btn-danger w-24">삭제</button>
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">상세 정보</th>
                                    <td colspan="3">
                                        <div class="p-5" id="classic-editor">
                                            <div class="preview">
                                                <div class="editor">
                                                    <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
                                                    <textarea class="form-control" name="information" id="information"
                                                              rows="10" cols="10"
                                                              placeholder="내용을 입력해주세요"
                                                    ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10"><label style="color:#ff0000;">(영어)</label> 상세 정보</th>
                                    <td colspan="3">
                                        <div class="p-5" id="classic-editor">
                                            <div class="preview">
                                                <div class="editor">
                                                    <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
                                                    <textarea class="form-control" name="informationEng" id="informationEng"
                                                              rows="10" cols="10"
                                                              placeholder="내용을 입력해주세요"
                                                    ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">배송비</th>
                                    <td colspan="3" class="whitespace-nowrap text-center">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th class="whitespace-nowrap text-center">기본 배송비</th>
                                                <td colspan="3" class="whitespace-nowrap">
                                                    <input name="deliveryCharge" id="deliveryCharge" type="text" class="form-control" placeholder="0">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="whitespace-nowrap text-center">반품 배송비</th>
                                                <td>
                                                    <input name="deliveryChargeRe" id="deliveryChargeRe" type="text" class="form-control" placeholder="0">
                                                </td>
                                                <th class="whitespace-nowrap text-center">교환 배송비 왕복</th>
                                                <td>
                                                    <input name="deliveryChargeCh" id="deliveryChargeCh" type="text" class="form-control" placeholder="0">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="whitespace-nowrap text-center">제주도 배송비</th>
                                                <td>
                                                    <input name="deliveryChargeJj" id="deliveryChargeJj" type="text" class="form-control" placeholder="0">
                                                </td>
                                                <th class="whitespace-nowrap text-center">도서산간 베송비</th>
                                                <td>
                                                    <input name="deliveryChargeEx" id="deliveryChargeEx" type="text" class="form-control" placeholder="0">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">정책 <br>배송/취소/교환/반품 </th>
                                    <td colspan="3">
                                        <div class="p-5" id="classic-editor">
                                            <div class="preview">
                                                <div class="editor">
                                                    <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
                                                    <textarea class="form-control" name="policy" id="policy"
                                                              rows="10" cols="10"
                                                              placeholder="내용을 입력해주세요"
                                                    ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10"><label style="color:#ff0000;">(영어)</label>정책 <br> 배송/취소/교환/반품</th>
                                    <td colspan="3">
                                        <div class="p-5" id="classic-editor">
                                            <div class="preview">
                                                <div class="editor">
                                                    <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
                                                    <textarea class="form-control" name="policyEng" id="policyEng"
                                                              rows="10" cols="10"
                                                              placeholder="내용을 입력해주세요"
                                                    ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">판매자</th>
                                    <td class="whitespace-nowrap">
                                        <select class="form-select w-56" aria-label=".form-select-lg example">
                                            <option>판매자 닉네임</option>
                                            <option>전체1</option>
                                            <option>전체2</option>
                                        </select>
                                        <button class="btn btn-primary w-24">자세히 보기</button>
                                    </td>
                                    <th class="whitespace-nowrap text-center bg-primary/10">판매 수</th>
                                    <td>{000}(건)</td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">실 사용자 리뷰</th>
                                    <td>{000}(개)</td>
                                    <th class="whitespace-nowrap text-center bg-primary/10">구매자 리뷰</th>
                                    <td>{000}(개)</td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">등록일</th>
                                    <td>yyyy.mm.dd HH:MM:SS</td>
                                    <th class="whitespace-nowrap text-center bg-primary/10">최근 수정일</th>
                                    <td>yyyy.mm.dd HH:MM:SS</td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">노출 상태</th>
                                    <td colspan="3">
                                        <select class="form-select w-56" aria-label=".form-select-lg example">
                                            <option>공개</option>
                                            <option>비공개</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">관리자</th>
                                    <td colspan="3">홍길동</td>
                                </tr>
                            </table>
                            <!-- 테이블 끝 -->
                            <div class="flex justify-between w-full p-5">
                                <div>
                                    <button class="btn btn-dark w-24">목록</button>
                                </div>
                                <div>
                                    <button class="btn btn-secondary w-24">삭제</button>
                                    <button class="btn btn-primary w-24 ml-2">수정</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>

            let oEditors = [];
            let oEditors2 = [];
            let oEditors3 = [];
            let oEditors4 = [];

            $(document).ready(function() {
                nhn.husky.EZCreator.createInIFrame({
                    oAppRef: oEditors,
                    elPlaceHolder: "information",
                    sSkinURI: "/smarteditor2-2.8.2.3/SmartEditor2Skin.html",
                    fCreator: "createSEditor2",
                    htParams : {
                        bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                        bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                        bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                        fOnBeforeUnload : function(){
                        }
                    },
                    fOnAppLoad : function(){
                    },
                })
            })

            $(document).ready(function() {
                nhn.husky.EZCreator.createInIFrame({
                    oAppRef: oEditors2,
                    elPlaceHolder: "informationEng",
                    sSkinURI: "/smarteditor2-2.8.2.3/SmartEditor2Skin.html",
                    fCreator: "createSEditor2",
                    htParams : {
                        bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                        bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                        bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                        fOnBeforeUnload : function(){
                        }
                    },
                    fOnAppLoad : function(){
                    },
                })
            })

            $(document).ready(function() {
                nhn.husky.EZCreator.createInIFrame({
                    oAppRef: oEditors3,
                    elPlaceHolder: "policy",
                    sSkinURI: "/smarteditor2-2.8.2.3/SmartEditor2Skin.html",
                    fCreator: "createSEditor2",
                    htParams : {
                        bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                        bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                        bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                        fOnBeforeUnload : function(){
                        }
                    },
                    fOnAppLoad : function(){
                    },
                })
            })

            $(document).ready(function() {
                nhn.husky.EZCreator.createInIFrame({
                    oAppRef: oEditors4,
                    elPlaceHolder: "policyEng",
                    sSkinURI: "/smarteditor2-2.8.2.3/SmartEditor2Skin.html",
                    fCreator: "createSEditor2",
                    htParams : {
                        bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                        bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                        bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                        fOnBeforeUnload : function(){
                        }
                    },
                    fOnAppLoad : function(){
                    },
                })
            })




        </script>


@endsection
