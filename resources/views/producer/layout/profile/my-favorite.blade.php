@extends('producer.app')

@section('title', 'My Favorites')

@push('style')
@endpush

@section('content')

    <!-- main content start  -->
    <section class="app--content">
        <!-- producers items area start -->
        <div class="producers--items--area">
            <!-- my melodies  -->
            <div class="my--melodies mt_65">
                <h4 class="small--green--title" data-aos="fade-in" data-aos-duration="1500" data-aos-offset="0">
                    My Favorites
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
                    url: "{{ route('producer.my.favorites') }}",
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
