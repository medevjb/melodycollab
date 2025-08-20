@extends('producer.app')

@section('title', 'Marketplace')

@push('style')
    <style>
        @media only screen and (min-width: 1200px) and (max-width: 1365px) {
            .button {
                margin-bottom: 0;
            }
        }
    </style>
@endpush

@section('content')
    <section class="app--content">
        <!-- marketplace area start -->
        <div class="browse--melodies marketplace--area" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">
            <!-- album slider  -->
            <div class="album--slider--wrapper">
                <div class="owl-carousel album--slider">
                    @forelse ($topPacks as $top)
                        <div class="item">
                            <div class="slider--card">
                                <img class="w-100" src="{{ asset($top->thumbnail) }}" alt="" />
                                <!-- details--box  -->
                                <div class="details--box">
                                    <div>
                                        <h3>
                                            {{ $top->name }}
                                        </h3>
                                        {{--   <a href="{{ route('producer.producers.profile', ['username' => $top->user->username]) }}"
                                            id="slider--description" class="d-block" style="color: var(--primary-color)">
                                            {{ $top->user->producer_name }}
                                        </a> --}}
                                        @if (!empty($top->user->username))
                                            <a href="{{ route('producer.producers.profile', ['username' => $top->user->username]) }}"
                                                id="slider--description" class="d-block"
                                                style="color: var(--primary-color)">
                                                {{ $top->user->producer_name }}
                                            </a>
                                        @else
                                            <span id="slider--description" class="d-block"
                                                style="color: var(--primary-color)">
                                                {{ $top->user->producer_name }}
                                            </span>
                                        @endif

                                    </div>
                                    <div class="buttons">
                                        <a href="#" class="buttonv2 play--demo"
                                            data-audio="{{ asset($top->melodiesFirst->file ?? '') }}"
                                            data-audio-id="{{ $top->melodiesFirst->id ?? '' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10"
                                                viewBox="0 0 8 10" fill="none">
                                                <path
                                                    d="M7.5 4.13397C8.16667 4.51887 8.16667 5.48113 7.5 5.86603L1.5 9.33013C0.833334 9.71503 -4.47338e-07 9.2339 -4.13689e-07 8.4641L-1.10848e-07 1.5359C-7.71986e-08 0.766098 0.833333 0.284973 1.5 0.669873L7.5 4.13397Z"
                                                    fill="#D9D9D9" />
                                            </svg>
                                            Play Demo
                                        </a>
                                        <a href="{{ route('producer.pack.show', ['id' => Crypt::encrypt($top->id)]) }}"
                                            class="button">View Pack</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h4>
                            No Packs Found
                        </h4>
                    @endforelse

                </div>
            </div>

            <div class="find--producers find--packs mt_65">
                <h1 data-aos="zoom-in" data-aos-duration="1600" class="aos-init aos-animate">Search Sample Packs</h1>
                <form action="{{ route('producer.marketplace') }}">
                    <!-- search  -->
                    <div class="search--producers aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1600"
                        data-aos-delay="50">
                        <input type="text" name="search" value="{{ request()->search }}"
                            placeholder="Search Sample Packs">
                        <button type="submit">Search Now</button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M1.74805 6.98546C1.74805 9.6008 3.86821 11.721 6.48357 11.721C7.61621 11.721 8.65608 11.3232 9.471 10.6598L13.2177 14.4066C13.4074 14.5962 13.7149 14.5962 13.9046 14.4066C14.0943 14.217 14.0943 13.9094 13.9046 13.7198L10.1579 9.97296C10.8213 9.15808 11.219 8.11821 11.219 6.98546C11.219 4.37014 9.09886 2.25 6.48357 2.25C3.86821 2.25 1.74805 4.37014 1.74805 6.98546ZM2.71941 6.98546C2.71941 9.06432 4.40469 10.7495 6.48357 10.7495C8.56238 10.7495 10.2476 9.06432 10.2476 6.98546C10.2476 4.90662 8.56238 3.22138 6.48357 3.22138C4.40469 3.22138 2.71941 4.90662 2.71941 6.98546Z"
                                fill="#878787"></path>
                        </svg>
                    </div>
                </form>
            </div>

            <div class="all--packs mt_65">
                <h4 class="small--green--title mb_20">Browse All Packs</h4>
                <div class="custom--row">
                    @forelse ($packs as $pack)
                        <div class="card--wrapper" data-aos="zoom-in" data-aos-duration="1600" data-aos-offset="0">
                            <!-- packs card  -->
                            <a href="{{ route('producer.pack.show', ['id' => Crypt::encrypt($pack->id)]) }}"
                                class="album--packs--card">
                                {{-- <div class="add--cart--icon" onclick="addToCart(event,{{ $pack->id }})">
                                    <img src="{{ asset('frontend/images/shopping-cart.svg') }}" alt="" />
                                </div> --}}
                                <!-- img area  -->
                                <div class="img--area">
                                    <img src="{{ asset($pack->thumbnail) }}" alt="" />
                                    <!-- play demo  -->
                                    @if ($pack->melodiesFirst)
                                        <p class="play--demo" data-bs-toggle="tooltip" data-bs-title="Play Demo"
                                            data-audio="{{ asset($pack->melodiesFirst->file) }}"
                                            data-audio-id="{{ $pack->melodiesFirst->id }}">
                                            <img src="{{ asset('frontend/images/play-svgrepo-com.svg') }}"
                                                alt="" />
                                        </p>
                                    @endif

                                </div>
                                <h4>{{ $pack->name }}</h4>
                                <div class="d-flex flex-column">
                                    <p class="artist">{{ $pack->user->producer_name }}</p>
                                    <p class="price">${{ Number::format($pack->price, 2) }}</p>
                                </div>
                            </a>
                        </div>
                    @empty
                    @endforelse
                    <div class="card--wrapper" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="300"
                        data-aos-offset="0">
                    </div>
                </div>
            </div>
            <!-- pagination  -->
            {{ $packs->links() }}

        </div>
        <!-- marketplace area end -->

    </section>

    @component('components.player-component')
    @endcomponent


@endsection

@push('script')
@endpush
