<div id="sidebar" class="sidebar">
    <div>
        <!-- <img src="./assets/images/logo.png" class="sidebar-logo" /> -->
        <div class="nameicon">
            <a href="#" class="logo">{{ Auth::user()->name }} </a> <button id="closebtn" class="closebtn d-block d-md-none d-lg-none"
                onclick="closemenu()"> <i class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="sidebar-links2">
            <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="{{ Route::is('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Bookings
            </a>
            <a href="{{ route('admin.categories.index') }}" class="{{ Route::is('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> categories
            </a>
            <a href="{{ route('admin.users.index') }}" class="{{ Route::is('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Users
            </a>

            <a href="{{ route('admin.classes.index') }}" class="{{ Route::is('admin.classes.*') ? 'active' : '' }}">
                <i class="fas fa-chalkboard"></i> Classes
            </a>

            <a href="{{ route('admin.subjects.index') }}" class="{{ Route::is('admin.subjects.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i> Subjects
            </a>

            <a href="{{ route('admin.timetables.index') }}" class="{{ Route::is('admin.timetables.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Timetable
            </a>

            <a href="{{ route('admin.attendances.index') }}" class="{{ Route::is('admin.attendances.*') ? 'active' : '' }}">
                <i class="fas fa-user-check"></i> Attendance
            </a>

            <a href="{{ route('admin.tests.index') }}" class="{{ Route::is('admin.tests.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Test/Exams
            </a>

            <a href="{{ route('admin.resources.index') }}" class="{{ Route::is('admin.resources.*') ? 'active' : '' }}">
                <i class="fas fa-folder-open"></i> Resources
            </a>
            <a href="{{ route('admin.events.index') }}" class="{{ Route::is('admin.events.*') ? 'active' : '' }}">
                <i class="fas fa-folder-open"></i> Events
            </a>
            <a href="{{ route('admin.roles.index') }}" class="{{ Route::is('admin.roles.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Roles
            </a>
            <a href="{{ route('admin.permissions.index') }}" class="{{ Route::is('admin.permissions.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Permissions
            </a>
            <a href="#"><i class="fas fa-calendar-alt"></i> Mezuza</a>
            <a href="#"><i class="fas fa-calendar-alt"></i> Subscription</a>
            <a href="#"><i class="fas fa-calendar-alt"></i> Tefilin Inspection</a>
            <a href="{{ route('admin.files.index') }}"><i class="fas fa-upload"></i> Book Upload</a>
            <a href="{{ route('admin.hebcalendar.index') }}"><i class="fas fa-calendar-alt"></i> Hebrew Calendar</a>
            <a href="{{ route('admin.countdown') }}"><i class="fas fa-hourglass-half"></i> Countdown</a>
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
