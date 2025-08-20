@extends('producer.app')

@section('title', 'My Downloads')

@push('style')
@endpush

@section('content')

    <!-- main content start  -->
    <section class="app--content">
        <!-- producers items area start -->
        <div class="producers--items--area">
            <h2 class="title text-center" data-aos="fade-in" data-aos-duration="1500" data-aos-offset="0">
                My Downloads
            </h2>
            <!-- my-packs -->
            <div class="my-packs">
                <h4 class="small--green--title mb_5" data-aos="fade-in" data-aos-duration="1500" data-aos-offset="0">
                   Packs
                </h4>
                <div class="custom--row">
                    @forelse ($data['packs'] as $pack)
                        <div class="card--wrapper" data-aos="zoom-in" data-aos-duration="1600" data-aos-offset="0">
                            <!-- packs card  -->
                            <a href="{{ route('producer.pack.show', ['id' => Crypt::encrypt($pack->id)]) }}"
                                class="album--packs--card">
                                <!-- img area  -->
                                <div class="img--area">
                                    <img src="{{ asset($pack->thumbnail) }}" alt="" />
                                </div>
                                <h4>{{ $pack->name }}</h4>
                                <div class="d-flex flex-column">
                                    <p class="artist">{{ $pack->user->producer_name }}</p>
                                    <button class="buttonv3 mt-3"
                                        onclick="PackDownload(event,'{{ Crypt::encrypt($pack->id) }}')">Download File</button>
                                </div>
                            </a>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            <!-- my melodies  -->
            <div class="my--melodies mt_65">
                <h4 class="small--green--title" data-aos="fade-in" data-aos-duration="1500" data-aos-offset="0">
                    Melodies
                </h4>
                <div class="browse--melodies" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">
                    <!-- top content  -->
                    @include('producer.partials.filter-form')
                    <!-- Melody List Container -->
                    <div id="melodyList">
                        @include('producer.partials.melody-list', ['melodies' => $data['melodies']])
                    </div>
                    <div id="paginationLinks">
                        @include('producer.partials.pagination', ['melodies' => $data['melodies']])
                    </div>
                </div>
            </div>
        </div>
        <!-- producers items area end -->


    </section>

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('producer.my.downloads') }}",
                    type: "GET",
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response);
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
