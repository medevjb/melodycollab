@extends('producer.app')

@section('title', 'Create Melody')

@push('style')
@endpush

@section('content')

    <!-- main content start  -->
    <section class="app--content">
        <!-- add new pack area start -->
        <section class="add--new--pack--area" data-aos="zoom-in" data-aos-duration="1600">
            <h2 class="title--lg text-center">Add New Melody</h2>
            <form method="POST" action="#" id="createMelodyForm">
                <div class="row">
                    <div class="col-lg-3 col-md-5 input--space">
                        <!-- thumbnail--upload  -->
                        <div class="thumbnail--upload upload--wrapper">
                            <input id="thumbnailUpload" type="file" data-preview-id="profilePreview"
                                data-loader-id="thumbnail-loader" label-id=".thumbnailUpload" />
                            <label for="thumbnailUpload" class="thumbnailUpload">
                                <img class="initial-img" src="{{ asset('frontend/images/camera.png') }}" alt="" />
                                <p class="initial-text">Add Thumbnail</p>
                                <img class="pack--preview--img" src="" id="profilePreview" alt="" />
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
                            <h4 class="pack--title">Upload Melody</h4>
                            <div class="pack--cover--upload upload--wrapper pack-melody-upload" id="zipWrapper">
                                <input id="packZipUpload" type="file" data-preview-id="packCoverPreviewZip"
                                    data-loader-id="pack-cover-loaderZip" label-id=".packcoverUpload"
                                    accept=".mp3,.wav,.aac,.ogg,.flac,.m4a,.wma,.aiff,.alac,.opus,.amr"
                                    style="display: none" />
                                <label for="packZipUpload" class="packcoverUpload" id="uploadLabelZip">

                                    <div class="upload--text" id="uploadTextZip">
                                        <img src="{{ asset('frontend/images/play-button.svg') }}" alt="Upload Icon" />
                                        <h5> Drag and drop your mp3 or wav audio file.</h5>
                                        <p class="title">
                                            Drag your mp3 or wav file to start uploading.
                                        </p>
                                        <p class="divider"></p>
                                        <p class="browse-file--btn">Browse files </p>                                        
                                    </div>

                                    <div class="fileDetails" id="fileDetailsZip" style="display: none">
                                        <img src="{{ asset('frontend/images/mp3-icon.svg') }}" alt="Zip Icon"
                                            class="zip-icon" />
                                        <p class="filename" id="fileNameZip"></p>
                                    </div>
                                    <div id="pack-cover-loaderZip" class="upload--loader" style="display: none">
                                        <img src="{{ asset('frontend/images/tube-spinner.svg') }}" alt="Loading..." />
                                    </div>

                                </label>
                            </div>
                        </div>
                        <div class="valid-feedback mt-3 text-danger d-block " id="error-zipfile"></div>
                    </div>
                    <div class="col-lg-6 mt_75 pr_35">
                        <div class="add--melodies--box">
                            <!-- sinlge--inputs  -->
                            <div class="sinlge--inputs">
                                <label for="melody-name">Melody Name</label>
                                <div>
                                    <input type="text" name="name" id="melody-name" class="text-capitalize" />
                                    <div class="valid-feedback text-danger d-block" id="error-name"></div>
                                </div>
                            </div>

                            <!-- sinlge--inputs  -->
                            <div class="sinlge--inputs bpm">
                                <label for="bpm">BPM</label>
                                <!-- multiple--content--feild  -->
                                <div class="multiple--content--feild">
                                    <div>
                                        <input type="text" id="bpm" class="small" name="bpm" />

                                        <div class="valid-feedback text-danger d-block" id="error-bpm"></div>
                                    </div>
                                    <p>bpm</p>
                                </div>
                            </div>
                            <!-- sinlge--inputs  -->
                            <div class="sinlge--inputs Key keys-option--wrapp options-common--dropdown position-relative">
                                <p class="title--key">Key</p>
                                <!-- trigger -->
                                <div class="trigger">

                                </div>
                                <!-- key--dropdown -->
                                <div class="key--dropdown">
                                    <ul class="nav nav-pills mb_20" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-flat-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-flat" type="button" role="tab"
                                                aria-controls="pills-flat" aria-selected="true">
                                                FLAT
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-sharp-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-sharp" type="button" role="tab"
                                                aria-controls="pills-sharp" aria-selected="false">
                                                Sharp
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade  " id="pills-flat" role="tabpanel"
                                            aria-labelledby="pills-flat-tab" tabindex="0">
                                            <!-- key group -->
                                            <div class="key--group">
                                                <!-- key sub group  -->
                                                <div class="key--subgroup">
                                                    <!-- key  -->
                                                    <div class="key">
                                                        <input id="key-sharp1" type="radio" name="key--group" />
                                                        <label for="key-sharp1">Db</label>
                                                    </div>
                                                    <!-- key  -->
                                                    <div class="key">
                                                        <input id="key-sharp2" type="radio" name="key--group" />
                                                        <label for="key-sharp2">Eb</label>
                                                    </div>
                                                </div>
                                                <!-- key sub group  -->
                                                <div class="key--subgroup">
                                                    <!-- key  -->
                                                    <div class="key">
                                                        <input id="key-sharp3" type="radio" name="key--group" />
                                                        <label for="key-sharp3">Gb</label>
                                                    </div>
                                                    <!-- key  -->
                                                    <div class="key">
                                                        <input id="key-sharp4" type="radio" name="key--group" />
                                                        <label for="key-sharp4">Ab</label>
                                                    </div>
                                                    <!-- key  -->
                                                    <div class="key">
                                                        <input id="key-sharp5" type="radio" name="key--group" />
                                                        <label for="key-sharp5">Bb</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- key group  -->
                                            <div class="key--group">
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key-sharp6" type="radio" name="key--group" />
                                                    <label for="key-sharp6">C</label>
                                                </div>
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key-sharp7" type="radio" name="key--group" />
                                                    <label for="key-sharp7">D</label>
                                                </div>
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key-sharp8" type="radio" name="key--group" />
                                                    <label for="key-sharp8">E</label>
                                                </div>
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key-sharp9" type="radio" name="key--group" />
                                                    <label for="key-sharp9">F</label>
                                                </div>
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key-sharp10" type="radio" name="key--group" />
                                                    <label for="key-sharp10">G</label>
                                                </div>
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key-sharp11" type="radio" name="key--group" />
                                                    <label for="key-sharp11">A</label>
                                                </div>
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key-sharp12" type="radio" name="key--group" />
                                                    <label for="key-sharp12">B</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show active" id="pills-sharp" role="tabpanel"
                                            aria-labelledby="pills-sharp-tab" tabindex="0">
                                            <!-- key group -->
                                            <div class="key--group">
                                                <!-- key sub group  -->
                                                <div class="key--subgroup">
                                                    <!-- key  -->
                                                    <div class="key">
                                                        <input id="key1" type="radio" name="key--group" />
                                                        <label for="key1">C#</label>
                                                    </div>
                                                    <!-- key  -->
                                                    <div class="key">
                                                        <input id="key2" type="radio" name="key--group" />
                                                        <label for="key2">D#</label>
                                                    </div>
                                                </div>
                                                <!-- key sub group  -->
                                                <div class="key--subgroup">
                                                    <!-- key  -->
                                                    <div class="key">
                                                        <input id="key3" type="radio" name="key--group" />
                                                        <label for="key3">F#</label>
                                                    </div>
                                                    <!-- key  -->
                                                    <div class="key">
                                                        <input id="key4" type="radio" name="key--group" />
                                                        <label for="key4">G#</label>
                                                    </div>
                                                    <!-- key  -->
                                                    <div class="key">
                                                        <input id="key5" type="radio" name="key--group" />
                                                        <label for="key5">A#</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- key group  -->
                                            <div class="key--group">
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key6" type="radio" name="key--group" />
                                                    <label for="key6">C</label>
                                                </div>
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key7" type="radio" name="key--group" />
                                                    <label for="key7">D</label>
                                                </div>
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key8" type="radio" name="key--group" />
                                                    <label for="key8">E</label>
                                                </div>
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key9" type="radio" name="key--group" />
                                                    <label for="key9">F</label>
                                                </div>
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key10" type="radio" name="key--group" />
                                                    <label for="key10">G</label>
                                                </div>
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key11" type="radio" name="key--group" />
                                                    <label for="key11">A</label>
                                                </div>
                                                <!-- key  -->
                                                <div class="key">
                                                    <input id="key12" type="radio" name="key--group" />
                                                    <label for="key12">B</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <!-- key--type  -->
                                    <div class="key--type">
                                        <!-- type  -->
                                        <div class="type">
                                            <input type="radio" id="major" name="key--type" />
                                            <label for="major">Maj</label>
                                        </div>
                                        <!-- type  -->
                                        <div class="type">
                                            <input type="radio" id="minor" name="key--type" />
                                            <label for="minor">Min</label>
                                        </div>
                                    </div>
                                    <!-- footer  -->
                                    <div class="dropdown--action">
                                        <a href="#" id="clearInputs" class="clearInputs">Clear</a>
                                        <a href="#" id="saveChanges" class="saveChanges">Apply</a>
                                    </div>
                                </div>
                            </div>
                            <div class="valid-feedback text-danger d-block" id="error-selected_key"></div>
                            <!-- sinlge--inputs  -->
                            <div class="sinlge--inputs split-percentage">
                                <label for="split-percentage">Split Percentage</label>
                                <div class="multiple--content--feild">
                                    <input type="string" id="split-percentage" class="small"
                                        name="split_percentage" />
                                    <p>%</p>
                                </div>
                            </div>
                            <div class="valid-feedback text-danger d-block" id="error-split_percentage"></div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt_75 pl_35">
                        <!-- add--melody--options  -->
                        <div class="add--melody--options add--melodies--box">
                            <!-- single--option  -->
                            <div class="single--option">
                                <p class="title">Genres</p>
                                <!-- pack--genres  -->
                                <div class="pack--genres">
                                    <ul class="all--added--genres">
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
                            </div>
                            <div class="valid-feedback text-center text-danger d-block" id="error-genres"></div>
                            <!-- single--option  -->
                            <div class="single--option">
                                <p class="title">Instruments</p>
                                <!-- pack--genres  -->
                                <div class="pack--genres">
                                    <ul class="all--added--genres">
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
                                                @foreach ($instruments as $instrument)
                                                    <li data-item="instruments" data-value="{{ $instrument->id }}">
                                                        {{ $instrument->title }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <div class="valid-feedback text-center text-danger d-block" id="error-instrument"></div>
                            <!-- single--option  -->
                            <div class="single--option">
                                <p class="title">Artist Type</p>
                                <!-- pack--genres  -->
                                <div class="pack--genres">
                                    <ul class="all--added--genres">
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
                                                @foreach ($artiseTypes as $artiseType)
                                                    <li data-item="artist_type" data-value="{{ $artiseType->id }}">
                                                        {{ $artiseType->title }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <div class="valid-feedback text-center text-danger d-block" id="error-artist_type"></div>
                        </div>
                    </div>
                    <!-- add--melodies -->
                    <!-- uplod--pack--area  -->
                    <div class="uplod--pack--area upload--single-melody">
                        <div class="input--group custom-checkbox">
                            <input id="terms" type="checkbox" name="terms" />
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
                            Upload Melody
                        </button>
                    </div>
            </form>
        </section>
        <!-- add new pack area end -->


    </section>
    <!-- main content end  -->


@endsection

@push('script')
    <script>
        // $(document).ready(function() {
        $("#createMelodyForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('producer.melody.store') }}",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
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
        // });
    </script>

    {{-- For Aleart to file-upload --}}
   {{--  onclick="return alertBeforeUpload()" --}}
   {{--  <script>
        function alertBeforeUpload() {
            Swal.fire({
                title: 'Are you sure?',
                text: "By continuing to upload, you confirm that all the details provided are your own creation. If it is discovered that you are not associated with the content, Melody Collab will not be held responsible or associated with you.Please review our privacy and policy page to ensure everything is clear to you.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continue'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("packZipUpload").click();
                }
            })
            return false;
        }
    </script> --}}
@endpush
