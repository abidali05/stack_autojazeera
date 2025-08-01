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

        /* Target the scrollable container */
        .table-responsive {
            scrollbar-width: thin;
            /* For Firefox */
            scrollbar-color: #281F48 #f1f1f1;
            /* Thumb and track for Firefox */
        }

        /* Webkit-based browsers (Chrome, Edge, Safari) */
        .table-responsive::-webkit-scrollbar {
            width: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            /* Light background */
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
    {{-- tabs navigaition  --}}
    <div class="container mt-3">
        <div class="row align-items-center mb-2">

            <div class="col-md-8">
                <h2 class="sec mb-0 primary-color-custom">Manage Amenities</h2>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn custom-btn-nav rounded" data-bs-toggle="modal" data-bs-target="#addServiceCategoryModal">
                    Add New

                </button>
            </div>
        </div>

    </div>


    {{-- <div class="container mt-2 ">

        <div class="row align-items-center mb-2">
             <div class="col-md-4 "> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #281F48; font-weight:700;">
                    {{ ($amenities->currentPage() - 1) * $amenities->perPage() + 1 }}
                    - {{ min($amenities->currentPage() * $amenities->perPage(), $amenities->total()) }}
                    of {{ $amenities->total() }} Results
                </span></div>
            <div class="col-md-8">
            
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($amenities->onFirstPage())
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</span>
                                </li>
                            @else
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page" value="{{ $amenities->currentPage() - 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $amenities->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($amenities->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $amenities->currentPage())
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #281F48; color: #fff;">{{ $page }}</span>
                                            </li>
                                        @else
                                            @if (request()->isMethod('post'))
                                                <li style="display: inline-block;">
                                                    <form method="POST" action="{{ url()->current() }}">
                                                        @csrf
                                                        <input type="hidden" name="page" value="{{ $page }}">
                                                        <button type="submit"
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">{{ $page }}</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li style="display: inline-block;">
                                                    <a href="{{ $url }}"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            @if ($amenities->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $amenities->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $amenities->nextPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&raquo;</a>
                                    </li>
                                @endif
                            @else
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&raquo;</span>
                                </li>
                            @endif
                        </ul>

                    </nav>
               
            </div>
          
      
        </div>
    </div> --}}
    <div class="container table-responsive ">
        <div class="row">
            <table class="table table-striped transparent-table align-middle amenities-datatable">
                <thead>
                    <tr>
                        <th>Sr#</th>
                        <th>Action</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>


                    @foreach ($amenities as $key => $amenity)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a class=" me-2" title="Edit" data-bs-toggle="modal" style="text-decoration: none"
                                    data-bs-target="#editServiceCategoryModal{{ $amenity->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a class="primary-color-custom cancel" data-id="{{ $amenity->id }}" title="Delete"
                                    data-bs-toggle="modal" data-bs-target="#deleteServiceCategoryModal{{ $amenity->id }}">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                            <td>{{ $amenity->name }}</td>

                        </tr>


                        <div class="modal fade" id="editServiceCategoryModal{{ $amenity->id }}" tabindex="-1"
                            aria-labelledby="colorModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                    <div class="modal-header border-0 "
                                        style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                        <h5 class="modal-title" id="colorModalLabel"> <strong>Edit Amenities</strong></h5>
                                        <button type="button" class="btn-close"
                                            style="background-color: #D9D9D9 !important; color: #FD5631;"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form id="featureForm" method="post"
                                        action="{{ route('superadmin.amenities.update', $amenity->id) }}"
                                        enctype="multipart/form-data">
                                        <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">

                                            @csrf
                                            @method('PUT')
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="bodyType" class="form-label">Enter Amenity
                                                            Name*</label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ $amenity->name }}" id="name{{ $amenity->id }}"
                                                            placeholder="Enter Amenity Name" required>
                                                    </div>
                                                    @error('name')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror


                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                                            <button type="button" class="btn btn-light px-4 py-2 "
                                                style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-light px-4 py-2 "
                                                style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>



















                        <div class="modal fade" id="deleteServiceCategoryModal{{ $amenity->id }}" tabindex="-1"
                            aria-labelledby="addDealerModalLabel" aria-hidden="true">
                            <div class="modal-dialog  modal-dialog-centered">
                                <div class="modal-content " style="border-radius: 10px; overflow: hidden;">
                                    <div class="modal-header border-0"
                                        style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                        <h5 class="modal-title" id="editDealerModalLabel"><strong>Delete </strong></h5>
                                        <button type="button" class="btn-close"
                                            style="background-color: #D9D9D9 !important; color: #FD5631;"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body text-center" style="background-color: #F0F3F6; color: #FD5631;">
                                        <h4 style="color:#281F48 !important;">Are you sure to delete this record? </h4>
                                        <div class="row mb-3">
                                            <form action="{{ route('superadmin.amenities.destroy', $amenity->id) }}"
                                                method="post">
                                                @method('DELETE')
                                                @csrf
                                                <div class="col-sm-8">
                                                    <input type="hidden" class="form-control" name="deleted_id"
                                                        value="{{ $amenity->id }}" required>
                                                </div>
                                        </div>




                                    </div>
                                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                                        <button type="button" class="btn btn-light px-4 py-2 "
                                            style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-light px-4 py-2 "
                                            style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;">Delete</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach




                </tbody>
            </table>
        </div>








        <div class="modal fade" id="addServiceCategoryModal" tabindex="-1" aria-labelledby="colorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                    <div class="modal-header border-0 "
                        style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                        <h5 class="modal-title" id="colorModalLabel"><strong> Add Amenity</strong></h5>
                        <button type="button" class="btn-close"
                            style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form id="featureForm" method="post" action="{{ route('superadmin.amenities.store') }}"
                        enctype="multipart/form-data">
                        <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">

                            @csrf
                            @method('POST')
                            <div class="row">

                                <div class="col-md-12">


                                    <div class="mb-3">
                                        <label for="bodyType" class="form-label">Enter Amenity
                                            Name*</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') }}" id="name" placeholder="Enter Amenity Name"
                                            required>
                                    </div>
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror


                                </div>
                            </div>

                        </div>

                        <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                            <button type="button" class="btn btn-light px-4 py-2 "
                                style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-light px-4 py-2 "
                                style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        {{-- success modal start --}}


        <div class="modal fade" id="amenityresponse" tabindex="-1" aria-labelledby="amenityresponseLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                    <!-- Modal Header -->
                    <div class="modal-header"
                        style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                        <h5 class="modal-title" id="amenityresponseLabel"><strong> Amenity</strong></h5>
                        <button type="button" class="btn-close"
                            style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body text-center" style="background-color: #F0F3F6; color: #FD5631;">
                        <p>{{ session('amenityresponse') }}</p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                        <button type="button" class="btn btn-light px-4 py-2 "
                            style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;""
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- success modal end --}}

        @if (session('amenityresponse'))
            <script>
                window.addEventListener('DOMContentLoaded', () => {
                    let modal = new bootstrap.Modal(document.getElementById('amenityresponse'));
                    modal.show();
                });
            </script>
        @endif

    </div>

    {{-- <div class="container my-2">
        <div class="row d-flex justify-content-between">
            <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #281F48; font-weight:700;">
                    {{ ($amenities->currentPage() - 1) * $amenities->perPage() + 1 }}
                    - {{ min($amenities->currentPage() * $amenities->perPage(), $amenities->total()) }}
                    of {{ $amenities->total() }} Results
                </span></div>
            <div class="col-md-4">
            
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($amenities->onFirstPage())
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</span>
                                </li>
                            @else
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $amenities->currentPage() - 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $amenities->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($amenities->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $amenities->currentPage())
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #281F48; color: #fff;">{{ $page }}</span>
                                            </li>
                                        @else
                                            @if (request()->isMethod('post'))
                                                <li style="display: inline-block;">
                                                    <form method="POST" action="{{ url()->current() }}">
                                                        @csrf
                                                        <input type="hidden" name="page"
                                                            value="{{ $page }}">
                                                        <button type="submit"
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">{{ $page }}</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li style="display: inline-block;">
                                                    <a href="{{ $url }}"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            @if ($amenities->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $amenities->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $amenities->nextPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&raquo;</a>
                                    </li>
                                @endif
                            @else
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&raquo;</span>
                                </li>
                            @endif
                        </ul>

                    </nav>
           
            </div>
        </div>
    </div> --}}

    <script>
        function handleServiceCategoryIconUpload(input, previewElementId) {
            const previewElement = document.getElementById(previewElementId);
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Check if the file is an image
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = function() {
                        // If it's a valid image, display it
                        previewElement.innerHTML = '';
                        previewElement.appendChild(img);
                    };
                    img.onerror = function() {
                        // Handle the case where the file is not a valid image
                        previewElement.textContent = 'Uploaded file is not a valid image.';
                    };
                };

                reader.readAsDataURL(file);
            } else {
                previewElement.textContent = 'No file uploaded.';
            }
        }

                $(document).ready(function() {
            $('.amenities-datatable').each(function() {
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
                    else if (['Name']
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
