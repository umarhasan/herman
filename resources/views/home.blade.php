@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="sec1">
        <div class="owl-carousel owl-theme main-caro">
            <div class="item">
                <img class="banner" src="assets/images/bg1.webp" alt="">

            </div>
            <div class="item">
                <img class="banner" src="assets/images/bg2.webp" alt="">
            </div>
            <div class="item bann3">
                <div class="container">
                    <div class="slide3">
                        <h3>For Head</h3>
                        <div class="slide3-inner">
                            <div class="fh">
                                <img class="paper" id="paper" src="assets/images/paper1.webp" alt="">
                                <img class="onhvr" id="onhvr" src="assets/images/text1.webp" alt="">
                            </div>
                            <div class="fh">
                                <img class="paper" id="paper" src="assets/images/paper2.webp" alt="">
                                <img class="onhvr" id="onhvr" src="assets/images/text2.webp" alt="">
                            </div>
                            <div class="fh">
                                <img class="paper" id="paper" src="assets/images/paper3.webp" alt="">
                                <img class="onhvr" id="onhvr" src="assets/images/text3.webp" alt="">
                            </div>
                        </div>
                        <div class="slide3-inner2">
                            <div class="fh">
                                <img class="paper" id="paper" src="assets/images/paper4.webp" alt="">
                                <img class="onhvr" id="onhvr" src="assets/images/text4.webp" alt="">
                            </div>
                        </div>
                        <div class="slide3-inner3">
                            <h3>For Base</h3>
                            <div class="fh">
                                <img class="paper" id="paper" src="assets/images/paper5.png" alt="">
                                <img class="onhvr" id="onhvr" src="assets/images/text5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                            condimentum. Maecenas id aliquet elit, non malesuada purus. Duis interdum ornare tincidunt.
                            Nulla non sollicitudin risus. Proin feugiat aliquet arcu volutpat condimentum. Praesent
                            auctor, ante sed eleifend facilisis.</p>
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
    <section class="sec3">
        <div class="container">
            <div class="sec3-inner">
                <h5 class="yellow-head">Our Products</h5>
                <h3 class="black-head">Our Products</h3>
            </div>
            <div class="row align-items-center">
                <div class="col-md-3 col-6">
                    <div class="product">
                        <img src="assets/images/product1.webp" alt="">
                        <div class="product-content">
                            <h3 class="black-head">Lorem Ipsum</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consectetur sed nisi nec
                                condimentum.</p>
                            <a href="#" class="y-btn">Donate Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="product">
                        <img src="assets/images/product2.webp" alt="">
                        <div class="product-content">
                            <h3 class="black-head">Lorem Ipsum</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consectetur sed nisi nec
                                condimentum.</p>
                            <a href="#" class="y-btn">Donate Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="product">
                        <img src="assets/images/product3.webp" alt="">
                        <div class="product-content">
                            <h3 class="black-head">Lorem Ipsum</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consectetur sed nisi nec
                                condimentum.</p>
                            <a href="#" class="y-btn">Donate Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="product">
                        <img src="assets/images/product4.webp" alt="">
                        <div class="product-content">
                            <h3 class="black-head">Lorem Ipsum</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consectetur sed nisi nec
                                condimentum.</p>
                            <a href="#" class="y-btn">Donate Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="sec4">
        <div class="container">
            <div class="sec4-inner">
                <h5 class="yellow-head">Category</h5>
                <h3 class="black-head">What Is Tefillin</h3>
            </div>
            <div class="row align-items-center">
                <div class="col-md-3">
                    <div class="category">
                        <a href="assets/images/sec4-i1.webp" data-fslightbox="all">
                            <img src="assets/images/sec4-i1.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="category1">
                        <a href="assets/images/sec4-i2.webp" data-fslightbox="all">
                            <img src="assets/images/sec4-i2.webp" alt="">
                        </a>
                        <a href="assets/images/sec4-i3.webp" data-fslightbox="all">
                            <img src="assets/images/sec4-i3.webp" alt="">
                        </a>
                    </div>
                    <div class="category">
                        <a href="assets/images/sec4-i5.webp" data-fslightbox="all">
                            <img src="assets/images/sec4-i5.webp" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category">
                        <a href="assets/images/sec4-i4.webp" data-fslightbox="all">
                            <img class="i4" src="assets/images/sec4-i4.webp" alt="">
                        </a>
                        <a href="assets/images/sec4-i6.webp" data-fslightbox="all">
                            <img src="assets/images/sec4-i6.webp" alt="">
                        </a>
                    </div>
                </div>
            </div>
    </section>
    <section class="sec5">
        <div class="container">
            <div class="sec5-inner">
                <h5 class="yellow-head">Tefillin</h5>
                <h3 class="black-head">Testimonials</h3>
            </div>
            <div class="owl-carousel owl-theme testimonial">
                <div class="item">
                    <div class="card">
                        <img src="./assets/images/pers1.webp" alt="">
                        <p> Integer sed felis id sapien ultricies accumsan. Fusce gravida nibh lectus, a vehicula mauris
                            lobortis quis. </p>
                        <h5>Ekaijinko Feng</h5>
                        <h5 class="man">22 Oct 2025</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <img src="./assets/images/pers2.webp" alt="">
                        <p> Integer sed felis id sapien ultricies accumsan. Fusce gravida nibh lectus, a vehicula mauris
                            lobortis quis. </p>
                        <h5>Ekaijinko Feng</h5>
                        <h5 class="man">22 Oct 2025</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <img src="./assets/images/pers3.webp" alt="">
                        <p> Integer sed felis id sapien ultricies accumsan. Fusce gravida nibh lectus, a vehicula mauris
                            lobortis quis. </p>
                        <h5>Ekaijinko Feng</h5>
                        <h5 class="man">22 Oct 2025</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <img src="./assets/images/pers4.webp" alt="">
                        <p> Integer sed felis id sapien ultricies accumsan. Fusce gravida nibh lectus, a vehicula mauris
                            lobortis quis. </p>
                        <h5>Ekaijinko Feng</h5>
                        <h5 class="man">22 Oct 2025</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <img src="./assets/images/pers3.webp" alt="">
                        <p> Integer sed felis id sapien ultricies accumsan. Fusce gravida nibh lectus, a vehicula mauris
                            lobortis quis. </p>
                        <h5>Ekaijinko Feng</h5>
                        <h5 class="man">22 Oct 2025</h5>
                    </div>
                </div>
            </div>
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
                                Nulla non sollicitudin risus. Proin feugiat aliquet arcu volutpat condimentum. Praesent
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
                                Nulla non sollicitudin risus. Proin feugiat aliquet arcu volutpat condimentum. Praesent
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
                                Nulla non sollicitudin risus. Proin feugiat aliquet arcu volutpat condimentum. Praesent
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
                                Nulla non sollicitudin risus. Proin feugiat aliquet arcu volutpat condimentum. Praesent
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
    <section class="sec7">
        <div class="container">
            <div class="newsletter">
                <div class="sec7-inner">
                    <h5 class="yellow-head">Trending</h5>
                    <h3 class="black-head">Latest News & Blogs</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut consectetur sed nisi nec condimentum.
                        Maecenas id aliquet elit, non malesuada purus. Duis interdum ornare tincidunt. Nulla non
                        sollicitudin risus.</p>
                    <form>
                        <input type="email" class="em-field" name="em" required placeholder="Enter Email">
                        <input class="sub-btn" type="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection