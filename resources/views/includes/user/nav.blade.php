<!-- Mobile Menu -->
<div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close">
            <span class="icofont-close js-menu-toggle"></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>

<!-- Main Navbar -->
<nav class="site-nav">
    <div class="container">
        <div class="menu-bg-wrap">
            <div class="site-navigation">
                <div class="row g-0 align-items-center">
                    <!-- Logo -->
                    <div class="col-2">
                        <a href="{{ route('user.index') }}" class="logo m-0 float-start">
                            <img src="{{ asset('images/icon.svg') }}" alt="Purrfect Tails" class="img logo-img" style="width: 100px; height: 100%;">
                        </a>
                    </div>

                    <!-- Center Menu -->
                    <div class="col-8 text-center">
                        <!-- Search Form -->
                        <form action="{{ route('search') }}" method="GET" class="search-form d-block d-lg-none mb-3">
                            <input type="text" name="search_blog" class="form-control" placeholder="Search...">
                            <span class="bi-search"></span>
                        </form>

                        <!-- Desktop Menu -->
                        <div class="scrollable-menu" style="max-height: 300px; overflow-y: auto;">
                            <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mx-auto menu-large">
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ route('users.category', $category->id) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Burger Menu and Desktop Search -->
                    <div class="col-2 text-end">
                        <!-- Burger Menu (for mobile) -->
                        <a href="#" class="burger ms-auto float-end site-menu-toggle js-menu-toggle d-inline-block d-lg-none light">
                            <span></span>
                        </a>

                        <!-- Desktop Search -->
                        <form action="{{ route('search') }}" method="GET" class="search-form d-none d-lg-inline-block">
                            <input type="text" name="search_blog" class="form-control" placeholder="Search..." style="width: 250px;">
                            <span class="bi-search"></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
