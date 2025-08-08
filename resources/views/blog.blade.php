@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="inner-pg-main">
    <section class="sec1">
        <div class="sec1-main">
            <h2 class="bann-head">Blogs</h2>
        </div>
    </section>
    <section class="sec6">
        <div class="container">
            <div class="sec6-inner">
                <h5 class="yellow-head">Trending</h5>
                <h3 class="black-head">Latest News & Blogs</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consectetur sed nisi nec condimentum.
                    Maecenas id aliquet elit, non malesuada purus. Duis interdum ornare tincidunt. Nulla non
                    sollicitudin risus.</p>
            </div>
            <div class="owl-carousel owl-theme blog-caro">
                <div class="item">
                    <div class="blog">
                        <div class="blog-content">
                            <h6>April 8, 2025</h6>
                            <h4>EDUCATIONAL FOR BEGINNERS BY THUBTEN CHODRON</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consectetur sed nisi nec
                                condimentum. Maecenas id aliquet elit, non malesuada purus. Duis interdum ornare
                                tincidunt.
                                Nulla non sollicitudin risus. Proin feugiat aliquet arcu volutpat condimentum.
                                Praesent
                                auctor, ante sed eleifend facilisis.</p>
                        </div>
                        <div class="blog-img">
                            <img src="assets/images/blog1.webp" alt="">
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="blog">
                        <div class="blog-content">
                            <h6>April 8, 2025</h6>
                            <h4>ESSENTIAL POINTS OF TANTRIC MEDITATION</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consectetur sed nisi nec
                                condimentum. Maecenas id aliquet elit, non malesuada purus. Duis interdum ornare
                                tincidunt.
                                Nulla non sollicitudin risus. Proin feugiat aliquet arcu volutpat condimentum.
                                Praesent
                                auctor, ante sed eleifend facilisis.</p>
                        </div>
                        <div class="blog-img">
                            <img src="assets/images/blog2.webp" alt="">
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="blog">
                        <div class="blog-content">
                            <h6>April 8, 2025</h6>
                            <h4>THE EDUCATIONAL TAUGHT BY WAPOLA RAHULA</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consectetur sed nisi nec
                                condimentum. Maecenas id aliquet elit, non malesuada purus. Duis interdum ornare
                                tincidunt.
                                Nulla non sollicitudin risus. Proin feugiat aliquet arcu volutpat condimentum.
                                Praesent
                                auctor, ante sed eleifend facilisis.</p>
                        </div>
                        <div class="blog-img">
                            <img src="assets/images/blog3.webp" alt="">
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="blog">
                        <div class="blog-content">
                            <h6>April 8, 2025</h6>
                            <h4>ESSENTIAL POINTS OF TANTRIC MEDITATION</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consectetur sed nisi nec
                                condimentum. Maecenas id aliquet elit, non malesuada purus. Duis interdum ornare
                                tincidunt.
                                Nulla non sollicitudin risus. Proin feugiat aliquet arcu volutpat condimentum.
                                Praesent
                                auctor, ante sed eleifend facilisis.</p>
                        </div>
                        <div class="blog-img">
                            <img src="assets/images/blog2.webp" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection