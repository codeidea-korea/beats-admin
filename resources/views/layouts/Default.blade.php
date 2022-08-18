<!doctype html>
<html lang="ko" class="light">
<head>

    @include('include.pageHeaderINC')
    @yield('pageHeader')
</head>
<body class="py-5">
@yield('body')
@include('include.PageFooterINC')
@yield('pageFooter')
</body>
</html>
