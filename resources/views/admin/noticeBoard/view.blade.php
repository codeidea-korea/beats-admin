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
                    <a href="/dashboard">
                        <i class="linecons-cog"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/member">
                        <i class="linecons-user"></i>
                        <span class="title">사용자관리</span>
                    </a>
                </li>
                <li class="active opened">
                    <a href="/admin/board/list">
                        <i class="linecons-database"></i>
                        <span class="title">서비스관리</span>
                    </a>
                    <ul>
                        <li class="active">
                            <a href="/admin/board/list">
                                <span class="title">공지사항</span>
                            </a>
                        </li>
                        <li>
                            <a href="/qa">
                                <span class="title">Q&A관리</span>
                            </a>
                        </li>
                        <li>
                            <a href="/faq">
                                <span class="title">FAQ관리</span>
                            </a>
                        </li>
                        <li>
                            <a href="/pds">
                                <span class="title">자료실관리</span>
                            </a>
                        </li>
                    </ul>
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
                <h3 class="panel-title">공지사항 상세</h3>
            </div>
            <div class="panel-body">

                <form method="post" id="boardupdateform" role="form" class="form-horizontal" action="/admin/board/update">
                    {{ csrf_field() }}
                    <input type="hidden" id="idx" name="idx" value="{{$boardData[0]->idx}}">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="field-1">제목</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="wr_title" name="wr_title" value="{{$boardData[0]->wr_title}}">
                        </div>
                    </div>

                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="field-1">내용</label>

                        <div class="col-sm-10">
                            <textarea class="form-control" id="wr_content" name="wr_content" style="width:100%;height:400px;resize:none;">{{$boardData[0]->wr_content}}</textarea>
                        </div>
                    </div>

                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">노출여부</label>
                        <div class="col-sm-10">
                            <select id="wr_open" name="wr_open">
                                <option value="open">노출</option>
                                <option value="secret">비 노출</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">관리자</label>
                        <div class="col-sm-10">
                            {{$boardData[0]->name}}
                        </div>
                    </div>
                    <div class="form-group-separator"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">등록일</label>
                        <div class="col-sm-10">
                            {{$boardData[0]->created_at}}
                        </div>
                    </div>
                    <div class="form-group-separator"></div>

                </form>
                <div style="float:right;">
                    <button class="btn btn-purple" type="button" onclick="$('#boardupdateform').submit();">수정</button>
                    <button class="btn btn-red" type="button" onclick="if(confirm('해당 공지사항을 삭제하시겠습니까?'))
                    $('#boardDeleteForm').submit();">삭제</button>
                    <button class="btn btn-blue" type="button">목록</button>
                </div>
            </div>

        </div>

        <form id="boardDeleteForm" method="post" action="/admin/board/delete">
            @csrf
            <input type="hidden" name="idx" id="idx" value="{{$boardData[0]->idx}}">
        </form>


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

<div class="footer-sticked-chat"><!-- Start: Footer Sticked Chat -->

    <script type="text/javascript">
        function toggleSampleChatWindow()
        {
            var $chat_win = jQuery("#sample-chat-window");

            $chat_win.toggleClass('open');

            if($chat_win.hasClass('open'))
            {
                var $messages = $chat_win.find('.ps-scrollbar');

                if($.isFunction($.fn.perfectScrollbar))
                {
                    $messages.perfectScrollbar('destroy');

                    setTimeout(function(){
                        $messages.perfectScrollbar();
                        $chat_win.find('.form-control').focus();
                    }, 300);
                }
            }

            jQuery("#sample-chat-window form").on('submit', function(ev)
            {
                ev.preventDefault();
            });
        }


    </script>




    <!-- End: Footer Sticked Chat -->
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
