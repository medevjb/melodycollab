@extends('producer.app')

@section('title', $data['producer']->producer_name   . ' Profile')

@push('style')
@endpush

@section('content')
    <section class="app--content">
        <!-- profiile area start -->
        <section class="profile--area">
            <form action="#">
                <!-- cover upload  -->
                <div class="cover--upload" data-aos="fade-in" data-aos-duration="1600">
                    <img id="cover--preview" src="{{ asset($data['producer']->cover ?? 'backend/images/cover.png') }}"
                        alt="" />
                    <div id="cover-loader" class="upload--loader" style="display: none">
                        <img src="{{asset('frontend/images/tube-spinner.svg')}}" alt="" />
                    </div>
                    <!-- upload btn  -->
                </div>
                <!-- profile  -->
                <div class="profile">
                    <!-- profile--upload  -->
                    <div class="upload--profile--wrap">
                        <!-- profile upload  -->
                        <div class="profile--upload" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="150">
                            <img id="profile--preview" src="{{ asset($data['producer']->avatar) }}" alt="" />
                            <div id="profile-loader" class="upload--loader" style="display: none">
                                <img src="{{asset('frontend/images/tube-spinner.svg')}}" alt="" />
                            </div>
                        </div>
                        <div data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">
                            @if (auth()->user()->isFollowing($data['producer']->id))
                                <button class="buttonv2 following--btn" onclick="unfollowUser(event,'{{ $data['producer']->id }}', this)">Unfollow</button>
                                @else
                                <button class="buttonv2 following--btn" onclick="followUser(event,'{{ $data['producer']->id }}', this)">Follow</button>
                            @endif
                        </div>
                    </div>
                    <!-- profile--details -->
                    <div class="profile--details" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">
                        <!-- name  -->
                        <div class="name">
                            <p>{{ $data['producer']->producer_name }}</p>
                            <span>{{ Number::abbreviate($data['producer']->followers->count()) }} Followers </span>
                        </div>
                        <p class="desc">
                            {{ $data['producer']->about }}
                        </p>
                        <div class="social--links--wrap">
                            <p data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="150" data-aos-offset="0">
                                Social Links
                            </p>
                            <div class="links">
                                @if ($data['producer']->instagram_username)
                                    <a href="https://www.instagram.com/{{ $data['producer']->instagram_username }}"
                                        target="_blank" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"
                                        data-aos-offset="0">
                                        <img src="{{ asset('frontend/images/insta.png') }}" alt=""
                                            width="40" class="rounded-circle" />
                                    </a>
                                @endif
                                @if ($data['producer']->youtube_username)
                                    <a href="https://www.youtube.com/{{ $data['producer']->youtube_username }}"
                                        target="_blank" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"
                                        data-aos-offset="0">
                                        <img src="{{ asset('frontend/images/youtubeicon.png') }}" alt="" width="40"
                                            class="rounded-circle" />
                                    </a>
                                @endif
                                @if ($data['producer']->beatstars_username)
                                    <a href="https://www.beatstars.com/{{ $data['producer']->beatstars_username }}"
                                        target="_blank" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"
                                        data-aos-offset="0">
                                        <img src="{{ asset('frontend/images/BEATSTARSICON.png') }}" alt=""
                                            width="40" class="rounded-circle" />
                                    </a>
                                @endif
                                @if ($data['producer']->soundee_username)
                                    <a href="https://www.soundee.com/{{ $data['producer']->soundee_username }}"
                                        target="_blank" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"
                                        data-aos-offset="0">
                                        <img src="{{ asset('frontend/images/SOUNDEEICON.png') }}" alt=""
                                            width="40" class="rounded-circle" />
                                    </a>
                                @endif
                                @if ($data['producer']->tiktok_username)
                                    <a href="https://www.tiktok.com/{{ '@'.$data['producer']->tiktok_username }}"
                                        target="_blank" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"
                                        data-aos-offset="0">
                                        <img src="{{ asset('frontend/images/SOUNDEEICON.png') }}" alt=""
                                            width="40" class="rounded-circle" />
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- premium pack slider  -->
            @if ($data['packs']->count() > 0)
                <div class="premium--pack--slider">
                    <h3 class="title" data-aos="zoom-in" data-aos-duration="1600">{{ $data['producer']->producer_name }} Premium Packs</h3>
                    <div class="slider--inner" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">
                        <div class="owl-carousel pack--slider">
                            @forelse ($data['packs'] as $item)
                                <div class="item">
                                    <a href="{{ route('producer.pack.show', Crypt::encrypt($item->id)) }}"
                                        class="album--packs--card">
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
                            @empty
                                <h4 style="font-size: 16px" class="ms-4 mt-4 ">No Packs</h4>
                            @endforelse

                        </div>
                    </div>
                </div>
            @else
                <h4 style="font-size: 22px" class="ms-4 mt-5 text-center " data-aos="zoom-in" data-aos-duration="1600"
                    data-aos-delay="100">No Packs Yet</h4>
            @endif
            <!-- browse--melodies start -->
            <div class="browse--melodies profile--melodies" data-aos="zoom-in" data-aos-duration="1600"
                data-aos-delay="100">
                <h1 class="title text-center fw-bold">{{ $data['producer']->producer_name }} Melodies</h1>
                <!-- top content  -->
                @include('producer.partials.filter-form')
                <!-- all melodies  -->
                @if ($data['melodies']->count() > 0)
                    <div id="melodyList">
                        @include('producer.partials.melody-list', ['melodies' => $data['melodies']])
                    </div>
                    <div id="paginationLinks">
                        @include('producer.partials.pagination', ['melodies' => $data['melodies']])
                    </div>
                @else
                    <h4 style="font-size: 22px" class="ms-4 mt-5 text-center ">No melodies found</h4>
                @endif
            </div>
            <!-- browse--melodies end -->
        </section>
        <!-- profiile area end -->
    </section>


    @component('components.player-component')
    @endcomponent
@endsection

@push('script')
    {{-- Filtering  --}}
    <script>
        $(document).ready(function() {
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                let url = "{{ route('producer.producers.profile', ':username') }}";
                $.ajax({
                    url: url.replace(':id', '{{ $data['producer']->username }}'),
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
