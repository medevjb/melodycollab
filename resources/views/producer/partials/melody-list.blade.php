<!-- all melodies  -->
<div class="all--browse--melodies w-100" data-aos="zoom-in" data-aos-duration="1600" data-aos-delay="150"
    data-aos-offset="0">
    @forelse ($melodies as $melody)
        <!-- single--melodi -->
        <div class="single--melodi" id="melody-{{ $melody->id }}">
            <!-- melodi  -->
            <div class="melodi" data-audio-src="{{ asset($melody->file) }}" data-audio-id="{{ $melody->id }}">
                <img class="melodi--img" src="{{ asset($melody->thumbnail) }}" alt="" />
                <div class="playPause--icon playPauseBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16" viewBox="0 0 12 16"
                        fill="none" id="play-icon">
                        <path
                            d="M10.272 8.54011L1.40633 14.2546C0.907242 14.5763 0.25 14.218 0.25 13.6242V2.1952C0.25 1.60142 0.90724 1.24311 1.40633 1.56481L10.272 7.27933C10.7302 7.57468 10.7302 8.24476 10.272 8.54011Z"
                            fill="#0CCF9F" />
                    </svg>
                    <svg width="18px" class="d-none" id="pause-icon" height="18px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
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
                    <h4 class="text-capitalize">
                        {{ Str::limit(str_replace('-', ' ', $melody->name), 45) }}
                    </h4>
                    <p>
                        {{-- <a href="{{ route('producer.producers.profile', ['username' => $melody->user->username]) }}" style="color: var(--primary-color)">{{ Str::limit($melody->user->producer_name, 45) }}</a> --}}
                        @if (!empty($melody->user->username))
                            <a href="{{ route('producer.producers.profile', ['username' => $melody->user->username]) }}"
                                style="color: var(--primary-color)">
                                {{ Str::limit($melody->user->producer_name, 45) }}
                            </a>
                        @else
                            <span>{{ Str::limit($melody->user->producer_name, 45) }}</span>
                        @endif

                    </p>
                </div>
                <div class="wave"></div>
                <div class="time-display">00:00</div>
            </div>

            <!-- action-and--details  -->
            <div class="action-and--details">
                <div class="details d-flex align-items-start">
                    <p class="me-2">{{ $melody->bpm }} BPM </p>
                    <p class="me-2">-</p>
                    <p class="me-2">{{ $melody->key }} </p>
                    <p class="me-2">-</p>
                    @if ($melody->melodyArtistTypes->isNotEmpty())
                        <p class="me-2">{{ Str::limit(optional($melody->melodyArtistTypes->first())->title, 15) }}
                        </p>
                    @endif
                </div>
                <div class="action">
                    @if (Auth::user()->id != $melody->user_id)
                        <svg class="wishlist {{ in_array($melody->id, $fvrts) ? 'active' : '' }}"
                            onclick="addToFav(event,{{ $melody->id }}, this)" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="25" viewBox="0 0 24 25" fill="none">
                            <path
                                d="M12.62 21.31C12.28 21.43 11.72 21.43 11.38 21.31C8.48 20.32 2 16.19 2 9.18998C2 6.09998 4.49 3.59998 7.56 3.59998C9.38 3.59998 10.99 4.47998 12 5.83998C13.01 4.47998 14.63 3.59998 16.44 3.59998C19.51 3.59998 22 6.09998 22 9.18998C22 16.19 15.52 20.32 12.62 21.31Z"
                                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    @endif
                    <a onclick="ShowDownloadModal({{ $melody->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" class="download">
                            <g clip-path="url(#clip0_5241_2219)">
                                <path
                                    d="M18.6666 24H5.33332C3.90883 24 2.56952 23.4452 1.56212 22.4378C0.554771 21.4306 0 20.0912 0 18.6666V17.3332C0 16.5968 0.596923 15.9999 1.33334 15.9999C2.06976 15.9999 2.66668 16.5968 2.66668 17.3332V18.6666C2.66668 19.3789 2.94409 20.0486 3.44767 20.5522C3.9514 21.0559 4.62103 21.3333 5.33332 21.3333H18.6666C19.3789 21.3333 20.0485 21.0559 20.5522 20.5522C21.0559 20.0485 21.3333 19.3788 21.3333 18.6666V17.3332C21.3333 16.5968 21.9302 15.9999 22.6666 15.9999C23.403 15.9999 24 16.5968 24 17.3332V18.6666C24 20.0911 23.4452 21.4304 22.4378 22.4378C21.4304 23.4452 20.0911 24 18.6666 24ZM12 18.6666C11.8155 18.6666 11.6399 18.6291 11.4802 18.5615C11.3311 18.4985 11.1911 18.407 11.0685 18.2874C11.0685 18.2873 11.0685 18.2873 11.0684 18.2873C11.0676 18.2864 11.0667 18.2855 11.0658 18.2847C11.0656 18.2845 11.0653 18.2842 11.065 18.2839C11.0643 18.2833 11.0637 18.2826 11.063 18.2819C11.0625 18.2814 11.0621 18.281 11.0616 18.2805C11.0611 18.2801 11.0605 18.2794 11.0601 18.2791C11.0592 18.2781 11.0582 18.2771 11.0572 18.2762L5.72386 12.9428C5.20318 12.4221 5.20318 11.5779 5.72386 11.0571C6.24454 10.5365 7.08883 10.5364 7.6095 11.0571L10.6667 14.1143V1.33334C10.6666 0.596923 11.2636 0 12 0C12.7364 0 13.3334 0.596923 13.3334 1.33334V14.1143L16.3905 11.0571C16.9111 10.5365 17.7555 10.5365 18.2761 11.0571C18.7968 11.5778 18.7968 12.4221 18.2761 12.9428L12.9428 18.2761C12.9418 18.277 12.9408 18.278 12.9399 18.279C12.9394 18.2794 12.9388 18.2801 12.9384 18.2804C12.9379 18.2809 12.9375 18.2813 12.937 18.2818C12.9364 18.2825 12.9356 18.2832 12.935 18.2838C12.9348 18.2841 12.9344 18.2844 12.9342 18.2846C12.9334 18.2855 12.9325 18.2863 12.9316 18.2872C12.9316 18.2872 12.9316 18.2872 12.9315 18.2873C12.9168 18.3016 12.902 18.3154 12.8868 18.329C12.7751 18.4285 12.6508 18.5062 12.5193 18.5616C12.5188 18.5618 12.5185 18.562 12.518 18.5622C12.5175 18.5624 12.5171 18.5626 12.5166 18.5628C12.3576 18.6297 12.1832 18.6666 12 18.6666Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_5241_2219">
                                    <rect width="24" height="24" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </a>
                    <!-- dots--action -->
                    @if (Auth::user()->id == $melody->user_id)
                        <div class="dots dots--action btn position-relative">
                            <svg class="" xmlns="http://www.w3.org/2000/svg" width="3" height="17"
                                viewBox="0 0 3 17" fill="none">
                                <circle cx="1.5" cy="1.5" r="1.5" fill="white" />
                                <circle cx="1.5" cy="8.5" r="1.5" fill="white" />
                                <circle cx="1.5" cy="15.5" r="1.5" fill="white" />
                            </svg>
                            <ul class="action--dropdown">
                                <li>
                                    <a href="{{ route('producer.melody.edit', ['id' => Crypt::encrypt($melody->id)]) }}"
                                        class="text-light">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13"
                                                stroke="#292D32" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M16.04 3.02001L8.16 10.9C7.86 11.2 7.56 11.79 7.5 12.22L7.07 15.23C6.91 16.32 7.68 17.08 8.77 16.93L11.78 16.5C12.2 16.44 12.79 16.14 13.1 15.84L20.98 7.96001C22.34 6.60001 22.98 5.02001 20.98 3.02001C18.98 1.02001 17.4 1.66001 16.04 3.02001Z"
                                                stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M14.91 4.1499C15.58 6.5399 17.45 8.4099 19.85 9.0899"
                                                stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Edit
                                    </a>
                                </li>
                                <li onclick="ShowDeleteAlert('{{ $melody->id }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path d="M8.80994 2L5.18994 5.63" stroke="#2C2F33" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M15.1899 2L18.8099 5.63" stroke="#2C2F33" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M2 7.84998C2 5.99998 2.99 5.84998 4.22 5.84998H19.78C21.01 5.84998 22 5.99998 22 7.84998C22 9.99998 21.01 9.84998 19.78 9.84998H4.22C2.99 9.84998 2 9.99998 2 7.84998Z"
                                            stroke="#2C2F33" stroke-width="1.5" />
                                        <path d="M9.76001 14V17.55" stroke="#2C2F33" stroke-width="1.5"
                                            stroke-linecap="round" />
                                        <path d="M14.36 14V17.55" stroke="#2C2F33" stroke-width="1.5"
                                            stroke-linecap="round" />
                                        <path
                                            d="M3.5 10L4.91 18.64C5.23 20.58 6 22 8.86 22H14.89C18 22 18.46 20.64 18.82 18.76L20.5 10"
                                            stroke="#2C2F33" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                    Delete
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <h4 class=" mt-5 text-center" style="font-size: 18px">No Melodies</h4>
    @endforelse



</div>


<script>
    function ShowDownloadModal(id) {

        let Durl = "{{ route('producer.melody.download', ':id') }}";
        Durl = Durl.replace(':id', id);
        $('#downloadBtn').attr('href', Durl);

        // Fetch Pdf Data
        $.ajax({
            type: "GET",
            url: Durl,
            success: function(data) {
                console.log(data.data.user);
                $('.melody-name').text(data.data.name);
                $('#collab--percentage').text(data.data.split);
                $('#collab--producer--name').text(data.data.user.producer_name);
                $('#collab--beatstars--name').text(data.data.user.beatstars_username);
                $('#collab--soundee--name').text(data.data.user.soundee_username);
                $('#collab--instagram--name').text(data.data.user.instagram_username);
                $('#collab--youtube--name').text(data.data.user.youtube_username);
                if (data.data.pdf != null) {
                    $('#downloadPDFBtn').attr('href', "{{ url('/') }}/storage/" + data.data.pdf);
                } else {
                    $('#downloadPDFBtn').attr('href', "javascript:void(0)");
                }
            }
        })

        let modal = document.getElementById("collab--popup--wrapp");
        modal.classList.add("show");

    }
</script>
