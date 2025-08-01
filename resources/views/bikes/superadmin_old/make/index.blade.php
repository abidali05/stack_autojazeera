@extends('layout.panel_layout.main')

@section('content')
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: white;
            line-height: 24px;
        }

        .select2-container--default .select2-selection--single {
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            height: 45px;
            background: #1F1B2D;
        }

        .select2-container--default .select2-results__option {
            padding: 10px 20px;
            background: #1F1B2D;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #FD5631;
            color: white;
        }

        .select2-search--dropdown {
            display: block;
            padding: 4px;
            background: #1F1B2D;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 10px 20px;
            font-size: 14px;
            background: #1F1B2D;
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

        tbody tr td a {
            color: white !important;
            text-decoration: none;
        }

        .bi::before,
        [class^="bi-"]::before,
        [class*=" bi-"]::before {
            vertical-align: -5px;
        }
    </style>
    <div class="container mt-5">
        <div class="row align-items-center mb-4">
            <div class="col-auto">
                <a href="{{ route('superadmin.dashboard') }}" class="text-white me-3">
                    <img src="{{ asset('web/images/icon.svg') }}" alt="back-arrow" width="50px" height="35px">
                </a>
            </div>
            <div class="col-auto">
                <h2 class="sec mb-0 primary-color-custom">Manage Bike Makes</h2>
            </div>
        </div>
        <div class="row align-items-center mb-4">
            <div class="col-md-4 mb-md-0 mb-2">
                <div class="input-group" style="width:100%">
                    <form id="dealerForm" action="" method="get" style="width:100%">
                        <select class="form-select  select-search formselect" name="make_id" style="width:100%"
                            style="color:black !important" aria-label="Search Dealer" aria-describedby="search-addon">
                            <option selected>Select Make Name</option>
                            <option value="0">All</option>
                            @foreach ($bike_makes as $key => $make)
                                <option value="{{ $make->id }}">{{ $make->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                @if ($bike_makes->hasPages())
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($bike_makes->onFirstPage())
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</span>
                                </li>
                            @else
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page" value="{{ $posts->currentPage() - 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&laquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $bike_makes->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($bike_makes->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $bike_makes->currentPage())
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #FD5631; color: #fff;">{{ $page }}</span>
                                            </li>
                                        @else
                                            @if (request()->isMethod('post'))
                                                <li style="display: inline-block;">
                                                    <form method="POST" action="{{ url()->current() }}">
                                                        @csrf
                                                        <input type="hidden" name="page" value="{{ $page }}">
                                                        <button type="submit"
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">{{ $page }}</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li style="display: inline-block;">
                                                    <a href="{{ $url }}"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            @if ($bike_makes->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $bike_makes->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $bike_makes->nextPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&raquo;</a>
                                    </li>
                                @endif
                            @else
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
            <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #FD5631; font-weight:700;">
                    {{ ($bike_makes->currentPage() - 1) * $bike_makes->perPage() + 1 }}
                    - {{ min($bike_makes->currentPage() * $bike_makes->perPage(), $bike_makes->total()) }}
                    of {{ $bike_makes->total() }} Results
                </span></div>
            <div class="col-md-8 text-end">
                <button class="btn custom-btn-nav rounded" data-bs-toggle="modal" data-bs-target="#addbikemakeModal">
                    <span> <i class="bi bi-plus fs-5 p-0 m-0 "></i></span> <span class="pb-3"> Add Make</span>
                </button>
            </div>
        </div>
    </div>
    <div class="container table-responsive ">
        <div class="row">
            <table class="table table-striped transparent-table align-middle datatable">
                <thead>
                    <tr>
                        <th>Sr#</th>
                        <th>Action</th>

                        <th>Icon</th>
                        <th>Make Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Repeat this block for each row -->
                    @foreach ($bike_makes as $key => $make)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a class="text-white me-2" title="Edit" data-bs-toggle="modal"
                                    data-bs-target="#editbikemakeModal{{ $make->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a class="primary-color-custom cancel" data-id="{{ $make->id }}" title="Delete"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>

                            <td><img @if ($make->icon) src="{{ asset('posts/makes/bikes/' . $make->icon) }}" @else src="{{ asset('web/images/toyota.png') }}" @endif
                                    alt="" srcset="" width="40" height="30"></td>
                            <td>{{ $make->name }}</td>
                            <td>
                                @if ($make->status == 0)
                                    <span class="badge text-bg-danger">Inactive</span>
                                @else
                                    <span class="badge text-bg-active">Active</span>
                                @endif

                            </td>
                        </tr>
                        {{-- @include('superadmin.modal.editmake') --}}
                        {{-- edit make modal  --}}

                        <div class="modal fade" id="editbikemakeModal{{ $make->id }}" tabindex="-1"
                            aria-labelledby="colorModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title" id="colorModalLabel">Add Make</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="featureForm" method="post"
                                            action="{{ route('superadmin.bike-make.update', $make->id) }}"
                                            enctype="multipart/form-data">
                                            <div class="modal-body">

                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <!-- Left Side: Upload Icon -->
                                                    <div class="col-md-6 text-center">
                                                        <div class="upload-area border border-dashed rounded p-4 text-center"
                                                            onclick="document.getElementById('bike_make_icon{{ $make->id }}').click();">
                                                            <p class="mb-0">Click here to upload Icon</p>
                                                            <input type="file" id="bike_make_icon{{ $make->id }}"
                                                                name="icon" class="d-none" accept=".png, .jpg, .jpeg"
                                                                onchange="handlemakeimageUpload(this, 'bike_make_icon_preview{{ $make->id }}')">
                                                        </div>
                                                        <div id="bike_make_icon_preview{{ $make->id }}"
                                                            class="mt-3 text-success image-preview"></div>
                                                    </div>


                                                    <!-- Right Side: Input Fields -->
                                                    <div class="col-md-6">

                                                        <div class="mb-3">
                                                            <label for="bodyType" class="form-label">Enter Make
                                                                Name*</label>
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ $make->name }}" id="bodyType"
                                                                placeholder="Enter Make Name" required>
                                                        </div>

                                                        <div class="form-check form-switch mb-3">
                                                            <input class="form-check-input" name="status"
                                                                type="checkbox" id="activateFeature"
                                                                {{ $make->status == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="activateFeature">Activate</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn  custom-btn-nav rounded">Save</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- Repeat this block for each row -->



                </tbody>
            </table>
        </div>




    </div>

    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #FD5631; font-weight:700;">
                    {{ ($bike_makes->currentPage() - 1) * $bike_makes->perPage() + 1 }}
                    - {{ min($bike_makes->currentPage() * $bike_makes->perPage(), $bike_makes->total()) }}
                    of {{ $bike_makes->total() }} Results
                </span></div>
            <div class="col-md-4">
                @if ($bike_makes->hasPages())
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($bike_makes->onFirstPage())
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</span>
                                </li>
                            @else
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $posts->currentPage() - 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&laquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $bike_makes->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($bike_makes->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $bike_makes->currentPage())
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #FD5631; color: #fff;">{{ $page }}</span>
                                            </li>
                                        @else
                                            @if (request()->isMethod('post'))
                                                <li style="display: inline-block;">
                                                    <form method="POST" action="{{ url()->current() }}">
                                                        @csrf
                                                        <input type="hidden" name="page"
                                                            value="{{ $page }}">
                                                        <button type="submit"
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">{{ $page }}</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li style="display: inline-block;">
                                                    <a href="{{ $url }}"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            @if ($bike_makes->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $bike_makes->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $bike_makes->nextPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&raquo;</a>
                                    </li>
                                @endif
                            @else
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>
    @include('superadmin.modal.addmake')
    @if (isset($make))
        <form action="{{ route('superadmin.bike-make.destroy', $make->id) }}" method="post">
            @include('superadmin.modal.delete')
        </form>
    @endif


    {{-- add make modal  --}}

    <div class="modal fade" id="addbikemakeModal" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="colorModalLabel">Add Make</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="featureForm" method="post" action="{{ route('superadmin.bike-make.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Left Side: Upload Icon -->
                            <div class="col-md-6 text-center">
                                <div class="upload-area  rounded p-4 text-center"
                                    onclick="document.getElementById('bike_make_icon').click();"
                                    style="border:1px dashed white">
                                    <p class="mb-0">Click here to upload Icon</p>
                                    <input type="file" id="bike_make_icon" name="icon" class="d-none"
                                        accept=".png, .jpg, .jpeg"
                                        onchange="handlemakeimageUpload(this, 'bike_make_icon_preview')">
                                </div>
                                <div id="bike_make_icon_preview" class="mt-3 text-success"></div>
                            </div>


                            <!-- Right Side: Input Fields -->
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="bodyType" class="form-label">Enter Make Name*</label>
                                    <input type="text" class="form-control" name="name" id="bodyType"
                                        placeholder="Enter Make Name" required>
                                </div>

                                <div class="form-check form-switch mb-3 d-flex justify-content-end">
                                    <input class="form-check-input" name="status" type="checkbox" id="activateFeature"
                                        checked>
                                    <label class="form-check-label" for="activateFeature">Activate</label>
                                </div>
                            </div>
                        </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn  custom-btn-nav rounded">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('web/bikes/js/superadmin/add_make.js') }}"></script>
@endsection
