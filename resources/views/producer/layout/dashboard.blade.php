@extends('producer.app')

@section('title', 'Home')

@push('style')
    <style>
        .tab {
            display: none;
        }

        .melodi--wrapper .active {
            display: block !important;
        }
    </style>
    @if (!Auth::user()->hasMembership())
        <style>
            .app--content {
                height: 100vh;
            }

            #collab--popup--wrapp {
                z-index: 800;
            }
            #collab--popup--wrapp #collab--popup {
                    width: width: 100vw !important;
                    height: auto;
                    max-height: calc(100vh - 50px);
                    /* height: calc(100vh - 308px) !important; */
                    top: 45%;
                    overflow-y: auto;
                }

           /*  #collab--popup--wrapp #collab--popup {
                width: 779px !important;
                height: calc(100vh - 308px) !important;
                top: 45%;
            } */
        </style>
    @endif

@endpush

@section('content')
    <!-- main content start  -->


    @if (Auth::user()->hasMembership())
        <section class="app--content">
            <div class="info--wrapper" >
                <div class="common--card--wrapper" >
                    <!-- info box  -->
                    <div class="info--box">
                        <div class="top--bar">
                            <p>Total Followers</p>
                        </div>
                        <h3 id="totalFollower">{{ Number::abbreviate(auth()->user()->followers()->count()) }}</h3>
                    </div>
                </div>
                <div class="common--card--wrapper" >
                    <!-- info box  -->
                    <div class="info--box">
                        <div class="top--bar">
                            <p>Total Plays</p>
                        </div>
                        <h3 id="totalPlays">{{ Number::format($data['playes']) }}</h3>
                    </div>
                </div>
                <div class="common--card--wrapper card--large" >
                    <!-- info box  -->
                    <div class="info--box">
                        <!-- top bar  -->
                        <div class="top--bar">
                            <p>Total Downloads</p>
                            {{-- <select>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="tomorrow">Tomorrow</option>
                        </select> --}}
                        </div>
                        <h3 id="totalDownloads">{{ Number::abbreviate($data['downloads']) }}+</h3>
                    </div>
                </div>
                <div class="common--card--wrapper card--large bottom--box" >
                    <!-- info box  -->
                    <div class="info--box ">
                        <!-- top bar  -->
                        <div class="top--bar">
                            <p>Sales Revenue</p>
                            <select name="revenue" id="revenueFiltering">
                                <option value="today">Today</option>
                                <option value="week">Last 7 Days</option>
                                <option value="month">This Month</option>
                                <option value="ytd">YTD</option>
                            </select>
                        </div>
                        <h3>$ <span id="revenueData" class="fs-2">{{ Number::format($data['revenue']) }}</span></h3>
                    </div>
                </div>
            </div>
            <div class="row class--row">
                <div class="col-lg-6 mt_45 "  data-aos-delay="200">
                    <!-- monthly--graph  -->
                    <div class="card--common mr-20 monthly--graph">
                        <!-- top bar  -->
                        <div class="top--bar">
                            <p>Download Graph</p>
                            <!-- filter option  -->
                            <div class="filter--graph">
                                <div class="item" data-index="0" onclick="loadDownloadGraphData(0)">Last 7 Days</div>
                                <div class="item" data-index="1" onclick="loadDownloadGraphData(1)">This Month</div>
                                <div class="item" data-index="2" onclick="loadDownloadGraphData(2)">YTD</div>
                                <div class="indicator"></div>
                            </div>
                        </div>
                        <div id="monthlyChart"></div>
                    </div>
                </div>
                <div class="col-lg-6 mt_45"  data-aos-delay="250">
                    <!-- activity--graph  -->
                    <div class="card--common upload--activity">
                        <!-- top bar  -->
                        <div class="top--bar">
                            <p>Sales Overview</p>
                            <!-- filter option  -->
                            <div class="filter--graph">
                                <div class="item" data-index="0" onclick="loadSalesGraphData(0)">Last 7 Days</div>
                                <div class="item" data-index="1" onclick="loadSalesGraphData(1)">This Month</div>
                                <div class="item" data-index="2" onclick="loadSalesGraphData(2)">YTD</div>
                                <div class="indicator"></div>
                            </div>
                        </div>
                        <div id="ActivityChart"></div>
                    </div>
                </div>
                <div class="col-xl-6 mt_45 top-melodies" >
                    <!-- latest melodi list  -->
                    <div class="card--common latest--melodi">
                        <!-- top bar  -->
                        <!-- top bar  -->
                        <div class="top--bar">
                            <p>Top Melodies</p>
                        </div>
                        <div class="melodi--wrapper">
                            <div class="tab tab-latest active">
                                <!-- melodi  -->
                                @forelse ($data['latestMelodies'] as $melody)
                                    <div class="melodi" data-audio-src="{{ url('/') }}{{ $melody->file }}"
                                        data-audio-id="{{ $melody->id }}" 
                                        data-aos-delay="50">
                                        <img class="melodi--img" src="{{ asset($melody->thumbnail) }}" alt="" />
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
                                        <div class="wave"></div>
                                        <div class="time-display">00:00</div>
                                    </div>
                                @empty
                                @endforelse
                            </div>

                        </div>
                        <a href="{{ route('producer.browse') }}" class="view--all mt_40">View All</a>
                    </div>
                </div>
                <div class="col-xl-6 mt_45 music--card-full-width">
                    <div class="card--common latest--packs" >
                        <!-- top bar  -->
                        <div class="top--bar">
                            <p>Latest Packs</p>
                        </div>
                        <div class="row music--img">
                            @forelse ($data['packs'] as $pack)
                                <div class="col-lg-4 col-md-6 mt_20 music--card" data-aos="zoom-in"
                                    data-aos-duration="1600" data-aos-delay="50">
                                    <!-- album--packs--card  -->
                                    <a href="{{ route('producer.pack.show', ['id' => Crypt::encrypt($pack->id)]) }}"
                                        class="album--packs--card">
                                        <!-- img area  -->
                                        <div class="img--area">
                                            <img src="{{ asset($pack->thumbnail) }}" alt="" />
                                        </div>
                                        <h4>{{ $pack->name }}</h4>
                                        <p class="artist">{{ $pack->user->producer_name }}</p>
                                    </a>
                                </div>
                            @empty
                            @endforelse
                        </div>
                        <a href="{{ route('producer.marketplace') }}" class="view--all">View All</a>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="app--content" style="position: relative">
            <div class="info--wrapper aos-init aos-animate" >
                <div class="common--card--wrapper aos-init aos-animate" >
                    <!-- info box  -->
                    <div class="info--box">
                        <div class="top--bar">
                            <p>Total Followers</p>
                        </div>
                        <h3>6,000</h3>
                    </div>
                </div>
                <div class="common--card--wrapper aos-init aos-animate" >
                    <!-- info box  -->
                    <div class="info--box">
                        <div class="top--bar">
                            <p>Total Plays</p>
                        </div>
                        <h3>69</h3>
                    </div>
                </div>
                <div class="common--card--wrapper card--large aos-init aos-animate" data-aos="zoom-in"
                    data-aos-duration="1600">
                    <!-- info box  -->
                    <div class="info--box">
                        <!-- top bar  -->
                        <div class="top--bar">
                            <p>Total Downloads</p>
                            <select style="display: none;">
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="tomorrow">Tomorrow</option>
                            </select>
                            <div class="nice-select" tabindex="0"><span class="current">Today</span>
                                <ul class="list">
                                    <li data-value="today" class="option selected">Today</li>
                                    <li data-value="yesterday" class="option">Yesterday</li>
                                    <li data-value="tomorrow" class="option">Tomorrow</li>
                                </ul>
                            </div>
                        </div>
                        <h3>200+</h3>
                    </div>
                </div>
                <div class="common--card--wrapper card--large bottom--box aos-init aos-animate" data-aos="zoom-in"
                    data-aos-duration="1600">
                    <!-- info box  -->
                    <div class="info--box ">
                        <!-- top bar  -->
                        <div class="top--bar">
                            <p>Sales Revenue</p>
                            <select style="display: none;">
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="tomorrow">Tomorrow</option>
                            </select>
                            <div class="nice-select" tabindex="0"><span class="current">Today</span>
                                <ul class="list">
                                    <li data-value="today" class="option selected">Today</li>
                                    <li data-value="yesterday" class="option">Yesterday</li>
                                    <li data-value="tomorrow" class="option">Tomorrow</li>
                                </ul>
                            </div>
                        </div>
                        <h3>$130.00</h3>
                    </div>
                </div>
            </div>
            <div class="row class--row">
                <div class="col-lg-6 mt_45 aos-init aos-animate" 
                    data-aos-delay="200">
                    <!-- monthly--graph  -->
                    <div class="card--common mr-20 monthly--graph">
                        <!-- top bar  -->
                        <div class="top--bar">
                            <p>Download Graph</p>
                            <!-- filter option  -->
                            <div class="filter--graph">
                                <div class="item active" data-index="0">24h</div>
                                <div class="item" data-index="1">Weekly</div>
                                <div class="item" data-index="2">Monthly</div>
                                <div class="indicator"></div>
                            </div>
                        </div>
                        <div id="monthlyChart" style="min-height: 365px;">
                            <div id="apexcharts9kr3majth" class="apexcharts-canvas apexcharts9kr3majth apexcharts-theme-"
                                style="width: 660px; height: 350px;"><svg id="SvgjsSvg1006" width="660"
                                    height="350" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
                                    class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                    style="background: none;">
                                    <foreignObject x="0" y="0" width="660" height="350">
                                        <div xmlns="http://www.w3.org/1999/xhtml"
                                            style="position: relative; height: 100%; width: 100%;">
                                            <div class="apexcharts-legend" style="max-height: 175px;"></div>
                                        </div>
                                    </foreignObject>
                                    <g id="SvgjsG1018" class="apexcharts-datalabels-group"
                                        transform="translate(0, 0) scale(1)"></g>
                                    <g id="SvgjsG1019" class="apexcharts-datalabels-group"
                                        transform="translate(0, 0) scale(1)"></g>
                                    <g id="SvgjsG1075" class="apexcharts-yaxis" rel="0"
                                        transform="translate(-8, 0)">
                                        <g id="SvgjsG1076" class="apexcharts-yaxis-texts-g"></g>
                                    </g>
                                    <g id="SvgjsG1008" class="apexcharts-inner apexcharts-graphical"
                                        transform="translate(10, 30)">
                                        <defs id="SvgjsDefs1007">
                                            <linearGradient id="SvgjsLinearGradient1010" x1="0" y1="0"
                                                x2="0" y2="1">
                                                <stop id="SvgjsStop1011" stop-opacity="0.4"
                                                    stop-color="rgba(216,227,240,0.4)" offset="0"></stop>
                                                <stop id="SvgjsStop1012" stop-opacity="0.5"
                                                    stop-color="rgba(190,209,230,0.5)" offset="1"></stop>
                                                <stop id="SvgjsStop1013" stop-opacity="0.5"
                                                    stop-color="rgba(190,209,230,0.5)" offset="1"></stop>
                                            </linearGradient>
                                            <clipPath id="gridRectMask9kr3majth">
                                                <rect id="SvgjsRect1015" width="639.9917097091675"
                                                    height="281.88571450614927" x="0" y="0" rx="0" ry="0"
                                                    opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
                                                    fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="gridRectBarMask9kr3majth">
                                                <rect id="SvgjsRect1016" width="643.9917097091675"
                                                    height="285.88571450614927" x="-2" y="-2" rx="0"
                                                    ry="0" opacity="1" stroke-width="0" stroke="none"
                                                    stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="gridRectMarkerMask9kr3majth">
                                                <rect id="SvgjsRect1017" width="639.9917097091675"
                                                    height="281.88571450614927" x="0" y="0" rx="0" ry="0"
                                                    opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0"
                                                    fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="forecastMask9kr3majth"></clipPath>
                                            <clipPath id="nonForecastMask9kr3majth"></clipPath>
                                        </defs>
                                        <rect id="SvgjsRect1014" width="41.14232419558934" height="281.88571450614927"
                                            x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0"
                                            stroke-dasharray="3" fill="url(#SvgjsLinearGradient1010)"
                                            class="apexcharts-xcrosshairs" y2="281.88571450614927" filter="none"
                                            fill-opacity="0.9"></rect>
                                        <g id="SvgjsG1039" class="apexcharts-grid">
                                            <g id="SvgjsG1040" class="apexcharts-gridlines-horizontal"
                                                style="display: none;">
                                                <line id="SvgjsLine1043" x1="0" y1="0"
                                                    x2="639.9917097091675" y2="0" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1044" x1="0" y1="70.47142862653732"
                                                    x2="639.9917097091675" y2="70.47142862653732" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1045" x1="0" y1="140.94285725307464"
                                                    x2="639.9917097091675" y2="140.94285725307464" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1046" x1="0" y1="211.41428587961195"
                                                    x2="639.9917097091675" y2="211.41428587961195" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1047" x1="0" y1="281.88571450614927"
                                                    x2="639.9917097091675" y2="281.88571450614927" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                            </g>
                                            <g id="SvgjsG1041" class="apexcharts-gridlines-vertical"
                                                style="display: none;"></g>
                                            <line id="SvgjsLine1049" x1="0" y1="281.88571450614927"
                                                x2="639.9917097091675" y2="281.88571450614927" stroke="transparent"
                                                stroke-dasharray="0" stroke-linecap="butt"></line>
                                            <line id="SvgjsLine1048" x1="0" y1="1" x2="0"
                                                y2="281.88571450614927" stroke="transparent" stroke-dasharray="0"
                                                stroke-linecap="butt"></line>
                                        </g>
                                        <g id="SvgjsG1042" class="apexcharts-grid-borders" style="display: none;"></g>
                                        <g id="SvgjsG1020" class="apexcharts-bar-series apexcharts-plot-series">
                                            <g id="SvgjsG1021" class="apexcharts-series" rel="1"
                                                seriesName="series-1" data:realIndex="0">
                                                <path id="SvgjsPath1026"
                                                    d="M25.142531452860148 281.88671450614925L25.142531452860148 115.70814293980598C25.142531452860148 110.70814293980598 30.142531452860148 105.70814293980598 35.14253145286015 105.70814293980598L56.28485564844948 105.70814293980598C61.28485564844948 105.70814293980598 66.28485564844948 110.70814293980598 66.28485564844948 115.70814293980598L66.28485564844948 281.88671450614925L25.142531452860148 281.88671450614925C25.142531452860148 281.88671450614925 25.142531452860148 281.88671450614925 25.142531452860148 281.88671450614925C25.142531452860148 281.88671450614925 25.142531452860148 281.88671450614925 25.142531452860148 281.88671450614925 "
                                                    fill="rgba(255,255,255,0.85)" fill-opacity="1" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area" index="0"
                                                    clip-path="url(#gridRectBarMask9kr3majth)"
                                                    pathTo="M 25.142531452860148 281.88671450614925 L 25.142531452860148 115.70814293980598 C 25.142531452860148 110.70814293980598 30.142531452860148 105.70814293980598 35.14253145286015 105.70814293980598 L 56.28485564844948 105.70814293980598 C 61.28485564844948 105.70814293980598 66.28485564844948 110.70814293980598 66.28485564844948 115.70814293980598 L 66.28485564844948 281.88671450614925 z "
                                                    pathFrom="M 25.142531452860148 281.88671450614925 L 25.142531452860148 281.88671450614925 L 66.28485564844948 281.88671450614925 L 66.28485564844948 281.88671450614925 L 66.28485564844948 281.88671450614925 L 66.28485564844948 281.88671450614925 L 66.28485564844948 281.88671450614925 L 25.142531452860148 281.88671450614925 z"
                                                    cy="105.70714293980598" cx="116.56991855416979" j="0" val="50"
                                                    barHeight="176.1785715663433" barWidth="41.14232419558934"></path>
                                                <path id="SvgjsPath1028"
                                                    d="M116.56991855416979 281.88671450614925L116.56991855416979 45.23671431326866C116.56991855416979 40.23671431326866 121.56991855416979 35.23671431326866 126.56991855416979 35.23671431326866L147.71224274975913 35.23671431326866C152.71224274975913 35.23671431326866 157.71224274975913 40.23671431326866 157.71224274975913 45.23671431326866L157.71224274975913 281.88671450614925L116.56991855416979 281.88671450614925C116.56991855416979 281.88671450614925 116.56991855416979 281.88671450614925 116.56991855416979 281.88671450614925C116.56991855416979 281.88671450614925 116.56991855416979 281.88671450614925 116.56991855416979 281.88671450614925 "
                                                    fill="rgba(255,255,255,0.85)" fill-opacity="1" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area" index="0"
                                                    clip-path="url(#gridRectBarMask9kr3majth)"
                                                    pathTo="M 116.56991855416979 281.88671450614925 L 116.56991855416979 45.236714313268656 C 116.56991855416979 40.236714313268656 121.56991855416979 35.236714313268656 126.56991855416979 35.236714313268656 L 147.71224274975913 35.236714313268656 C 152.71224274975913 35.236714313268656 157.71224274975913 40.236714313268656 157.71224274975913 45.236714313268656 L 157.71224274975913 281.88671450614925 z "
                                                    pathFrom="M 116.56991855416979 281.88671450614925 L 116.56991855416979 281.88671450614925 L 157.71224274975913 281.88671450614925 L 157.71224274975913 281.88671450614925 L 157.71224274975913 281.88671450614925 L 157.71224274975913 281.88671450614925 L 157.71224274975913 281.88671450614925 L 116.56991855416979 281.88671450614925 z"
                                                    cy="35.23571431326866" cx="207.9973056554794" j="1" val="70"
                                                    barHeight="246.6500001928806" barWidth="41.14232419558934"></path>
                                                <path id="SvgjsPath1030"
                                                    d="M207.9973056554794 281.88671450614925L207.9973056554794 80.47242862653732C207.9973056554794 75.47242862653732 212.9973056554794 70.47242862653732 217.9973056554794 70.47242862653732L239.13962985106875 70.47242862653732C244.13962985106875 70.47242862653732 249.13962985106875 75.47242862653732 249.13962985106875 80.47242862653732L249.13962985106875 281.88671450614925L207.9973056554794 281.88671450614925C207.9973056554794 281.88671450614925 207.9973056554794 281.88671450614925 207.9973056554794 281.88671450614925C207.9973056554794 281.88671450614925 207.9973056554794 281.88671450614925 207.9973056554794 281.88671450614925 "
                                                    fill="rgba(255,255,255,0.85)" fill-opacity="1" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area" index="0"
                                                    clip-path="url(#gridRectBarMask9kr3majth)"
                                                    pathTo="M 207.9973056554794 281.88671450614925 L 207.9973056554794 80.47242862653732 C 207.9973056554794 75.47242862653732 212.9973056554794 70.47242862653732 217.9973056554794 70.47242862653732 L 239.13962985106875 70.47242862653732 C 244.13962985106875 70.47242862653732 249.13962985106875 75.47242862653732 249.13962985106875 80.47242862653732 L 249.13962985106875 281.88671450614925 z "
                                                    pathFrom="M 207.9973056554794 281.88671450614925 L 207.9973056554794 281.88671450614925 L 249.13962985106875 281.88671450614925 L 249.13962985106875 281.88671450614925 L 249.13962985106875 281.88671450614925 L 249.13962985106875 281.88671450614925 L 249.13962985106875 281.88671450614925 L 207.9973056554794 281.88671450614925 z"
                                                    cy="70.47142862653732" cx="299.42469275678906" j="2" val="60"
                                                    barHeight="211.41428587961195" barWidth="41.14232419558934"></path>
                                                <path id="SvgjsPath1032"
                                                    d="M299.42469275678906 281.88671450614925L299.42469275678906 98.09028578317165C299.42469275678906 93.09028578317165 304.42469275678906 88.09028578317165 309.42469275678906 88.09028578317165L330.56701695237837 88.09028578317165C335.56701695237837 88.09028578317165 340.56701695237837 93.09028578317165 340.56701695237837 98.09028578317165L340.56701695237837 281.88671450614925L299.42469275678906 281.88671450614925C299.42469275678906 281.88671450614925 299.42469275678906 281.88671450614925 299.42469275678906 281.88671450614925C299.42469275678906 281.88671450614925 299.42469275678906 281.88671450614925 299.42469275678906 281.88671450614925 "
                                                    fill="rgba(255,255,255,0.85)" fill-opacity="1" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area" index="0"
                                                    clip-path="url(#gridRectBarMask9kr3majth)"
                                                    pathTo="M 299.42469275678906 281.88671450614925 L 299.42469275678906 98.09028578317165 C 299.42469275678906 93.09028578317165 304.42469275678906 88.09028578317165 309.42469275678906 88.09028578317165 L 330.56701695237837 88.09028578317165 C 335.56701695237837 88.09028578317165 340.56701695237837 93.09028578317165 340.56701695237837 98.09028578317165 L 340.56701695237837 281.88671450614925 z "
                                                    pathFrom="M 299.42469275678906 281.88671450614925 L 299.42469275678906 281.88671450614925 L 340.56701695237837 281.88671450614925 L 340.56701695237837 281.88671450614925 L 340.56701695237837 281.88671450614925 L 340.56701695237837 281.88671450614925 L 340.56701695237837 281.88671450614925 L 299.42469275678906 281.88671450614925 z"
                                                    cy="88.08928578317165" cx="390.8520798580987" j="3" val="55"
                                                    barHeight="193.79642872297762" barWidth="41.14232419558934"></path>
                                                <path id="SvgjsPath1034"
                                                    d="M390.8520798580987 281.88671450614925L390.8520798580987 10.000999999999976C390.8520798580987 5.000999999999976 395.8520798580987 0.0009999999999763531 400.8520798580987 0.0009999999999763531L421.9944040536881 0.0009999999999763531C426.9944040536881 0.0009999999999763531 431.9944040536881 5.000999999999976 431.9944040536881 10.000999999999976L431.9944040536881 281.88671450614925L390.8520798580987 281.88671450614925C390.8520798580987 281.88671450614925 390.8520798580987 281.88671450614925 390.8520798580987 281.88671450614925C390.8520798580987 281.88671450614925 390.8520798580987 281.88671450614925 390.8520798580987 281.88671450614925 "
                                                    fill="rgba(12,207,159,0.85)" fill-opacity="1" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area" index="0"
                                                    clip-path="url(#gridRectBarMask9kr3majth)"
                                                    pathTo="M 390.8520798580987 281.88671450614925 L 390.8520798580987 10.001 C 390.8520798580987 5.0009999999999994 395.8520798580987 0.001 400.8520798580987 0.001 L 421.9944040536881 0.001 C 426.9944040536881 0.001 431.9944040536881 5.001 431.9944040536881 10.001 L 431.9944040536881 281.88671450614925 z "
                                                    pathFrom="M 390.8520798580987 281.88671450614925 L 390.8520798580987 281.88671450614925 L 431.9944040536881 281.88671450614925 L 431.9944040536881 281.88671450614925 L 431.9944040536881 281.88671450614925 L 431.9944040536881 281.88671450614925 L 431.9944040536881 281.88671450614925 L 390.8520798580987 281.88671450614925 z"
                                                    cy="0" cx="482.27946695940835" j="4" val="80"
                                                    barHeight="281.88571450614927" barWidth="41.14232419558934"></path>
                                                <path id="SvgjsPath1036"
                                                    d="M482.27946695940835 281.88671450614925L482.27946695940835 80.47242862653732C482.27946695940835 75.47242862653732 487.27946695940835 70.47242862653732 492.27946695940835 70.47242862653732L513.4217911549977 70.47242862653732C518.4217911549977 70.47242862653732 523.4217911549977 75.47242862653732 523.4217911549977 80.47242862653732L523.4217911549977 281.88671450614925L482.27946695940835 281.88671450614925C482.27946695940835 281.88671450614925 482.27946695940835 281.88671450614925 482.27946695940835 281.88671450614925C482.27946695940835 281.88671450614925 482.27946695940835 281.88671450614925 482.27946695940835 281.88671450614925 "
                                                    fill="rgba(255,255,255,0.85)" fill-opacity="1" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area" index="0"
                                                    clip-path="url(#gridRectBarMask9kr3majth)"
                                                    pathTo="M 482.27946695940835 281.88671450614925 L 482.27946695940835 80.47242862653732 C 482.27946695940835 75.47242862653732 487.27946695940835 70.47242862653732 492.27946695940835 70.47242862653732 L 513.4217911549977 70.47242862653732 C 518.4217911549977 70.47242862653732 523.4217911549977 75.47242862653732 523.4217911549977 80.47242862653732 L 523.4217911549977 281.88671450614925 z "
                                                    pathFrom="M 482.27946695940835 281.88671450614925 L 482.27946695940835 281.88671450614925 L 523.4217911549977 281.88671450614925 L 523.4217911549977 281.88671450614925 L 523.4217911549977 281.88671450614925 L 523.4217911549977 281.88671450614925 L 523.4217911549977 281.88671450614925 L 482.27946695940835 281.88671450614925 z"
                                                    cy="70.47142862653732" cx="573.706854060718" j="5" val="60"
                                                    barHeight="211.41428587961195" barWidth="41.14232419558934"></path>
                                                <path id="SvgjsPath1038"
                                                    d="M573.706854060718 281.88671450614925L573.706854060718 115.70814293980598C573.706854060718 110.70814293980598 578.706854060718 105.70814293980598 583.706854060718 105.70814293980598L604.8491782563074 105.70814293980598C609.8491782563074 105.70814293980598 614.8491782563074 110.70814293980598 614.8491782563074 115.70814293980598L614.8491782563074 281.88671450614925L573.706854060718 281.88671450614925C573.706854060718 281.88671450614925 573.706854060718 281.88671450614925 573.706854060718 281.88671450614925C573.706854060718 281.88671450614925 573.706854060718 281.88671450614925 573.706854060718 281.88671450614925 "
                                                    fill="rgba(255,255,255,0.85)" fill-opacity="1" stroke-opacity="1"
                                                    stroke-linecap="round" stroke-width="0" stroke-dasharray="0"
                                                    class="apexcharts-bar-area" index="0"
                                                    clip-path="url(#gridRectBarMask9kr3majth)"
                                                    pathTo="M 573.706854060718 281.88671450614925 L 573.706854060718 115.70814293980598 C 573.706854060718 110.70814293980598 578.706854060718 105.70814293980598 583.706854060718 105.70814293980598 L 604.8491782563074 105.70814293980598 C 609.8491782563074 105.70814293980598 614.8491782563074 110.70814293980598 614.8491782563074 115.70814293980598 L 614.8491782563074 281.88671450614925 z "
                                                    pathFrom="M 573.706854060718 281.88671450614925 L 573.706854060718 281.88671450614925 L 614.8491782563074 281.88671450614925 L 614.8491782563074 281.88671450614925 L 614.8491782563074 281.88671450614925 L 614.8491782563074 281.88671450614925 L 614.8491782563074 281.88671450614925 L 573.706854060718 281.88671450614925 z"
                                                    cy="105.70714293980598" cx="665.1342411620276" j="6" val="50"
                                                    barHeight="176.1785715663433" barWidth="41.14232419558934"></path>
                                                <g id="SvgjsG1023" class="apexcharts-bar-goals-markers">
                                                    <g id="SvgjsG1025" className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMask9kr3majth)"></g>
                                                    <g id="SvgjsG1027" className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMask9kr3majth)"></g>
                                                    <g id="SvgjsG1029" className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMask9kr3majth)"></g>
                                                    <g id="SvgjsG1031" className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMask9kr3majth)"></g>
                                                    <g id="SvgjsG1033" className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMask9kr3majth)"></g>
                                                    <g id="SvgjsG1035" className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMask9kr3majth)"></g>
                                                    <g id="SvgjsG1037" className="apexcharts-bar-goals-groups"
                                                        class="apexcharts-hidden-element-shown"
                                                        clip-path="url(#gridRectMarkerMask9kr3majth)"></g>
                                                </g>
                                                <g id="SvgjsG1024"
                                                    class="apexcharts-bar-shadows apexcharts-hidden-element-shown"></g>
                                            </g>
                                            <g id="SvgjsG1022"
                                                class="apexcharts-datalabels apexcharts-hidden-element-shown"
                                                data:realIndex="0"></g>
                                        </g>
                                        <line id="SvgjsLine1050" x1="0" y1="0" x2="639.9917097091675"
                                            y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                            stroke-linecap="butt" class="apexcharts-ycrosshairs"></line>
                                        <line id="SvgjsLine1051" x1="0" y1="0" x2="639.9917097091675"
                                            y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt"
                                            class="apexcharts-ycrosshairs-hidden"></line>
                                        <g id="SvgjsG1052" class="apexcharts-xaxis" transform="translate(0, 0)">
                                            <g id="SvgjsG1053" class="apexcharts-xaxis-texts-g"
                                                transform="translate(0, -4)"><text id="SvgjsText1055"
                                                    font-family="Helvetica, Arial, sans-serif" x="45.71369355065482"
                                                    y="309.88571450614927" text-anchor="middle" dominant-baseline="auto"
                                                    font-size="12px" font-weight="400" fill="#3a383e"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1056">Sun</tspan>
                                                    <title>Sun</title>
                                                </text><text id="SvgjsText1058" font-family="Helvetica, Arial, sans-serif"
                                                    x="137.14108065196444" y="309.88571450614927" text-anchor="middle"
                                                    dominant-baseline="auto" font-size="12px" font-weight="400"
                                                    fill="#3a383e" class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1059">Mon</tspan>
                                                    <title>Mon</title>
                                                </text><text id="SvgjsText1061" font-family="Helvetica, Arial, sans-serif"
                                                    x="228.56846775327406" y="309.88571450614927" text-anchor="middle"
                                                    dominant-baseline="auto" font-size="12px" font-weight="400"
                                                    fill="#3a383e" class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1062">Tue</tspan>
                                                    <title>Tue</title>
                                                </text><text id="SvgjsText1064" font-family="Helvetica, Arial, sans-serif"
                                                    x="319.99585485458374" y="309.88571450614927" text-anchor="middle"
                                                    dominant-baseline="auto" font-size="12px" font-weight="400"
                                                    fill="#3a383e" class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1065">Wed</tspan>
                                                    <title>Wed</title>
                                                </text><text id="SvgjsText1067" font-family="Helvetica, Arial, sans-serif"
                                                    x="411.4232419558934" y="309.88571450614927" text-anchor="middle"
                                                    dominant-baseline="auto" font-size="12px" font-weight="400"
                                                    fill="#26a69a" class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1068">Thu</tspan>
                                                    <title>Thu</title>
                                                </text><text id="SvgjsText1070" font-family="Helvetica, Arial, sans-serif"
                                                    x="502.850629057203" y="309.88571450614927" text-anchor="middle"
                                                    dominant-baseline="auto" font-size="12px" font-weight="400"
                                                    fill="#3a383e" class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1071">Fri</tspan>
                                                    <title>Fri</title>
                                                </text><text id="SvgjsText1073" font-family="Helvetica, Arial, sans-serif"
                                                    x="594.2780161585125" y="309.88571450614927" text-anchor="middle"
                                                    dominant-baseline="auto" font-size="12px" font-weight="400"
                                                    fill="#3a383e" class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1074">Sat</tspan>
                                                    <title>Sat</title>
                                                </text></g>
                                        </g>
                                        <g id="SvgjsG1077"
                                            class="apexcharts-yaxis-annotations apexcharts-hidden-element-shown"></g>
                                        <g id="SvgjsG1078"
                                            class="apexcharts-xaxis-annotations apexcharts-hidden-element-shown"></g>
                                        <g id="SvgjsG1079"
                                            class="apexcharts-point-annotations apexcharts-hidden-element-shown"></g>
                                    </g>
                                </svg>
                                <div class="apexcharts-tooltip apexcharts-theme-dark">
                                    <div class="apexcharts-tooltip-title"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                    <div class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-0"
                                        style="order: 1;"><span class="apexcharts-tooltip-marker"
                                            style="background-color: rgb(255, 255, 255);"></span>
                                        <div class="apexcharts-tooltip-text"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label"></span><span
                                                    class="apexcharts-tooltip-text-y-value"></span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-dark">
                                    <div class="apexcharts-yaxistooltip-text"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt_45 aos-init aos-animate" 
                    data-aos-delay="250">
                    <!-- activity--graph  -->
                    <div class="card--common upload--activity">
                        <!-- top bar  -->
                        <div class="top--bar">
                            <p>Sales Overview</p>
                            <!-- filter option  -->
                            <div class="filter--graph">
                                <div class="item active" data-index="0">24h</div>
                                <div class="item" data-index="1">Weekly</div>
                                <div class="item" data-index="2">Monthly</div>
                                <div class="indicator"></div>
                            </div>
                        </div>
                        <div id="ActivityChart" style="min-height: 345px;">
                            <div id="apexchartso5hph9mug" class="apexcharts-canvas apexchartso5hph9mug apexcharts-theme-"
                                style="width: 660px; height: 330px;"><svg id="SvgjsSvg1080" width="660"
                                    height="330" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
                                    class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS"
                                    transform="translate(0, 0)">
                                    <foreignObject x="0" y="0" width="660" height="330">
                                        <div xmlns="http://www.w3.org/1999/xhtml"
                                            style="position: relative; height: 100%; width: 100%;">
                                            <div class="apexcharts-legend" style="max-height: 165px;"></div>
                                        </div>
                                    </foreignObject>
                                    <rect id="SvgjsRect1084" width="0" height="0" x="0" y="0" rx="0"
                                        ry="0" opacity="1" stroke-width="0" stroke="none"
                                        stroke-dasharray="0" fill="#fefefe"></rect>
                                    <g id="SvgjsG1089" class="apexcharts-datalabels-group"
                                        transform="translate(0, 0) scale(1)"></g>
                                    <g id="SvgjsG1090" class="apexcharts-datalabels-group"
                                        transform="translate(0, 0) scale(1)"></g>
                                    <g id="SvgjsG1145" class="apexcharts-yaxis" rel="0"
                                        transform="translate(-8, 0)">
                                        <g id="SvgjsG1146" class="apexcharts-yaxis-texts-g"></g>
                                    </g>
                                    <g id="SvgjsG1082" class="apexcharts-inner apexcharts-graphical"
                                        transform="translate(22, 30)">
                                        <defs id="SvgjsDefs1081">
                                            <clipPath id="gridRectMasko5hph9mug">
                                                <rect id="SvgjsRect1086" width="628" height="261.88571450614927" x="0"
                                                    y="0" rx="0" ry="0" opacity="1" stroke-width="0"
                                                    stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="gridRectBarMasko5hph9mug">
                                                <rect id="SvgjsRect1087" width="636" height="269.88571450614927"
                                                    x="-4" y="-4" rx="0" ry="0" opacity="1"
                                                    stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff">
                                                </rect>
                                            </clipPath>
                                            <clipPath id="gridRectMarkerMasko5hph9mug">
                                                <rect id="SvgjsRect1088" width="628" height="261.88571450614927" x="0"
                                                    y="0" rx="0" ry="0" opacity="1" stroke-width="0"
                                                    stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                            </clipPath>
                                            <clipPath id="forecastMasko5hph9mug"></clipPath>
                                            <clipPath id="nonForecastMasko5hph9mug"></clipPath>
                                            <linearGradient id="SvgjsLinearGradient1095" x1="0" y1="0"
                                                x2="0" y2="1">
                                                <stop id="SvgjsStop1096" stop-opacity="0.7"
                                                    stop-color="rgba(255,255,255,0.7)" offset="0"></stop>
                                                <stop id="SvgjsStop1097" stop-opacity="0" stop-color="rgba(12,207,159,0)"
                                                    offset="1"></stop>
                                                <stop id="SvgjsStop1098" stop-opacity="0" stop-color="rgba(12,207,159,0)"
                                                    offset="1"></stop>
                                            </linearGradient>
                                        </defs>
                                        <line id="SvgjsLine1085" x1="0" y1="0" x2="0"
                                            y2="261.88571450614927" stroke="#b6b6b6" stroke-dasharray="3"
                                            stroke-linecap="butt" class="apexcharts-xcrosshairs" x="0" y="0"
                                            width="1" height="261.88571450614927" fill="#b1b9c4" filter="none"
                                            fill-opacity="0.9" stroke-width="1"></line>
                                        <line id="SvgjsLine1105" x1="0" y1="261.88571450614927" x2="0"
                                            y2="267.88571450614927" stroke="#e0e0e0" stroke-dasharray="0"
                                            stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine1106" x1="104.66666666666667" y1="261.88571450614927"
                                            x2="104.66666666666667" y2="267.88571450614927" stroke="#e0e0e0"
                                            stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick">
                                        </line>
                                        <line id="SvgjsLine1107" x1="209.33333333333334" y1="261.88571450614927"
                                            x2="209.33333333333334" y2="267.88571450614927" stroke="#e0e0e0"
                                            stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick">
                                        </line>
                                        <line id="SvgjsLine1108" x1="314" y1="261.88571450614927" x2="314"
                                            y2="267.88571450614927" stroke="#e0e0e0" stroke-dasharray="0"
                                            stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <line id="SvgjsLine1109" x1="418.6666666666667" y1="261.88571450614927"
                                            x2="418.6666666666667" y2="267.88571450614927" stroke="#e0e0e0"
                                            stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick">
                                        </line>
                                        <line id="SvgjsLine1110" x1="523.3333333333334" y1="261.88571450614927"
                                            x2="523.3333333333334" y2="267.88571450614927" stroke="#e0e0e0"
                                            stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-xaxis-tick">
                                        </line>
                                        <line id="SvgjsLine1111" x1="628" y1="261.88571450614927" x2="628"
                                            y2="267.88571450614927" stroke="#e0e0e0" stroke-dasharray="0"
                                            stroke-linecap="butt" class="apexcharts-xaxis-tick"></line>
                                        <g id="SvgjsG1101" class="apexcharts-grid">
                                            <g id="SvgjsG1102" class="apexcharts-gridlines-horizontal"
                                                style="display: none;">
                                                <line id="SvgjsLine1112" x1="0" y1="0" x2="628"
                                                    y2="0" stroke="#e0e0e0" stroke-dasharray="0"
                                                    stroke-linecap="butt" class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1113" x1="0" y1="65.47142862653732"
                                                    x2="628" y2="65.47142862653732" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1114" x1="0" y1="130.94285725307464"
                                                    x2="628" y2="130.94285725307464" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1115" x1="0" y1="196.41428587961195"
                                                    x2="628" y2="196.41428587961195" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                                <line id="SvgjsLine1116" x1="0" y1="261.88571450614927"
                                                    x2="628" y2="261.88571450614927" stroke="#e0e0e0"
                                                    stroke-dasharray="0" stroke-linecap="butt"
                                                    class="apexcharts-gridline"></line>
                                            </g>
                                            <g id="SvgjsG1103" class="apexcharts-gridlines-vertical"
                                                style="display: none;"></g>
                                            <line id="SvgjsLine1118" x1="0" y1="261.88571450614927"
                                                x2="628" y2="261.88571450614927" stroke="transparent"
                                                stroke-dasharray="0" stroke-linecap="butt"></line>
                                            <line id="SvgjsLine1117" x1="0" y1="1" x2="0"
                                                y2="261.88571450614927" stroke="transparent" stroke-dasharray="0"
                                                stroke-linecap="butt"></line>
                                        </g>
                                        <g id="SvgjsG1104" class="apexcharts-grid-borders" style="display: none;"></g>
                                        <g id="SvgjsG1091" class="apexcharts-area-series apexcharts-plot-series">
                                            <g id="SvgjsG1092" class="apexcharts-series" zIndex="0"
                                                seriesName="series2" data:longestSeries="true" rel="1"
                                                data:realIndex="0">
                                                <path id="SvgjsPath1099"
                                                    d="M0 261.88571450614927C36.63333333333333 261.88571450614927 68.03333333333333 183.3200001543045 104.66666666666667 183.3200001543045C141.3 183.3200001543045 172.70000000000002 98.20714293980598 209.33333333333334 98.20714293980598C245.9666666666667 98.20714293980598 277.3666666666667 183.3200001543045 314 183.3200001543045C350.6333333333333 183.3200001543045 382.03333333333336 170.22571442899704 418.6666666666667 170.22571442899704C455.3 170.22571442899704 486.70000000000005 52.37714290122989 523.3333333333334 52.37714290122989C559.9666666666667 52.37714290122989 591.3666666666667 124.39571439042089 628 124.39571439042089C628 124.39571439042089 628 124.39571439042089 628 261.88571450614927L0 261.88571450614927C0 261.88571450614927 0 261.88571450614927 0 261.88571450614927 "
                                                    fill="url(#SvgjsLinearGradient1095)" fill-opacity="1"
                                                    stroke-opacity="1" stroke-linecap="butt" stroke-width="0"
                                                    stroke-dasharray="0" class="apexcharts-area" index="0"
                                                    clip-path="url(#gridRectMasko5hph9mug)"
                                                    pathTo="M 0 261.88571450614927C 36.63333333333333 261.88571450614927 68.03333333333333 183.3200001543045 104.66666666666667 183.3200001543045C 141.3 183.3200001543045 172.70000000000002 98.20714293980598 209.33333333333334 98.20714293980598C 245.96666666666667 98.20714293980598 277.3666666666667 183.3200001543045 314 183.3200001543045C 350.6333333333333 183.3200001543045 382.03333333333336 170.22571442899704 418.6666666666667 170.22571442899704C 455.3 170.22571442899704 486.70000000000005 52.37714290122989 523.3333333333334 52.37714290122989C 559.9666666666667 52.37714290122989 591.3666666666667 124.39571439042089 628 124.39571439042089C 628 124.39571439042089 628 124.39571439042089 628 261.88571450614927 L 0 261.88571450614927z"
                                                    pathFrom="M 0 392.8285717592239 L 0 392.8285717592239 L 104.66666666666667 392.8285717592239 L 209.33333333333334 392.8285717592239 L 314 392.8285717592239 L 418.6666666666667 392.8285717592239 L 523.3333333333334 392.8285717592239 L 628 392.8285717592239z">
                                                </path>
                                                <path id="SvgjsPath1100"
                                                    d="M0 261.88571450614927C36.63333333333333 261.88571450614927 68.03333333333333 183.3200001543045 104.66666666666667 183.3200001543045C141.3 183.3200001543045 172.70000000000002 98.20714293980598 209.33333333333334 98.20714293980598C245.9666666666667 98.20714293980598 277.3666666666667 183.3200001543045 314 183.3200001543045C350.6333333333333 183.3200001543045 382.03333333333336 170.22571442899704 418.6666666666667 170.22571442899704C455.3 170.22571442899704 486.70000000000005 52.37714290122989 523.3333333333334 52.37714290122989C559.9666666666667 52.37714290122989 591.3666666666667 124.39571439042089 628 124.39571439042089C628 124.39571439042089 628 124.39571439042089 628 124.39571439042089 "
                                                    fill="none" fill-opacity="1" stroke="#0ccf9f" stroke-opacity="1"
                                                    stroke-linecap="butt" stroke-width="4" stroke-dasharray="0"
                                                    class="apexcharts-area" index="0"
                                                    clip-path="url(#gridRectMasko5hph9mug)"
                                                    pathTo="M 0 261.88571450614927C 36.63333333333333 261.88571450614927 68.03333333333333 183.3200001543045 104.66666666666667 183.3200001543045C 141.3 183.3200001543045 172.70000000000002 98.20714293980598 209.33333333333334 98.20714293980598C 245.96666666666667 98.20714293980598 277.3666666666667 183.3200001543045 314 183.3200001543045C 350.6333333333333 183.3200001543045 382.03333333333336 170.22571442899704 418.6666666666667 170.22571442899704C 455.3 170.22571442899704 486.70000000000005 52.37714290122989 523.3333333333334 52.37714290122989C 559.9666666666667 52.37714290122989 591.3666666666667 124.39571439042089 628 124.39571439042089"
                                                    pathFrom="M 0 392.8285717592239 L 0 392.8285717592239 L 104.66666666666667 392.8285717592239 L 209.33333333333334 392.8285717592239 L 314 392.8285717592239 L 418.6666666666667 392.8285717592239 L 523.3333333333334 392.8285717592239 L 628 392.8285717592239"
                                                    fill-rule="evenodd"></path>
                                                <g id="SvgjsG1093"
                                                    class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown"
                                                    data:realIndex="0">
                                                    <g class="apexcharts-series-markers">
                                                        <path id="SvgjsPath1150" d="M 0, 0
                                       m -0, 0
                                       a 0,0 0 1,0 0,0
                                       a 0,0 0 1,0 -0,0" fill="#0ccf9f" fill-opacity="1" stroke="#ffffff"
                                                            stroke-opacity="0.9" stroke-linecap="butt" stroke-width="2"
                                                            stroke-dasharray="0" cx="0" cy="0"
                                                            shape="circle"
                                                            class="apexcharts-marker w8t1dcrxcf no-pointer-events"
                                                            default-marker-size="0"></path>
                                                    </g>
                                                </g>
                                            </g>
                                            <g id="SvgjsG1094" class="apexcharts-datalabels" data:realIndex="0"></g>
                                        </g>
                                        <line id="SvgjsLine1119" x1="0" y1="0" x2="628"
                                            y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1"
                                            stroke-linecap="butt" class="apexcharts-ycrosshairs"></line>
                                        <line id="SvgjsLine1120" x1="0" y1="0" x2="628"
                                            y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt"
                                            class="apexcharts-ycrosshairs-hidden"></line>
                                        <g id="SvgjsG1121" class="apexcharts-xaxis" transform="translate(0, 0)">
                                            <g id="SvgjsG1122" class="apexcharts-xaxis-texts-g"
                                                transform="translate(0, -4)"><text id="SvgjsText1124"
                                                    font-family="Helvetica, Arial, sans-serif" x="0" y="289.88571450614927"
                                                    text-anchor="middle" dominant-baseline="auto" font-size="12px"
                                                    font-weight="400" fill="#373d3f"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1125">Sun</tspan>
                                                    <title>Sun</title>
                                                </text><text id="SvgjsText1127"
                                                    font-family="Helvetica, Arial, sans-serif" x="104.66666666666666"
                                                    y="289.88571450614927" text-anchor="middle" dominant-baseline="auto"
                                                    font-size="12px" font-weight="400" fill="#373d3f"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1128">Mon</tspan>
                                                    <title>Mon</title>
                                                </text><text id="SvgjsText1130"
                                                    font-family="Helvetica, Arial, sans-serif" x="209.33333333333334"
                                                    y="289.88571450614927" text-anchor="middle" dominant-baseline="auto"
                                                    font-size="12px" font-weight="400" fill="#373d3f"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1131">Tue</tspan>
                                                    <title>Tue</title>
                                                </text><text id="SvgjsText1133"
                                                    font-family="Helvetica, Arial, sans-serif" x="314.00000000000006"
                                                    y="289.88571450614927" text-anchor="middle" dominant-baseline="auto"
                                                    font-size="12px" font-weight="400" fill="#373d3f"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1134">Wed</tspan>
                                                    <title>Wed</title>
                                                </text><text id="SvgjsText1136"
                                                    font-family="Helvetica, Arial, sans-serif" x="418.66666666666674"
                                                    y="289.88571450614927" text-anchor="middle" dominant-baseline="auto"
                                                    font-size="12px" font-weight="400" fill="#373d3f"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1137">Thu</tspan>
                                                    <title>Thu</title>
                                                </text><text id="SvgjsText1139"
                                                    font-family="Helvetica, Arial, sans-serif" x="523.3333333333334"
                                                    y="289.88571450614927" text-anchor="middle" dominant-baseline="auto"
                                                    font-size="12px" font-weight="400" fill="#373d3f"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1140">Fri</tspan>
                                                    <title>Fri</title>
                                                </text><text id="SvgjsText1142"
                                                    font-family="Helvetica, Arial, sans-serif" x="628"
                                                    y="289.88571450614927" text-anchor="middle" dominant-baseline="auto"
                                                    font-size="12px" font-weight="400" fill="#373d3f"
                                                    class="apexcharts-text apexcharts-xaxis-label "
                                                    style="font-family: Helvetica, Arial, sans-serif;">
                                                    <tspan id="SvgjsTspan1143">Sat</tspan>
                                                    <title>Sat</title>
                                                </text></g>
                                            <line id="SvgjsLine1144" x1="0" y1="261.88571450614927"
                                                x2="628" y2="261.88571450614927" stroke="#e0e0e0"
                                                stroke-dasharray="0" stroke-width="1" stroke-linecap="butt"></line>
                                        </g>
                                        <g id="SvgjsG1147"
                                            class="apexcharts-yaxis-annotations apexcharts-hidden-element-shown"></g>
                                        <g id="SvgjsG1148"
                                            class="apexcharts-xaxis-annotations apexcharts-hidden-element-shown"></g>
                                        <g id="SvgjsG1149"
                                            class="apexcharts-point-annotations apexcharts-hidden-element-shown"></g>
                                        <rect id="SvgjsRect1151" width="0" height="0" x="0" y="0"
                                            rx="0" ry="0" opacity="1" stroke-width="0"
                                            stroke="none" stroke-dasharray="0" fill="#fefefe"
                                            class="apexcharts-zoom-rect"></rect>
                                        <rect id="SvgjsRect1152" width="0" height="0" x="0" y="0"
                                            rx="0" ry="0" opacity="1" stroke-width="0"
                                            stroke="none" stroke-dasharray="0" fill="#fefefe"
                                            class="apexcharts-selection-rect"></rect>
                                    </g>
                                </svg>
                                <div class="apexcharts-tooltip apexcharts-theme-light">
                                    <div class="apexcharts-tooltip-title"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                    <div class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-0"
                                        style="order: 1;"><span class="apexcharts-tooltip-marker"
                                            style="background-color: rgb(12, 207, 159);"></span>
                                        <div class="apexcharts-tooltip-text"
                                            style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                            <div class="apexcharts-tooltip-y-group"><span
                                                    class="apexcharts-tooltip-text-y-label"></span><span
                                                    class="apexcharts-tooltip-text-y-value"></span></div>
                                            <div class="apexcharts-tooltip-goals-group"><span
                                                    class="apexcharts-tooltip-text-goals-label"></span><span
                                                    class="apexcharts-tooltip-text-goals-value"></span></div>
                                            <div class="apexcharts-tooltip-z-group"><span
                                                    class="apexcharts-tooltip-text-z-label"></span><span
                                                    class="apexcharts-tooltip-text-z-value"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom apexcharts-theme-light">
                                    <div class="apexcharts-xaxistooltip-text"
                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                                </div>
                                <div
                                    class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                    <div class="apexcharts-yaxistooltip-text"></div>
                                </div>
                                <div class="apexcharts-toolbar" style="top: 0px; right: 3px;">
                                    <div class="apexcharts-zoomin-icon" title="Zoom In"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <path d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="apexcharts-zoomout-icon" title="Zoom Out"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <path d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M7 11v2h10v-2H7zm5-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="apexcharts-zoom-icon apexcharts-selected" title="Selection Zoom"><svg
                                            xmlns="http://www.w3.org/2000/svg" fill="#000000" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <path
                                                d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                                            </path>
                                            <path d="M0 0h24v24H0V0z" fill="none"></path>
                                            <path d="M12 10h-2v2H9v-2H7V9h2V7h1v2h2v1z"></path>
                                        </svg></div>
                                    <div class="apexcharts-pan-icon" title="Panning"><svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <defs>
                                                <path d="M0 0h24v24H0z" id="a"></path>
                                            </defs>
                                            <clipPath id="b">
                                                <use overflow="visible" xlink:href="#a"></use>
                                            </clipPath>
                                            <path clip-path="url(#b)"
                                                d="M23 5.5V20c0 2.2-1.8 4-4 4h-7.3c-1.08 0-2.1-.43-2.85-1.19L1 14.83s1.26-1.23 1.3-1.25c.22-.19.49-.29.79-.29.22 0 .42.06.6.16.04.01 4.31 2.46 4.31 2.46V4c0-.83.67-1.5 1.5-1.5S11 3.17 11 4v7h1V1.5c0-.83.67-1.5 1.5-1.5S15 .67 15 1.5V11h1V2.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5V11h1V5.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5z">
                                            </path>
                                        </svg></div>
                                    <div class="apexcharts-reset-icon" title="Reset Zoom"><svg fill="#000000"
                                            height="24" viewBox="0 0 24 24" width="24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"></path>
                                            <path d="M0 0h24v24H0z" fill="none"></path>
                                        </svg></div>
                                    <div class="apexcharts-menu-icon" title="Menu"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <path fill="none" d="M0 0h24v24H0V0z"></path>
                                            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
                                        </svg></div>
                                    <div class="apexcharts-menu">
                                        <div class="apexcharts-menu-item exportSVG" title="Download SVG">Download SVG
                                        </div>
                                        <div class="apexcharts-menu-item exportPNG" title="Download PNG">Download PNG
                                        </div>
                                        <div class="apexcharts-menu-item exportCSV" title="Download CSV">Download CSV
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mt_45 top-melodies aos-init aos-animate" data-aos="zoom-in"
                    data-aos-duration="1600">
                    <!-- latest melodi list  -->
                    <div class="card--common latest--melodi">
                        <!-- top bar  -->
                        <!-- top bar  -->
                        <div class="top--bar">
                            <p>Top Melodies</p>
                            <!-- filter option  -->
                            <div class="filter--graph">
                                <div class="item active" data-index="0">Views</div>
                                <div class="item" data-index="1">Downloads</div>
                                <div class="item" data-index="2">Sales</div>
                                <div class="indicator"></div>
                            </div>
                        </div>
                        <div class="melodi--wrapper">
                            <!-- melodi  -->
                            <div class="melodi aos-init aos-animate" data-audio-src="assets/audio/ishq.mp3"
                                 data-aos-delay="50">
                                <img class="melodi--img" src="../assets/images/melodi1.png" alt="">
                                <div class="playPause--icon playPauseBtn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16"
                                        viewBox="0 0 12 16" fill="none" id="play-icon">
                                        <path
                                            d="M10.272 8.54011L1.40633 14.2546C0.907242 14.5763 0.25 14.218 0.25 13.6242V2.1952C0.25 1.60142 0.90724 1.24311 1.40633 1.56481L10.272 7.27933C10.7302 7.57468 10.7302 8.24476 10.272 8.54011Z"
                                            fill="#0CCF9F"></path>
                                    </svg>
                                    <svg width="18px" class="d-none" id="pause-icon" height="18px"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2 6C2 4.11438 2 3.17157 2.58579 2.58579C3.17157 2 4.11438 2 6 2C7.88562 2 8.82843 2 9.41421 2.58579C10 3.17157 10 4.11438 10 6V18C10 19.8856 10 20.8284 9.41421 21.4142C8.82843 22 7.88562 22 6 22C4.11438 22 3.17157 22 2.58579 21.4142C2 20.8284 2 19.8856 2 18V6Z"
                                            fill="#1C274C"></path>
                                        <path
                                            d="M14 6C14 4.11438 14 3.17157 14.5858 2.58579C15.1716 2 16.1144 2 18 2C19.8856 2 20.8284 2 21.4142 2.58579C22 3.17157 22 4.11438 22 6V18C22 19.8856 22 20.8284 21.4142 21.4142C20.8284 22 19.8856 22 18 22C16.1144 22 15.1716 22 14.5858 21.4142C14 20.8284 14 19.8856 14 18V6Z"
                                            fill="#1C274C"></path>
                                    </svg>
                                </div>
                                <div class="wave">
                                    <div></div>
                                </div>
                                <div class="time-display">3:48</div>
                            </div>
                            <!-- melodi  -->
                            <div class="melodi aos-init aos-animate" data-audio-src="assets/audio/2.mp3"
                                 data-aos-delay="50">
                                <img class="melodi--img" src="../assets/images/melodi2.png" alt="">
                                <div class="playPause--icon playPauseBtn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16"
                                        viewBox="0 0 12 16" fill="none" id="play-icon">
                                        <path
                                            d="M10.272 8.54011L1.40633 14.2546C0.907242 14.5763 0.25 14.218 0.25 13.6242V2.1952C0.25 1.60142 0.90724 1.24311 1.40633 1.56481L10.272 7.27933C10.7302 7.57468 10.7302 8.24476 10.272 8.54011Z"
                                            fill="#0CCF9F"></path>
                                    </svg>
                                    <svg width="18px" class="d-none" id="pause-icon" height="18px"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2 6C2 4.11438 2 3.17157 2.58579 2.58579C3.17157 2 4.11438 2 6 2C7.88562 2 8.82843 2 9.41421 2.58579C10 3.17157 10 4.11438 10 6V18C10 19.8856 10 20.8284 9.41421 21.4142C8.82843 22 7.88562 22 6 22C4.11438 22 3.17157 22 2.58579 21.4142C2 20.8284 2 19.8856 2 18V6Z"
                                            fill="#1C274C"></path>
                                        <path
                                            d="M14 6C14 4.11438 14 3.17157 14.5858 2.58579C15.1716 2 16.1144 2 18 2C19.8856 2 20.8284 2 21.4142 2.58579C22 3.17157 22 4.11438 22 6V18C22 19.8856 22 20.8284 21.4142 21.4142C20.8284 22 19.8856 22 18 22C16.1144 22 15.1716 22 14.5858 21.4142C14 20.8284 14 19.8856 14 18V6Z"
                                            fill="#1C274C"></path>
                                    </svg>
                                </div>
                                <div class="wave">
                                    <div></div>
                                </div>
                                <div class="time-display">1:58</div>
                            </div>
                            <div class="melodi aos-init aos-animate" data-audio-src="assets/audio/audio.mp3"
                                 data-aos-delay="50">
                                <img class="melodi--img" src="../assets/images/melodi1.png" alt="">
                                <div class="playPause--icon playPauseBtn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16"
                                        viewBox="0 0 12 16" fill="none" id="play-icon">
                                        <path
                                            d="M10.272 8.54011L1.40633 14.2546C0.907242 14.5763 0.25 14.218 0.25 13.6242V2.1952C0.25 1.60142 0.90724 1.24311 1.40633 1.56481L10.272 7.27933C10.7302 7.57468 10.7302 8.24476 10.272 8.54011Z"
                                            fill="#0CCF9F"></path>
                                    </svg>
                                    <svg width="18px" class="d-none" id="pause-icon" height="18px"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2 6C2 4.11438 2 3.17157 2.58579 2.58579C3.17157 2 4.11438 2 6 2C7.88562 2 8.82843 2 9.41421 2.58579C10 3.17157 10 4.11438 10 6V18C10 19.8856 10 20.8284 9.41421 21.4142C8.82843 22 7.88562 22 6 22C4.11438 22 3.17157 22 2.58579 21.4142C2 20.8284 2 19.8856 2 18V6Z"
                                            fill="#1C274C"></path>
                                        <path
                                            d="M14 6C14 4.11438 14 3.17157 14.5858 2.58579C15.1716 2 16.1144 2 18 2C19.8856 2 20.8284 2 21.4142 2.58579C22 3.17157 22 4.11438 22 6V18C22 19.8856 22 20.8284 21.4142 21.4142C20.8284 22 19.8856 22 18 22C16.1144 22 15.1716 22 14.5858 21.4142C14 20.8284 14 19.8856 14 18V6Z"
                                            fill="#1C274C"></path>
                                    </svg>
                                </div>
                                <div class="wave">
                                    <div></div>
                                </div>
                                <div class="time-display">0:05</div>
                            </div>
                            <!-- melodi  -->
                            <div class="melodi aos-init" data-audio-src="assets/audio/2.mp3" data-aos="zoom-in"
                                data-aos-duration="1600" data-aos-delay="50">
                                <img class="melodi--img" src="../assets/images/melodi2.png" alt="">
                                <div class="playPause--icon playPauseBtn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16"
                                        viewBox="0 0 12 16" fill="none" id="play-icon">
                                        <path
                                            d="M10.272 8.54011L1.40633 14.2546C0.907242 14.5763 0.25 14.218 0.25 13.6242V2.1952C0.25 1.60142 0.90724 1.24311 1.40633 1.56481L10.272 7.27933C10.7302 7.57468 10.7302 8.24476 10.272 8.54011Z"
                                            fill="#0CCF9F"></path>
                                    </svg>
                                    <svg width="18px" class="d-none" id="pause-icon" height="18px"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2 6C2 4.11438 2 3.17157 2.58579 2.58579C3.17157 2 4.11438 2 6 2C7.88562 2 8.82843 2 9.41421 2.58579C10 3.17157 10 4.11438 10 6V18C10 19.8856 10 20.8284 9.41421 21.4142C8.82843 22 7.88562 22 6 22C4.11438 22 3.17157 22 2.58579 21.4142C2 20.8284 2 19.8856 2 18V6Z"
                                            fill="#1C274C"></path>
                                        <path
                                            d="M14 6C14 4.11438 14 3.17157 14.5858 2.58579C15.1716 2 16.1144 2 18 2C19.8856 2 20.8284 2 21.4142 2.58579C22 3.17157 22 4.11438 22 6V18C22 19.8856 22 20.8284 21.4142 21.4142C20.8284 22 19.8856 22 18 22C16.1144 22 15.1716 22 14.5858 21.4142C14 20.8284 14 19.8856 14 18V6Z"
                                            fill="#1C274C"></path>
                                    </svg>
                                </div>
                                <div class="wave">
                                    <div></div>
                                </div>
                                <div class="time-display">1:58</div>
                            </div>
                        </div>
                        <a href="browse.html" class="view--all mt_40">View All</a>
                    </div>
                </div>
                <div class="col-xl-6 mt_45 music--card-full-width">
                    <div class="card--common latest--packs aos-init aos-animate" data-aos="zoom-in"
                        data-aos-duration="1600">
                        <!-- top bar  -->
                        <div class="top--bar">
                            <p>Latest Packs</p>
                        </div>
                        <div class="row music--img">
                            <div class="col-lg-4 col-md-6 mt_20 music--card aos-init aos-animate" data-aos="zoom-in"
                                data-aos-duration="1600" data-aos-delay="50">
                                <!-- album--packs--card  -->
                                <a href="marketplace.html" class="album--packs--card">
                                    <!-- img area  -->
                                    <div class="img--area">
                                        <img src="../assets/images/album-packs1.png" alt="">
                                    </div>
                                    <h4>ABYSS</h4>
                                    <p class="artist">FrancisGotHeat</p>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 mt_20 music--card aos-init aos-animate" data-aos="zoom-in"
                                data-aos-duration="1600" data-aos-delay="100">
                                <!-- album--packs--card  -->
                                <a href="marketplace.html" class="album--packs--card">
                                    <!-- img area  -->
                                    <div class="img--area">
                                        <img src="../assets/images/album-packs2.png" alt="">
                                    </div>
                                    <h4>ma bella'</h4>
                                    <p class="artist">trustmelucien</p>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 mt_20 music--card aos-init aos-animate" data-aos="zoom-in"
                                data-aos-duration="1600" data-aos-delay="150">
                                <!-- album--packs--card  -->
                                <a href="marketplace.html" class="album--packs--card">
                                    <!-- img area  -->
                                    <div class="img--area">
                                        <img src="../assets/images/album-packs3.png" alt="">
                                    </div>
                                    <h4>for once</h4>
                                    <p class="artist">shanks.</p>
                                </a>
                            </div>
                        </div>
                        <a href="marketplace.html" class="view--all">View All</a>
                    </div>
                </div>
            </div>

            <div class="collab-popup--wrapp nomembership-modal show" style="position: absolute"
                id="collab--popup--wrapp">
                <div id="collab--popup">
                    <h3 class="title text-uppercase">Become a pro to access to all analytics and...</h3>
                    <ul class="feature">
                        <li>
                            <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                            Upload Unlimited Melodies
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                            Sell Sample Packs
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                            Custom sample pack store
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                            Sell on producers marketplace
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                            Sell Digital Products
                        </li>
                        <li>
                            <img src="{{ asset('frontend/images/check-circle-1.svg') }}" alt="">
                            Pro Analytics Dashboard
                        </li>
                    </ul>

                    <div class="buttons mt-5">
                        <a href="{{ route('producer.membership', ['type' => Str::slug('Pro')]) }}" class="button disabled"
                        id="downloadPDFBtn">
                        Upgrade to Pro
                    </a>
                    </div>
                </div>
            </div>
        </section>


    @endif

    <!-- audio player  -->
    @component('components.player-component')
    @endcomponent


@endsection

@push('script')
    {{-- Retrive Revenue Data --}}
    <script>
        $(document).ready(function() {
            $('#revenueFiltering').on('change', function() {
                var value = $(this).val();

                $.ajax({
                    type: 'post',
                    url: '{{ route('producer.revenue.by.filter') }}',
                    data: {
                        data: value,
                        _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel
                    },
                    success: function(resp) {
                        if (resp) {
                            $('#revenueData').html(resp.data.revenue == null ? 0 : resp.data.revenue);
                            $('#totalFollower').html(resp.data.followers == null ? 0 : resp.data.followers);
                            $('#totalPlays').html(resp.data.playes == null ? 0 : resp.data.playes);
                            $('#totalDownloads').html(resp.data.downloads == null ? 0 : resp.data.downloads+"+");
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error: ' + xhr.statusText);
                    }
                });
            });

        });


        function ChangeMelodyTab(tab) {
            $(`.tab-${tab}`).addClass('active').siblings().removeClass('active');
        }
    </script>

    {{-- Graph Dynamic data --}}
    <script>
        function loadDownloadGraphData(filterIndex) {
            // Define the endpoints for each filter
            const endpoints = [
                '/producer/get-download-graph-data?filter=last7days', // For Last 7 Days
                '/producer/get-download-graph-data?filter=thismonth', // For This Month
                '/producer/get-download-graph-data?filter=ytd' // For YTD
            ];

            // jQuery AJAX request
            $.ajax({
                url: endpoints[filterIndex],
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    handleMonthlyChart(response); // Pass the data to the chart function
                },
                error: function(xhr, status, error) {
                    console.error('Error loading graph data:', error);
                }
            });
        }

        function handleMonthlyChart(data) {
            let container = document.querySelector("#monthlyChart");

            if (container) {
                // Clear any previous chart before rendering a new one
                $('#monthlyChart').html('');

                console.log(data.categories.length);

                var dataValues = data.values; // Data received from the server
                var maxValue = Math.max(...dataValues);
                var maxIndex = dataValues.indexOf(maxValue);

                var barColors = dataValues.map((value) =>
                    value === maxValue ? "#0ccf9f" : "#fff"
                );
                var labelColors = dataValues.map((value, index) =>
                    index === maxIndex ? "#26A69A" : "#3A383E"
                );

                var options = {
                    chart: {
                        type: "bar",
                        height: 350,
                        toolbar: {
                            show: false,
                        },
                        background: "none",
                    },
                    series: [{
                        data: dataValues, // Data from the response
                    }, ],
                    plotOptions: {
                        bar: {
                            distributed: true,
                            columnWidth: "45%", // Adjust column width for better fit
                            dataLabels: {
                                position: "top",
                            },
                            borderRadius: 10,
                            borderRadiusApplication: "end",
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    xaxis: {
                        categories: data.categories, // Categories from the response
                        tickAmount: data.categories.length, // Ensure tick amount matches the number of categories
                        labels: {
                            show: true,
                            style: {
                                colors: labelColors,
                            },
                        },
                        position: "bottom",
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false,
                        },
                        tooltip: {
                            enabled: false,
                        },
                    },
                    yaxis: {
                        labels: {
                            show: false,
                        },
                    },
                    grid: {
                        show: false,
                        padding: {
                            left: 0,
                            right: 0,
                        },
                    },
                    colors: barColors,
                    theme: {
                        monochrome: {
                            enabled: false,
                        },
                    },
                    legend: {
                        show: false,
                    },
                    tooltip: {
                        enabled: true,
                        theme: "dark",
                        background: {
                            color: "#0a0a0a",
                        },
                    },
                };

                var chart = new ApexCharts(container, options);
                chart.render();
            }
        }

        function loadSalesGraphData(filterIndex) {
            // Define the endpoints for each filter
            const endpoints = [
                '/producer/get-sales-graph-data?filter=last7days', // For Last 7 Days
                '/producer/get-sales-graph-data?filter=thismonth', // For This Month
                '/producer/get-sales-graph-data?filter=ytd' // For YTD
            ];

            // jQuery AJAX request
            $.ajax({
                url: endpoints[filterIndex],
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    hendeeLoadSalesGraphData(response); // Pass the data to the chart function
                },
                error: function(xhr, status, error) {
                    console.error('Error loading graph data:', error);
                }
            });
        }

        function hendeeLoadSalesGraphData(data) {
            let container = document.querySelector("#ActivityChart");

            if (container) { 
                // Clear existing chart if any
                $('#ActivityChart').html('');

                // Chart options
                var options = {
                    series: [{
                        name: "series2",
                        data: data.values, // Data received from the server
                    }, ],
                    chart: {
                        height: 330,
                        type: "area",
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    stroke: {
                        curve: "smooth",
                    },
                    xaxis: {
                        categories: data.categories, // Categories received from the server
                    },
                    tooltip: {
                        x: {
                            format: "dd/MM/yy HH:mm",
                        },
                    },
                    grid: {
                        show: false,
                    },
                    yaxis: {
                        labels: {
                            show: false,
                        },
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            shade: "light",
                            type: "vertical",
                            shadeIntensity: 1,
                            gradientToColors: ["rgba(255, 255, 255, 0.00)"],
                            inverseColors: true,
                            opacityFrom: 0.7,
                            opacityTo: 0.0,
                            stops: [0, 100],
                        },
                    },
                    colors: ["#0CCF9F"],
                };

                // Render chart
                var chart = new ApexCharts(container, options);
                chart.render();
            }
        }


        // Load the default (Last 7 Days) graph on page load
        $(document).ready(function() {
            loadDownloadGraphData(0);
            loadSalesGraphData(0);
        });
    </script>
@endpush
