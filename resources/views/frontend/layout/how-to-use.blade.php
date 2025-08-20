@extends('frontend.app')

@section('title', 'How to Use')

@push('style')
@endpush

@section('content')
<section data-aos="fade-up"
data-aos-anchor-placement="center-bottom" data-aos-duration="2000" class="sm--video-section-container ">
    <div class="container">
        <div class="sm--video-main-wrapper">
            <h2 class="sm--video-section-title">How Collabs Works?</h2>
            <div  class="sm--video-wrapper">

                <div class="sm-video-iframe-container">
                  <iframe width="560" height="315" src="https://www.youtube.com/embed/PWjfYvf0fsw?si=Z1sPXmN0lvrNrpMn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

@push('script')
@endpush
