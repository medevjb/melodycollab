@extends('frontend.app')

@section('title', 'Pricing')

@push('style')
    <style>
        footer .logo img {
            width: 211px;
            height: 50px;
            margin: 35px 0;
        }

        .logo-white,
        .logo-black {
            display: none;
        }
        footer{
            display: none;
        }
    </style>
@endpush

@section('content')
    <main>
        <!-- pricing area start  -->
        <section class="pricing--area page--pricing">
            <div class="container">
                <!-- section title  -->
                <div class="section--title text-center">
                    <h3 data-aos="zoom-out" data-aos-duration="1200">
                        Create your Free Account Today!
                    </h3>
                </div>
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

        <!-- faq area start  -->
        <section class="faq--area mb-5">
            <!-- section title  -->
            <div class="section--title text-center mb_20">
                <h3 data-aos="zoom-out" data-aos-duration="1200" class="aos-init aos-animate">
                    Frequently Asked Questions
                </h3>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        What do I get when I sign up for the free trial?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>
                                            You will have access to all the benefits of a Pro account for 7 days, allowing
                                            you to explore everything the platform has to offer and advance your career as a
                                            music producer.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Can I cancel whenever I want?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>
                                            Yes, you can cancel your Pro membership with Melody Collab at any time. Just
                                            keep in mind that you will lose all the benefits of being a Pro member.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- faq area end  -->
    </main>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script></script>
@endpush
