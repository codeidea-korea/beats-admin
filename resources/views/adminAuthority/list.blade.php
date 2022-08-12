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
                <li class="active opened active">
                    <a href="/member">
                        <i class="linecons-user"></i>
                        <span class="title">사용자관리</span>
                    </a>
                </li>
                <li>
                    <a href="/notice">
                        <i class="linecons-database"></i>
                        <span class="title">시스템자원관리</span>
                    </a>
                    <ul>
                        <li class="active">
                            <a href="/notice">
                                <span class="title">공지사항관리</span>
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
                <h3 class="panel-title">사용자관리</h3>

                <div class="panel-options">
                    <a href="#" data-toggle="panel">
                        <span class="collapse-icon">&ndash;</span>
                        <span class="expand-icon">+</span>
                    </a>
                    <a href="#" data-toggle="remove">
                        &times;
                    </a>
                </div>
            </div>
            <div class="panel-body">

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
                    @foreach($adminData as $rs)
                    <tr>
                        <td style="width:8%">1</td>
                        <td style="width:10%">{{$rs->group_name}}</td>
                        <td style="width:10%">{{$rs->name}}</td>
                        <td style="width:20%">@if($rs->phoneno==null) 000-0000-0000 @else {{$rs->phoneno}} @endif</td>
                        <td>{{$rs->email}}</td>
                        <td style="width:10%">{{$rs->isuse}}</td>
                        <td style="width:20%">{{$rs->created_at}}</td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>

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


    <div id="chat" class="fixed"><!-- start: Chat Section -->

        <div class="chat-inner">


            <h2 class="chat-header">
                <a  href="#" class="chat-close" data-toggle="chat">
                    <i class="fa-plus-circle rotate-45deg"></i>
                </a>

                Chat
                <span class="badge badge-success is-hidden">0</span>
            </h2>

            <script type="text/javascript">
                // Here is just a sample how to open chat conversation box
                jQuery(document).ready(function($)
                {
                    var $chat_conversation = $(".chat-conversation");

                    $(".chat-group a").on('click', function(ev)
                    {
                        ev.preventDefault();

                        $chat_conversation.toggleClass('is-open');

                        $(".chat-conversation textarea").trigger('autosize.resize').focus();
                    });

                    $(".conversation-close").on('click', function(ev)
                    {
                        ev.preventDefault();
                        $chat_conversation.removeClass('is-open');
                    });
                });
            </script>


            <div class="chat-group">
                <strong>Favorites</strong>

                <a href="#"><span class="user-status is-online"></span> <em>Catherine J. Watkins</em></a>
                <a href="#"><span class="user-status is-online"></span> <em>Nicholas R. Walker</em></a>
                <a href="#"><span class="user-status is-busy"></span> <em>Susan J. Best</em></a>
                <a href="#"><span class="user-status is-idle"></span> <em>Fernando G. Olson</em></a>
                <a href="#"><span class="user-status is-offline"></span> <em>Brandon S. Young</em></a>
            </div>


            <div class="chat-group">
                <strong>Work</strong>

                <a href="#"><span class="user-status is-busy"></span> <em>Rodrigo E. Lozano</em></a>
                <a href="#"><span class="user-status is-offline"></span> <em>Robert J. Garcia</em></a>
                <a href="#"><span class="user-status is-offline"></span> <em>Daniel A. Pena</em></a>
            </div>


            <div class="chat-group">
                <strong>Other</strong>

                <a href="#"><span class="user-status is-online"></span> <em>Dennis E. Johnson</em></a>
                <a href="#"><span class="user-status is-online"></span> <em>Stuart A. Shire</em></a>
                <a href="#"><span class="user-status is-online"></span> <em>Janet I. Matas</em></a>
                <a href="#"><span class="user-status is-online"></span> <em>Mindy A. Smith</em></a>
                <a href="#"><span class="user-status is-busy"></span> <em>Herman S. Foltz</em></a>
                <a href="#"><span class="user-status is-busy"></span> <em>Gregory E. Robie</em></a>
                <a href="#"><span class="user-status is-busy"></span> <em>Nellie T. Foreman</em></a>
                <a href="#"><span class="user-status is-busy"></span> <em>William R. Miller</em></a>
                <a href="#"><span class="user-status is-idle"></span> <em>Vivian J. Hall</em></a>
                <a href="#"><span class="user-status is-offline"></span> <em>Melinda A. Anderson</em></a>
                <a href="#"><span class="user-status is-offline"></span> <em>Gary M. Mooneyham</em></a>
                <a href="#"><span class="user-status is-offline"></span> <em>Robert C. Medina</em></a>
                <a href="#"><span class="user-status is-offline"></span> <em>Dylan C. Bernal</em></a>
                <a href="#"><span class="user-status is-offline"></span> <em>Marc P. Sanborn</em></a>
                <a href="#"><span class="user-status is-offline"></span> <em>Kenneth M. Rochester</em></a>
                <a href="#"><span class="user-status is-offline"></span> <em>Rachael D. Carpenter</em></a>
            </div>

        </div>

        <!-- conversation template -->
        <div class="chat-conversation">

            <div class="conversation-header">
                <a href="#" class="conversation-close">
                    &times;
                </a>

                <span class="user-status is-online"></span>
                <span class="display-name">Arlind Nushi</span>
                <small>Online</small>
            </div>

            <ul class="conversation-body">
                <li>
                    <span class="user">Arlind Nushi</span>
                    <span class="time">09:00</span>
                    <p>Are you here?</p>
                </li>
                <li class="odd">
                    <span class="user">Brandon S. Young</span>
                    <span class="time">09:25</span>
                    <p>This message is pre-queued.</p>
                </li>
                <li>
                    <span class="user">Brandon S. Young</span>
                    <span class="time">09:26</span>
                    <p>Whohoo!</p>
                </li>
                <li class="odd">
                    <span class="user">Arlind Nushi</span>
                    <span class="time">09:27</span>
                    <p>Do you like it?</p>
                </li>
            </ul>

            <div class="chat-textarea">
                <textarea class="form-control autogrow" placeholder="Type your message"></textarea>
            </div>

        </div>

        <!-- end: Chat Section -->
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
<link rel="stylesheet" href="assets/js/datatables/dataTables.bootstrap.css">

<!-- Bottom Scripts -->
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/TweenMax.min.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/joinable.js"></script>
<script src="assets/js/xenon-api.js"></script>
<script src="assets/js/xenon-toggles.js"></script>
<script src="assets/js/datatables/js/jquery.dataTables.min.js"></script>


<!-- Imported scripts on this page -->
<script src="assets/js/datatables/dataTables.bootstrap.js"></script>
<script src="assets/js/datatables/yadcf/jquery.dataTables.yadcf.js"></script>
<script src="assets/js/datatables/tabletools/dataTables.tableTools.min.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="assets/js/xenon-custom.js"></script>

</body>
</html>
