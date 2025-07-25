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
    <!-- back header start -->
    <div class="container mt-3">
        <div class="row align-items-center mb-2">

            <div class="col-md-12">
                <h2 class="sec mb-0 primary-color-custom">Manage Color</h2>
            </div>
        </div>
        <div class="row align-items-center mb-2">
            {{--      <div class="col-md-4 mb-md-0 mb-2">
             <div class="input-group" style="width: 100%;">
        <form id="dealerForm" action="" method="get" style="width:100% ;">
            <select class="form-select select-search formselect" 
                    name="color_id" 
                    style="color: black !important; width: 100%; padding:10px !important" 
                    aria-label="Search Dealer" 
                    aria-describedby="search-addon">
                <option selected>Select Color</option>
                <option value="0">All</option>
                @foreach ($colors as $key => $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endforeach
            </select>
        </form>
    </div>
            </div> --}}
            <div class="col-md-12 d-flex justify-content-end">
                <button class="btn custom-btn-nav rounded" data-bs-toggle="modal" data-bs-target="#colorModal">
                    <i class="bi bi-plus fs-5 p-0 m-0 "></i> Add New Color
                </button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-between">
            {{-- <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #281F48; font-weight:700;">
                    {{ ($colors->currentPage() - 1) * $colors->perPage() + 1 }}
                    - {{ min($colors->currentPage() * $colors->perPage(), $colors->total()) }}
                    of {{ $colors->total() }} Results
                </span></div> --}}
            {{-- <div class="col-md-4">
                <nav class="d-flex justify-content-end align-items-center">

                    <!-- Pagination -->
                    <ul class="pagination"
                        style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                        @if ($colors->onFirstPage())
                            <li style="display: inline-block;">
                                <span
                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</span>
                            </li>
                        @else
                            @if (request()->isMethod('post'))
                                <li style="display: inline-block;">
                                    <form method="POST" action="{{ url()->current() }}">
                                        @csrf
                                        <input type="hidden" name="page" value="{{ $colors->currentPage() - 1 }}">
                                        <button type="submit"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                    </form>
                                </li>
                            @else
                                <li style="display: inline-block;">
                                    <a href="{{ $colors->previousPageUrl() }}"
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                </li>
                            @endif
                        @endif

                        @foreach ($colors->links()->elements as $element)
                            @if (is_string($element))
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                </li>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $colors->currentPage())
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

                        @if ($colors->hasMorePages())
                            @if (request()->isMethod('post'))
                                <li style="display: inline-block;">
                                    <form method="POST" action="{{ url()->current() }}">
                                        @csrf
                                        <input type="hidden" name="page" value="{{ $colors->currentPage() + 1 }}">
                                        <button type="submit"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                    </form>
                                </li>
                            @else
                                <li style="display: inline-block;">
                                    <a href="{{ $colors->nextPageUrl() }}"
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
            <div class="container table-responsive ">
                <div class="row">
                    <table class="table table-striped transparent-table align-middle color-datatable">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Action</th>
                                <th>Name</th>
                                <th>Color</th>
                                <!-- <th>Status</th> -->
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($colors as $key => $color)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <a class=" me-2" title="Edit" data-bs-toggle="modal" style="text-decoration:none"
                                            data-bs-target="#editcolorModal{{ $color->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a class="primary-color-custom cancel" data-id="{{ $color->id }}" title="Delete"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                    <td>{{ $color->name }}</td>
                                    <td>
                                        <input type="color" id="favcolor" name="code" value="{{ $color->color_id }}"
                                            disabled>
                                    </td>
                                </tr>
                                @include('superadmin.modal.editcolor')
                            @endforeach

                        </tbody>
                    </table>
                </div>


            </div>
            {{-- <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                            style="font-size: 18px; color: #281F48; font-weight:700;">
                            {{ ($colors->currentPage() - 1) * $colors->perPage() + 1 }}
                            - {{ min($colors->currentPage() * $colors->perPage(), $colors->total()) }}
                            of {{ $colors->total() }} Results
                        </span></div>
                    <div class="col-md-4">
                        <nav class="d-flex justify-content-end align-items-center">
                            <!-- Page Info -->


                            <!-- Pagination -->
                            <ul class="pagination"
                                style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                @if ($colors->onFirstPage())
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
                                                    value="{{ $colors->currentPage() - 1 }}">
                                                <button type="submit"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                            </form>
                                        </li>
                                    @else
                                        <li style="display: inline-block;">
                                            <a href="{{ $colors->previousPageUrl() }}"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                        </li>
                                    @endif
                                @endif

                                @foreach ($colors->links()->elements as $element)
                                    @if (is_string($element))
                                        <li style="display: inline-block;">
                                            <span
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                        </li>
                                    @endif

                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $colors->currentPage())
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

                                @if ($colors->hasMorePages())
                                    @if (request()->isMethod('post'))
                                        <li style="display: inline-block;">
                                            <form method="POST" action="{{ url()->current() }}">
                                                @csrf
                                                <input type="hidden" name="page"
                                                    value="{{ $colors->currentPage() + 1 }}">
                                                <button type="submit"
                                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                            </form>
                                        </li>
                                    @else
                                        <li style="display: inline-block;">
                                            <a href="{{ $colors->nextPageUrl() }}"
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
            @include('superadmin.modal.addcolor')
            @if (isset($color))
                <form action="{{ route('superadmin.color.destroy', $color->id) }}" method="post">
                    @include('superadmin.modal.delete')
                </form>
            @endif
            <script>
        $(document).ready(function() {
            $('.color-datatable').each(function() {
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

