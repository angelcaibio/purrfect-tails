<!DOCTYPE html>
<html>
@include('includes.admin.header')
    <body class="gray-bg">
        <div class="middle-box text-center loginscreen animated fadeInDown">
            <div>
                <div>
                    <div class="logo-wrapper">
                        <img src="{{asset('images/icon.png')}}" alt="Purrfect Tails" class="logo-name">
                    </div>
                </div>
            @yield('content')
            </div>
        </div>
        @include('includes.admin.js')
    </body>
</html>