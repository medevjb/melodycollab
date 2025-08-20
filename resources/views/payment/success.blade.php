@extends('frontend.app')

@section('title', 'Success Payment')

@push('style')
 <link rel="stylesheet" href="{{ asset('producers/css/style.css') }}">
 <style>
    .logo-white,
        .logo-black {
            display: none;
        }
 </style>
@endpush

@section('content')

    <section class="welcome--area">
        <div class="row justify-content-center">
            <div class="col-xxl-5 col-xl-7 col-lg-10 col-md-11">
                <!-- welcome--wrapp  -->
                <div class="welcome--wrapp aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1600"
                    data-aos-offset="0">
                    <h2 class="title--lg">Welcome! You are now a Pro.</h2>
                    <p class="title--sm">Get access to all the benefits today for free and take
                        your career to the next level.</p>
                    <!-- welcome--box  -->
                    <div class="welcome--box">
                        <img src="{{ asset('frontend/images/check-large.png')}}" alt="">
                        <a href="{{ route('producer.dashboard')}}" class="button welcome-btn">Go to My Account</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
@endpush
