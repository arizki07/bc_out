@extends('layouts.app')
@section('content')
    <style>
        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
    <div style="background-color: #3b5d50; padding: 50px 0;">
        <div class="container">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-lg-7 d-flex flex-column align-items-center">
                    <div class="hero-img-wrap mb-4"
                        style="position: relative; width: 280px; height: 280px; border-radius: 50%; 
                            background: linear-gradient(135deg, #fe0606, #071de5, #f6f7f6); 
                            background-size: 300% 300%; 
                            animation: gradientMove 5s ease infinite; 
                            display: flex; justify-content: center; align-items: center;">
                        <img src="{{ asset('assets/images/bg.jpg') }}" class="img-fluid"
                            style="border-radius: 50%; object-fit: cover; width: 240px; height: 240px;">
                    </div>
                    <div class="intro-excerpt text-white">
                        <h1>SEMESTAA OUTDOOR</h1>
                        <p class="mb-4">SEMESTAA OUTDOOR menyediakan berbagai peralatan camping yang dapat disewa dengan
                            harga terjangkau. Dari tenda, matras, hingga peralatan memasak outdoor, kami siap mendukung
                            petualangan Anda dengan perlengkapan berkualitas dan nyaman digunakan.</p>
                        <p><a href="" class="btn btn-secondary me-2">Shop Now</a><a href="#"
                                class="btn btn-white-outline">Explore</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <!-- Start Product Section -->
    <style>
        .product-item {
            transition: transform 0.1s;
        }

        .product-item:hover {
            transform: scale(1.05);
            /* Efek zoom saat hover */
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 50px;
            /* Ubah sesuai kebutuhan */
            height: 50px;
            /* Ubah sesuai kebutuhan */
            background-color: rgba(0, 0, 0, 0.5);
            /* Warna latar belakang */
            border-radius: 50%;
            /* Membuat bulatan */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
            /* Pastikan tombol berada di atas konten */
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: white;
            /* Warna ikon */
            border-radius: 50%;
            /* Membuat bulatan pada ikon */
            width: 20px;
            /* Ubah sesuai kebutuhan */
            height: 20px;
            /* Ubah sesuai kebutuhan */
        }

        /* Mengatur tombol agar lebih responsif */
        @media (max-width: 576px) {

            .carousel-control-prev,
            .carousel-control-next {
                width: 40px;
                /* Ubah ukuran untuk perangkat mobile */
                height: 40px;
            }
        }
    </style>
    <div class="product-section">
        <div class="container">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" style="overflow: hidden;">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            @foreach ($barang as $index => $item)
                                @if ($index < 4)
                                    <!-- Hanya tampilkan 4 item per slide -->
                                    <div class="col-12 col-md-3 mb-4">
                                        <a class="product-item" href="cart.html">
                                            <img src="{{ asset('assets/images/product-1.png') }}"
                                                class="img-fluid product-thumbnail">
                                            <h3 class="product-title">{{ $item->nama_barang }}</h3>
                                            <strong class="product-price">Rp.{{ $item->harga }}</strong>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @for ($i = 4; $i < count($barang); $i += 4)
                        <div class="carousel-item">
                            <div class="row">
                                @for ($j = $i; $j < $i + 4 && $j < count($barang); $j++)
                                    <div class="col-12 col-md-3 mb-4">
                                        <a class="product-item" href="cart.html">
                                            <img src="{{ asset('assets/images/product-1.png') }}"
                                                class="img-fluid product-thumbnail">
                                            <h3 class="product-title">{{ $barang[$j]->nama_barang }}</h3>
                                            <strong class="product-price">Rp.{{ $barang[$j]->harga }}</strong>
                                        </a>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @endfor
                </div>
                <!-- Bulatan untuk tombol navigasi -->
                <button class="carousel-control-prev rounded-circle" type="button" data-bs-target="#productCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next rounded-circle" type="button" data-bs-target="#productCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- End Product Section -->

    <!-- Start Why Choose Us Section -->
    <div class="why-choose-section">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <h2 class="section-title">Why Choose Us</h2>
                    <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit
                        imperdiet dolor tempor tristique.</p>

                    <div class="row my-5">
                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/truck.svg') }}" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Fast &amp; Free Shipping</h3>
                                <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
                                    vulputate.</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/bag.svg') }}" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Easy to Shop</h3>
                                <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
                                    vulputate.</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/support.svg') }}" alt="Image" class="imf-fluid">
                                </div>
                                <h3>24/7 Support</h3>
                                <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
                                    vulputate.</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/return.svg') }}" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Hassle Free Returns</h3>
                                <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
                                    vulputate.</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="img-wrap">
                        <img src="{{ asset('assets/images/why-choose-us-img.jpg') }}" alt="Image" class="img-fluid">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Why Choose Us Section -->

    <!-- Start Testimonial Slider -->
    <div class="testimonial-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto text-center">
                    <h2 class="section-title">Testimonials</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="testimonial-slider-wrap text-center">

                        <div id="testimonial-nav">
                            <span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
                            <span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
                        </div>

                        <div class="testimonial-slider">

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae
                                                    odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
                                                    vulputate velit imperdiet dolor tempor tristique. Pellentesque
                                                    habitant morbi tristique senectus et netus et malesuada fames ac
                                                    turpis egestas. Integer convallis volutpat dui quis
                                                    scelerisque.&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="{{ asset('assets/images/person-1.png') }}"
                                                        alt="Maria Jones" class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Maria Jones</h3>
                                                <span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae
                                                    odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
                                                    vulputate velit imperdiet dolor tempor tristique. Pellentesque
                                                    habitant morbi tristique senectus et netus et malesuada fames ac
                                                    turpis egestas. Integer convallis volutpat dui quis
                                                    scelerisque.&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="{{ asset('assets/images/person-1.png') }}"
                                                        alt="Maria Jones" class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Maria Jones</h3>
                                                <span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae
                                                    odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
                                                    vulputate velit imperdiet dolor tempor tristique. Pellentesque
                                                    habitant morbi tristique senectus et netus et malesuada fames ac
                                                    turpis egestas. Integer convallis volutpat dui quis
                                                    scelerisque.&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="{{ asset('assets/images/person-1.png') }}"
                                                        alt="Maria Jones" class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Maria Jones</h3>
                                                <span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonial Slider -->
@endsection
