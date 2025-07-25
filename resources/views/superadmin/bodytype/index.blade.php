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
        div.dt-container .dt-length, div.dt-container .dt-search, div.dt-container .dt-info, div.dt-container .dt-processing, div.dt-container .dt-paging {
    color: inherit;
    display: flex
;
    justify-content: end;
}
    </style>
    {{-- tabs navigaition  --}}
    <div class="container mt-5">
        <div class="row align-items-center mb-4">

            <div class="col-md-12">
                <h2 class="sec mb-0 primary-color-custom">Manage Body Type</h2>
            </div>
            <div class="col-md-12 text-end">

                <button class="btn custom-btn-nav rounded text-white" data-bs-toggle="modal" data-bs-target="#featureModal">
                    <span> <i class="bi bi-plus fs-5 p-0 m-0 text-white"></i></span> <span class="pb-3 text-white"> Add Body
                        Type</span>
                </button>
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
            <div class="container mt-5">

                {{-- <div class="row align-items-center mb-4">
                  
					          <div class="col-4"> <span class="pt-md-3 pagination_count"
                                style="font-size: 18px; color: #281F48; font-weight:700;">
                                {{ ($bodytypes->currentPage() - 1) * $bodytypes->perPage() + 1 }}
                                - {{ min($bodytypes->currentPage() * $bodytypes->perPage(), $bodytypes->total()) }}
                                of {{ $bodytypes->total() }} Results
                            </span></div>
                    <div class="col-8">
                 
                            <nav class="d-flex justify-content-end align-items-center">
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">

                                    @if ($bodytypes->onFirstPage())
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
                                                        value="{{ $bodytypes->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bodytypes->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($bodytypes->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $bodytypes->currentPage())
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

                                    @if ($bodytypes->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $bodytypes->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bodytypes->nextPageUrl() }}"
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
                </div> --}}
            </div>
            <div class="container table-responsive">
                <div class="row">
                    <table class="table table-striped transparent-table align-middle bodytype-datatable">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Action</th>
                                <th>Icon</th>
                                <th>Body Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Repeat this block for each row -->
                            @foreach ($bodytypes as $key => $type)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <a class=" me-2" title="Edit" data-bs-toggle="modal" style="text-decoration:none"
                                            data-bs-target="#editbodytypeModal{{ $type->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="primary-color-custom cancel" data-id="{{ $type->id }}" title="Delete"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>

                                    <td><img @if ($type->icon) src="{{ asset('posts/bodytypes/' . $type->icon) }}" @else src="{{ asset('web/images/car-icon.png') }}" @endif
                                            alt="" srcset="" width="40" height="30"></td>
                                    <td>{{ $type->name }}</td>
                                    <td>
                                        @if ($type->status == 0)
                                            <span class="badge text-bg-danger">Inactive</span>
                                        @else
                                            <span class="badge text-bg-active">Active</span>
                                        @endif

                                    </td>
                                    @include('superadmin.modal.editbodytype')
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="container my-2">
                <div class="row d-flex justify-content-between">
                    <div class="col-4"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($bodytypes->currentPage() - 1) * $bodytypes->perPage() + 1 }}
                            - {{ min($bodytypes->currentPage() * $bodytypes->perPage(), $bodytypes->total()) }}
                            of {{ $bodytypes->total() }} Results
                        </span></div>
                    <div class="col-4">
                      
                            <nav class="d-flex justify-content-end align-items-center">
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">

                                    @if ($bodytypes->onFirstPage())
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
                                                        value="{{ $bodytypes->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bodytypes->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($bodytypes->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $bodytypes->currentPage())
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

                                    @if ($bodytypes->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $bodytypes->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bodytypes->nextPageUrl() }}"
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
            @include('superadmin.modal.addbodytype')

            @if (isset($type))
                <form action="{{ route('superadmin.bodytype.destroy', $type->id) }}" method="post">
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
                                <select class="form-select  select-search formselect"
                                    style="width:100%; background-color:#1F1B2D" name="bikebodytype_id"
                                    style="color:black !important" aria-label="Search Dealer"
                                    aria-describedby="search-addon">
                                    <option selected>Select body type</option>
                                    <option value="0">All</option>
                                    @foreach ($bikebodytypes as $key => $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="col-4">
                        @if ($bikebodytypes->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">

                                    @if ($bikebodytypes->onFirstPage())
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
                                                        value="{{ $bikebodytypes->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bikebodytypes->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif
                                    @foreach ($bikebodytypes->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $bikebodytypes->currentPage())
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

                                    @if ($bikebodytypes->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $bikebodytypes->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bikebodytypes->nextPageUrl() }}"
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
                    {{-- <div class="container mt-2">
                        <div class="col-4"> <span class="pt-md-3 pagination_count"
                                style="font-size: 18px; color: #281F48; font-weight:700;">
                                {{ ($bikebodytypes->currentPage() - 1) * $bikebodytypes->perPage() + 1 }}
                                -
                                {{ min($bikebodytypes->currentPage() * $bikebodytypes->perPage(), $bikebodytypes->total()) }}
                                of {{ $bikebodytypes->total() }} Results
                            </span></div>
                    </div> --}}
                    <div class="col-md-12 text-end">

                        <button class="btn custom-btn-nav rounded" data-bs-toggle="modal"
                            data-bs-target="#addbikeBodyTypeModal">
                            <span> <i class="bi bi-plus fs-5 p-0 m-0 "></i></span> <span class="pb-3"> Add Body
                                Type</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="container table-responsive ">
                <div class="row">
                    <table class="table table-striped transparent-table align-middle bodytype-datatable">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Action</th>
                                <th>Icon</th>
                                <th>Body Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Repeat this block for each row -->
                            @foreach ($bikebodytypes as $key => $type)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <a class=" me-2" title="Edit" data-bs-toggle="modal" style="text-decoration:none"
                                            data-bs-target="#editBikebodytypeModal{{ $type->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="primary-color-custom cancel" data-id="{{ $type->id }}"
                                            title="Delete" data-bs-toggle="modal"
                                            data-bs-target="#deletebikebodytypeModal{{ $type->id }}">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>

                                    <td><img @if ($type->icon) src="{{ $type->icon }}" @else src="{{ asset('web/images/car-icon.png') }}" @endif
                                            alt="" srcset="" width="40" height="30"></td>
                                    <td>{{ $type->name }}</td>
                                    <td>
                                        @if ($type->status == 0)
                                            <span class="badge text-bg-danger">Inactive</span>
                                        @else
                                            <span class="badge text-bg-active">Active</span>
                                        @endif

                                    </td>

                                </tr>
                                <div class="modal fade" id="editBikebodytypeModal{{ $type->id }}" tabindex="-1"
                                    aria-labelledby="featureModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header border-0" style="background-color:#F0F3F6">
                                                <h5 class="modal-title" id="featureModalLabel">Add Body Type</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="background-color:#F0F3F6">
                                                <form id="bodytypeform" method="post"
                                                    action="{{ route('superadmin.bike-bodytype.update', $type->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <!-- Left Side: Upload Icon -->
                                                        <div class="col-md-6 text-center">
                                                            <div class="upload-area border border-dashed rounded p-4 text-center"
                                                                onclick="document.getElementById('bike_bodytype_icon{{ $type->id }}').click();">
                                                                <p class="mb-0">Click here to upload Icon</p>
                                                                <input type="file"
                                                                    id="bike_bodytype_icon{{ $type->id }}"
                                                                    name="icon" class="d-none"
                                                                    accept=".png, .jpg, .jpeg, .gif, .ico, .svg"
                                                                    onchange="handlebodytypeimageUpload(this, 'bike_bodytype_icon_preview{{ $type->id }}')">
                                                            </div>
                                                            <div id="bike_bodytype_icon_preview{{ $type->id }}"
                                                                class="mt-3 text-success image-preview"></div>
                                                        </div>

                                                        <!-- Right Side: Input Fields -->
                                                        <div class="col-md-6">

                                                            <div class="mb-3">
                                                                <label for="bodyType" class="form-label">Enter Body
                                                                    Type</label>
                                                                <input type="text" class="form-control" name="name"
                                                                    value="{{ $type->name }}" id="bodyType"
                                                                    placeholder="Enter Body Type" required>
                                                            </div>

                                                            <div class="form-check form-switch mb-3">
                                                                <input class="form-check-input" name="status"
                                                                    {{ $type->status == 1 ? 'checked' : '' }}
                                                                    type="checkbox" id="activateFeature">
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


                                {{-- delete bike body type modal --}}

                                <div class="modal fade" id="deletebikebodytypeModal{{ $type->id }}" tabindex="-1"
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
                                                    <form
                                                        action="{{ route('superadmin.bike-bodytype.destroy', $type->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="col-sm-8">
                                                            <input type="hidden" class="form-control" name="deleted_id"
                                                                id="deleted_id" name="{{ $type->id }}" required>
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
            <div class="container my-2">
                {{-- <div class="row d-flex justify-content-between">
                    <div class="col-4"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($bikebodytypes->currentPage() - 1) * $bikebodytypes->perPage() + 1 }}
                            - {{ min($bikebodytypes->currentPage() * $bikebodytypes->perPage(), $bikebodytypes->total()) }}
                            of {{ $bikebodytypes->total() }} Results
                        </span></div>
                    <div class="col-4">

                        <nav class="d-flex justify-content-end align-items-center">
                            <ul class="pagination"
                                style="display: flex; list-style: none; gap: 5px; padding: 0; margin: 0; justify-content: center;">

                                @if ($models->onFirstPage())
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; opacity: 0.5;">&laquo;</span>
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
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; text-decoration: none;">&laquo;</a>
                                        </li>
                                    @endif
                                @endif

                                @foreach ($models->links()->elements as $element)
                                    @if (is_string($element))
                                        <li style="display: inline-block;">
                                            <span
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                        </li>
                                    @endif

                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $models->currentPage())
                                                <li style="display: inline-block;">
                                                    <span
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #281F48; color: #fff;">{{ $page }}</span>
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
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; text-decoration: none;">{{ $page }}</a>
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
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; text-decoration: none;">&raquo;</a>
                                        </li>
                                    @endif
                                @else
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; opacity: 0.5;">&raquo;</span>
                                    </li>
                                @endif

                            </ul>
                        </nav>

                    </div>
                </div> --}}
            </div>
            @include('superadmin.modal.addbodytype')

            @if (isset($type))
                <form action="{{ route('superadmin.bodytype.destroy', $type->id) }}" method="post">
                    @include('superadmin.modal.delete')
                </form>
            @endif
        </div>
    </div>


    {{-- add bike body type modal --}}

    {{-- add body type modal  --}}

    <div class="modal fade" id="addbikeBodyTypeModal" tabindex="-1" aria-labelledby="addBodyTypeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="background-color:#F0F3F6">

            <div class="modal-content">
                <div class="modal-header border-0" style="background-color:#F0F3F6">
                    <h5 class="modal-title" id="addBodyTypeModalLabel">Add Body Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color:#F0F3F6">
                    <form id="featureForm" method="post" action="{{ route('superadmin.bike-bodytype.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Left Side: Upload Icon -->
                            <div class="col-md-6 text-center">
                                <div class="upload-area border border-dashed rounded p-4 text-center"
                                    onclick="document.getElementById('bike_bodytype_icon').click();">
                                    <p class="mb-0">Click here to upload Icon</p>
                                    <input type="file" id="bike_bodytype_icon" name="icon" class="d-none"
                                        accept=".png, .jpg, .jpeg, .gif, .ico, .svg"
                                        onchange="handlebodytypeimageUpload(this, 'bike_bodytype_icon_preview')">
                                </div>
                                <div id="bike_bodytype_icon_preview" class="mt-3 text-success"></div>
                            </div>

                            <!-- Right Side: Input Fields -->
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="bodyType" class="form-label">Enter Body Type</label>
                                    <input type="text" class="form-control" name="name" id="bodyType"
                                        placeholder="Enter Body Type" required>
                                </div>

                                <div class="form-check form-switch mb-3">
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

    <script>
        $(document).ready(function() {
            $('.bodytype-datatable').each(function() {
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
            });
        });
    </script>
@endsection
