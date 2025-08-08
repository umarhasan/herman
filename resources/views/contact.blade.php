@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="inner-pg-main">
    <section class="sec1">
        <div class="sec1-main">
            <h2 class="bann-head">Contact Us</h2>
        </div>
    </section>
    <section class="sec2">
        <div class="container">
            <div class="contactform">
                <h6 class="yellow-head">Feel Free To Ask</h6>
                <h2 class="black-head">Get In Touch</h2>
                <form class="form">
                    <div class="g-box">
                        <input type="text" required class="field" name="fname" placeholder="First Name">
                        <input type="text" required class="field" name="lname" placeholder="Last Name">
                        <input type="email" required class="field" name="email" placeholder="Email Address">
                        <input type="tel" required class="field" name="phone" placeholder="Phone Number">
                    </div>
                    <div class="f-box">
                        <textarea class="msgfield" name="msg" placeholder="Message"></textarea>
                        <input type="submit" value="Send" class="sndbtn">
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection