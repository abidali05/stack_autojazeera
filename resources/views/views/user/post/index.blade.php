@extends('layout.panel_layout.main')
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

        .form-select:disabled {
            background-color: #282435;
            border: none;
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
table.dataTable>thead>tr>th, table.dataTable>thead>tr>td {
   padding: 0px 10px 5px 10px; 
    border-bottom: 1px solid rgba(0, 0, 0, 0.3);
}
        /* For inline search version */
    </style>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4 d-flex align-items-center">

                <h2 class="sec mb-0 primary-color-custom">Manage Car Ads </h2>
            </div>
            <div class="col-md-8 text-end">
                <a href="{{ route('ads.create') }}" class="btn custom-btn-nav rounded">
                    <i class="bi bi-plus-circle"></i> Post an Ad
                </a>
            </div>
            <div class="col-md-12 mt-3 text-center row d-none">

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
    <div class="container my-2">

        <div class="row align-items-center ">
            <div class="col-md-4 "> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #281F48; font-weight:700;">
                    {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
                    - {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
                    of {{ $posts->total() }} Results
                </span></div>
            <div class="col-md-8">

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
                                        <input type="hidden" name="page" value="{{ $posts->currentPage() - 1 }}">
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

                        @if ($posts->hasMorePages())
                            @if (request()->isMethod('post'))
                                <li style="display: inline-block;">
                                    <form method="POST" action="{{ url()->current() }}">
                                        @csrf
                                        <input type="hidden" name="page" value="{{ $posts->currentPage() + 1 }}">
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

            </div>


        </div>
    </div>
    <div class="tab-content " id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="container">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show"
                        style="background: white !important ;color #281F48 !important" role="alert">
                        <p style="color: white; padding:unset; display:inline"> {{ session('success') }} </p>
                        <button type="button" class="btn-close btn btn-sm" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <!-- Modal Trigger Script -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                            errorModal.show();
                        });
                    </script>

                    <!-- Bootstrap Modal -->
                    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                <div class="modal-header"
                                    style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                    <h5 class="modal-title" id="errorModalLabel"><strong> Error</strong></h5>
                                    <button type="button" class="btn-close "
                                        style="background-color: #D9D9D9 !important; color: #FD5631;"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center" style="background-color: #F0F3F6; color: #FD5631;">
                                    <p style="color: #281F48; margin: 0;">{{ session('error') }}</p>
                                </div>
                                <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                                    <button type="button" class="btn btn-light px-4 py-2 "
                                        style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


                {{--  <div class="row align-items-center  ">
            <div class="col-md-4 mb-md-0 mb-2 ">
                
                <form id="dealerForm" action="" method="get">
                    <select class="form-select  select-search formselect" name="post_id" style="color:black !important"  aria-label="Search Dealer" aria-describedby="search-addon">
                        <option selected>Select Post</option>
                        <option value="0" >All</option>
                        @foreach ($posts as $post)
                        <option value="{{$post->id}}">{{$post->makename}}</option>
                  @endforeach
                    </select>
                    </form>
               
            </div> --}}

                <div class="col-md-12 text-end d-none">
                    <a href="{{ route('ads.create') }}" class="btn custom-btn-nav rounded">
                        <i class="bi bi-plus-circle"></i> Post an Ad
                    </a>
                </div>
            </div>
        </div>
        <div class="container table-responsive">
            <div class="row ">
                <table class="table table-striped transparent-table align-middle ads-datatable">
                    <thead>
                        <tr>
                            <th>Sr#</th>
                            <th>Action</th>
                            <th>Image</th>
                            <th>Featured</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>Comment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Repeat this block for each row -->
                        @foreach ($posts as $i => $post)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <a href="{{ route('ads.edit', $post->id) }}" class=" me-2"
                                        style="text-decoration: none" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a class="primary-color-custom cancel" data-id="{{ $post->id }}" title="Delete"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                                <?php
                                $main = $post->document->first();
                                
                                ?>
                                <td>
                                    @if (isset($main->doc_name))
                                        <img src="{{ url('posts/doc/' . $main->doc_name) }}" class="rounded"
                                            alt="..." width="50" height="50">
                                    @else
                                        no image
                                    @endif
                                </td>
                                <td>
                                    @if ($post->feature_ad == 0)
                                    <span class="badge text-bg-danger">No</span></a> @else<span
                                            class="badge text-bg-success">Yes</span></a>
                                    @endif
                                </td>
                                <td>{{ $post->makename }}</td>
                                <td>{{ $post->modelname }}</td>
                                <td>{{ $post->year }}</td>
                                <td> {{ Str::limit($post->dealer_comment, 50, '...') }}
                                </td>
                                <td>
                                    @if ($post->status == 0)
                                        <a><span class="badge text-bg-danger">In Review</span></a>
                                    @elseif($post->status == '2')
                                        <a href="#"><span class="badge text-bg-danger" data-bs-toggle="modal"
                                            data-bs-target="#statusModal{{ $post->id }}">Rejected</span></a>@else<a>
                                            <span class="badge text-bg-success">Active</span></a>
                                    @endif
                                </td>
                            </tr>

                            <div class="modal fade" id="statusModal{{ $post->id }}" tabindex="-1"
                                aria-labelledby="statusModalLabel{{ $post->id }}" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                        <div class="modal-header "
                                            style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                            <h5 class="modal-title" id="statusModalLabel{{ $post->id }}"><strong>Ad
                                                    Status</strong>
                                            </h5>
                                            <button type="button" class="btn-close"
                                                style="background-color: #D9D9D9 !important; color: #FD5631;"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">

                                            <div class="mb-3">
                                                <label for="postStatus{{ $post->id }}"
                                                    class="form-label">Status</label>
                                                <select class="form-select" name="status"
                                                    id="postStatus{{ $post->id }}" disabled>
                                                    <option value="1" {{ $post->status == '1' ? 'selected' : '' }}>
                                                        Approved</option>
                                                    <option value="2" {{ $post->status == '2' ? 'selected' : '' }}>
                                                        Rejected</option>
                                                    <option value="2" {{ $post->status == '0' ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </div>
                                            @if ($post->status == '2')
                                                <div class="mb-3" id="rejectionReasonContainer{{ $post->id }}">
                                                    <label for="rejectionReason{{ $post->id }}"
                                                        class="form-label">Rejection Reason</label>
                                                    <textarea class="form-control" style="    line-height: 1 !important; color:red !important" name="rejected_reason"
                                                        id="rejectionReason{{ $post->id }}" placeholder="Enter reason for rejection" disabled>{{ $post->rejected_reason }}</textarea>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                                            <button type="button" class="btn btn-light px-4 py-2 "
                                                style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                                data-bs-dismiss="modal">Cancel</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach



                    </tbody>
                </table>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center ">
                <div class="col-md-4 "> <span class="pt-md-3 pagination_count"
                        style="font-size: 18px; color: #281F48; font-weight:700;">
                        {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
                        - {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
                        of {{ $posts->total() }} Results
                    </span></div>
                <div class="col-md-8">

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

                </div>


            </div>
        </div>
        @if (isset($post))
            <form action="{{ route('ads.destroy', $post->id) }}" method="post">
                @include('superadmin.modal.delete')
            </form>
        @endif
    </div>
    {{-- tab end  --}}
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        {{-- tab start  --}}
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show text-white" style="background: #FD5631"
                    role="alert">
                    <p style="color: white; padding:unset; display:inline"> {{ session('success') }} </p>
                    <button type="button" class="btn-close btn btn-sm" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show text-white" style="background: #FD5631"
                    role="alert">
                    <p style="color: red; padding:unset; display:inline"> {{ session('error') }} </p>
                    <button type="button" class="btn-close btn btn-sm" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif
            <div class="row align-items-center my-lg-4">


                <div class="col-md-12 text-end">
                    <a href="{{ route('ads.create') }}" class="btn custom-btn-nav rounded">
                        <i class="bi bi-plus-circle"></i> Post an Ad
                    </a>
                </div>
            </div>
            <div class="row align-items-center  ">
                <div class="col-md-4 mb-md-0 mb-2 ">

                    <form id="dealerForm" action="" method="get">
                        <select class="form-select  select-search formselect" name="post_id"
                            style="color:black !important" aria-label="Search Dealer" aria-describedby="search-addon">
                            <option selected>Select Post</option>
                            <option value="0">All</option>
                            @foreach ($posts as $post)
                                <option value="{{ $post->id }}">{{ $post->makename }}</option>
                            @endforeach
                        </select>
                    </form>

                </div>

                <div class="col-md-12 text-end d-none">
                    <a href="{{ route('ads.create') }}" class="btn custom-btn-nav rounded">
                        <i class="bi bi-plus-circle"></i> Post an Ad
                    </a>
                </div>
            </div>
        </div>
        <div class="container table-responsive">
            <div class="row ">
                <table class="table table-striped transparent-table align-middle datatable">
                    <thead>
                        <tr>
                            <th>Sr#</th>
                            <th>Action</th>
                            <th>Image</th>
                            <th>Featured</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>Comment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $i => $post)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <a href="{{ route('ads.edit', $post->id) }}" class=" me-2"
                                        style="text-decoration: none" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a class="primary-color-custom cancel" data-id="{{ $post->id }}" title="Delete"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                                <?php
                                $main = $post->document->first();
                                ?>
                                <td> <a
                                        @if (Request::is('superadmin/*')) href="{{ route('superadmin.cardetail', $post->id) }}" @else href="{{ route('cardetail', $post->id) }}" @endif>
                                        @if (isset($main->doc_name))
                                            <img src="{{ url('posts/doc/' . $main->doc_name) }}" class="rounded"
                                                alt="..." width="50" height="50">
                                        @else
                                            no image
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    @if ($post->feature_ad == 0)
                                    <span class="badge text-bg-danger">No</span></a> @else<span
                                            class="badge text-bg-success">Yes</span></a>
                                    @endif
                                </td>
                                <td>{{ $post->makename }}</td>
                                <td>{{ $post->modelname }}</td>
                                <td>{{ $post->year }}</td>
                                <td> {{ Str::limit($post->dealer_comment, 50, '...') }}
                                </td>
                                <td>
                                    @if ($post->status == 0)
                                        <a><span class="badge text-bg-danger">Inactive</span></a>
                                    @elseif($post->status == '2')
                                        <a href="#"><span class="badge text-bg-danger" data-bs-toggle="modal"
                                            data-bs-target="#statusModal{{ $post->id }}">Rejected</span></a>@else<a>
                                            <span class="badge text-bg-success">Active</span></a>
                                    @endif
                                </td>

                            </tr>

                            <div class="modal fade" id="statusModal{{ $post->id }}" tabindex="-1"
                                aria-labelledby="statusModalLabel{{ $post->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                        <div class="modal-header"
                                            style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                            <h5 class="modal-title" id="statusModalLabel{{ $post->id }}"><strong> Ad
                                                    Status</strong>
                                            </h5>
                                            <button type="button" class="btn-close "
                                                style="background-color: #D9D9D9 !important; color: #FD5631;"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">

                                            <div class="mb-3">
                                                <label for="postStatus{{ $post->id }}"
                                                    class="form-label">Status</label>
                                                <select class="form-select" name="status"
                                                    id="postStatus{{ $post->id }}" disabled>
                                                    <option value="1" {{ $post->status == '1' ? 'selected' : '' }}>
                                                        Approved</option>
                                                    <option value="2" {{ $post->status == '2' ? 'selected' : '' }}>
                                                        Rejected</option>
                                                    <option value="2" {{ $post->status == '0' ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </div>
                                            @if ($post->status == '2')
                                                <div class="mb-3" id="rejectionReasonContainer{{ $post->id }}">
                                                    <label for="rejectionReason{{ $post->id }}"
                                                        class="form-label">Rejection Reason</label>
                                                    <textarea class="form-control" name="rejected_reason" id="rejectionReason{{ $post->id }}"
                                                        placeholder="Enter reason for rejection" disabled>{{ $post->rejected_reason }}</textarea>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                                            <button type="button" class="btn btn-light px-4 py-2 "
                                                style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                                data-bs-dismiss="modal">Cancel</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{ $posts->links('pagination::bootstrap-5') }}

                    </tbody>
                </table>
            </div>
        </div>
        @if (isset($post))
            <form action="{{ route('ads.destroy', $post->id) }}" method="post">
                @include('superadmin.modal.delete')
            </form>
        @endif
    </div>
    <script>
        if (window.location.pathname === '/ads') {
            localStorage.removeItem('storedImages');
            console.log("Cleared storedImages from localStorage.");
        }
        $(document).ready(function() {
            $('.ads-datatable').each(function() {
                var table = $(this).DataTable({
                    paging: false,
                    lengthChange: false,
                    searching: true,
                    info: false,
                    ordering: true,
                    language: {
                        search: "Search: "
                    }
                });

                // Add search row
                $(this).find('thead').append('<tr class="search-row"></tr>');

                $(this).find('thead th').each(function(index) {
                    var title = $(this).text().trim();
                    var searchHtml = '';

                    // Custom search for Featured column (Yes/No dropdown)
                    if (title === 'Featured') {
                        searchHtml = `
                    <select class="ads-column-search">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                `;
                    }
                    // Custom search for Year column (numeric input)
                    else if (title === 'Year') {
                        searchHtml = `
                    <input type="number" 
                           placeholder="Search Year" 
                           class="ads-column-search" 
                           min="1900" 
                           max="${new Date().getFullYear() + 1}">
                `;
                    }
                    // Regular text search for Make and Model
                    else if (['Make', 'Model'].includes(title)) {
                        searchHtml =
                            `<input type="text" placeholder="Search ${title}" class="ads-column-search"/>`;
                    }

                    $(this).closest('thead').find('.search-row').append(
                        '<th>' + searchHtml + '</th>'
                    );
                });

                // Apply search functionality
                $(this).find('.search-row select, .search-row input').on('keyup change', function() {
                    var columnIndex = $(this).closest('th').index();
                    table.column(columnIndex).search(this.value).draw();
                });
            });
        });
    </script>

@endsection
