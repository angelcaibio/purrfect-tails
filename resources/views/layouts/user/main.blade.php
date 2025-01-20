<!doctype html>
<html lang="en">
@include('includes.user.header')
    <body>
        @include('includes.user.auth')
        @include('includes.user.nav')
        <div>
            @yield('content')
            @include('includes.user.footer')
        </div>
        @include('includes.user.js')
    </body>
</html>