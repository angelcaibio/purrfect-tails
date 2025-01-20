<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Dropdown for User -->
        <div class="dropdown">
            <a href="#" 
               class="navbar-brand dropdown-toggle d-flex align-items-center text-primary" 
               id="logoDropdown" data-bs-toggle="dropdown" aria-expanded="false" 
               style="font-size: 0.9rem;">
                <span>Welcome, {{ Auth::check() ? Auth::user()->username : 'Guest' }}!</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="logoDropdown" style="font-size: 0.9rem;">
                @if(Auth::check())
                    <li>
                        <a class="dropdown-item text-primary" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           Log Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @else
                    <li><a class="dropdown-item text-primary" href="{{ route('user.login') }}">Login</a></li>
                    <li><a class="dropdown-item text-primary" href="{{ route('register') }}">Register</a></li>
                @endif
            </ul>
        </div>

        <!-- Current Date and Time -->
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <span class="nav-link text-primary">
                    {{ now()->timezone('Asia/Manila')->format('l, F j, Y - h:i A') }}
                </span>
            </li>
        </ul>
    </div>
</nav>
