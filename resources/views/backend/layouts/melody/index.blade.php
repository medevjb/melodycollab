@extends('backend.app')

@push('style')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 12px;
            width: 12px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #0d6efd;
        }

        input:checked+.slider:before {
            transform: translateX(14px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endpush

@section('title', 'Melodies')
@section('content')

    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Melody</h2>
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
                            <li class="active"><span><i class="lni lni-angle-double-right"></i></span>Melody</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Start --}}
    <div class="tables-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="table-wrapper table-responsive">
                        <table id="data-table" class="table">
                            <thead>
                                <tr>
                                    <th>S/L</th>
                                    <th>Name</th>
                                    <th>Melody</th>
                                    <th>Thumbnail</th>
                                    <th>File</th>
                                    <th>BPM</th>
                                    <th>Key</th>
                                    <th>Split</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Dynamic Data --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Main Content end --}}

    @push('script')
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    }
                });

                if (!$.fn.DataTable.isDataTable('#data-table')) {
                    let dTable = $('#data-table').DataTable({
                        order: [],
                        lengthMenu: [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "All"]
                        ],
                        processing: true,
                        responsive: true,
                        serverSide: true,
                        language: {
                            processing: `<div class="text-center">
                                    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>`
                        },
                        scroller: {
                            loadingIndicator: false
                        },
                        pagingType: "full_numbers",
                        dom: "<'row justify-content-between table-topbar'<'col-md-2 col-sm-4 px-0'l><'col-md-2 col-sm-4 px-0'f>>tipr",
                        ajax: {
                            url: "{{ route('melody.index') }}",
                            type: "GET",
                            error: function(xhr, status, error) {
                                console.error("AJAX error: ", error);
                                flasher.error('An error occurred while loading data.');
                            }
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'producer_name',
                                name: 'producer_name',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'melody',
                                name: 'melody',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'thumbnail',
                                name: 'thumbnail',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'file',
                                name: 'file',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'bpm',
                                name: 'bpm',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'key',
                                name: 'key',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'split',
                                name: 'split',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'type',
                                name: 'type',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'status',
                                name: 'status',
                                orderable: true,
                                searchable: true
                            }
                        ]
                    });
                }
            });
        </script>

        <script>
            // Status Change Confirm Alert
            function showStatusChangeAlert(id) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to update the status?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        statusChange(id);
                    }
                });
            }

            // Status Change
            function statusChange(id) {
                let url = '{{ route('melody.toggleStatus') }}';

                $.ajax({
                    type: "POST", // Change to POST
                    url: url,
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token
                        id: id // Pass the id as data
                    },
                    success: function(resp) {
                        console.log(resp);
                        // Reload DataTable
                        $('#data-table').DataTable().ajax.reload();
                        if (resp.success) {
                            // Show toast message
                            toastr.success(resp.message);
                        } else if (resp.errors) {
                            toastr.error(resp.errors[0]);
                        } else {
                            toastr.error(resp.message);
                        }
                    },
                    error: function(error) {
                        console.error("Error:", error);
                        toastr.error("An error occurred while updating the status!");
                    }
                });
            }
        </script>

        {{-- file download --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            function downloadFile(fileUrl) {
                $.ajax({
                    url: fileUrl,
                    type: 'HEAD',
                    success: function() {
                        // File exists, so initiate download
                        window.location.href = fileUrl;
                    },
                    error: function() {
                        // File doesn't exist, show Toastr message
                        toastr.error('File not exist');
                    }
                });
            }

            function fileNotExist() {
                toastr.error('File not exist');
            }
        </script>
    @endpush
@endsection
