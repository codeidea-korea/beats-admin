@extends('layouts.default')
@section('content')

    <div class="content">
        <!-- BEGIN: Top Bar -->
    @include('include.topBarINC')
    <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">요금제 관리</h2>
        </div>

        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="intro-y col-span-12 lg:col-span-12">

                <div class="intro-y box mt-5">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
                        <h2 class="font-medium text-base mr-auto text-primary">총 <span id="pointMemCnt">{{number_format($totalCount)}}</span>개의 요금제가 있습니다.</h2>
                        <button class="btn box flex items-center text-slate-600 border border-slate-400" onClick="javascript:location.href = '{{ url('/plan/planWrite') }}';">
                            등록
                        </button>
                    </div>
                    <div class="p-5">
                        <div class="overflow-x-auto">
                            <table class="table table-bordered table-hover table-auto">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">No.</th>
                                    <th class="whitespace-nowrap text-center">LANG</th>
                                    <th class="whitespace-nowrap text-center">요금제 이름</th>
                                    <th class="whitespace-nowrap text-center">기본 문구</th>
                                    <th class="whitespace-nowrap text-center">이용 요금</th>
                                    <th class="whitespace-nowrap text-center">혜택 수</th>
                                    <th class="whitespace-nowrap text-center">이용자 수</th>
                                    <th class="whitespace-nowrap text-center">사용 여부</th>
                                    <th class="whitespace-nowrap text-center">관리자</th>
                                    <th class="whitespace-nowrap text-center">등록일</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($totalCount==0)
                                    <tr>
                                        <td colspan="9" style="text-align:center;"> 등록된 요금제가 없습니다. </td>
                                    </tr>
                                @endif
                                @php $i=0; @endphp
                                @foreach($planList as $rs)
                                    <tr>
                                        <td class="whitespace-nowrap text-center">{{$totalCount-$i}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->lang}}</td>
                                        <td class="whitespace-nowrap text-center"><a href="/plan/planView/{{$rs->idx}}">{{$rs->name}}</a></td>
                                        <td class="whitespace-nowrap text-center"><a href="/plan/planView/{{$rs->idx}}">{{$rs->contents}}</a></td>
                                        <td class="whitespace-nowrap text-center">{{$rs->fee}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->benefitsCnt}}</td>
                                        <td class="whitespace-nowrap text-center"> - </td>
                                        <td class="whitespace-nowrap text-center">{{$rs->isYnView}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->admin_name}}</td>
                                        <td class="whitespace-nowrap text-center">{{$rs->create_date}}</td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script>

    </script>
@endsection
