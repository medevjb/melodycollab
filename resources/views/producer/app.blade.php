<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>
        @yield('title') || {{ $setting->title ?? 'Melody Collab' }}
    </title>
    <!-- ==== Favicon ==== -->

    <link rel="icon" type="image/png" href="{{ asset($setting->favicon ?? 'frontend/images/MelodyCollabFinal-favicon.png') }}" />

    @include('producer.partials.style')

    @if ($setting != null && $setting->pixel != null)
        {{ $setting->pixel }}
    @endif
</head>

<body>
    <!-- header :: start -->
    @include('producer.partials.header')
    <!-- header :: end -->

    <main>
        <!-- sidebar start  -->
        @include('producer.partials.sidebar')
        <!-- sidebar end  -->


        @yield('content')


        <!-- main content end  -->
    </main>

    <div class="collab-popup--wrapp" id="collab--popup--wrapp">
        <form action="#">
            <div id="collab--popup">
                <h3 class="title">Collab Percentage Information</h3>
                <p class="melody-name text-capitalize">{melody.name}</p>
                <ul class="feature">
                    <li>
                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                        Split Percentage : <span id="collab--percentage">50</span>%
                    </li>
                    <li>
                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                        Producer name: <span id="collab--producer--name"></span>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                        Beatstars Username : <span id="collab--beatstars--name"></span>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                        Soundee Username : <span id="collab--soundee--name"></span>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                        Instagram Username : <span id="collab--instagram--name"></span>
                    </li>
                    <li>
                        <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                        YouTube Channel : <span id="collab--youtube--name"></span>
                    </li>
                </ul>
                <div class="input--group custom--checkbox">
                    <input id="percentage-terms" id="percentage-terms" checked type="checkbox">
                    <label for="percentage-terms">By downloading and using this melody, the producer agrees to add the
                        melody's owner as a collaborator on the beat that is uploaded to any digital store or music
                        distribution platform. Failure to comply with this condition may result in the removal of the
                        beat
                        from such platforms.</label>
                </div>
                <div class="buttons">
                    <a href="#" id="downloadBtn" class="button close--modal disabled">Download Melody</a>
                    <a href="#" class="button close--modal disabled" target="_blank" id="downloadPDFBtn">
                        Download Licence
                    </a>
                </div>
                <p class="close--pop close--modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50"
                        fill="none">
                        <path d="M16.1641 16.1621L33.8417 33.8398" stroke="#09745A" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M16.1583 33.8398L33.8359 16.1621" stroke="#09745A" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </p>
            </div>
        </form>
    </div>

    <!-- footer :: end  -->
    @include('producer.partials.script')
</body>

</html>
