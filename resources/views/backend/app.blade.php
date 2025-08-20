<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="icon" type="image/jpg, image/png, image/jpeg, image/gif, image/x-icon, image/vnd.microsoft.icon, image/ico, image/bmp, image/webp, image/svg+xml" href="{{ asset($setting->favicon?? 'frontend/images/MelodyCollabFinal-favicon.png') }}" />

    <title>@yield('title')</title>

    @include('backend.partials.styles')
</head>

<body>
    {{--  ======== Preloader ===========  --}}
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    {{--  ======== Preloader ===========  --}}
    @include('backend.partials.sidebar')
    <main class="main-wrapper">
        @include('backend.partials.header')
        <section class="section">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
        @include('backend.partials.footer')
    </main>
    @include('backend.partials.scripts')
</body>

</html>
