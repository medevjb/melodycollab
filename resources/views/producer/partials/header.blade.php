<!-- header start  -->
<header>
    <div class="row align-items-center justify-content-between" style="position: relative;">
        <div class="btn-dashboard col-md-1 col-1">
            <div id="hamburger--dashboard" class="hamburger">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M3 6h18M3 12h18M3 18h18" stroke="#8F8F8F" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <div id="responsive--dashboard" class="dashboard--nav">
                <div class="close">
                    <div id="close--menu--dashboard" class="close--menu" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path d="M18 6L6 18M6 6l12 12" stroke="#8F8F8F" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <div class="dashboard--logo">
                    <a href="{{ route('producer.dashboard') }}" class="logo">
                        <img class="logo-white" src="{{ asset($setting->logo ?? 'frontend/images/logo-white.png') }}"
                            alt="" />
                        <img class="logo-black" src="{{ asset($setting->logo ?? 'frontend/images/logo-black.png') }}"
                            alt="" />
                    </a>
                </div>
                <ul class="menu--top" style="margin-bottom: 20px">

                    <li>
                        <a href="{{ route('producer.dashboard') }}"
                            class="{{ request()->routeIs('producer.dashboard') ? 'active' : '' }}">
                            <img class="menu-icon-white dashboartd-icon"
                                src="{{ asset('frontend/images/dashboard.png') }}" alt="">
                            <img class="menu-icon-black dashboartd-icon"
                                src="{{ asset('frontend/images/dashboard-black.png') }}" alt="">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('producer.browse') }}"
                            class="{{ request()->routeIs(['producer.browse', 'producer.melody*']) ? 'active' : '' }}">
                            <img class="menu-icon-white dashboartd-icon" src="{{ asset('frontend/images/Browse.png') }}"
                                alt="">
                            <img class="menu-icon-black dashboartd-icon"
                                src="{{ asset('frontend/images/Browse-black.png') }}" alt="">
                            Browse
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('producer.all.producers') }}"
                            class="{{ request()->routeIs(['producer.all.producers', 'producer.producers.profile']) ? 'active' : '' }}">
                            <img class="menu-icon-white dashboartd-icon"
                                src="{{ asset('frontend/images/Producers.png') }}" alt="">
                            <img class="menu-icon-black dashboartd-icon"
                                src="{{ asset('frontend/images/Producers-black.png') }}" alt="">
                            Producers
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('producer.marketplace') }}"
                            class="{{ request()->routeIs(['producer.marketplace', 'producer.pack*']) ? 'active' : '' }}">
                            <img class="menu-icon-white dashboartd-icon"
                                src="{{ asset('frontend/images/marketplace.png') }}" alt="">
                            <img class="menu-icon-black dashboartd-icon"
                                src="{{ asset('frontend/images/marketplace-black.png') }}" alt="">
                            Marketplace
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('producer.feed') }}"
                            class="{{ request()->routeIs('producer.feed') ? 'active' : '' }}">
                            <img class="menu-icon-white dashboartd-icon" src="{{ asset('frontend/images/Feed.png') }}"
                                alt="">
                            <img class="menu-icon-black dashboartd-icon"
                                src="{{ asset('frontend/images/Feed-black.png') }}" alt="">
                            Feed
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('producer.my.profile') }}"
                            class="{{ request()->routeIs(['producer.my.profile', 'producer.edit.profile']) ? 'active' : '' }}">
                            <img class="menu-icon-white dashboartd-icon" src="{{ asset('frontend/images/user.png') }}"
                                alt="">
                            <img class="menu-icon-black dashboartd-icon"
                                src="{{ asset('frontend/images/user-black.png') }}" alt="">
                            Profile
                        </a>
                    </li>
                </ul>
                @if (!auth()->user()->hasMembership())
                    <ul class="menu--bottom">
                        <li>
                            <a href="{{ route('producer.membership', ['type' => Str::slug('Pro')]) }}">
                                <img class="dashboartd-icon" src="{{ asset('frontend/images/pro-icon.png') }}"
                                    alt="">

                                Become a PRO
                            </a>
                        </li>
                    </ul>
                @endif
                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    style="cursor: pointer" class="log--out">
                    <svg width="18px" height="18px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12.9999 2C10.2385 2 7.99991 4.23858 7.99991 7C7.99991 7.55228 8.44762 8 8.99991 8C9.55219 8 9.99991 7.55228 9.99991 7C9.99991 5.34315 11.3431 4 12.9999 4H16.9999C18.6568 4 19.9999 5.34315 19.9999 7V17C19.9999 18.6569 18.6568 20 16.9999 20H12.9999C11.3431 20 9.99991 18.6569 9.99991 17C9.99991 16.4477 9.55219 16 8.99991 16C8.44762 16 7.99991 16.4477 7.99991 17C7.99991 19.7614 10.2385 22 12.9999 22H16.9999C19.7613 22 21.9999 19.7614 21.9999 17V7C21.9999 4.23858 19.7613 2 16.9999 2H12.9999Z"
                            fill="#000000" />
                        <path
                            d="M13.9999 11C14.5522 11 14.9999 11.4477 14.9999 12C14.9999 12.5523 14.5522 13 13.9999 13V11Z"
                            fill="#000000" />
                        <path
                            d="M5.71783 11C5.80685 10.8902 5.89214 10.7837 5.97282 10.682C6.21831 10.3723 6.42615 10.1004 6.57291 9.90549C6.64636 9.80795 6.70468 9.72946 6.74495 9.67492L6.79152 9.61162L6.804 9.59454L6.80842 9.58848C6.80846 9.58842 6.80892 9.58778 5.99991 9L6.80842 9.58848C7.13304 9.14167 7.0345 8.51561 6.58769 8.19098C6.14091 7.86637 5.51558 7.9654 5.19094 8.41215L5.18812 8.41602L5.17788 8.43002L5.13612 8.48679C5.09918 8.53682 5.04456 8.61033 4.97516 8.7025C4.83623 8.88702 4.63874 9.14542 4.40567 9.43937C3.93443 10.0337 3.33759 10.7481 2.7928 11.2929L2.08569 12L2.7928 12.7071C3.33759 13.2519 3.93443 13.9663 4.40567 14.5606C4.63874 14.8546 4.83623 15.113 4.97516 15.2975C5.04456 15.3897 5.09918 15.4632 5.13612 15.5132L5.17788 15.57L5.18812 15.584L5.19045 15.5872C5.51509 16.0339 6.14091 16.1336 6.58769 15.809C7.0345 15.4844 7.13355 14.859 6.80892 14.4122L5.99991 15C6.80892 14.4122 6.80897 14.4123 6.80892 14.4122L6.804 14.4055L6.79152 14.3884L6.74495 14.3251C6.70468 14.2705 6.64636 14.1921 6.57291 14.0945C6.42615 13.8996 6.21831 13.6277 5.97282 13.318C5.89214 13.2163 5.80685 13.1098 5.71783 13H13.9999V11H5.71783Z"
                            fill="#000000" />
                    </svg>
                    Log Out

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </a>
                <div class="mt-4">
                    {{-- <div id="google_translate_element"></div> --}}
                </div>
                </ul>
            </div>
        </div>
        <!-- page--name  -->

        <div class="col-md-3 col-3" data-aos="fade-in" data-aos-duration="1600">
        </div>
        <div class="col-md-8 col-8">
            <!-- header--right--wrapper -->
            <div class="header--right--wrapper">
                <div data-aos="fade-in" data-aos-duration="1600" data-aos-delay="150">
                    <form action="{{ route('producer.search') }}">
                        <input id="header-search" type="text" name="search" placeholder="Search here" />
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" class="open-search">
                                <!-- SVG path... -->
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" class="close-search">
                                <!-- SVG path... -->
                            </svg>
                        </button>
                    </form>
                    <!-- mobile--search--trigger  -->
                    <p class="mobile--search--trigger d-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" class="open-mobile-search">
                            <!-- SVG path... -->
                        </svg>
                    </p>

                </div>

                <!-- profile  -->
                <div class="profile" data-aos="fade-in" data-aos-duration="1600" data-aos-delay="200">
                    <!-- toggler-->
                    <div class="toggler">
                        <img src="{{ asset(auth()->user()->avatar ?? 'backend/images/user-cover.jpg') }}"
                            alt="" />
                        <p>Profile</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17"
                            fill="none">
                            <path
                                d="M13.2787 6.46667L8.93208 10.8133C8.41875 11.3267 7.57875 11.3267 7.06542 10.8133L2.71875 6.46667"
                                stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <!-- dropdown  -->
                    <div class="dropdown">
                        <ul>
                            <li>
                                <a href="{{ route('producer.edit.profile') }}">
                                    <span
                                        style="position: relative; display: inline-block; width: 20px; height: 20px;">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/B_Manage Account.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/W_ManageAccount.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">
                                    </span>
                                    Manage Account
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('producer.my.items') }}">
                                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15"
                                        viewBox="0 0 14 15" fill="none">
                                        <path
                                            d="M12.8333 6.85832V2.89166C12.8333 2.01666 12.46 1.66666 11.5325 1.66666H9.17583C8.24833 1.66666 7.875 2.01666 7.875 2.89166V6.85832C7.875 7.73332 8.24833 8.08332 9.17583 8.08332H11.5325C12.46 8.08332 12.8333 7.73332 12.8333 6.85832Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M12.8333 12.1083V11.0583C12.8333 10.1833 12.46 9.83334 11.5325 9.83334H9.17583C8.24833 9.83334 7.875 10.1833 7.875 11.0583V12.1083C7.875 12.9833 8.24833 13.3333 9.17583 13.3333H11.5325C12.46 13.3333 12.8333 12.9833 12.8333 12.1083Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 8.14166V12.1083C6.1224 12.9833 5.74906 13.3333 4.82156 13.3333H2.4649C1.5374 13.3333 1.16406 12.9833 1.16406 12.1083V8.14166C1.16406 7.26666 1.5374 6.91666 2.4649 6.91666H4.82156C5.74906 6.91666 6.1224 7.26666 6.1224 8.14166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 2.89166V3.94166C6.1224 4.81666 5.74906 5.16666 4.82156 5.16666H2.4649C1.5374 5.16666 1.16406 4.81666 1.16406 3.94166V2.89166C1.16406 2.01666 1.5374 1.66666 2.4649 1.66666H4.82156C5.74906 1.66666 6.1224 2.01666 6.1224 2.89166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> --}}
                                    <span
                                        style="position: relative; display: inline-block; width: 20px; height: 20px;">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/b_your_items.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/w_your_items.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">
                                    </span>
                                    Your Items
                                </a>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <a href="{{ route('producer.my.favorites') }}">
                                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15"
                                        viewBox="0 0 14 15" fill="none">
                                        <path
                                            d="M12.8333 6.85832V2.89166C12.8333 2.01666 12.46 1.66666 11.5325 1.66666H9.17583C8.24833 1.66666 7.875 2.01666 7.875 2.89166V6.85832C7.875 7.73332 8.24833 8.08332 9.17583 8.08332H11.5325C12.46 8.08332 12.8333 7.73332 12.8333 6.85832Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M12.8333 12.1083V11.0583C12.8333 10.1833 12.46 9.83334 11.5325 9.83334H9.17583C8.24833 9.83334 7.875 10.1833 7.875 11.0583V12.1083C7.875 12.9833 8.24833 13.3333 9.17583 13.3333H11.5325C12.46 13.3333 12.8333 12.9833 12.8333 12.1083Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 8.14166V12.1083C6.1224 12.9833 5.74906 13.3333 4.82156 13.3333H2.4649C1.5374 13.3333 1.16406 12.9833 1.16406 12.1083V8.14166C1.16406 7.26666 1.5374 6.91666 2.4649 6.91666H4.82156C5.74906 6.91666 6.1224 7.26666 6.1224 8.14166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 2.89166V3.94166C6.1224 4.81666 5.74906 5.16666 4.82156 5.16666H2.4649C1.5374 5.16666 1.16406 4.81666 1.16406 3.94166V2.89166C1.16406 2.01666 1.5374 1.66666 2.4649 1.66666H4.82156C5.74906 1.66666 6.1224 2.01666 6.1224 2.89166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> --}}
                                    <span
                                        style="position: relative; display: inline-block; width: 20px; height: 20px;">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/My Favorites.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">
                                    </span>
                                    My Favorites
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('producer.my.downloads') }}">
                                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15"
                                        viewBox="0 0 14 15" fill="none">
                                        <path
                                            d="M12.8333 6.85832V2.89166C12.8333 2.01666 12.46 1.66666 11.5325 1.66666H9.17583C8.24833 1.66666 7.875 2.01666 7.875 2.89166V6.85832C7.875 7.73332 8.24833 8.08332 9.17583 8.08332H11.5325C12.46 8.08332 12.8333 7.73332 12.8333 6.85832Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M12.8333 12.1083V11.0583C12.8333 10.1833 12.46 9.83334 11.5325 9.83334H9.17583C8.24833 9.83334 7.875 10.1833 7.875 11.0583V12.1083C7.875 12.9833 8.24833 13.3333 9.17583 13.3333H11.5325C12.46 13.3333 12.8333 12.9833 12.8333 12.1083Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 8.14166V12.1083C6.1224 12.9833 5.74906 13.3333 4.82156 13.3333H2.4649C1.5374 13.3333 1.16406 12.9833 1.16406 12.1083V8.14166C1.16406 7.26666 1.5374 6.91666 2.4649 6.91666H4.82156C5.74906 6.91666 6.1224 7.26666 6.1224 8.14166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 2.89166V3.94166C6.1224 4.81666 5.74906 5.16666 4.82156 5.16666H2.4649C1.5374 5.16666 1.16406 4.81666 1.16406 3.94166V2.89166C1.16406 2.01666 1.5374 1.66666 2.4649 1.66666H4.82156C5.74906 1.66666 6.1224 2.01666 6.1224 2.89166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> --}}
                                    <span
                                        style="position: relative; display: inline-block; width: 20px; height: 20px;">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/B download.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/w download.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">

                                    </span>
                                    Downloads
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('producer.recent.downloads') }}">
                                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15"
                                        viewBox="0 0 14 15" fill="none">
                                        <path
                                            d="M12.8333 6.85832V2.89166C12.8333 2.01666 12.46 1.66666 11.5325 1.66666H9.17583C8.24833 1.66666 7.875 2.01666 7.875 2.89166V6.85832C7.875 7.73332 8.24833 8.08332 9.17583 8.08332H11.5325C12.46 8.08332 12.8333 7.73332 12.8333 6.85832Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M12.8333 12.1083V11.0583C12.8333 10.1833 12.46 9.83334 11.5325 9.83334H9.17583C8.24833 9.83334 7.875 10.1833 7.875 11.0583V12.1083C7.875 12.9833 8.24833 13.3333 9.17583 13.3333H11.5325C12.46 13.3333 12.8333 12.9833 12.8333 12.1083Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 8.14166V12.1083C6.1224 12.9833 5.74906 13.3333 4.82156 13.3333H2.4649C1.5374 13.3333 1.16406 12.9833 1.16406 12.1083V8.14166C1.16406 7.26666 1.5374 6.91666 2.4649 6.91666H4.82156C5.74906 6.91666 6.1224 7.26666 6.1224 8.14166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 2.89166V3.94166C6.1224 4.81666 5.74906 5.16666 4.82156 5.16666H2.4649C1.5374 5.16666 1.16406 4.81666 1.16406 3.94166V2.89166C1.16406 2.01666 1.5374 1.66666 2.4649 1.66666H4.82156C5.74906 1.66666 6.1224 2.01666 6.1224 2.89166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> --}}
                                    <span
                                        style="position: relative; display: inline-block; width: 20px; height: 20px;">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/B recent purchases.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/W recent purchases.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">

                                    </span>
                                    Recent Purchases
                                </a>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <a href="{{ route('producer.create.pack') }}">
                                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15"
                                        viewBox="0 0 14 15" fill="none">
                                        <path
                                            d="M12.8333 6.85832V2.89166C12.8333 2.01666 12.46 1.66666 11.5325 1.66666H9.17583C8.24833 1.66666 7.875 2.01666 7.875 2.89166V6.85832C7.875 7.73332 8.24833 8.08332 9.17583 8.08332H11.5325C12.46 8.08332 12.8333 7.73332 12.8333 6.85832Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M12.8333 12.1083V11.0583C12.8333 10.1833 12.46 9.83334 11.5325 9.83334H9.17583C8.24833 9.83334 7.875 10.1833 7.875 11.0583V12.1083C7.875 12.9833 8.24833 13.3333 9.17583 13.3333H11.5325C12.46 13.3333 12.8333 12.9833 12.8333 12.1083Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 8.14166V12.1083C6.1224 12.9833 5.74906 13.3333 4.82156 13.3333H2.4649C1.5374 13.3333 1.16406 12.9833 1.16406 12.1083V8.14166C1.16406 7.26666 1.5374 6.91666 2.4649 6.91666H4.82156C5.74906 6.91666 6.1224 7.26666 6.1224 8.14166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 2.89166V3.94166C6.1224 4.81666 5.74906 5.16666 4.82156 5.16666H2.4649C1.5374 5.16666 1.16406 4.81666 1.16406 3.94166V2.89166C1.16406 2.01666 1.5374 1.66666 2.4649 1.66666H4.82156C5.74906 1.66666 6.1224 2.01666 6.1224 2.89166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> --}}
                                    <span
                                        style="position: relative; display: inline-block; width: 20px; height: 20px;">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/b add new pack_.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/w add new pack.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">

                                    </span>
                                    Add New Pack
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('producer.create.melody') }}">
                                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15"
                                        viewBox="0 0 14 15" fill="none">
                                        <path
                                            d="M12.8333 6.85832V2.89166C12.8333 2.01666 12.46 1.66666 11.5325 1.66666H9.17583C8.24833 1.66666 7.875 2.01666 7.875 2.89166V6.85832C7.875 7.73332 8.24833 8.08332 9.17583 8.08332H11.5325C12.46 8.08332 12.8333 7.73332 12.8333 6.85832Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M12.8333 12.1083V11.0583C12.8333 10.1833 12.46 9.83334 11.5325 9.83334H9.17583C8.24833 9.83334 7.875 10.1833 7.875 11.0583V12.1083C7.875 12.9833 8.24833 13.3333 9.17583 13.3333H11.5325C12.46 13.3333 12.8333 12.9833 12.8333 12.1083Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 8.14166V12.1083C6.1224 12.9833 5.74906 13.3333 4.82156 13.3333H2.4649C1.5374 13.3333 1.16406 12.9833 1.16406 12.1083V8.14166C1.16406 7.26666 1.5374 6.91666 2.4649 6.91666H4.82156C5.74906 6.91666 6.1224 7.26666 6.1224 8.14166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 2.89166V3.94166C6.1224 4.81666 5.74906 5.16666 4.82156 5.16666H2.4649C1.5374 5.16666 1.16406 4.81666 1.16406 3.94166V2.89166C1.16406 2.01666 1.5374 1.66666 2.4649 1.66666H4.82156C5.74906 1.66666 6.1224 2.01666 6.1224 2.89166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> --}}
                                    <span
                                        style="position: relative; display: inline-block; width: 20px; height: 20px;">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/b upload new melody.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/w upload new melody.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">

                                    </span>
                                    Add New Melodies
                                </a>
                            </li>
                        </ul>
                        <ul>
                            <li class="mode-switcher">
                                <a href="#">
                                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="14" height="15"
                                        viewBox="0 0 14 15" fill="none">
                                        <path
                                            d="M12.8333 6.85832V2.89166C12.8333 2.01666 12.46 1.66666 11.5325 1.66666H9.17583C8.24833 1.66666 7.875 2.01666 7.875 2.89166V6.85832C7.875 7.73332 8.24833 8.08332 9.17583 8.08332H11.5325C12.46 8.08332 12.8333 7.73332 12.8333 6.85832Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M12.8333 12.1083V11.0583C12.8333 10.1833 12.46 9.83334 11.5325 9.83334H9.17583C8.24833 9.83334 7.875 10.1833 7.875 11.0583V12.1083C7.875 12.9833 8.24833 13.3333 9.17583 13.3333H11.5325C12.46 13.3333 12.8333 12.9833 12.8333 12.1083Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 8.14166V12.1083C6.1224 12.9833 5.74906 13.3333 4.82156 13.3333H2.4649C1.5374 13.3333 1.16406 12.9833 1.16406 12.1083V8.14166C1.16406 7.26666 1.5374 6.91666 2.4649 6.91666H4.82156C5.74906 6.91666 6.1224 7.26666 6.1224 8.14166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M6.1224 2.89166V3.94166C6.1224 4.81666 5.74906 5.16666 4.82156 5.16666H2.4649C1.5374 5.16666 1.16406 4.81666 1.16406 3.94166V2.89166C1.16406 2.01666 1.5374 1.66666 2.4649 1.66666H4.82156C5.74906 1.66666 6.1224 2.01666 6.1224 2.89166Z"
                                            stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> --}}
                                    <span
                                        style="position: relative; display: inline-block; width: 20px; height: 20px;">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/b light mode.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">
                                        <img src="{{ asset('frontend/images/ProfileDropdown/w dark mode.png') }}"
                                            style="position: absolute; top: 0; left: 0; width: 100%;" alt="">

                                    </span>
                                    <p class="text">Switch To Light Mode</p>
                                </a>
                            </li>
                        </ul>                       
                        <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            style="cursor: pointer" class="sign--out">
                            Sign Out
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- search-mobile d-none  -->
<div class="search-mobile d-none">
    <p class="mobile--search--close">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            class="hide-close-search">
            <path
                d="M17.9999 5.99994C17.8124 5.81247 17.5581 5.70715 17.2929 5.70715C17.0278 5.70715 16.7735 5.81247 16.5859 5.99994L11.9999 10.5859L7.41394 5.99994C7.22641 5.81247 6.9721 5.70715 6.70694 5.70715C6.44178 5.70715 6.18747 5.81247 5.99994 5.99994C5.81247 6.18747 5.70715 6.44178 5.70715 6.70694C5.70715 6.9721 5.81247 7.22641 5.99994 7.41394L10.5859 11.9999L5.99994 16.5859C5.81247 16.7735 5.70715 17.0278 5.70715 17.2929C5.70715 17.5581 5.81247 17.8124 5.99994 17.9999C6.18747 18.1874 6.44178 18.2927 6.70694 18.2927C6.9721 18.2927 7.22641 18.1874 7.41394 17.9999L11.9999 13.4139L16.5859 17.9999C16.7735 18.1874 17.0278 18.2927 17.2929 18.2927C17.5581 18.2927 17.8124 18.1874 17.9999 17.9999C18.1874 17.8124 18.2927 17.5581 18.2927 17.2929C18.2927 17.0278 18.1874 16.7735 17.9999 16.5859L13.4139 11.9999L17.9999 7.41394C18.1874 7.22641 18.2927 6.9721 18.2927 6.70694C18.2927 6.44178 18.1874 6.18747 17.9999 5.99994Z"
                fill="#0CCF9F" />
        </svg>
    </p>
    <form action="#">
        <input type="text" placeholder="Search here...">
    </form>
</div>
<!-- header end  -->
