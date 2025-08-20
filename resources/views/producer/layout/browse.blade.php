@extends('producer.app')

@section('title', 'Browse Melodies')

@push('style')
    <style>
    </style>
@endpush

@section('content')
    <section class="app--content">
        <!-- browse--melodies start -->
        <div class="browse--melodies" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">
            <!-- top content  -->
            <div class="top--content">
                <h1 data-aos="zoom-in" data-aos-duration="1600">All Melodies</h1>
                <p data-aos="zoom-in" data-aos-duration="1600">
                    Find the perfect melody for your next collaboration with producers from around the world. Collaborate
                    and take your music to the next level with these top-tier producers’ melodies.
                </p>
                <!-- search  -->
                <div class="search--melodi" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="50">
                    <form action="{{ route('producer.browse') }}" method="GET">
                        <input type="text" name="search" value="{{ request()->search }}"
                            placeholder="Search Melodies or Producers" />
                        <button type="submit">Search Now</button>
                    </form>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17"
                        fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M1.74805 6.98546C1.74805 9.6008 3.86821 11.721 6.48357 11.721C7.61621 11.721 8.65608 11.3232 9.471 10.6598L13.2177 14.4066C13.4074 14.5962 13.7149 14.5962 13.9046 14.4066C14.0943 14.217 14.0943 13.9094 13.9046 13.7198L10.1579 9.97296C10.8213 9.15808 11.219 8.11821 11.219 6.98546C11.219 4.37014 9.09886 2.25 6.48357 2.25C3.86821 2.25 1.74805 4.37014 1.74805 6.98546ZM2.71941 6.98546C2.71941 9.06432 4.40469 10.7495 6.48357 10.7495C8.56238 10.7495 10.2476 9.06432 10.2476 6.98546C10.2476 4.90662 8.56238 3.22138 6.48357 3.22138C4.40469 3.22138 2.71941 4.90662 2.71941 6.98546Z"
                            fill="#878787" />
                    </svg>
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
    {{-- Filtering  --}}
    <script>
        $(document).ready(function() {
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let search = $('.search--melodi').find('input[name="search"]').val();
                formData += `&search=${search}`;

                $.ajax({
                    url: "{{ route('producer.browse') }}",
                    type: "GET",
                    data: formData,
                    success: function(response) {
                        console.log(response);

                        // Stop and destroy current WaveSurfer instances
                        if (typeof currentPlaying !== 'undefined' && currentPlaying) {
                            currentPlaying.pause();
                            currentPlaying.destroy();
                            currentPlaying = null;
                            currentButton = null;
                        }

                        // Update melody list and pagination
                        $('#melodyList').html(response.html);
                        $('#paginationLinks').html(response.pagination);

                        // Verify audio source
                        $('#melodyList .melodi').each(function() {
                            const audioSrc = $(this).data('audio-src');
                            if (!audioSrc) {
                                console.error("Audio source not found for melody.");
                            }
                        });

                        // Re-initialize the melody player for new items
                        handleMelodyPlayer();
                    },
                    error: function(xhr, status, error) {
                        console.log("Error: " + error);
                    }
                });
            });
        });



        $(document).on('click', '.page-link', function() {
            $('.default--audio--player').removeClass('show');
            // Stop and destroy current WaveSurfer instances
            if (typeof currentPlaying !== 'undefined' && currentPlaying) {
                currentPlaying.pause();
                currentPlaying.destroy();
                currentPlaying = null;
                currentButton = null;
            }
        });
    </script>
@endpush
