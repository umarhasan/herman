<div id="sidebar" class="sidebar">
    <div>
        <!-- <img src="./assets/images/logo.png" class="sidebar-logo" /> -->
        <div class="nameicon">
            <a href="#" class="logo">{{ Auth::user()->name }} </a> <button id="closebtn" class="closebtn d-block d-md-none d-lg-none"
                onclick="closemenu()"> <i class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="sidebar-links2">
            <a href="{{ route('student.dashboard') }}" class="{{ Route::is('student.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
			<a href="#"><i class="fas fa-address-book"></i> Book</a>
            <a href="#"><i class="fas fa-calendar-alt"></i> Mezuza</a>
            <a href="#"><i class="fas fa-calendar-alt"></i> Subscription</a>
            <a href="#"><i class="fas fa-calendar-alt"></i> Tefilin Inspection</a>
            <a href="#"><i class="fas fa-upload"></i> Book Upload</a>
            <a href="#"><i class="fas fa-vials"></i> Test</a>
            <a href="{{ route('student.hebcalendar.index') }}"><i class="fas fa-calendar-alt"></i> Hebrew Calendar</a>
            <a href="#"><i class="fas fa-bullhorn"></i> Advertisement</a>
            <a href="{{ route('student.countdown') }}"><i class="fas fa-hourglass-half"></i> Countdown</a>
        </div>
    </div>

    <div class="sidebar-items">
        <h3 class="sidebar-h3">SYSTEM</h3>
        <div class="sidebar-links1">
            <a href="#"><i class="fa-thin fa-circle-exclamation"></i> Help Center</a>
            <a href="#"><i class="fa-regular fa-gear-complex"></i> Settings</a>
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
