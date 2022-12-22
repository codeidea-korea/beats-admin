@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">관리자 등록</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">

                        <form method="post" action="{{ url('/api/v1/member/chMemberPrp') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="file" name="photo_file" id="photo_file" >
                    <!-- table 시작 -->
                    <div class="p-5">
                        <div class="overflow-x-auto">

                            <!-- 테이블 끝 -->
                            <div class="flex justify-between w-full p-5">

                                <div>
                                    <button class="btn btn-primary w-24 ml-2 btn_create" type="submit">등록</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    </form>

                </div>
            </div>
        </div>


@endsection
