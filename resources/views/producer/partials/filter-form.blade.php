<form id="filterForm" method="POST" class="mt-5">
    <!-- filtering--options -->
    <div class="filtering--options"> 
        <!-- option  -->
        <div class="option popular">
            <select name="order" id="order">
                <option selected>Type</option>
                <option value="popular">Popular</option>
                <option value="recent">Recent</option>
                <option value="random">Random</option>
            </select>
        </div>
        <!-- option  -->
        <div class="option fixed-slect">
            <select name="filter_genre" id="filter_genre">
                <option selected value="">Genres</option>
                @foreach ($genrises as $genrese)
                    <option value="{{ $genrese->id }}">{{ $genrese->title }}</option>
                @endforeach
            </select>
        </div>
        <!-- option  -->
        <div class="option bmp--range position-relative options-common--dropdown">
            <!-- trigger -->
            <div class="trigger">
                BPM
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"
                    fill="none">
                    <mask id="mask0_5256_2893" style="mask-type: luminance" maskUnits="userSpaceOnUse" x="0"
                        y="0" width="10" height="10">
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
                        <input id="exactRadio" class="exactRadio" type="radio" value="exact" name="exect_bpm" checked />
                        <label for="exactRadio">Exact</label>
                    </div>
                    <input id="exactInput" class="exactInput" name="exect_bpm_value" type="text" />
                </div>
                <!-- range  -->
                <div class="range bmp-radio--options">
                    <!-- exact--radio  -->
                    <div class="exact--radio radio--wrapp">
                        <input id="rangeRadio" class="rangeRadio" type="radio" value="range" name="exect_bpm" />
                        <label for="rangeRadio">Range</label>
                    </div>
                    <div class="d-flex range--inputs--wrapp align-items-center">
                        <input id="rangeInput" class="rangeInput" name="bmp_range_min" type="tel"
                            placeholder="Min" />
                        <p class="divider"></p>
                        <input id="rangeInput" name="bmp_range_max" class="rangeInput" type="tel"
                            placeholder="Max" />
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
                @foreach ($instruments as $instrument)
                    <option value="{{ $instrument->id }}">{{ $instrument->title }}</option>
                @endforeach
            </select>
        </div>
        <!-- option  -->
        @include('producer.partials.key-options')


        <!-- option  -->
        <div class="option fixed-slect">
            <select name="filter_artise_type" id="filter_artise_type">
                <option selected value="">Artist type</option>
                @foreach ($artiseTypes as $artise_type)
                    <option value="{{ $artise_type->id }}">{{ $artise_type->title }}</option>
                @endforeach
            </select>
        </div>
        <!-- option  -->
        <button type="submit" class="apply-filter">Apply Filter</button>
    </div>
    <button type="button" class="clear-filter" title="Clear Filter">Clear Filter</button>
</form>
