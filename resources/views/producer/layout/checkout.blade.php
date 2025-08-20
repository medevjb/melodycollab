@extends('producer.app')

@section('title', 'Checkout')

@push('style')
<style>
</style>
@endpush

@section('content')

    <section class="app--content">
        <!-- checkout area  -->
        <div class="checkout-f-wrapp">
            <h1 class="t-main text-center">Checkout</h1>
            <div class="row justify-content-center">
                <div class="col-xxl-10">
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- f-look  -->
                            <div class="f-look">
                                <h4 class="t-subtitle">Final Look Through</h4>
                                <!-- f-all-products  -->
                                <div class="f-all-products">
                                    @if ($carts)
                                        @forelse ($carts->items as $item)
                                            <div class="cart-product mt_25">
                                                <!-- product-quantity  -->
                                                <div class="product-quantity">
                                                    <div class="p-image-wrap position-relative">
                                                        <img class="p-image" src="{{ asset($item->pack->thumbnail) }}"
                                                            alt="{{ $item->pack->name }}">
                                                        <img class="delete-icon"
                                                            src="{{ asset('frontend/images/close.svg') }}"
                                                            alt="{{ $item->pack->name }}"
                                                            onclick="removeFromCart(event,{{ $item->id }}, this)">
                                                    </div>
                                                    <div class="title-quantity">
                                                        <!-- p-title -->
                                                        <div class="p-title">
                                                            <h4 class="t-main">{{ $item->pack->name }}</h4>
                                                            <p class="t-sub">{{ $item->pack->user->name }}</p>
                                                        </div>
                                                        <!-- p-quantity  -->
                                                        <p class="p-quantity">
                                                            X1
                                                        </p>
                                                    </div>
                                                </div>
                                                <!-- product price  -->
                                                <div class="p-price">${{ Number::format($item->pack->price, 2) }}</div>
                                            </div>
                                        @empty
                                            <h5>Card Empty</h5>
                                        @endforelse
                                    @else
                                        <h5>Card Empty</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="total-p-box">
                                <div class="p-box">
                                    <h3 class="t-box-sub">Final Look Through</h3>
                                    <ul>
                                        <li>
                                            <p>Total</p>
                                            @if ($carts)
                                                <p id="ck-sub-total">
                                                    ${{ number_format(
                                                        $carts->items->sum(function ($item) {
                                                            return $item->pack->price;
                                                        }),
                                                        2,
                                                    ) }}
                                                </p>
                                            @else
                                                <p id="ck-total">$00.00</p>
                                            @endif
                                        </li>
                                        <li class="total">
                                            <p>Total Charge</p>
                                            @if ($carts)
                                                <p id="ck-total">
                                                    ${{ number_format(
                                                        $carts->items->sum(function ($item) {
                                                            return $item->pack->price;
                                                        }),
                                                        2,
                                                    ) }}
                                                </p>
                                            @else
                                                <p id="ck-total">$00.00</p>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <form action="{{ route('producer.checkout.paypal') }}" method="POST">
                                    @csrf
                                    <button class="button" type="submit">Proceed To Pay</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </script>
@endpush
