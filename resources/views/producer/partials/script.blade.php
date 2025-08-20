<script src="{{ asset('frontend/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('frontend/js/plugins.js') }}"></script>
<script src="{{ asset('frontend/js/dashboard.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://unpkg.com/wavesurfer.js"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
<script src="{{ asset('frontend/js/toastr.min.js') }}"></script>

{{-- Google Translator JS --}}
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
</script>

{{-- Google Translators --}}
<script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,es',
        }, 'google_translate_element');
    }
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Bs Icon --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

{{-- Bs Icon --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Toastr JS -->
<script>
    $(document).ready(function() {
        toastr.options = {
            'closeButton': true,
            'debug': true,
            'newestOnTop': true,
            'progressBar': false,
            'positionClass': 'toast-top-center',
            'preventDuplicates': true,
            'showDuration': '1000',
            'hideDuration': '1000',
            'timeOut': '5000',
            'extendedTimeOut': '1000',
            'showEasing': 'linear',
            'hideEasing': 'linear',
            'showMethod': 'slideDown',
            'hideMethod': 'slideUp',
            'hover': false,
        };

        @if (Session::has('t-success'))
            toastr.success("{{ session('t-success') }}");
        @endif

        @if (Session::has('status'))
            toastr.success("{{ session('status') }}");
        @endif

        @if (Session::has('t-error'))
            toastr.error("{{ session('t-error') }}");
        @endif

        @if (Session::has('t-info'))
            toastr.info("{{ session('t-info') }}");
        @endif

        @if (Session::has('t-warning'))
            toastr.warning("{{ session('t-warning') }}");
        @endif
    });
</script>



{{-- Hendeling Pagination --}}
<script>
    
</script>

{{-- Add to cart --}}
<script>
    // Add Item in cart
    function addToCart(e, id) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('producer.add.to.cart') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: {
                id: id
            },
            success: function(response) {
                console.log(response);
                if (response.success) {

                    // Apend Card info to cart
                    if (response.data) {
                        let CartWrapper = document.querySelector('#cart-wrapper');

                        let price = parseFloat(response.data.pack.price);
                        if (!isNaN(price)) {
                            price = price.toFixed(2); // Convert and format price
                        } else {
                            price = '0.00'; // Fallback value if price is invalid
                            toastr.error('Invalid price format');
                        }
                        let html = `
                                <div class="cart-product mt_25">
                                    <div class="product-quantity">
                                        <div class="p-image-wrap position-relative">
                                            <img class="p-image" src="{{ url('/') }}${response.data.pack.thumbnail}" alt="">
                                            <img class="delete-icon" src="{{ asset('frontend/images/close.svg') }}" onclick="removeFromCart(event,${response.data.item.id}, this)" alt="">
                                        </div>
                                        <div class="title-quantity">
                                            <!-- p-title -->
                                            <div class="p-title">
                                                <h4 class="t-main">${response.data.pack.name}</h4>
                                                <p class="t-sub">${response.data.pack.user.name}</p>
                                            </div>
                                            <!-- p-quantity  -->
                                            <p class="p-quantity">
                                                X1
                                            </p>
                                        </div>
                                    </div>
                                    <!-- product price  -->
                                    <div class="p-price">$${price}</div>
                                </div>
                                `;

                        CartWrapper.insertAdjacentHTML('beforeend', html);

                        // Update cart 
                        let CartCount = document.querySelector('.cart-count');
                        CartCount.innerHTML = CartCount.innerHTML * 1 + 1;

                        let CartTotalPrice = document.querySelector('#total-cart-price');
                        let currentPrice = parseFloat(CartTotalPrice.innerHTML.replace(/[^0-9.]/g, ''));
                        CartTotalPrice.innerHTML = '$' + (currentPrice + parseFloat(price)).toFixed(2);

                    }
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(error) {
                console.log(error);
                toastr.error(error.responseJSON.message);
            }
        });
    }


    // Remove from cart
    function removeFromCart(e, id, element) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteFromCart(e, id, element)
            }
        })

    }

    function deleteFromCart(e, id, element) {
        $.ajax({
            url: "{{ route('producer.remove.to.cart') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: {
                id: id
            },
            success: function(response) {
                console.log(response);
                if (response.success) {
                    toastr.success(response.message);

                    let CartWrapper = document.querySelector('#cart-wrapper');
                    let CartCount = document.querySelector('.cart-count');
                    let CartTotalPrice = document.querySelector('#total-cart-price');
                    let currentPrice = parseFloat(CartTotalPrice.innerHTML.replace(/[^0-9.]/g, ''));
                    CartTotalPrice.innerHTML = '$' + (currentPrice - parseFloat(response.pack.price))
                        .toFixed(2);
                    CartCount.innerHTML = CartCount.innerHTML * 1 - 1;

                    element.closest('.cart-product').remove();


                    // Find the Subtotal element
                    let SubTotal = document.querySelector('#ck-sub-total');
                    if (SubTotal) {
                        let currentSubPrice = parseFloat(SubTotal.innerHTML.replace(/[^0-9.]/g, ''));
                        SubTotal.innerHTML = '$' + (currentSubPrice - parseFloat(response.pack.price))
                            .toFixed(2);
                    }

                    // Find the Total element
                    let CkTotal = document.querySelector('#ck-total');
                    if (CkTotal) {
                        let currentTotalPrice = parseFloat(CkTotal.innerHTML.replace(/[^0-9.]/g, ''));
                        CkTotal.innerHTML = '$' + (currentTotalPrice - parseFloat(response.pack.price))
                            .toFixed(2);
                    }


                } else {
                    toastr.error(response.message);
                }
            },
            error: function(error) {
                console.log(error);
                toastr.error(error.responseJSON.message);
            }
        });
    }


    // Remove all From cart
    $('#DeleteAllcardItem').click(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You removed all items from cart!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "{{ route('producer.remove.all.from.cart') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {},
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            toastr.success(response.message);
                            let CartWrapper = document.querySelector('#cart-wrapper');
                            CartWrapper.innerHTML = '';

                            let CartCount = document.querySelector('.cart-count');
                            CartCount.innerHTML = 0;

                            let CartTotalPrice = document.querySelector(
                                '#total-cart-price');
                            CartTotalPrice.innerHTML = '$0.00';

                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        toastr.error(error.responseJSON.message);
                    }
                });
            }
        })
    });

    function updateFollowerCount(count) {
        document.getElementById('followerCount').textContent = `${count} Followers`;
    }

    function followUser(e, id, element) {
        e.preventDefault();
        let url = `{{ route('producer.follow', ':id') }}`;
        $.ajax({
            url: url.replace(':id', id),
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response) {
                window.location.reload();
                console.log(response);
                if (response.success) {
                    $(element).text('Unfollow');
                    updateFollowerCount(response.followerCount);
                    
                } else {
                    window.location.reload();
                    $(element).text('Follow');
                   
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function unfollowUser(e, id, element) {
        e.preventDefault();

        let url = `{{ route('producer.unfollow', ':id') }}`;
        $.ajax({
            url: url.replace(':id', id),
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                if (response.success) {
                    window.location.reload();
                } else {
                    $(element).text('Unfollow');
                    window.location.reload();
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
</script>



{{-- Add To FVRT --}}
<script>
    function addToFav(e, id, element) {
        e.preventDefault();
        let url = `{{ route('producer.favorite', ':id') }}`;
        $.ajax({
            url: url.replace(':id', id),
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                if (response.success) {
                    // Add active class

                    toastr.success(response.message);
                } else {
                    // Remove Active Class
                    toastr.error(response.message);
                }
            },
            error: function(error) {
                console.log(error);
                toastr.error(error.responseJSON.message);
            }
        });
    }
</script>

{{-- Download Pack --}}
<script>
    function PackDownload(e, id) {
        e.preventDefault();
        // Create the download URL by replacing the :id placeholder
        let url = "{{ route('producer.pack.download', ':id') }}";
        url = url.replace(':id', id);

        // Trigger the download by redirecting the browser to the file URL
        window.location.href = url;

    }
</script>



{{-- Subscription Cancle --}}
<script>
   $(document).ready(function() {
    $('#CancleBtn').click(function(e) {
        e.preventDefault();

        Swal.fire({
            title: '<h3 style="color: white;">Are you sure want to cancel ? </h3>',
            html: '<h6 style="color: white;">You Have to purchase again!</h6>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#b80f0a',
            cancelButtonColor: '#0d6efd',
            confirmButtonText: 'Yes, Cancel it!',
            didOpen: () => {
                $('.swal2-popup').css('background-color', '#001611');
            }
        }).then((result) => {
            if (result.isConfirmed) {
                CancleMembership();
            }
        })
    });
});


    function CancleMembership() {
        let url = '{{ route('producer.cancel.subscription') }}';
        $.ajax({
            type: "GET",
            url: url,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    toastr.warning(response.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            },
            error: function(error) {
                toastr.success("Error:", error.message);

            }
        })
    }
</script>


{{-- Form Clear Button --}}
<script>
    $(document).ready(function() {
        $('.clear-filter').click(function(e) {
            e.preventDefault();

            // Get the current URL without query parameters
            let url = window.location.origin + window.location.pathname;

            console.log(url);

            // Redirect to the URL without query parameters
            window.location.href = url;
        });
        $('.global-for-clear').click(function(e) {
            e.preventDefault();

            // Get the current URL without query parameters
            let url = window.location.origin + window.location.pathname;

            console.log(url);

            // Redirect to the URL without query parameters
            window.location.href = url;
        });

    })
</script>




{{-- Handel Melody --}}
<script>
    function handleMelodyPlayer() {
        let currentPlaying = null;
        let currentButton = null;
        let bottomPlayer = document.querySelector(
            ".default--audio--player"
        );
        if (bottomPlayer) {
            let bottomWave = document.getElementById("bottom-wave");
            let bottomPlayPauseWrapp = document.querySelector(
                ".default--audio--player .playPause-wrapper"
            );
            let bottomPlayPause =
                bottomPlayPauseWrapp.querySelector(".play-pause");
            // Select time display elements
            const totalDurationElement = document.querySelector(
                ".default--audio--player .duration"
            );
            const totalPastTimeElement = document.querySelector(
                ".default--audio--player .current-time"
            );
            // Volume slider
            const volumeSlider = document.querySelector(".volume--control");
            // backward and forward buttons
            const backwardButton = document.querySelector(
                ".default--audio--player .backward"
            );
            const forwardButton = document.querySelector(
                ".default--audio--player .forward"
            );
            const hidePlayer = bottomPlayer?.querySelector(".hide--audio");
            bottomWave.innerHTML = "";
            const bottomWaveSurfer = WaveSurfer.create({
                container: bottomWave,
                waveColor: "#c3c3c3",
                progressColor: "#0ccf9f",
                height: 35,
                cursorColor: "#0ccf9f",
                barRadius: 10,
                interact: false,
            });

            document.querySelectorAll(".melodi").forEach((melodi) => {
                const melodyId = melodi.getAttribute("data-audio-id");
                const audioSrc = melodi.getAttribute("data-audio-src");
                const waveContainer = melodi.querySelector(".wave");
                const playPauseButton =
                    melodi.querySelector(".playPauseBtn");
                let playSvg = melodi.querySelector("#play-icon");
                let pauseSvg = melodi.querySelector("#pause-icon");
                let TotalTimeDisplay =
                    melodi.querySelector(".time-display");

                if (!melodi.waveSurferInstance) {
                    const waveSurfer = WaveSurfer.create({
                        container: waveContainer,
                        waveColor: "#c3c3c3",
                        progressColor: "#0ccf9f",
                        height: 35,
                        cursorColor: "#0ccf9f",
                        barRadius: 10,
                        interact: false,
                    });
                    waveSurfer.load(audioSrc);
                    waveSurfer.on("ready", function() {
                        const duration = waveSurfer.getDuration();

                        TotalTimeDisplay.textContent = formatTime(duration);
                    });
                    // playpause
                    playPauseButton.addEventListener("click", function() {
                        if (waveSurfer.isPlaying()) {
                            waveSurfer.pause();
                            playSvg.classList.remove("d-none");
                            pauseSvg.classList.add("d-none");
                            bottomPlayPause
                                .querySelector("#pause")
                                .classList.add("d-none");
                            bottomPlayPause
                                .querySelector("#play")
                                .classList.remove("d-none");
                            return false;
                        }
                        // Call Ajax to get current playing audio
                        $.ajax({
                            url: `/producer/get-playing-audio/${melodyId}`,
                            type: "GET",
                            success: function(data) {
                                waveSurfer.load(data.file);
                                if (data) {
                                    if (
                                        currentPlaying &&
                                        currentPlaying !== waveSurfer
                                    ) {
                                        currentPlaying.pause();
                                        if (currentButton) {
                                            currentButton
                                                .querySelector("#play-icon")
                                                .classList.remove("d-none");
                                            currentButton
                                                .querySelector(
                                                    "#pause-icon"
                                                )
                                                .classList.add("d-none");
                                        }
                                        currentPlaying.seekTo(0);
                                    }
                                    if (waveSurfer.isPlaying()) {
                                        waveSurfer.pause();
                                        playSvg.classList.remove("d-none");
                                        pauseSvg.classList.add("d-none");
                                        bottomPlayPause
                                            .querySelector("#pause")
                                            .classList.add("d-none");
                                        bottomPlayPause
                                            .querySelector("#play")
                                            .classList.remove("d-none");
                                    } else {
                                        waveSurfer.play();
                                        playSvg.classList.add("d-none");
                                        pauseSvg.classList.remove("d-none");
                                        bottomPlayPause
                                            .querySelector("#pause")
                                            .classList.remove("d-none");
                                        bottomPlayPause
                                            .querySelector("#play")
                                            .classList.add("d-none");
                                        currentPlaying = waveSurfer;
                                        currentButton = playPauseButton;
                                        bottomWaveSurfer.load(audioSrc);
                                    }
                                    // Update progress
                                    waveSurfer.on(
                                        "audioprocess",
                                        function() {
                                            const currentTime =
                                                waveSurfer.getCurrentTime();
                                            const duration =
                                                waveSurfer.getDuration();
                                            if (duration > 0) {
                                                const progress =
                                                    currentTime / duration;
                                                bottomWaveSurfer.seekTo(
                                                    progress
                                                );
                                            }
                                            updateTimeProgress(
                                                currentTime,
                                                duration
                                            );
                                        }
                                    );
                                    // OnPause
                                    waveSurfer.on("pause", function() {
                                        bottomWaveSurfer.seekTo(
                                            waveSurfer.getCurrentTime() /
                                            waveSurfer.getDuration()
                                        );
                                    });

                                    // OnFinish
                                    waveSurfer.on("finish", function() {
                                        if (currentPlaying) {
                                            currentButton
                                                .querySelector("#play-icon")
                                                .classList.remove("d-none");
                                            currentButton
                                                .querySelector(
                                                    "#pause-icon"
                                                )
                                                .classList.add("d-none");
                                        }
                                        // Update the bottom player state
                                        bottomPlayPause
                                            .querySelector("#pause")
                                            .classList.add("d-none");
                                        bottomPlayPause
                                            .querySelector("#play")
                                            .classList.remove("d-none");
                                    });

                                    let thimb =
                                        document.querySelector(
                                            "#thumbnail"
                                        );
                                    let mainUrl = window.location.origin;

                                    if (data.data.type == "demo") {
                                        thimb.src =
                                            mainUrl +
                                            data.data.pack.thumbnail;
                                    } else {
                                        thimb.src =
                                            mainUrl + data.data.thumbnail;
                                    }
                                    let melodyname = data.data.name.replace(
                                        /-/g,
                                        " "
                                    );
                                    $(".play-title").text(
                                        melodyname.substring(0, 45) + "..."
                                    );
                                    $(".artist").text(
                                        data.data.user.producer_name
                                    );

                                    bottomPlayer?.classList.add("show");
                                } else {
                                    toastr.error(
                                        "Error:",
                                        "Melody not found"
                                    );
                                }
                            },
                            error: function(error) {
                                toastr.error("Error:", error.message);
                            },
                        });
                    });
                }
            });
            // bottom player playPauseButton
            bottomPlayPause?.addEventListener("click", function() {
                if (currentPlaying) {
                    if (currentPlaying.isPlaying()) {
                        currentPlaying.pause();
                        if (currentButton) {
                            currentButton
                                .querySelector("#play-icon")
                                .classList.remove("d-none");
                            currentButton
                                .querySelector("#pause-icon")
                                .classList.add("d-none");
                        }
                        bottomPlayPause
                            .querySelector("#pause")
                            .classList.add("d-none");
                        bottomPlayPause
                            .querySelector("#play")
                            .classList.remove("d-none");
                    } else {
                        currentPlaying.play();
                        if (currentButton) {
                            currentButton
                                .querySelector("#play-icon")
                                .classList.add("d-none");
                            currentButton
                                .querySelector("#pause-icon")
                                .classList.remove("d-none");
                        }
                        bottomPlayPause
                            .querySelector("#pause")
                            .classList.remove("d-none");
                        bottomPlayPause
                            .querySelector("#play")
                            .classList.add("d-none");
                    }
                }
            });

            // updateTimeProgress
            function updateTimeProgress(currentTime, duration) {
                totalPastTimeElement.textContent = formatTime(currentTime);
                totalDurationElement.textContent = formatTime(duration);
            }
            // formatTime
            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = Math.floor(seconds % 60);

                return `${minutes}:${
                    remainingSeconds < 10 ? "0" : ""
                }${remainingSeconds}`;
            }
            // forward backward
            backwardButton.addEventListener("click", function() {
                if (currentPlaying) {
                    let currentTime = currentPlaying.getCurrentTime();
                    currentPlaying.seekTo(
                        Math.max(
                            (currentTime - 5) /
                            currentPlaying.getDuration(),
                            0
                        )
                    );
                    // Manually update bottomWaveSurfer progress
                    bottomWaveSurfer.seekTo(
                        currentPlaying.getCurrentTime() /
                        currentPlaying.getDuration()
                    );
                }
            });
            forwardButton.addEventListener("click", function() {
                if (currentPlaying) {
                    let currentTime = currentPlaying.getCurrentTime();
                    currentPlaying.seekTo(
                        Math.max(
                            (currentTime + 5) /
                            currentPlaying.getDuration(),
                            0
                        )
                    );
                    // Manually update bottomWaveSurfer progress
                    bottomWaveSurfer.seekTo(
                        currentPlaying.getCurrentTime() /
                        currentPlaying.getDuration()
                    );
                }
            });
            // volumeSlider
            volumeSlider?.addEventListener("input", function() {
                if (currentPlaying) {
                    currentPlaying.setVolume(volumeSlider.value);

                    if (volumeSlider.value <= 0) {
                        volumeSlider.parentElement
                            .querySelector("#mute")
                            .classList.remove("d-none");
                        volumeSlider.parentElement
                            .querySelector("#sound")
                            .classList.add("d-none");
                    } else {
                        volumeSlider.parentElement
                            .querySelector("#mute")
                            .classList.add("d-none");
                        volumeSlider.parentElement
                            .querySelector("#sound")
                            .classList.remove("d-none");
                    }
                }
            });

            // hide show player
            hidePlayer?.addEventListener("click", function() {
                hidePlayer.querySelector("svg").classList.toggle("hide");
                hidePlayer
                    .closest(".default--audio--player")
                    .classList.toggle("hide");
            });
        }
    }
</script>

@stack('script')
