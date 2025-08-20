@extends('producer.app')

@section('title', 'Edit Pack')

@push('style')
    <style>
        .modal .add--new--pack--area .upload--wrapper label {
            height: 280px;
        }

        div:where(.swal2-container) {
            z-index: 10991;

        }
    </style>
@endpush

@section('content')

    <!-- main content start  -->
    <section class="app--content">
        <!-- add new pack area start -->
        <section class="add--new--pack--area" data-aos="zoom-in" data-aos-duration="1600">
            <h2 class="title--lg text-center">Edit {{ $pack->name }} Pack</h2>
            <form method="POST" id="PackForm">
                <input type="hidden" name="id" value="{{ $pack->id }}">
                <div class="row">
                    <div class="col-md-6 input--space">
                        <div class="input--group input--large">
                            <input type="text" placeholder="Name Of The Pack" name="name"
                                value="{{ $pack->name }}" />
                        </div>
                        <div class="valid-feedback text-danger d-block" id="error-name"></div>
                    </div>
                    <div class="col-md-6 input--space">
                        <div class="input--group input--large pack--price">
                            <div class="label">
                                <p>Pack Price</p>
                                $
                            </div>
                            <input type="number" placeholder="00.00" name="price" value="{{ $pack->price }}" />
                        </div>
                        <div class="valid-feedback text-danger d-block" id="error-price"></div>
                    </div>
                    <div class="col-lg-3 col-md-5 input--space">
                        <!-- thumbnail--upload  -->
                        <div class="thumbnail--upload upload--wrapper">
                            <input id="thumbnailUpload" type="file" data-preview-id="profilePreview"
                                data-loader-id="thumbnail-loader" label-id=".thumbnailUpload" name="thumbnail" />
                            <label for="thumbnailUpload" class="thumbnailUpload">
                                <img src="{{ asset('frontend/images/camera.png') }}" alt="" />
                                <p>Add Thumbnail</p>
                                <img class="pack--preview--img d-block" src="{{ $pack->thumbnail }}" id="profilePreview"
                                    alt="" />
                                <div id="thumbnail-loader" class="upload--loader" style="display: none">
                                    <img src="{{ asset('frontend/images/tube-spinner.svg') }}" alt="" />
                                </div>
                            </label>
                            <div class="valid-feedback mt-3 text-danger d-block" id="error-file"></div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-7 input--space">
                        <!-- ZIP upload -->
                        <div class="pack--file--wrapper">
                            <h4 class="pack--title">Sample Pack Upload</h4>
                            <div class="pack--cover--upload upload--wrapper pack--file--upload">
                                <input id="packZipUpload" type="file" data-preview-id="packCoverPreviewZip"
                                    data-loader-id="pack-cover-loaderZip" label-id=".packcoverUpload" accept=".zip"
                                    style="display: none" />
                                <label for="packZipUpload" class="packcoverUpload" id="uploadLabelZip">
                                    <div class="upload--text d-none" id="uploadTextZip">
                                        <img src="{{ asset('frontend/images/upload.svg') }}" alt="Upload Icon" />
                                        <p class="title">
                                            Drag your .zip file to start uploading
                                        </p>
                                        <p class="divider"></p>
                                        <p class="browse-file--btn">Browse files</p>
                                    </div>
                                    <div class="fileDetails d-block" id="fileDetailsZip" style="display: none">
                                        <img src="{{ asset('frontend/images/zip-icon.svg') }}" alt="Zip Icon"
                                            class="zip-icon" />
                                        <p class="filename" id="fileNameZip">{{ $pack->file_name }}</p>
                                    </div>
                                    <div id="pack-cover-loaderZip" class="upload--loader" style="display: none">
                                        <img src="{{ asset('frontend/images/tube-spinner.svg') }}" alt="Loading..." />
                                    </div>
                                </label>
                            </div>
                            <div class="valid-feedback text-danger d-block mt-2" id="error-zipfile"></div>
                        </div>
                    </div>
                    <div class="col-xxl-4 mt_35">
                        <!-- audio-demos--wrapp  -->
                        <div class="audio-demos--wrapp">
                            <!-- titles -->
                            <div class="titles">
                                <h4 class="title--lg">MP3 Audio Demos</h4>
                                <p class="title--sm">
                                    Upload up to 4 Audio Demos to showcase your Pack
                                </p>
                            </div>
                            <!-- MP3 upload -->
                            <div class="pack--cover--upload upload--wrapper pack--audio-demos mt_15" data-purpas="demo">
                                <input id="packAudioUpload" type="file" data-preview-id="packCoverPreviewAudio"
                                    data-loader-id="pack-cover-loaderAudio" label-id=".packcoverUpload" accept=".mp3"
                                    style="display: none" />
                                <label for="packAudioUpload" class="packcoverUpload" id="uploadLabelAudio">
                                    <div class="upload--text" id="uploadTextAudio">
                                        <img src="{{ asset('frontend/images/play-button.svg') }}" alt="Upload Icon" />
                                        <p class="title">
                                            Drag your .mp3 file to start uploading
                                        </p>
                                        <p class="divider"></p>
                                        <p class="browse-file--btn">Browse files</p>
                                    </div>
                                    <div class="fileDetails" id="fileDetailsAudio" style="display: none">
                                        <img src="{{ asset('frontend/images/mp3-icon.svg') }}" alt="MP3 Icon"
                                            class="mp3-icon" />
                                        <p class="filename" id="fileNameAudio"></p>
                                    </div>
                                    <div id="pack-cover-loaderAudio" class="upload--loader" style="display: none">
                                        <img src="{{ asset('frontend/images/tube-spinner.svg') }}" alt="Loading..." />
                                    </div>
                                </label>
                            </div>
                            <p class="upload--warning">Only support .mp3 audio files</p>
                        </div>
                    </div>
                    <div class="col-xxl-8 mt_35">
                        <!-- audio--demos  -->
                        <div class="audio--demos">
                            <h4 class="title">MP3 Audio Demos</h4>
                            <div id="demoMelodyWrapper">
                                @foreach ($pack->melodies as $melody)
                                    <div class="single--melodi" id="demo{{ $melody->id }}">
                                        <!-- melodi  -->
                                        <div class="melodi" data-audio-src="{{ asset($melody->file) }}"
                                            data-audio-id="{{ $melody->id }}">
                                            <div class="playPause--icon playPauseBtn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16"
                                                    viewBox="0 0 12 16" fill="none" id="play-icon">
                                                    <path
                                                        d="M10.272 8.54011L1.40633 14.2546C0.907242 14.5763 0.25 14.218 0.25 13.6242V2.1952C0.25 1.60142 0.90724 1.24311 1.40633 1.56481L10.272 7.27933C10.7302 7.57468 10.7302 8.24476 10.272 8.54011Z"
                                                        fill="#0CCF9F" />
                                                </svg>
                                                <svg width="18px" class="d-none" id="pause-icon" height="18px"
                                                    viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M2 6C2 4.11438 2 3.17157 2.58579 2.58579C3.17157 2 4.11438 2 6 2C7.88562 2 8.82843 2 9.41421 2.58579C10 3.17157 10 4.11438 10 6V18C10 19.8856 10 20.8284 9.41421 21.4142C8.82843 22 7.88562 22 6 22C4.11438 22 3.17157 22 2.58579 21.4142C2 20.8284 2 19.8856 2 18V6Z"
                                                        fill="#1C274C" />
                                                    <path
                                                        d="M14 6C14 4.11438 14 3.17157 14.5858 2.58579C15.1716 2 16.1144 2 18 2C19.8856 2 20.8284 2 21.4142 2.58579C22 3.17157 22 4.11438 22 6V18C22 19.8856 22 20.8284 21.4142 21.4142C20.8284 22 19.8856 22 18 22C16.1144 22 15.1716 22 14.5858 21.4142C14 20.8284 14 19.8856 14 18V6Z"
                                                        fill="#1C274C" />
                                                </svg>
                                            </div>
                                            <!-- producer  -->
                                            <div class="producer">
                                                <input type="hidden" name="demo_id[]" value="{{ $melody->id }}">
                                                <h4 class="text-capitalize">
                                                    {{ $melody->file_name }}
                                                </h4>
                                                <p class="text-capitalize">{{ $melody->name }}</p>
                                            </div>
                                            <div class="wave"></div>
                                            <div class="time-display">00:00</div>
                                        </div>
                                        <!-- action-and--details  -->
                                        <div class="action-and--details">
                                            <div class="action">
                                                <button onclick="ShowEditModal(event,this,{{ $melody->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13"
                                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path
                                                            d="M16.0379 3.02025L8.15793 10.9003C7.85793 11.2003 7.55793 11.7903 7.49793 12.2203L7.06793 15.2303C6.90793 16.3203 7.67793 17.0803 8.76793 16.9303L11.7779 16.5003C12.1979 16.4403 12.7879 16.1403 13.0979 15.8403L20.9779 7.96025C22.3379 6.60025 22.9779 5.02025 20.9779 3.02025C18.9779 1.02025 17.3979 1.66025 16.0379 3.02025Z"
                                                            stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path
                                                            d="M14.9062 4.15039C15.5763 6.54039 17.4463 8.41039 19.8463 9.09039"
                                                            stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </button>

                                                <button onclick="ShowDeleteAlert(event,this,{{ $melody->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
                                                        <g clip-path="url(#clip0_8923_1234)">
                                                            <path
                                                                d="M17.4974 3.33333H14.9141C14.7207 2.39284 14.2089 1.54779 13.4651 0.940598C12.7213 0.333408 11.7909 0.0012121 10.8307 0L9.16406 0C8.20389 0.0012121 7.2735 0.333408 6.52969 0.940598C5.78588 1.54779 5.27414 2.39284 5.08073 3.33333H2.4974C2.27638 3.33333 2.06442 3.42113 1.90814 3.57741C1.75186 3.73369 1.66406 3.94565 1.66406 4.16667C1.66406 4.38768 1.75186 4.59964 1.90814 4.75592C2.06442 4.9122 2.27638 5 2.4974 5H3.33073V15.8333C3.33205 16.938 3.77146 17.997 4.55258 18.7781C5.3337 19.5593 6.39274 19.9987 7.4974 20H12.4974C13.6021 19.9987 14.6611 19.5593 15.4422 18.7781C16.2233 17.997 16.6627 16.938 16.6641 15.8333V5H17.4974C17.7184 5 17.9304 4.9122 18.0867 4.75592C18.2429 4.59964 18.3307 4.38768 18.3307 4.16667C18.3307 3.94565 18.2429 3.73369 18.0867 3.57741C17.9304 3.42113 17.7184 3.33333 17.4974 3.33333ZM9.16406 1.66667H10.8307C11.3476 1.6673 11.8517 1.82781 12.2737 2.1262C12.6958 2.42459 13.0152 2.84624 13.1882 3.33333H6.80656C6.97955 2.84624 7.29898 2.42459 7.72105 2.1262C8.14313 1.82781 8.64717 1.6673 9.16406 1.66667ZM14.9974 15.8333C14.9974 16.4964 14.734 17.1323 14.2652 17.6011C13.7963 18.0699 13.1604 18.3333 12.4974 18.3333H7.4974C6.83436 18.3333 6.19847 18.0699 5.72963 17.6011C5.26079 17.1323 4.9974 16.4964 4.9974 15.8333V5H14.9974V15.8333Z"
                                                                fill="white" />
                                                            <path
                                                                d="M8.33333 14.9997C8.55434 14.9997 8.76631 14.9119 8.92259 14.7556C9.07887 14.5993 9.16666 14.3874 9.16666 14.1663V9.16634C9.16666 8.94533 9.07887 8.73337 8.92259 8.57709C8.76631 8.42081 8.55434 8.33301 8.33333 8.33301C8.11232 8.33301 7.90036 8.42081 7.74408 8.57709C7.5878 8.73337 7.5 8.94533 7.5 9.16634V14.1663C7.5 14.3874 7.5878 14.5993 7.74408 14.7556C7.90036 14.9119 8.11232 14.9997 8.33333 14.9997Z"
                                                                fill="white" />
                                                            <path
                                                                d="M11.6693 14.9997C11.8903 14.9997 12.1023 14.9119 12.2585 14.7556C12.4148 14.5993 12.5026 14.3874 12.5026 14.1663V9.16634C12.5026 8.94533 12.4148 8.73337 12.2585 8.57709C12.1023 8.42081 11.8903 8.33301 11.6693 8.33301C11.4483 8.33301 11.2363 8.42081 11.08 8.57709C10.9237 8.73337 10.8359 8.94533 10.8359 9.16634V14.1663C10.8359 14.3874 10.9237 14.5993 11.08 14.7556C11.2363 14.9119 11.4483 14.9997 11.6693 14.9997Z"
                                                                fill="white" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_8923_1234">
                                                                <rect width="20" height="20" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="valid-feedback text-danger d-block mt-2" id="error-demo_id"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt_35">
                        <!-- promo-videoUrl--box  -->
                        <div class="promo-videoUrl--box">
                            <label for="promoUrl" class="mb_15 title ml_25">Promo Video URL</label>
                            <div class="input--group input--large">
                                <input type="text" id="promoUrl" placeholder="YouTube or Vimeo video URL"
                                    name="promoUrl" value="{{ $pack->promo_video_url }}" />
                            </div>
                            <div class="valid-feedback text-danger d-block" id="error-promoUrl"></div>
                        </div>
                        <!-- pack--genres  -->
                        <div class="pack--genres--wrapp mt_15">
                            <h4 class="title ml_25">Pack Genres</h4>
                            <!-- pack--genres  -->
                            <div class="pack--genres">
                                <ul class="all--added--genres">
                                    @foreach ($pack->packGenrese as $genres)
                                        <li>
                                            {{ $genres->title }}
                                            <input type="hidden" name="genres[]" value="{{ $genres->id }}">
                                            <span class="close-icon">×</span>
                                        </li>
                                    @endforeach
                                    <div class="add--genres addGenresWrapp">
                                        <!-- toggle -->
                                        <p class="trigger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24"
                                                viewBox="0 0 27 24" fill="none">
                                                <path d="M6.75 12H20.25" stroke="#FCFDFF" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M13.5 18V6" stroke="#FCFDFF" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </p>
                                        <ul class="genres--dropdown common--dropdown">
                                            @foreach ($genrises as $genre)
                                                <li data-item="genres" data-value="{{ $genre->id }}">
                                                    {{ $genre->title }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </ul>
                            </div>
                            <div class="valid-feedback text-danger d-block mb-2" id="error-genres"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt_35">
                        <!-- pack--feature  -->
                        <div class="pack--feature">
                            <h4 class="title ml_25">What’s included on this pack</h4>
                            <div class="features" id="#editor-container">
                                {{-- id="description" was problem , now i fixed this problem. this id is worked but only for light mode: id="editor" --}}
                                <textarea name="description" id="editor" class="form-control bg-transparent outline-none border-0"
                                    style="color: black" cols="30" rows="10"
                                    placeholder="Example: This pack includes 300 High Quality Samples">{{ $pack->description }}</textarea>
                                <div class="valid-feedback text-danger d-block mt-2" id="error-description"></div>

                                <div class="valid-feedback text-danger d-block mt-2" id="error-description"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- add--melodies -->
                <!-- uplod--pack--area  -->
                <div class="uplod--pack--area">
                    <div class="input--group custom-checkbox">
                        <input id="terms" type="checkbox" name="terms" checked />
                        <label for="terms">
                            By continuing to upload you are ensuring that all the details
                            above are your own creation and if it reveals that you are not
                            associated with it, Melody Collab will not be associated with
                            you. Please check the
                            <a href="#">privacy and policy</a>
                            page to get everything clear to you.
                        </label>
                    </div>
                    <div class="text-start valid-feedback text-danger d-block" id="error-terms"></div>
                    <button type="submit" class="button w-100 text-center mt_35">
                        Save
                    </button>
                </div>
            </form>
        </section>
        <!-- add new pack area end -->

        @component('components.player-component')
        @endcomponent


    </section>
    <!-- main content end  -->
    <div class="modal fade modal-xl" id="DemoModal" tabindex="-1" role="dialog" aria-labelledby="DemoModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
                <form method="POST" id="DemoModalForm">
                    <input type="hidden" name="id" id="demoId">
                    <div class="modal-header">
                        <h5 class="modal-title" id="DemoModalTitle">Create Demo</h5>
                        <button type="button" class="close text-light" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body add--new--pack--area  edit--inputs p-5">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="melody-name" class="text-capitalize"
                                    placeholder="FrancisGotHeat - Anytime" name="name">
                                <div class="valid-feedback text-danger d-block" id="error-name"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="input--space">
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
                                            <p class="add--icon-text">Add Thumbnail For demo</p>
                                            <div id="file-loader" class="upload--loader" style="display: none;">
                                                <img src="{{ asset('frontend/images/tube-spinner.svg') }}"
                                                    alt="">
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 input--space">
                                <!-- ZIP upload -->
                                <div class="pack--file--wrapper">
                                    <h4 class="pack--title">Upload Melody</h4>
                                    <div class="pack--cover--upload upload--wrapper pack-melody-upload p-5"
                                        id="zipWrapper">
                                        <input id="packZipUpload" type="file" data-preview-id="packCoverPreviewZip"
                                            data-loader-id="pack-cover-loaderZip" label-id=".packcoverUpload"
                                            accept=".mp3,.wav,.aac,.ogg,.flac,.m4a,.wma,.aiff,.alac,.opus,.amr"
                                            style="display: none" />
                                        <label for="packZipUpload" class="packcoverUpload" id="uploadLabelZip">
                                            <div class="upload--text" id="uploadTextZip">
                                                <img src="{{ asset('frontend/images/play-button.svg') }}"
                                                    alt="Upload Icon" />
                                                <p class="title">
                                                    Drag your .mp3,.wav,.aac,.ogg,.flac,.m4a,.wma,.aiff,.alac,.opus,.amr
                                                    file to start uploading
                                                </p>
                                                <p class="divider"></p>
                                                <p class="browse-file--btn">Browse files</p>
                                            </div>
                                            <div class="fileDetails" id="fileDetailsZip" style="display: none">
                                                <img src="{{ asset('frontend/images/mp3-icon.svg') }}" alt="Zip Icon"
                                                    class="zip-icon" />
                                                <p class="filename" id="fileNameZip"></p>
                                            </div>
                                            <div id="pack-cover-loaderZip" class="upload--loader" style="display: none">
                                                <img src="{{ asset('frontend/images/tube-spinner.svg') }}"
                                                    alt="Loading..." />
                                            </div>
                                        </label>
                                        <div class="valid-feedback text-center text-danger d-block" id="error-zipfile">
                                        </div>
                                    </div>
                                </div>
                                <div class="valid-feedback mt-3 text-danger d-block " id="error-zipfile"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Ck Editor --}}
    <script src="{{ asset('Backend/plugins/tinymc/tinymce.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['bold', 'italic', 'link','blockQuote'],
                // Set up editor styles
                editorConfig: {
                    styles: {
                        '.ck-content': {
                            'background-color': 'black',
                            'color': 'white',
                        }
                    }
                },
                // Additional configuration if needed
                ui: {
                    view: {
                        editable: {
                            element: document.querySelector('#editor'),
                        },
                    },
                }
            })
            .then(editor => {
                // Force black background and white text color consistently
                editor.ui.view.editable.element.style.backgroundColor = 'black';
                editor.ui.view.editable.element.style.color = 'white';
                // Ensure ck-content class applies the style inside the editing area
                editor.editing.view.change(writer => {
                    writer.setStyle('background-color', 'black', editor.editing.view.document.getRoot());
                    writer.setStyle('color', 'white', editor.editing.view.document.getRoot());
                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        // it also editor
        $(function() {
            const tinymceOptions = {
                selector: '#description',
                menubar: false,
                statusbar: false,
                toolbar_sticky: true,
                draggable_modal: true,
                plugins: [
                    'advlist', 'autolink', 'lists', 'charmap', 'image', 'anchor', 'wordcount', 'autosave',
                    'link', 'preview', 'code',
                ],
                toolbar: 'styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | forecolor backcolor emoticons | image link code | blockquote | undo redo',
                contextmenu: 'bold italic underline copy paste',
                // This applies CSS to the content (the text area where the user types)
                content_style: `
                            body {
                                background-color: #1c1c1c !important;
                                color: #fff !important;
                                font-family: Arial, sans-serif;
                            }
                            p, li {
                                color: #fff !important;
                            }

                        `,

                // You can either include a custom CSS file or inline the styles for the TinyMCE UI (toolbar, buttons, etc.)
                content_css: false,
                setup: function(editor) {
                    editor.ui.registry.addContextToolbar('textselection', {
                        predicate: function(node) {
                            return !editor.selection.isCollapsed();
                        },
                        items: 'bold italic underline | bullist numlist blockquote | copy paste',
                        position: 'selection',
                        scope: 'node'
                    });

                    editor.ui.registry.addIcon('icon',
                        '<svg width="24" height="24" focusable="false"><g clip-path="url(#a)"><path fill-rule="evenodd" clip-rule="evenodd" d="M15 6.7a1 1 0 0 0-1.4 0l-9.9 10a1 1 0 0 0 0 1.3l2.1 2.1c.4.4 1 .4 1.4 0l10-9.9c.3-.3.3-1 0-1.4l-2.2-2Zm1.4 2.8-2-2-3 2.7 2.2 2.2 2.8-2.9Z" fill="#007bff"></path><path d="m18.5 7.3-.7-1.5-1.5-.8 1.5-.7.7-1.5.7 1.5 1.5.7-1.5.8-.7 1.5ZM18.5 16.5l-.7-1.6-1.5-.7 1.5-.7.7-1.6.7 1.6 1.5.7-1.5.7-.7 1.6ZM9.7 7.3 9 5.8 7.5 5 9 4.3l.7-1.5.7 1.5L12 5l-1.5.8-.7 1.5Z" fill="#007bff"></path></g><defs><clipPath id="a"><path d="M0 0h24v24H0z"></path></clipPath></defs></svg>'
                    );
                    editor.ui.registry.addIcon('iconMain',
                        '<svg width="24" height="24" focusable="false"><path fill-rule="evenodd" clip-rule="evenodd" d="M5 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H5Zm6.8 11.5.5 1.2a68.3 68.3 0 0 0 .7 1.1l.4.1c.3 0 .5 0 .7-.3.2-.1.3-.3.3-.6l-.3-1-2.6-6.2a20.4 20.4 0 0 0-.5-1.3l-.5-.4-.7-.2c-.2 0-.5 0-.6.2-.2 0-.4.2-.5.4l-.3.6-.3.7L5.7 15l-.2.6-.1.4c0 .3 0 .5.3.7l.6.2c.3 0 .5 0 .7-.2l.4-1 .5-1.2h3.9ZM9.8 9l1.5 4h-3l1.5-4Zm5.6-.9v7.6c0 .4 0 .7.2 1l.7.2c.3 0 .6 0 .8-.3l.2-.9V8.1c0-.4 0-.7-.2-.9a1 1 0 0 0-.8-.3c-.2 0-.5.1-.7.3l-.2 1Z" fill="#007bff"></path></svg>'
                    );
                    editor.ui.registry.addIcon('iconRewrite',
                        '<svg width="16px" height="16px" viewBox="0 -0.5 21 21" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#007bff" stroke="#007bff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>edit_cover [#1481]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-419.000000, -359.000000)" fill="#007bff"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M384,209.210475 L384,219 L363,219 L363,199.42095 L373.5,199.42095 L373.5,201.378855 L365.1,201.378855 L365.1,217.042095 L381.9,217.042095 L381.9,209.210475 L384,209.210475 Z M370.35,209.51395 L378.7731,201.64513 L380.4048,203.643172 L371.88195,212.147332 L370.35,212.147332 L370.35,209.51395 Z M368.25,214.105237 L372.7818,214.105237 L383.18415,203.64513 L378.8298,199 L368.25,208.687714 L368.25,214.105237 Z" id="edit_cover-[#1481]"> </path> </g> </g> </g> </g></svg>'
                    );
                    editor.ui.registry.addIcon('iconSummarize',
                        '<svg width="20px" height="20px" viewBox="0 0 24 24" fill="none!important" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect width="24" height="24" fill="white"></rect> <path d="M12 6.90909C10.8999 5.50893 9.20406 4.10877 5.00119 4.00602C4.72513 3.99928 4.5 4.22351 4.5 4.49965C4.5 6.54813 4.5 14.3034 4.5 16.597C4.5 16.8731 4.72515 17.09 5.00114 17.099C9.20405 17.2364 10.8999 19.0998 12 20.5M12 6.90909C13.1001 5.50893 14.7959 4.10877 18.9988 4.00602C19.2749 3.99928 19.5 4.21847 19.5 4.49461C19.5 6.78447 19.5 14.3064 19.5 16.5963C19.5 16.8724 19.2749 17.09 18.9989 17.099C14.796 17.2364 13.1001 19.0998 12 20.5M12 6.90909L12 20.5" stroke="#007bff" stroke-linejoin="round" fill="none"></path> <path d="M19.2353 6H21.5C21.7761 6 22 6.22386 22 6.5V19.539C22 19.9436 21.5233 20.2124 21.1535 20.0481C20.3584 19.6948 19.0315 19.2632 17.2941 19.2632C14.3529 19.2632 12 21 12 21C12 21 9.64706 19.2632 6.70588 19.2632C4.96845 19.2632 3.64156 19.6948 2.84647 20.0481C2.47668 20.2124 2 19.9436 2 19.539V6.5C2 6.22386 2.22386 6 2.5 6H4.76471" stroke="#007bff" stroke-linejoin="round" fill="none"></path> </g></svg>'
                    );
                    editor.ui.registry.addIcon('iconSimplify',
                        '<svg width="17px" height="17px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="journal" transform="translate(-124 -62)"> <path id="Path_94" data-name="Path 94" d="M130,93a4,4,0,0,0,4-4V63h21V89a4,4,0,0,1-4,4H130a5,5,0,0,1-5-5V82h9" fill="none" stroke="#498efc" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path> <line id="Line_48" data-name="Line 48" x2="17" transform="translate(138 89)" fill="none" stroke="#498efc" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></line> <line id="Line_49" data-name="Line 49" x1="9" transform="translate(140 70)" fill="none" stroke="#f1d17c" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></line> <line id="Line_50" data-name="Line 50" x1="9" transform="translate(140 74)" fill="none" stroke="#f1d17c" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></line> <line id="Line_51" data-name="Line 51" x1="9" transform="translate(140 78)" fill="none" stroke="#f1d17c" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></line> <line id="Line_52" data-name="Line 52" x1="9" transform="translate(140 82)" fill="none" stroke="#f1d17c" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></line> </g> </g></svg>'
                    );
                    editor.ui.registry.addIcon('iconExpand',
                        '<svg style="fill:none;" width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <g clip-path="url(#clip0_3443_218)"> <path d="M3.1665 12.375H15.8332" stroke="#007bff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M3.1665 4.45833C3.1665 4.24837 3.24991 4.047 3.39838 3.89854C3.54684 3.75007 3.74821 3.66666 3.95817 3.66666H7.12484C7.3348 3.66666 7.53616 3.75007 7.68463 3.89854C7.8331 4.047 7.9165 4.24837 7.9165 4.45833V7.625C7.9165 7.83496 7.8331 8.03632 7.68463 8.18479C7.53616 8.33326 7.3348 8.41666 7.12484 8.41666H3.95817C3.74821 8.41666 3.54684 8.33326 3.39838 8.18479C3.24991 8.03632 3.1665 7.83496 3.1665 7.625V4.45833Z" stroke="#007bff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M3.1665 16.3333H12.6665" stroke="#007bff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </g> <defs> <clipPath id="clip0_3443_218"> <rect width="19" height="19" fill="white" transform="translate(0 0.5)"/> </clipPath> </defs> </svg>'
                    );
                    editor.ui.registry.addIcon('iconTrim',
                        '<svg style="fill:none!important;" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"> <g clip-path="url(#clip0_3443_226)"> <path d="M2.25 5.25C2.25 5.84674 2.48705 6.41903 2.90901 6.84099C3.33097 7.26295 3.90326 7.5 4.5 7.5C5.09674 7.5 5.66903 7.26295 6.09099 6.84099C6.51295 6.41903 6.75 5.84674 6.75 5.25C6.75 4.65326 6.51295 4.08097 6.09099 3.65901C5.66903 3.23705 5.09674 3 4.5 3C3.90326 3 3.33097 3.23705 2.90901 3.65901C2.48705 4.08097 2.25 4.65326 2.25 5.25Z" stroke="#007bff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M2.25 12.75C2.25 13.3467 2.48705 13.919 2.90901 14.341C3.33097 14.7629 3.90326 15 4.5 15C5.09674 15 5.66903 14.7629 6.09099 14.341C6.51295 13.919 6.75 13.3467 6.75 12.75C6.75 12.1533 6.51295 11.581 6.09099 11.159C5.66903 10.7371 5.09674 10.5 4.5 10.5C3.90326 10.5 3.33097 10.7371 2.90901 11.159C2.48705 11.581 2.25 12.1533 2.25 12.75Z" stroke="#007bff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6.4502 6.45L14.2502 14.25" stroke="#007bff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path d="M6.4502 11.55L14.2502 3.75" stroke="#007bff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </g> <defs> <clipPath id="clip0_3443_226"> <rect width="18" height="18" fill="white"/> </clipPath> </defs> </svg>'
                    );
                    editor.ui.registry.addIcon('iconImprove',
                        '<svg width="20px" height="20px" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Interface / Check_All_Big"> <path id="Vector" d="M7 12L11.9497 16.9497L22.5572 6.34326M2.0498 12.0503L6.99955 17M17.606 6.39355L12.3027 11.6969" stroke="#007bff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="white"></path> </g> </g></svg>'
                    );
                    editor.ui.registry.addIcon('iconFixGrammer',
                        '<svg width="20px" height="20px" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 12.5L3.84375 9.5M3.84375 9.5L5 5.38889C5 5.38889 5.25 4.5 6 4.5C6.75 4.5 7 5.38889 7 5.38889L8.15625 9.5M3.84375 9.5H8.15625M9 12.5L8.15625 9.5M13 16.8333L15.4615 19.5L21 13.5M12 8.5H15C16.1046 8.5 17 7.60457 17 6.5C17 5.39543 16.1046 4.5 15 4.5H12V8.5ZM12 8.5H16C17.1046 8.5 18 9.39543 18 10.5C18 11.6046 17.1046 12.5 16 12.5H12V8.5Z" stroke="#008bff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="white"></path> </g></svg>'
                    );
                    editor.ui.registry.addIcon('iconTone',
                        '<svg width="18px" height="18px" viewBox="0 -0.5 21 21" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#007bff" stroke="#007bff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>edit_text_bar [#1372]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-379.000000, -800.000000)" fill="#007bff"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M327.2,654 L325.1,654 L325.1,646 L327.2,646 L327.2,644 L323,644 L323,656 L327.2,656 L327.2,654 Z M333.5,644 L333.5,646 L341.9,646 L341.9,654 L333.5,654 L333.5,656 L344,656 L344,644 L333.5,644 Z M331.4,658 L333.5,658 L333.5,660 L327.2,660 L327.2,658 L329.3,658 L329.3,642 L327.2,642 L327.2,640 L333.5,640 L333.5,642 L331.4,642 L331.4,658 Z" id="edit_text_bar-[#1372]"> </path> </g> </g> </g> </g></svg>'
                    );
                    editor.ui.registry.addIcon('iconStyle',
                        '<svg fill="#007bff" width="18px"  height="18px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg" stroke="#007bff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M517.257 1127.343c72.733 0 148.871 36.586 221.274 107.45 87.455 110.418 114.922 204.135 81.632 278.296-72.733 162.274-412.664 234.897-618.666 259.178 34.609-82.62 75.15-216.88 75.15-394.645 0-97.123 66.47-195.455 157.88-233.689 26.698-11.097 54.494-16.59 82.73-16.59Zm229.404-167.109c54.055 28.895 106.462 65.371 155.133 113.494l13.844 15.6c28.016 35.378 50.649 69.987 70.425 104.155-29.554 26.259-59.878 52.737-90.75 79.545-18.898-35.488-43.069-71.964-72.843-109.319l-4.285-4.834c-48.342-47.683-99.43-83.39-151.727-107.011 26.368-30.653 53.066-61.196 80.203-91.63Zm1046.49-803.133c7.801 7.8 18.129 21.754 16.92 52.187-6.043 155.683-284.338 494.405-740.509 909.266-19.995-32.302-41.969-64.822-67.788-97.453l-22.523-25.27c-49.22-48.671-101.408-88.883-156.012-121.074 350.588-385.855 728.203-734.356 910.254-741.828 30.983-.109 44.497 9.01 59.658 24.172Zm126.678 56.472c2.087-53.615-14.832-99.98-56.142-141.29-34.28-34.279-81.962-51.198-134.588-49.11-304.554 12.414-912.232 683.377-1179.54 996.17-53.616-5.383-106.682 2.088-157.441 23.402-132.61 55.263-225.339 193.038-225.339 334.877 0 268.517-103.935 425.737-104.923 427.275L0 1896.747l110.307-6.153c69.217-3.735 681.29-45.375 810.165-332.46 24.39-54.604 29.225-113.163 15.93-175.239 374.32-321.802 972.11-879.71 983.427-1169.322" fill="#007bff"></path> </g></svg>'
                    );
                    editor.ui.registry.addIcon('iconTranslate',
                        '<svg fill="#007bff" width="21px" fill="none!important" height="21px" viewBox="0 -64 640 640" xmlns="http://www.w3.org/2000/svg" stroke="#007bff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M152.1 236.2c-3.5-12.1-7.8-33.2-7.8-33.2h-.5s-4.3 21.1-7.8 33.2l-11.1 37.5H163zM616 96H336v320h280c13.3 0 24-10.7 24-24V120c0-13.3-10.7-24-24-24zm-24 120c0 6.6-5.4 12-12 12h-11.4c-6.9 23.6-21.7 47.4-42.7 69.9 8.4 6.4 17.1 12.5 26.1 18 5.5 3.4 7.3 10.5 4.1 16.2l-7.9 13.9c-3.4 5.9-10.9 7.8-16.7 4.3-12.6-7.8-24.5-16.1-35.4-24.9-10.9 8.7-22.7 17.1-35.4 24.9-5.8 3.5-13.3 1.6-16.7-4.3l-7.9-13.9c-3.2-5.6-1.4-12.8 4.2-16.2 9.3-5.7 18-11.7 26.1-18-7.9-8.4-14.9-17-21-25.7-4-5.7-2.2-13.6 3.7-17.1l6.5-3.9 7.3-4.3c5.4-3.2 12.4-1.7 16 3.4 5 7 10.8 14 17.4 20.9 13.5-14.2 23.8-28.9 30-43.2H412c-6.6 0-12-5.4-12-12v-16c0-6.6 5.4-12 12-12h64v-16c0-6.6 5.4-12 12-12h16c6.6 0 12 5.4 12 12v16h64c6.6 0 12 5.4 12 12zM0 120v272c0 13.3 10.7 24 24 24h280V96H24c-13.3 0-24 10.7-24 24zm58.9 216.1L116.4 167c1.7-4.9 6.2-8.1 11.4-8.1h32.5c5.1 0 9.7 3.3 11.4 8.1l57.5 169.1c2.6 7.8-3.1 15.9-11.4 15.9h-22.9a12 12 0 0 1-11.5-8.6l-9.4-31.9h-60.2l-9.1 31.8c-1.5 5.1-6.2 8.7-11.5 8.7H70.3c-8.2 0-14-8.1-11.4-15.9z" fill="#007bff"></path></g></svg>'
                    );

                    editor.on('ContextMenu', function(e) {
                        $(".tox-collection").remove();
                        setTimeout(() => {
                            $('.tox-collection').css('width', '240px');
                            $('.tox-collection').css('padding', '0px 16px');
                            $($('.tox-collection__group')[0].querySelector('#custom_label'))
                                .remove();
                            $($('.tox-collection__group')[1].querySelector('#quick_label'))
                                .remove();
                            $($('.tox-collection__group')[0]).prepend(
                                '<p class="tox-custom-label" id="custom_label">Custom Action</p>'
                            );
                            $($('.tox-collection__group')[1]).prepend(
                                '<p class="tox-custom-label mt-2" id="quick_label">Quick Actions</p>'
                            );
                        }, 0);
                    });

                    const styleTag = document.createElement("style");
                    styleTag.innerHTML = `
                        .tox-tinymce, .tox-tinymce-aux, .tox .tox-toolbar, .tox-toolbar__primary, .tox-toolbar__overflow {
                            background-color: #1c1c1c !important;  /* Dark toolbar background */
                        }

                        .tox .tox-button, .tox .tox-button svg, .tox .tox-toolbar__group {
                            background-color: #1c1c1c !important;  /* Toolbar button background */
                            color: #fff !important;                /* Button text color */
                        }

                        .tox .tox-button:hover, .tox .tox-button--enabled:hover {
                            background-color: #333 !important;     /* Button hover state */
                        }

                        .tox .tox-editor-header, .tox .tox-statusbar {
                            background-color: #1c1c1c !important;  /* Statusbar and header background */
                            color: #fff !important;                /* Statusbar text color */
                        }

                        .tox .tox-toolbar__primary svg, .tox .tox-toolbar__group svg {
                            fill: #fff !important;  /* White icons on toolbar buttons */
                        }

                        .tox-tinymce {
                            border-color: #333 !important;  /* Editor border color */
                        }

                        .tox-tinymce .tox-editor-container, .tox .tox-toolbar {
                            border-color: #333 !important;  /* Border between toolbar and editor */
                        }
                        .tox .tox-tbtn--bespoke {
                            background: #1c1c1c !important;
                            color: #fff !important;
                        }
                        .tox .tox-menu {
                            background-color: #1c1c1c !important;
                            color: #fff !important;
                        }
                        .tox .tox-collection__item {
                            color: white !important;
                        }
                        .tox .tox-collection--list .tox-collection__item--active:not(.tox-collection__item--state-disabled) {
                            color: #222f3e !important;
                        }
                    `;
                    document.head.appendChild(styleTag);
                }
            };

            tinyMCE.init(tinymceOptions);
        });

        $('.close-icon').on('click', function(e) {
            $(this).closest('li').remove();
        })
    </script>

    {{-- For Demo JS --}}
    <script>
        $(document).ready(function() {
            $('#createAudioDemo').on("click", function() {
                // $('#pack--preview--img')[0].hide();
                // $('.zip-icon')[0].src = "{{ asset('frontend/images/play-button.svg') }}";
                $('#DemoModal').modal('show');
            });
        });

        // formatTime
        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = Math.floor(seconds % 60);

            return `${minutes}:${
                        remainingSeconds < 10 ? "0" : ""
                    }${remainingSeconds}`;
        }


        // Wave Init
        function waveInit(audioSrc, demo) {
            console.log(demo);
            const melody = $(`#${demo}`)[0]; // Convert jQuery object to plain DOM element
            const waveContainer = melody.querySelector(".wave");
            let TotalTimeDisplay = melody.querySelector(".time-display");
            const waveSurfer = WaveSurfer.create({
                container: waveContainer,
                waveColor: "#c3c3c3",
                progressColor: "#0ccf9f",
                height: 35,
                cursorColor: "#0ccf9f",
                barRadius: 10,
                interact: false,
            });
            waveSurfer.load(audioSrc);
            waveSurfer.on("ready", function() {
                const duration = waveSurfer.getDuration();

                TotalTimeDisplay.textContent = formatTime(duration);
            });
        }

        // {{-- Create Demo Video --}}
        $('#DemoModalForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('producer.pack.demo.store') }}",
                data: new FormData(this),
                cache: false,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    if (response.success == true) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            // Append Data on Table
                            $('#DemoModal').modal('hide');
                            $('#DemoModalForm')[0].reset();

                            let Existingdemo = $(`#demo${response.data.id}`);
                            if (Existingdemo) {
                                Existingdemo.remove();
                            }


                            let MelodyWrapper = $('#demoMelodyWrapper');
                            let html = `
                                <div class="single--melodi" id="demo${response.data.id}">
                                <!-- melodi  -->
                                <div class="melodi" data-audio-src="{{ url('/') }}${response.data.file}" data-audio-id="${response.data.id}">
                                    <img class="melodi--img" src="${response.data.thumbnail}"
                                        alt="" />
                                    <div class="playPause--icon playPauseBtn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16"
                                            viewBox="0 0 12 16" fill="none" id="play-icon">
                                            <path
                                                d="M10.272 8.54011L1.40633 14.2546C0.907242 14.5763 0.25 14.218 0.25 13.6242V2.1952C0.25 1.60142 0.90724 1.24311 1.40633 1.56481L10.272 7.27933C10.7302 7.57468 10.7302 8.24476 10.272 8.54011Z"
                                                fill="#0CCF9F" />
                                        </svg>
                                        <svg width="18px" class="d-none" id="pause-icon" height="18px"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2 6C2 4.11438 2 3.17157 2.58579 2.58579C3.17157 2 4.11438 2 6 2C7.88562 2 8.82843 2 9.41421 2.58579C10 3.17157 10 4.11438 10 6V18C10 19.8856 10 20.8284 9.41421 21.4142C8.82843 22 7.88562 22 6 22C4.11438 22 3.17157 22 2.58579 21.4142C2 20.8284 2 19.8856 2 18V6Z"
                                                fill="#1C274C" />
                                            <path
                                                d="M14 6C14 4.11438 14 3.17157 14.5858 2.58579C15.1716 2 16.1144 2 18 2C19.8856 2 20.8284 2 21.4142 2.58579C22 3.17157 22 4.11438 22 6V18C22 19.8856 22 20.8284 21.4142 21.4142C20.8284 22 19.8856 22 18 22C16.1144 22 15.1716 22 14.5858 21.4142C14 20.8284 14 19.8856 14 18V6Z"
                                                fill="#1C274C" />
                                        </svg>
                                    </div>
                                    <!-- producer  -->
                                    <div class="producer">
                                        <input type="hidden" name="demo_id[]" value="${response.data.id}">
                                        <h4>
                                            ${response.data.file_name}
                                        </h4>
                                        <p>${response.data.name}</p>
                                    </div>
                                    <div class="wave"></div>
                                    <div class="time-display">00:00</div>
                                </div>
                                <!-- action-and--details  -->
                                <div class="action-and--details">
                                    <div class="action">
                                        <button onclick="ShowEditModal(event,this,${response.data.id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13"
                                                    stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M16.0379 3.02025L8.15793 10.9003C7.85793 11.2003 7.55793 11.7903 7.49793 12.2203L7.06793 15.2303C6.90793 16.3203 7.67793 17.0803 8.76793 16.9303L11.7779 16.5003C12.1979 16.4403 12.7879 16.1403 13.0979 15.8403L20.9779 7.96025C22.3379 6.60025 22.9779 5.02025 20.9779 3.02025C18.9779 1.02025 17.3979 1.66025 16.0379 3.02025Z"
                                                    stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M14.9062 4.15039C15.5763 6.54039 17.4463 8.41039 19.8463 9.09039"
                                                    stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>

                                        <button onclick="ShowDeleteAlert(event,this,${response.data.id})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <g clip-path="url(#clip0_8923_1234)">
                                                    <path
                                                        d="M17.4974 3.33333H14.9141C14.7207 2.39284 14.2089 1.54779 13.4651 0.940598C12.7213 0.333408 11.7909 0.0012121 10.8307 0L9.16406 0C8.20389 0.0012121 7.2735 0.333408 6.52969 0.940598C5.78588 1.54779 5.27414 2.39284 5.08073 3.33333H2.4974C2.27638 3.33333 2.06442 3.42113 1.90814 3.57741C1.75186 3.73369 1.66406 3.94565 1.66406 4.16667C1.66406 4.38768 1.75186 4.59964 1.90814 4.75592C2.06442 4.9122 2.27638 5 2.4974 5H3.33073V15.8333C3.33205 16.938 3.77146 17.997 4.55258 18.7781C5.3337 19.5593 6.39274 19.9987 7.4974 20H12.4974C13.6021 19.9987 14.6611 19.5593 15.4422 18.7781C16.2233 17.997 16.6627 16.938 16.6641 15.8333V5H17.4974C17.7184 5 17.9304 4.9122 18.0867 4.75592C18.2429 4.59964 18.3307 4.38768 18.3307 4.16667C18.3307 3.94565 18.2429 3.73369 18.0867 3.57741C17.9304 3.42113 17.7184 3.33333 17.4974 3.33333ZM9.16406 1.66667H10.8307C11.3476 1.6673 11.8517 1.82781 12.2737 2.1262C12.6958 2.42459 13.0152 2.84624 13.1882 3.33333H6.80656C6.97955 2.84624 7.29898 2.42459 7.72105 2.1262C8.14313 1.82781 8.64717 1.6673 9.16406 1.66667ZM14.9974 15.8333C14.9974 16.4964 14.734 17.1323 14.2652 17.6011C13.7963 18.0699 13.1604 18.3333 12.4974 18.3333H7.4974C6.83436 18.3333 6.19847 18.0699 5.72963 17.6011C5.26079 17.1323 4.9974 16.4964 4.9974 15.8333V5H14.9974V15.8333Z"
                                                        fill="white" />
                                                    <path
                                                        d="M8.33333 14.9997C8.55434 14.9997 8.76631 14.9119 8.92259 14.7556C9.07887 14.5993 9.16666 14.3874 9.16666 14.1663V9.16634C9.16666 8.94533 9.07887 8.73337 8.92259 8.57709C8.76631 8.42081 8.55434 8.33301 8.33333 8.33301C8.11232 8.33301 7.90036 8.42081 7.74408 8.57709C7.5878 8.73337 7.5 8.94533 7.5 9.16634V14.1663C7.5 14.3874 7.5878 14.5993 7.74408 14.7556C7.90036 14.9119 8.11232 14.9997 8.33333 14.9997Z"
                                                        fill="white" />
                                                    <path
                                                        d="M11.6693 14.9997C11.8903 14.9997 12.1023 14.9119 12.2585 14.7556C12.4148 14.5993 12.5026 14.3874 12.5026 14.1663V9.16634C12.5026 8.94533 12.4148 8.73337 12.2585 8.57709C12.1023 8.42081 11.8903 8.33301 11.6693 8.33301C11.4483 8.33301 11.2363 8.42081 11.08 8.57709C10.9237 8.73337 10.8359 8.94533 10.8359 9.16634V14.1663C10.8359 14.3874 10.9237 14.5993 11.08 14.7556C11.2363 14.9119 11.4483 14.9997 11.6693 14.9997Z"
                                                        fill="white" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_8923_1234">
                                                        <rect width="20" height="20" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            `;

                            MelodyWrapper.append(html);
                            waveInit("{{ url('/') }}" + response.data.file, "demo" +
                                response.data.id);

                        }, 2000);
                    } else {
                        if (response.errors) {
                            $.each(response.errors, function(key, value) {
                                $(`#error-${key}`).html(value);
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    toastr.error(err.Message);

                }
            });
        });



        // Edit Modal Show
        function ShowEditModal(e, ele, id) {

            // Get Data using ajax
            e.preventDefault();
            let element = $(ele);

            let url = "{{ route('producer.get.demo', ':id') }}";
            $.ajax({
                type: "GET",
                url: url.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(resp) {
                    if (resp.success === true) {
                        $('#demoId').val(resp.data.id);
                        $('#name').val(resp.data.name);
                        $('.add--icon-text').hide();
                        let prev = $('.modal #filePreview');
                        prev.attr('src', resp.data.thumbnail);
                        prev.show();

                        $('.modal #uploadTextZip').hide();
                        $('.modal #fileNameZip').text(resp.data.file_name);

                        $('#DemoModalTitle').text('Update Demo');
                        $(".modal #fileDetailsZip").show();

                        $('#DemoModal').modal('show');
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error: function(error) {
                    toastr.error(error);
                }
            })

        }

        // Delete Modal
        function ShowDeleteAlert(e, ele, id) {
            // show Alert
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

            let url = "{{ route('producer.delete.demo', ':id') }}";
            $.ajax({
                type: "DELETE",
                url: url.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(resp) {
                    if (resp.success === true) {
                        toastr.success(resp.message);
                        $('#demo' + id).remove();
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


    {{-- Close Modal --}}
    <script>
        // Close Modal
        $(document).on('click', '.close', function() {
            $('#DemoModal').modal('hide');
        })
    </script>


    <script>
        $("#PackForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('producer.pack.update') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    //console.log(response);
                    if (response.success == true) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = "{{ route('producer.my.items') }}";
                        }, 2000);
                    } else {
                        if (response.errors) {
                            $.each(response.errors, function(key, value) {
                                $(`#error-${key}`).html(value);
                            });
                            toastr.error(response.message)
                        } else {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function(xhr, status, error) {

                    var err = eval("(" + xhr.responseText + ")");
                    toastr.error(err.Message);

                }
            });
        });
    </script>
@endpush
