<div class="overflow-x-auto">
    <table class="table table-bordered table-hover table-auto">
        <thead>
        <tr>
            <th class="whitespace-nowrap text-center" style="width:8%;">No.</th>
            <th class="whitespace-nowrap text-center" >메모</th>
            <th class="whitespace-nowrap text-center" style="width:10%;">관리자</th>
            <th class="whitespace-nowrap text-center" style="width:10%;">등록일</th>
            <th class="whitespace-nowrap text-center" style="width:10%;"> - </th>

        </tr>
        </thead>
        <tbody>
        @if($totalCount==0)
            <tr>
                <td class="whitespace-nowrap text-center" colspan="5">
                    데이터가 없습니다.
                </td>
            </tr>
        @endif
        @php $i=0; @endphp
        @foreach($memoList as $rs)
        <tr>
            <td class="whitespace-nowrap text-center">
                {{$totalCount-($i+(($params['page']-1)*10))}}
            </td>
            <td class="whitespace-nowrap text-center">
                {{$rs->memo}}
            </td>
            <td class="whitespace-nowrap text-center">
                {{$rs->adminindex}}
            </td>
            <td class="whitespace-nowrap text-center">
                {{$rs->crdate}}
            </td>
            <td class="whitespace-nowrap text-center">
                <button class="btn btn-primary w-24 ml-2" onClick="memoDel({{$rs->idx}});">삭제</button>
            </td>
        </tr>
        @php $i++; @endphp
        @endforeach

        </tbody>
    </table>
</div>
