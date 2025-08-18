@extends('layout.superadmin_layout.main')

@section('content')
    <style>
        .form-select {
            max-width: 100%;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: white;
            line-height: 24px;
            max-width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            height: 45px;
            background: #281F48;
        }

        .select2-container--default .select2-results__option {
            padding: 10px 20px;
            background: white;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #281F48;
            color: white;
        }

        .select2-search--dropdown {
            display: block;
            padding: 4px;
            background: #281F48;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 10px 20px;
            font-size: 14px;
            background: #281F48;
            color: white;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: none;
        }

        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent white transparent;
            border-width: 0 6px 7px 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            left: -118%;
            margin-left: -4px;
            margin-top: 10px;
            position: absolute;
            top: 50%;
            width: 0;
        }

        .table-responsive {
            scrollbar-width: thin;
            scrollbar-color: #281F48 #f1f1f1;
        }

        .table-responsive::-webkit-scrollbar {
            width: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .nav-links {
            color: #281F48;
            background-color: #F0F3F6;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .nav-links.active {
            color: white;
            background-color: #281F48;
        }

        .nav-links:hover {
            color: white;
            background-color: #281F48;
        }

        .btn-action {
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 5px;
        }

        .btn-edit {
            background-color: #281F48;
            color: white;
            border: none;
        }

        .btn-delete {
            background-color: #d90600;
            color: white;
            border: none;
        }

        .custom-modal {
            border-radius: 10px;
            overflow: hidden;
        }

        .custom-modal-header {
            background-color: #FD5631;
            color: white;
            border-bottom: none;
        }

        .custom-modal-body {
            background-color: #F0F3F6;
            color: #281F48;
        }

        .custom-modal-footer {
            background-color: #F0F3F6;
            border-top: none;
        }

        .custom-close-btn {
            font-weight: 600;
            color: #FD5631;
            background-color: white;
            border-radius: 5px;
            border: none;
            padding: 8px 20px;
        }

        .custom-close-btn:hover {
            background-color: #FD5631;
            color: white;
        }

        .custom-delete-btn {
            font-weight: 600;
            color: #281F48;
            background-color: white;
            border-radius: 5px;
            border: none;
            padding: 8px 20px;
        }

        .custom-delete-btn:hover {
            background-color: #d90600;
            color: white;
        }
    </style>

    <div class="container mt-3">
        <div class="row align-items-center mb-2">
            <div class="col-md-12">
                <h2 class="sec mb-0 primary-color-custom">Manage Admins</h2>
            </div>
            <div class="col-md-12 text-end d-flex justify-content-end align-items-center gap-2">
                <a href="{{ route('superadmin.admins.create') }}" class="btn custom-btn-nav rounded">
                    Create an Admin
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row align-items-center">
        </div>
    </div>
    <div class="container table-responsive">
        <div class="row">
            <table class="table table-striped transparent-table align-middle admin-datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->number }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                <a href="{{ route('superadmin.admins.edit', $user->id) }}"
                                    class="btn btn-edit btn-action text-white">
                                    Edit
                                </a>
                                <button type="button" class="btn btn-delete btn-action" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $user->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @foreach ($users as $user)
        <div class="modal fade custom-modal" id="deleteModal{{ $user->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="{{ route('superadmin.admins.destroy', $user->id) }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header custom-modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            Are you sure you want to delete admin <strong>{{ $user->name }}</strong>?
                        </div>
                        <div class="modal-footer custom-modal-footer justify-content-center">
                            <button type="button" class="btn custom-close-btn" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn custom-delete-btn">Yes, Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.admin-datatable').each(function() {
                var table = $(this).DataTable({
                    paging: true,
                    pageLength: 25,
                    lengthChange: false,
                    searching: true,
                    ordering: true,
                    scrollX: false,
                    order: [[0, 'asc']],
                    language: {
                        search: "Search: "
                    },
                    dom: `
                        <"search-wrapper mb-3"f>
                        <"pagination-wrapper d-flex justify-content-between align-items-center mb-3"i p>
                        rt
                        <"pagination-wrapper d-flex justify-content-between align-items-center mt-3"i p>
                        <"clear">
                    `
                });

                // Add search row
                $(this).find('thead').append('<tr class="search-row"></tr>');

                $(this).find('thead th').each(function(index) {
                    var title = $(this).text().trim();
                    var searchHtml = '';

                    if (['Name', 'Email', 'Phone'].includes(title)) {
                        searchHtml = '<input type="text" placeholder="Search ' + title +
                            '" class="ads-column-search"/>';
                    }

                    $(this).closest('thead').find('.search-row').append('<th>' + searchHtml +
                        '</th>');
                });

                // Apply search functionality
                $(this).find('.search-row input, .search-row select').on('keyup change', function() {
                    var columnIndex = $(this).closest('th').index();
                    table.column(columnIndex).search(this.value).draw();
                });
            });
        });
    </script>
@endsection