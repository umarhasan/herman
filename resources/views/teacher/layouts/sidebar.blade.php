<div id="sidebar" class="sidebar">
    <div>
        <!-- <img src="./assets/images/logo.png" class="sidebar-logo" /> -->
        <div class="nameicon">
            <a href="#" class="logo">{{ Auth::user()->name }} </a> <button id="closebtn" class="closebtn d-block d-md-none d-lg-none"
                onclick="closemenu()"> <i class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="sidebar-links2">
            <a href="{{ route('teacher.dashboard') }}" class="{{ Route::is('teacher.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('teacher.bookings.index') }}" class="{{ Route::is('teacher.bookings.index') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Bookings
            </a>
		    <a href="{{ route('teacher.hebcalendar.index') }}"><i class="fas fa-calendar-alt"></i> Hebrew Calendar</a>
            <a href="{{ route('teacher.countdown') }}"><i class="fas fa-hourglass-half"></i> Countdown</a>
            <a href="{{ route('teacher.timetables.index') }}" class="{{ Route::is('teacher.timetables.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Timetable
            </a>
            <a href="{{ route('teacher.recordbooks') }}"><i class="fas fa-hourglass-half"></i> Record Books</a>
            <div class="sidebar-items">
                <h3 class="sidebar-h3">SYSTEM</h3>
                <div class="sidebar-links1">
                    <a href="#"><i class="fa-thin fa-circle-exclamation"></i> Help Center</a>
                    <a class="{{ Route::is('teacher.profile.edit') ? 'active' : '' }}" href="{{ route('teacher.profile.edit') }}">
                        <i class="fas fa-user-cog"></i> Profile
                    </a>

                    <a class="{{ Route::is('teacher.password.change') ? 'active' : '' }}" href="#">
                        <i class="fas fa-key"></i> Change Password
                    </a>
                    <a>
                        <form action="{{ route('logout') }}" method="post" class="logout-form">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i> Log Out
                            </button>
                        </form>
                    </a>
                    {{-- <a href="#"><i class="fa-light fa-left-from-bracket"></i> Logout</a> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- System Help --}}
    <div class="sidebar-items">

    </div>
</div>
