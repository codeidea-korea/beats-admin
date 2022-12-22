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
                                <!--
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">구분</th>
                                    <td colspan="3">
                                        <div class="form-check inline-block ml-5">
                                            <input name="gubun" id="" class="form-check-input" type="checkbox" value="1">
                                            <label class="form-check-label" for="checkbox-switch-1">최저가</label>
                                        </div>
                                        <div class="form-check inline-block ml-5">
                                            <input name="gubun" id="" class="form-check-input" type="checkbox" value="2">
                                            <label class="form-check-label" for="checkbox-switch-2">추천</label>
                                        </div>
                                        <div class="form-check inline-block ml-5">
                                            <input name="gubun" id="" class="form-check-input" type="checkbox" value="3">
                                            <label class="form-check-label" for="checkbox-switch-3">구분 값 표기</label>
                                        </div>
                                    </td>
                                </tr>
                                -->
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">상품 뱃지</th>
                                    <td colspan="3">
                                        <input  name="bj" type="text" class="form-control" maxlength="10" value="{{$productData->bj}}" placeholder="10자 이내로 작성해주세요">
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">제품영</th>
                                    <td colspan="3">
                                        <input  name="name" type="text" class="form-control" value="{{$productData->name}}" placeholder="제품명 표기 영역">
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">(영어)제품영</th>
                                    <td colspan="3">
                                        <input name="name_en" type="text" class="form-control" value="{{$productData->name_en}}" placeholder="(영어) 제품명 표기 영역">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">(일본)제품영</th>
                                    <td colspan="3">
                                        <input name="name_jp" type="text" class="form-control" value="{{$productData->name_jp}}" placeholder="(일본) 제품명 표기 영역">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">(중국)제품영</th>
                                    <td colspan="3">
                                        <input name="name_ch" type="text" class="form-control" value="{{$productData->name_ch}}" placeholder="(중국) 제품명 표기 영역">
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">대표이미지</th>
                                    <td colspan="3">
                                        @if($productData->hash_name !=null)
                                            <img style="width:720px" src="{{$productData->urlLink}}">
                                        @endif
                                        <input type="file" name="productImg" id="productImg"  />
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">가격 설정</th>
                                    <td colspan="3">
                                        <div class="flex items-center">
                                            <input name="price" id="" type="text" class="form-control w-64 mr-2" value="{{$productData->price}}" placeholder=""><span>(원)</span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">옵션 설정</th>
                                    <td colspan="3">
                                        <div class="grid grid-cols-6 gap-6">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="whitespace-nowrap text-center w-32">옵션 구분</th>
                                                    <th class="whitespace-nowrap text-center w-32">형태-색상</th>
                                                    <th class="whitespace-nowrap text-center w-32">추가 금액</th>
                                                    <th class="whitespace-nowrap text-center w-32">재고수량</th>
                                                    <th class="whitespace-nowrap text-center w-32"><button class="btn btn-primary w-24" onClick="addOptionFrom();">추가</button></th>
                                                </tr>
                                                </thead>
                                                <tbody id="optionTable">
                                                @php $i=1; @endphp
                                                @foreach($optionData as $rs)
                                                <tr>
                                                    <th class="whitespace-nowrap text-center"><input type="hidden" name="option_no[]" value="{{$i}}">옵션#{{$i}}</th>
                                                    <td>
                                                        <input name="option_title[]" type="text" class="form-control" value="{{$rs->option_title}}" placeholder="기본형">
                                                    </td>
                                                    <td>
                                                        <input name="option_price[]" type="text" class="form-control" value="{{$rs->option_price}}" placeholder="0">
                                                    </td>
                                                    <td>
                                                        <input name="option_stock[]" type="text" class="form-control" value="{{$rs->option_stock}}" placeholder="0">
                                                    </td>
                                                    <td class="whitespace-nowrap text-center">
                                                        <button class='btn btn-danger w-24 btnCancle'>삭제</button>
                                                    </td>
                                                </tr>
                                                @php $i++; @endphp
                                                @endforeach
                                                </tbody>
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
                                                    <textarea class="form-control" name="information" id="information" style="width:95%"
                                                              rows="10" cols="10"
                                                              placeholder="내용을 입력해주세요"
                                                    >{{$productData->information}}</textarea>
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
                                                    <textarea class="form-control" name="information_en" id="information_en" style="width:95%"
                                                              rows="10" cols="10"
                                                              placeholder="내용을 입력해주세요"
                                                    >{{$productData->information_en}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10"><label style="color:#ff0000;">(일본)</label> 상세 정보</th>
                                    <td colspan="3">
                                        <div class="p-5" id="classic-editor">
                                            <div class="preview">
                                                <div class="editor">
                                                    <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
                                                    <textarea class="form-control" name="information_jp" id="information_jp" style="width:95%"
                                                              rows="10" cols="10"
                                                              placeholder="내용을 입력해주세요"
                                                    >{{$productData->information_jp}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10"><label style="color:#ff0000;">(중국)</label> 상세 정보</th>
                                    <td colspan="3">
                                        <div class="p-5" id="classic-editor">
                                            <div class="preview">
                                                <div class="editor">
                                                    <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
                                                    <textarea class="form-control" name="information_ch" id="information_ch" style="width:95%"
                                                              rows="10" cols="10"
                                                              placeholder="내용을 입력해주세요"
                                                    >{{$productData->information_ch}}</textarea>
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
                                                    <input name="delivery_charge" id="delivery_charge" type="text" value="{{$productData->delivery_charge}}" class="form-control" placeholder="0">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="whitespace-nowrap text-center">반품 배송비</th>
                                                <td>
                                                    <input name="delivery_charge_re" id="delivery_charge_re" type="text" value="{{$productData->delivery_charge_re}}" class="form-control" placeholder="0">
                                                </td>
                                                <th class="whitespace-nowrap text-center">교환 배송비 왕복</th>
                                                <td>
                                                    <input name="delivery_charge_ch" id="delivery_charge_ch" type="text" value="{{$productData->delivery_charge_ch}}" class="form-control" placeholder="0">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="whitespace-nowrap text-center">제주도 배송비</th>
                                                <td>
                                                    <input name="delivery_charge_jj" id="delivery_charge_jj" type="text" value="{{$productData->delivery_charge_jj}}" class="form-control" placeholder="0">
                                                </td>
                                                <th class="whitespace-nowrap text-center">도서산간 베송비</th>
                                                <td>
                                                    <input name="delivery_charge_ex" id="delivery_charge_ex" type="text" value="{{$productData->delivery_charge_ex}}" class="form-control" placeholder="0">
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
                                                    <textarea class="form-control" name="policy" id="policy" style="width:95%"
                                                              rows="10" cols="10"
                                                              placeholder="내용을 입력해주세요"
                                                    >{{$productData->policy}}</textarea>
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
                                                    <textarea class="form-control" name="policy_en" id="policy_en" style="width:95%"
                                                              rows="10" cols="10"
                                                              placeholder="내용을 입력해주세요"
                                                    >{{$productData->policy_en}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10"><label style="color:#ff0000;">(일본)</label>정책 <br> 배송/취소/교환/반품</th>
                                    <td colspan="3">
                                        <div class="p-5" id="classic-editor">
                                            <div class="preview">
                                                <div class="editor">
                                                    <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
                                                    <textarea class="form-control" name="policy_jp" id="policy_jp" style="width:95%"
                                                              rows="10" cols="10"
                                                              placeholder="내용을 입력해주세요"
                                                    >{{$productData->policy_jp}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10"><label style="color:#ff0000;">(중국)</label>정책 <br> 배송/취소/교환/반품</th>
                                    <td colspan="3">
                                        <div class="p-5" id="classic-editor">
                                            <div class="preview">
                                                <div class="editor">
                                                    <script type="text/javascript" src="/smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
                                                    <textarea class="form-control" name="policy_ch" id="policy_ch" style="width:95%"
                                                              rows="10" cols="10"
                                                              placeholder="내용을 입력해주세요"
                                                    >{{$productData->policy_ch}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">실 사용자 리뷰</th>
                                    <td>{000}(개)</td>
                                    <th class="whitespace-nowrap text-center bg-primary/10">구매자 리뷰</th>
                                    <td>{000}(개)</td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">등록일</th>
                                    <td>{{$productData->create_date}}</td>
                                    <th class="whitespace-nowrap text-center bg-primary/10">최근 수정일</th>
                                    <td>{{$productData->mode_date}}</td>
                                </tr>
                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">노출 상태</th>
                                    <td>
                                        <select name="is_display" class="form-select w-56" aria-label=".form-select-lg example">
                                            <option @if($productData->is_display=="Y") selected @endif value="Y">공개</option>
                                            <option @if($productData->is_display=="N") selected @endif value="N">비공개</option>
                                        </select>
                                    </td>
                                    <th class="whitespace-nowrap text-center bg-primary/10">판매 수</th>
                                    <td>{000}(건)</td>
                                </tr>

                                <tr>
                                    <th class="whitespace-nowrap text-center bg-primary/10">관리자</th>
                                    <td colspan="3">{{$productData->admin_name}}</td>
                                </tr>
                            </table>
                            <!-- 테이블 끝 -->
                            <div class="flex justify-between w-full p-5">
                                <div>
                                    <button class="btn btn-dark w-24">목록</button>
                                </div>
                                <div>
                                    <button class="btn btn-secondary w-24">삭제</button>
                                    <button class="btn btn-primary w-24 ml-2 proIn">수정</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="totalCnt" value="{{count($optionData)}}">
        <input type="hidden" name="products_idx" value="{{$params['idx']}}">


        <script>
            function addOptionFrom(){
                var totalCnt = $("#totalCnt").val();
                var nowCount = totalCnt*1+1;
                $("#totalCnt").val(nowCount);
                var dom = document.createElement('tr');
                var ihtml = "";
                ihtml =  "<tr>"
                ihtml += "<th class='whitespace-nowrap text-center'><input type='hidden' name='option_no[]' value='"+nowCount+"'>옵션#"+nowCount+"</th>"
                ihtml += "<td><input name='option_title[]'  type='text' class='form-control' placeholder='기본형'></td>"
                ihtml += "<td><input name='option_price[]'  type='text' class='form-control' placeholder='0'></td>"
                ihtml += "<td><input name='option_stock[]'  type='text' class='form-control' placeholder='0 '></td>"
                ihtml += "<td class='whitespace-nowrap text-center'><button class='btn btn-danger w-24 btnCancle'>삭제</button></td>"
                ihtml += "</tr>";
                dom.innerHTML = ihtml;

                $("#optionTable").append(dom);
            }

            $(function (){
                // 폼삭제
                $("#optionTable").on("click", ".btnCancle", function() {
                    $(this).closest("tr").remove();
                });

                $(".proIn").on('click', function(){

                    var formData = new FormData;

                    $("input[name='option_no[]']").each(function(i) {
                        formData.append('option_no[]',$(this).val());
                    });
                    $("input[name='option_title[]']").each(function(i) {
                        formData.append('option_title[]',$(this).val());
                    });
                    $("input[name='option_price[]']").each(function(i) {
                        formData.append('option_price[]',$(this).val());
                    });
                    $("input[name='option_stock[]']").each(function(i) {
                        formData.append('option_stock[]',$(this).val());
                    });

                    //구분은 기획 변경으로 제거
                    //$("input[name=gubun]:checked").each(function(){
                    //    formData.append('gubun[]',$(this).val());
                    //})

                    oEditors.getById["information"].exec("UPDATE_CONTENTS_FIELD", []);
                    oEditors.getById["information_en"].exec("UPDATE_CONTENTS_FIELD", []);
                    oEditors.getById["information_jp"].exec("UPDATE_CONTENTS_FIELD", []);
                    oEditors.getById["information_ch"].exec("UPDATE_CONTENTS_FIELD", []);
                    oEditors.getById["policy"].exec("UPDATE_CONTENTS_FIELD", []);
                    oEditors.getById["policy_en"].exec("UPDATE_CONTENTS_FIELD", []);
                    oEditors.getById["policy_jp"].exec("UPDATE_CONTENTS_FIELD", []);
                    oEditors.getById["policy_ch"].exec("UPDATE_CONTENTS_FIELD", []);


                    formData.append( "idx", $('input[name=products_idx]').val());
                    formData.append( "bj", $('input[name=bj]').val());
                    formData.append( "name", $('input[name=name]').val());
                    formData.append( "name_en", $('input[name=name_en]').val());
                    formData.append( "name_jp", $('input[name=name_jp]').val());
                    formData.append( "name_ch", $('input[name=name_ch]').val());
                    formData.append( "productImg", $("#productImg")[0].files[0] );
                    formData.append( "price", $('input[name=price]').val());
                    formData.append( "information", $("textarea[name='information']").val());
                    formData.append( "information_en", $("textarea[name='information_en']").val());
                    formData.append( "information_jp", $("textarea[name='information_jp']").val());
                    formData.append( "information_ch", $("textarea[name='information_ch']").val());
                    formData.append( "delivery_charge",   $('input[name=delivery_charge]').val());
                    formData.append( "delivery_charge_re",$('input[name=delivery_charge_re]').val());
                    formData.append( "delivery_charge_ch",$('input[name=delivery_charge_ch]').val());
                    formData.append( "delivery_charge_jj",$('input[name=delivery_charge_jj]').val());
                    formData.append( "delivery_charge_ex",$('input[name=delivery_charge_ex]').val());
                    formData.append( "policy",$("textarea[name='policy']").val());
                    formData.append( "policy_en", $("textarea[name='policy_en']").val());
                    formData.append( "policy_jp", $("textarea[name='policy_jp']").val());
                    formData.append( "policy_ch", $("textarea[name='policy_ch']").val());
                    formData.append( "is_display",$("select[name='is_display']").val());

                    jQuery.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type:"post",
                        cache: false,
                        processData: false,
                        contentType: false,
                        data: formData,
                        url: '{{ url('/products/productUpdate') }}',
                        success: function searchSuccess(data) {
                            if(data.code==0){
                                alert('상품이 수정되었습니다.');
                                location.href="/products/productList";
                            }else{
                                alert(data.message);
                            }
                        },
                        error: function (e) {
                            console.log(e);
                            alert('로딩 중 오류가 발생 하였습니다.');
                        }
                    });

                });

            })


            //* edit bar 설정
            let oEditors = [];

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
                    oAppRef: oEditors,
                    elPlaceHolder: "information_en",
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
                    oAppRef: oEditors,
                    elPlaceHolder: "information_jp",
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
                    oAppRef: oEditors,
                    elPlaceHolder: "information_ch",
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
                    oAppRef: oEditors,
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
                    oAppRef: oEditors,
                    elPlaceHolder: "policy_en",
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
                    oAppRef: oEditors,
                    elPlaceHolder: "policy_jp",
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
                    oAppRef: oEditors,
                    elPlaceHolder: "policy_ch",
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
