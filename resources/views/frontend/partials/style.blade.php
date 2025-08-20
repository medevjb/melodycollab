 <!-- ==== All Css Links ==== -->
 <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
 <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/aos.css') }}" />
 <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/helper.css') }}" />
 <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/owl.carousel.min.css') }}" />
 <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/nice-select.min.css') }}" />
 <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/magnific-popup.min.css') }}" />
 <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.css') }}" />
 <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/responsive.css') }}" />
 <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/toastr.min.css') }}" />
 <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/toastr.css') }}" />

 <style>
     .VIpgJd-ZVi9od-ORHb-OEVmcd {
         display: none;
     }

     .VIpgJd-ZVi9od-l4eHX-hSRGPd {
         display: none;
     }

     .goog-te-gadget {
         color: #000 !important;
     }

     #google_translate_element .goog-te-gadget .goog-te-combo {
         padding: 10px 15px !important;
         border: 1px solid #8a93a2;
         border: 1px solid var(--white);
         border-radius: 20px;
         color: #000000 !important;
         font-size: 14px;
         background-color: white;
         width: 250px;
     }
 </style>


@if ($setting != null && $setting->pixel != null)
{!! $setting->pixel !!}
@endif

 @stack('style')
