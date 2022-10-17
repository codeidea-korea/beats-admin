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
        <th>코드</th>
        <th>한글</th>
        <th>영어</th>
        <th>중국어</th>
        <th>일본어</th>
    </tr>
    </thead>
    <!-- 데이터 내용 x-->
    @if(count($menuList)==0)
        <tbody>
        <tr>
            <td colspan="6">
                <span>결과가 없습니다.</span>
            </td>
        </tr>
        </tbody>
    @else
    <!-- 데이터 내용 o-->
        <tbody>
        @foreach($menuList as $rs)
            <tr>
                <td>{{$rs->menu_code}}</td>
                <td>{{$rs->lang_kr}}</td>
                <td>{{$rs->lang_en}}</td>
                <td>{{$rs->lang_ch}}</td>
                <td>{{$rs->lang_jp}}</td>
            </tr>
        @endforeach

        </tbody>
    @endif
<!-- 데이터 내용 o-->
</table>
