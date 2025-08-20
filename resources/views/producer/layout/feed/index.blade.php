@extends('producer.app')

@section('title', 'My Feed')

@push('style')
@endpush

@section('content')
    <section class="app--content">
        <!-- browse--melodies start -->
        <div class="browse--melodies" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">
            <!-- top content  -->
            <div class="top--content">
                <h1 data-aos="zoom-in" data-aos-duration="1600">
                    What's new from your favorite producers
                </h1>
                <p data-aos="zoom-in" data-aos-duration="1600">
                    Here you will find all the new content from your favorite producers. You can see the latest melodies
                    they've uploaded and the newest sample
                    packs they've released.
                </p>
            </div>

            <!-- premium pack slider  -->
            <div class="premium--pack--slider">
                <h4 class="small--green--title mb_20">Latest Packs</h4>
                <div class="slider--inner" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">
                    <div class="owl-carousel feed--slider">
                        @foreach ($data['packs'] as $item)
                            <div class="item">
                                <a href="{{ route('producer.pack.show', Crypt::encrypt($item->id)) }}"
                                    class="album--packs--card">
                                    {{-- <div class="add--cart--icon" onclick="addToCart(event,{{ $item->id }})">
                                        <img src="{{ asset('frontend/images/shopping-cart.svg') }}" alt="" />
                                    </div> --}}
                                    <!-- img area  -->
                                    <div class="img--area">
                                        <img src="{{ $item->thumbnail }}" alt="" />
                                    </div>
                                    <h4>{{ $item->name }}</h4>
                                    <div class="d-flex flex-column">
                                        <p class="artist">{{ $item->user->producer_name }}
                                        <p class="price">${{ number_format($item->price, 2) }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    @if ($data['packs']->isEmpty())
                    <h4 style="font-size: 16px" class="ms-4 mt-2 text-center">No Packs</h4>
                    @endif
                </div>
            </div>


            @include('producer.partials.filter-form')
            <!-- Melody List Container -->
            <div id="melodyList">
                @include('producer.partials.melody-list', ['melodies' => $data['melodies']])
            </div>
            <div id="paginationLinks">
                @include('producer.partials.pagination', ['melodies' => $data['melodies']])
            </div>
        </div>
        <!-- browse--melodies end -->
    </section>

    @component('components.player-component')
    @endcomponent


@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Hendeling Filtering --}}
     {{-- Filtering  --}}
     <script>



        $(document).ready(function() {
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                let url = "{{ route('producer.feed') }}";
                $.ajax({
                    url: url,
                    type: "GET",
                    data: $(this).serialize(),
                    success: function(response) {
                        // Initialize Melody Wave

                        $('#melodyList').html(response.html);
                        $('#paginationLinks').html(response.pagination);
                        handleMelodyPlayer();
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + error);
                    }
                });
            });
        });
    </script>
@endpush
