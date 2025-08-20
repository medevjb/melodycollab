@extends('frontend.app')

@section('title', 'Membership Checkout')

@push('style')
    <link rel="stylesheet" href="{{ asset('producers/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('producers/css/responsive.css') }}">
    <style>
        [data-theme="dark"] #collab--popup--wrapp #collab--popup {
            width: 700px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.23);
            background: rgba(18, 18, 18, 0.95);
            padding: 80px 122px;
            -webkit-box-shadow: 0px 3px 42px 0px var(--primary-color);
            box-shadow: 0px 3px 42px 0px var(--primary-color);
            position: fixed;
            height: auto;
            overflow-y: auto;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Adjust the card number field with card brand image */
        .card-number-field {
            margin-bottom: 20px;
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        #card-brand img {
            margin-right: 10px;
        }

        .form-control {
            padding: 14px 20px;
            font-size: 16px;
            border: 1px solid #ced4da;
            border-left: none;
            border-radius: 4px;
            border-radius: 10px;
        }

        .form-label {
            display: block;
        }

        #card-errors {
            color: #fa755a;
            margin-top: 10px;
        }

        .form-label {
            color: #d0cfcf;
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
            margin-bottom: 10px;
        }

        .input-group-text {
            height: 52px;
            overflow: hidden;
            border: none;
        }

        @media only screen and (min-width: 375px) and (max-width: 479px) {

            .checkout--area .checkout--left,
            .checkout--area .checkout--right {
                width: 90%;
                margin: 0 20px;
            }

        }

        header {
            left: 0 !important;
            width: 100% !important;
        }

        .reverse {
            display: flex;
            flex-direction: row-reverse;
        }

        footer .logo img {
            width: 211px;
            height: 50px;
            margin: 35px 0;
        }
        .logo-white,
        .logo-black {
            display: none;
        }
        footer{
            display: none;
        }
        .menu--wrapper .menu{
            visibility: hidden;
        }
        #responsive ul{
            display: none;
        }
    </style>
@endpush

@section('content')
    <!-- main content start  -->
    <section class="checkout--area">
        <div class="custom--row reverse">
            <!-- checkout--right  -->
            <div class="checkout--right checkout--left" data-aos="zoom-in" data-aos-duration="1600" data-aos-offset="0">
                <div class="free-trail-mobile">
                    <h2 class="title" data-aos="zoom-in" data-aos-duration="1600" data-aos-offset="0">
                        Start your {{ $membership->trail }}-day free
                        trial
                    </h2>
                    <p class="sub--title" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100" data-aos-offset="0">
                        Get access to all the benefits today for free and take your career
                        to the next level.
                    </p>
                    <!-- buy--button  -->
                    <a href="{{ route('producer.paypal.checkout') }}" class="buy--button" data-aos="zoom-in"
                        data-aos-duration="1600" data-aos-delay="100" data-aos-offset="0">
                        Buy with
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="16" viewBox="0 0 60 16"
                            fill="none">
                            <path
                                d="M22.4438 3.95703H19.128C18.9011 3.95703 18.7081 4.12188 18.6727 4.34588L17.3316 12.8487C17.3049 13.0164 17.4349 13.1677 17.6051 13.1677H19.1881C19.415 13.1677 19.608 13.0028 19.6434 12.7784L20.0051 10.485C20.04 10.2605 20.2334 10.0957 20.4598 10.0957H21.5095C23.6938 10.0957 24.9544 9.03873 25.2836 6.94418C25.432 6.02782 25.2899 5.30782 24.8608 4.80358C24.3895 4.24988 23.5537 3.95703 22.4438 3.95703ZM22.8264 7.06249C22.6451 8.2523 21.736 8.2523 20.8569 8.2523H20.3566L20.7076 6.03024C20.7285 5.89594 20.8448 5.79703 20.9806 5.79703H21.2099C21.8087 5.79703 22.3735 5.79703 22.6654 6.13836C22.8395 6.342 22.8928 6.64455 22.8264 7.06249Z"
                                fill="#253B80"></path>
                            <path
                                d="M32.354 7.02433H30.7662C30.6309 7.02433 30.514 7.12324 30.4932 7.25755L30.4229 7.70167L30.3119 7.5407C29.9681 7.04179 29.2016 6.875 28.4365 6.875C26.6818 6.875 25.1831 8.20397 24.8913 10.0682C24.7395 10.9982 24.9553 11.8874 25.4828 12.5075C25.9666 13.0777 26.659 13.3152 27.4828 13.3152C28.8966 13.3152 29.6806 12.4062 29.6806 12.4062L29.6098 12.8474C29.5831 13.0161 29.7131 13.1674 29.8823 13.1674H31.3126C31.54 13.1674 31.732 13.0025 31.7679 12.778L32.626 7.34336C32.6532 7.17609 32.5237 7.02433 32.354 7.02433ZM30.1407 10.1148C29.9875 11.0219 29.2675 11.6309 28.3492 11.6309C27.8881 11.6309 27.5196 11.483 27.283 11.2028C27.0483 10.9245 26.9591 10.5283 27.0338 10.0871C27.1768 9.18773 27.9089 8.55888 28.8132 8.55888C29.2641 8.55888 29.6306 8.7087 29.8721 8.99136C30.114 9.27694 30.21 9.67548 30.1407 10.1148Z"
                                fill="#253B80"></path>
                            <path
                                d="M40.8122 7.02441H39.2165C39.0643 7.02441 38.9213 7.10005 38.835 7.2266L36.6342 10.4683L35.7014 7.35314C35.6427 7.15823 35.4628 7.02441 35.2592 7.02441H33.6912C33.5007 7.02441 33.3683 7.2106 33.4289 7.38999L35.1865 12.5478L33.5341 14.8804C33.4042 15.0642 33.5351 15.3168 33.7596 15.3168H35.3533C35.5045 15.3168 35.6461 15.2431 35.7319 15.119L41.0391 7.45835C41.1661 7.27508 41.0357 7.02441 40.8122 7.02441Z"
                                fill="#253B80"></path>
                            <path
                                d="M46.0923 3.95703H42.7759C42.5495 3.95703 42.3565 4.12188 42.3211 4.34588L40.98 12.8487C40.9534 13.0164 41.0833 13.1677 41.2525 13.1677H42.9543C43.1124 13.1677 43.2477 13.0523 43.2724 12.8952L43.653 10.485C43.6879 10.2605 43.8814 10.0957 44.1078 10.0957H45.157C47.3417 10.0957 48.6019 9.03873 48.9316 6.94418C49.0804 6.02782 48.9374 5.30782 48.5083 4.80358C48.0375 4.24988 47.2021 3.95703 46.0923 3.95703ZM46.4748 7.06249C46.294 8.2523 45.3849 8.2523 44.5054 8.2523H44.0055L44.357 6.03024C44.3779 5.89594 44.4933 5.79703 44.6295 5.79703H44.8588C45.4571 5.79703 46.0225 5.79703 46.3143 6.13836C46.4884 6.342 46.5413 6.64455 46.4748 7.06249Z"
                                fill="#179BD7"></path>
                            <path
                                d="M56.0082 7.02433H54.4213C54.2851 7.02433 54.1692 7.12324 54.1488 7.25755L54.0785 7.70167L53.967 7.5407C53.6232 7.04179 52.8572 6.875 52.0921 6.875C50.3374 6.875 48.8392 8.20397 48.5474 10.0682C48.3961 10.9982 48.6109 11.8874 49.1384 12.5075C49.6232 13.0777 50.3146 13.3152 51.1384 13.3152C52.5522 13.3152 53.3362 12.4062 53.3362 12.4062L53.2654 12.8474C53.2388 13.0161 53.3687 13.1674 53.5389 13.1674H54.9687C55.1951 13.1674 55.3881 13.0025 55.4235 12.778L56.2822 7.34336C56.3083 7.17609 56.1784 7.02433 56.0082 7.02433ZM53.7949 10.1148C53.6426 11.0219 52.9217 11.6309 52.0034 11.6309C51.5432 11.6309 51.1738 11.483 50.9372 11.2028C50.7025 10.9245 50.6143 10.5283 50.688 10.0871C50.832 9.18773 51.5631 8.55888 52.4674 8.55888C52.9183 8.55888 53.2848 8.7087 53.5263 8.99136C53.7692 9.27694 53.8652 9.67548 53.7949 10.1148Z"
                                fill="#179BD7"></path>
                            <path
                                d="M57.8801 4.18975L56.5191 12.8482C56.4924 13.0159 56.6224 13.1672 56.7916 13.1672H58.1598C58.3872 13.1672 58.5802 13.0024 58.6151 12.7779L59.9572 4.27557C59.9838 4.10781 59.8539 3.95605 59.6847 3.95605H58.1526C58.0173 3.95654 57.9009 4.05545 57.8801 4.18975Z"
                                fill="#179BD7"></path>
                            <path
                                d="M3.56317 14.8195L3.81675 13.2088L3.2519 13.1957H0.554688L2.42911 1.3106C2.43493 1.27472 2.45384 1.24127 2.48148 1.21751C2.50911 1.19375 2.54451 1.18066 2.58135 1.18066H7.12923C8.63905 1.18066 9.68099 1.49485 10.225 2.11497C10.48 2.40588 10.6424 2.70988 10.721 3.04442C10.8034 3.39545 10.8049 3.81485 10.7244 4.32636L10.7186 4.36369V4.69145L10.9736 4.83594C11.1884 4.94988 11.3591 5.0803 11.49 5.22963C11.7081 5.47836 11.8492 5.79448 11.9089 6.16927C11.9704 6.55472 11.9501 7.01339 11.8492 7.53266C11.7329 8.13 11.5447 8.65024 11.2907 9.07594C11.057 9.46818 10.7593 9.79351 10.4058 10.0456C10.0684 10.2851 9.66741 10.467 9.21408 10.5833C8.77481 10.6978 8.27396 10.7555 7.72463 10.7555H7.37069C7.1176 10.7555 6.87178 10.8466 6.67881 11.01C6.48535 11.1768 6.35735 11.4047 6.31808 11.6539L6.29141 11.7988L5.84341 14.6376L5.82305 14.7419C5.81772 14.7748 5.80851 14.7913 5.79493 14.8025C5.78281 14.8127 5.76535 14.8195 5.74838 14.8195H3.56317Z"
                                fill="#253B80"></path>
                            <path
                                d="M11.2134 4.40234C11.1999 4.48913 11.1844 4.57786 11.1669 4.66901C10.5671 7.74828 8.51526 8.81204 5.89466 8.81204H4.56036C4.23987 8.81204 3.96981 9.04477 3.91987 9.36089L3.23672 13.6935L3.04326 14.9216C3.01078 15.1291 3.17078 15.3163 3.38023 15.3163H5.74678C6.02702 15.3163 6.26508 15.1126 6.3092 14.8363L6.33248 14.716L6.77805 11.8884L6.80666 11.7333C6.85029 11.4559 7.08884 11.2523 7.36908 11.2523H7.72302C10.0159 11.2523 11.8108 10.3214 12.3354 7.62756C12.5545 6.50222 12.4411 5.56259 11.8612 4.90174C11.6857 4.70246 11.468 4.53713 11.2134 4.40234Z"
                                fill="#179BD7"></path>
                            <path
                                d="M10.5881 4.1518C10.4964 4.12513 10.4019 4.10089 10.3049 4.07907C10.2075 4.05774 10.1076 4.03883 10.0048 4.02234C9.64503 3.96416 9.25084 3.93652 8.82854 3.93652H5.26394C5.17618 3.93652 5.09278 3.9564 5.01812 3.99228C4.85375 4.07131 4.73157 4.22695 4.702 4.41749L3.94369 9.2204L3.92188 9.36052C3.97181 9.0444 4.24188 8.81167 4.56236 8.81167H5.89666C8.51727 8.81167 10.5691 7.74743 11.1689 4.66864C11.1868 4.57749 11.2019 4.48877 11.2155 4.40198C11.0637 4.32149 10.8993 4.25264 10.7224 4.19398C10.6787 4.17943 10.6336 4.16537 10.5881 4.1518Z"
                                fill="#222D65"></path>
                            <path
                                d="M4.70039 4.41742C4.72997 4.22687 4.85215 4.07124 5.01651 3.99269C5.09166 3.95681 5.17457 3.93693 5.26233 3.93693H8.82693C9.24924 3.93693 9.64342 3.96457 10.0032 4.02275C10.106 4.03924 10.2058 4.05815 10.3033 4.07948C10.4003 4.1013 10.4948 4.12554 10.5864 4.15221C10.632 4.16578 10.6771 4.17984 10.7212 4.1939C10.8982 4.25257 11.0626 4.3219 11.2143 4.4019C11.3928 3.26396 11.2129 2.48918 10.5976 1.7876C9.9193 1.01524 8.69506 0.68457 7.12851 0.68457H2.58063C2.26063 0.68457 1.98766 0.917298 1.93821 1.2339L0.0439056 13.2412C0.00657224 13.4788 0.189845 13.6931 0.42936 13.6931H3.23712L3.94209 9.22033L4.70039 4.41742Z"
                                fill="#253B80"></path>
                        </svg>
                    </a>
                </div>
                <!-- pricing--card  -->
                <div class="pricing--card">
                    <!-- card--top  -->
                    <div class="card--top">
                        <p class="title-sm title--common">You’re paying</p>
                        <h3 class="price--lg">$0.00</h3>
                    </div>
                    <!-- free--trail  -->
                    <div class="free--trail">
                        <p class="trail--title">Free Pro Trial</p>
                        <p class="trail--price title--common">$ 0.00</p>
                    </div>
                    <!-- future--payments--wrap  -->
                    <div class="future--payments--wrap">
                        <!-- future--payments  -->
                        <div class="future--payments">
                            <!-- left  -->
                            <div class="left">
                                <p class="payments--left--title">Future payments</p>
                                <p class="payments-left--sm--title">Starting on
                                    {{ Carbon\Carbon::now()->addDays($membership->trail)->format('F j, Y') }}</p>
                            </div>
                            <p class="price title--common">$ {{ $membership->price }}</p>
                        </div>
                        <!-- total--price  -->
                        <div class="total--price d-flex align-items-center justify-content-between">
                            <p class="total--title">Total</p>
                            <p class="total--price title--common">$ 0.00</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- checkout--left  -->
            <div class="checkout--left">
                <div class="free-trail-desktop">
                    <h2 class="title" data-aos="zoom-in" data-aos-duration="1600" data-aos-offset="0">
                        Start your {{ $membership->trail }}-day free
                        trial
                    </h2>
                    <p class="sub--title" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="100" data-aos-offset="0">
                        Get access to all the benefits today for free and take your career
                        to the next level.
                    </p>
                    <!-- buy--button  -->
                    <a href="{{ route('producer.paypal.checkout') }}" class="buy--button" data-aos="zoom-in"
                        data-aos-duration="1600" data-aos-delay="100" data-aos-offset="0">
                        Buy with
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="16" viewBox="0 0 60 16"
                            fill="none">
                            <path
                                d="M22.4438 3.95703H19.128C18.9011 3.95703 18.7081 4.12188 18.6727 4.34588L17.3316 12.8487C17.3049 13.0164 17.4349 13.1677 17.6051 13.1677H19.1881C19.415 13.1677 19.608 13.0028 19.6434 12.7784L20.0051 10.485C20.04 10.2605 20.2334 10.0957 20.4598 10.0957H21.5095C23.6938 10.0957 24.9544 9.03873 25.2836 6.94418C25.432 6.02782 25.2899 5.30782 24.8608 4.80358C24.3895 4.24988 23.5537 3.95703 22.4438 3.95703ZM22.8264 7.06249C22.6451 8.2523 21.736 8.2523 20.8569 8.2523H20.3566L20.7076 6.03024C20.7285 5.89594 20.8448 5.79703 20.9806 5.79703H21.2099C21.8087 5.79703 22.3735 5.79703 22.6654 6.13836C22.8395 6.342 22.8928 6.64455 22.8264 7.06249Z"
                                fill="#253B80"></path>
                            <path
                                d="M32.354 7.02433H30.7662C30.6309 7.02433 30.514 7.12324 30.4932 7.25755L30.4229 7.70167L30.3119 7.5407C29.9681 7.04179 29.2016 6.875 28.4365 6.875C26.6818 6.875 25.1831 8.20397 24.8913 10.0682C24.7395 10.9982 24.9553 11.8874 25.4828 12.5075C25.9666 13.0777 26.659 13.3152 27.4828 13.3152C28.8966 13.3152 29.6806 12.4062 29.6806 12.4062L29.6098 12.8474C29.5831 13.0161 29.7131 13.1674 29.8823 13.1674H31.3126C31.54 13.1674 31.732 13.0025 31.7679 12.778L32.626 7.34336C32.6532 7.17609 32.5237 7.02433 32.354 7.02433ZM30.1407 10.1148C29.9875 11.0219 29.2675 11.6309 28.3492 11.6309C27.8881 11.6309 27.5196 11.483 27.283 11.2028C27.0483 10.9245 26.9591 10.5283 27.0338 10.0871C27.1768 9.18773 27.9089 8.55888 28.8132 8.55888C29.2641 8.55888 29.6306 8.7087 29.8721 8.99136C30.114 9.27694 30.21 9.67548 30.1407 10.1148Z"
                                fill="#253B80"></path>
                            <path
                                d="M40.8122 7.02441H39.2165C39.0643 7.02441 38.9213 7.10005 38.835 7.2266L36.6342 10.4683L35.7014 7.35314C35.6427 7.15823 35.4628 7.02441 35.2592 7.02441H33.6912C33.5007 7.02441 33.3683 7.2106 33.4289 7.38999L35.1865 12.5478L33.5341 14.8804C33.4042 15.0642 33.5351 15.3168 33.7596 15.3168H35.3533C35.5045 15.3168 35.6461 15.2431 35.7319 15.119L41.0391 7.45835C41.1661 7.27508 41.0357 7.02441 40.8122 7.02441Z"
                                fill="#253B80"></path>
                            <path
                                d="M46.0923 3.95703H42.7759C42.5495 3.95703 42.3565 4.12188 42.3211 4.34588L40.98 12.8487C40.9534 13.0164 41.0833 13.1677 41.2525 13.1677H42.9543C43.1124 13.1677 43.2477 13.0523 43.2724 12.8952L43.653 10.485C43.6879 10.2605 43.8814 10.0957 44.1078 10.0957H45.157C47.3417 10.0957 48.6019 9.03873 48.9316 6.94418C49.0804 6.02782 48.9374 5.30782 48.5083 4.80358C48.0375 4.24988 47.2021 3.95703 46.0923 3.95703ZM46.4748 7.06249C46.294 8.2523 45.3849 8.2523 44.5054 8.2523H44.0055L44.357 6.03024C44.3779 5.89594 44.4933 5.79703 44.6295 5.79703H44.8588C45.4571 5.79703 46.0225 5.79703 46.3143 6.13836C46.4884 6.342 46.5413 6.64455 46.4748 7.06249Z"
                                fill="#179BD7"></path>
                            <path
                                d="M56.0082 7.02433H54.4213C54.2851 7.02433 54.1692 7.12324 54.1488 7.25755L54.0785 7.70167L53.967 7.5407C53.6232 7.04179 52.8572 6.875 52.0921 6.875C50.3374 6.875 48.8392 8.20397 48.5474 10.0682C48.3961 10.9982 48.6109 11.8874 49.1384 12.5075C49.6232 13.0777 50.3146 13.3152 51.1384 13.3152C52.5522 13.3152 53.3362 12.4062 53.3362 12.4062L53.2654 12.8474C53.2388 13.0161 53.3687 13.1674 53.5389 13.1674H54.9687C55.1951 13.1674 55.3881 13.0025 55.4235 12.778L56.2822 7.34336C56.3083 7.17609 56.1784 7.02433 56.0082 7.02433ZM53.7949 10.1148C53.6426 11.0219 52.9217 11.6309 52.0034 11.6309C51.5432 11.6309 51.1738 11.483 50.9372 11.2028C50.7025 10.9245 50.6143 10.5283 50.688 10.0871C50.832 9.18773 51.5631 8.55888 52.4674 8.55888C52.9183 8.55888 53.2848 8.7087 53.5263 8.99136C53.7692 9.27694 53.8652 9.67548 53.7949 10.1148Z"
                                fill="#179BD7"></path>
                            <path
                                d="M57.8801 4.18975L56.5191 12.8482C56.4924 13.0159 56.6224 13.1672 56.7916 13.1672H58.1598C58.3872 13.1672 58.5802 13.0024 58.6151 12.7779L59.9572 4.27557C59.9838 4.10781 59.8539 3.95605 59.6847 3.95605H58.1526C58.0173 3.95654 57.9009 4.05545 57.8801 4.18975Z"
                                fill="#179BD7"></path>
                            <path
                                d="M3.56317 14.8195L3.81675 13.2088L3.2519 13.1957H0.554688L2.42911 1.3106C2.43493 1.27472 2.45384 1.24127 2.48148 1.21751C2.50911 1.19375 2.54451 1.18066 2.58135 1.18066H7.12923C8.63905 1.18066 9.68099 1.49485 10.225 2.11497C10.48 2.40588 10.6424 2.70988 10.721 3.04442C10.8034 3.39545 10.8049 3.81485 10.7244 4.32636L10.7186 4.36369V4.69145L10.9736 4.83594C11.1884 4.94988 11.3591 5.0803 11.49 5.22963C11.7081 5.47836 11.8492 5.79448 11.9089 6.16927C11.9704 6.55472 11.9501 7.01339 11.8492 7.53266C11.7329 8.13 11.5447 8.65024 11.2907 9.07594C11.057 9.46818 10.7593 9.79351 10.4058 10.0456C10.0684 10.2851 9.66741 10.467 9.21408 10.5833C8.77481 10.6978 8.27396 10.7555 7.72463 10.7555H7.37069C7.1176 10.7555 6.87178 10.8466 6.67881 11.01C6.48535 11.1768 6.35735 11.4047 6.31808 11.6539L6.29141 11.7988L5.84341 14.6376L5.82305 14.7419C5.81772 14.7748 5.80851 14.7913 5.79493 14.8025C5.78281 14.8127 5.76535 14.8195 5.74838 14.8195H3.56317Z"
                                fill="#253B80"></path>
                            <path
                                d="M11.2134 4.40234C11.1999 4.48913 11.1844 4.57786 11.1669 4.66901C10.5671 7.74828 8.51526 8.81204 5.89466 8.81204H4.56036C4.23987 8.81204 3.96981 9.04477 3.91987 9.36089L3.23672 13.6935L3.04326 14.9216C3.01078 15.1291 3.17078 15.3163 3.38023 15.3163H5.74678C6.02702 15.3163 6.26508 15.1126 6.3092 14.8363L6.33248 14.716L6.77805 11.8884L6.80666 11.7333C6.85029 11.4559 7.08884 11.2523 7.36908 11.2523H7.72302C10.0159 11.2523 11.8108 10.3214 12.3354 7.62756C12.5545 6.50222 12.4411 5.56259 11.8612 4.90174C11.6857 4.70246 11.468 4.53713 11.2134 4.40234Z"
                                fill="#179BD7"></path>
                            <path
                                d="M10.5881 4.1518C10.4964 4.12513 10.4019 4.10089 10.3049 4.07907C10.2075 4.05774 10.1076 4.03883 10.0048 4.02234C9.64503 3.96416 9.25084 3.93652 8.82854 3.93652H5.26394C5.17618 3.93652 5.09278 3.9564 5.01812 3.99228C4.85375 4.07131 4.73157 4.22695 4.702 4.41749L3.94369 9.2204L3.92188 9.36052C3.97181 9.0444 4.24188 8.81167 4.56236 8.81167H5.89666C8.51727 8.81167 10.5691 7.74743 11.1689 4.66864C11.1868 4.57749 11.2019 4.48877 11.2155 4.40198C11.0637 4.32149 10.8993 4.25264 10.7224 4.19398C10.6787 4.17943 10.6336 4.16537 10.5881 4.1518Z"
                                fill="#222D65"></path>
                            <path
                                d="M4.70039 4.41742C4.72997 4.22687 4.85215 4.07124 5.01651 3.99269C5.09166 3.95681 5.17457 3.93693 5.26233 3.93693H8.82693C9.24924 3.93693 9.64342 3.96457 10.0032 4.02275C10.106 4.03924 10.2058 4.05815 10.3033 4.07948C10.4003 4.1013 10.4948 4.12554 10.5864 4.15221C10.632 4.16578 10.6771 4.17984 10.7212 4.1939C10.8982 4.25257 11.0626 4.3219 11.2143 4.4019C11.3928 3.26396 11.2129 2.48918 10.5976 1.7876C9.9193 1.01524 8.69506 0.68457 7.12851 0.68457H2.58063C2.26063 0.68457 1.98766 0.917298 1.93821 1.2339L0.0439056 13.2412C0.00657224 13.4788 0.189845 13.6931 0.42936 13.6931H3.23712L3.94209 9.22033L4.70039 4.41742Z"
                                fill="#253B80"></path>
                        </svg>
                    </a>
                </div>
                <div class="payment--box aos-init aos-animate">
                    <form action="#" id="payment-form">
                        <div id="collab--popup">
                            <div class="modal-body mt-1 mb-2 " id="form-body">
                                <!-- Card Number Field with Card Brand Image -->
                                <div class="form-group card-number-field">
                                    <label for="card-number" class="form-label">Card Number</label>
                                    <div class="input-group">
                                        <span id="card-brand" class="input-group-text">
                                            <img id="card-brand-image" src="{{ asset('frontend/images/mastercard.png') }}"
                                                alt="Card Brand" width="40">
                                        </span>
                                        <div id="card-number-element" class="form-control"></div>
                                    </div>
                                </div>

                                <div class="row d-flex align-items-center">
                                    <div class="col-6">
                                        <!-- Expiration Date Field -->
                                        <div class="form-group card-number-field">
                                            <label for="card-expiry" class="form-label">Expiration Date</label>
                                            <div id="card-expiry-element" class="form-control"></div>
                                        </div>


                                    </div>

                                    <div class="col-6">
                                        <!-- CVC Field -->
                                        <div class="form-group card-number-field">
                                            <label for="card-cvc" class="form-label">CVC</label>
                                            <div id="card-cvc-element" class="form-control"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Error Message -->
                                <div id="card-errors" role="alert" class="text-danger"></div>

                            </div>
                            <div class="modal-footer d-flex gap-2 mt-2">
                                <button type="submit" class="trial--button " id="BuyBtn">Start Pro
                                    Trial</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- main content end  -->



    <div class="collab-popup--wrapp" id="collab--popup--wrapp">
        <form action="#" id="payment-form">
            <div id="collab--popup">
                <div class="modal-body mt-1 mb-2 " id="form-body">
                    <!-- Card Number Field with Card Brand Image -->
                    <div class="form-group card-number-field">
                        <label for="card-number" class="form-label">Card Number</label>
                        <div class="input-group">
                            <span id="card-brand" class="input-group-text">
                                <img id="card-brand-image" src="{{ asset('frontend/images/mastercard.png') }}"
                                    alt="Card Brand" width="40">
                            </span>
                            <div id="card-number-element" class="form-control"></div>
                        </div>
                    </div>

                    <div class="row d-flex align-items-center">
                        <div class="col-6">
                            <!-- Expiration Date Field -->
                            <div class="form-group card-number-field">
                                <label for="card-expiry" class="form-label">Expiration Date</label>
                                <div id="card-expiry-element" class="form-control"></div>
                            </div>


                        </div>

                        <div class="col-6">
                            <!-- CVC Field -->
                            <div class="form-group card-number-field">
                                <label for="card-cvc" class="form-label">CVC</label>
                                <div id="card-cvc-element" class="form-control"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div id="card-errors" role="alert" class="text-danger"></div>

                </div>
                <div class="modal-footer d-flex gap-2 mt-5">
                    <button type="button" class="buttonv3 text-light close border-0"
                        style="background-color: #c30010 !important;">Close</button>
                    <button type="submit" class="buttonv3 text-light border-0" id="BuyBtn">Start Pro Trial</button>
                </div>
            </div>
        </form>
    </div>


    {{-- Buy Plan --}}
    {{--  --}}
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        let modal = document.getElementById("collab--popup--wrapp");
        $('.close').click(function() {
            modal.classList.remove("show");
        })


        $('#confirmBtn').click(function(e) {
            e.preventDefault();
            modal.classList.add("show");
        });




        // Ensure Stripe.js is loaded
        if (window.Stripe) {
            var stripe = Stripe("{{ env('STRIPE_PUBLIC_KEY') }}");
            var elements = stripe.elements();

            // Custom styling for the Stripe Elements, including height
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    border: 'none',
                    fontSize: '18px', // Larger font size to help achieve 50px heigh
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create Stripe Elements for card number, expiry, and CVC
            var cardNumberElement = elements.create('cardNumber', {
                style: style
            });
            var cardExpiryElement = elements.create('cardExpiry', {
                style: style
            });
            var cardCvcElement = elements.create('cardCvc', {
                style: style
            });

            // Mount the Stripe Elements to the divs
            cardNumberElement.mount('#card-number-element');
            cardExpiryElement.mount('#card-expiry-element');
            cardCvcElement.mount('#card-cvc-element');

            // Handle real-time validation and card brand detection
            var displayError = document.getElementById('card-errors');
            var cardBrandImage = document.getElementById('card-brand-image');

            cardNumberElement.on('change', function(event) {
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }

                // Detect the card brand and change the card brand image
                var brand = event.brand;
                switch (brand) {
                    case 'visa':
                        cardBrandImage.src = "{{ asset('frontend/images/visa.png') }}";
                        break;
                    case 'mastercard':
                        cardBrandImage.src = "{{ asset('frontend/images/mastercard.png') }}";
                        break;
                    case 'amex':
                        cardBrandImage.src = "{{ asset('frontend/images/amex-card.png') }}";
                        break;
                    case 'discover':
                        cardBrandImage.src = "{{ asset('frontend/images/discover.png') }}";
                        break;
                    default:
                        cardBrandImage.src = "{{ asset('frontend/images/default-card.png') }}"; // Default image
                        break;
                }
            });


            // Handle form submission
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                let btn = document.getElementById('BuyBtn');
                btn.innerHTML =
                    'Please Wait...<i class="fa fa-circle-o-notch fa-spin my-2" style="font-size:23px"></i>';
                btn.setAttribute('disabled', true); // Disable the button while processing

                stripe.createToken(cardNumberElement).then(function(result) {
                    if (result.error) {
                        displayError.textContent = result.error.message;
                        btn.innerHTML = 'Confirm'; // Reset button text
                        btn.removeAttribute('disabled'); // Re-enable the button
                    } else {
                        createSubscription(result.token)
                    }
                });
            });


        }



        function createSubscription(token) {

            let btn = document.getElementById('BuyBtn');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('producer.store.subscription') }}",
                data: {
                    data: token,
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(() => {
                            window.location.href = "{{ route('producer.payment.success') }}";
                        }, 2000);
                    } else {
                        toastr.error(response.message??response.data);
                        modal.classList.remove("show");
                    }
                },
                error: function(error) {
                    toastr.error("Error:", error.message);
                    btn.innerHTML =
                        'Buy Plan';
                    btn.removeAttribute('disabled');
                    $('.btn-danger').show();

                }
            })
        }
    </script>
@endpush
