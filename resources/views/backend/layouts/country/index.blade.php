@extends('backend.app')

@section('title', 'Country')

@push('style')
<link rel="stylesheet" href="{{asset("backend/css/datatable/buttons.dataTables.min.css")}}">
@endpush

@section('content')
    {{--  ========== title-wrapper start ==========  --}}
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Melody Country</h2>
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
                            <li class="active"><span><i class="lni lni-angle-double-right"></i></span>Country</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    {{--  ========== title-wrapper end ==========  --}}

    <div class="tables-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="d-flex justify-content-end mb-3">
                        <button class="btn btn-primary btn-sm" id="addBtn">Add New</button>
                    </div>
                    <div id="file_exports"></div>
                    <div class="table-wrapper table-responsive">
                        <table id="data-table" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
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


    <!-- Country Modal start -->
    <div class="follow-up-modal">
        <div class="modal fade" id="CountryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content card-style text-center">
                    <div class="modal-header">
                        <div class="content text-start ">
                            <h4 class="">
                                Create Country
                            </h4>
                        </div>
                    </div>
                    <form id="VreateUpdateModal" method="POST">
                        <div class="modal-body">
                            <div class="content text-start">

                                <div class="input-style-3">
                                    <span class="icon">
                                        <i class="fa-solid fa-play"></i>
                                    </span>
                                    <input type="text" placeholder="Name" name="name" id="name">
                                    <input type="hidden" name="id" id="id">
                                    <span class="valid-feedback d-block text-danger"></span>
                                </div>

                            </div>
                            <div class="action d-flex flex-wrap justify-content-center mt-20">
                                <button data-bs-dismiss="modal"
                                    class="main-btn btn-sm primary-btn-outline square-btn btn-hover m-1 " id="close-modal">
                                    Close
                                </button>
                                <button type="submit" class="main-btn btn-sm primary-btn square-btn btn-hover m-1">
                                    Submit
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Country Modal End -->
@endsection



@push('script')
 <!-- Include jQuery UI for Sortable -->
 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

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
                        url: "{{ route('country.index') }}",
                        type: "get",
                    },

                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
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
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    createdRow: function(row, data, dataIndex) {
                        // Add a class and data attribute to each <tr> element
                        $(row).addClass('tableRow').attr('data-id', data.id);
                    },
                });
                // dTable.buttons().container().appendTo('#file_exports');
                new DataTable('#example', {
                    responsive: true
                });
            }



            $("#data-table tbody").sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function() {
                    sendOrderToServer();
                }
            });

            function sendOrderToServer() {
                var order = [];
                var token = $('meta[name="csrf-token"]').attr('content');

                $('tr.tableRow').each(function(index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('country.rendaring') }}",
                    data: {
                        order: order,
                        _token: token
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            console.log(response);
                        } else {
                            console.log(response);
                        }
                    }
                });
            }
        });



        // Create Modal Show
        $(document).ready(function() {
            $('#addBtn').on('click', function() {
                $("#VreateUpdateModal")[0].reset();
                $("#id").val('');
                $('#CountryModal').modal('show');
            });
        });


        // Submit Form
        $("#VreateUpdateModal").on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('create.update.country') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: new FormData(this), // Directly pass FormData
                contentType: false, // Important for FormData
                processData: false, // Important for FormData
                success: function(resp) {
                    // Reload DataTable
                    $('#data-table').DataTable().ajax.reload();

                    if (resp.success === true) {
                        // Show success toast message
                        toastr.success(resp.message);
                        $('#CountryModal').modal('hide');
                        $("#VreateUpdateModal")[0].reset();
                    } else if (resp.errors) {
                        console.log(resp.errors);
                        // Show error messages on the form
                        $('#name').next('.valid-feedback').text(resp.errors.name);
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error: function(xhr) {
                    // Display all errors returned by the server
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            // Display error messages
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error('An unexpected error occurred.');
                    }
                }
            });
        });




        // Update
        function ShowUpdateModal(id) {
            let url = '{{ route('country.get', ':id') }}';
            $.ajax({
                type: "GET",
                url: url.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(resp) {
                    if (resp.success === true) {
                        // show toast message
                        toastr.success(resp.message);
                        $("#VreateUpdateModal")[0].reset();
                        $('#name').val(resp.data.name);
                        $('#id').val(resp.data.id);
                        $('#CountryModal').modal('show');
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error: function(error) {
                    toastr.error(error);
                }
            })
        }




        // Close Modal
        $("#close-modal").on('click', function(e) {
            e.preventDefault();
            $('#CountryModal').modal('hide');
        })



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
             let url = '{{ route('country.status', ':id') }}';
             $.ajax({
                 type: "GET",
                 url: url.replace(':id', id),
                 success: function(resp) {
                     console.log(resp);
                     // Reloade DataTable
                     $('#data-table').DataTable().ajax.reload();
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
            let url = '{{ route('country.destroy', ':id') }}';
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
                    $('#data-table').DataTable().ajax.reload();
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
