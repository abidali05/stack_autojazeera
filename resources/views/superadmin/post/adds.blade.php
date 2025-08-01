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

        .ads-column-search {
            width: 90px;
            font-size: 10px;
            border: 1px solid #D9D9D9;
            border-radius: 2px;
            padding: 2px;
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
    {{-- tabs navigaition  --}}
    <div class="container mt-3">
        <div class="row align-items-center mb-2">

            <div class="col-md-12">
                <h2 class="sec mb-0 primary-color-custom">Manage Car Ads </h2>
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
    <div class="tab-content " id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            {{-- tab start  --}}
            <div class="container ">
                <div class="row align-items-center mb-2">
                    {{--  <div class="col-md-4 mb-md-0 mb-2">
                        <div class="input-group" style="width: 100%;">
                            <form id="dealerForm" action="" method="get" style="width: 100%;">
                                <select class="form-select select-search formselect" name="carpost_id"
                                    style="width: 100%; color: black !important;" aria-label="Search Dealer"
                                    aria-describedby="search-addon">
                                    <option selected>Select Dealer</option>
                                    <option value="0">All</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div> 
                    </div> --}}
                    {{-- <div class="col-md-12">
                        @if ($posts->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <!-- Page Info -->


                                <!-- Pagination -->
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                    @if ($posts->onFirstPage())
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
                                                        value="{{ $posts->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $posts->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($posts->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $posts->currentPage())
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

                                    @if ($posts->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $posts->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $posts->nextPageUrl() }}"
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
                    <div class="col-md-3 mb-md-0 mb-2  d-none ">
                        <div class="input-group">
                            <form action="" method="get">
                                <input class="form-control form-lg  me-2 mysearch rounded" type="search" name="car_search"
                                    placeholder="Search" aria-label="Search">
                            </form>

                        </div>
                    </div>
                    {{-- <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
                            - {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
                            of {{ $posts->total() }} Results
                        </span></div> --}}
                    <div class="col-md-12 text-end d-flex justify-content-end align-items-center gap-2">
                        <a href="{{ route('superadmin.ads.create') }}" class="btn custom-btn-nav rounded">
                            Post an Ad
                        </a>
                        <!-- Export Button -->
                        {{-- <a href="{{ route('superadmin.adss.export') }}">
                            <button type="submit" class="btn btn-outline-success rounded ms-2">
                                <i class="bi bi-file-earmark-excel"></i> Export Excel
                            </button>
                        </a>
                        <!-- Import Button (triggers modal) -->
                        <button type="button" class="btn btn-outline-primary rounded ms-2" data-bs-toggle="modal"
                            data-bs-target="#importExcelModal">
                            <i class="bi bi-upload"></i> Import Excel
                        </button> --}}
                    </div>

                    <!-- Import Modal -->
                    {{-- <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importExcelModalLabel">Import Ads from Excel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('superadmin.ads.import') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="excelFile" class="form-label">Select Excel File (.xlsx)</label>
                                            <input type="file" class="form-control" id="excelFile" name="excel_file"
                                                accept=".xlsx,.xls" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="container py-3">
                {{-- <div class="row d-flex justify-content-between">
                    <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
                            - {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
                            of {{ $posts->total() }} Results
                        </span></div>
                    <div class="col-md-4">
                        @if ($posts->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <!-- Page Info -->


                                <!-- Pagination -->
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                    @if ($posts->onFirstPage())
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
                                                        value="{{ $posts->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $posts->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($posts->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $posts->currentPage())
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

                                    @if ($posts->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $posts->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $posts->nextPageUrl() }}"
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
                </div> --}}
            </div>
            <div class="container table-responsive">
                <div class="row">
                    <table class="table table-striped transparent-table align-middle ads-datatable">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Action</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Deleted On </th>
                                <th>Dealer Name</th>
                                <th>Dealer Email</th>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Year</th>
                                <th>Comment</th>
                                <th>Created On </th>
                                <th>Updated On</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $key => $post)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.ads.edit', $post->id) }}" class=" me-2"
                                            title="Edit" style="text-decoration:none;">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="#" class="primary-color-custom cancel" data-id="{{ $post->id }}"
                                            title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>

                                    <?php
                                    $main = $post->document->first();
                                    ?>
                                    <td>
                                        @if (isset($main->doc_name))
                                            <img src="{{ url('posts/doc/' . $main->doc_name) }}" class=""
                                                alt="..." width="50" height="50">
                                        @endif
                                    </td>

                                    <td>
                                        @if ($post->status == 0)
                                            <a href="#"><span class="badge text-bg-danger" data-bs-toggle="modal"
                                                    data-bs-target="#statusModal{{ $post->id }}">In Review</span></a>
                                        @elseif($post->status == '2')
                                            <a href="#"><span class="badge text-bg-danger" data-bs-toggle="modal"
                                                data-bs-target="#statusModal{{ $post->id }}">Rejected</span></a>@else<a
                                                href="#" data-bs-toggle="modal"
                                                data-bs-target="#statusModal{{ $post->id }}"> <span
                                                    class="badge text-bg-success">Active</span></a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($post->feature_ad == 0)
                                        <span class="badge text-bg-danger">No</span></a> @else<span
                                                class="badge text-bg-success">Yes</span></a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $post->deleted_at ? \Carbon\Carbon::parse($post->deleted_at)->format('d M Y') : '' }}
                                    </td>
                                    <td> {{ $post->dealer->name ?? '' }}</td>
                                    <td> {{ $post->dealer->email ?? '' }}</td>

                                    <td>{{ $post->makename }}</td>
                                    <td>{{ $post->modelname }}</td>
                                    <td>{{ $post->year }}</td>
                                    <td> {{ Str::limit($post->dealer_comment, 30, '...') }}
                                    </td>

                                    {{-- <td>  @if ($post->status == 0) <a href="{{route('superadmin.change_post_status',$post->id)}}"  ><span class="badge text-bg-danger">Inactive</span></a> @else<a href="{{route('superadmin.change_post_status',$post->id)}}"  > <span class="badge text-bg-success">Active</span></a> @endif</td> --}}

                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($post->created_at)->format('d M Y') }} </td>
                                    <td class="text-center">
                                        {{ $post->updated_at ? $post->updated_at->format('d M Y') : 'N/A' }}
                                    </td>
                                </tr>

                                <div class="modal fade" id="statusModal{{ $post->id }}" tabindex="-1"
                                    aria-labelledby="statusModalLabel{{ $post->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                            <div class="modal-header border-0"
                                                style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                                <h5 class="modal-title" id="statusModalLabel{{ $post->id }}">
                                                    <strong>Update Post
                                                        Status</strong>
                                                </h5>
                                                <button type="button" class="btn-close"
                                                    style="background-color: #D9D9D9 !important; color: #FD5631;"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">
                                                <form method="post"
                                                    action="{{ route('superadmin.change_posts_status') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                    <input type="hidden" name="vehicle_type" value="car">
                                                    <div class="mb-3">
                                                        <label for="postStatus{{ $post->id }}"
                                                            class="form-label">Select
                                                            Status*</label>
                                                        <select class="form-select" name="status"
                                                            style="background-color:white;color:#281F48"
                                                            id="postStatus{{ $post->id }}" required
                                                            onchange="toggleRejectionReason({{ $post->id }})">
                                                            <option value="0"
                                                                {{ $post->status == '0' ? 'selected' : '' }}>
                                                                Inactive</option>
                                                            <option value="1"
                                                                {{ $post->status == '1' ? 'selected' : '' }}>
                                                                Approved</option>
                                                            <option value="2"
                                                                {{ $post->status == '2' ? 'selected' : '' }}>
                                                                Rejected</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3 {{ $post->status != 2 ? 'd-none' : '' }}"
                                                        id="rejectionReasonContainer{{ $post->id }}">
                                                        <label for="rejectionReason{{ $post->id }}"
                                                            class="form-label">Rejection Reason*</label>
                                                        <textarea class="form-control" name="rejected_reason" style="line-height: 1 !important;"
                                                            id="rejectionReason{{ $post->id }}" placeholder="Enter reason for rejection" required>{{ $post->rejected_reason }}</textarea>
                                                    </div>
                                            </div>
                                            <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                                                <button type="button" class="btn btn-light px-4 py-2 "
                                                    style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-light px-4 py-2 "
                                                    style="background-color:white; font-weight:600; color: #281F48; border-radius: 5px;">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <div class="container py-3">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
                            - {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
                            of {{ $posts->total() }} Results
                        </span></div>
                    <div class="col-md-4">
                        @if ($posts->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <!-- Page Info -->


                                <!-- Pagination -->
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                    @if ($posts->onFirstPage())
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
                                                        value="{{ $posts->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $posts->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($posts->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $posts->currentPage())
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

                                    @if ($posts->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $posts->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $posts->nextPageUrl() }}"
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

            @if (isset($post))
                <form action="{{ route('superadmin.ads.destroy', $post->id) }}" method="post">
                    @method('DELETE')
                    @include('superadmin.modal.delete')
                </form>
            @endif
        </div>

        {{-- tab end  --}}
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            {{-- tab start  --}}
            <div class="container mt-3">
                <div class="row align-items-center mb-3">
                    <div class="col-md-4 mb-md-0 mb-2">
                        <div class="input-group" style="width: 100%;">
                            <form id="dealerForm" action="" method="get" style="width: 100%;">
                                <select class="form-select select-search formselect" name="bikepost_id"
                                    style="width: 100%; color: black !important;" aria-label="Search Dealer"
                                    aria-describedby="search-addon">
                                    <option selected>Select Dealer</option>
                                    <option value="0">All</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="col-md-8">
                        @if ($bike_posts->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                    @if ($bike_posts->onFirstPage())
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
                                                        value="{{ $bike_posts->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bike_posts->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($bike_posts->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $bike_posts->currentPage())
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

                                    @if ($bike_posts->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $bike_posts->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bike_posts->nextPageUrl() }}"
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
                    <div class="col-md-3 mb-md-0 mb-2  d-none ">
                        <div class="input-group">
                            <form action="" method="get">
                                <input class="form-control form-lg  me-2 mysearch rounded" type="search"
                                    name="bike_search" placeholder="Search" aria-label="Search">
                            </form>
                        </div>
                    </div>
                    {{-- <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($bike_posts->currentPage() - 1) * $bike_posts->perPage() + 1 }}
                            - {{ min($bike_posts->currentPage() * $bike_posts->perPage(), $bike_posts->total()) }}
                            of {{ $bike_posts->total() }} Results
                        </span></div> --}}
                    <div class="col-md-8 text-end">
                        <a href="{{ route('superadmin.ads.create') }}" class="btn custom-btn-nav rounded">
                            <span> <i class="bi bi-plus fs-5 p-0 m-0 "></i></span> <span class="pb-3"> Post an Ad</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="container table-responsive">
                <div class="row">
                    <table class="table table-striped transparent-table align-middle datatable">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Action</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Dealer Name</th>
                                <th>Dealer Email</th>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Year</th>
                                <th>Comment</th>
                                <th>Created On </th>
                                <th>Updated On</th>
                                <th>Deleted On </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Repeat this block for each row -->
                            @foreach ($bike_posts as $key => $post)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <a href="{{ url('superadmin/bike-ads/' . $post->id . '/edit') }}" class=" me-2"
                                            title="Edit" style="text-decoration:none;">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="#" class="primary-color-custom cancel"
                                            data-id="{{ $post->id }}" title="Delete" data-bs-toggle="modal"
                                            data-bs-target="#bikedeleteModal{{ $post->id }}">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>

                                    <td> <a href="{{ url('bike-details', $post->id) }}">
                                            @if (isset($main->doc_name))
                                                <img src="{{ $post->media[0]->file_path ?? asset('web/bikes/images/logo.svg') }}"
                                                    class="" alt="..." width="50" height="50">
                                            @endif
                                        </a>
                                    </td>

                                    <td>
                                        @if ($post->status == 0)
                                            <a href="#"><span class="badge text-bg-danger" data-bs-toggle="modal"
                                                    data-bs-target="#statusModal{{ $post->id }}">In Review</span></a>
                                        @elseif($post->status == '2')
                                            <a href="#"><span class="badge text-bg-danger" data-bs-toggle="modal"
                                                data-bs-target="#statusModal{{ $post->id }}">Rejected</span></a>@else<a
                                                href="#" data-bs-toggle="modal"
                                                data-bs-target="#statusModal{{ $post->id }}"> <span
                                                    class="badge text-bg-success">Active</span></a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($post->is_featured == 0)
                                        <span class="badge text-bg-danger">No</span></a> @else<span
                                                class="badge text-bg-success">Yes</span></a>
                                        @endif
                                    </td>
                                    <td> {{ @$post->dealer->name }}</td>
                                    <td> {{ @$post->dealer->email }}</td>
                                    <td>{{ $post->makename }}</td>
                                    <td>{{ $post->modelname }}</td>
                                    <td>{{ $post->year }}</td>
                                    <td> {{ Str::limit($post->description, 30, '...') }}
                                    </td>

                                    {{-- <td>  @if ($post->status == 0) <a href="{{route('superadmin.change_post_status',$post->id)}}"  ><span class="badge text-bg-danger">Inactive</span></a> @else<a href="{{route('superadmin.change_post_status',$post->id)}}"  > <span class="badge text-bg-success">Active</span></a> @endif</td> --}}

                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($post->created_at)->format('d M Y') }} </td>
                                    <td class="text-center">
                                        {{ $post->updated_at ? $post->updated_at->format('d M Y') : 'N/A' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $post->deleted_at ? \Carbon\Carbon::parse($post->deleted_at)->format('d M Y') : 'N/A' }}
                                    </td>

                                </tr>

                                <div class="modal fade" id="statusModal{{ $post->id }}" tabindex="-1"
                                    aria-labelledby="statusModalLabel{{ $post->id }}" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered">
                                        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                            <div class="modal-header border-0"
                                                style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                                <h5 class="modal-title" id="statusModalLabel{{ $post->id }}">
                                                    <strong>Update Post
                                                        Status</strong>
                                                </h5>
                                                <button type="button" class="btn-close"
                                                    style="background-color: #D9D9D9 !important; color: #FD5631;"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">
                                                <form method="post"
                                                    action="{{ route('superadmin.change_posts_status') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                    <input type="hidden" name="vehicle_type" value="bike">
                                                    <div class="mb-3">
                                                        <label for="bikepostStatus{{ $post->id }}"
                                                            class="form-label">Select
                                                            Status*</label>
                                                        <select class="form-select" name="status"
                                                            id="bikepostStatus{{ $post->id }}" required
                                                            onchange="toggleRejectionReason({{ $post->id }})">
                                                            <option value="0"
                                                                {{ $post->status == '0' ? 'selected' : '' }}>
                                                                Inactive</option>
                                                            <option value="1"
                                                                {{ $post->status == '1' ? 'selected' : '' }}>
                                                                Approved</option>
                                                            <option value="2"
                                                                {{ $post->status == '2' ? 'selected' : '' }}>
                                                                Rejected</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3 {{ $post->status != 2 ? 'd-none' : '' }}"
                                                        id="bikerejectionReasonContainer{{ $post->id }}">
                                                        <label for="rejectionReason{{ $post->id }}"
                                                            class="form-label">Rejection Reason*</label>
                                                        <textarea class="form-control" style="line-height:1 !important" name="rejected_reason"
                                                            id="rejectionReason{{ $post->id }}" placeholder="Enter reason for rejection" required>{{ $post->rejected_reason }}</textarea>
                                                    </div>
                                            </div>
                                            <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                                                <button type="button" class="btn btn-light px-4 py-2 "
                                                    style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-light px-4 py-2 "
                                                    style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade" id="bikedeleteModal{{ $post->id }}" tabindex="-1"
                                    aria-labelledby="addDealerModalLabel" aria-hidden="true">
                                    <div class="modal-dialog ">
                                        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                            <div class="modal-header border-0"
                                                style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                                <h5 class="modal-title" id="editDealerModalLabel"><strong>Delete </strong>
                                                </h5>
                                                <button type="button" class="btn-close"
                                                    style="background-color: #D9D9D9 !important; color: #FD5631;"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">
                                                <h4 style="color:#281F48 !important;">Are you sure to delete this record?
                                                </h4>
                                                <div class="row mb-3">
                                                    <form action="{{ url('superadmin/bike-ads/destroy') }}"
                                                        method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <div class="col-sm-8">
                                                            <input type="hidden" class="form-control" name="deleted_id"
                                                                id="deleted_id" value="{{ $post->id }}" required>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                                                <button type="button" class="btn btn-light px-4 py-2 "
                                                    style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-light px-4 py-2 "
                                                    style="background-color:white; font-weight:600; color: #281F48; border-radius: 5px;">Delete</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                </form>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="container py-3">
                {{-- <div class="row d-flex justify-content-between">
                    <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($bike_posts->currentPage() - 1) * $bike_posts->perPage() + 1 }}
                            - {{ min($bike_posts->currentPage() * $bike_posts->perPage(), $bike_posts->total()) }}
                            of {{ $bike_posts->total() }} Results
                        </span></div>
                    <div class="col-md-4">
                        @if ($bike_posts->hasPages())
                            <nav class="d-flex justify-content-end align-items-center">
                                <ul class="pagination"
                                    style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                    @if ($bike_posts->onFirstPage())
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
                                                        value="{{ $bike_posts->currentPage() - 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bike_posts->previousPageUrl() }}"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                            </li>
                                        @endif
                                    @endif

                                    @foreach ($bike_posts->links()->elements as $element)
                                        @if (is_string($element))
                                            <li style="display: inline-block;">
                                                <span
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                            </li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $bike_posts->currentPage())
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

                                    @if ($bike_posts->hasMorePages())
                                        @if (request()->isMethod('post'))
                                            <li style="display: inline-block;">
                                                <form method="POST" action="{{ url()->current() }}">
                                                    @csrf
                                                    <input type="hidden" name="page"
                                                        value="{{ $bike_posts->currentPage() + 1 }}">
                                                    <button type="submit"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                </form>
                                            </li>
                                        @else
                                            <li style="display: inline-block;">
                                                <a href="{{ $bike_posts->nextPageUrl() }}"
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
                </div> --}}
            </div>
            @if (isset($bike_post))
                <form action="{{ route('superadmin.ads.destroy', $bike_post->id) }}" method="post">
                    @include('superadmin.modal.delete')
                </form>
            @endif

        </div>
        {{-- tab end  --}}
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('select[id^="postStatus"], select[id^="bikepostStatus"]').forEach(function(
                select) {
                toggleRejectionReason(select); // on load

                select.addEventListener('change', function() {
                    toggleRejectionReason(this);
                });
            });

            function toggleRejectionReason(select) {
                const postId = select.id.replace('postStatus', '').replace('bikepostStatus', '');
                const reasonContainer = document.getElementById(`rejectionReasonContainer${postId}`) || document
                    .getElementById(`bikerejectionReasonContainer${postId}`);
                const reasonField = document.getElementById(`rejectionReason${postId}`);
                if (select.value === "2") {
                    reasonContainer.classList.remove('d-none');
                    reasonField.setAttribute('required', true);
                } else {
                    reasonContainer.classList.add('d-none');
                    reasonField.removeAttribute('required');
                }
            }
        });

        $(document).ready(function() {
            $('.ads-datatable').each(function() {
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
                    if (title === 'Featured') {
                        searchHtml =
                            '<select class="ads-column-search"><option value="">Any</option><option value="Yes">Yes</option><option value="No">No</option></select>';
                    }
                    // Create text inputs for other specified columns
                    else if (['Deleted On', 'Dealer Name', 'Dealer Email', 'Make', 'Model', 'Year']
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
