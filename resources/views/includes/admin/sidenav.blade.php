<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img
                        alt="image"
                        class="rounded-circle"
                        src="{{ asset('storage/profile_picture/' . ($profile_picture ?? 'default.jpg')) }}"
                        style="width: 48px; height: 48px; object-fit: cover;"
                    />
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ $username ?? 'Admin' }}</span>
                        <span class="text-muted text-xs block">Administrator</span>
                    </a>
                </div>

                <div class="logo-element">
                    <img
                        src="{{ asset('images/icon.svg') }}"
                        alt="Purrfect Tails"
                        style="width: 100%; height: auto;"
                    />
                </div>
            </li>

            <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}">
                    <i class="fa fa-th-large"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/blogs', 'admin/categories', 'admin/tags') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-pencil"></i>
                    <span class="nav-label">General</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ request()->is('admin/blogs') ? 'active' : '' }}">
                        <a href="{{ url('admin/blogs') }}">Blogs</a>
                    </li>
                    <li class="{{ request()->is('admin/categories') ? 'active' : '' }}">
                        <a href="{{ url('admin/categories') }}">Categories</a>
                    </li>
                    <li class="{{ request()->is('admin/tags') ? 'active' : '' }}">
                        <a href="{{ url('admin/tags') }}">Tags</a>
                    </li>
                </ul>
            </li>

            <li class="{{ request()->is('admin/users', 'admin/comments') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span class="nav-label">Subscribers</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ request()->is('admin/users') ? 'active' : '' }}">
                        <a href="{{ url('admin/users') }}">Users</a>
                    </li>
                    <li class="{{ request()->is('admin/comments') ? 'active' : '' }}">
                        <a href="{{ url('admin/comments') }}">Comments</a>
                    </li>
                </ul>
            </li>

            <li class="{{ request()->is('admin/media_library') ? 'active' : '' }}">
                <a href="{{ url('admin/media_library') }}">
                    <i class="fa fa-camera"></i>
                    <span class="nav-label">Media Library</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
