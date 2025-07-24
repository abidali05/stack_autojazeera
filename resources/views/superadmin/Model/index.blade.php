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
    </style> {{-- tabs navigaition  --}}
    <div class="container mt-3">
        <div class="row align-items-center mb-2">

            <div class="col-md-12">
                <h2 class="sec mb-0 primary-color-custom">Manage Car Model</h2>
            </div>
        </div>
        <div class="row d-none">
            <div class="col-md-12 text-center row">

                <ul class="nav nav-tabs" style="border:none" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-links active " id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                            type="button" role="tab" aria-controls="home" aria-selected="true">Cars</button>
                    </li>
                    <li class="nav-item m-0" role="presentation">
                        <button class="nav-links " id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab" aria-controls="profile" aria-selected="false">Bikes</button>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            {{-- tab start  --}}
            <!-- back header start -->

            <div class="container mt-3">

                <div class="row align-items-center ">
                    <div class="col-md-4 mb-md-0 mb-2 d-none">
                        <div class="input-group" style="width:100%">
                            <form id="dealerForm" action="" method="get" style="width:100%">
                                <select class="form-select  select-search formselect" style="width:100%" name="model_id"
                                    style="color:black !important" aria-label="Search Dealer"
                                    aria-describedby="search-addon">
                                    <option selected>Select Model Name</option>
                                    <option value="0">All</option>
                                    @foreach ($models as $key => $model)
                                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-8 d-none">
                        @if ($models->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <!-- Page Info -->


                                <!-- Pagination -->
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
                    <div class="col-md-4 d-none"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($models->currentPage() - 1) * $models->perPage() + 1 }}
                            - {{ min($models->currentPage() * $models->perPage(), $models->total()) }}
                            of {{ $models->total() }} Results
                        </span></div>
                    <div class="col-md-12 text-end">
                        <button class="btn custom-btn-nav rounded" data-bs-toggle="modal" data-bs-target="#makeModal">
                            Add Model
                        </button>
                    </div>
                </div>
            </div>
                {{-- <div class="container my-2">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-5"> <span class="pt-md-3 pagination_count"
                                style="font-size: 18px; color: #281F48; font-weight:700;">
                                {{ ($bikemodels->currentPage() - 1) * $bikemodels->perPage() + 1 }}
                                - {{ min($bikemodels->currentPage() * $bikemodels->perPage(), $bikemodels->total()) }}
                                of {{ $bikemodels->total() }} Results
                            </span></div>
                        <div class="col-md-4">
                            @if ($bikemodels->hasPages())
                                <nav class="d-flex justify-content-end align-items-center">
                                    <!-- Page Info -->


                                    <!-- Pagination -->
                                    <ul class="pagination"
                                        style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                        @if ($bikemodels->onFirstPage())
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
                                                            value="{{ $bikemodels->currentPage() - 1 }}">
                                                        <button type="submit"
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li style="display: inline-block;">
                                                    <a href="{{ $bikemodels->previousPageUrl() }}"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                                </li>
                                            @endif
                                        @endif

                                        @foreach ($bikemodels->links()->elements as $element)
                                            @if (is_string($element))
                                                <li style="display: inline-block;">
                                                    <span
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                                </li>
                                            @endif

                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    @if ($page == $bikemodels->currentPage())
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

                                        @if ($bikemodels->hasMorePages())
                                            @if (request()->isMethod('post'))
                                                <li style="display: inline-block;">
                                                    <form method="POST" action="{{ url()->current() }}">
                                                        @csrf
                                                        <input type="hidden" name="page"
                                                            value="{{ $bikemodels->currentPage() + 1 }}">
                                                        <button type="submit"
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li style="display: inline-block;">
                                                    <a href="{{ $bikemodels->nextPageUrl() }}"
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
                    <table class="table table-striped transparent-table align-middle datatable">
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
                                        <a class=" me-2" title="Edit" data-bs-toggle="modal"
                                            style="text-decoration:none"
                                            data-bs-target="#editmodelModal{{ $model->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="primary-color-custom cancel" data-id="{{ $model->id }}"
                                            title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                                @include('superadmin.modal.editmodel')
                            @endforeach
                        </tbody>
                    </table>
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
            @include('superadmin.modal.addmodel')
            @if (isset($model))
                <form action="{{ route('superadmin.model.destroy', $model->id) }}" method="post">
                    @include('superadmin.modal.delete')
                </form>
            @endif
        </div>
        {{-- tab end  --}}
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            {{-- tab start  --}}
            <div class="container mt-5">

                <div class="row align-items-center mb-4">
                    <div class="col-md-4 mb-md-0 mb-2">
                        <div class="input-group" style="width:100%">
                            <form id="dealerForm" action="" method="get" style="width:100%">
                                <select class="form-select  select-search formselect" style="width:100%" name="model_id"
                                    style="color:black !important" aria-label="Search Dealer"
                                    aria-describedby="search-addon">
                                    <option selected>Select Model Name</option>
                                    <option value="0">All</option>
                                    @foreach ($bikemodels as $key => $model)
                                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="col-md-8">
                        @if ($bikemodels->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                    @if ($bikemodels->onFirstPage())
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
                                                        value="{{ $bikemodels->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bikemodels->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($bikemodels->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $bikemodels->currentPage())
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

                                    @if ($bikemodels->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $bikemodels->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bikemodels->nextPageUrl() }}"
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
                    {{-- <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($bikemodels->currentPage() - 1) * $bikemodels->perPage() + 1 }}
                            - {{ min($bikemodels->currentPage() * $bikemodels->perPage(), $bikemodels->total()) }}
                            of {{ $bikemodels->total() }} Results
                        </span></div> --}}
                    <div class="col-md-8 text-end">
                        <button class="btn custom-btn-nav rounded" data-bs-toggle="modal"
                            data-bs-target="#addbikemakeModal">
                            <span> <i class="bi bi-plus fs-5 p-0 m-0 "></i></span> <span class="pb-3"> Add Model</span>
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
                                <th>Body Type</th>
                                <th>Make Name</th>
                                <th>Model</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bikemodels as $key => $model)
                                <!-- Repeat this block for each row -->
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <a class=" me-2" title="Edit" data-bs-toggle="modal"
                                            style="text-decoration:none"
                                            data-bs-target="#editBikemodelModal{{ $model->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="primary-color-custom cancel" data-id="{{ $model->id }}"
                                            title="Delete" data-bs-toggle="modal"
                                            data-bs-target="#deletebikemodelModal{{ $model->id }}">
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
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header border-0" style="background-color:#F0F3F6">
                                                <h5 class="modal-title" id="colorModalLabel">Add Model</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="background-color:#F0F3F6">
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
                                                                <option value="" disabled selected>Select Make
                                                                </option>
                                                                @foreach ($bikemakes as $make)
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
                                                                <option value="" disabled selected>Select Body Type
                                                                </option>
                                                                @foreach ($bikebodytypes as $bodytype)
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
                                                            id="activateFeature"
                                                            {{ $model->status === 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="activateFeature">Activate</label>
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


                                {{-- delete modal  --}}

                                <div class="modal fade" id="deletebikemodelModal{{ $model->id }}" tabindex="-1"
                                    aria-labelledby="addDealerModalLabel" aria-hidden="true">
                                    <div class="modal-dialog ">
                                        <div class="modal-content"
                                            style="background-color:#F0F3F6 !important; color:#281F48 !important;">
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title" id="editDealerModalLabel">Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <form action="{{ route('superadmin.bike-model.destroy', $model->id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <h4 style="color:#281F48 !important;">Are you sure to delete this
                                                        record?
                                                    </h4>
                                                    <div class="row mb-3">

                                                        <div class="col-sm-8">
                                                            <input type="hidden" class="form-control" name="deleted_id"
                                                                id="deleted_id" value="{{ $model->id }}" required>
                                                        </div>
                                                    </div>




                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn  custom-btn-nav rounded">Delete</button>
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
            <div class="container my-2">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-5"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($bikemodels->currentPage() - 1) * $bikemodels->perPage() + 1 }}
                            - {{ min($bikemodels->currentPage() * $bikemodels->perPage(), $bikemodels->total()) }}
                            of {{ $bikemodels->total() }} Results
                        </span></div>
                    <div class="col-md-4">
                        @if ($bikemodels->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <!-- Page Info -->


                                <!-- Pagination -->
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                    @if ($bikemodels->onFirstPage())
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
                                                        value="{{ $bikemodels->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bikemodels->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($bikemodels->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $bikemodels->currentPage())
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

                                    @if ($bikemodels->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $bikemodels->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bikemodels->nextPageUrl() }}"
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
            </div>
            @include('superadmin.modal.addmodel')
            @if (isset($model))
                <form action="{{ route('superadmin.model.destroy', $model->id) }}" method="post">
                    @include('superadmin.modal.delete')
                </form>
            @endif
        </div>
    </div>



    {{-- add bike model modal  --}}
    {{-- add modal  --}}
    <div class="modal fade" id="addbikemakeModal" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0" style="background-color:#F0F3F6">
                    <h5 class="modal-title" id="colorModalLabel">Add Model</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color:#F0F3F6">
                    <form method="post" action="{{ route('superadmin.bike-model.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="colorName" class="col-sm-5 col-form-label">Select Make*</label>
                            <div class="col-sm-7">
                                <select class="form-select" name="make"
                                    style="color:#281F48;background-color:white;text-align:start ;border:1px solid #281F48"
                                    id="featureType" required>
                                    <option value="" disabled selected>Select Make</option>
                                    @foreach ($bikemakes as $make)
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
                                    @foreach ($bikebodytypes as $bodytype)
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

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn  custom-btn-nav rounded">Save</button>
                </div>

                </form>
            </div>
        </div>
    </div>
@endsection
