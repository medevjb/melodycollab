@extends('frontend.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<section class="auth--area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- auth--box  -->
                <div class="auth--box" data-aos="fade-in" data-aos-duration="1600">
                    <h1 class="title">Log In to our portal</h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- ssl login  -->
                        <a href="#" class="ssl--login">
                            <img src="{{ asset('frontend/images/google.svg') }}" alt="" />
                            Log In with Google
                        </a>
                        <p class="divider">Or</p>
                            <!-- input--group  -->
                            <div class="input--group">
                                <input type="email" placeholder="Email Address" name="email" />
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="password" placeholder="Password" name="password"  />
                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="my-3 d-flex w-100">
                                    <div class="d-flex w-100">
                                        <input class="" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <!-- forgot--pass  -->
                        @if (Route::has('password.request'))
                            <p class="forgot--pass">
                                Forgot Password? <a href="{{ route('password.request') }}">Click Here</a>
                            </p>
                        @endif
                        {{-- <button type="submit">Log In</button> --}}
                        <button type="submit" class="button w-100 ">Log In</button>
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
