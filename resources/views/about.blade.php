@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="inner-pg-main">
    <section class="sec1">
        <div class="sec1-main">
            <h2 class="bann-head">About Us</h2>
        </div>
    </section>
    <section class="sec2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="abt-img">
                        <img src="assets/images/abt-img.jpg" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="abt-cntnt">
                        <h3 class="black-head">About Us</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consectetur sed nisi nec
                            condimentum. Maecenas id aliquet elit, non malesuada purus. Duis interdum ornare
                            tincidunt.
                            Nulla non sollicitudin risus. Proin feugiat aliquet arcu volutpat condimentum. Praesent
                            auctor, ante sed eleifend facilisis.Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit. Ut consectetur sed nisi nec
                            condimentum. Maecenas id aliquet elit, non malesuada purus. Duis interdum ornare
                            tincidunt..</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consectetur sed nisi nec
                            condimentum. Maecenas id aliquet elit, non malesuada purus. Duis interdum ornare
                            tincidunt.
                            Nulla non sollicitudin risus. Proin feugiat aliquet arcu volutpat condimentum. </p>
                        <div class="abt-inner-main">
                            <div class="inner-col">
                                <img src="assets/images/inner-col1.webp" alt="">
                                <div class="inner-col-cntnt">
                                    <h6>Tefillin Educational</h5>
                                        <h5>Daishin Eshin</h5>
                                </div>
                            </div>
                            <div class="inner-col">
                                <img src="assets/images/inner-col2.webp" alt="">
                                <div class="inner-col-cntnt">
                                    <h6>Tefillin Educational</h5>
                                        <h5>Daishin Eshin</h5>
                                </div>
                            </div>
                            <div class="inner-col">
                                <img src="assets/images/inner-col3.webp" alt="">
                                <div class="inner-col-cntnt">
                                    <h6>Tefillin Educational</h5>
                                        <h5>Daishin Eshin</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection