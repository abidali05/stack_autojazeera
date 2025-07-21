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
        <div class="row align-items-center mb-2">
       
            <div class="col-md-12">
                <h2 class="sec mb-0 primary-color-custom">Manage Shops</h2>
            </div>
        </div>

    </div>


    <div class="container my-2">
        <div class="row d-flex justify-content-between">
            <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #281F48; font-weight:700;">
                    {{ ($shops->currentPage() - 1) * $shops->perPage() + 1 }}
                    - {{ min($shops->currentPage() * $shops->perPage(), $shops->total()) }}
                    of {{ $shops->total() }} Results
                </span></div>
            <div class="col-md-4">
             
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($shops->onFirstPage())
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
                                                value="{{ $shops->currentPage() - 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $shops->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($shops->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $shops->currentPage())
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

                            @if ($shops->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $shops->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $shops->nextPageUrl() }}"
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
    <div class="container table-responsive ">
        <div class="row">
            <table class="table table-striped transparent-table align-middle datatable">
                <thead>
                    <tr>
                        <th>Sr#</th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Dealer</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>


                    @foreach ($shops as $key => $shop)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>

                                <a class="primary-color-custom cancel" data-id="{{ $shop->id }}" title="View"
                                    data-bs-toggle="modal" data-bs-target="#previewmodal{{ $shop->id }}">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>

                            <td>
                                @if ($shop->status == '1')
                                    <span class="badge rounded-pill bg-success" data-bs-toggle="modal"
                                        data-bs-target="#statusModal{{ $shop->id }}">Active</span>
                                @elseif ($shop->status == '2')
                                    <span class="badge rounded-pill bg-danger" data-bs-toggle="modal"
                                        data-bs-target="#statusModal{{ $shop->id }}">Rejected</span>
								
								@else
                                    <span class="badge rounded-pill bg-danger" data-bs-toggle="modal"
                                        data-bs-target="#statusModal{{ $shop->id }}">Inactive</span>
                                @endif
                            </td>

                            <td><img src="{{ $shop->logo }}" alt="" srcset="" width="40" height="30">
                            </td>
                            <td>{{ $shop->dealer->name ?? '' }}</td>
                            <td>{{ $shop->name }}</td>

                        </tr>


                        <div class="modal fade" id="previewmodal{{ $shop->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog  modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header" style="border:none !important">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="row mt-2">
                                                        <div class="col-12 col-md-2">
                                                            <div class="d-flex justify-content-center">
                                                                <img id="preview-logo" src="{{ $shop->logo }}"
                                                                    class="img-fluid" style="max-width: 100px;"
                                                                    alt="Shop Logo">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-9 pt-3">
                                                            <h1 id="preview-shop-name" class="fourtyeight">
                                                                {{ $shop->name }}</h1>
                                                            <span id="preview-shop-address"
                                                                class="twentyfourgrey">{{ $shop->address }}</span>
                                                            <div class="mt-2">
                                                                <span id="preview-shop-phone" class="sixteen me-5"><i
                                                                        class="bi bi-telephone me-2"></i>{{ $shop->number }}</span>
                                                                <span id="preview-shop-email" class="sixteen"><i
                                                                        class="bi bi-envelope me-2"></i>{{ $shop->email }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 mt-5">
                                                            <h2 class="twentyeight" style="color:#281F48;">About Shop</h2>
                                                            <p id="preview-shop-description" class="sixteen">
                                                                {{ $shop->description }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h2 class="twentyeight" style="color:#281F48;">Photos</h2>
                                                            <div class="row" id="preview-shop-images">
                                                                @foreach ($shop->shop_images as $image)
                                                                    <div class="col-md-{{ $loop->first ? '9' : '3' }}">
                                                                        <img src="{{ $image->path }}" class="img-fluid"
                                                                            style="max-height: {{ $loop->first ? '300px' : '140px' }}; width: 100%; object-fit: cover; border-radius: 8px;"
                                                                            alt="Shop Image">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 col-12 p-3">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h2 class="mt-5 mb-3 twentyeight" style="color:#281F48;">Services Offered</h2>
                                                                    <div class="row" id="preview-services-container">
                                                                        @foreach ($shop->shop_services->chunk(ceil($shop->shop_services->count() / 3)) as $chunk)
                                                                            <div class="col-md-4 col-6">
                                                                                @foreach ($chunk as $service)
                                                                                    <p class="eighteen">
                                                                                        {{ $service->service->name }}</p>
                                                                                @endforeach
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 p-3 mb-1">
                                                            <div class="map-container rounded-3">
                                                                <iframe id="preview-map" width="100%" height="300px"
                                                                    frameborder="0" style="border:0; border-radius: 8px;"
                                                                    src="https://www.google.com/maps?q={{ urlencode($shop->address) }}&output=embed"
                                                                    allowfullscreen>
                                                                </iframe>
                                                                <p id="preview-map-address" class="sixteen">
                                                                    {{ $shop->address }} <button
                                                                        class="mapbutton ms-4">Get Directions <img
                                                                            src="{{ asset('web/services/images/Group 1171275297.svg') }}"
                                                                            class="img-fluid ms-2"
                                                                            style="height: 20px; width: 20px;"
                                                                            alt="..."></button></p>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $days = [
                                                                'Monday',
                                                                'Tuesday',
                                                                'Wednesday',
                                                                'Thursday',
                                                                'Friday',
                                                                'Saturday',
                                                                'Sunday',
                                                            ];
                                                        @endphp
                                                        <div class="col-md-12 col-lg-12 col-12">
                                                            <div class="row">
                                                                <div class="col-md-6 col-12 px-4">
                                                                    <h2 class="twentyeight" style="color:#281F48;">Hours</h2>
                                                                    <div class="row">
                                                                        <div class="col-4"
                                                                            style="font-weight: 600;color: #000000;">
                                                                            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                                                <p class="sixteen">{{ $day }}</p>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="col-8"
                                                                            style="font-weight: 600; color: #000000;">
                                                                            @foreach ($days as $day)
                                                                                @php
                                                                                    $timing = $shop->shop_timings
                                                                                        ->where('day', $day)
                                                                                        ->first();
                                                                                @endphp
                                                                                <p id="preview-{{ strtolower($day) }}-hours"
                                                                                    class="sixteen text-end">
                                                                                    @if ($timing)
                                                                                        {{ date('h:i A', strtotime($timing->start_time)) }} -
                                                            {{ date('h:i A', strtotime($timing->end_time)) }}
                                                                                    @else
                                                                                        Closed
                                                                                    @endif
                                                                                </p>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12" style="color: #000000;">
                                                                    <div class="row">
                                                                        <h2 class="twentyeight" style="color:#281F48;">Amenities</h2>
                                                                        <div class="row"
                                                                            id="preview-amenities-container">
                                                                            @foreach ($shop->shop_amenities->chunk(ceil($shop->shop_amenities->count() / 2)) as $chunk)
                                                                                <div class="col-md-6">
                                                                                    @foreach ($chunk as $amenity)
                                                                                        <p class="sixteen"><i
                                                                                                class="bi bi-check-circle me-2"></i>{{ $amenity->amenity->name }}
                                                                                        </p>
                                                                                    @endforeach
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                        <p class="twentyeight mt-3">Our Social Media</p>
                                                                        <div class="col-md-12 twelve"
                                                                            style="font-weight: 600; color: #000000;">
                                                                            @if ($shop->facebook)
                                                                                <span id="preview-facebook"
                                                                                    class="me-5"><img
                                                                                        src="{{ asset('web/services/images/facebook.svg') }}"
                                                                                        class="img-fluid me-2"
                                                                                        alt="...">
                                                                                    {{ $shop->facebook }}</span>
                                                                            @endif
                                                                            @if ($shop->instagram)
                                                                                <span id="preview-instagram"
                                                                                    class="me-5"><img
                                                                                        src="{{ asset('web/services/images/instagram.svg') }}"
                                                                                        class="img-fluid me-2"
                                                                                        alt="...">
                                                                                    {{ $shop->instagram }}</span>
                                                                            @endif
                                                                            @if ($shop->twitter)
                                                                                <span id="preview-twitter"><img
                                                                                        src="{{ asset('web/services/images/Social Iconsxxx.svg') }}"
                                                                                        class="img-fluid me-2"
                                                                                        alt="...">
                                                                                    {{ $shop->twitter }}</span>
                                                                            @endif

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="statusModal{{ $shop->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog  ">
                                <div class="modal-content">
                                    <div class="modal-header" style="border:none !important">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('superadmin.update_shop_status') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $shop->id }}">
                                            <div class="mb-3">
                                                <label for="status{{ $shop->id }}" class="form-label">Status</label>
                                                <select class="form-select" name="status"
                                                    id="status{{ $shop->id }}">
                                                    <option value="1" {{ $shop->status == '1' ? 'selected' : '' }}>
                                                        Approved</option>
                                                    <option value="2" {{ $shop->status == '2' ? 'selected' : '' }}>
                                                        Rejected</option>
                                                    <option value="0" {{ $shop->status == '0' ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </div>
                                            <div class="mb-3" id="rejectionReasonContainer{{ $shop->id }}"
                                                style="display: {{ $shop->status == '2' ? 'block' : 'none' }}">
                                                <label for="rejectionReason{{ $shop->id }}"
                                                    class="form-label">Rejection
                                                    Reason</label>
                                                <textarea class="form-control" style="    line-height: 1 !important;
" name="rejection_reason" id="rejectionReason{{ $shop->id }}"
                                                    placeholder="Enter reason for rejection" {{ $shop->status != '2' ? 'disabled' : '' }}>{{ $shop->rejection_reason }}</textarea>
                                            </div>

                                            <div class="mb-3 text-end">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>

                                        <script>
                                            document.getElementById('status{{ $shop->id }}').addEventListener('change', function() {
                                                const reasonContainer = document.getElementById('rejectionReasonContainer{{ $shop->id }}');
                                                if (this.value === "2") {
                                                    reasonContainer.style.display = 'block';
                                                    document.getElementById('rejectionReason{{ $shop->id }}').removeAttribute('disabled');
                                                } else {
                                                    reasonContainer.style.display = 'none';
                                                    document.getElementById('rejectionReason{{ $shop->id }}').setAttribute('disabled', true);
                                                }
                                            });
                                        </script>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach




                </tbody>
            </table>
        </div>





        {{-- success modal start --}}


        <div class="modal fade" id="shopresponse" tabindex="-1" aria-labelledby="shopresponseLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="shopresponseLabel">Shops</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p>{{ session('shopresponse') }}</p>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- success modal end --}}

        @if (session('shopresponse'))
            <script>
                window.addEventListener('DOMContentLoaded', () => {
                    let modal = new bootstrap.Modal(document.getElementById('shopresponse'));
                    modal.show();
                });
            </script>
        @endif

    </div>

    <div class="container my-2">
        <div class="row d-flex justify-content-between">
            <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #281F48; font-weight:700;">
                    {{ ($shops->currentPage() - 1) * $shops->perPage() + 1 }}
                    - {{ min($shops->currentPage() * $shops->perPage(), $shops->total()) }}
                    of {{ $shops->total() }} Results
                </span></div>
            <div class="col-md-4">
             
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($shops->onFirstPage())
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
                                                value="{{ $shops->currentPage() - 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $shops->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($shops->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $shops->currentPage())
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

                            @if ($shops->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $shops->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $shops->nextPageUrl() }}"
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







    <script>
        function handleServiceCategoryIconUpload(input, previewElementId) {
            const previewElement = document.getElementById(previewElementId);
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Check if the file is an image
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = function() {
                        // If it's a valid image, display it
                        previewElement.innerHTML = '';
                        previewElement.appendChild(img);
                    };
                    img.onerror = function() {
                        // Handle the case where the file is not a valid image
                        previewElement.textContent = 'Uploaded file is not a valid image.';
                    };
                };

                reader.readAsDataURL(file);
            } else {
                previewElement.textContent = 'No file uploaded.';
            }
        }
    </script>
@endsection
