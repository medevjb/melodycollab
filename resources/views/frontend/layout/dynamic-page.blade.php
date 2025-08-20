@extends('frontend.app')

@section('title', 'How to Use')

@push('style')
@endpush

@section('content')
    <section data-aos="fade-up" data-aos-anchor-placement="center-bottom" data-aos-duration="2000"
        class="sm--video-section-container ">
        <div class="container">
            <div class="sm--video-main-wrapper">
                <h2 class="sm--video-section-title mt-5">
                    {{$page->page_title ?? ''}}
                </h2>
                <div class="mb-5 p-4 p-md-0" >
                    {!! $page->page_content ?? '' !!}
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
@endpush
