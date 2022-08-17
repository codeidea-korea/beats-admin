<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Xenon Boostrap Admin Panel" />
    <meta name="author" content="" />

    <title>Admin - Data Tables</title>

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
    <link rel="stylesheet" href="/assets/css/fonts/linecons/css/linecons.css">
    <link rel="stylesheet" href="/assets/css/fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/xenon-core.css">
    <link rel="stylesheet" href="/assets/css/xenon-forms.css">
    <link rel="stylesheet" href="/assets/css/xenon-components.css">
    <link rel="stylesheet" href="/assets/css/xenon-skins.css">
    <link rel="stylesheet" href="/assets/css/custom.css">

    <script src="/assets/js/jquery-1.11.1.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
<body class="page-body">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

    <!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
    <!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
    <!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
    <div class="sidebar-menu toggle-others fixed">

        <div class="sidebar-menu-inner">

            <header class="logo-env">

                <!-- logo -->
                <div class="logo">
                    <a href="/dashboard" class="logo-expanded">
                        <img src="/assets/images/logo@2x2.png"  alt="" />
                    </a>
                </div>

                <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
                <div class="mobile-menu-toggle visible-xs">
                    <a href="#" data-toggle="mobile-menu">
                        <i class="fa-bars"></i>
                    </a>
                </div>

            </header>



            <ul id="main-menu" class="main-menu">
                <!-- add class "multiple-expanded" to allow multiple submenus to open -->
                <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
                <li>
                    <a href="/admin/list">
                        <i class="linecons-cog"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="active opened active">
                    <a href="/admin/list">
                        <i class="linecons-user"></i>
                        <span class="title">관리자 관리</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>

        </div>

    </div>

    <div class="main-content">


        <div class="page-title">

            <div class="title-env">
                <h1 class="title">사용자관리</h1>
            </div>

            <div class="breadcrumb-env">

                <ol class="breadcrumb bc-1" >
                    <li>
                        <a href="/dashboard"><i class="fa-home"></i>Home</a>
                    </li>
                    <li class="active">
                        <strong>사용자관리</strong>
                    </li>
                </ol>

            </div>

        </div>


        <!-- 공지사항 -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">관리자 상세</h3>
            </div>
            <div class="panel-body">

                <form role="form" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="field-1">상태</label>

                        <div class="col-sm-10">
                            <select class="form-control" name="isuse">
                                <option value="Y" @if($adminData->isuse=="Y") selected @endif>활성화</option>
                                <option value="N" @if($adminData->isuse=="N") selected @endif>비활성화</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="field-1">그룹</label>

                        <div class="col-sm-10">
                            <select class="form-control" name="group_code">
                                @foreach($groupList as $rs)
                                    <option value="{{$rs->group_code}}" @if($adminData->group_code==$rs->group_code) selected @endif >{{$rs->group_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group-separator"></div>

                    <div class="form-group" >
                        <label class="col-sm-2 control-label" for="field-1">이름</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="{{$adminData->name}}">
                        </div>
                    </div>
                    <div class="form-group-separator"></div>



                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="field-1">아이디</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="id" value="{{$adminData->id}}" readonly>
                        </div>
                    </div>
                    <div class="form-group-separator"></div>
                    <div class="form-group" >
                        <label class="col-sm-2 control-label" for="field-1">비밀번호 재설정</label>
                        <div class="col-sm-10">
                            <button class="btn btn-purple" type="button">비밀번호 재설정</button>
                        </div>
                    </div>
                    <div class="form-group-separator"></div>

                    <div class="form-group" >
                        <label class="col-sm-2 control-label" for="field-1">연락처</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phoneno" value="{{$adminData->phoneno}}">
                        </div>
                    </div>
                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="field-1">Email</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" value="{{$adminData->email}}">
                        </div>
                    </div>
                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="field-1">등록자</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="" value="{{$adminData->adminid}}">
                        </div>
                    </div>
                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="field-1">등록일</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="" value="{{$adminData->created_at}}">
                        </div>
                    </div>
                    <div class="form-group-separator"></div>

                </form>
                <div style="float:right;">
                    <button class="btn btn-purple" type="button" onClick="alert();">수정</button>
                    <button class="btn btn-red" type="button" onClick="alert();">삭제</button>
                    <button class="btn btn-blue" type="button" onClick="javascript:location.href = '/admin/list';">목록</button>
                </div>
            </div>

        </div>

        <footer class="main-footer sticky footer-type-1">

            <div class="footer-inner">

                <!-- Add your copyright text here -->
                <div class="footer-text">
                    &copy; 2022
                    <strong>Admin</strong>
                    xxxx theme by laborator
                </div>


                <!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
                <div class="go-up">

                    <a href="#" rel="go-top">
                        <i class="fa-angle-up"></i>
                    </a>

                </div>

            </div>

        </footer>
    </div>

</div>







<!-- Imported styles on this page -->
<link rel="stylesheet" href="/assets/js/datatables/dataTables.bootstrap.css">

<!-- Bottom Scripts -->
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/TweenMax.min.js"></script>
<script src="/assets/js/resizeable.js"></script>
<script src="/assets/js/joinable.js"></script>
<script src="/assets/js/xenon-api.js"></script>
<script src="/assets/js/xenon-toggles.js"></script>
<script src="/assets/js/datatables/js/jquery.dataTables.min.js"></script>


<!-- Imported scripts on this page -->
<script src="/assets/js/datatables/dataTables.bootstrap.js"></script>
<script src="/assets/js/datatables/yadcf/jquery.dataTables.yadcf.js"></script>
<script src="/assets/js/datatables/tabletools/dataTables.tableTools.min.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="/assets/js/xenon-custom.js"></script>

</body>
</html>
