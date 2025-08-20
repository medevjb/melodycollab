@extends('frontend.app')

@section('title', 'Home')

@push('style')
    <style>
        .logo-white,
        .logo-black {
            display: block;
        }

        .cookie-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            opacity: 0.9;
            z-index: 9999;
        }
    </style>
@endpush

@section('content')
    <!-- hero area start  -->
    <section class="hero--area" style="background-image: url({{ asset('frontend/images/hero-bg.png') }})">
        <div class="container">
            <div class="row">
                <div class="hero--contents text-center">
                    <h2 data-aos="zoom-out" data-aos-duration="1600">COLLAB WITH</h2>
                    <h1 data-aos="zoom-out" data-aos-duration="1600" data-aos-delay="100">
                        TOP MUSIC <br />
                        PRODUCERS
                    </h1>
                    <p data-aos="zoom-out" data-aos-duration="1600" data-aos-delay="100">
                        Browse thousands of free melodies <br />
                        from top producers to collab on your next HIT!
                    </p>
                    <div data-aos="zoom-out" data-aos-duration="1600" data-aos-delay="100">
                        <a href="{{ route('register') }}" class="button">
                            Try For Free
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path d="M15.5859 3.28296L4.4916 14.3773" stroke="#050505" stroke-width="1.78302"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15.5859 11.4214V3.28296H7.44745" stroke="#050505" stroke-width="1.78302"
                                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- hero area end  -->
    <!-- hero maquee area start  -->
    <section class="marquee--area d-none" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="100"
        data-aos-offset="0">
        <div class="rk--hero--marquee">
            <div class="slide">
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee1.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Albano White</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee3.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Mark Albano</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee2.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Cesear Kasilias</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee1.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Albano White</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee3.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Mark Albano</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee2.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Cesear Kasilias</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee1.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Albano White</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee3.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Mark Albano</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee2.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Cesear Kasilias</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
            </div>
            <div class="slide">
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee1.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Albano White</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee3.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Mark Albano</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee2.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Cesear Kasilias</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee1.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Albano White</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee3.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Mark Albano</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee2.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Cesear Kasilias</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee1.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Albano White</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee3.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Mark Albano</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
                <!-- slider item  -->
                <div class="slider--item">
                    <div class="img--area">
                        <img src="{{ asset('frontend/images/marquee2.png') }}" alt="maquee--img" />
                    </div>
                    <div class="content">
                        <h4>Cesear Kasilias</h4>
                        <p>30 Music, 4 Playlists</p>
                    </div>
                </div>
            </div>
        </div>
        <img class="curved--up" src="{{ asset('frontend/images/curved-shape-up.png') }}" alt="" />
        <img class="curved--down" src="{{ asset('frontend/images/curved-shape-down.png') }}" alt="" />
    </section>
    <!-- hero maquee area end  -->

    <!-- top level melodies area start  -->
    {{-- <section class="top--levelmelodies--area">
        <!-- section title  -->
        <div class="section--title text-center d-none">
            <h3 data-aos="zoom-out" data-aos-duration="1200">
                Top Level Melodies From Top Producers To Level Up Your Beats
            </h3>
            <div data-aos="zoom-out" data-aos-duration="1200">
                <a href="#"{{ route('login', ['from' => 'signin']) }}class="buttonv2">Get Started Today</a>
            </div>
        </div>
        <div class="content">
            <div class="top-melodies-marquee-slider" data-aos="fade-left" data-aos-duration="1200">
                <div class="slide">
                    @forelse ($packs as $item)
                        <div class="slider--item">
                            <a href="{{ route('producer.pack.show', ['id' => Crypt::encrypt($item->id)]) }}"
                                class="melodi--card">
                                <div class="img--area">
                                    <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->name }}" />
                                </div>
                                <div class="contents">
                                    <p class="playlist">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15Z"
                                                stroke="#FAFAFA" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M9.62 17.3C10.7908 17.3 11.74 16.3509 11.74 15.1801C11.74 14.0092 10.7908 13.0601 9.62 13.0601C8.44915 13.0601 7.5 14.0092 7.5 15.1801C7.5 16.3509 8.44915 17.3 9.62 17.3Z"
                                                stroke="#FAFAFA" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M11.7422 15.18V7.77002" stroke="#FAFAFA" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M13.1322 6.7701L15.4722 7.55006C16.0422 7.74006 16.5022 8.38006 16.5022 8.98006V9.60005C16.5022 10.4101 15.8722 10.8601 15.1122 10.6001L12.7722 9.82008C12.2022 9.63008 11.7422 8.99009 11.7422 8.39009V7.7701C11.7422 6.9701 12.3622 6.5101 13.1322 6.7701Z"
                                                stroke="#FAFAFA" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        Playlist
                                    </p>
                                    <h4>{{ $item->name }}</h4>
                                    <div class="price">
                                        <p>{{ $item->melodies->count() }} Music</p>
                                        <p>${{ Number::format($item->price, 2) }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <h4 class="text-center">No Data</h4>
                    @endforelse
                </div>
            </div>
        </div>
    </section> --}}
    <!-- top level melodies area end  -->

    <!-- instruction area start  -->
    <section class="instruction--area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1200" data-aos-offset="0">
                    <div class="img--area img--rotate img--rotate--wrap">
                        <img src="{{ asset('frontend/images/landing-01.png') }}" alt="" />
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1200">
                    <div class="details">
                        <h3>
                            Create your free profile and upload your melodies to collaborate with top producers.
                        </h3>
                        <p>
                            By creating your profile, you can share your melodies with top producers around the world and
                            unlock endless collaboration opportunities.
                        </p>
                        <a href="{{ route('register') }}" class="button">Get Started Today</a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center row--reverse">
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1200">
                    <div class="img--area img--rotate img--rotate--wrap">
                        <img src="{{ asset('frontend/images/landing-02.png') }}" alt="" />
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1200" data-aos-offset="0">
                    <div class="details">
                        <h3>
                            Sell your sample packs in our marketplace and earn money today!
                        </h3>
                        <p>
                            Unlock your earning potential in our dedicated marketplace for music producers. Reach the right
                            audience and maximize your earnings!
                        </p>
                        <a href="{{ route('register') }}" class="button">Get Started Today</a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1200" data-aos-offset="0">
                    <div class="img--area img--rotate img--rotate--wrap">
                        <img src="{{ asset('frontend/images/landing-03.png') }}" alt="" />
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1200">
                    <div class="details">
                        <h3>
                            Download melodies from top producers and split sales on digital beat stores.
                        </h3>
                        <p>
                            Access exclusive melodies from top producers, collaborate globally, and share in sales profits.
                            Unlock new opportunities to elevate your music career through powerful partnerships.
                        </p>
                        <a href="{{ route('register') }}" class="button">Get Started Today</a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center row--reverse">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1200" data-aos-offset="0">
                    <div class="img--area img--rotate img--rotate--wrap">
                        <img src="{{ asset('frontend/images/landing-04.png') }}" alt="" />
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1200">
                    <div class="details">
                        <h3>
                            Access our Free melody samples database from top producers all around the world.
                        </h3>
                        <p>
                            Explore the world’s top melody sample database, crafted by leading producers. Unlock endless
                            creative possibilities and collaborate globally to take your music to new heights.
                        </p>
                        <a href="{{ route('register') }}" class="button">Get Started Today</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- instruction area end  -->

    <!-- pricing area start  -->
    <!-- pricing area start  -->
    <section class="pricing--area">
        <div class="container">
            <!-- section title  -->
            <div class="section--title text-center">
                <h3 data-aos="zoom-out" data-aos-duration="1200">
                    Create your Free Account Today!
                </h3>
            </div>
            <!-- pricing--package--switcher  -->
            <!-- <div class="pricing--package--switcher">
                                      <div>
                                        <input id="yearly" type="radio" name="priceing" checked />
                                        <label for="yearly" class="package yearly">
                                          Yearly
                                          <div class="tag">Save 2 months</div>
                                        </label>
                                      </div>
                                      <div>
                                        <input id="monthly" type="radio" name="priceing" />
                                        <label for="monthly" class="package monthly mt_15">
                                          Monthly
                                        </label>
                                      </div>
                                    </div> -->
            <div class="inner" data-aos="fade-in" data-aos-duration="1200">
                <div class="row no-gutters justify-content-center">
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="100">
                        <!-- price card  -->
                        <div class="price--card free">
                            <h3 class="price">$0</h3>
                            <div class="plan--feature">
                                <p class="plan">Free</p>
                                <span class="quote">Create your free account to have access to all of
                                    this:</span>
                                <ul>
                                    <li>
                                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="" />
                                        Create your Producer Profile
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="" />
                                        Download Melodies from other producers
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="" />
                                        Access all Melodies Library
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="" />
                                        Upload 5 Melodies to Collab
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="" />
                                        Collab with other producers
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('register') }}" class="button w-100 mt_40">Create Free Account</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="200">
                        <!-- price card  -->
                        <div class="price--card card--popular">
                            <h3 class="price">$9.99<span>/month</span></h3>
                            <div class="plan--feature">
                                <p class="plan">Pro</p>
                                <span class="quote">Take your producer career to<br />
                                    the next level</span>
                                <ul>
                                    <li>
                                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="" />
                                        Everything in Free +
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="" />
                                        Upload unlimited melodies for collab
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="" />
                                        Sell Sample Packs
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="" />
                                        Custom Sample Pack Store
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="" />
                                        Sell on producer marketplace
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="" />
                                        Sell Digital Products
                                    </li>
                                    <li>
                                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="" />
                                        Pro Analytics Dashboard
                                    </li>
                                </ul>
                            </div>
                            @if (Auth::check() && Auth::user()->hasMembership())
                                <a href="{{ route('producer.edit.profile') }}" class="button w-100 mt_30">
                                    Manage Membership
                                </a>
                            @else
                                <a href="{{ route('producer.membership', ['type' => Str::slug('Pro')]) }}"
                                    class="button w-100 mt_30">
                                    Try Pro
                                </a>
                            @endif
                            <p class="tag">MOST POPULAR</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- pricing area end  -->

  <!-- Cookie Consent Banner -->
<div id="cookieBanner" class="cookie-banner" style="display: none; justify-content: center; align-items: center; background: black; color: white; padding: 10px;">
    <p>This website uses cookies to ensure you get the best experience on our website. <a href="{{ route('dynamic.page', ['slug' => 'privacy-policy'])}}" style="color: white; text-decoration: underline; padding-right: 30px;">Learn More.</a></p>
    <button id="acceptCookies" class="btn btn-success" style="background-color: black; padding-left: 30px; padding-right: 30px; transition: all 0.3s ease-in-out;" onmouseover="this.style.backgroundColor='#0ccf9f'" onmouseout="this.style.backgroundColor='black'; ">Accept</button>
</div>
@endsection



@push('script')
    <script>
        // Function to set a cookie
        function setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Cookie expires in 'days' days
            document.cookie = name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
        }

        // Function to get a cookie by name
        function getCookie(name) {
            const decodedCookie = decodeURIComponent(document.cookie);
            const cookiesArray = decodedCookie.split(';');
            for (let i = 0; i < cookiesArray.length; i++) {
                let cookie = cookiesArray[i].trim();
                if (cookie.indexOf(name + "=") === 0) {
                    return cookie.substring(name.length + 1);
                }
            }
            return "";
        }

        // Show the cookie banner if the user hasn't accepted cookies
        document.addEventListener("DOMContentLoaded", function() {
            if (getCookie("cookieConsent") !== "accepted") {
                document.getElementById('cookieBanner').style.display = 'flex'; // Show the banner
            }
        });

        // Handle the "Accept Cookies" button click
        document.getElementById('acceptCookies').addEventListener('click', function() {
            setCookie("cookieConsent", "accepted", 365); // Save cookie for 1 year
            document.getElementById('cookieBanner').style.display = 'none'; // Hide the banner immediately
        });
    </script>
@endpush