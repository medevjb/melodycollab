@extends('producer.app')

@section('title', $pack->name . ' Details')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.2.0/magnific-popup.min.css" />
@endpush

@section('content')

    <section class="app--content">
        <!-- individiul pack area start -->
        <section class="individiul--pack--area">
            <!-- pack--details -->
            <div class="pack--details" data-aos="zoom-in" data-aos-duration="1200">
                <!-- pack--cover  -->
                <div class="pack--cover">
                    <img class="w-100" src="{{ asset($pack->user->cover) }}" alt="" />
                </div>
                <!-- pack -->
                <div class="pack">
                    <!-- pack--left  -->
                    <div class="pack--left" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="100">
                        <img src="{{ asset($pack->thumbnail) }}" alt="{{ $pack->name }}" />
                        @if ($pack->user->id != Auth::user()->id)
                            <a href="{{ route('producer.buy.pack', ['id' => Crypt::encrypt($pack->id)]) }}"
                                class="buttonv3">Buy This Pack</a>
                        @endif
                    </div>
                    <!-- pack--right -->
                    <div class="pack--right">
                        <div class="">
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <h2 class="pack--title" data-aos="zoom-in" data-aos-duration="1200" data-aos-offest="0">
                                    {{ $pack->name }}
                                </h2>
                                @if ($pack->user->id == Auth::user()->id)
                                    <div class="d-flex gap-3">
                                        <div>
                                            <button onclick="ShowDeleteAlert(event,this,{{ $pack->id }})"
                                                class="button mt-2">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        <div>
                                            <a href="{{ route('producer.pack.edit', ['id' => Crypt::encrypt($pack->id)]) }}"
                                                class="buttonv2 mt-2">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                        @if (!empty($pack->user->username))
                            <a href="{{ route('producer.producers.profile', ['username' => $pack->user->username]) }}"
                                class="categoty d-block" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="50"
                                data-aos-offest="0">
                                {{ $pack->user->producer_name }}
                            </a>
                        @else
                            <span class="categoty d-block" data-aos="zoom-in" data-aos-duration="1200"
                                data-aos-delay="50" data-aos-offest="0">
                                {{ $pack->user->producer_name }}
                            </span>
                        @endif
                        <p class="price" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="100"
                            data-aos-offest="0">
                            ${{ Number::format($pack->price, 2) }}
                        </p>
                    </div>
                </div>
                <div class="individiul-demo--audio">
                    <h4>Audio Demos</h4>
                    <div class="melodi--wrapper">
                        @forelse ($pack->melodies as $demo)
                            <!-- melodi  -->
                            <div class="melodi" data-audio-src="{{ asset($demo->file) }}" data-aos="zoom-in"
                                data-aos-duration="1600" data-aos-delay="50" data-aos-offset="0"
                                data-audio-id="{{ $demo->id }}">
                                <div class="playPause--icon playPauseBtn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16"
                                        viewBox="0 0 12 16" fill="none" id="play-icon">
                                        <path
                                            d="M10.272 8.54011L1.40633 14.2546C0.907242 14.5763 0.25 14.218 0.25 13.6242V2.1952C0.25 1.60142 0.90724 1.24311 1.40633 1.56481L10.272 7.27933C10.7302 7.57468 10.7302 8.24476 10.272 8.54011Z"
                                            fill="#0CCF9F" />
                                    </svg>
                                    <svg width="18px" class="d-none" id="pause-icon" height="18px" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2 6C2 4.11438 2 3.17157 2.58579 2.58579C3.17157 2 4.11438 2 6 2C7.88562 2 8.82843 2 9.41421 2.58579C10 3.17157 10 4.11438 10 6V18C10 19.8856 10 20.8284 9.41421 21.4142C8.82843 22 7.88562 22 6 22C4.11438 22 3.17157 22 2.58579 21.4142C2 20.8284 2 19.8856 2 18V6Z"
                                            fill="#1C274C" />
                                        <path
                                            d="M14 6C14 4.11438 14 3.17157 14.5858 2.58579C15.1716 2 16.1144 2 18 2C19.8856 2 20.8284 2 21.4142 2.58579C22 3.17157 22 4.11438 22 6V18C22 19.8856 22 20.8284 21.4142 21.4142C20.8284 22 19.8856 22 18 22C16.1144 22 15.1716 22 14.5858 21.4142C14 20.8284 14 19.8856 14 18V6Z"
                                            fill="#1C274C" />
                                    </svg>
                                </div>
                                <div class="wave"></div>
                                <div class="time-display">00:00</div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
            <!-- pack--popup--video  -->
            {{-- <div class="pack--popup--video mt_55" data-aos="zoom-in" data-aos-duration="1200" data-aos-offset="0">
                <!-- play--area -->
                <div class="play--area">
                    <img class="w-100" src="{{ asset($pack->thumbnail) }}" alt="" />
                    <!-- vid--play -->
                    <a href="{{ asset($pack->promo_video_url) }}" class="vid--play">
                        <img src="{{ asset('frontend/images/play-icon.svg') }}" alt="" />
                    </a>
                </div>
                <div class="social--links--list">
                    {!! $pack->description !!}
                </div>
            </div>
 --}}

            <div class="pack--popup--video mt-5" data-aos="zoom-in" data-aos-duration="1200" data-aos-offset="0">
                <div class="row">
                    <!-- Image Section -->
                    <div class="col-12 col-md-7 mb-4 mb-md-0">
                        <div class="play--area position-relative">
                            <img class="img-fluid w-100 h-100" src="{{ asset($pack->thumbnail) }}" alt="Thumbnail"
                                style="object-fit: cover;" />
                            <!-- Play button centered on the image -->
                            <a href="{{ asset($pack->promo_video_url) }}"
                                class="vid--play position-absolute top-50 start-50 translate-middle">
                                <img src="{{ asset('frontend/images/play-icon.svg') }}" alt="Play Icon" />
                            </a>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="col-12 col-md-5">
                        <div class="social--links--list">
                            <p id="description-text" class="description-text">
                                {!! ($pack->description) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>


    @component('components.player-component')
    @endcomponent
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.2.0/jquery.magnific-popup.min.js"></script>

    {{-- SwwtAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function ShowDeleteAlert(e, element, id) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(id)
                }
            });

        }


        function deleteItem(id) {

            let url = "{{ route('producer.pack.delete', ':id') }}";
            $.ajax({
                type: "DELETE",
                url: url.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(resp) {
                    if (resp.success === true) {
                        toastr.success(resp.message);
                        setTimeout(() => {
                            window.location.href = "{{ route('producer.my.items') }}";
                        }, 2000);
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error: function(error) {
                    toastr.error(error);
                }
            })
        }
    </script>
@endpush
