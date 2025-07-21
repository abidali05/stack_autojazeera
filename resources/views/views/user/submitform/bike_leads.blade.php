{{-- @dd($posts[0]->post) --}}
@extends('layout.panel_layout.main')

@section('content')
    <style>
        /* Style for the dropdown */
        #lead-type {
            border: 1px solid white;
            height: 40px;
            color: white;
            background-color: #1F1B2D;
            padding: 5px;
            outline: none;
            border-radius: 5px;
        }

        #lead-type option {
            color: white;
            background-color: #1F1B2D;
        }

        #lead-type option:hover {
            color: white;
        }

        .nav-link {
            color: white;
        }

        .nav-link:focus,
        .nav-link:active {
            color: #281F48 !important;
        }

        .nav-link:hover {
            background-color: white;
            color: red;
        }

        .orange {
            color: #FD5631;
            font-weight: 600;
        }

        .exportbtn {
            background-color: white;
            color: #281F48;
            border-radius: 5px;
            border: none;
            padding: 10px 20px;
        }

        .modal-content {
            background-color: #F0F3F6 !important;
        }
    </style>
    <div class="container mt-3">
        <!-- Header Section -->
        <div class="d-flex align-items-center mb-3">

            <h2 class="sec mb-0 primary-color-custom">Bike Leads</h2>
        </div>
        <div style="background-color: #F0F3F6;" class="p-2 pb-0 rounded  row">
            <!-- Search and Filters Section -->
            <div class="search-bar d-flex justify-content-between align-items-end mb-3">

                <div class="input-group d-none" style="width: 60%;">

                    <span class="input-group-text bg-transparent border-0 text-white"><i class="bi bi-search"></i></span>
                    <form method="get" action="">
                        <input type="text" class="form-control bg-transparent" name="search"
                            placeholder="Search By Name" aria-label="Search">
                    </form>
                </div>

            </div>

            <!-- Tabs Section -->
            <ul class="nav nav-tabs mb-3 border-bottom-0 col-md-10" id="carTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active " id="all-cars-tab" data-bs-toggle="tab" data-bs-target="#all-cars"
                        type="button" role="tab" style="color: #281F48" aria-controls="all-cars"
                        aria-selected="true">All Bikes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="used-cars-tab" data-bs-toggle="tab" data-bs-target="#used-cars"
                        type="button" role="tab" style="color: #281F48" aria-controls="used-cars"
                        aria-selected="false">Used Bikes
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="new-cars-tab" data-bs-toggle="tab" data-bs-target="#new-cars"
                        type="button" role="tab" style="color: #281F48" aria-controls="new-cars"
                        aria-selected="false">New Bikes
                    </button>
                </li>


                {{--
                <li class="nav-item ms-2">
                    <button id="add-filter-btn" class="btn btn-secondary">Add More Filters</button>
                </li>
                --}}
            </ul>
            <div class="col-md-2 text-end">
                @if (request()->search)
                    <a href="{{ route('forms.export', ['search' => request('search')]) }}"
                        class="btn custom-btn-nav rounded">Export</a>
                @else
                    <a href="{{ route('forms.export') }}" class=" exportbtn">Export</a>
                @endif
            </div>

        </div>


        <!-- Tab Content Section -->
        <div class="tab-content" id="carTabsContent">
            <!-- All Cars Tab -->
            <div class="tab-pane fade show active" id="all-cars" role="tabpanel" aria-labelledby="all-cars-tab">			 <div class="container my-2">

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
                <div class="table-section table-responsive">
                    <table class="table table-striped transparent-table align-middle datatable1">
                        <thead>
                            <tr>
                                <!-- <th>Action</th>-->
                                <th class="d-none">S.No</th>
                                <th>Type</th>
                                <th>Condition</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>City </th>
                                <th>View Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $i => $form)
                                <tr class="table-row">
                                    <td class="d-none">{{ $i + 1 }}</td>
                                    <td>{{ $form->requesttype }}</td>
                                    <td class="text-capitalize">{{ $form->post->condition }}</td>
                                    <td>{{ $form->fullname }}</td>
                                    <td>{{ $form->number }}</td>
                                    <td>{{ $form->email }}</td>
                                    <td>{{ $form->created_at }}</td>
                                    <td>{{ $form->user->cityname }}</td>
                                    <td class="text-center">
                                        <a href="#" class="view-details" data-bs-toggle="modal"
                                            data-bs-target="#view_comment_modal{{ $form->id }}">
                                            <i class="bi bi-eye" style="color: #281F48 !important;"></i>
                                        </a>
                                    </td>
                                </tr>

                                <div class="modal fade modal-lg" id="view_comment_modal{{ $form->id }}" tabindex="-1"
                                    aria-labelledby="viewCommentLabel{{ $form->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content"
                                           style="border-radius: 10px; overflow: hidden;">
                                            <div class="border-0 modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                                <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-3" style="background-color: #F0F3F6; color: #FD5631;">
                                                <form>
                                                    <div class="row mb-3">
                                                        <div class="col-12 text-center"
                                                            style="border-bottom:1px solid #B7B7B7">
                                                            <h3 class="modal-title"
                                                                style="color: #FD5631; font-weight: bold;padding-bottom: 13px;"
                                                                id="viewCommentLabel{{ $form->id }}">
                                                                {{ $form->fullname }} <span style=color:#281F48>|
                                                                    {{ $form->requesttype }} </span>
                                                            </h3>
                                                        </div>
                                                        <div class="mb-3 mt-4">
                                                            <label for="message{{ $form->id }}"
                                                                class="form-label  mb-3"
                                                                style="font-size:24px"><strong>Comments</strong></label>
                                                            <p class="p-0 m-0 " style="font-size:20px">
                                                                {{ $form->comment }}</p>
                                                        </div>
                                                        <div class="col-md-4 mt-3">
                                                            {{--  <label for="fullname{{$form->id}}" class="form-label" style="color: #FD5631;">Full Name</label>
                                                        <input type="text" class="form-control" id="fullname{{$form->id}}" placeholder="Enter full name" value="{{$form->fullname}}" readonly> --}}
                                                            <p class="p-0 m-0 orange">Phone</p>
                                                        </div>
                                                        <div class="col-md-6 mt-3">

                                                            {{-- <label for="email{{$form->id}}" class="form-label" style="color: #FD5631;">Email</label>
                                                        <input type="email" class="form-control" id="email{{$form->id}}" placeholder="Enter email" value="{{$form->email}}" readonly> --}}
                                                            <p class="p-0 m-0">{{ $form->number }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row ">
                                                        <div class="col-md-4">
                                                            {{--   <label for="phone{{$form->id}}" class="form-label">Phone Number</label>
                                                        <input type="text" class="form-control" id="phone{{$form->id}}" placeholder="Enter phone number" value="{{$form->number}}" readonly> --}}
                                                            <p class="p-0 orange">Email</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{--     <label for="dob{{$form->id}}" class="form-label">Date of Birth</label>
                                                        <input type="text" class="form-control" id="dob{{$form->id}}" placeholder="dd/mm/yyyy" value="{{\carbon\Carbon::parse($form->dob)->format('d/m/Y')}}"  readonly>  --}}
                                                            <p class="p-0">{{ $form->email }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="row ">
                                                        <div class="col-md-4">
                                                            {{--  <label for="time{{$form->id}}" class="form-label">Time</label>
                                                        <input type="time" class="form-control" id="time{{$form->id}}" value="{{$form->apointment_time}}" readonly> --}}
                                                            <p class="p-0 orange">Requested Date</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{-- <label for="contactMethod{{$form->id}}" class="form-label">Preferred Contact Method</label>
                                                        <select class="form-control" disabled id="contactMethod{{$form->id}}">
                                                            
                                                            <option value="email" {{$form->perefered_contact_method == 'email' ? 'selected' : ''}}>Email</option>
                                                            <option value="number" {{$form->perefered_contact_method == 'number' ? 'selected' : ''}}>Phone</option>
                                                        </select> --}}

                                                        </div>

                                                        {{--  <div class="mb-3">
                                                    <label for="message{{$form->id}}" class="form-label">Message</label>
                                                    <textarea class="form-control" id="message{{$form->id}}" rows="4" placeholder="Enter your message here" readonly>{{$form->comment}}</textarea>
                                                </div> --}}
                                                        <div class="col-md-4">
                                                            <p class="orange">Ad Id</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p>{{ $form->post->id }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p class="orange">Ad Title</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p>{{ $form->post->title }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p class="orange">Ad Published Date</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p>
                                                                {{ \carbon\Carbon::parse($form->post->created_at)->format('d/m/Y') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                   

                        </tbody>
                    </table>
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
                </div>
            </div>

            <!-- Used Cars Tab -->
            <div class="tab-pane fade" id="used-cars" role="tabpanel" aria-labelledby="used-cars-tab ">
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
                <div class="table-section">
                    <table class="table table-striped transparent-table align-middle datatable1">
                        <thead>
                            <tr>
                                <!-- <th>Action</th>-->
                                <th class="d-none">S.No</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                {{-- <th>Comments</th> --}}
                                <th>Date</th>
                                <th>City & Province</th>
                                <th>View Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Used cars rows -->
                            @foreach ($posts as $i => $form)
                                @if ($form->post->condition == 'used')
                                    <tr class="table-row">
                                        <td class="d-none">{{ $i + 1 }}</td>
                                        <!--  <td><i class="bi bi-list text-warning"></i> <i class="bi bi-trash text-danger"></i></td> -->
                                        <td>{{ $form->requesttype }}</td>
                                        <td>{{ $form->fullname }}</td>
                                        <td>{{ $form->number }}</td>
                                        <td>{{ $form->email }}</td>
                                        {{-- <td>{{$form->comment}} <a href="#" class="text-white">Read more</a></td> --}}
                                        <td>{{ $form->created_at }}</td>
                                        <td>{{ $form->user->cityname }}</td>
                                        <td class="text-center">
                                            <a href="#" class="view-details" data-bs-toggle="modal"
                                                data-bs-target="#view_used_comment_modal{{ $form->id }}">
                                                <i class="bi bi-eye" style="color: #FD5631 !important;"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <div class="modal fade modal-lg" id="view_used_comment_modal{{ $form->id }}"
                                        tabindex="-1" aria-labelledby="viewCommentLabel{{ $form->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content"
                                             style="border-radius: 10px; overflow: hidden;">
                                                <div class="modal-header border-0" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                                    <h5 class="modal-title" 
                                                        id="viewCommentLabel{{ $form->id }}">
                                                      <strong>   Book an Appointment</strong>
                                                    </h5>
                                                    <button type="button" data-bs-dismiss="modal"
                                                        aria-label="Close" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;"></button>
                                                </div>
                                                <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">
                                                    <form>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label for="fullname{{ $form->id }}"
                                                                    class="form-label" style="color: #FD5631;">Full
                                                                    Name*</label>
                                                                <input type="text" class="form-control"
                                                                    id="fullname{{ $form->id }}"
                                                                    placeholder="Enter full name"
                                                                    value="{{ $form->fullname }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="email{{ $form->id }}" class="form-label"
                                                                    style="color: #FD5631;">Email*</label>
                                                                <input type="email" class="form-control"
                                                                    id="email{{ $form->id }}"
                                                                    placeholder="Enter email" value="{{ $form->email }}"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label for="phone{{ $form->id }}"
                                                                    class="form-label">Phone Number</label>
                                                                <input type="text" class="form-control"
                                                                    id="phone{{ $form->id }}"
                                                                    placeholder="Enter phone number"
                                                                    value="{{ $form->number }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="dob{{ $form->id }}"
                                                                    class="form-label">Date
                                                                    of Birth</label>
                                                                <input type="text" class="form-control"
                                                                    id="dob{{ $form->id }}" placeholder="dd/mm/yyyy"
                                                                    value="{{ \carbon\Carbon::parse($form->created_at)->format('d/m/Y') }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label for="time{{ $form->id }}"
                                                                    class="form-label">Time</label>
                                                                <input type="time" class="form-control"
                                                                    id="time{{ $form->id }}"
                                                                    value="{{ $form->apointment_time }}" readonly>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="contactMethod{{ $form->id }}"
                                                                    class="form-label">Preferred Contact Method</label>
                                                                <select class="form-control" disabled
                                                                    id="contactMethod{{ $form->id }}">

                                                                    <option value="email"
                                                                        {{ $form->perefered_contact_method == 'email' ? 'selected' : '' }}>
                                                                        Email</option>
                                                                    <option value="number"
                                                                        {{ $form->perefered_contact_method == 'number' ? 'selected' : '' }}>
                                                                        Phone</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message{{ $form->id }}"
                                                                class="form-label">Message</label>
                                                            <textarea class="form-control" id="message{{ $form->id }}" rows="4" placeholder="Enter your message here"
                                                                readonly>{{ $form->comment }}</textarea>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            <!-- Repeat rows as needed -->
                         
                        </tbody>
                    </table>
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
                </div>
            </div>

            <!-- New Cars Tab -->
            <div class="tab-pane fade" id="new-cars" role="tabpanel" aria-labelledby="new-bike-tab">
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
                <div class="table-section">
                    <table class="table table-striped transparent-table align-middle datatable1">
                        <thead>
                            <tr>
                                <!--<th>Action</th>-->
                                <th class="d-none">S.No</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                {{-- <th>Comments</th> --}}
                                <th>Date</th>
                                <th>City & Province</th>
                                <th>View Comments</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($posts as $i => $form)
                                @if ($form->post->condition == 'new')
                                    <tr class="table-row">
                                        <!-- <td><i class="bi bi-list text-warning"></i> <i class="bi bi-trash text-danger"></i></td> -->
                                        <td class="d-none">{{ $i + 1 }}</td>
                                        <td>{{ $form->requesttype }}</td>
                                        <td>{{ $form->fullname }}</td>
                                        <td>{{ $form->number }}</td>
                                        <td>{{ $form->email }}</td>
                                        {{-- <td>{{$form->comment}} <a href="#" class="text-white">Read more</a></td> --}}
                                        <td>{{ $form->created_at }}</td>
                                        <td>{{ $form->user->cityname }}</td>
                                        <td class="text-center">
                                            <a href="#" class="view-details" data-bs-toggle="modal"
                                                data-bs-target="#view_new_comment_modal{{ $form->id }}">
                                                <i class="bi bi-eye" style="color: #FD5631 !important;"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <div class="modal fade modal-lg" id="view_new_comment_modal{{ $form->id }}"
                                        tabindex="-1" aria-labelledby="viewCommentLabel{{ $form->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content"
                                                style="border-radius: 10px; overflow: hidden;">
                                                <div class="modal-header border-0" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                                    <h5 class="modal-title" 
                                                        id="viewCommentLabel{{ $form->id }}">
                                                        <strong> Book an Appointment</strong>
                                                    </h5>
                                                    <button type="button"  class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                                                        aria-label="Close" ></button>
                                                </div>
                                                <div class="modal-body"  style="background-color: #F0F3F6; color: #FD5631;">
                                                    <form>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label for="fullname{{ $form->id }}"
                                                                    class="form-label" style="color: #FD5631;">Full
                                                                    Name*</label>
                                                                <input type="text" class="form-control"
                                                                    id="fullname{{ $form->id }}"
                                                                    placeholder="Enter full name"
                                                                    value="{{ $form->fullname }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="email{{ $form->id }}" class="form-label"
                                                                    style="color: #FD5631;">Email*</label>
                                                                <input type="email" class="form-control"
                                                                    id="email{{ $form->id }}"
                                                                    placeholder="Enter email" value="{{ $form->email }}"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label for="phone{{ $form->id }}"
                                                                    class="form-label">Phone Number</label>
                                                                <input type="text" class="form-control"
                                                                    id="phone{{ $form->id }}"
                                                                    placeholder="Enter phone number"
                                                                    value="{{ $form->number }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="dob{{ $form->id }}"
                                                                    class="form-label">Date
                                                                    of Birth</label>
                                                                <input type="text" class="form-control"
                                                                    id="dob{{ $form->id }}" placeholder="dd/mm/yyyy"
                                                                    value="{{ \carbon\Carbon::parse($form->created_at)->format('d/m/Y') }}"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label for="time{{ $form->id }}"
                                                                    class="form-label">Time</label>
                                                                <input type="time" class="form-control"
                                                                    id="time{{ $form->id }}"
                                                                    value="{{ $form->apointment_time }}" readonly>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="contactMethod{{ $form->id }}"
                                                                    class="form-label">Preferred Contact Method</label>
                                                                <select class="form-control" disabled
                                                                    id="contactMethod{{ $form->id }}">

                                                                    <option value="email"
                                                                        {{ $form->perefered_contact_method == 'email' ? 'selected' : '' }}>
                                                                        Email</option>
                                                                    <option value="number"
                                                                        {{ $form->perefered_contact_method == 'number' ? 'selected' : '' }}>
                                                                        Phone</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message{{ $form->id }}"
                                                                class="form-label">Message</label>
                                                            <textarea class="form-control" id="message{{ $form->id }}" rows="4" placeholder="Enter your message here"
                                                                readonly>{{ $form->comment }}</textarea>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
              
                        </tbody>
                    </table>
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
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addFilterBtn = document.getElementById('add-filter-btn');
            const filterCard = document.getElementById('filter-card');
            const cancelBtn = document.getElementById('cancel-btn');


            // Show Filter Card
            addFilterBtn.addEventListener('click', () => {
                filterCard.style.display = 'block';
            });

            // Hide Filter Card
            cancelBtn.addEventListener('click', () => {
                filterCard.style.display = 'none';
            });

            // Apply Filters (Example)
            document.getElementById('apply-btn').addEventListener('click', () => {
                alert('Filters applied!');
                filterCard.style.display = 'none';
            });
        });




        $(document).ready(function() {
            $('.datatable1').DataTable({
                "paging": false,
                "info": false,
                "lengthChange": false,
                "ordering": true,
                "searching": true,
                "language": {
                    "emptyTable": "You dont have any leads yet"
                }
            });
        });
    </script>
@endsection
