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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

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
                    order: [
                        [0, 'asc']
                    ],
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

                    // Create select for Featured column
                    if (title === 'Status') {
                        searchHtml =
                            '<select class="ads-column-search"><option value="">Any</option><option value="Active">Active</option><option value="InActive">InActive</option></select>';
                    }
                    // Create text inputs for other specified columns
                    else if (['Name', 'Email','Phone']
                        .includes(title)) {
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
