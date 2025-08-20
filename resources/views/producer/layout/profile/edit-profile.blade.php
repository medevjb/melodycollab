@extends('producer.app')

@section('title', 'My Profile')

@push('style')
    <style>
        #collab--popup--wrapp #collab--popup .feature {
            width: 477px;
            margin: 0 auto;
        }

        #collab--popup--wrapp #collab--popup {
            max-width: 765px !important;
            min-height: calc(100vh - 182px);
        }
    </style>
@endpush

@section('content')


    <!-- main content start  -->
    <section class="app--content">
        <!-- edit profile area start -->
        <section class="edit--profile--area">
            <h1 data-aos="zoom-in" data-aos-duration="1600">Edit Your Profile</h1>
            <form action="{{ route('producer.update.profile') }}" method="POST">
                @csrf
                <div class="edit--inputs" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">
                    <div class="row ">
                        <div class="col-md-6">
                            <input type="text" placeholder="Name" name="name"
                                value="{{ Auth::user()->name }}" />
                            @error('name')
                                <div class="error-message text-danger">{{ $message }}</div>
                            @enderror
                        </div>                       
                            <div class="col-md-6 email">
                                <input type="email" disabled placeholder="Email" value="{{ Auth::user()->email }}" />
                            </div>
                      
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" placeholder="Producer Name" name="producer_name"
                                value="{{ Auth::user()->producer_name }}" />
                            @error('producer_name')
                                <div class="error-message text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <select class="country-select" name="country">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ $country->id == auth()->user()->country_id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('country')
                                <div class="error-message text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- link start --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group has-validation" style="align-items:center">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <img src="{{ asset('frontend/images/beatstars.png') }}" width="20" alt="">
                                </span>
                                <input type="text" class="form-control" placeholder="Beatstars username"
                                    name="beatstars_username" value="{{ auth()->user()->beatstars_username }}">
                                @error('beatstars_username')
                                    <div class="error-message text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group has-validation" style="align-items:center">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <img src="{{ asset('frontend/images/Instagram_logo.png') }}" width="20"
                                        alt="">
                                </span>
                                <input type="text" class="form-control" placeholder="Instagram username"
                                    name="instagram_username" value="{{ auth()->user()->instagram_username }}">
                                @error('instagram_username')
                                    <div class="error-message text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group has-validation" style="align-items:center">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <img src="{{ asset('frontend/images/youtube.svg') }}" width="20" alt="">
                                </span>
                                <input type="text" class="form-control" placeholder="YouTube username (optional)"
                                    value="{{ auth()->user()->youtube_username }}" name="youtube_username">
                                @error('youtube_username')
                                    <div class="error-message text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group has-validation" style="align-items:center">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <img src="{{ asset('frontend/images/soundee-logo.webp') }}" width="20"
                                        alt="">
                                </span>
                                <input type="text" class="form-control" placeholder="Soundee username"
                                    name="soundee_username" value="{{ auth()->user()->soundee_username }}">
                                @error('soundee_username')
                                    <div class="error-message text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group has-validation" style="align-items:center">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <img src="{{ asset('frontend/images/TIKTOKICON.png') }}" width="20"
                                        alt="">
                                </span>
                                <input type="text" class="form-control" placeholder="Tiktok username"
                                    name="tiktok_username" value="{{ auth()->user()->tiktok_username }}">
                                @error('tiktok_username')
                                    <div class="error-message text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- link ends --}}
                    <div class="row mt-25">
                        <div class="col-md-12">
                            <textarea name="about" placeholder="About Me" class="form-control " id="about" cols="30"
                                rows="10">{{ auth()->user()->about }}</textarea>
                        </div>
                    </div>

                </div>
                <div class="update-btn">
                    <button class="button w-100 mt_30" data-aos="zoom-in" data-aos-duration="1600"
                        data-aos-delay="100">Update Profile</button>
                </div>
            </form>
        </section>
        <!-- edit profile area end -->
        <!-- edit profile area start -->
        <section class="edit--profile--area mt_100" data-aos="zoom-in" data-aos-duration="1600">
            <h1 data-aos="zoom-in" data-aos-duration="1600">Password & Security</h1>
            <form action="{{ route('producer.change.password') }}" method="POST">
                @csrf
                <div class="edit--inputs" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="password--feild mt_25">
                                <input type="password" placeholder="Old Password" name="old_password" />
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
                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 confirm-password">
                            <div class="password--feild mt_25">
                                <input type="password" placeholder="New Password" name="password" />

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
                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 confirm-password">
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
                                    <span class="invalid-feedback" role="alert">

                                        <strong>{{ $message }}</strong>

                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="update-btn">
                    <button type="submit" class="button w-100 mt_30" data-aos="zoom-in" data-aos-duration="1600"
                        data-aos-delay="100">Change Password</button>
                </div>
            </form>
        </section>


        <!-- Paypal Setting area start -->
        <section class="edit--profile--area mt_100" data-aos="zoom-in" data-aos-duration="1600">
            <h1 data-aos="zoom-in" data-aos-duration="1600">Payment (Paypal Setting)</h1>
            <form action="{{ route('producer.set.paypal') }}" method="POST">
                @csrf
                <div class="update-btn">
                    <button type="submit" class="button w-100 mt_30" data-aos="zoom-in" data-aos-duration="1600"
                        data-aos-delay="100">{{ auth()->user()->paypal_email != null ? 'Update Paypal' : 'Setup Paypal'}}</button>
                </div>
            </form>
            {{-- <form action="{{ route('producer.setup.paypal') }}" method="POST">
                @csrf
                <div class="edit--inputs" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100">

                    <div class="row">
                        <div class="col-md-6 confirm-password">
                            <div class="password--feild mt_25">
                                <textarea name="client_id" class="form-control" id="" cols="30" rows="5"
                                    placeholder="Paypal Client ID Ex: AejwlmhhXXXXXXXXXXXXXXXX....">{{ $paypal != null ? Crypt::decrypt($paypal?->client_id) : '' }}</textarea>
                                @error('client_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 confirm-password">
                            <div class="password--feild mt_25">
                                <textarea name="client_secret" class="form-control" id="" cols="30" rows="5"
                                    placeholder="Paypal Client ID Ex: EBgTEuImscXXXXXXXXXXXXXXXX....">{{ $paypal != null ? Crypt::decrypt($paypal?->client_secret) : '' }}</textarea>
                                @error('client_secret')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="update-btn">
                    <button type="submit" class="button w-100 mt_30" data-aos="zoom-in" data-aos-duration="1600"
                        data-aos-delay="100">Update Paypal</button>
                </div>
            </form> --}}
        </section>
        <!-- edit profile area end -->

        @if (Auth::check() && Auth::user()->hasMembership())
            <!-- Subscription Setting area start -->
            <section class="edit--profile--area mt_100 mb_100" data-aos="zoom-in" data-aos-duration="1600">
                <h1 data-aos="zoom-in" data-aos-duration="1600">Manage Subscription</h1>
                <div class="update-btn">
                    <button type="submit" id="ManageBtn" class="button w-100 mt_30" data-aos="zoom-in"
                        data-aos-duration="1600" data-aos-delay="100">Manage Subscription</button>
                </div>
            </section>
            <!-- edit profile area end -->
        @endif
    </section>


    <!-- main content end  -->
    <div class="collab-popup--wrapp" id="collab--popup--wrapp">

        <div id="collab--popup">
            <div class="modal-body mt-1 mb-2 " id="form-body">
                <div class="modal-header">
                    <div class="">
                        <div class="col-11">
                            <img class="logo-white img-fluid"
                                src="{{ asset($settings->logo ?? 'frontend/images/logo-white.png') }}" alt="" />
                            <img class="logo-black img-fluid"
                                src="{{ asset($settings->logo ?? 'frontend/images/logo-black.png') }}" alt="" />
                        </div>
                    </div>
                    <div class="col-1">
                        <button type="button" class="close text-light" id="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="modal-body">
                    <h3 class="text-center fw-bold mt-5 mb-4 text-uppercase">
                        IF YOU CANCEL YOUR MEMBERSHIP, YOU WILL LOSE ALL THESE BENEFITS:
                    </h3>
                    <ul class="feature">
                        <li>
                            <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                            You cannot sell Sample Packs
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                            You cannot upload unlimited melodies
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                            You will lose your custom Sample Pack store
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                            You cannot sell on Producer's Marketplace
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                            You cannot access your Pro Analytics Dashboard
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                            You will stop earning money from your sales
                        </li>
                    </ul>
                </div>

                <div class="modal-footer row mt-5">
                    <div class="col-lg-6 col-md-6 col-sm-6 d-flex justify-content-center">
                        <button type="button" id="CancleBtn" class="buttonv3 text-light border-0"
                        style="background-color: #c30010 !important;">Cancel Membership</button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 d-flex justify-content-center">
                        <button type="button" class="text-dark text-center buttonv3 text-light border-0" id="ContinueBtn">Continue with Pro</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('script')
        <script>
            let modal = document.getElementById("collab--popup--wrapp");
            $('#ContinueBtn').click(function() {
                modal.classList.remove("show");
            })
            $('#close').click(function() {
                modal.classList.remove("show");
            })


            $('#ManageBtn').click(function(e) {
                e.preventDefault();
                modal.classList.add("show");
            });
        </script>
    @endpush
