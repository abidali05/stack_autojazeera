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

        .bi::before,
        [class^="bi-"]::before,
        [class*=" bi-"]::before {
            vertical-align: -5px;
        }
    </style>
    <!-- back header start -->

    <div class="container mt-5">
        <div class="row align-items-center mb-4">
            <div class="col-auto">
                <a href="{{ route('superadmin.dashboard') }}" class="text-white me-3">
                    <img src="{{ asset('web/images/icon.svg') }}" alt="back-arrow" width="50px" height="35px">
                </a>
            </div>
            <div class="col-auto">
                <h2 class="sec mb-0 primary-color-custom">Manage Model</h2>
            </div>
        </div>
        <div class="row align-items-center mb-4">
            <div class="col-md-4 mb-md-0 mb-2">
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
            <div class="col-md-8">
                @if ($models->hasPages())
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($models->onFirstPage())
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
                                        <a href="{{ $models->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($models->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $models->currentPage())
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

                            @if ($models->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page" value="{{ $models->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $models->nextPageUrl() }}"
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
                    {{ ($models->currentPage() - 1) * $models->perPage() + 1 }}
                    - {{ min($models->currentPage() * $models->perPage(), $models->total()) }}
                    of {{ $models->total() }} Results
                </span></div>
            <div class="col-md-8 text-end">
                <button class="btn custom-btn-nav rounded" data-bs-toggle="modal" data-bs-target="#addbikemakeModal">
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
                    @foreach ($models as $key => $model)
                        <!-- Repeat this block for each row -->
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a class="text-white me-2" title="Edit" data-bs-toggle="modal"
                                    style="text-decoration:none" data-bs-target="#editBikemodelModal{{ $model->id }}">
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
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title" id="colorModalLabel">Add Model</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post"
                                            action="{{ route('superadmin.bike-model.update', $model->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="row mb-3">
                                                <label for="colorName" class="col-sm-5 col-form-label">Select
                                                    Make*</label>
                                                <div class="col-sm-7">
                                                    <select class="form-select" name="make" id="featureType" required>
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
                                                    <select class="form-select" name="bodytype" id="bodyType" required>
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
                                                    id="activateFeature" {{ $model->status === '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="activateFeature">Activate</label>
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
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-md-5"> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #FD5631; font-weight:700;">
                    {{ ($models->currentPage() - 1) * $models->perPage() + 1 }}
                    - {{ min($models->currentPage() * $models->perPage(), $models->total()) }}
                    of {{ $models->total() }} Results
                </span></div>
            <div class="col-md-4">
                @if ($models->hasPages())
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($models->onFirstPage())
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
                                        <a href="{{ $models->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($models->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $models->currentPage())
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

                            @if ($models->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $models->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $models->nextPageUrl() }}"
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
    {{-- add modal  --}}
    <div class="modal fade" id="addbikemakeModal" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="colorModalLabel">Add Make</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('superadmin.bike-model.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="colorName" class="col-sm-5 col-form-label">Select Make*</label>
                            <div class="col-sm-7">
                                <select class="form-select" name="make" id="featureType" required>
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
                                <select class="form-select" name="bodytype" id="bodyType" required>
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

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn  custom-btn-nav rounded">Save</button>
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
@endsection
