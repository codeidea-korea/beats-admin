<!DOCTYPE html>
<html lang="ko" class="light">
<!-- BEGIN: Head -->
<head>
    @include('include.pageHeaderINC')
</head>
<!-- END: Head -->
<body class="py-5">
{{-- --}}


@yield('content')

@include('include.pageFooterINC')
</body>
</html>
