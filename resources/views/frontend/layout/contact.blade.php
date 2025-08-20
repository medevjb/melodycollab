@extends('frontend.app')

@section('title', 'Contact Us')

@push('style')
@endpush

@section('content')
    <!-- contact us section starts -->
    <section data-aos="fade-up" data-aos-anchor-placement="center-bottom" data-aos-duration="2000"
        class="sm--contact-us-section-container">
        <div class="container">
            <div class="sm--contact-us-text-container">
                <h1>{{ $system->contact_title ?? 'We Are Here to Help' }}</h1>
                <div class="sm--phone-svg-and-text-container">
                    <h4>
                        If you have any questions or issues, let us know. Fill out the form and we’ll get back to you soon.
                    </h4>
                </div>
                {{-- <div class="sm--email-svg-and-text-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none">
                        <path
                            d="M17 20.5H7C4 20.5 2 19 2 15.5V8.5C2 5 4 3.5 7 3.5H17C20 3.5 22 5 22 8.5V15.5C22 19 20 20.5 17 20.5Z"
                            stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M17 9L13.87 11.5C12.84 12.32 11.15 12.32 10.12 11.5L7 9" stroke="#292D32"
                            stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <h4>Email: {{ $system->email ?? '' }}</h4>
                </div>

                <div class="sm--location-svg-and-text-container">
                    <div style="display: flex; gap: 9px; align-items: top;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M11.9578 23.0173L11.3183 22.4691C10.4367 21.7309 2.73853 15.0825 2.73853 10.2193C2.73853 5.12764 6.86617 1 11.9578 1C17.0495 1 21.1772 5.12764 21.1772 10.2193C21.1772 15.0825 13.479 21.7309 12.601 22.4728L11.9578 23.0173ZM11.9578 2.99349C7.96902 2.998 4.73657 6.23046 4.73205 10.2193C4.73205 13.2744 9.46826 18.155 11.9578 20.3888C14.4475 18.1541 19.1836 13.2707 19.1836 10.2193C19.1791 6.23046 15.9467 2.99805 11.9578 2.99349Z"
                                fill="#fff" />
                            <path
                                d="M11.9579 13.8738C9.93963 13.8738 8.30347 12.2376 8.30347 10.2193C8.30347 8.20101 9.93963 6.56485 11.9579 6.56485C13.9762 6.56485 15.6124 8.20101 15.6124 10.2193C15.6124 12.2376 13.9763 13.8738 11.9579 13.8738ZM11.9579 8.39204C10.9488 8.39204 10.1307 9.21012 10.1307 10.2193C10.1307 11.2284 10.9488 12.0465 11.9579 12.0465C12.9671 12.0465 13.7852 11.2284 13.7852 10.2193C13.7852 9.21012 12.9671 8.39204 11.9579 8.39204Z"
                                fill="#fff" />
                        </svg>
                        <h4 style="line-height: 24px">Address:</h4>
                        <h4>{!! $system->contact_address ?? '' !!}</h4>
                    </div>
                </div> --}}
            </div>
            {{--  form for admin Mail start --}}
            <form action="{{ route('contact.AdminMail') }}" method="POST">
                @csrf
                <div class="sm--contact-us-field-container">
                    <div class="sm--contact-us-field-left">
                        <div class="sm--name-input-container">
                            <input placeholder="Your Name" type="text" name="name" id="name" />
                        </div>
                        <div class="sm--email-input-container">
                            <input placeholder="Your Email" type="email" name="email" id="email" />
                        </div>
                    </div>
                    <div class="sm--contact-us-field-right">
                        <div class="sm--textarea-input-container">
                            <textarea placeholder="Your Message" name="message" id="message"></textarea>
                        </div>
                    </div>
                </div>
                <div class="sm--send-message-button-container">
                    <button type="submit">
                        Send Message
                    </button>
                </div>
            </form>
            {{--  form for admin Mail end --}}
        </div>
    </section>
@endsection

@push('script')
@endpush
