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

   .ads-column-search {
    width: 90px;
    font-size: 10px;
    border: 1px solid #D9D9D9;
    border-radius: 2px;
    padding: 2px;
}
.bike-column-search {
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
        div.dt-container .dt-length, div.dt-container .dt-search, div.dt-container .dt-info, div.dt-container .dt-processing, div.dt-container .dt-paging {
    color: inherit;
    display: flex
;
    justify-content: end;
}</style>
    <div class="container mt-3">
        @if (session('success'))
            <!-- Modal Trigger Script -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();
                });
            </script>

            <!-- Bootstrap Modal -->
            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                        <div class="modal-header"
                            style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                            <h5 class="modal-title" id="successModalLabel"><strong> Success</strong></h5>
                            <button type="button" class="btn-close "
                                style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="background-color: #F0F3F6; color: #FD5631;">
                            <p style="margin: 0; color:#281F48;">{{ session('success') }}</p>
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


        @if (session('error'))
            <!-- Modal Trigger Script -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    errorModal.show();
                });
            </script>

            <!-- Bootstrap Modal -->
            <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                        <div class="modal-header"
                            style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                            <h5 class="modal-title" id="errorModalLabel"><strong> Error</strong></h5>
                            <button type="button" class="btn-close"
                                style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center" style="background-color: #F0F3F6; color: #FD5631;">
                            <p style="color: #281F48; margin: 0;">{{ session('error') }}</p>
                        </div>
                        <div class="modal-footer justify-content-center border-0 p-0 pb-3 ">
                            <button type="button" class="btn btn-light px-4 py-2 "
                                style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row align-items-center ">

            <div class="col-md-6 d-flex align-items-center">

                <h2 class="sec mb-0 primary-color-custom">Manage Bike Ads </h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('bike_ads.create') }}" class="btn custom-btn-nav rounded">
                    <i class="bi bi-plus-circle"></i> Post an Ad
                </a>
            </div>
        </div>
        {{-- <div class="row align-items-center  ">
            <div class="col-md-4 mb-md-0 mt-3 mb-2 ">

                <form id="dealerForm" action="" method="get">
                    <select class="form-select  select-search formselect" name="post_id" style="color:black !important"
                        aria-label="Search Dealer" aria-describedby="search-addon">
                        <option selected>Select Post</option>
                        <option value="0">All</option>
                        @foreach ($posts as $post)
                            <option value="{{ $post->id }}">{{ $post->makename }}</option>
                        @endforeach
                    </select>
                </form>

            </div>

            <div class="col-md-12 text-end d-none">
                <a href="{{ route('bike_ads.create') }}" class="btn custom-btn-nav rounded">
                    <i class="bi bi-plus-circle"></i> Post an Ad
                </a>
            </div>
        </div> --}}
    </div>
    <div class="container my-2">

        <div class="row align-items-center ">
            {{-- <div class="col-md-4 "> <span class="pt-md-3 pagination_count"
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
            </div> --}}
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

                                <a href="{{ route('bike_ads.edit', $post->id) }}" class=" me-2"
                                    style="text-decoration: none" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <a class="primary-color-custom cancel" data-id="{{ $post->id }}" title="Delete"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $post->id }}">
                                    <i class="bi bi-trash"></i>
                                </a>


                            </td>

                            <td>
                                {{-- <a
                                    @if (Request::is('superadmin/*')) href="{{ route('superadmin.cardetail', $post->id) }}" @else href="{{ route('cardetail', $post->id) }}" @endif>
                                    @if (isset($main->doc_name)) --}}
                                <img src="{{ $post->media ? $post->media[0]->file_path : '' }}" class="rounded"
                                    alt="..." width="50" height="50">
                                {{-- @else
                                        no image
                                    @endif
                                </a> --}}
                            </td>
                            <td>
                                @if ($post->is_featured == 0)
                                <span class="badge text-bg-danger">No</span></a> @else<span
                                        class="badge text-bg-success">Yes</span></a>
                                @endif
                            </td>
                            <td>{{ $post->makename }}</td>
                            <td>{{ $post->modelname }}</td>
                            <td>{{ $post->year }}</td>
                            <td style="color:#FF0000 !important; font-weight:500">
                                {{ Str::limit($post->description, 50, '...') }}
                            </td>
                            <td>
                                @if ($post->status == 0)
                                    <a href="#"><span class="badge text-bg-danger">In Review</span></a>
                                @elseif($post->status == '2')
                                    <a><span class="badge text-bg-danger" data-bs-toggle="modal"
                                        data-bs-target="#statusModal{{ $post->id }}">Rejected</span></a>@else<a>
                                        <span class="badge text-bg-success">Active</span></a>
                                @endif
                            </td>

                        </tr>

                        <div class="modal fade" id="statusModal{{ $post->id }}" tabindex="-1"
                            aria-labelledby="statusModalLabel{{ $post->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                    <div class="modal-header "
                                        style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                        <h5 class="modal-title" id="statusModalLabel{{ $post->id }}"><strong> Ad
                                                Status</strong></h5>
                                        <button type="button" class="btn-close"
                                            style="background-color: #D9D9D9 !important; color: #FD5631;"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">

                                        <div class="mb-3">
                                            <label for="postStatus{{ $post->id }}"
                                                class="form-label text-white">Status</label>
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
                                                    class="form-label text-white">Rejection Reason</label>
                                                <textarea class="form-control" style="color:red !important ;     line-height: 1 !important;" name="rejected_reason"
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


                        {{-- delete modal starts  --}}

                        <div class="modal fade" id="deleteModal{{ $post->id }}" tabindex="-1"
                            aria-labelledby="addDealerModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                    <div class="modal-header border-0"
                                        style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                        <h5 class="modal-title" id="editDealerModalLabel"> <strong> Delete</strong></h5>
                                        <button type="button" class="btn-close"
                                            style="background-color: #D9D9D9 !important; color: #FD5631;"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">
                                        <h4 style="color:#281F48 !important">Are you sure to delete this record? </h4>
                                        <div class="row mb-3">

                                            <div class="col-sm-8">
                                                <input type="hidden" class="form-control" name="deleted_id"
                                                    id="deleted_id" name="dealershipName" required>
                                            </div>
                                        </div>




                                    </div>
                                    <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                                        <form action="{{ route('bike_ads.destroy', $post->id) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button" class="btn btn-light px-4 py-2 "
                                                style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-light px-4 py-2 "
                                                style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;">Delete</button>
                                        </form>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        {{-- delete modal ends  --}}
                    @endforeach



                </tbody>
            </table>
        </div>
    </div>
    {{-- <div class="container my-2">

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
    </div> --}}

    <script>
        if (window.location.pathname === '/ads') {
            localStorage.removeItem('storedImages');
            console.log("Cleared storedImages from localStorage.");
        }
        
        $(document).ready(function() {
            $('.ads-datatable').each(function() {
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

                    // Custom search for Featured column (Yes/No dropdown)
                    if (title === 'Featured') {
                        searchHtml = `
                    <select class="bike-column-search">
                        <option value="">Any</option>
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
                    else if (['Dealer Name','Make', 'Model'].includes(title)) {
                        searchHtml =
                            `<input type="text" placeholder="Search ${title}" class="bike-column-search"/>`;
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
