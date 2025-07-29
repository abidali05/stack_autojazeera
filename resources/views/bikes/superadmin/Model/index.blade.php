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
    </style>
    <!-- back header start -->

    <div class="container mt-3">
        <div class="row align-items-center mb-4">

            <div class="col-md-12">
                <h2 class="sec mb-0 primary-color-custom">Manage Bike Model</h2>
            </div>
        </div>
        <div class="row align-items-center mb-2">
            <div class="col-md-4 mb-md-0 mb-2 d-none">
                <div class="input-group" style="width:100%">
                    <form id="dealerForm" action="" method="get" style="width:100%">
                        <select class="form-select  select-search formselect" style="width:100%" name="model_id"
                            style="color:black !important" aria-label="Search Dealer" aria-describedby="search-addon">
                            <option selected>Select Model Name</option>
                            <option value="0">All</option>
                            @foreach ($models as $key => $model)
                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            {{-- <div class="col-md-8 d-none">
                @if ($models->hasPages())
                    <nav class="d-flex justify-content-end align-items-center">
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($models->onFirstPage())
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</span>
                                </li>
                            @else
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page" value="{{ $models->currentPage() - 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $models->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($models->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $models->currentPage())
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

                            @if ($models->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page" value="{{ $models->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $models->nextPageUrl() }}"
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
                @endif
            </div> --}}
            {{-- <div class="col-md-4 d-none"> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #281F48; font-weight:700;">
                    {{ ($models->currentPage() - 1) * $models->perPage() + 1 }}
                    - {{ min($models->currentPage() * $models->perPage(), $models->total()) }}
                    of {{ $models->total() }} Results
                </span></div> --}}
            <div class="col-md-12 text-end">
                <button class="btn custom-btn-nav rounded" data-bs-toggle="modal" data-bs-target="#addbikemakeModal">
                    Add Model
                </button>
            </div>
        </div>
    </div>
    {{-- <div class="container my-2">
        <div class="row d-flex justify-content-between">
            <div class="col-md-5"> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #281F48; font-weight:700;">
                    {{ ($models->currentPage() - 1) * $models->perPage() + 1 }}
                    - {{ min($models->currentPage() * $models->perPage(), $models->total()) }}
                    of {{ $models->total() }} Results
                </span></div>
            <div class="col-md-4">
                @if ($models->hasPages())
                    <nav class="d-flex justify-content-end align-items-center">
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($models->onFirstPage())
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</span>
                                </li>
                            @else
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page" value="{{ $models->currentPage() - 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $models->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($models->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $models->currentPage())
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

                            @if ($models->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $models->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $models->nextPageUrl() }}"
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
                @endif
            </div>
        </div>
    </div> --}}
    <div class="container table-responsive ">
        <div class="row">
            <table class="table table-striped transparent-table align-middle model-datatable">
                <thead>
                    <tr>
                        <th>Sr#</th>
                        <th>Action</th>
                        <th>Body Type</th>
                        <th>Make Name</th>
                        <th>Model</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($models as $key => $model)
                        <!-- Repeat this block for each row -->
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a class=" me-2" title="Edit" data-bs-toggle="modal" style="text-decoration:none"
                                    data-bs-target="#editBikemodelModal{{ $model->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a class="primary-color-custom cancel" data-id="{{ $model->id }}" title="Delete"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>

                            <td>{{ $model->body->name ?? '' }}</td>
                            <td>{{ $model->make->name ?? '' }}</td>
                            <td>{{ $model->name }}</td>
                            <td>
                                @if ($model->status == 0)
                                    <span class="badge text-bg-danger">Inactive</span>
                                @else
                                    <span class="badge  text-bg-active">Active</span>
                                @endif

                            </td>
                        </tr>
                        <div class="modal fade" id="editBikemodelModal{{ $model->id }}" tabindex="-1"
                            aria-labelledby="colorModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                    <div class="modal-header border-0"
                                        style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                        <h5 class="modal-title" id="colorModalLabel"> <strong>Edit Model</strong></h5>
                                        <button type="button" class="btn-close"
                                            style="background-color: #D9D9D9 !important; color: #FD5631;"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">
                                        <form method="post"
                                            action="{{ route('superadmin.bike-model.update', $model->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="row mb-3">
                                                <label for="colorName" class="col-sm-5 col-form-label">Select
                                                    Make*</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select"
                                                        style="color:#281F48;background-color:white;text-align:start ;border:1px solid #281F48"
                                                        name="make" id="featureType" required>
                                                        <option value="" disabled selected>Select Make</option>
                                                        @foreach ($makes as $make)
                                                            <option value="{{ $make->id }}"
                                                                {{ $make->id == $model->make_id ? 'selected' : '' }}>
                                                                {{ $make->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="colorCode" class="col-sm-5 col-form-label">Enter Body
                                                    Type*</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select"
                                                        style="color:#281F48;background-color:white;text-align:start ;border:1px solid #281F48"
                                                        name="bodytype" id="bodyType" required>
                                                        <option value="" disabled selected>Select Body Type</option>
                                                        @foreach ($bodytypes as $bodytype)
                                                            <option value="{{ $bodytype->id }}"
                                                                {{ $bodytype->id == $model->bodytype ? 'selected' : '' }}>
                                                                {{ $bodytype->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="addStatus" class="col-sm-5 col-form-label">Enter
                                                    Model*</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ $model->name }}" id="bodyType"
                                                        placeholder="Enter Model" required>
                                                </div>

                                            </div>
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" name="status" type="checkbox"
                                                    id="activateFeature" {{ $model->status === 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="activateFeature">Activate</label>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- <div class="container my-3">
        <div class="row d-flex justify-content-between">
            <div class="col-md-5"> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #281F48; font-weight:700;">
                    {{ ($models->currentPage() - 1) * $models->perPage() + 1 }}
                    - {{ min($models->currentPage() * $models->perPage(), $models->total()) }}
                    of {{ $models->total() }} Results
                </span></div>
            <div class="col-md-4">
                @if ($models->hasPages())
                    <nav class="d-flex justify-content-end align-items-center">
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($models->onFirstPage())
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
                                                value="{{ $models->currentPage() - 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $models->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($models->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $models->currentPage())
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

                            @if ($models->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $models->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $models->nextPageUrl() }}"
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
                @endif
            </div>
        </div>
    </div> --}}
    {{-- add modal  --}}
    <div class="modal fade" id="addbikemakeModal" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content " style="border-radius: 10px; overflow: hidden;">
                <div class="modal-header border-0"
                    style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                    <h5 class="modal-title" id="colorModalLabel"> <strong> Add Model</strong></h5>
                    <button type="button" class="btn-close"
                        style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">
                    <form method="post" action="{{ route('superadmin.bike-model.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="colorName" class="col-sm-5 col-form-label">Select Make*</label>
                            <div class="col-sm-7">
                                <select class="form-select" name="make"
                                    style="color:#281F48;background-color:white;text-align:start ;border:1px solid #281F48"
                                    id="featureType" required>
                                    <option value="" disabled selected>Select Make</option>
                                    @foreach ($makes as $make)
                                        <option value="{{ $make->id }}">{{ $make->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="colorCode" class="col-sm-5 col-form-label">Enter Body Type*</label>
                            <div class="col-sm-7">
                                <select class="form-select" name="bodytype" id="bodyType"
                                    style="color:#281F48;background-color:white;text-align:start ;border:1px solid #281F48"
                                    required>
                                    <option value="" disabled selected>Select Body Type</option>
                                    @foreach ($bodytypes as $bodytype)
                                        <option value="{{ $bodytype->id }}">{{ $bodytype->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="addStatus" class="col-sm-5 col-form-label">Enter Model*</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="name" id="bodyType"
                                    placeholder="Enter Model" required>
                            </div>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" name="status" type="checkbox" id="activateFeature" checked>
                            <label class="form-check-label" for="activateFeature">Activate</label>
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


    @if (isset($model))
        <form action="{{ route('superadmin.bike-model.destroy', $model->id) }}" method="post">
            @include('superadmin.modal.delete')
        </form>
    @endif

    <script>
        $(document).ready(function() {
            $('.model-datatable').each(function() {
                var table = $(this).DataTable({
                    paging: true,
                    pageLength: 25,
                    lengthChange: false,
                    searching: true,
                    ordering: true,
                    scrollX: true,
                    order: [
                        [0, 'asc']
                    ],
                    language: {
                        search: "Search: "
                    },
                    dom: `<"search-wrapper mb-3"f>
                        <"pagination-wrapper d-flex justify-content-between align-items-center mb-3"i p>
                        rt
                        <"pagination-wrapper d-flex justify-content-between align-items-center mt-3"i p>
                        <"clear">`
                });

                // Add search row
                $(this).find('thead').append('<tr class="search-row"></tr>');

                $(this).find('thead th').each(function(index) {
                    var title = $(this).text().trim();
                    var searchHtml = '';

                    // Only create inputs for specific columns
                    if (['Dealer Name', 'Make', 'Model', 'Year'].includes(title)) {
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
