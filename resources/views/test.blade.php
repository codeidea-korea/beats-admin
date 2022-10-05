@extends('layouts.default')

@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">첨부파일 테스트</h2>
        </div>

    </div>

    <!-- 등록 모달 시작 -->
    <div id="superlarge-modal-size-preview" aria-hidden="true">
        <div class="modal-dialog modal-2xl">
            <div class="modal-content">
                <div class="modal-body p-10 text-center">

                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto">컨텐츠 등록</h2>
                    </div>

                    <form id="BannerWriteForm" method="post" action="/api/v1/soundSource/soundFileUpdate" enctype="multipart/form-data">
                        <div class="overflow-x-auto">
                            {{ csrf_field() }}
                            <input type="hidden" name="banner_code" value=""/>
                            <table class="table table-bordered">

                                <tr>
                                    <td>
                                        <input type="file" multiple="multiple" name="music_file[]" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                                    </td>
                                </tr>

                            </table>
                        </div>

                        <div class="flex items-center justify-center mt-5">
                            <button class="btn btn-primary w-32 ml-2 mr-2 bannerAddbtn">등록</button>
                            <button type="button" class="btn btn-secondary w-32" data-tw-dismiss="modal">닫기</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 등록 모달 끝 -->




@endsection


