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
                                    <button class="nav-link w-full py-2" type="button" role="tab" onClick="javascript:location.href = '/member/memberView/{{$params['idx']}}';">기본 정보</button>
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
                                    <button class="nav-link w-full py-2 active" type="button" role="tab" onClick="javascript:location.href = '/member/musicList/{{$params['idx']}}';">음원</button>
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

                    <form name="searchForm" id="searchForm" class="form-horizontal" role="form"   method="get" action="{{ url('/member/musicList/'.$params['idx']) }}">
                        <div class="p-5">
                            <div class="">
                                <table class="table table-bordered">
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">음원 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select name="progress_rate" class="form-select" aria-label=".form-select-lg">
                                                <option value=""        @if($params['progress_rate']=="") selected @endif >전체</option>
                                                <option value="working" @if($params['progress_rate']=="working") selected @endif >작업 중</option>
                                                <option value="100"   @if($params['progress_rate']=="100") selected @endif >최종본</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10">작업 방식</th>
                                        <td class="whitespace-nowrap">
                                            <select name="common_composition" class="form-select" aria-label=".form-select-lg example">
                                                <option value=""  @if($params['common_composition']=="") selected @endif  >전체</option>
                                                <option value="N" @if($params['common_composition']=="N") selected @endif >개인 작업</option>
                                                <option value="Y" @if($params['common_composition']=="Y") selected @endif >공동 작업</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10">판매 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select name="sales_status" class="form-select" aria-label=".form-select-lg example">
                                                <option value=""  @if($params['sales_status']=="") selected @endif >전체</option>
                                                <option value="Y" @if($params['sales_status']=="Y") selected @endif >판매중</option>
                                                <option value="N" @if($params['sales_status']=="N") selected @endif >미 판매중</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                        <th class="whitespace-nowrap text-center bg-primary/10">공개 상태</th>
                                        <td class="whitespace-nowrap">
                                            <select name="open_status" class="form-select" aria-label=".form-select-lg example">
                                                <option value=""  @if($params['open_status']=="") selected @endif  >전체</option>
                                                <option value="Y" @if($params['open_status']=="Y") selected @endif >공개</option>
                                                <option value="N" @if($params['open_status']=="N") selected @endif >비 공개</option>
                                            </select>
                                            <!--<button class="btn btn-primary w-24">대상 설정</button>-->
                                        </td>
                                    <tr>
                                        <th class="whitespace-nowrap text-center bg-primary/10">검색</th>
                                        <td colspan="7">
                                            <input name="search_text" id="regular-form-1" type="text" value="{{$params['search_text']}}" class="form-control">
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
                    </form>
                </div>
            </div>
            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 {{number_format(count($musicList))}}개의 음원이 있습니다.</h2>
                    </div>
                    <div class="p-2 bg-slate-200 flex flex-wrap gap-3">
                        @foreach($musicList as $rs)
                            <div class="intro-x box p-5 w-full">
                                <div class="w-full items-center flex gap-5">
                                    <script src="https://unpkg.com/wavesurfer.js"></script>
                                    <div class="border-l flex gap-3 px-5 ml-auto">
                                        <audio id="player" controls  src="{{url('/storage'.$rs->file_url.'/'.$rs->hash_name)}}">
                                        </audio>
                                    </div>
                                    <div class="grow px-5">
                                        <div class="font-medium text-lg">{{$rs->music_title}}</div>
                                        <div class="text-slate-400 mt-1"> <span class="font-bold"><a href="javascript:test123();">최근 수정일</a> :</span>{{$rs->moddate}}</div>
                                        <div class="text-slate-400 flex items-center mt-1">
                                            <i data-lucide="circle" class="w-4 h-4 mr-1"></i>
                                            47
                                        </div>
                                        <div class="font-medium text-lg" id="waveform"></div>
                                    </div>


                                    <div class="border-l flex gap-3 px-5 ml-auto">
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">작업 방식</div>
                                            <div class="btn-warning p-1 rounded-md">@if($rs->common_composition=="Y") 공동작업 @else 개인작업 @endif</div>
                                        </div>
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">작업 진행률</div>
                                            <div class="btn-warning p-1 rounded-md">{{$rs->progress_rate}}%</div>
                                        </div>
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">재생 시간</div>
                                            <div class="btn-warning p-1 rounded-md">{{$rs->play_time}}</div>
                                        </div>
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center" style="width:90px;">
                                            <div class="font-bold">판매 상태</div>
                                            <div class="btn-secondary p-1 rounded-md">@if($rs->sales_status=="Y") 판매중 @else 미판매중 @endif</div>
                                        </div>
                                        <div class="border border-slate-300 rounded-md border-dashed p-3 text-center">
                                            <div class="font-bold">공개 상태</div>
                                            <div class="btn-secondary p-1 rounded-md">@if($rs->open_status=="Y") 공개 @else 비공개 @endif</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="border border-slate-300 rounde-md border-dashed p-2 rounded-md flex flex-wrap gap-3">
                                        @php $explode = explode( ',', $rs->tag);@endphp
                                        @foreach($explode as $value)
                                            <div data-theme="light" class="btn btn-secondary py-1 px-2">
                                                {{$value}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="flex box justify-between w-full p-5">
                            <div>
                                <button class="btn btn-secondary w-24" onClick="javascript:location.href = '/member/memberList';">목록</button>
                            </div>
                            <!--
                            <div>
                                <button class="btn btn-primary w-24 ml-2">수정</button>
                            </div>
                            -->
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
