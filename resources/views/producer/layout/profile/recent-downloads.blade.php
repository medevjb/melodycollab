@extends('producer.app')

@section('title', 'Recent Purchases')

@push('style')
@endpush

@section('content')

    <!-- main content start  -->
    <section class="app--content">
        <!-- producers items area start -->
        <div class="producers--items--area">
            <h2 class="title text-center" data-aos="fade-in" data-aos-duration="1500" data-aos-offset="0">
                Recent Purchases
            </h2>
            <!-- my-packs -->
            <div class="my-packs">
                <div class="custom--row">
                    @forelse ($packs as $pack)
                        <div class="card--wrapper" data-aos="zoom-in" data-aos-duration="1600" data-aos-offset="0">
                            <!-- packs card  -->
                            <a href="{{ route('producer.pack.show', ['id' => Crypt::encrypt($pack->id)]) }}"
                                class="album--packs--card">
                                <!-- img area  -->
                                <div class="img--area">
                                    <img src="{{ asset($pack->thumbnail) }}" alt="" />
                                </div>
                                <h4>{{ $pack->name }}</h4>
                                <div class="d-flex flex-column">
                                    <p class="artist">{{ $pack->user->producer_name }}</p>
                                    <button class="buttonv3 mt-3"
                                        onclick="PackDownload(event,'{{ Crypt::encrypt($pack->id) }}')">download</button>
                                </div>
                            </a>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <!-- producers items area end -->


    </section>

@endsection

@push('script')
    <script>
        
    </script>
@endpush
