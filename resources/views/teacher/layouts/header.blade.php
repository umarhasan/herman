<div class="column2">
    <!-- Mobile Sidebar Toggle Button -->
    <button class="openbtn d-block d-md-none d-lg-none" id="openbtn" onclick="togglemenu()">
        <i class="fa-solid fa-bars"></i>
    </button>

    <div class="main-div">
        <div class="header d-flex justify-content-between align-items-center">
            <!-- Left side -->
            <div class="left">
                <h3 class="main1-a">Hello, {{ Auth::user()->name }}</h3>
                <h4 class="main1-b">Countdown</h4>
            </div>

            <!-- Right side: Invite, Notification, Profile -->
            <div class="right d-flex align-items-center gap-3">
                <a class="invitebtn" href="#">Invite</a>

                <a href="#">
                    <img src="{{ asset('Backend/assets/images/bell-icon.png') }}" alt="Notifications">
                </a>

				<a href="{{ route('teacher.chat.index') }}" class="text-decoration-none">
                    <i class="fa-solid fa-comments me-1"></i> Chat
                </a>

                <!-- Profile Dropdown without caret -->
                <div class="dropdown">
                    <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" class="prof">
                        <img src="{{ asset('Backend/assets/images/profile-pic.png') }}" alt="Profile" class="profile-img">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="px-3 py-2">
                            <strong>{{ Auth::user()->name }}</strong><br>
                            <small>{{ Auth::user()->email }}</small>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('teacher.profile.edit') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Change Password</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

