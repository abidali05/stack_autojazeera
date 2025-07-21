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
    </style>
    <?php
    
    use App\Models\User;
    
    $provinces = \App\Models\Province::all();
    $users = User::where('role', 1)->get();
    
    ?>
    <div class="container mt-5">
        <div class="row align-items-center mb-4">
            <div class="col-auto">
                <a href="{{ route('superadmin.dashboard') }}" class="text-white me-3">
                    <img src="{{ asset('web/images/icon.svg') }}" alt="back-arrow" width="50px" height="35px">
                </a>
            </div>
            <div class="col-auto">
                <h2 class="sec mb-0 primary-color-custom">Manage Dealer Subscription </h2>
            </div>
        </div>
        <div class="row align-items-center mb-4">
            <div class="col-md-4 mb-md-0 mb-2">
                <div class="input-group" style="width:100%">
                    <form id="dealerForm" action="" method="get" style="width:100%">
                        <select class="form-select select-search formselect w-100" name="user_id" style="width:100%"
                            style="color:black !important;" aria-label="Search Dealer" aria-describedby="search-addon">
                            <option selected>Select Dealer</option>
                            <option value="0">All</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

            </div>
            <div class="col-md-8">
                @if ($subscriptions->hasPages())
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($subscriptions->onFirstPage())
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
                                        <a href="{{ $subscriptions->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($subscriptions->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $subscriptions->currentPage())
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

                            @if ($subscriptions->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $subscriptions->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $subscriptions->nextPageUrl() }}"
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
        <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                style="font-size: 18px; color: #281F48; font-weight:700;">
                {{ ($subscriptions->currentPage() - 1) * $subscriptions->perPage() + 1 }}
                - {{ min($subscriptions->currentPage() * $subscriptions->perPage(), $subscriptions->total()) }}
                of {{ $subscriptions->total() }} Results
            </span></div>
    </div>
    <div class="container table-responsive">
        <div class="row">
            <table class="table table-striped transparent-table align-middle datatable">
                <thead>
                    <tr>
                        <th>Sr#</th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Dealer Name</th>
                        <th>Dealer Email</th>
                        <th>Current Subscription</th>
                        <th>Billing Start Date</th>
                        <th>Billing End Date</th>
                        <th>Created Date</th>


                    </tr>
                </thead>
                <tbody>
                    <!-- Repeat this block for each row -->
                    @foreach ($subscriptions as $key => $sub)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a class=" me-2 edit" title="Edit" style="text-decoration:none"
                                    data-id="{{ $sub->id }}" data-bs-toggle="modal"
                                    data-bs-target="#editsubscriptionModal{{ $sub->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a class="primary-color-custom cancel" title="Delete" data-id="{{ $sub->id }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckDefault" data-id="{{ $sub->id }}"
                                        {{ $sub->status == 1 ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>{{ $sub->user->name }}</td>
                            <td>{{ $sub->user->email }}</td>
                            <td>{{ $sub->subscribe()->name }}</td>
                            <td>{{ carbon\carbon::parse($sub->billing_start)->format('d M Y') }}</td>
                            <td>{{ carbon\carbon::parse($sub->billing_end)->format('d M Y') }}</td>
                            <td>{{ $sub->created_at->format('d M Y') }}</td>


                        </tr>
                        <!-- Modal -->
                        @if ($sub->subscribe()->name === 'Free Plan')
                            <div class="modal fade" id="editsubscriptionModal{{ $sub->id }}" tabindex="-1"
                                aria-labelledby="addDealerModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header border-0" style="background-color:#F0F3F6;">
                                            <h5 class="modal-title" id="addDealerModalLabel">Manage Dealer Subscription
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="background-color:#F0F3F6;">
                                            <form method="post"
                                                action="{{ route('superadmin.subscription.update', $sub->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-3">
                                                    <label for="dealershipName" class="col-sm-4 col-form-label">Dealer
                                                        Name*</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-select"
                                                            style="color:#281F48;background-color:white;border:1px solid #281F48 ; text-align:start"
                                                            id="adddealer" name="dealershipName" disabled>
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}"
                                                                    {{ $user->id == $sub->user_id ? 'selected' : '' }}>
                                                                    {{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('dealershipName')
                                                            <div class="alert ">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <div class="row mb-3">
                                                    <label for="addStatus" class="col-sm-4 col-form-label">Start
                                                        Date</label>
                                                    <div class="col-sm-8 " style="display: flex;">
                                                        <input type="date" class="form-control"
                                                            style="    line-height: 0.8 !important;" name="billing_start"
                                                            id="dealerName" placeholder=""
                                                            value="{{ $sub->billing_start }}">





                                                    </div>
                                                    <label for="addStatus" class="col-sm-4 col-form-label pt-4">End
                                                        Date</label>
                                                    <div class="col-sm-8 pt-3 " style="display: flex;">




                                                        <input type="date" class="form-control"
                                                            style="    line-height: 0.8 !important;" name="billing_end"
                                                            id="dealerName" placeholder=""
                                                            value="{{ $sub->billing_end }}">

                                                    </div>
                                                    @error('billing_start')
                                                        <div class="alert ">{{ $message }}</div>
                                                    @enderror
                                                    @error('billing_end')
                                                        <div class="alert ">{{ $message }}</div>
                                                    @enderror
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
                        @else
                            <div class="modal fade" id="editsubscriptionModal{{ $sub->id }}" tabindex="-1"
                                aria-labelledby="addDealerModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="border-0 modal-header">
                                            <h5 class="modal-title" id="addDealerModalLabel">Manage Dealer Subscription
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>This subscription cannot be edited as this is not a free plan.</p>

                                        </div>
                                    </div>
                                </div>
                        @endif
                    @endforeach



                    <!-- Repeat the row -->

                    <!-- Repeat the row -->
                </tbody>
            </table>
        </div>


    </div>
    <div class="container pt-3">
        <div class="row d-flex justify-content-between">
            <div class="col-md-4"> <span class="pt-md-3 pagination_count"
                    style="font-size: 18px; color: #281F48; font-weight:700;">
                    {{ ($subscriptions->currentPage() - 1) * $subscriptions->perPage() + 1 }}
                    - {{ min($subscriptions->currentPage() * $subscriptions->perPage(), $subscriptions->total()) }}
                    of {{ $subscriptions->total() }} Results
                </span></div>
            <div class="col-md-4">
                @if ($subscriptions->hasPages())
                    <nav class="d-flex justify-content-end align-items-center">
                        <!-- Page Info -->


                        <!-- Pagination -->
                        <ul class="pagination"
                            style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                            @if ($subscriptions->onFirstPage())
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
                                        <a href="{{ $subscriptions->previousPageUrl() }}"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                    </li>
                                @endif
                            @endif

                            @foreach ($subscriptions->links()->elements as $element)
                                @if (is_string($element))
                                    <li style="display: inline-block;">
                                        <span
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                    </li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $subscriptions->currentPage())
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

                            @if ($subscriptions->hasMorePages())
                                @if (request()->isMethod('post'))
                                    <li style="display: inline-block;">
                                        <form method="POST" action="{{ url()->current() }}">
                                            @csrf
                                            <input type="hidden" name="page"
                                                value="{{ $subscriptions->currentPage() + 1 }}">
                                            <button type="submit"
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                        </form>
                                    </li>
                                @else
                                    <li style="display: inline-block;">
                                        <a href="{{ $subscriptions->nextPageUrl() }}"
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
    @if (isset($sub))
        <form action="{{ route('superadmin.subscription.destroy', $sub->id) }}" method="post">
            @include('superadmin.modal.delete')
        </form>
    @endif

    <script>
        $(document).ready(function() {
            $('.form-check-input').change(function() {
                var subscriptionId = $(this).data('id'); // Get the subscription ID
                var newStatus = $(this).is(':checked') ? 1 : 0; // Determine new status

                // Send an AJAX request to update the status
                $.ajax({
                    url: '/superadmin/subscription-update/' + subscriptionId +
                    '/update-status', // Adjust the URL as needed
                    type: 'POST',
                    data: {
                        status: newStatus,
                        _token: '{{ csrf_token() }}' // Include CSRF token for security
                    },
                    success: function(response) {
                        alert('Status updated successfully!');
                    },
                    error: function(xhr) {
                        alert('Error updating status: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
