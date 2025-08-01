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
        <div class="row align-items-center ">

            <div class="col-md-12">
                <h2 class="sec mb-0 primary-color-custom">Manage Car Make</h2>
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
            <div class="container mt-2">

                <div class="row align-items-center mb-4 ">
                    <div class="col-md-4 mb-md-0 mb-2 d-none">
                        <div class="input-group" style="width:100%">
                            <form id="dealerForm" action="" method="get" style="width:100%">
                                <select class="form-select  select-search formselect" name="carmake_id" style="width:100%"
                                    style="color:black !important" aria-label="Search Dealer"
                                    aria-describedby="search-addon">
                                    <option selected>Select Make Name</option>
                                    <option value="0">All</option>
                                    @foreach ($makes as $key => $make)
                                        <option value="{{ $make->id }}">{{ $make->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="col-md-8 d-none">
                        @if ($makes->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                    @if ($makes->onFirstPage())
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
                                                        value="{{ $makes->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $makes->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($makes->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $makes->currentPage())
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

                                    @if ($makes->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $makes->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $makes->nextPageUrl() }}"
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
                            {{ ($makes->currentPage() - 1) * $makes->perPage() + 1 }}
                            - {{ min($makes->currentPage() * $makes->perPage(), $makes->total()) }}
                            of {{ $makes->total() }} Results
                        </span></div> --}}
                    <div class="col-md-12 text-end">
                        <button class="btn custom-btn-nav rounded" data-bs-toggle="modal" data-bs-target="#makeModal">
                            Add Make Name
                        </button>
                        <a href="{{ route('superadmin.make-export') }}">
                            <button type="submit" class="btn btn-light px-4 py-2 "
                                style="background-color: white; font-weight:400; color: #281F48; border-radius: 5px; border:1px solid #281F48">
                                <i class="bi bi-file-earmark-excel"></i> Export Excel
                            </button>
                        </a>
                        <!-- Import Button (triggers modal) -->
                        <button type="button" class="btn btn-light px-4 py-2 "
                            style="background-color: #281F48; font-weight:400; color: white; border-radius: 5px;"
                            data-bs-toggle="modal" data-bs-target="#importExcelModal">
                            <i class="bi bi-upload"></i> Import Excel
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importExcelModalLabel">Import Ads from Excel</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('superadmin.make-import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="excelFile" class="form-label">Select Excel File (.xlsx)</label>
                                    <input type="file" class="form-control" id="excelFile" name="excel_file"
                                        accept=".xlsx,.xls" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="container my-2">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($makes->currentPage() - 1) * $makes->perPage() + 1 }}
                            - {{ min($makes->currentPage() * $makes->perPage(), $makes->total()) }}
                            of {{ $makes->total() }} Results
                        </span></div>
                    <div class="col-md-4">
                        @if ($makes->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                    @if ($makes->onFirstPage())
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
                                                        value="{{ $makes->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $makes->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($makes->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $makes->currentPage())
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

                                    @if ($makes->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $makes->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $makes->nextPageUrl() }}"
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
                                <th>Icon</th>
                                <th>Make Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Repeat this block for each row -->
                            @foreach ($makes as $key => $make)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <a class=" me-2" title="Edit" data-bs-toggle="modal"
                                            style="text-decoration: none"
                                            data-bs-target="#editmakeModal{{ $make->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="primary-color-custom cancel" data-id="{{ $make->id }}"
                                            title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>

                                    <td><img @if ($make->icon) src="{{ asset('posts/makes/' . $make->icon) }}" @else src="{{ asset('web/images/toyota.png') }}" @endif
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
                                @include('superadmin.modal.editmake')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <div class="container my-2">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($makes->currentPage() - 1) * $makes->perPage() + 1 }}
                            - {{ min($makes->currentPage() * $makes->perPage(), $makes->total()) }}
                            of {{ $makes->total() }} Results
                        </span></div>
                    <div class="col-md-4">
                        @if ($makes->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <!-- Page Info -->


                                <!-- Pagination -->
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                    @if ($makes->onFirstPage())
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
                                                        value="{{ $makes->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $makes->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($makes->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $makes->currentPage())
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

                                    @if ($makes->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $makes->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $makes->nextPageUrl() }}"
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

            @include('superadmin.modal.addmake')
            @if (isset($make))
                <form action="{{ route('superadmin.make.destroy', $make->id) }}" method="post">
                    @include('superadmin.modal.delete')
                </form>
            @endif
        </div>
        {{-- tab end  --}}
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="container mt-5">

                <div class="row align-items-center mb-4">
                    <div class="col-md-4 mb-md-0 mb-2">
                        <div class="input-group" style="width:100%">
                            <form id="dealerForm" action="" method="get" style="width:100%">
                                <select class="form-select  select-search formselect" name="bikemake_id"
                                    style="width:100%" style="color:black !important" aria-label="Search Dealer"
                                    aria-describedby="search-addon">
                                    <option selected>Select Make Name</option>
                                    <option value="0">All</option>
                                    @foreach ($bikemakes as $key => $make)
                                        <option value="{{ $make->id }}">{{ $make->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="col-md-8">
                        @if ($bikemakes->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                    @if ($bikemakes->onFirstPage())
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
                                                        value="{{ $bikemakes->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bikemakes->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($bikemakes->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $bikemakes->currentPage())
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

                                    @if ($bikemakes->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $bikemakes->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bikemakes->nextPageUrl() }}"
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
                            {{ ($bikemakes->currentPage() - 1) * $bikemakes->perPage() + 1 }}
                            - {{ min($bikemakes->currentPage() * $bikemakes->perPage(), $bikemakes->total()) }}
                            of {{ $bikemakes->total() }} Results
                        </span></div> --}}
                    <div class="col-md-8 text-end">
                        <button class="btn custom-btn-nav rounded" data-bs-toggle="modal"
                            data-bs-target="#addbikemakeModal">
                            <span> <i class="bi bi-plus fs-5 p-0 m-0 "></i></span> <span class="pb-3"> Add Make
                                Name</span>
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
                            @foreach ($bikemakes as $key => $make)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <a class=" me-2" title="Edit" data-bs-toggle="modal"
                                            data-bs-target="#editbikemakeModal{{ $make->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="primary-color-custom cancel" data-id="{{ $make->id }}"
                                            title="Delete" data-bs-toggle="modal"
                                            data-bs-target="#deletebikemakeModal{{ $make->id }}">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>

                                    <td><img @if ($make->icon) src="{{ $make->icon }}" @else src="{{ asset('web/images/toyota.png') }}" @endif
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

                                <div class="modal fade" id="editbikemakeModal{{ $make->id }}" tabindex="-1"
                                    aria-labelledby="colorModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header border-0" style="background-color:#F0F3F6">
                                                <h5 class="modal-title" id="colorModalLabel">Add Make</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="background-color:#F0F3F6">
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
                                                                    <input type="file"
                                                                        id="bike_make_icon{{ $make->id }}"
                                                                        name="icon" class="d-none"
                                                                        accept=".png, .jpg, .jpeg"
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
                                                                    <input type="text" class="form-control"
                                                                        name="name" value="{{ $make->name }}"
                                                                        id="bodyType" placeholder="Enter Make Name"
                                                                        required>
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
                                                        <button type="submit"
                                                            class="btn  custom-btn-nav rounded">Save</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- delete bike make modal  --}}

                                <div class="modal fade" id="deletebikemakeModal{{ $make->id }}" tabindex="-1"
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
                                                <h4 style="color:#281F48 !important;">Are you sure to delete this record?
                                                </h4>
                                                <div class="row mb-3">
                                                    <form action="{{ route('superadmin.bike-make.destroy', $make->id) }}"
                                                        method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <div class="col-sm-8">
                                                            <input type="hidden" class="form-control" name="deleted_id"
                                                                id="deleted_id" value="{{ $make->id }}" required>
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
                            <!-- Repeat this block for each row -->
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <div class="container my-2">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($bikemakes->currentPage() - 1) * $bikemakes->perPage() + 1 }}
                            - {{ min($bikemakes->currentPage() * $bikemakes->perPage(), $bikemakes->total()) }}
                            of {{ $bikemakes->total() }} Results
                        </span></div>
                    <div class="col-md-4">
                        @if ($bikemakes->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <!-- Page Info -->


                                <!-- Pagination -->
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                    @if ($bikemakes->onFirstPage())
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
                                                        value="{{ $bikemakes->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bikemakes->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($bikemakes->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $bikemakes->currentPage())
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

                                    @if ($bikemakes->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $bikemakes->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bikemakes->nextPageUrl() }}"
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
            @include('superadmin.modal.addmake')
            @if (isset($make))
                <form action="{{ route('superadmin.make.destroy', $make->id) }}" method="post">
                    @include('superadmin.modal.delete')
                </form>
            @endif

            <div class="modal fade" id="addbikemakeModal" tabindex="-1" aria-labelledby="colorModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header border-0" style="background-color:#F0F3F6">
                            <h5 class="modal-title" id="colorModalLabel">Add Make</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="background-color:#F0F3F6">
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
                                                accept=".png, .jpg, .jpeg, .svg"
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
                                            <input class="form-check-input" name="status" type="checkbox"
                                                id="activateFeature" checked>
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

            <script>
                $(document).ready(function() {
                    $('.model-datatable').each(function() {
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
                            else if (['Make Name']
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
