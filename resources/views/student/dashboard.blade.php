@extends('student.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="center-main">

    <div class="search-box">
        <div class="input-group">
            <div class="input-group-prepend">
                <button id="button-addon2" type="submit" class="btn btn-link text-warning">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <input type="search" placeholder="Search..." aria-describedby="button-addon2"
                class="form-control border-0 bg-light">
        </div>
    </div>

    <div class="countdown1">
        <h3 class="counta">Countdown to 13th Birthday</h3>
        <p class="countb">This countdown shows the time left until you turn 13 years old.</p>
        <a href="{{ route('student.hebcalendar.pdf') }}" class="btn btn-primary">
            📄 Download 13th Year Calendar PDF
        </a>
        <div id="countdown">
            <ul>
                <li class="count"><span id="days">--</span> DAYS</li>
                <li class="count"><span id="hours">--</span> HRS</li>
                <li class="count"><span id="minutes">--</span> MIN</li>
                <li class="count"><span id="seconds">--</span> SEC</li>
            </ul>
        </div>

        <div id="message" class="text-success font-weight-bold mt-3"></div>


    </div>
</div>

<script>
    (function () {
        const second = 1000,
              minute = second * 60,
              hour = minute * 60,
              day = hour * 24;

        const dobString = "{{ $dob }}"; // e.g. "2012-07-24"
        if (!dobString) {
            document.getElementById("countdown").innerHTML = "<h4 class='text-danger'>Date of birth not set.</h4>";
            return;
        }

        const dob = new Date(dobString);
        const thirteenthBirthday = new Date(dob.getFullYear() + 13, dob.getMonth(), dob.getDate());

        const countDownTime = thirteenthBirthday.getTime();

        const x = setInterval(function () {
            const now = new Date().getTime();
            const distance = countDownTime - now;

            if (distance <= 0) {
                clearInterval(x);
                document.getElementById("countdown").style.display = "none";
                document.getElementById("message").innerHTML = "🎉 You are now 13 years old!";
                return;
            }

            document.getElementById("days").innerText = Math.floor(distance / day);
            document.getElementById("hours").innerText = Math.floor((distance % day) / hour);
            document.getElementById("minutes").innerText = Math.floor((distance % hour) / minute);
            document.getElementById("seconds").innerText = Math.floor((distance % minute) / second);
        }, 1000);
    })();
</script>
@endsection
