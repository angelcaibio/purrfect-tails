<!DOCTYPE html>
<html>
@include('includes.admin.header')
<body class="fixed-navigation">
    <div id="wrapper">
        @include('includes.admin.sidenav')
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            @include('includes.admin.nav')
        </div>
            @yield('content')
            @include('includes.admin.footer')

        </div>
    @include('includes.admin.js')
</body>
</html>
