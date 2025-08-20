<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>
        @yield('title') || {{ $setting->title ?? 'Melody Collab' }}
    </title>
    {{-- csrf Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- ==== Favicon ==== -->

    <link rel="icon" type="image/png" href="{{ asset($setting->favicon ?? 'frontend/images/MelodyCollabFinal-favicon.png') }}" />

    {{-- Open Graph Meta Tags for Facebook, LinkedIn, Skype --}}
    <meta property="og:title" content="@yield('og_title', $setting->title ?? 'Melody Collab')" />
    <meta property="og:description" content="@yield('og_description', $setting->description ?? 'Check out this amazing melody collaboration!')" />
    <meta property="og:image" content="@yield('og_image', asset($setting->logo ?? 'frontend/images/logo-white.png'))" />
    <meta property="og:url" content="@yield('og_url', url()->current())" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ $setting->system_name ?? 'Melody Collab' }}" />

    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:title" content="@yield('twitter_title', $setting->title ?? 'Melody Collab')" />
    <meta name="twitter:description" content="@yield('twitter_description', $setting->description ??'Check out this amazing melody collaboration!')" />
    <meta name="twitter:image" content="@yield('twitter_image', asset($setting->logo ?? 'frontend/images/logo-white.png'))" />
    <meta name="twitter:url" content="@yield('twitter_url', url()->current())" />

    @include('frontend.partials.style')
</head>

<body>
    <!-- header :: start -->
    @include('frontend.partials.header')
    <!-- header :: end -->

    <!-- main :: start -->
    <main>
        @yield('content')
    </main>
    <!-- main :: end -->

    <!-- footer :: start  -->
    @include('frontend.partials.footer')



    <!-- footer :: end  -->
    @include('frontend.partials.script')
</body>

</html>
