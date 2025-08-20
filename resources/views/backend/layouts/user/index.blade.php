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

@section('title', 'User list')
@section('content')

    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>User list</h2>
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
                        {{-- <button id="filter-google-users" class="btn btn-outline-primary mb-3" style="width: 170px;">Google Users</button> --}}
                        <div class="d-flex justify-content-end">
                            <div class="mb-3">
                                <select class="form-select shadow-sm" id="filter-select"
                                    style="width: 170px; border-radius: 0.5rem; padding: 0.5rem 1rem; font-size: 0.875rem;">
                                    <option value="">Select Filter</option>
                                    <option value="google_users">Google Users</option>
                                    <option value="paid_users">Paid Users</option>
                                    <option value="free_users">Free Users</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <table id="data-tables" class="table">
                        <thead>
                            <tr>
                                <th>S/L</th>
                                <th>Producer Name</th>
                                <th>Country</th>
                                <th>Join Date</th>
                                <th>Email</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Total Sales</th>
                                <th>Action</th>
                                {{-- <th>Type</th> --}}
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
        {{--   <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    }
                });

                // Handle Google Users filter button click
                $('#filter-google-users').on('click', function() {
                    // Send AJAX request to filter users with google_id
                    $('#data-tables').DataTable().ajax.url("{{ route('user.index') }}?google_user=true").load();
                });

                if (!$.fn.DataTable.isDataTable('#data-tables')) {
                    let dTable = $('#data-tables').DataTable({
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
                            url: "{{ route('user.index') }}",
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
                                data: 'country',
                                name: 'country',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'join',
                                name: 'join',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'email',
                                name: 'email',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'image',
                                name: 'image',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'status',
                                name: 'status',
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: 'TotalSales',
                                name: 'TotalSales',
                                orderable: true,
                                searchable: true
                            },
                        ]
                    });
                }
            });
        </script> --}}

        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    }
                });

                let dTable = $('#data-tables').DataTable({
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
                    ajax: {
                        url: "{{ route('user.index') }}",
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
                            data: 'country',
                            name: 'country',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'join',
                            name: 'join',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'email',
                            name: 'email',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'image',
                            name: 'image',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'TotalSales',
                            name: 'TotalSales',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                // Handle filter selection
                $('#filter-select').on('change', function() {
                    const filterValue = $(this).val();
                    let filterUrl = "{{ route('user.index') }}";

                    if (filterValue === 'google_users') {
                        filterUrl += "?google_user=true";
                    } else if (filterValue === 'paid_users') {
                        filterUrl += "?status=paid";
                    } else if (filterValue === 'free_users') {
                        filterUrl += "?status=free";
                    }

                    dTable.ajax.url(filterUrl).load();
                });
            });


            // delete Confirm
        function showDeleteConfirm(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delete this record?',
                text: 'If you delete this, it will be gone forever.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(id);
                }
            });
        }

        // Delete Button
        function deleteItem(id) {
            let url = '{{ route('user.destroy', ':id') }}';
            let csrfToken = '{{ csrf_token() }}';
            $.ajax({
                type: "DELETE",
                url: url.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(resp) {
                    console.log(resp);
                    // Reloade DataTable
                    $('#data-tables').DataTable().ajax.reload();
                    if (resp.success === true) {
                        // show toast message
                        toastr.success(resp.message);

                    } else if (resp.errors) {
                        toastr.error(resp.errors[0]);
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error: function(error) {
                    // location.reload();
                }
            })
        }
        </script>
    @endpush
@endsection
