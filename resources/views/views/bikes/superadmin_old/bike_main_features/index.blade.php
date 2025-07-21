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
                <h2 class="sec mb-0 primary-color-custom">Manage Bike Feature</h2>
            </div>
        </div>
        <div class="row align-items-center mb-4">
            <div class="col-md-4 mb-md-0 mb-2">
                <div class="input-group" style="width:100%">
                    <form id="dealerForm" action="" method="get" style="width:100%">
                        <select class="form-select  select-search formselect" style="width:100%" name="feature_id"
                            style="color:black !important" aria-label="Search Dealer" aria-describedby="search-addon">
                            <option selected>Select Feature type</option>
                            <option value="0">All</option>
                            @foreach ($features as $key => $feature)
                                <option value="{{ $feature->id }}">{{ $feature->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                @if ($features->hasPages())
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($features->onFirstPage())
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
                                        <a href="{{ $features->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($features->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $features->currentPage())
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

                            @if ($features->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $features->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $features->nextPageUrl() }}"
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
            <div class="col-4"> <span class=" pagination_count" style="font-size: 18px; color: #FD5631; font-weight:700;">
                    {{ ($features->currentPage() - 1) * $features->perPage() + 1 }}
                    - {{ min($features->currentPage() * $features->perPage(), $features->total()) }}
                    of {{ $features->total() }} Results
                </span></div>
            <div class="col-md-8 text-end">
                <button class="btn custom-btn-nav rounded" data-bs-toggle="modal" data-bs-target="#addbikefeatureModal">
                    <span> <i class="bi bi-plus fs-5 p-0 m-0 "></i></span> <span class="pb-3"> Add New Feature</span>
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
                        <th>Feature Type</th>
                        <th>Feature Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Repeat this block for each row -->
                    @foreach ($features as $key => $feature)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a href="#" class="text-white me-2" title="Edit" style="text-decoration:none"
                                    data-bs-toggle="modal" data-bs-target="#editbikefeatureModal{{ $feature->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a class="primary-color-custom cancel" data-id="{{ $feature->id }}" title="Delete"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>

                            @if ($feature->icon)
                                <td><img src="{{ asset('posts/features/bikes/' . $feature->icon) }}" alt=""
                                        srcset="" width="30" height="30"></td>
                            @else
                                <td><img src="{{ asset('web/images/Icon-form.png') }}" alt="" srcset=""
                                        width="30" height="30"></td>
                            @endif
                            <td>{{ $feature->category }}</td>
                            <td>{{ $feature->name }}</td>
                            <td>
                                @if ($feature->status == 1)
                                    <span class="badge text-bg-active">Active</span>
                                @else
                                    <span class="badge text-bg-danger">Inactive</span>
                                @endif

                            </td>
                        </tr>
                        {{-- edit modal  --}}
                        <div class="modal fade" id="editbikefeatureModal{{$feature->id}}" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <form id="featureForm" method="post" action="{{route('superadmin.bike-features.update',$feature->id)}}" enctype="multipart/form-data">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title" id="featureModalLabel">Edit Feature</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                        
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <!-- Left Side: Upload Icon -->
                                                <div class="col-md-6 text-center">
                                                    <div class="upload-area border border-dashed rounded p-4 text-center"
                                                        onclick="document.getElementById('imageupload1{{$feature->id}}').click();">
                                                        <p class="mb-0">Click here to upload Icon</p>
                                                        <input type="file" id="imageupload1{{$feature->id}}" name="icon" class="d-none"
                                                            accept=".png, .jpg, .jpeg, .gif, .ico, .svg"
                                                            onchange="handleimageUpload1(this, 'brochurePreview{{$feature->id}}')">
                                                    </div>
                                                    <div id="brochurePreview{{$feature->id}}" class="mt-3 text-success image-preview"></div>
                                                </div>
                        
                                                <!-- Right Side: Input Fields -->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="featureType" class="form-label">Select Feature Type*</label>
                                                        <select class="form-select" name="featureType" id="featureType" required>
                                                            <option value="" disabled selected>Select Feature Type</option>
                                                            <option value="Tires&Wheels" {{ $feature->category == 'Tires&Wheels' ? 'selected' : '' }}>Tires&Wheels</option>
                                                            <option value="Braking System" {{ $feature->category == 'Braking System' ? 'selected' : '' }}>Braking System</option>
                                                            <option value="Lighting System" {{ $feature->category == 'Lighting System' ? 'selected' : '' }}>Lighting System</option>
                                                            <option value="Safety Features" {{ $feature->category == 'Safety Features' ? 'selected' : '' }}>Safety Features</option>
                                                            <option value="Technology & Connectivity" {{ $feature->category == 'Technology & Connectivity' ? 'selected' : '' }}>Technology & Connectivity</option>
                                                        </select>
                                                    </div>
                        
                                                    <div class="mb-3">
                                                        <label for="bodyType" class="form-label">Enter Feature Name</label>
                                                        <input type="text" name="featureName" value="{{$feature->name}}" class="form-control" id="bodyType" placeholder="Enter Feature Name"
                                                            required>
                                                    </div>
                        
                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input" name="status" type="checkbox" id="activateFeature" {{$feature->status == 1?"checked":""}}>
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
                    @endforeach


                </tbody>
            </table>
        </div>


    </div>
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-4"> <span class=" pagination_count"
                    style="font-size: 18px; color: #FD5631; font-weight:700;">
                    {{ ($features->currentPage() - 1) * $features->perPage() + 1 }}
                    - {{ min($features->currentPage() * $features->perPage(), $features->total()) }}
                    of {{ $features->total() }} Results
                </span></div>
            <div class="col-4">
                @if ($features->hasPages())
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($features->onFirstPage())
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
                                        <a href="{{ $features->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($features->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $features->currentPage())
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

                            @if ($features->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $features->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $features->nextPageUrl() }}"
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
    {{-- add feature modal  --}}

    <div class="modal fade" id="addbikefeatureModal" tabindex="-1" aria-labelledby="addbikefeatureModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="addbikefeatureModalLabel">Add Bike Feature</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="featureForm" method="post" action="{{ route('superadmin.bike-features.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Left Side: Upload Icon -->
                            <div class="col-md-6 text-center">
                                <div class="upload-area border border-dashed rounded p-4 text-center"
                                    onclick="document.getElementById('brochureUpload2').click();">
                                    <p class="mb-0">Click here to upload Icon</p>
                                    <input type="file" id="brochureUpload2" name="icon" class="d-none"
                                        accept=".png, .jpg, .jpeg, .gif, .ico, .svg"
                                        onchange="handleimageUpload(this, 'brochurePreview2')">
                                </div>
                                <div id="brochurePreview2" class="mt-3 text-success"></div>
                            </div>
                            <!-- Right Side: Input Fields -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="featureType" class="form-label">Select Feature Type*</label>
                                    <select class="form-select" name="featureType" id="featureType" required>
                                        <option value="" disabled selected>Select Feature Type</option>
                                        <option value="Tires&Wheels">Tires&Wheels</option>
                                        <option value="Braking System">Braking System</option>
                                        <option value="Lighting System">Lighting System</option>
                                        <option value="Safety Features">Safety Features</option>
                                        <option value="Technology & Connectivity">Technology & Connectivity</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="bodyType" class="form-label">Enter Feature Name</label>
                                    <input type="text" name="featureName" class="form-control" id="bodyType"
                                        placeholder="Enter Feature Name" required>
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


    @if (isset($feature))
        <form action="{{ route('superadmin.bike-features.destroy', $feature->id) }}" method="post">
            @include('superadmin.modal.delete')
        </form>
    @endif
@endsection
