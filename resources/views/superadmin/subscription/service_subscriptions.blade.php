@extends('layout.superadmin_layout.main')
@section('content')
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        table {
            border-collapse: separate !important;
            border-spacing: 0 10px;
        }

        table tr,
        table td,
        table th {
            border-bottom: none !important;
        }

        table thead th {
            color: #002d69;
            font-size: 18px;
            white-space: nowrap;
            font-weight: 500;
            background-color: #f0f3f6 !important;
        }

        table tbody td {
            color: #000000;
            white-space: nowrap;
            font-size: 13px;
            font-weight: 400;
            background-color: #f0f3f6 !important;
        }

        .history {
            font-size: 30px;
            font-weight: 600;
            color: #281F48;
        }

        .adsbtn {
            font-size: 16px;
            font-weight: 500;
            color: #281F48;
            border: 1px solid #281F48;
            border-radius: 5px;
        }

        .servicesbtn {
            font-size: 16px;
            font-weight: 500;
            color: white;
            background-color: #281F48;
            border: 1px solid #281F48;
            border-radius: 5px;
        }

        .nav-tabs {
            --bs-nav-tabs-border-width: none !important;

        }

        .nav-linkss:focus,
        .nav-linkss:hover,
        .nav-linkss:active {
            font-size: 16px;
            font-weight: 500;
            color: white;
            background-color: #281F48;
            border: 1px solid #281F48;
            border-radius: 5px;
            padding: 5px 10px;
        }

        .nav-linkss {
            font-size: 16px;
            font-weight: 500;
            color: #281F48;
            border: 1px solid #281F48;
            border-radius: 5px;
            padding: 5px 10px;
        }

        .nav-link:focus,
        .nav-link:active {
            color: #ffffff !important;
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
    <!-- Buttons to toggle between Ads and Services -->
    <div class="container my-3">
        <div class="row">
            <div class="col-md-6">
                <p class="m-0 history">Service Subscription History</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mb-2">
            {{-- <div class="col-md-4 "> <span class=" pagination_count" style="font-size: 18px; color: #281F48; font-weight:700;">
                    {{ ($subscriptions->currentPage() - 1) * $subscriptions->perPage() + 1 }}
                    - {{ min($subscriptions->currentPage() * $subscriptions->perPage(), $subscriptions->total()) }}
                    of {{ $subscriptions->total() }} Results
                </span></div> --}}
            {{-- <div class="col-md-8">
                <nav class="d-flex justify-content-end align-items-center">
                    <ul class="pagination"
                        style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                        @if ($subscriptions->onFirstPage())
                            <li style="display: inline-block;">
                                <span
                                    style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</span>
                            </li>
                        @else
                            @if (request()->isMethod('post'))
                                <li style="display: inline-block;">
                                    <form method="POST" action="{{ url()->current() }}">
                                        @csrf
                                        <input type="hidden" name="page" value="{{ $newsletters->currentPage() - 1 }}">
                                        <button type="submit"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                    </form>
                                </li>
                            @else
                                <li style="display: inline-block;">
                                    <a href="{{ $subscriptions->previousPageUrl() }}"
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                </li>
                            @endif
                        @endif

                        @foreach ($subscriptions->links()->elements as $element)
                            @if (is_string($element))
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                </li>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $subscriptions->currentPage())
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

                        @if ($subscriptions->hasMorePages())
                            @if (request()->isMethod('post'))
                                <li style="display: inline-block;">
                                    <form method="POST" action="{{ url()->current() }}">
                                        @csrf
                                        <input type="hidden" name="page"
                                            value="{{ $subscriptions->currentPage() + 1 }}">
                                        <button type="submit"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                    </form>
                                </li>
                            @else
                                <li style="display: inline-block;">
                                    <a href="{{ $subscriptions->nextPageUrl() }}"
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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table align-middle service-datatable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Plan</th>
                                <th>User Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Price</th>
                                <th>Cancelled Date</th>
                                {{-- <th>Refunded Date</th> --}}
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($subscriptions as $i => $ads_subscription)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $ads_subscription->plan->name }}</td>
                                    <td>{{ $ads_subscription->user->name }}</td>
                                    <td>{{ $ads_subscription->start_date ?? 'N/A' }}</td>
                                    <td>{{ $ads_subscription->end_date ?? 'N/A' }}</td>
                                    <td>{{ $ads_subscription->amount_paid ?? 'N/A' }}</td>
                                    <td>{{ $ads_subscription->cancel_date ?? 'N/A' }}</td>
                                    {{-- <td>{{ $ads_subscription->refunded_date ?? 'N/A' }}</td> --}}
                                    <td>
                                        @if ($ads_subscription->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($ads_subscription->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @elseif($ads_subscription->status == 'returned')
                                            <span class="badge bg-warning">Returned</span>
                                        @elseif($ads_subscription->status == 'expired')
                                            <span class="badge bg-secondary">Expired</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- <div class="container">
                        <div class="row mb-2">
                            <div class="col-md-4 "> <span class=" pagination_count"
                                    style="font-size: 18px; color: #281F48; font-weight:700;">
                                    {{ ($subscriptions->currentPage() - 1) * $subscriptions->perPage() + 1 }}
                                    -
                                    {{ min($subscriptions->currentPage() * $subscriptions->perPage(), $subscriptions->total()) }}
                                    of {{ $subscriptions->total() }} Results
                                </span></div>
                            <div class="col-md-8">

                                <nav class="d-flex justify-content-end align-items-center">
                                    <ul class="pagination"
                                        style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                                        @if ($subscriptions->onFirstPage())
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
                                                            value="{{ $newsletters->currentPage() - 1 }}">
                                                        <button type="submit"
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li style="display: inline-block;">
                                                    <a href="{{ $subscriptions->previousPageUrl() }}"
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                                                </li>
                                            @endif
                                        @endif

                                        @foreach ($subscriptions->links()->elements as $element)
                                            @if (is_string($element))
                                                <li style="display: inline-block;">
                                                    <span
                                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                                                </li>
                                            @endif

                                            @if (is_array($element))
                                                @foreach ($element as $page => $url)
                                                    @if ($page == $subscriptions->currentPage())
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

                                        @if ($subscriptions->hasMorePages())
                                            @if (request()->isMethod('post'))
                                                <li style="display: inline-block;">
                                                    <form method="POST" action="{{ url()->current() }}">
                                                        @csrf
                                                        <input type="hidden" name="page"
                                                            value="{{ $subscriptions->currentPage() + 1 }}">
                                                        <button type="submit"
                                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li style="display: inline-block;">
                                                    <a href="{{ $subscriptions->nextPageUrl() }}"
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
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.service-datatable').each(function() {
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
