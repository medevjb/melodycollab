@extends('frontend.app')

@section('title', 'Login')

@push('style')
    <style>
        .auth--area .auth--box input[type="checkbox"] {
            height: 20px;
            width: 20px;
            margin-right: 6px;
        }

        .logo-white,
        .logo-black {
            display: none;
        }
        footer{
            display: none;
        }
    </style>

    @section('content')
        <section class="auth--area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <!-- auth--box  -->
                        <div class="auth--box" data-aos="fade-in" data-aos-duration="1600">
                            <h1 class="title">{{ request()->has('from') ? 'Sign Up' : 'Log In' }} to Melody Collab</h1>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <!-- ssl login  -->
                                <a href="{{ route('google.login') }}" class="ssl--login">
                                    <img src="{{ asset('frontend/images/google.svg') }}" alt="" />
                                    Continue with Google
                                </a>
                                <p class="divider">Or</p>
                                <!-- input--group  -->
                                <div class="input--group">
                                    <input type="email" placeholder="Email Address" value="{{ old('email') }}" name="email" />
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input type="password" placeholder="Password" name="password" />
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
                                    By creating an account and/or logging in, you agree to MelodyCollab
<a href="{{ route('dynamic.page',['slug' => 'terms-of-service'])}}">Terms of Service</a> and <a href="{{ route('dynamic.page',['slug' => 'privacy-policy'])}}">Privacy Policy.</a>
                                </p>
                                <p class="new--register">
                                    Don't have an account ? <a href="{{ route('register') }}">Sign Up</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
