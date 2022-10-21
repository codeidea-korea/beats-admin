@php
    header("Content-type: application/vnd.ms-excel; charset=UTF-8" );
    header("Content-Disposition: attachment; filename=".$params['fileName']);
    header("Content-Description: PHP8 Generated Data");
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");
@endphp
<style>
    #list
    {
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        width: 100%;
    }
    #list td, #list th
    {
        border: 1px dotted black;
        text-align: center;
    }
    #list th
    {
        color: black;
        background-color: greenyellow;
    }
    #list tr.alt td
    {
        background-color: yellow;
        text-align: center;
    }
</style>

<table id="list">
    <thead style="background: #CAE2AF;">
    <tr>
        <th>분류</th>
        <th>회원 구분</th>
        <th>가입 채널</th>
        <th>국적</th>
        <th>고유 ID</th>

        <th>닉네임</th>
        <th>제재</th>
        <th>상태</th>
        <th>가입일</th>
        <th>최근 접속일</th>
    </tr>
    </thead>
    <!-- 데이터 내용 x-->
    @if(count($memberList)==0)
        <tbody>
        <tr>
            <td colspan="10">
                <span>결과가 없습니다.</span>
            </td>
        </tr>
        </tbody>
@else
    <!-- 데이터 내용 o-->
        <tbody>
        @foreach($memberList as $rs)
            <tr>
                <td>
                        {{$rs->classValue}}
                </td>
                <td>
                        {{$rs->gubunValue}}
                </td>
                <td>
                        {{$rs->channelValue}}
                </td>
                <td>
                        {{$rs->nati}}
                </td>
                <td>
                        {{$rs->mem_id}}
                </td>
                <td>
                        {{$rs->mem_nickname}}
                </td>
                <td>{{$rs->mem_sanctions}}</td>
                <td>{{$rs->statusValue}}</td>
                <td>{{$rs->mem_regdate}}</td>

                <td>{{$rs->last_login_at}}</td>
            </tr>
        @endforeach

        </tbody>
@endif
<!-- 데이터 내용 o-->
</table>
