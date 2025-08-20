(function ($) {
    "use strict";

    $(document).ready(function () {
        // Define waveSurferInstances globally
        let waveSurferInstances = []; // Array to store all WaveSurfer instances

        function stopAllWaveSurferInstances() {
            waveSurferInstances.forEach((waveSurfer) => {
                if (waveSurfer.isPlaying()) {
                    waveSurfer.pause();
                }
                waveSurfer.seekTo(0); // Reset to the beginning
                waveSurfer.destroy(); // Destroy instance
            });
            waveSurferInstances.length = 0; // Clear the array after destroying instances
        }

        $(document).on("click", ".pagination a", function (event) {
            event.preventDefault();

            const url = $(this).attr("href");
            loadMelodies(url);
        });

        function loadMelodies(url) {
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    $("#melodyList").html(data.html);
                    $("#paginationLinks").html(data.pagination);

                    // Stop and clear all current WaveSurfer instances
                    stopAllWaveSurferInstances();

                    // Re-initialize the melody player for new items
                    handleMelodyPlayer();
                },
                error: function (xhr) {
                    toastr.error("Error: " + xhr.statusText);
                    console.log("Error:", xhr);
                },
            });
        }

        // handleMegaMenu
        function handleMegaMenu() {
            let trigger = document.querySelector(".mengamenu");
            let dropdown = document.querySelector(".dropdown--megamenu");

            if (trigger) {
                trigger.addEventListener("mouseenter", function () {
                    dropdown.classList.add("show");
                });

                trigger.addEventListener("mouseleave", function () {
                    dropdown.classList.remove("show");
                });

                dropdown.addEventListener("mouseenter", function () {
                    dropdown.classList.add("show");
                });

                dropdown.addEventListener("mouseleave", function () {
                    dropdown.classList.remove("show");
                });
            }
        }

        handleMegaMenu();

        function handleHeaderSearch() {
            let searchBtns = document.querySelectorAll("header .open-search");
            let closeBtns = document.querySelectorAll("header .close-search");
            let Inputs = document.querySelectorAll("#header-search");
            let form = document.querySelector(".header--right--wrapper form");

            if (searchBtns && closeBtns && Inputs) {
                searchBtns.forEach((btn) => {
                    btn.addEventListener("click", function (e) {
                        e.preventDefault();
                        Inputs.forEach((input) => {
                            input.classList.add("show");
                        });
                        btn.style.opacity = "0";
                        btn.style.visibility = "hidden";
                        btn.style.pointerEvents = "none";
                        closeBtns.forEach((closeBtn) => {
                            closeBtn.style.opacity = "1";
                            closeBtn.style.visibility = "visible";
                            closeBtn.style.pointerEvents = "auto";
                        });
                        if (form) {
                            form.style.width = "270px";
                            if (
                                window.innerWidth >= 575 &&
                                window.innerWidth <= 767
                            ) {
                                form.style.width = "200px";
                            }
                        }
                    });
                });

                closeBtns.forEach((closeBtn) => {
                    closeBtn.addEventListener("click", function (e) {
                        e.preventDefault();
                        Inputs.forEach((input) => {
                            input.classList.remove("show");
                        });
                        closeBtn.style.opacity = "0";
                        closeBtn.style.visibility = "hidden";
                        closeBtn.style.pointerEvents = "none";
                        searchBtns.forEach((btn) => {
                            btn.style.opacity = "1";
                            btn.style.visibility = "visible";
                            btn.style.pointerEvents = "auto";
                        });
                        if (form) {
                            form.style.width = "50px";
                        }
                    });
                });
            }
        }
        handleHeaderSearch();

        // top-melodies-slider
        $(".top-melodies-slider").owlCarousel({
            loop: true,
            margin: 18,
            nav: false,
            dots: false,
            autoplay: true,
            autoplaySpeed: 2000,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 3,
                },
                1000: {
                    items: 5,
                    stagePadding: 90,
                },
            },
        });
        // top-melodies-slider
        $(".pack--slider").owlCarousel({
            loop: false,
            margin: 16,
            nav: true,
            dots: false,
            autoplay: true,
            navText: [
                '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M24.9974 36.6663H14.9974C6.66406 36.6663 3.33073 33.333 3.33073 24.9997V14.9997C3.33073 6.66634 6.66406 3.33301 14.9974 3.33301H24.9974C33.3307 3.33301 36.6641 6.66634 36.6641 14.9997V24.9997C36.6641 33.333 33.3307 36.6663 24.9974 36.6663Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path class="arrow-icon" d="M22.1016 25.8829L16.2349 19.9995L22.1016 14.1162" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M15.0026 36.6663H25.0026C33.3359 36.6663 36.6693 33.333 36.6693 24.9997V14.9997C36.6693 6.66634 33.3359 3.33301 25.0026 3.33301H15.0026C6.66927 3.33301 3.33594 6.66634 3.33594 14.9997V24.9997C3.33594 33.333 6.66927 36.6663 15.0026 36.6663Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path class="arrow-icon" d="M17.8984 25.8829L23.7651 19.9995L17.8984 14.1162" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            ],
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 2,
                },
                1000: {
                    items: 3,
                },
                1500: {
                    items: 4,
                },
            },
        });

        // top-melodies-slider
        $(".feed--slider").owlCarousel({
            loop: false,
            margin: 16,
            nav: true,
            dots: false,
            autoplay: true,
            navText: [
                '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M24.9974 36.6663H14.9974C6.66406 36.6663 3.33073 33.333 3.33073 24.9997V14.9997C3.33073 6.66634 6.66406 3.33301 14.9974 3.33301H24.9974C33.3307 3.33301 36.6641 6.66634 36.6641 14.9997V24.9997C36.6641 33.333 33.3307 36.6663 24.9974 36.6663Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path class="arrow-icon" d="M22.1016 25.8829L16.2349 19.9995L22.1016 14.1162" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M15.0026 36.6663H25.0026C33.3359 36.6663 36.6693 33.333 36.6693 24.9997V14.9997C36.6693 6.66634 33.3359 3.33301 25.0026 3.33301H15.0026C6.66927 3.33301 3.33594 6.66634 3.33594 14.9997V24.9997C3.33594 33.333 6.66927 36.6663 15.0026 36.6663Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path class="arrow-icon" d="M17.8984 25.8829L23.7651 19.9995L17.8984 14.1162" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            ],
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 2,
                },
                1000: {
                    items: 3,
                },
                1500: {
                    items: 5,
                },
            },
        });

        // aos
        AOS.init({
            once: true,
        });

        $("select").niceSelect();

        // handleMelodyPlayer
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
                        waveSurfer.on("ready", function () {
                            const duration = waveSurfer.getDuration();
                            TotalTimeDisplay.textContent = formatTime(duration);
                        });
                        // playpause
                        playPauseButton.addEventListener("click", function () {
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
                            let url = `/producer/get-playing-audio/${melodyId}`;
                            $.ajax({
                                url: url,
                                type: "GET",
                                success: function (data) {
                                    if (data) {
                                        // waveSurfer.load(data.file);
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
                                            waveSurferInstances.push(waveSurfer);
                                        }
                                        // Update progress
                                        waveSurfer.on(
                                            "audioprocess",
                                            function () {
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
                                        waveSurfer.on("pause", function () {
                                            bottomWaveSurfer.seekTo(
                                                waveSurfer.getCurrentTime() /
                                                    waveSurfer.getDuration()
                                            );
                                        });

                                        // OnFinish
                                        waveSurfer.on("finish", function () {
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
                                error: function (error) {
                                    toastr.error("Error:", error.message);
                                },
                            });
                        });
                    }
                });
                // bottom player playPauseButton
                bottomPlayPause?.addEventListener("click", function () {
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
                backwardButton.addEventListener("click", function () {
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
                forwardButton.addEventListener("click", function () {
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
                volumeSlider?.addEventListener("input", function () {
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
                hidePlayer?.addEventListener("click", function () {
                    hidePlayer.querySelector("svg").classList.toggle("hide");
                    hidePlayer
                        .closest(".default--audio--player")
                        .classList.toggle("hide");
                });
            }
        }
        handleMelodyPlayer();

        // handleMelodiAction
        function handleMelodiAction() {
            let melodis = document.querySelectorAll(".single--melodi");

            if (melodis) {
                melodis.forEach((melodi) => {
                    melodi.addEventListener("click", function (e) {
                        let wishlist = melodi.querySelector(".wishlist");
                        let dotMenu = melodi.querySelector(".dots");
                        // wishlist
                        if (wishlist && wishlist.contains(e.target)) {
                            wishlist.classList.toggle("active");
                        }
                        // dot menu
                        if (dotMenu && dotMenu.contains(e.target)) {
                            let dotMenuTrigger = e.target;
                            let dropMenu =
                                e.target.parentNode.querySelector(
                                    ".action--dropdown"
                                );
                            let options = dropMenu.querySelectorAll("li");
                            dropMenu.classList.toggle("show");

                            options.forEach((option) => {
                                option.addEventListener("click", function () {
                                    dropMenu.classList.remove("show");
                                });
                            });

                            document.addEventListener("click", function (e) {
                                if (
                                    !dropMenu.contains(e.target) &&
                                    !dotMenuTrigger.contains(e.target)
                                ) {
                                    dropMenu.classList.remove("show");
                                }
                            });
                        }
                    });
                });
            }
        }
        handleMelodiAction();

        // show loader
        function showLoader(loaderElem) {
            if (loaderElem) {
                loaderElem.style.display = "block";
            }
        }
        showLoader();
        // hide loader
        function hideLoader(loaderElem) {
            if (loaderElem) {
                loaderElem.style.display = "none";
            }
        }
        hideLoader();

        // handle file upload
        // handle file upload
        function handleFileUpload(event, type) {
            const input = event.target;
            const previewId = input.getAttribute("data-preview-id");
            const loaderId = input.getAttribute("data-loader-id");
            const labelId = input.getAttribute("label-id");

            const previewImg = document.getElementById(previewId);
            const loader = document.getElementById(loaderId);
            const uploadLabel = document.querySelector(labelId);
            const file = input.files[0];
            console.log(file);

            // Define route based on type
            let route;
            switch (type) {
                case "profile":
                    route = "/producer/update-profile-picture";
                    break;
                case "cover":
                    route = "/producer/update-cover-picture";
                    break;
                case "thumbnail":
                    route = "/producer/update-thumbnail-picture";
                    break;
                default:
                    route = "/producer/update-file"; // Default route
            }

            if (file) {
                showLoader(loader);

                const formData = new FormData();
                formData.append("image", file);

                // AJAX request using jQuery
                $.ajax({
                    url: route, // Use the dynamic route based on type
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (data) {
                        if (data.success) {
                            toastr.success("Success:", data.message);
                            if (type == "file" || type == "thumbnail") {
                                let html = `<input type="text" name="file" value="${data.url}" />`;
                                input.parentElement.insertAdjacentHTML(
                                    "beforeend",
                                    html
                                );
                                // Show the uploaded image
                                previewImg.style.display = "block";
                                previewImg.src = data.url;
                                if (uploadLabel) {
                                    uploadLabel.style.border = "none";
                                }
                                hideLoader(loader);
                                return false;
                            }
                            // Show the uploaded image
                            previewImg.style.display = "block";
                            previewImg.src = data.image;
                            if (uploadLabel) {
                                uploadLabel.style.border = "none";
                            }
                        } else {
                            toastr.error("Error:", data.message);
                        }

                        hideLoader(loader);
                    },
                    error: function (error) {
                        hideLoader(loader);
                        console.error("Error:", error);
                    },
                });
            }
        }

        // Add event listeners for file inputs with different routes
        document
            .getElementById("coverUpload")
            ?.addEventListener("change", function (event) {
                handleFileUpload(event, "cover");
            });
        document
            .getElementById("profile--upload")
            ?.addEventListener("change", function (event) {
                handleFileUpload(event, "profile");
            });
        document
            .getElementById("thumbnailUpload")
            ?.addEventListener("change", function (event) {
                handleFileUpload(event, "thumbnail");
            });

        document
            .getElementById("fileUpload")
            ?.addEventListener("change", function (event) {
                handleFileUpload(event, "file");
            });

        let regProfileUpload = document.querySelector(".uploadRegFile");
        if (regProfileUpload) {
            regProfileUpload.addEventListener("change", function (event) {
                handleFileUpload(event, "thumbnail"); // Use 'profile' or any type depending on your requirement
            });
        }
        // handle fileUploads

        function handleFileUploads(selector, validFileType) {
            const uploadBoxes = document.querySelectorAll(selector);

            uploadBoxes.forEach((uploadBox) => {
                const fileInput = uploadBox.querySelector("input[type='file']");
                const uploadLabel = uploadBox.querySelector(".packcoverUpload");
                const uploadText = uploadBox.querySelector(".upload--text");
                const fileDetails = uploadBox.querySelector(".fileDetails");
                const fileName = uploadBox.querySelector(".filename");

                const purpose = uploadBox.getAttribute("data-purpas");

                // Check if fileInput exists and if it has the data-loader-id attribute
                if (fileInput && fileInput.dataset.loaderId) {
                    const loader = uploadBox.querySelector(
                        `#${fileInput.dataset.loaderId}`
                    );

                    // Click to upload functionality
                    uploadLabel.addEventListener("click", function (event) {
                        event.preventDefault();
                        fileInput.click();
                    });

                    // File input change event
                    fileInput.addEventListener("change", handleFileSelect);
                } else {
                    const loader = "pack-cover-loaderZip";
                }

                // Drag and drop events
                if (uploadLabel) {
                    uploadLabel.addEventListener("dragover", handleDragOver);
                    uploadLabel.addEventListener("dragleave", handleDragLeave);
                    uploadLabel.addEventListener("drop", handleFileDrop);
                }
                function handleFileSelect(event) {
                    // showLoader(loader);
                    event.preventDefault();
                    event.stopPropagation();
                    const file = event.target.files[0];
                    displayFileDetails(file);
                }

                function handleDragOver(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    uploadLabel.classList.add("drag-over");
                }

                function handleDragLeave(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    uploadLabel.classList.remove("drag-over");
                }

                function handleFileDrop(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    uploadLabel.classList.remove("drag-over");
                    const file = event.dataTransfer.files[0];
                    displayFileDetails(file);
                }

                function uploadZip(file) {
                    // Ajax Call
                    const formData = new FormData();
                    formData.append("file", file);
                    formData.append("type", validFileType);

                    if (purpose == "demo") {
                        $.ajax({
                            type: "POST",
                            url: "/producer/pack/demo/store",
                            data: formData,
                            cache: false,
                            processData: false,
                            contentType: false,
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                            },
                            success: function (response) {
                                console.log(response);
                                if (response.success == true) {
                                    toastr.success(response.message);
                                    let Existingdemo = $(
                                        `#demo${response.data.id}`
                                    );
                                    if (Existingdemo) {
                                        Existingdemo.remove();
                                    }

                                    let MelodyWrapper = $("#demoMelodyWrapper");

                                    const base = window.location.origin;

                                    // Update the src by concatenating the domain with response.data.file
                                    const audioSrc = `${base}/${response.data.file}`;
                                    console.log(audioSrc);

                                    let melodyShortName =
                                        response.data.name.substring(0, 40);
                                    let userName = response.user.name;

                                    let preloaderWrapper =
                                        $("#uploadTextAudio");
                                    let uploadedPreview =
                                        $("#fileDetailsAudio");

                                    if (preloaderWrapper) {
                                        uploadedPreview.hide();
                                        preloaderWrapper.show();
                                    }

                                    let html = `
                                            <div class="single--melodi" id="demo${response.data.id}">
                                            <!-- melodi  -->
                                            <div class="melodi melody-demo" data-audio-src="${audioSrc}" data-audio-id="${response.data.id}">
                                                <div class="playPause--icon playPauseBtn">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16"
                                                        viewBox="0 0 12 16" fill="none" id="play-icon">
                                                        <path
                                                            d="M10.272 8.54011L1.40633 14.2546C0.907242 14.5763 0.25 14.218 0.25 13.6242V2.1952C0.25 1.60142 0.90724 1.24311 1.40633 1.56481L10.272 7.27933C10.7302 7.57468 10.7302 8.24476 10.272 8.54011Z"
                                                            fill="#0CCF9F" />
                                                    </svg>
                                                    <svg width="18px" class="d-none" id="pause-icon" height="18px"
                                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M2 6C2 4.11438 2 3.17157 2.58579 2.58579C3.17157 2 4.11438 2 6 2C7.88562 2 8.82843 2 9.41421 2.58579C10 3.17157 10 4.11438 10 6V18C10 19.8856 10 20.8284 9.41421 21.4142C8.82843 22 7.88562 22 6 22C4.11438 22 3.17157 22 2.58579 21.4142C2 20.8284 2 19.8856 2 18V6Z"
                                                            fill="#1C274C" />
                                                        <path
                                                            d="M14 6C14 4.11438 14 3.17157 14.5858 2.58579C15.1716 2 16.1144 2 18 2C19.8856 2 20.8284 2 21.4142 2.58579C22 3.17157 22 4.11438 22 6V18C22 19.8856 22 20.8284 21.4142 21.4142C20.8284 22 19.8856 22 18 22C16.1144 22 15.1716 22 14.5858 21.4142C14 20.8284 14 19.8856 14 18V6Z"
                                                            fill="#1C274C" />
                                                    </svg>
                                                </div>
                                                <!-- producer  -->
                                                <div class="producer">
                                                    <input type="hidden" name="demo_id[]" value="${response.data.id}">
                                                    <h4 class="text-capitalize">
                                                        ${melodyShortName}
                                                    </h4>
                                                    <p class="text-capitalize">${userName}</p>
                                                </div>
                                                <div class="wave"></div>
                                                <div class="time-display">00:00</div>
                                            </div>
                                            <!-- action-and--details  -->
                                            <div class="action-and--details">
                                                <div class="action">
                                                    <button onclick="ShowDeleteAlert(event,this,${response.data.id})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            viewBox="0 0 20 20" fill="none">
                                                            <g clip-path="url(#clip0_8923_1234)">
                                                                <path
                                                                    d="M17.4974 3.33333H14.9141C14.7207 2.39284 14.2089 1.54779 13.4651 0.940598C12.7213 0.333408 11.7909 0.0012121 10.8307 0L9.16406 0C8.20389 0.0012121 7.2735 0.333408 6.52969 0.940598C5.78588 1.54779 5.27414 2.39284 5.08073 3.33333H2.4974C2.27638 3.33333 2.06442 3.42113 1.90814 3.57741C1.75186 3.73369 1.66406 3.94565 1.66406 4.16667C1.66406 4.38768 1.75186 4.59964 1.90814 4.75592C2.06442 4.9122 2.27638 5 2.4974 5H3.33073V15.8333C3.33205 16.938 3.77146 17.997 4.55258 18.7781C5.3337 19.5593 6.39274 19.9987 7.4974 20H12.4974C13.6021 19.9987 14.6611 19.5593 15.4422 18.7781C16.2233 17.997 16.6627 16.938 16.6641 15.8333V5H17.4974C17.7184 5 17.9304 4.9122 18.0867 4.75592C18.2429 4.59964 18.3307 4.38768 18.3307 4.16667C18.3307 3.94565 18.2429 3.73369 18.0867 3.57741C17.9304 3.42113 17.7184 3.33333 17.4974 3.33333ZM9.16406 1.66667H10.8307C11.3476 1.6673 11.8517 1.82781 12.2737 2.1262C12.6958 2.42459 13.0152 2.84624 13.1882 3.33333H6.80656C6.97955 2.84624 7.29898 2.42459 7.72105 2.1262C8.14313 1.82781 8.64717 1.6673 9.16406 1.66667ZM14.9974 15.8333C14.9974 16.4964 14.734 17.1323 14.2652 17.6011C13.7963 18.0699 13.1604 18.3333 12.4974 18.3333H7.4974C6.83436 18.3333 6.19847 18.0699 5.72963 17.6011C5.26079 17.1323 4.9974 16.4964 4.9974 15.8333V5H14.9974V15.8333Z"
                                                                    fill="white" />
                                                                <path
                                                                    d="M8.33333 14.9997C8.55434 14.9997 8.76631 14.9119 8.92259 14.7556C9.07887 14.5993 9.16666 14.3874 9.16666 14.1663V9.16634C9.16666 8.94533 9.07887 8.73337 8.92259 8.57709C8.76631 8.42081 8.55434 8.33301 8.33333 8.33301C8.11232 8.33301 7.90036 8.42081 7.74408 8.57709C7.5878 8.73337 7.5 8.94533 7.5 9.16634V14.1663C7.5 14.3874 7.5878 14.5993 7.74408 14.7556C7.90036 14.9119 8.11232 14.9997 8.33333 14.9997Z"
                                                                    fill="white" />
                                                                <path
                                                                    d="M11.6693 14.9997C11.8903 14.9997 12.1023 14.9119 12.2585 14.7556C12.4148 14.5993 12.5026 14.3874 12.5026 14.1663V9.16634C12.5026 8.94533 12.4148 8.73337 12.2585 8.57709C12.1023 8.42081 11.8903 8.33301 11.6693 8.33301C11.4483 8.33301 11.2363 8.42081 11.08 8.57709C10.9237 8.73337 10.8359 8.94533 10.8359 9.16634V14.1663C10.8359 14.3874 10.9237 14.5993 11.08 14.7556C11.2363 14.9119 11.4483 14.9997 11.6693 14.9997Z"
                                                                    fill="white" />
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_8923_1234">
                                                                    <rect width="20" height="20" fill="white" />
                                                                </clipPath>
                                                            </defs>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        `;

                                    MelodyWrapper.append(html);
                                    let demoMelody = $(
                                        `#demo${response.data.id}`
                                    );
                                    handleMelodyDemoPlayer(
                                        demoMelody,
                                        audioSrc,
                                        response.data.id
                                    );
                                } else {
                                    if (response.errors) {
                                        $.each(
                                            response.errors,
                                            function (key, value) {
                                                $(`#error-${key}`).html(value);
                                            }
                                        );
                                    }
                                }
                            },
                            error: function (xhr, status, error) {
                                var err = eval("(" + xhr.responseText + ")");
                                toastr.error(err.Message);
                            },
                        });
                    } else {
                        // showLoader(loader);
                        // AJAX request using jQuery
                        $.ajax({
                            url: "/producer/upload-zip", // Use the dynamic route based on type
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                            },
                            success: function (data) {
                                // hideLoader(loader);
                                if (data.success) {
                                    $("#melody-name").val(data.file_name);
                                    let html = `<input type="text" name="zipfile" value="${data.url}" />`;
                                    if(data.original_url){
                                        html += `<input type="text" name="original_url" value="${data.original_url}" />`;
                                    }
                                    $("#zipWrapper").append(html);
                                    $("#uploadLabelZip").append(html);
                                    toastr.success("Success:", data.message);
                                } else {
                                    toastr.error("Error:", data.message);
                                    return false;
                                }
                            },
                            error: function (error) {
                                toastr.error("Error:", error.message);
                                return false;
                            },
                        });
                    }
                }

                // handleMelodyPlayer
                function handleMelodyDemoPlayer(
                    initElement,
                    audioSrc,
                    melodyDemoId
                ) {
                    let currentPlaying = null;
                    let currentButton = null;
                    setTimeout(function () {
                        let demoMelody = initElement[0];

                        const melodyId =
                            demoMelody.getAttribute("data-audio-id");

                        const waveContainer = demoMelody.querySelector(".wave");
                        console.log(waveContainer);
                        const playPauseButton =
                            demoMelody.querySelector(".playPauseBtn");
                        let playSvg = demoMelody.querySelector("#play-icon");
                        let pauseSvg = demoMelody.querySelector("#pause-icon");
                        let TotalTimeDisplay =
                            demoMelody.querySelector(".time-display");

                        const waveSurferDemo = WaveSurfer.create({
                            container: waveContainer,
                            waveColor: "#c3c3c3",
                            progressColor: "#0ccf9f",
                            height: 35,
                            cursorColor: "#0ccf9f",
                            barRadius: 10,
                            interact: false,
                        });

                        waveSurferDemo.load(audioSrc);
                        waveSurferDemo.on("ready", function () {
                            const duration = waveSurferDemo.getDuration();

                            TotalTimeDisplay.textContent = formatTime(duration);
                        });
                        // playpause
                        playPauseButton.addEventListener("click", function () {
                            if (waveSurferDemo.isPlaying()) {
                                waveSurferDemo.pause();
                                playSvg.classList.remove("d-none");
                                pauseSvg.classList.add("d-none");
                                bottomPlayPause
                                    .querySelector("#pause")
                                    .classList.add("d-none");
                                bottomPlayPause
                                    .querySelector("#play")
                                    .classList.remove("d-none");
                                return false;
                            } else {
                                // Stop and destroy current WaveSurfer instances
                                if (
                                    typeof currentPlaying !== "undefined" &&
                                    currentPlaying
                                ) {
                                    currentPlaying.pause();
                                    currentPlaying.destroy();
                                    currentPlaying = null;
                                    currentButton = null;
                                }
                            }

                            // Call Ajax to get current playing audio
                            $.ajax({
                                url: `/producer/get-playing-audio/${melodyDemoId}`,
                                type: "GET",
                                success: function (data) {
                                    console.log(data);
                                    waveSurferDemo.load(data.file);
                                    if (data) {
                                        if (
                                            currentPlaying &&
                                            currentPlaying !== waveSurferDemo
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
                                        if (waveSurferDemo.isPlaying()) {
                                            waveSurferDemo.pause();
                                            playSvg.classList.remove("d-none");
                                            pauseSvg.classList.add("d-none");
                                            bottomPlayPause
                                                .querySelector("#pause")
                                                .classList.add("d-none");
                                            bottomPlayPause
                                                .querySelector("#play")
                                                .classList.remove("d-none");
                                        } else {
                                            waveSurferDemo.play();
                                            playSvg.classList.add("d-none");
                                            pauseSvg.classList.remove("d-none");
                                            bottomPlayPause
                                                .querySelector("#pause")
                                                .classList.remove("d-none");
                                            bottomPlayPause
                                                .querySelector("#play")
                                                .classList.add("d-none");
                                            currentPlaying = waveSurferDemo;
                                            currentButton = playPauseButton;
                                            bottomWaveSurfer.load(audioSrc);
                                        }
                                        // Update progress
                                        waveSurferDemo.on(
                                            "audioprocess",
                                            function () {
                                                const currentTime =
                                                    waveSurferDemo.getCurrentTime();
                                                const duration =
                                                    waveSurferDemo.getDuration();
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
                                        waveSurferDemo.on("pause", function () {
                                            bottomWaveSurfer.seekTo(
                                                waveSurferDemo.getCurrentTime() /
                                                    waveSurferDemo.getDuration()
                                            );
                                        });

                                        // OnFinish
                                        waveSurferDemo.on(
                                            "finish",
                                            function () {
                                                if (currentPlaying) {
                                                    currentButton
                                                        .querySelector(
                                                            "#play-icon"
                                                        )
                                                        .classList.remove(
                                                            "d-none"
                                                        );
                                                    currentButton
                                                        .querySelector(
                                                            "#pause-icon"
                                                        )
                                                        .classList.add(
                                                            "d-none"
                                                        );
                                                }
                                                // Update the bottom player state
                                                bottomPlayPause
                                                    .querySelector("#pause")
                                                    .classList.add("d-none");
                                                bottomPlayPause
                                                    .querySelector("#play")
                                                    .classList.remove("d-none");
                                            }
                                        );
                                        console.log(data.data.thumbnail);
                                        let thimb =
                                            document.querySelector(
                                                "#thumbnail"
                                            );
                                        thimb.src = data.data.thumbnail;
                                        $(".play-title").text(
                                            data.data.file_name.substring(
                                                0,
                                                10
                                            ) + "..."
                                        );
                                        $(".artist").text(data.data.name);

                                        bottomPlayer?.classList.add("show");
                                    } else {
                                        toastr.error(
                                            "Error:",
                                            "Melody not found"
                                        );
                                    }
                                },
                                error: function (error) {
                                    toastr.error("Error:", error.message);
                                },
                            });
                        });
                        // updateTimeProgress
                        function updateTimeProgress(currentTime, duration) {
                            totalPastTimeElement.textContent =
                                formatTime(currentTime);
                            totalDurationElement.textContent =
                                formatTime(duration);
                        }
                        // formatTime
                        function formatTime(seconds) {
                            const minutes = Math.floor(seconds / 60);
                            const remainingSeconds = Math.floor(seconds % 60);

                            return `${minutes}:${remainingSeconds < 10 ? "0" : ""}${remainingSeconds}`;
                        }
                    }, 100);
                }

                function displayFileDetails(file) {
                    if (uploadZip(file) !== false) {
                        fileDetails.style.display = "block";
                        fileName.textContent = file.name;
                        // loader.style.display = "none";
                        uploadText.style.display = "none";
                    }
                }
            });
        }

        // Call the function with the specific selectors and file types
        handleFileUploads(".pack--file--upload", ".zip");
        handleFileUploads(".pack--audio-demos", ".mp3");
        handleFileUploads(".pack-melody-upload", ".wav");

        // handleDefaultAudioPlayer
        function handleDemoAudioPlayer() {
            let playDemoTrigger = document.querySelectorAll(".play--demo");
            let bottomPlayer = document.querySelector(
                ".default--audio--player"
            );
            let demoWave = bottomPlayer?.querySelector("#bottom-wave");
            let demoPlayPause = bottomPlayer?.querySelector(".play-pause");
            let backwardButton = bottomPlayer?.querySelector(".backward");
            let forwardButton = bottomPlayer?.querySelector(".forward");
            // Select time display elements
            const totalDurationElement =
                bottomPlayer?.querySelector(".duration");
            const totalPastTimeElement =
                bottomPlayer?.querySelector(".current-time");
            // Volume slider
            const volumeSlider =
                bottomPlayer?.querySelector(".volume--control");
            let currentDemoWaveSurfer = null;

            if (playDemoTrigger) {
                playDemoTrigger.forEach((trigger) => {
                    trigger?.addEventListener("click", function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        let audioSrc = trigger?.getAttribute("data-audio");
                        let audioId = trigger?.getAttribute("data-audio-id");

                        // Stop and destroy the previous instance if any
                        if (currentDemoWaveSurfer) {
                            currentDemoWaveSurfer.stop();
                            currentDemoWaveSurfer.destroy();
                            currentDemoWaveSurfer = null;
                        }
                        demoWave.innerHTML = "";

                        const demoWaveSurfer = WaveSurfer.create({
                            container: demoWave,
                            waveColor: "#c3c3c3",
                            progressColor: "#0ccf9f",
                            height: 35,
                            cursorColor: "#0ccf9f",
                            barRadius: 10,
                            interact: false,
                        });

                        demoWaveSurfer.load(audioSrc);

                        demoWaveSurfer.on("audioprocess", function () {
                            const currentTime = demoWaveSurfer.getCurrentTime();
                            const duration = demoWaveSurfer.getDuration();
                            if (duration > 0) {
                                updateTimeProgress(currentTime, duration);
                            }
                        });
                        // Store the current instance
                        currentDemoWaveSurfer = demoWaveSurfer;

                        // Call Ajax to get current playing audio
                        $.ajax({
                            url: `/producer/get-playing-audio/${audioId}`,
                            type: "GET",
                            success: function (data) {
                                demoWaveSurfer.load(data.file);
                                if (data) {
                                    // initial load
                                    if (demoWaveSurfer.isPlaying()) {
                                        demoWaveSurfer.pause();
                                    } else {
                                        demoWaveSurfer.play();
                                    }
                                    demoPlayPause
                                        .querySelector("#play")
                                        .classList.add("d-none");
                                    demoPlayPause
                                        .querySelector("#pause")
                                        .classList.remove("d-none");
                                    let thimb =
                                        document.querySelector("#thumbnail");
                                    let siteUrl = window.location.origin;
                                    thimb.src =
                                        siteUrl + data.data.pack.thumbnail;
                                    let melodyname = data.data.name.replace(
                                        /-/g,
                                        " "
                                    );
                                    $(".play-title").text(
                                        melodyname.substring(0, 25) + "..."
                                    );
                                    $(".default--audio--player .artist").text(
                                        data.data.user.producer_name
                                    );

                                    bottomPlayer?.classList.add("show");
                                } else {
                                    toastr.error("Error:", "Melody not found");
                                }
                            },
                            error: function (error) {
                                toastr.error("Error:", error.message);
                            },
                        });

                        // demoplaypause
                        demoPlayPause?.addEventListener("click", function () {
                            if (demoWaveSurfer.isPlaying()) {
                                demoWaveSurfer.pause();
                                demoPlayPause
                                    .querySelector("#play")
                                    .classList.remove("d-none");
                                demoPlayPause
                                    .querySelector("#pause")
                                    .classList.add("d-none");
                            } else {
                                demoWaveSurfer.play();
                                demoPlayPause
                                    .querySelector("#play")
                                    .classList.add("d-none");
                                demoPlayPause
                                    .querySelector("#pause")
                                    .classList.remove("d-none");
                            }
                        });
                        // backward forward
                        backwardButton.addEventListener("click", function () {
                            let currentTime = demoWaveSurfer.getCurrentTime();
                            demoWaveSurfer.seekTo(
                                Math.max(
                                    (currentTime - 5) /
                                        demoWaveSurfer.getDuration(),
                                    0
                                )
                            );
                        });
                        forwardButton.addEventListener("click", function () {
                            let currentTime = demoWaveSurfer.getCurrentTime();
                            demoWaveSurfer.seekTo(
                                Math.max(
                                    (currentTime + 5) /
                                        demoWaveSurfer.getDuration(),
                                    0
                                )
                            );
                        });

                        // updateTimeProgress
                        function updateTimeProgress(currentTime, duration) {
                            totalPastTimeElement.textContent =
                                formatTime(currentTime);
                            totalDurationElement.textContent =
                                formatTime(duration);
                        }
                        // formatTime
                        function formatTime(seconds) {
                            const minutes = Math.floor(seconds / 60);
                            const remainingSeconds = Math.floor(seconds % 60);

                            return `${minutes}:${remainingSeconds < 10 ? "0" : ""}${remainingSeconds}`;
                        }

                        volumeSlider.addEventListener("input", function () {
                            demoWaveSurfer.setVolume(volumeSlider.value); // Use the correct instance
                        });

                        bottomPlayer?.classList.add("show");
                    });
                });
            }
        }
        handleDemoAudioPlayer();

        // tooltips
        const tooltipTriggerList = document.querySelectorAll(
            '[data-bs-toggle="tooltip"]'
        );
        const tooltipList = [...tooltipTriggerList].map(
            (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
        );
        // handleAnimatedTab
        function handleAnimatedTab() {
            let filterGraps = document.querySelectorAll(".filter--graph");

            if (filterGraps) {
                filterGraps.forEach((graph) => {
                    let items = graph.querySelectorAll(".item");
                    let indicators = graph.querySelectorAll(".indicator");
                    items.forEach((item) => {
                        item.addEventListener("click", function () {
                            items.forEach((i) => i.classList.remove("active"));
                            item.classList.add("active");
                            const index = this.getAttribute("data-index");
                            indicators.forEach((indicator) => {
                                indicator.style.left = `calc(${index} * 100% / 3)`;
                            });
                        });
                    });
                });
            }
        }
        handleAnimatedTab();

        // handleChartFilter
        function handleChartFilter() {
            document.querySelectorAll(".melodi--filter li")?.forEach((item) => {
                item.addEventListener("click", function () {
                    document
                        .querySelector(".melodi--filter li.active")
                        ?.classList.remove("active");
                    this.classList.add("active");
                });
            });
        }
        handleChartFilter();

        // album slider
        $(".owl-carousel.album--slider").owlCarousel({
            loop: false,
            margin: 10,
            items: 1,
            dots: true,
            nav: true,
            autoplay: false,
            navText: [
                '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M24.9974 36.6663H14.9974C6.66406 36.6663 3.33073 33.333 3.33073 24.9997V14.9997C3.33073 6.66634 6.66406 3.33301 14.9974 3.33301H24.9974C33.3307 3.33301 36.6641 6.66634 36.6641 14.9997V24.9997C36.6641 33.333 33.3307 36.6663 24.9974 36.6663Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path class="arrow-icon" d="M22.1016 25.8829L16.2349 19.9995L22.1016 14.1162" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M15.0026 36.6663H25.0026C33.3359 36.6663 36.6693 33.333 36.6693 24.9997V14.9997C36.6693 6.66634 33.3359 3.33301 25.0026 3.33301H15.0026C6.66927 3.33301 3.33594 6.66634 3.33594 14.9997V24.9997C3.33594 33.333 6.66927 36.6663 15.0026 36.6663Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path class="arrow-icon" d="M17.8984 25.8829L23.7651 19.9995L17.8984 14.1162" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            ],
        });
        // Function to show popup
        function showPopup(popElement) {
            popElement?.classList.add("show");
            document.body.style.overflow = "hidden";
        }

        // Function to hide popup
        function hidePopup(popElement) {
            popElement?.classList.remove("show");
            document.body.style.overflow = "auto";
        }

        // Function to handle popup interaction
        function handleProPopup() {
            let trigger = document.querySelector(".menu--bottom li a");
            let popup = document.getElementById("proPopup--wrapper");
            let closeBtn = document.querySelector("#proPopup .top--header svg");

            if (trigger && popup) {
                trigger.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent default action of the link
                    showPopup(popup);
                });
                closeBtn.addEventListener("click", function () {
                    hidePopup(popup);
                });
            }
        }
        // handleProPopup();

        // handle Collab popup
        function handleCollabPopup() {
            let triggers = document.querySelectorAll(
                ".single--melodi .download"
            );
            let popup = document.getElementById("collab--popup--wrapp");
            let closeBtns = document.querySelectorAll(
                "#collab--popup--wrapp .close--modal"
            );

            if (triggers && popup) {
                triggers.forEach((trigger) => {
                    trigger.addEventListener("click", function (event) {
                        event.preventDefault(); // Prevent default action of the link
                        showPopup(popup);
                    });
                });
                closeBtns.forEach((closeBtn) => {
                    closeBtn.addEventListener("click", function () {
                        hidePopup(popup);
                    });
                });
            }
        }
        handleCollabPopup();

        // video popup home
        $(".vid--play").magnificPopup({
            type: "iframe",
            iframe: {
                patterns: {
                    youtube: {
                        index: "youtube.com/",

                        id: "v=",
                        src: "https://www.youtube.com/embed/%id%?autoplay=1",
                    },
                },

                srcAction: "iframe_src",
            },
        });
        // initial call
        function AddMelodiesOnLoad() {
            let addmelodiesOptions = document.querySelectorAll(
                ".add--melodies--inner"
            );
            if (addmelodiesOptions) {
                addmelodiesOptions.forEach((item, index) => {
                    // handleRadioInput(index);
                    // melodiUpload(index);
                });
            }
        }
        AddMelodiesOnLoad();

        // handleSingleAddMelodies
        function handleSingleAddMelodies() {
            let melodiesContainer = document.querySelector(
                ".add--melodies--inner"
            );
            let melodyCounter = document.querySelectorAll(
                ".add--melodies--options"
            ).length;

            if (melodiesContainer) {
                let addBtn = document.querySelector(".add-melodi-btn");

                addBtn.addEventListener("click", function (e) {
                    melodyCounter++;
                    let AddItems = `<div class="add--melodies--options mt_80" data-counter="${melodyCounter}">
                                        <div class="custom--input--row mt_45">
                                        <div class="left--side m-name">
                                            <div class="row--title">
                                            <p>Melody Name</p>
                                            </div>
                                            <div class="input">
                                            <input type="text" id="melody-name-${melodyCounter}">
                                            </div>
                                        </div>
                                        <div class="right--side genres">
                                            <div class="row--title">
                                            <p>Genres</p>
                                            </div>
                                            <div class="select--box">
                                            <select id="genres-select-${melodyCounter}" style="display: none;">
                                                <option selected="" disabled="">Choose from dropdown</option>
                                                <option value="1">Trap</option>
                                                <option value="2">Reggaeton</option>
                                                <option value="3">Drill</option>
                                                <option value="4">RnB</option>
                                                <option value="5">Afro Beat</option>
                                            </select>
                                            <div class="nice-select" tabindex="0">
                                                <span class="current">Choose from dropdown</span>
                                                <ul class="list">
                                                <li data-value="Choose from dropdown" class="option selected disabled">Choose from dropdown</li>
                                                <li data-value="1" class="option">Trap</li>
                                                <li data-value="2" class="option">Reggaeton</li>
                                                <li data-value="3" class="option">Drill</li>
                                                <li data-value="4" class="option">RnB</li>
                                                <li data-value="5" class="option">Afro Beat</li>
                                                </ul>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="custom--input--rowv2 mt_45 add--bpm">
                                        <div class="left--side">
                                            <div class="row--title">
                                            <p>Add BPM</p>
                                            </div>
                                            <div class="radio--control">
                                            <div class="radio--group">
                                                <input id="exact-${melodyCounter}" type="radio" name="bpm-group-${melodyCounter}" required="">
                                                <label for="exact-${melodyCounter}">Exact</label>
                                            </div>
                                            <input class="hide" type="text" id="forExact-${melodyCounter}">
                                            </div>
                                        </div>
                                        <div class="right--side">
                                            <div class="radio--control">
                                            <div class="radio--group">
                                                <input id="range-${melodyCounter}" type="radio" name="bpm-group-${melodyCounter}" required="">
                                                <label for="range-${melodyCounter}">Range</label>
                                            </div>
                                            <div class="range--inputs hide">
                                                <input type="text" id="range-start-${melodyCounter}">
                                                <p>To</p>
                                                <input type="text" id="range-end-${melodyCounter}">
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="custom--input--rowv2 mt_45 add--key">
                                        <div class="left--side">
                                            <div class="row--title">
                                            <p>Add Key</p>
                                            </div>
                                            <div class="radio--control">
                                            <div class="radio--group">
                                                <input id="major-${melodyCounter}" type="radio" name="key-group-${melodyCounter}" required="">
                                                <label for="major-${melodyCounter}">Major</label>
                                            </div>
                                            <div class="hide">
                                                <select id="key-major-select-${melodyCounter}" style="display: none;">
                                                <option selected="" disabled="">Choose from dropdown</option>
                                                <option value="1">Key 1</option>
                                                <option value="2">Key 2</option>
                                                <option value="3">Key 3</option>
                                                </select>
                                                <div class="nice-select" tabindex="0">
                                                <span class="current">Choose from dropdown</span>
                                                <ul class="list">
                                                    <li data-value="Choose from dropdown" class="option selected disabled">Choose from dropdown</li>
                                                    <li data-value="1" class="option">Key 1</li>
                                                    <li data-value="2" class="option">Key 2</li>
                                                    <li data-value="3" class="option">Key 3</li>
                                                </ul>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="right--side">
                                            <div class="radio--control">
                                            <div class="radio--group">
                                                <input id="sharp-${melodyCounter}" type="radio" name="key-group-${melodyCounter}" required="">
                                                <label for="sharp-${melodyCounter}">Sharp</label>
                                            </div>
                                            <div class="select--box">
                                                <div class="hide">
                                                <select id="key-sharp-select-${melodyCounter}" style="display: none;">
                                                    <option selected="" disabled="">Choose from dropdown</option>
                                                    <option value="1">Key 1</option>
                                                    <option value="2">Key 2</option>
                                                    <option value="3">Key 3</option>
                                                </select>
                                                <div class="nice-select" tabindex="0">
                                                    <span class="current">Choose from dropdown</span>
                                                    <ul class="list">
                                                    <li data-value="Choose from dropdown" class="option selected disabled">Choose from dropdown</li>
                                                    <li data-value="1" class="option">Key 1</li>
                                                    <li data-value="2" class="option">Key 2</li>
                                                    <li data-value="3" class="option">Key 3</li>
                                                    </ul>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="custom--input--row mt_45">
                                        <div class="left--side m-name">
                                            <div class="row--title">
                                            <p>Artist Type</p>
                                            </div>
                                            <div class="select--box">
                                            <select id="artist-select-${melodyCounter}" style="display: none;">
                                                <option selected="" disabled="">Choose from dropdown</option>
                                                <option value="1">Drake</option>
                                                <option value="2">Travis Scott</option>
                                                <option value="3">Juice WRLD</option>
                                                <option value="4">Lil Baby</option>
                                                <option value="5">Roddy Ricch</option>
                                            </select>
                                            <div class="nice-select" tabindex="0">
                                                <span class="current">Choose from dropdown</span>
                                                <ul class="list">
                                                <li data-value="Choose from dropdown" class="option selected disabled">Choose from dropdown</li>
                                                <li data-value="1" class="option">Drake</li>
                                                <li data-value="2" class="option">Travis Scott</li>
                                                <li data-value="3" class="option">Juice WRLD</li>
                                                <li data-value="4" class="option">Lil Baby</li>
                                                <li data-value="5" class="option">Roddy Ricch</li>
                                                </ul>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="right--side genres">
                                            <div class="row--title">Instruments</div>
                                            <div class="select--box">
                                            <select id="instruments-select-${melodyCounter}" style="display: none;">
                                                <option selected="" disabled="">Choose from dropdown</option>
                                                <option value="1">Guitar</option>
                                                <option value="2">Keys</option>
                                                <option value="3">Vocals</option>
                                                <option value="4">Synth</option>
                                                <option value="5">Pads</option>
                                            </select>
                                            <div class="nice-select" tabindex="0">
                                                <span class="current">Choose from dropdown</span>
                                                <ul class="list">
                                                <li data-value="Choose from dropdown" class="option selected disabled">Choose from dropdown</li>
                                                <li data-value="1" class="option">Guitar</li>
                                                <li data-value="2" class="option">Keys</li>
                                                <li data-value="3" class="option">Vocals</li>
                                                <li data-value="4" class="option">Synth</li>
                                                <li data-value="5" class="option">Pads</li>
                                                </ul>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="custom--input--row mt_45 upload">
                                        <div class="left--side m-name">
                                            <div class="row--title">
                                            <p>Melody File</p>
                                            </div>
                                            <div class="uplod--melodi">
                                            <input type="file" id="melodi-upload-${melodyCounter}" data-filename=".file-name-melodi-${melodyCounter}">
                                            <label for="melodi-upload-${melodyCounter}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M21.6668 14.3L21.2668 19.3C21.1168 20.83 20.9968 22 18.2868 22H5.70684C2.99684 22 2.87684 20.83 2.72684 19.3L2.32684 14.3C2.24684 13.47 2.50684 12.7 2.97684 12.11C2.98684 12.1 2.98684 12.1 2.99684 12.09C3.54684 11.42 4.37684 11 5.30684 11H18.6868C19.6168 11 20.4368 11.42 20.9768 12.07C20.9868 12.08 20.9968 12.09 20.9968 12.1C21.4868 12.69 21.7568 13.46 21.6668 14.3Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10"></path>
                                                <path d="M3.5 11.4303V6.28027C3.5 2.88027 4.35 2.03027 7.75 2.03027H9.02C10.29 2.03027 10.58 2.41027 11.06 3.05027L12.33 4.75027C12.65 5.17027 12.84 5.43027 13.69 5.43027H16.24C19.64 5.43027 20.49 6.28027 20.49 9.68027V11.4703" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M9.42969 17H14.5697" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                                <p class="file-name-melodi-${melodyCounter}">Add File</p>
                                            </label>
                                            </div>
                                        </div>
                                        <div class="right--side genres">
                                            <div class="row--title">
                                            <p>Melody File</p>
                                            </div>
                                            <div class="uplod--melodi license--upload">
                                            <input type="file" id="license-upload-${melodyCounter}" data-filename=".file-name-license-${melodyCounter}">
                                            <label for="license-upload-${melodyCounter}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M21.6668 14.3L21.2668 19.3C21.1168 20.83 20.9968 22 18.2868 22H5.70684C2.99684 22 2.87684 20.83 2.72684 19.3L2.32684 14.3C2.24684 13.47 2.50684 12.7 2.97684 12.11C2.98684 12.1 2.98684 12.1 2.99684 12.09C3.54684 11.42 4.37684 11 5.30684 11H18.6868C19.6168 11 20.4368 11.42 20.9768 12.07C20.9868 12.08 20.9968 12.09 20.9968 12.1C21.4868 12.69 21.7568 13.46 21.6668 14.3Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10"></path>
                                                <path d="M3.5 11.4303V6.28027C3.5 2.88027 4.35 2.03027 7.75 2.03027H9.02C10.29 2.03027 10.58 2.41027 11.06 3.05027L12.33 4.75027C12.65 5.17027 12.84 5.43027 13.69 5.43027H16.24C19.64 5.43027 20.49 6.28027 20.49 9.68027V11.4703" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M9.42969 17H14.5697" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                                <p class="file-name-license-${melodyCounter}">Add File</p>
                                            </label>
                                            </div>
                                        </div>
                                        </div>
                                    </div>`;
                    e.preventDefault();
                    melodiesContainer.insertAdjacentHTML("beforeend", AddItems);
                    // handleRadioInput(melodyCounter);
                    melodiUpload(melodyCounter);
                });
            }
        }
        // handleSingleAddMelodies();

        // handle radio input
        function handleRadioInput(counter) {
            const addBpm = document.querySelector(
                `.add--melodies--options[data-counter="${counter}"] .add--bpm`
            );
            const addKey = document.querySelector(
                `.add--melodies--options[data-counter="${counter}"] .add--key`
            );

            if (addBpm && addKey) {
                const exactRadio = addBpm.querySelector(`#exact-${counter}`);
                const rangeRadio = addBpm.querySelector(`#range-${counter}`);
                let exactInput = addBpm.querySelector(`#forExact-${counter}`);
                let rangeInputs = addBpm.querySelector(`.range--inputs`);

                const majorRadio = addKey.querySelector(`#major-${counter}`);
                const sharpRadio = addKey.querySelector(`#sharp-${counter}`);
                let selectLeft = addKey.querySelector(`.left--side .hide`);
                let selectRight = addKey.querySelector(`.right--side .hide`);

                exactRadio?.addEventListener("change", function () {
                    if (exactRadio.checked) {
                        console.log("checked");
                        exactInput.classList.remove("hide");
                        exactInput.classList.add("show");
                        rangeInputs.classList.add("hide");
                        rangeInputs.classList.remove("show");
                    }
                });
                rangeRadio?.addEventListener("change", function () {
                    if (rangeRadio.checked) {
                        console.log("checked");
                        rangeInputs.classList.remove("hide");
                        rangeInputs.classList.add("show");
                        exactInput.classList.add("hide");
                        exactInput.classList.remove("show");
                    }
                });
                majorRadio?.addEventListener("change", function () {
                    if (majorRadio.checked) {
                        console.log("checked");
                        selectLeft.classList.remove("hide");
                        selectLeft.classList.add("show");
                        selectRight.classList.add("hide");
                        selectRight.classList.remove("show");
                    }
                });
                sharpRadio?.addEventListener("change", function () {
                    if (sharpRadio.checked) {
                        console.log("checked");
                        selectLeft.classList.add("hide");
                        selectLeft.classList.remove("show");
                        selectRight.classList.remove("hide");
                        selectRight.classList.add("show");
                    }
                });
            }
        }

        // melodiUpload
        function melodiUpload(counter) {
            const melodiUpload = document.getElementById(
                `melodi-upload-${counter}`
            );
            const licenseUpload = document.getElementById(
                `license--upload-${counter}`
            );

            const melodiFileUploadHandler = (event) => {
                const input = event.target;
                const file = input.files[0];
                let fileData = input.getAttribute("data-filename");
                let fileNameElement = document.querySelector(fileData);
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        let fileName = input.files[0].name;
                        fileNameElement.textContent = fileName;
                    };
                    reader.readAsDataURL(file);
                }
            };

            if (melodiUpload) {
                melodiUpload.addEventListener(
                    "change",
                    melodiFileUploadHandler
                );
            }

            if (licenseUpload) {
                licenseUpload.addEventListener(
                    "change",
                    melodiFileUploadHandler
                );
            }
        }

        function handleAddGenresDropdown() {
            let addGenresWrapp = document.querySelectorAll(".pack--genres");

            addGenresWrapp.forEach((item) => {
                let trigger = item.querySelector(".trigger");
                let dropdown = item.querySelector(".genres--dropdown");
                let allGenresContainer = item.querySelector(
                    ".all--added--genres"
                );
                let addGenresDiv =
                    allGenresContainer.querySelector(".add--genres");

                if (trigger) {
                    trigger.addEventListener("click", function (event) {
                        event.stopPropagation();
                        dropdown.classList.add("show");
                    });
                }

                dropdown.addEventListener("click", function (event) {
                    if (event.target.tagName.toLowerCase() === "li") {
                        let selectedGenre = decodeHtmlEntities(
                            event.target.innerHTML.trim()
                        );
                        let genreExists = false;

                        // decodeHtmlEntities function
                        function decodeHtmlEntities(text) {
                            let textarea = document.createElement("textarea");
                            textarea.innerHTML = text;
                            return textarea.value;
                        }

                        // Check if the genre already exists before the addGenresDiv

                        // Ensure we only compare actual genre list items, not the addGenresDiv itself
                        let existingGenres = Array.from(
                            allGenresContainer.children
                        ).filter(
                            (li) =>
                                li !== addGenresDiv &&
                                li.tagName.toLowerCase() === "li"
                        );

                        for (let li of existingGenres) {
                            let genreName = li.firstChild.textContent.trim();

                            if (
                                genreName.toLowerCase() ===
                                selectedGenre.toLowerCase()
                            ) {
                                genreExists = true;
                                break;
                            }
                        }

                        // If the genre doesn't exist, append it to the list
                        if (!genreExists) {
                            let liElement = document.createElement("li");
                            liElement.textContent = selectedGenre;
                            console.log();

                            // create hidden input
                            let hiddenInput = document.createElement("input");
                            hiddenInput.type = "hidden";
                            let inputName = event.target
                                .getAttribute("data-item")
                                .toLowerCase();
                            let inputValue = event.target
                                .getAttribute("data-value")
                                .toLowerCase();

                            if (inputName) {
                                hiddenInput.name = `${inputName}[]`;
                                hiddenInput.value = inputValue;
                            }

                            liElement.appendChild(hiddenInput);

                            // Create a close icon element
                            let closeIcon = document.createElement("span");
                            closeIcon.innerHTML = "&times;";
                            closeIcon.classList.add("close-icon");
                            // Add click event listener to the close icon to remove the li element
                            closeIcon.addEventListener("click", function (e) {
                                e.stopPropagation();
                                liElement.remove();
                            });
                            liElement.appendChild(closeIcon);
                            allGenresContainer.insertBefore(
                                liElement,
                                addGenresDiv
                            );
                        } else {
                            alert(selectedGenre + " is already added.");
                        }
                    }
                });

                document.addEventListener("click", function (event) {
                    let target = event.target;
                    if (
                        (target !== trigger && !dropdown.contains(target)) ||
                        event.target.tagName.toLowerCase() === "li"
                    ) {
                        dropdown.classList.remove("show");
                    }
                });
            });
        }
        handleAddGenresDropdown();

        // handleBMPdropdown
        function handleBMPdropdown() {
            let BPMContainers = document.querySelectorAll(".option.bmp--range");

            if (BPMContainers) {
                BPMContainers.forEach((container) => {
                    let trigger = container.querySelector(".trigger");
                    let ArrowIcon = container.querySelector(".trigger svg");
                    let dropdown = container.querySelector(".bmp--dropdown");
                    let extactRadios = document.querySelectorAll(".exactRadio");
                    let rangeRadios = document.querySelectorAll(".rangeRadio");
                    let extactInputs = document.querySelectorAll(".exactInput");
                    let rangeInputs = document.querySelectorAll(".rangeInput");
                    let clearButtons =
                        document.querySelectorAll(".clearInputs");
                    let saveButtons = document.querySelectorAll(".saveChanges");
                    let rangeDivider = document.querySelector(
                        ".range--inputs--wrapp .divider"
                    );

                    rangeDivider.classList.add("d-none");

                    trigger.addEventListener("click", function () {
                        dropdown.classList.toggle("show");
                        ArrowIcon.classList.toggle("show");
                    });

                    // Initial load
                    extactInputs.forEach((input) => {
                        input.style.opacity = "1";
                        input.style.visibility = "visible";
                    });

                    // Event listeners for exactRadio
                    extactRadios.forEach((radio) => {
                        radio.addEventListener("change", function () {
                            if (radio.checked) {
                                extactInputs.forEach((input) => {
                                    input.style.opacity = "1";
                                    input.style.visibility = "visible";
                                });
                                rangeInputs.forEach((input) => {
                                    input.style.opacity = "0";
                                    input.style.visibility = "hidden";
                                });
                                rangeDivider.classList.add("d-none");
                                document
                                    .querySelectorAll("input[type='number']")
                                    .forEach(function (input) {
                                        input.value = "";
                                    });
                            }
                        });
                    });

                    // Event listeners for rangeRadio
                    rangeRadios.forEach((radio) => {
                        radio.addEventListener("change", function () {
                            if (radio.checked) {
                                rangeInputs.forEach((input) => {
                                    input.style.opacity = "1";
                                    input.style.visibility = "visible";
                                });
                                extactInputs.forEach((input) => {
                                    input.style.opacity = "0";
                                    input.style.visibility = "hidden";
                                });
                                rangeDivider.classList.remove("d-none");
                                document
                                    .querySelectorAll("input[type='number']")
                                    .forEach(function (input) {
                                        input.value = "";
                                    });
                            }
                        });
                    });

                    // Clear button functionality
                    clearButtons.forEach((clearButton) => {
                        clearButton.addEventListener("click", function (e) {
                            e.preventDefault();
                            document
                                .querySelectorAll(".rangeInput")
                                .forEach(function (input) {
                                    input.value = "";
                                });
                            document
                                .querySelectorAll(".exactInput")
                                .forEach(function (input) {
                                    input.value = "";
                                });
                        });
                    });

                    // Save button functionality
                    saveButtons.forEach((saveButton) => {
                        saveButton.addEventListener("click", function (e) {
                            e.preventDefault();
                            dropdown.classList.remove("show");
                        });
                    });

                    // Close dropdown if clicking outside
                    document.addEventListener("click", function (e) {
                        let target = e.target;
                        if (
                            target !== dropdown &&
                            !dropdown.contains(target) &&
                            !trigger.contains(target)
                        ) {
                            dropdown.classList.remove("show");
                        }
                    });
                });
            }
        }
        handleBMPdropdown();
        // handleKeyDropdown
        function handleKeyDropdown() {
            let keysWrapp = document.querySelectorAll(".keys-option--wrapp");
            if (keysWrapp) {
                keysWrapp.forEach((keyWrapp) => {
                    let trigger = keyWrapp.querySelector(".trigger");
                    let dropdowns = keyWrapp.querySelectorAll(".key--dropdown");
                    let clearButtons =
                        keyWrapp.querySelectorAll(".clearInputs");
                    let saveButtons = keyWrapp.querySelectorAll(".saveChanges");
                    let keyInputs = keyWrapp.querySelectorAll(
                        '.key--group input[type="radio"]'
                    );
                    let keyTypes = keyWrapp.querySelectorAll(
                        '.key--type input[type="radio"]'
                    );
                    let selectedKey = "";
                    let selectedKeyType = "";

                    // Create a span for text content
                    let triggerTextSpan = document.createElement("span");
                    triggerTextSpan.textContent = "Key";
                    trigger.appendChild(triggerTextSpan);

                    // Create the SVG element
                    let svgIcon = document.createElement("span");
                    svgIcon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                      <mask id="mask0_5256_2893" style="mask-type: luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="10" height="10">
                        <path d="M0 10H10V0H0V10Z" fill="white"></path>
                      </mask>
                      <g mask="url(#mask0_5256_2893)">
                        <path d="M1.37607 2.62573L5.10752 6.35717L8.61718 2.84751L9.50109 3.73138L5.10752 8.12494L0.492188 3.50962L1.37607 2.62573Z" fill="white" fill-opacity="0.4"></path>
                      </g>
                    </svg>`;
                    trigger.appendChild(svgIcon);

                    // Create a hidden input
                    let hiddenInput = document.createElement("input");
                    hiddenInput.type = "hidden";
                    hiddenInput.name = "selected_key";
                    trigger.appendChild(hiddenInput);

                    trigger.addEventListener("click", () => {
                        dropdowns.forEach((dropdown) => {
                            dropdown.classList.toggle("show");
                        });
                    });

                    keyInputs.forEach((key) => {
                        key.addEventListener("click", function () {
                            selectedKey = this.nextElementSibling.textContent;
                            updateTriggerText();
                        });
                    });

                    keyTypes.forEach((Keytype) => {
                        Keytype.addEventListener("click", function () {
                            selectedKeyType =
                                this.nextElementSibling.textContent.trim();
                            updateTriggerText();
                        });
                    });
                    // updateTriggerText
                    function updateTriggerText() {
                        let updatedText = "";

                        if (selectedKey) {
                            updatedText = selectedKey;

                            if (selectedKeyType) {
                                updatedText += ` ${selectedKeyType}`;
                            }
                        } else if (selectedKeyType) {
                            updatedText = selectedKeyType;
                        }

                        // Hide the initial text and SVG if a key is selected
                        if (selectedKey || selectedKeyType) {
                            triggerTextSpan.textContent = updatedText;
                            svgIcon.style.display = "none";
                        } else {
                            // Show the initial text and SVG if no key is selected
                            triggerTextSpan.style.display = "";
                            svgIcon.style.display = "";
                        }

                        triggerTextSpan.textContent = updatedText;

                        // Update hidden input value
                        hiddenInput.value = updatedText;
                    }
                    clearButtons.forEach((clearBtn) => {
                        clearBtn.addEventListener("click", function (e) {
                            e.preventDefault();
                            selectedKey = "";
                            selectedKeyType = "";
                            svgIcon.style.display = "block";
                            triggerTextSpan.textContent = "key";
                            document
                                .querySelectorAll(
                                    '.key--dropdown input[type="radio"]'
                                )
                                .forEach((input) => {
                                    input.checked = false;
                                });
                        });
                    });
                    saveButtons.forEach((saveBtn) => {
                        saveBtn.addEventListener("click", function (e) {
                            e.preventDefault();
                            dropdowns.forEach((dropdown) => {
                                dropdown.classList.remove("show");
                            });
                        });
                    });
                    dropdowns.forEach((dropdown) => {
                        document.addEventListener("click", function (e) {
                            let target = e.target;
                            if (
                                target !== dropdown &&
                                !dropdown.contains(target) &&
                                !trigger.contains(target)
                            ) {
                                dropdown.classList.remove("show");
                            }
                        });
                    });
                });
            }
        }
        handleKeyDropdown();

        function handleModeSwitcher() {
            let trigger = document.querySelector(".mode-switcher");

            // Check localStorage or default to dark mode for new users
            const currentTheme = localStorage.getItem("theme") || "dark"; // Default to dark if no theme is saved

            if (currentTheme === "dark") {
                document.documentElement.setAttribute("data-theme", "dark");
                if (trigger) {
                    trigger.classList.add("active");
                    let textElem = trigger.querySelector(".text");
                    if (textElem) {
                        textElem.innerHTML = "Switch To Light Mode";
                    }
                }
            } else {
                document.documentElement.setAttribute("data-theme", "light");
                if (trigger) {
                    trigger.classList.remove("active");
                    let textElem = trigger.querySelector(".text");
                    if (textElem) {
                        textElem.innerHTML = "Switch To Dark Mode";
                    }
                }
            }

            // Listen for click event on the trigger button
            trigger?.addEventListener("click", function (e) {
                e.preventDefault();
                this.classList.toggle("active");

                if (this.classList.contains("active")) {
                    this.querySelector(".text").innerHTML =
                        "Switch To Light Mode";
                    localStorage.setItem("theme", "dark");
                    document.documentElement.setAttribute("data-theme", "dark");
                } else {
                    this.querySelector(".text").innerHTML =
                        "Switch To Dark Mode";
                    localStorage.setItem("theme", "light");
                    document.documentElement.setAttribute(
                        "data-theme",
                        "light"
                    );
                }
                handleMonthlyChart();
                handleLightWaveImg();
            });
        }

        handleModeSwitcher();

        // handle mobile search
        function handleMobileSearch() {
            let trigger = document.querySelector(".open-mobile-search");
            let mobileSearch = document.querySelector(".search-mobile");
            let closeBtn = document.querySelector(".mobile--search--close");

            if (trigger && mobileSearch) {
                trigger.addEventListener("click", function (e) {
                    e.preventDefault();
                    mobileSearch.classList.add("show");
                });
                closeBtn.addEventListener("click", function () {
                    mobileSearch.classList.remove("show");
                });
            }
        }
        handleMobileSearch();

        function handleLightWaveImg() {
            let waveIcon = document.querySelector(
                ".social--links--wrap .wave--icon"
            );
            if (waveIcon) {
                let isLightMode =
                    document.documentElement.getAttribute("data-theme") ===
                    "light";
                let waveImg = document.querySelector(
                    ".social--links--wrap .wave--icon img"
                );
                let BlackWaveIconSrc = document
                    .querySelector(".social--links--wrap .wave--icon")
                    .getAttribute("data-light-img");
                let whiteWaveIconSrc = document
                    .querySelector(".social--links--wrap .wave--icon")
                    .getAttribute("data-dark-img");

                if (isLightMode) {
                    waveImg.setAttribute("src", BlackWaveIconSrc);
                } else {
                    waveImg.setAttribute("src", whiteWaveIconSrc);
                }
            }
        }
        handleLightWaveImg();

        // Optional: Detect changes to the `data-theme` attribute dynamically
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === "data-theme") {
                    handleLightWaveImg();
                }
            });
        });

        observer.observe(document.documentElement, { attributes: true });
    });

    // handle cart Dropdown
    function handleCartDropdown() {
        let trigger = document.querySelector(".cart-wrap .toggler ");
        let dropDownElem = document.getElementById("cartDropdown");

        if (trigger && dropDownElem) {
            trigger.addEventListener("click", function () {
                dropDownElem.classList.toggle("show");
                document.body.style.overflow = "auto";
            });

            document.addEventListener("click", function (e) {
                if (
                    dropDownElem &&
                    !dropDownElem.contains(e.target) &&
                    !trigger.contains(e.target)
                ) {
                    dropDownElem.classList.remove("show");
                }
            });
        }
    }
    handleCartDropdown();
})(jQuery);

function updatePlaceholder() {
    const searchInput = document.getElementById("header-search");
    if (window.innerWidth < 1200 && window.innerWidth >= 991) {
        searchInput.placeholder = "Search";
    } else {
        searchInput.placeholder = "Search Here";
    }
}
updatePlaceholder();
window.addEventListener("resize", updatePlaceholder);

document.getElementById("hamburger")?.addEventListener("click", function () {
    document.getElementById("responsive").style.right = "0";
    document.getElementById("responsive").style.display = "block";
    document.getElementById("hamburger").style.display = "none";
    document.getElementById("close--menu").style.display = "block";
});
document.getElementById("close--menu")?.addEventListener("click", function () {
    document.getElementById("responsive").style.right = "-100%";
    document.getElementById("close--menu").style.display = "none";
    document.getElementById("hamburger").style.display = "block";
});

let sidebarMenu = document.getElementById("sidebar-megamenu");
document.getElementById("genres")?.addEventListener("click", function () {
    if (sidebarMenu.style.display === "none") {
        sidebarMenu.style.display = "block";
        document.getElementById("responsive").style.height = "100vh";
    } else {
        sidebarMenu.style.display = "none";
    }
});
