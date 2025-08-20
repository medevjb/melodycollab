@extends('producer.app')

@section('title', 'Producers')

@push('style')
    <style>
        .clear-filter {
            width: 121px;
            margin-top: 85px;
        }

        @media only screen and (max-width: 811px) {
            .clear-filter {
                width: 100%;
                display: block;
                margin-top: 122px;
            }
        }
    </style>
@endpush

@section('content')
    <section class="app--content">
        <!-- producers area start -->
        <section class="producers--area" data-aos="zoom-in" data-aos-duration="1600">
            <!-- find--producers -->
            <div class="find--producers">
                <h1 data-aos="zoom-in" data-aos-duration="1600">All Producers</h1>
                <form action="{{ route('producer.all.producers') }}" method="GET" id="searchForm">
                    <!-- search  -->
                    <div class="search--producers" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="50">
                        <input type="text" id="search" name="search" value="{{ request()->search }}"
                            placeholder="Search producers" />
                        <button type="submit">Search Now</button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M1.74805 6.98546C1.74805 9.6008 3.86821 11.721 6.48357 11.721C7.61621 11.721 8.65608 11.3232 9.471 10.6598L13.2177 14.4066C13.4074 14.5962 13.7149 14.5962 13.9046 14.4066C14.0943 14.217 14.0943 13.9094 13.9046 13.7198L10.1579 9.97296C10.8213 9.15808 11.219 8.11821 11.219 6.98546C11.219 4.37014 9.09886 2.25 6.48357 2.25C3.86821 2.25 1.74805 4.37014 1.74805 6.98546ZM2.71941 6.98546C2.71941 9.06432 4.40469 10.7495 6.48357 10.7495C8.56238 10.7495 10.2476 9.06432 10.2476 6.98546C10.2476 4.90662 8.56238 3.22138 6.48357 3.22138C4.40469 3.22138 2.71941 4.90662 2.71941 6.98546Z"
                                fill="#878787" />
                        </svg>
                    </div>
                    <!-- producers--filter -->
                    <div class="producers--filter" style="position: relative">
                        <div class="options">
                            <div class="state global-for-clear">Global</div>
                            <div>
                                <select name="country">
                                    <option selected disabled>BY COUNTRY</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country') == $country->id ? 'selected' : '' }}>{{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <a href="#" onclick="applyCountryFilter(event)" class="apply--filter">
                            Apply Filter
                        </a>

                    </div>
                    <button type="button" class="clear-filter" title="Clear Filter">
                        Clear Filter
                    </button>
                </form>
            </div>
            <!-- top producers  -->
            <div class="producers--wrapper top--producers mt_65">
                <h3 data-aos="fade-in" data-aos-duration="1600">Top Producers</h3>
                <div class="custom--row">
                    @forelse ($topProducers as $top)
                        <!-- producer  -->
                        <div class="card--wrapper" data-aos="zoom-in" data-aos-duration="1600" data-aos-offset="0">
                            @if (!empty($top->username))
                                <a href="{{ route('producer.producers.profile',['username' => $top->username]) }}"
                                    class="producer--card">
                                    <div class="img--area">
                                        <img src="{{ asset($top->avatar) }}" alt="" />
                                    </div>
                                    <p>{{ $top->producer_name }}</p>
                                </a>
                            @else
                                <div class="producer--card">
                                    <div class="img--area">
                                        <img src="{{ asset($top->avatar) }}" alt="" />
                                    </div>
                                    <p>{{ $top->producer_name }}</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <h4 style="font-size: 16px" class="ms-4 mt-4 ">No Producer Found for this Search</h4>
                    @endforelse
                </div>
            </div>
            <div class="producers--wrapper top--producers mt_65">
                <h3 data-aos="fade-in" data-aos-duration="1600">All Producers</h3>
                <div class="custom--row">
                    @forelse ($producers as $producer)
                        <div class="card--wrapper" data-aos="zoom-in" data-aos-duration="1600" data-aos-offset="0">
                            @if (!empty($producer->username))
                                <a href="{{ route('producer.producers.profile', ['username' => $producer->username]) }}"
                                    class="producer--card">
                                    <div class="img--area">
                                        <img src="{{ asset($producer->avatar) }}" alt="" />
                                    </div>
                                    <p>
                                        {{ $producer->producer_name }}
                                    </p>
                                </a>
                            @else
                                <span class="producer--card">
                                    <div class="img--area">
                                        <img src="{{ asset($producer->avatar) }}" alt="" />
                                    </div>
                                    <p>

                                    {{ $producer->producer_name }}
                                    </p>
                                </span>
                            @endif
                        </div>
                    @empty
                        <h4 style="font-size: 16px" class="ms-4 mt-4 ">No Producers</h4>
                    @endforelse

                </div>
                {{ $producers->links() }}
            </div>
        </section>
        <!-- producers area end -->

    </section>


@endsection

@push('script')
    <script>
        function applyCountryFilter(e) {
            e.preventDefault();
            document.getElementById("search").value = "";
            var form = document.getElementById("searchForm");
            form.submit();
        }
    </script>
@endpush
