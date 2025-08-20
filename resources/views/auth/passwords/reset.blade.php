@extends('frontend.app')

@section('content')

<section class="auth--area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- auth--box  -->
                <div class="auth--box" data-aos="fade-in" data-aos-duration="1600">
                    <h1 class="title">Log In to our portal</h1>
                    <form method="POST" action="{{ route('password.update') }}">
                        <input type="hidden" name="token" value="{{ $token }}">
                        @csrf
                            <!-- input--group  -->
                            <div class="input--group">
                                <input type="email" placeholder="Email" name="email" value="{{ $email ?? old('email') }}"  />
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input--group mt-3">
                                <input type="password" placeholder="Password" name="password"  />
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input--group mt-3">
                                <input type="password" placeholder="Confirm Password" name="password_confirmation"  />
                                @error('password_confirmation')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <!-- forgot--pass  -->
                            <p class="forgot--pass">
                                Go to Login ? <a href="{{ route('login') }}">Click Here</a>
                            </p>
                        {{-- <button type="submit">Log In</button> --}}
                        <button type="submit" class="button w-100 ">{{ __('Reset Password') }}</button>
                        <!-- new register  -->
                        <p class="new--register">
                            New Here? <a href="{{ route('register') }}">Register Today </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
