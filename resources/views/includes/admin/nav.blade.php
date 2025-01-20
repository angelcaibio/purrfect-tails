<nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#">
            <i class="fa fa-bars"></i>
        </a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <li>
            <!-- Logout link that uses POST request with a simple href -->
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out"></i> Log out
            </a>
            <!-- Hidden form to handle POST request for logout -->
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
