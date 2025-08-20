@extends('producer.app')

@section('title', 'My Items')

@push('style')
@endpush

@section('content')


    <!-- main content start  -->
    <section class="app--content">
        <!-- producers items area start -->
        <div class="producers--items--area">
            <h2 class="title text-center" data-aos="fade-in" data-aos-duration="1500" data-aos-offset="0">
                My Items
            </h2>
            <!-- my-packs -->
            <div class="my-packs">
                <h4 class="small--green--title mb_5" data-aos="fade-in" data-aos-duration="1500" data-aos-offset="0">
                    My Packs
                </h4>
                <div class="custom--row">
                    <div class="card--wrapper" data-aos="zoom-in" data-aos-duration="1600" data-aos-offset="0">
                        <!-- packs card  -->
                        <a href="individiul-pack.html" class="album--packs--card">
                            <!-- img area  -->
                            <div class="img--area">
                                <img src="{{ asset('frontend/images/album-packs1.png') }}" alt="" />
                            </div>
                            <h4>ABYSS</h4>
                            <div class="d-flex flex-column">
                                <p class="artist">FrancisGotHeat</p>
                                <p class="price">$6.00</p>
                            </div>
                        </a>
                    </div>
                    <div class="card--wrapper" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="50"
                        data-aos-offset="0">
                        <!-- packs card  -->
                        <a href="individiul-pack.html" class="album--packs--card">
                            <!-- img area  -->
                            <div class="img--area">
                                <img src="{{ asset('frontend/images/album-packs2.png') }}" alt="" />
                            </div>
                            <h4>ma bella'</h4>
                            <div class="d-flex flex-column">
                                <p class="artist">FrancisGotHeat</p>
                                <p class="price">$6.00</p>
                            </div>
                        </a>
                    </div>
                    <div class="card--wrapper" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100"
                        data-aos-offset="0">
                        <!-- packs card  -->
                        <a href="individiul-pack.html" class="album--packs--card">
                            <!-- img area  -->
                            <div class="img--area">
                                <img src="{{ asset('frontend/images/album-packs3.png') }}" alt="" />
                            </div>
                            <h4>for once</h4>
                            <div class="d-flex flex-column">
                                <p class="artist">FrancisGotHeat</p>
                                <p class="price">$6.00</p>
                            </div>
                        </a>
                    </div>
                    <div class="card--wrapper" data-aos="zoom-in" data-aos-duration="1600" data-aos-offset="0"
                        data-aos-delay="150">
                        <!-- packs card  -->
                        <a href="individiul-pack.html" class="album--packs--card">
                            <!-- img area  -->
                            <div class="img--area">
                                <img src="{{ asset('frontend/images/album-packs1.png') }}" alt="" />
                            </div>
                            <h4>ABYSS</h4>
                            <div class="d-flex flex-column">
                                <p class="artist">FrancisGotHeat</p>
                                <p class="price">$6.00</p>
                            </div>
                        </a>
                    </div>
                    <div class="card--wrapper" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="200"
                        data-aos-offset="0">
                        <!-- packs card  -->
                        <a href="individiul-pack.html" class="album--packs--card">
                            <!-- img area  -->
                            <div class="img--area">
                                <img src="{{ asset('frontend/images/album-packs2.png') }}" alt="" />
                            </div>
                            <h4>ma bella'</h4>
                            <div class="d-flex flex-column">
                                <p class="artist">FrancisGotHeat</p>
                                <p class="price">$6.00</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- my melodies  -->
            <div class="my--melodies mt_65">
                <h4 class="small--green--title" data-aos="fade-in" data-aos-duration="1500" data-aos-offset="0">
                    My Melodies
                </h4>
                <div class="browse--melodies" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">
                    <!-- top content  -->
                    <form id="filterForm" method="POST">
                        <!-- filtering--options -->
                        <div class="filtering--options">
                            <!-- option  -->
                            <div class="option popular">
                                <select name="order" id="order">
                                    <option selected>Popular</option>
                                    <option value="most-popular">Most Popular</option>
                                    <option value="recent">Most Recent</option>
                                    <option value="random">Random</option>
                                </select>
                            </div>
                            <!-- option  -->
                            <div class="option fixed-slect">
                                <select name="filter_genre" id="filter_genre">
                                    <option selected value="">Genres</option>
                                    @foreach ($data['genrises'] as $genrese)
                                        <option value="{{ $genrese->id }}">{{ $genrese->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- option  -->
                            <div class="option bmp--range position-relative options-common--dropdown">
                                <!-- trigger -->
                                <div class="trigger">
                                    BPM
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                        viewBox="0 0 10 10" fill="none">
                                        <mask id="mask0_5256_2893" style="mask-type: luminance"
                                            maskUnits="userSpaceOnUse" x="0" y="0" width="10" height="10">
                                            <path d="M0 10H10V0H0V10Z" fill="white" />
                                        </mask>
                                        <g mask="url(#mask0_5256_2893)">
                                            <path
                                                d="M1.37607 2.62573L5.10752 6.35717L8.61718 2.84751L9.50109 3.73138L5.10752 8.12494L0.492188 3.50962L1.37607 2.62573Z"
                                                fill="white" fill-opacity="0.4" />
                                        </g>
                                    </svg>
                                </div>
                                <!-- bmp--dropdown  -->
                                <div class="bmp--dropdown">
                                    <!-- exact  -->
                                    <div class="exact bmp-radio--options">
                                        <!-- exact--radio  -->
                                        <div class="exact--radio radio--wrapp">
                                            <input id="exactRadio" class="exactRadio" type="radio" name="exect_bpm"
                                                checked />
                                            <label for="exactRadio">Exact</label>
                                        </div>
                                        <input id="exactInput" class="exactInput" name="exect_bpm_value"
                                            type="text" />
                                    </div>
                                    <!-- range  -->
                                    <div class="range bmp-radio--options">
                                        <!-- exact--radio  -->
                                        <div class="exact--radio radio--wrapp">
                                            <input id="rangeRadio" class="rangeRadio" type="radio" name="bmp_range" />
                                            <label for="rangeRadio">Range</label>
                                        </div>
                                        <div class="d-flex range--inputs--wrapp align-items-center">
                                            <input id="rangeInput" class="rangeInput" name="bmp_range_min"
                                                type="tel" placeholder="Min" />
                                            <p class="divider"></p>
                                            <input id="rangeInput" name="bmp_range_max" class="rangeInput"
                                                type="tel" placeholder="Max" />
                                        </div>
                                    </div>
                                    <!-- footer  -->
                                    <div class="dropdown--action">
                                        <a href="#" id="clearInputs" class="clearInputs">Clear</a>
                                        <a href="#" id="saveChanges" class="saveChanges">Save</a>
                                    </div>
                                </div>
                            </div>
                            <!-- option  -->
                            <div class="option fixed-slect instruments">
                                <select name="filter_instruments" id="filter_instruments">
                                    <option selected value="">Instrument</option>
                                    @foreach ($data['instruments'] as $instrument)
                                        <option value="{{ $instrument->id }}">{{ $instrument->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- option  -->
                            <!-- option  -->
                            <div class="option keys-option--wrapp options-common--dropdown position-relative">
                                <!-- trigger -->
                                <div class="trigger d-flex align-items-center"></div>
                                <!-- key--dropdown -->
                                <div class="key--dropdown">
                                    <ul class="nav nav-pills mb_20" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-flat-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-flat" type="button" role="tab"
                                                aria-controls="pills-flat" aria-selected="true">
                                                FLAT
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-sharp-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-sharp" type="button" role="tab"
                                                aria-controls="pills-sharp" aria-selected="false">
                                                Sharp
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-flat" role="tabpanel"
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
                                        <div class="tab-pane fade" id="pills-sharp" role="tabpanel"
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
                                            <label for="major">Major</label>
                                        </div>
                                        <!-- type  -->
                                        <div class="type">
                                            <input type="radio" id="minor" name="key--type" />
                                            <label for="minor">Minor</label>
                                        </div>
                                    </div>
                                    <!-- footer  -->
                                    <div class="dropdown--action">
                                        <a href="#" id="clearInputs" class="clearInputs">Clear</a>
                                        <a href="#" id="saveChanges" class="saveChanges">Apply</a>
                                    </div>
                                </div>
                            </div>




                            
                            <!-- option  -->
                            <div class="option fixed-slect">
                                <select name="filter_artise_type" id="filter_artise_type">
                                    <option selected value="">Artist type</option>
                                    @foreach ($data['artiseTypes'] as $artise_type)
                                        <option value="{{ $artise_type->id }}">{{ $artise_type->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- option  -->
                            <button type="submit">Apply Filter</button>
                        </div>
                    </form>
                    <!-- Melody List Container -->
                    <div id="melodyList">
                        @include('producer.partials.melody-list', ['melodies' => $data['melodies']])
                    </div>
                </div>
            </div>
        </div>
        <!-- producers items area end -->

    </section>

    @component('components.player-component')
    @endcomponent


@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function ShowDeleteAlert(id) {
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
            })
        }

        function deleteItem(id) {

            let url = "{{ route('producer.delete.melody', ':id') }}";
            $.ajax({
                url: url.replace(':id', id),
                type: "GET",
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire(
                            'Deleted!',
                            'Melody has been deleted.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                $(`#melody-${id}`).remove();
                            }
                        })
                    }
                },
                error: function(error) {
                    Swal.fire(
                        'Error!',
                        'Melody has not been deleted.',
                        'error'
                    )
                }
            })
        }
    </script>





@endpush
