@extends('producer.app')

@section('title', 'Home')

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" />
    <style>
        /* Write Css Under Backend */
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }

        .dropify-wrapper {
            border-radius: 0.8rem !important;
        }

        .text-danger strong {
            font-size: 14px;
        }
    </style>
@endpush

@section('content')

    <!-- main content start  -->
    <section class="app--content">
        <!-- profiile area start -->
        <section class="profile--area">
            <form action="#">
                <!-- cover upload  -->
                <div class="cover--upload" data-aos="fade-in" data-aos-duration="1600">
                    <img id="cover--preview" src="{{ asset(auth()->user()->cover ?? 'backend/images/cover.png') }}"
                        alt="" />
                    <div id="cover-loader" class="upload--loader" style="display: none">
                        <img src="{{ asset('frontend/images/tube-spinner.svg') }}" alt="" />
                    </div>
                    <!-- upload btn  -->
                    <div class="cover-upload--btn">
                        <label for="coverUpload" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">
                            <svg xmlns="http://www.w3.org/2000/svg')}}" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M13.2633 3.59997L5.05327 12.29C4.74327 12.62 4.44327 13.27 4.38327 13.72L4.01327 16.96C3.88327 18.13 4.72327 18.93 5.88327 18.73L9.10327 18.18C9.55327 18.1 10.1833 17.77 10.4933 17.43L18.7033 8.73997C20.1233 7.23997 20.7633 5.52997 18.5533 3.43997C16.3533 1.36997 14.6833 2.09997 13.2633 3.59997Z"
                                    stroke="#FAFAFA" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M11.8906 5.05005C12.3206 7.81005 14.5606 9.92005 17.3406 10.2" stroke="#FAFAFA"
                                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M3 22H21" stroke="#FAFAFA" stroke-width="1.5" stroke-miterlimit="10"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </label>
                        <input type="file" id="coverUpload" data-preview-id="cover--preview"
                            data-loader-id="cover-loader" />
                    </div>
                </div>
                <!-- profile  -->
                <div class="profile">
                    <!-- profile--upload  -->
                    <div class="upload--profile--wrap">
                        <!-- profile upload  -->
                        <div class="profile--upload" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="150">
                            <img id="profile--preview"
                                src="{{ asset(auth()->user()->avatar ?? 'frontend/images/producer3.png') }}"
                                alt="" />
                            <div id="profile-loader" class="upload--loader" style="display: none">
                                <img src="{{ asset('frontend/images/tube-spinner.svg') }}" alt="" />
                            </div>
                            <!-- profile upload  -->
                            <label for="profile--upload">
                                <svg xmlns="http://www.w3.org/2000/svg')}}" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M13.2633 3.59997L5.05327 12.29C4.74327 12.62 4.44327 13.27 4.38327 13.72L4.01327 16.96C3.88327 18.13 4.72327 18.93 5.88327 18.73L9.10327 18.18C9.55327 18.1 10.1833 17.77 10.4933 17.43L18.7033 8.73997C20.1233 7.23997 20.7633 5.52997 18.5533 3.43997C16.3533 1.36997 14.6833 2.09997 13.2633 3.59997Z"
                                        stroke="#FAFAFA" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M11.8906 5.05005C12.3206 7.81005 14.5606 9.92005 17.3406 10.2" stroke="#FAFAFA"
                                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M3 22H21" stroke="#FAFAFA" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </label>
                            <input type="file" id="profile--upload" data-preview-id="profile--preview"
                                data-loader-id="profile-loader" />
                        </div>
                        <div data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">
                            <a href="{{ route('producer.edit.profile') }}" class="buttonv2 following--btn">Edit Profile</a>
                        </div>
                    </div>
                    <!-- profile--details -->
                    <div class="profile--details" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">
                        <!-- name  -->
                        <div class="name">
                            <p>{{ auth()->user()->producer_name }}</p>
                            <span>{{ Number::abbreviate(auth()->user()->followers->count()) }} Followers </span>
                        </div>
                        <p class="desc">
                            {{ auth()->user()->about }}
                        </p>
                        <div class="social--links--wrap">
                            <p data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="150" data-aos-offset="0">
                                Social Links
                            </p>
                            <div class="links">
                                @if (auth()->user()->instagram_username)
                                    <a href="https://www.instagram.com/{{ auth()->user()->instagram_username }}"
                                        target="_blank" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"
                                        data-aos-offset="0">
                                        <img src="{{ asset('frontend/images/insta.png') }}" alt="" width="40"
                                            class="rounded-circle" />
                                    </a>
                                @endif
                                @if (auth()->user()->youtube_username)
                                    <a href="https://www.youtube.com/{{ auth()->user()->youtube_username }}"
                                        target="_blank" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"
                                        data-aos-offset="0">
                                        <img src="{{ asset('frontend/images/youtubeicon.png') }}" alt=""
                                            width="40" class="rounded-circle" />
                                    </a>
                                @endif
                                @if (auth()->user()->beatstars_username)
                                    <a href="https://www.beatstars.com/{{ auth()->user()->beatstars_username }}"
                                        target="_blank" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"
                                        data-aos-offset="0">
                                        <img src="{{ asset('frontend/images/BEATSTARSICON.png') }}" alt=""
                                            width="40" class="rounded-circle" />
                                    </a>
                                @endif
                                @if (auth()->user()->soundee_username)
                                    <a href="https://www.soundee.com/{{ auth()->user()->soundee_username }}"
                                        target="_blank" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"
                                        data-aos-offset="0">
                                        <img src="{{ asset('frontend/images/SOUNDEEICON.png') }}" alt=""
                                            width="40" class="rounded-circle" />
                                    </a>
                                @endif
                                @if (auth()->user()->tiktok_username)
                                    {{-- old way did not worked--}}
                                    {{-- <a href="https://www.tiktok.com/@{{ auth() - > user() - > tiktok_username }}" --}}

                                    {{-- 1st way worked--}}
                                    {{-- <a href="https://www.tiktok.com/{{ '@' . auth()->user()->tiktok_username }}" --}}

                                    {{-- 2nd way --}}
                                    <a href="https://www.tiktok.com/{{ auth()->user()->tiktok_username }}"
     
                                        target="_blank" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="200"
                                        data-aos-offset="0">
                                        <img src="{{ asset('frontend/images/TIKTOKICON.png') }}" alt=""
                                            width="40" class="rounded-circle" />
                                    </a>
                                @endif
                                <div>
                                    <a href="{{ route('producer.edit.profile') }}" style="background-color: #0ccf9f"
                                        class="btn text-white btn-sm rounded-circle">
                                        <i class="bi bi-plus menu-icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- premium pack slider  -->
            @if ($data['packs']->count() > 0)
                <div class="premium--pack--slider">
                    <h3 class="title" data-aos="zoom-in" data-aos-duration="1600">{{ auth()->user()->producer_name }}
                        Premium Packs</h3>
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
            @endif
            <!-- browse--melodies start -->
            <div class="browse--melodies profile--melodies" data-aos="zoom-in" data-aos-duration="1600"
                data-aos-delay="100">
                <!-- top content  -->
                @include('producer.partials.filter-form')
                <!-- all melodies  -->
                <div id="melodyList">
                    @include('producer.partials.melody-list', ['melodies' => $data['melodies']])
                    @include('producer.partials.pagination', ['melodies' => $data['melodies']])
                </div>
            </div>
        </section>
        <!-- profiile area end -->
    </section>

    @component('components.player-component', ['id' => ($id = 1000)])
    @endcomponent





    <div class="modal fade modal-lg" id="SocialMediaModal" tabindex="-1" role="dialog"
        aria-labelledby="SocialMediaModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
                <form method="POST" id="SocialMediaModalForm">
                    <input type="hidden" name="id" id="fileId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="SocialMediaModalTitle">Create Socialmedia</h5>
                        <button type="button" class="close text-light" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body add--new--pack--area  edit--inputs p-5">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="url" class="form-label">URL</label>
                                <input type="text" id="url" placeholder="Ex: https://www.facebook.com"
                                    name="url">
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="icon" class="form-label">Platform Icon</label>
                                <div class=" input--space">
                                    <!-- thumbnail--upload  -->
                                    <div class="thumbnail--upload upload--wrapper">
                                        <input id="fileUpload" type="file" data-preview-id="filePreview"
                                            data-loader-id="file-loader" label-id=".fileUpload">

                                        <label for="fileUpload" class="fileUpload" style="border: none;">
                                            <img src="{{ asset('frontend/images/camera.png') }}" id="initialPrev"
                                                alt="">
                                            <img class="pack--preview--img"
                                                src="{{ asset('frontend/images/camera.png') }}" id="filePreview"
                                                alt="" />
                                            <p class="add--icon-text">Add Icon</p>
                                            <div id="file-loader" class="upload--loader" style="display: none;">
                                                <img src="{{ asset('frontend/images/tube-spinner.svg') }}"
                                                    alt="">
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn buttonv3 close" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn buttonv2">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{-- Dropify CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>


    {{-- Filtering  --}}
    <script>
        $(document).ready(function() {
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('producer.my.items') }}",
                    type: "GET",
                    data: $(this).serialize(),
                    success: function(response) {
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

    <script>
        // Dropify 
        $(document).ready(function() {
            $('.dropify').dropify();
        });

        function CreateSocialmedua(e) {
            e.preventDefault();
            $('#fileId').val('');
            $('#SocialMediaModalTitle').text('Create Socialmedia');
            $('#SocialMediaModalForm')[0].reset();
            let prev = $('#initialPrev');
            prev.attr('src', "{{ asset('frontend/images/camera.png') }}");
            $('.add--icon-text').show();
            $('#url').val('');
            $('#SocialMediaModal').modal('show');
        }


        // Close Modal
        $(document).on('click', '.close', function() {
            $('#SocialMediaModal').modal('hide');
            $('#fileId').val('');
        })





        // Store Socialmedia
        $("#SocialMediaModalForm").submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let url = "{{ route('producer.socialmedia.store') }}";
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success === true) {
                        $('#SocialMediaModal').modal('hide');
                        window.location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(error) { // Added a missing comma here
                    toastr.error(error.responseJSON ? error.responseJSON.message :
                        'An error occurred.');
                }
            });
        });


        function ShowUpdateSocial(e, id) {
            e.preventDefault();

            let url = "{{ route('producer.socialmedia.edit', ':id') }}";
            $.ajax({
                type: "GET",
                url: url.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(resp) {
                    if (resp.success === true) {
                        $('#fileId').val(resp.data.id);
                        $('.add--icon-text').hide();
                        let prev = $('#initialPrev');
                        prev.attr('src', resp.data.icon);
                        $('#url').val(resp.data.url);
                        $('#SocialMediaModalTitle').text('Update Socialmedia');
                        $('#SocialMediaModal').modal('show');
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
