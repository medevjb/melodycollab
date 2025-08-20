@extends('frontend.app')

@section('title', 'Register')

@push('style')
    <style>
        .auth--area .nice-select .list {
            max-height: 200px;
            overflow-y: auto
        }

        .auth--area .nice-select .list::-webkit-scrollbar {
            width: 8px;
            background-color: #0ccf9f;
        }
        .logo-white,
        .logo-black {
            display: none;
        }
        footer{
            display: none;
        }
    </style>
@endpush

@section('content')
    <section class="auth--area">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- auth--box  -->
                    <div class="auth--box" data-aos="fade-in" data-aos-duration="1600">
                        <h1 class="title">Create Your Account</h1>
                        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- input--group  -->
                            <div class="input--group">
                                <input type="text" placeholder="Name" name="name"
                                    value="{{ old('name') }}" />
                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="text" placeholder="Producer Name" name="producer_name"
                                    value="{{ old('producer_name') }}" />
                                @error('producer_name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <select class="" name="country">
                                    <option value="">Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" />
                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                {{-- hide input statrt --}}

                               {{--  <input type="text" placeholder="Beatstars username" name="beatstars_username"
                                    value="{{ old('beatstars_username') }}" />
                                @error('beatstars_username')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="text" placeholder="Instagram username (optional)" name="instragram_username"
                                    value="{{ old('instragram_username') }}" />
                                @error('instragram_username')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="text" placeholder="Soundee username (optional)" name="soundee_username"
                                    value="{{ old('soundee_username') }}" />
                                @error('soundee_username')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="text" placeholder="YouTube username (optional)" name="youtube_username"
                                    value="{{ old('youtube_username') }}" />
                                @error('youtube_username')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --}}

                                {{-- hide input end --}}

                                <div class="password--feild mt_25">
                                    <input type="password" placeholder="Password" name="password" />
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M15.5819 11.9999C15.5819 13.9799 13.9819 15.5799 12.0019 15.5799C10.0219 15.5799 8.42188 13.9799 8.42188 11.9999C8.42188 10.0199 10.0219 8.41992 12.0019 8.41992C13.9819 8.41992 15.5819 10.0199 15.5819 11.9999Z"
                                            stroke="#FFF5EB" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M11.9998 20.2702C15.5298 20.2702 18.8198 18.1902 21.1098 14.5902C22.0098 13.1802 22.0098 10.8102 21.1098 9.40021C18.8198 5.80021 15.5298 3.72021 11.9998 3.72021C8.46984 3.72021 5.17984 5.80021 2.88984 9.40021C1.98984 10.8102 1.98984 13.1802 2.88984 14.5902C5.17984 18.1902 8.46984 20.2702 11.9998 20.2702Z"
                                            stroke="#FFF5EB" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="password--feild mt_25">
                                    <input type="password" placeholder="Confirm Password" name="password_confirmation" />
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M15.5819 11.9999C15.5819 13.9799 13.9819 15.5799 12.0019 15.5799C10.0219 15.5799 8.42188 13.9799 8.42188 11.9999C8.42188 10.0199 10.0219 8.41992 12.0019 8.41992C13.9819 8.41992 15.5819 10.0199 15.5819 11.9999Z"
                                            stroke="#FFF5EB" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M11.9998 20.2702C15.5298 20.2702 18.8198 18.1902 21.1098 14.5902C22.0098 13.1802 22.0098 10.8102 21.1098 9.40021C18.8198 5.80021 15.5298 3.72021 11.9998 3.72021C8.46984 3.72021 5.17984 5.80021 2.88984 9.40021C1.98984 10.8102 1.98984 13.1802 2.88984 14.5902C5.17984 18.1902 8.46984 20.2702 11.9998 20.2702Z"
                                            stroke="#FFF5EB" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    @error('password_confirmation')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" id="login-btn" class="button w-100 mt_30">
                                Register As Producer
                            </button>
                            <p class="new--register">
                                By creating an account and/or logging in, you agree to MelodyCollab
                                <a href="{{ route('dynamic.page',['slug' => 'terms-of-service'])}}">Terms of Service</a> and <a href="{{ route('dynamic.page',['slug' => 'privacy-policy'])}}">Privacy Policy.</a>
                            </p>
                            <!-- new register  -->
                            <p class="new--register">
                                Already have an account? <a href="{{ route('login') }}"> Log In </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- auth area end  -->
@endsection

@push('script')
@endpush
