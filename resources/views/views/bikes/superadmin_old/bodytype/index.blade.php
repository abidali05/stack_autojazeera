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
    <div class="container mt-5">
        <div class="row align-items-center mb-4">
            <div class="col-auto">
                <a href="{{ route('superadmin.dashboard') }}" class="text-white me-3">
                    <img src="{{ asset('web/images/icon.svg') }}" alt="back-arrow" width="50px" height="35px">
                </a>
            </div>
            <div class="col-auto">
                <h2 class="sec mb-0 primary-color-custom">Manage Bike Body Type</h2>
            </div>
        </div>
        <div class="row align-items-center mb-4">
            <div class="col-md-4 mb-md-0 mb-2">
                <div class="input-group" style="width:100%">
                    <form id="dealerForm" action="" method="get" style="width:100%">
                        <select class="form-select  select-search formselect" style="width:100%; background-color:#1F1B2D"
                            name="bodytype_id" style="color:black !important" aria-label="Search Dealer"
                            aria-describedby="search-addon">
                            <option selected>Select body type</option>
                            <option value="0">All</option>
                            @foreach ($bodytypes as $key => $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <div class="col-4">
                @if ($bodytypes->hasPages())
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($bodytypes->onFirstPage())
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
                                        <a href="{{ $bodytypes->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($bodytypes->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $bodytypes->currentPage())
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

                            @if ($bodytypes->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $bodytypes->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $bodytypes->nextPageUrl() }}"
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
            <div class="container mt-2">
                <div class="col-4"> <span class="pt-md-3 pagination_count"
                        style="font-size: 18px; color: #FD5631; font-weight:700;">
                        {{ ($bodytypes->currentPage() - 1) * $bodytypes->perPage() + 1 }}
                        - {{ min($bodytypes->currentPage() * $bodytypes->perPage(), $bodytypes->total()) }}
                        of {{ $bodytypes->total() }} Results
                    </span></div>
            </div>
            <div class="col-md-12 text-end">

                <button class="btn custom-btn-nav rounded" data-bs-toggle="modal" data-bs-target="#addBodyTypeModal">
                    <span> <i class="bi bi-plus fs-5 p-0 m-0 "></i></span> <span class="pb-3"> Add Body Type</span>
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
                                <a class="text-white me-2" title="Edit" data-bs-toggle="modal"
                                    style="text-decoration:none" data-bs-target="#editBikebodytypeModal{{ $type->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a class="primary-color-custom cancel" data-id="{{ $type->id }}" title="Delete"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>

                            <td><img @if ($type->icon) src="{{ asset('posts/bodytypes/bikes/' . $type->icon) }}" @else src="{{ asset('web/images/car-icon.png') }}" @endif
                                    alt="" srcset="" width="40" height="30"></td>
                            <td>{{ $type->name }}</td>
                            <td>
                                @if ($type->status == 0)
                                    <span class="badge text-bg-danger">Inactive</span>
                                @else
                                    <span class="badge text-bg-active">Active</span>
                                @endif

                            </td>
                            <div class="modal fade" id="editBikebodytypeModal{{$type->id}}" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title" id="featureModalLabel">Add Body Type</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="bodytypeform" method="post" action="{{route('superadmin.bike-bodytype.update',$type->id)}}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <!-- Left Side: Upload Icon -->
                                                    <div class="col-md-6 text-center">
                                                    <div class="upload-area border border-dashed rounded p-4 text-center"
                                                        onclick="document.getElementById('bike_bodytype_icon{{$type->id}}').click();">
                                                        <p class="mb-0">Click here to upload Icon</p>
                                                        <input type="file" id="bike_bodytype_icon{{$type->id}}" name="icon" class="d-none"
                                                            accept=".png, .jpg, .jpeg, .gif, .ico, .svg"
                                                            onchange="handlebodytypeimageUpload(this, 'bike_bodytype_icon_preview{{$type->id}}')">
                                                    </div>
                                                    <div id="bike_bodytype_icon_preview{{$type->id}}" class="mt-3 text-success image-preview"></div>
                                                </div>
                        
                                                    <!-- Right Side: Input Fields -->
                                                    <div class="col-md-6">
                                                       
                                                        <div class="mb-3">
                                                            <label for="bodyType" class="form-label">Enter Body Type</label>
                                                            <input type="text" class="form-control" name="name" value="{{$type->name}}" id="bodyType" placeholder="Enter Body Type"
                                                                required>
                                                        </div>
                        
                                                        <div class="form-check form-switch mb-3">
                                                            <input class="form-check-input" name="status" {{$type->status == 1?"checked":""}} type="checkbox" id="activateFeature" >
                                                            <label class="form-check-label"  for="activateFeature">Activate</label>
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
                         
                            
                        </tr>
                    @endforeach
                    <!-- Repeat this block for each row -->



                </tbody>
            </table>
        </div>


    </div>
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-4"> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #FD5631; font-weight:700;">
                    {{ ($bodytypes->currentPage() - 1) * $bodytypes->perPage() + 1 }}
                    - {{ min($bodytypes->currentPage() * $bodytypes->perPage(), $bodytypes->total()) }}
                    of {{ $bodytypes->total() }} Results
                </span></div>
            <div class="col-4">
                @if ($bodytypes->hasPages())
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($bodytypes->onFirstPage())
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
                                        <a href="{{ $bodytypes->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($bodytypes->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $bodytypes->currentPage())
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

                            @if ($bodytypes->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $bodytypes->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $bodytypes->nextPageUrl() }}"
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
    

    @if (isset($type))
        <form action="{{ route('superadmin.bike-bodytype.destroy', $type->id) }}" method="post">
            @include('superadmin.modal.delete')
        </form>
    @endif





    {{-- add body type modal  --}}

    <div class="modal fade" id="addBodyTypeModal" tabindex="-1" aria-labelledby="addBodyTypeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="addBodyTypeModalLabel">Add Body Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
    <script src="{{asset('web/bikes/js/superadmin/add_body_types.js')}}"></script>
@endsection
