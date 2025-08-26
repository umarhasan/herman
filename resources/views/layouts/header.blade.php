<header class="header">
    <nav class="navbar-light navbar-expand-lg">
        <div class="container d-block">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-lg-3 col-md-2 col-6 px-3">
                    <a href="/">
                        <img class="navlogo" src="{{ asset('assets/images/logo.webp') }}" alt="Logo">
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="col-lg-6 col-md-6 d-none d-md-block d-lg-block px-3">
                    <div class="navbar">
                        <div class="nav-up">
                            <ul class="nav-ul">
                                <li><a class="list {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a></li>
                                <li><a class="list" href="{{ asset('about') }}">About Us</a></li>
                                <li><a class="list" href="{{ asset('teachers') }}">Teachers</a></li>
                                <li><a class="list" href="{{ asset('products') }}">Products</a></li>
                                <li><a class="list" href="{{ asset('blogs') }}">Blog</a></li>
                                <li><a class="list" href="{{ asset('contact') }}">Contact Us</a></li>
                                @role('Teacher')
                                    <li>
                                        <a href="{{ route('teacher.chat.list') }}"
                                        class="list"
                                        style="display:flex; align-items:center; height:32px">
                                        Chat
                                        </a>
                                    </li>
                                @endrole
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Desktop Login / Auth Area -->
                <div class="col-lg-3 col-md-4 d-none d-md-block d-lg-block px-3">
                    <div class="loginbtns">
                        @auth
                            <!-- Dropdown for Logged-in User -->
                            <div class="dropdown">
                                <a class="dropdown-toggle login" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
                                        @if(Auth::user()->hasRole('Admin'))
                                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                        @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a class="login" href="{{ asset('login') }}">Login</a>
                            <a class="login" href="#">Subscribe Now</a>
                        @endauth
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="col-6 d-lg-none d-md-none d-block">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#navbarOffcanvas" aria-controls="navbarOffcanvas" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <!-- Offcanvas Menu -->
                    <div class="offcanvas offcanvas-end bg-secondary secondary-1" id="navbarOffcanvas" tabindex="-1">
                        <div class="offcanvas-header">
                            <a class="navbar-brand" href="/"><img src="{{ asset('assets/images/logo.webp') }}" alt="logo"
                                    class="logo"></a>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav">
                                <div class="nav-up">
                                    <ul class="nav-ul">
                                        <li><a class="list {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a></li>
                                        <li><a class="list" href="{{ asset('about') }}">About Us</a></li>
                                        <li><a class="list" href="{{ asset('products') }}">Products</a></li>
                                        <li><a class="list" href="{{ asset('blogs') }}">Blog</a></li>
                                        <li><a class="list" href="{{ asset('contact') }}">Contact Us</a></li>
                                    </ul>
                                </div>

                                <div class="loginbtns mt-3">
                                    @auth
                                        <div class="dropdown">
                                            <a class="dropdown-toggle login" href="#" role="button" data-bs-toggle="dropdown">
                                                {{ Auth::user()->name }}
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                                @if(Auth::user()->hasRole('Admin'))
                                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                                @endif
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @else
                                        <a class="login d-block mb-2" href="{{ asset('login') }}">Login</a>
                                        <a class="login d-block" href="#">Subscribe Now</a>
                                    @endauth
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>
</header>
