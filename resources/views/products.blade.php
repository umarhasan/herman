@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="inner-pg-main">
    <section class="sec1">
        <div class="sec1-main">
            <h2 class="bann-head">Products</h2>
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
</div>
@endsection