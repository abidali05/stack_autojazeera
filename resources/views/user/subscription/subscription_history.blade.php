@extends('layout.panel_layout.main')
@section('content')
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap");

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
    </style>

    <div class="container my-3">
        <div class="row">
            <div class="col-md-6">
                <h2 class="sec mb-0 primary-color-custom">Ads Subscription History</h2>
            </div>
            {{-- <div class="col-md-6 d-flex justify-content-end">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @if (Auth::user()->package)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1"
                                type="button" role="tab" style="background-color: #281F48; color: white;">
                                Ads Subscription
                            </button>
                        </li>
                    @endif
                    @if (Auth::user()->shop_package)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2"
                                type="button" role="tab" style="background-color: white; color: #281F48;">
                                Services Subscription
                            </button>
                        </li>
                    @endif
                </ul>
            </div> --}}
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="tab-content" id="myTabContent">

                    {{-- Ads Tab --}}
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                        <div class="table-responsive ">

                            @if (!empty($ads_invoices))
                                <table class="table table-striped transparent-table align-middle datatable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Plan</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Price</th>
                                            <th>Cancelled Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ads_invoices as $i => $invoice)
                                            @php
                                                $productId = $invoice->lines->data[0]->price->product ?? null;
                                                $sub = $subscriptions[$invoice->subscription] ?? null;
                                                $now = \Carbon\Carbon::now()->timestamp;
                                                $isExpired =
                                                    $sub &&
                                                    $sub->status !== 'canceled' &&
                                                    $sub->current_period_end < $now;
                                            @endphp
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $products[$productId]->name ?? 'Plan' }}
                                                    {{ $products[$productId]->metadata->is_free == '0' && $invoice->amount_paid == 0 ? '( Trial)' : '' }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::createFromTimestamp($invoice->created)->format('d M Y') }}
                                                </td>
                                                <td>
                                                    {{ $sub && $sub->current_period_end ? \Carbon\Carbon::createFromTimestamp($sub->current_period_end)->format('d M Y') : 'N/A' }}
                                                </td>
                                                <td>{{ strtoupper($invoice->currency) }}
                                                    {{ number_format($invoice->amount_paid / 100, 2) }} </td>
                                                <td>
                                                    {{ $sub && $sub->canceled_at ? \Carbon\Carbon::createFromTimestamp($sub->canceled_at)->format('d M Y') : '' }}
                                                </td>
                                                <td>
                                                    @if ($sub && $sub->status === 'trialing')
                                                        <span class="badge bg-info">Trial (Ends
                                                            {{ \Carbon\Carbon::createFromTimestamp($sub->trial_end)->format('d M Y') }})</span>
                                                    @elseif ($sub && $sub->status === 'active' && !$sub->cancel_at && !$isExpired)
                                                        <span class="badge bg-success">Active</span>
                                                    @elseif ($sub && $sub->status === 'canceled')
                                                        <span class="badge bg-danger">Cancelled</span>
                                                    @elseif ($isExpired)
                                                        <span class="badge bg-secondary">Ended</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">Unknown</span>
                                                    @endif

                                                </td>
                                                <td>
                                                    @if ($sub && $sub->status === 'trialing')
                                                        <span>
                                                            N/A
                                                        </span>
                                                    @else
                                                        <a href="{{ route('downloadInvoice', $invoice->id) }}"
                                                            target="_blank">View Invoice</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>



                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('#myTab .nav-link');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => {
                        t.classList.remove('active');
                        t.style.backgroundColor = '#ffffff';
                        t.style.color = '#281F48';
                    });
                    this.classList.add('active');
                    this.style.backgroundColor = '#281F48';
                    this.style.color = '#ffffff';
                });
            });
        });
    </script>
@endsection
