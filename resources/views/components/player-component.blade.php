<div>
    <div class="default--audio--player">
        <div class="details">
            <img id="thumbnail" src="{{asset('frontend/images/album-packs1.png')}}" alt="" />
            <div>
                <h3 class="title play-title text-capitalize" >Cxrker_Someone_Gm_168BP</h3>
                <p class="artist">Cxrker</p>
            </div>
        </div>
        <div class="controls">
            <!-- progress--wrapper  -->
            <div class="progress--wrapper">
                <span class="current-time">0:00</span>
                <div id="bottom-wave"></div>
                <span class="duration">3:50</span>
            </div>
            <!-- playPause  -->
            <div class="playPause-wrapper">
                <!-- backward  -->
                <button class="backward">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none">
                        <path d="M2 7H5V17H2V7ZM6 12L13.002 7V17L6 12ZM21.002 7L14 12L21.002 17V7Z" fill="white" />
                    </svg>
                </button>
                <button class="play-pause">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 12 16"
                        fill="none" id="play" class="d-none">
                        <path
                            d="M10.272 8.54011L1.40633 14.2546C0.907242 14.5763 0.25 14.218 0.25 13.6242V2.1952C0.25 1.60142 0.90724 1.24311 1.40633 1.56481L10.272 7.27933C10.7302 7.57468 10.7302 8.24476 10.272 8.54011Z"
                            fill="#0CCF9F"></path>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" id="pause" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <path
                            d="M10.65 19.11V4.89C10.65 3.54 10.08 3 8.64 3H5.01C3.57 3 3 3.54 3 4.89V19.11C3 20.46 3.57 21 5.01 21H8.64C10.08 21 10.65 20.46 10.65 19.11Z"
                            stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M21.0001 19.11V4.89C21.0001 3.54 20.4301 3 18.9901 3H15.3601C13.9301 3 13.3501 3.54 13.3501 4.89V19.11C13.3501 20.46 13.9201 21 15.3601 21H18.9901C20.4301 21 21.0001 20.46 21.0001 19.11Z"
                            stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <!-- forward  -->
                <button class="forward">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none">
                        <path d="M21.002 17H18.002V7H21.002V17ZM17.002 12L10 17V7L17.002 12ZM2 17L9.002 12L2 7V17Z"
                            fill="white" />
                    </svg>
                </button>
            </div>
            <!-- volume--control -->
            <div class="volume--control--wrap">
                <svg xmlns="http://www.w3.org/2000/svg" id="sound" width="24" height="24"
                    viewBox="0 0 24 24" fill="none">
                    <path
                        d="M2 10V14C2 16 3 17 5 17H6.43C6.8 17 7.17 17.11 7.49 17.3L10.41 19.13C12.93 20.71 15 19.56 15 16.59V7.41003C15 4.43003 12.93 3.29003 10.41 4.87003L7.49 6.70003C7.17 6.89003 6.8 7.00003 6.43 7.00003H5C3 7.00003 2 8.00003 2 10Z"
                        stroke="#292D32" stroke-width="1.5" />
                    <path d="M18 8C19.78 10.37 19.78 13.63 18 16" stroke="#292D32" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M19.8301 5.5C22.7201 9.35 22.7201 14.65 19.8301 18.5" stroke="#292D32" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" id="mute" class="d-none" width="24"
                    height="24" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M2 10.1595V14.1595C2 16.1595 3 17.1595 5 17.1595H6.43C6.8 17.1595 7.17 17.2695 7.49 17.4595L10.41 19.2895C12.93 20.8695 15 19.7195 15 16.7495V7.56946C15 4.58946 12.93 3.44946 10.41 5.02946L7.49 6.85946C7.17 7.04946 6.8 7.15946 6.43 7.15946H5C3 7.15946 2 8.15946 2 10.1595Z"
                        stroke="#292D32" stroke-width="1.5" />
                    <path d="M22 14.1194L18.04 10.1594" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M21.96 10.1995L18 14.1595" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <input class="volume--control" type="range" min="0" max="1" step="0.01" />
            </div>
            <!-- audio  -->
            <audio id="default--audio" src="{{asset('producers/audio/2.mp3')}}"></audio>
        </div>
        <!-- hide--audio  -->
        <div class="hide--audio">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none">
                <path d="M19.9201 8.94995L13.4001 15.47C12.6301 16.24 11.3701 16.24 10.6001 15.47L4.08008 8.94995"
                    stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>
    </div>

</div>
