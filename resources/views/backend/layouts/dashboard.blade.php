@extends('backend.app')

@section('title', 'Dashboard')

@push('style')
    <style>
        .scrollable-list {
            max-height: 300px;
            /* Set your desired max height */
            overflow-y: auto;
            /* Enable vertical scrolling */
            white-space: nowrap;
            /* Prevent line breaks */
        }
    </style>
@endpush

@section('content')
    {{--  ========== title-wrapper start ==========  --}}
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Dashboard</h2>
                </div>
            </div>

            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav>
                        <ol class="base-breadcrumb breadcrumb-three">
                            <li>
                                <a href="{{ route('dashboard') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8 0a8 8 0 1 0 4.596 14.104A5.934 5.934 0 0 1 8 13a5.934 5.934 0 0 1-4.596-2.104A7.98 7.98 0 0 0 8 0zm-2 3a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm-1.465 5.682A3.976 3.976 0 0 0 4 9c0 1.044.324 2.01.882 2.818a6 6 0 1 1 6.236 0A3.975 3.975 0 0 0 12 9a3.976 3.976 0 0 0-.536-1.318l-1.898.633-.018-.056 2.194-.732a4 4 0 1 0-7.6 0l2.194.733-.018.056-1.898-.634z" />
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <li class="active"><span><i class="lni lni-angle-double-right"></i></span>Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    {{--  ========== title-wrapper end ==========  --}}



    <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
            <div class="icon-card d-flex flex-column justify-content-between h-100">
                <div class="icon primary">
                    <i class="lni lni-wallet"></i>
                </div>
                <div class="content text-center mt-3">
                    <h6 class="mb-10">Commission (%)</h6>
                    <h3 class="text-bold mb-10">
                        <form action="{{ route('commition.store') }}" method="POST" id="commission-form" class="d-flex align-items-center">
                            @csrf
                            <input type="number" name="commission" id="commission" class="form-control text-center fs-2"
                                style="border: 0px !important; " value="{{ $setting != null ? $setting->commission : 0 }}">
                            <button class="btn btn-sm bg-primary p-1 m-1 d-flex align-items-center justify-content-center" style="height: 40px; width: 40px" type="submit"><svg width="40" height="40"
                                    viewBox="0 0 24 24" fill="#ffffff" xmlns="http://www.w3.org/2000/svg"
                                    transform="rotate(0 0 0)">
                                    <path
                                        d="M19.2803 6.76264C19.5732 7.05553 19.5732 7.53041 19.2803 7.8233L9.86348 17.2402C9.57058 17.533 9.09571 17.533 8.80282 17.2402L4.71967 13.157C4.42678 12.8641 4.42678 12.3892 4.71967 12.0963C5.01256 11.8035 5.48744 11.8035 5.78033 12.0963L9.33315 15.6492L18.2197 6.76264C18.5126 6.46975 18.9874 6.46975 19.2803 6.76264Z"
                                        fill="#ffffff" />
                                </svg>
                            </button>
                        </form>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
            <div class="icon-card d-flex flex-column justify-content-between h-100">
                <div class="icon purple mb-2">
                    <i class="lni lni-cart-full"></i>
                </div>
                <div class="content text-center">
                    <h6 class="mb-10">New Orders</h6>
                    <div class="d-flex align-items-center">
                        <i class="lni lni-calendar mr-2 text-primary"></i>
                        <h6 class="text-primary">{{ now()->format(' F') }}</h6>
                    </div>
                    <h3 class="text-bold mb-10">{{ $currentMonthOrdersCount ?? 0 }}</h3>
                </div>
            </div>
        </div>

        @php
            use Carbon\Carbon;
            $currentMonth = Carbon::now()->format('F Y'); // Get current month in format 'Month Year'
        @endphp

        <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">

            <div class="card-style d-flex flex-column justify-content-between h-100">
                <div class="icon primary text-center mb-3">
                    <i class="lni lni-user text-success" style="font-size: 2rem;"></i>
                </div>
                <h6 class="card-title text-black text-center mb-10 mt-2">
                    New Users This Month
                </h6>

                <ul class="flex-fill text-center">
                    @forelse($chartData['usernames'] as $month => $usernames)
                        @if (Carbon::parse($month)->format('F Y') === $currentMonth)
                            <li class="list-group-item align-items-center">
                                <strong class="text-primary">
                                    <i class="lni lni-calendar mr-2"></i> {{ $month }}
                                </strong> <br>
                                <span style="font-size: 1.5rem;color:black;">
                                    {{ count($usernames) }}
                                </span>
                            </li>
                        @endif
                    @empty
                        <li class="list-group-item text-center">No data found</li>
                    @endforelse
                </ul>

            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
            <div class="icon-card d-flex flex-column justify-content-between h-100">
                <div class="icon success">
                    <i class="lni lni-dollar"></i>
                </div>
                <div class="content text-center">
                    <h6 class="mb-10">Total Melody Revenue</h6>
                    <h3 class="text-bold mb-10">${{ $TotalPrice ?? 0 }}</h3>
                    <p class="text-sm text-success">
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
            <div class="icon-card d-flex flex-column justify-content-between h-100">
                <div class="icon success">
                    <i class="lni lni-dollar"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Total Membership Revenue</h6>
                    <h3 class="text-bold mb-10 text-center">${{ $TotalMembershipAmount ?? 0 }}</h3>
                    <p class="text-sm text-success">
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
            <div class="icon-card d-flex flex-column justify-content-between h-100">
                <div class="icon success mb-3">
                    <i class="lni lni-close"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Membership Cancellation Rate</h6>
                    <h3 class="text-bold mb-10 text-center">{{ $MembershipCancellationRate ?? 'N/A' }}%</h3>
                    <p class="text-sm text-success">
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
            <div class="icon-card d-flex flex-column justify-content-between h-100">
                <div class="icon success">
                    <i class="lni lni-music"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10 text-center">Total Melodies</h6>
                    <h3 class="text-bold mb-10 text-center">{{ $TotalMelody ?? 0 }}</h3>
                    <p class="text-sm text-success">
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
            <div class="icon-card d-flex flex-column justify-content-between h-100">
                <div class="icon success">
                    <i class="lni lni-package"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10 text-center">Total Packs</h6>
                    <h3 class="text-bold mb-10 text-center">{{ $totalPack ?? 0 }}</h3>
                    <p class="text-sm text-danger">
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
            <div class="icon-card d-flex flex-column justify-content-between h-100">
                <div class="icon primary">
                    <i class="lni lni-credit-cards"></i>
                </div>
                <div class="content text-center">
                    <h6 class="mb-10">Top Sold Pack</h6>
                    <h3 class="text-bold mb-10">{{ $TopSoldPack ? $TopSoldPack->total_orders : 0 }}</h3>                   
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
            <div class="icon-card d-flex flex-column justify-content-between h-100">
                <div class="icon primary">
                    <i class="lni lni-download"></i>
                </div>
                <div class="content text-center mt-3">
                    <h6 class="mb-10">Top downloaded melodies</h6>
                    <h3 class="text-bold mb-10">{{ $TopDownloadMelody ? $TopDownloadMelody->downloads : 0 }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
            <div class="icon-card d-flex flex-column justify-content-between h-100">
                <div class="icon primary">
                    <i class="lni lni-cloud-download"></i>
                </div>
                <div class="content text-center mt-3">
                    <h6 class="mb-10">All downloaded melodies</h6>
                    <h3 class="text-bold mb-10">{{ $TotalDownloadMelody ? $TotalDownloadMelody : 0 }}</h3>
                </div>
            </div>
        </div>
    </div>


    <!-- Display the usernames of users who registered this month -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card-style mb-30">
                <p class="text-success text-bold">Users Data for Each Month</p>
                <div class="chart-container">
                    <canvas id="new-users-chart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-style mb-10">
                <p class="text-success text-bold">Order Data for Each Month</p>
                <div class="chart-container">
                    <canvas id="order-chart"></canvas>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- chart for new users start --}}
    <script>
        // Data passed from the controller
        const labels = @json($chartData['labels']); // Will always have 12 months
        const data = @json($chartData['data']); // Will have counts, with 0 for months without users

        const ctx = document.getElementById('new-users-chart').getContext('2d');
        const newUserChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'This year\'s Users',
                    data: data,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                        'rgba(0, 123, 255, 0.5)',
                        'rgba(220, 53, 69, 0.5)',
                        'rgba(40, 167, 69, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(23, 162, 184, 0.5)',
                        'rgba(255, 193, 7, 0.5)',
                        'rgba(188, 80, 144, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132,0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                        'rgba(0, 123, 255, 0.5)',
                        'rgba(220, 53, 69, 0.5)',
                        'rgba(40, 167, 69, 0.5)',
                        'rgba(23, 162, 184, 0.5)',
                        'rgba(255, 193, 7, 0.5)',
                        'rgba(188, 80, 144, 0.5)'
                    ],
                    borderWidth: 1,
                    barThickness: 50
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    {{-- chart for new users end --}}

    {{-- order chart start --}}
    <script>
        var orderctx = document.getElementById('order-chart').getContext('2d');
        var orderChart = new Chart(orderctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($orderChartData['labels']) !!},
                datasets: [{
                    label: 'This year\'s Orders',
                    data: {!! json_encode($orderChartData['data']) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true, // Fill the area under the line
                    tension: 0.3 // Smooth curves
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    {{-- order chart end --}}
@endpush
