@extends('layouts.Default')
@section('content')


    <script type="text/javascript">
        jQuery(document).ready(function($)
        {
            $("#example-1").dataTable({
                aLengthMenu: [
                    [20, 100, -1], [20, 100, "All"]
                ]
                //,paging:false
                ,stateSave:true
                //,serverSide:true
            });
        });
    </script>

    <table id="example-1" class="table table-striped table-bordered table-hover" >
        <thead>
        <tr>
            <th style="width:8%">No</th>
            <th style="width:10%">그룹</th>
            <th style="width:10%">이름</th>
            <th style="width:20%">연락처</th>
            <th>E-mail</th>
            <th style="width:10%">상태</th>
            <th style="width:20%">등록일</th>
        </tr>
        </thead>

        <tbody>
        @foreach($adminList as $rs)
            <tr>
                <td style="width:8%">1</td>
                <td style="width:10%">{{$rs->group_name}}</td>
                <td style="width:10%"><a href="/admin/view?idx={{$rs->idx}}">{{$rs->name}}</a></td>
                <td style="width:20%">@if($rs->phoneno==null) 000-0000-0000 @else {{$rs->phoneno}} @endif</td>
                <td>{{$rs->email}}</td>
                <td style="width:10%">{{$rs->isuse}}</td>
                <td style="width:20%">{{$rs->created_at}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div style="float:right;">
        <button class="btn btn-purple" type="button" onClick="javascript:location.href = '/admin/write';">등록</button>
    </div>
@endsection
