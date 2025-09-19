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
            /* Light background */
        }

        .table>:not(caption)>*>* {
            padding: 0rem .5rem;
            color: var(--bs-table-color-state, var(--bs-table-color-type, var(--bs-table-color)));
            background-color: var(--bs-table-bg);
            border-bottom-width: var(--bs-border-width);
            box-shadow: inset 0 0 0 9999px var(--bs-table-bg-state, var(--bs-table-bg-type, var(--bs-table-accent-bg)));
        }

        table.dataTable>thead>tr>th,
        table.dataTable>thead>tr>td {
            padding: 0px 10px 5px 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.3);
        }

        div.dt-container .dt-length,
        div.dt-container .dt-search,
        div.dt-container .dt-info,
        div.dt-container .dt-processing,
        div.dt-container .dt-paging {
            color: inherit;
            display: flex;
            justify-content: end;
        }
    </style>
    <div class="container mt-3">
        <div class="row align-items-center mb-2">

            <div class="col-md-12">
                <h2 class="sec mb-0 primary-color-custom">Manage Blogs</h2>
            </div>
        </div>
        <div class="row align-items-center mb-2">
            <div class="col-md-12 d-flex justify-content-end">
                <a href="{{ route('superadmin.blogs.create') }}">
                    <button class="btn custom-btn-nav rounded">
                        <i class="bi bi-plus fs-5 p-0 m-0 "></i> Add New Blog
                    </button>
                </a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="container table-responsive">
                <div class="row">
                    <table class="table table-striped align-middle blog-datatable">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Action</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Tags</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blogs as $key => $blog)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <a style="text-decoration: none" href="{{ route('superadmin.blogs.edit', $blog->id) }}" class="me-2"
                                            title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                   <!-- Delete Button (opens modal instead of submitting directly) -->
<button type="button" class="btn btn-link p-0 m-0 text-danger" title="Delete"
        data-bs-toggle="modal" data-bs-target="#deleteModal{{ $blog->id }}">
    <i class="bi bi-trash"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="deleteModal{{ $blog->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $blog->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel{{ $blog->id }}">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        Are you sure you want to delete this blog?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn custom-btn-nav rounded" data-bs-dismiss="modal">No</button>

        <!-- Real delete form -->
        <form action="{{ route('superadmin.blogs.destroy', $blog->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn custom-btn-nav rounded"> Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

                                    </td>
                                    <td>{{ $blog->title }}</td>
                                    <td>
                                        @if ($blog->image)
                                            <a href="{{ asset($blog->image) }}" target="_blank">
                                                <img src="{{ asset($blog->image) }}" width="50"
                                                    style="height: 40px; object-fit: cover;">
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    <td>{!! Str::limit($blog->description, 50) !!}</td>
                                    <td>{{ $blog->tags }}</td>
                                </tr>

                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @include('superadmin.modal.addcolor')
            <script>
                $(document).ready(function() {
                    $('.blog-datatable').each(function() {
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

                            // Only create inputs for specific columns
                            if (['Name'].includes(title)) {
                                searchHtml = '<input type="text" placeholder="Search ' + title +
                                    '" class="ads-column-search"/>';
                            }

                            $(this).closest('thead').find('.search-row').append(
                                '<th>' + searchHtml + '</th>'
                            );
                        });

                        // Apply search functionality
                        $(this).find('.search-row input').on('keyup change', function() {
                            var columnIndex = $(this).closest('th').index();
                            table.column(columnIndex).search(this.value).draw();
                        });
                    });
                });
            </script>
        @endsection
