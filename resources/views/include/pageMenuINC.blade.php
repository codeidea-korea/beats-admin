<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="Midone - HTML Admin Template" class="w-6" src="/dist/images/logo.svg">
        </a>
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <div class="scrollable">
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        <ul class="scrollable__content py-2">
            @php
                $tempDepth = 1;


            @endphp
            @foreach(session('ADMINMENULIST') as $rs)
                @if($tempDepth==2 && $rs->depth == 1)
                    </ul>
                    </li>
                    @php
                        $tempDepth = 1;
                    @endphp
                @endif

                @if($rs->depth == 1 && $rs->lcnt==0)
                    <li>
                        <a href="javascript:location.href='{{ url($rs->url) }}';" class="menu @if(substr($rs->menucode,0,5) == substr($params['menuCode'],0,5)) menu--active @php $navi @endphp @endif">
                            <div class="menu__icon"> <i data-lucide="{{$rs->description}}"></i> </div>
                            <div class="menu__title">
                                {{$rs->menuname}}
                            </div>
                        </a>
                    </li>
                @elseif($rs->depth == 1&&$rs->lcnt > 0)
                    <li>
                        <!--<a href="javascript:;" class="side-menu side-menu--active">-->
                        <a href="javascript:;" class="menu @if(substr($rs->menucode,0,5) == substr($params['menuCode'],0,5)) menu--active @endif">
                            <div class="menu__icon"> <i data-lucide="{{$rs->description}}"></i> </div>
                            <div class="menu__title">
                                {{$rs->menuname}}
                                <div class="menu__sub-icon @if(substr($rs->menucode,0,5) == substr($params['menuCode'],0,5)) transform rotate-180 @endif"> <i data-lucide="chevron-down"></i> </div>
                                <!--<div class="side-menu__sub-icon transform rotate-180"> <i data-lucide="chevron-down"></i> </div>-->
                            </div>
                        </a>
                        <ul class="menu__sub-open" @if(substr($rs->menucode,0,5) != substr($params['menuCode'],0,5)) style="display:none" @endif >
                    @php
                        $tempDepth=2;
                    @endphp
                @elseif($rs->depth == 2)
                    <li>
                        <!--<a href="javascript:;" class="side-menu side-menu--active">-->
                        <a href="javascript:location.href='{{ url($rs->url) }}';" class="side-menu @if($rs->menucode == $params['menuCode']) menu--active @endif">
                            <div class="menu__icon"> <i data-lucide="activity"></i> </div>
                            <div class="menu__title">  {{$rs->menuname}}</div>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
<!-- END: Mobile Menu -->
<div class="flex mt-[4.7rem] md:mt-0">
    <!-- BEGIN: Side Menu -->
    <nav class="side-nav">
        <a href="" class="intro-x flex items-center pl-5 pt-4">
            <img alt="Midone - HTML Admin Template" class="w-6" src="/dist/images/logo.svg">
            <span class="hidden xl:block text-white text-lg ml-3"> 통합관리자 </span>
        </a>

            <div class="side-nav__devider my-6"></div>
            <ul>
                @php
                $tempDepth = 1;
                @endphp
                @foreach(session('ADMINMENULIST') as $rs)
                    @if($tempDepth==2 && $rs->depth == 1)
                            </ul>
                        </li>
                        @php
                            $tempDepth = 1;
                        @endphp
                    @endif

                    @if($rs->depth == 1 && $rs->lcnt==0)
                        <li>
                            <a href="javascript:location.href='{{ url($rs->url) }}';" class="side-menu @if(substr($rs->menucode,0,5) == substr($params['menuCode'],0,5)) side-menu--active @endif">
                                <div class="side-menu__icon"> <i data-lucide="{{$rs->description}}"></i> </div>
                                <div class="side-menu__title">
                                    {{$rs->menuname}}
                                </div>
                            </a>
                        </li>
                    @elseif($rs->depth == 1&&$rs->lcnt > 0)

                        <li>
                            <!--<a href="javascript:;" class="side-menu side-menu--active">-->
                            <a href="javascript:;" class="side-menu @if(substr($rs->menucode,0,5) == substr($params['menuCode'],0,5)) side-menu--active @endif">
                                <div class="side-menu__icon"> <i data-lucide="{{$rs->description}}"></i> </div>
                                <div class="side-menu__title">
                                    {{$rs->menuname}}
                                    <div class="side-menu__sub-icon @if(substr($rs->menucode,0,5) == substr($params['menuCode'],0,5)) transform rotate-180 @endif"> <i data-lucide="chevron-down"></i> </div>
                                    <!--<div class="side-menu__sub-icon transform rotate-180"> <i data-lucide="chevron-down"></i> </div>-->
                                </div>
                            </a>
                            <ul class="side-menu__sub-open" @if(substr($rs->menucode,0,5) != substr($params['menuCode'],0,5)) style="display:none" @endif >
                        @php
                            $tempDepth=2;
                        @endphp
                    @elseif($rs->depth == 2)

                        <li>
                            <!--<a href="javascript:;" class="side-menu side-menu--active">-->
                            <a href="javascript:location.href='{{ url($rs->url) }}';" class="side-menu @if($rs->menucode == $params['menuCode']) side-menu--active @endif">
                                <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                <div class="side-menu__title">  {{$rs->menuname}}</div>
                            </a>
                        </li>

                    @endif
                @endforeach
                            </ul>
                        </li>
            </ul>
    </nav>
