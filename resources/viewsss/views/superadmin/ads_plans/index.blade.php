@extends('layout.superadmin_layout.main')

@section('content')
    <style>
        .nav-tabs .nav-link {
            color: white;
            background-color: #281F48;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .nav-tabs .nav-link.active {
            color: #281F48;
            background-color: #F0F3F6;
        }

        .nav-tabs .nav-link:hover {
            color:  #281F48;
            background-color: white;
        }

        .table-responsive {
            scrollbar-width: thin;
            scrollbar-color: #281F48 #f1f1f1;
        }

        .table-responsive::-webkit-scrollbar {
            width: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
    </style>

    <div class="container mt-3">
        <div class="row align-items-center mb-4">
          
            <div class="col-md-12">
                <h2 class="sec mb-0 primary-color-custom">Subscription Plans</h2>
            </div>
        </div>

        {{-- Bootstrap Nav Tabs --}}
        <ul class="nav nav-tabs mb-2 " style="border:none" id="planTab" role="tablist">
            <li class="nav-item" role="presentation"> 
                <button class="nav-link active" id="ads-tab" data-bs-toggle="tab" data-bs-target="#ads" type="button"
                    role="tab" aria-controls="ads" aria-selected="true">Ads Plans</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="service-tab" data-bs-toggle="tab" data-bs-target="#service" type="button"
                    role="tab" aria-controls="service" aria-selected="false">Service Plans</button>
            </li>
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content" id="planTabContent">
            {{-- Ads Plans --}}
            <div class="tab-pane fade show active" id="ads" role="tabpanel" aria-labelledby="ads-tab">
                <div class="table-responsive">
                    <table class="table table-striped align-middle datatable">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plans as $key => $plan)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $plan->name }}</td>
                                    <td>{{ $plan->type == 'private_seller' ? 'Private Seller' : 'Car Dealer' }}</td>
                                    <td>{{ $plan->price ?? 'Free Forever' }}</td>
                                    <td>
                                        <i class="bi bi-eye-fill" data-bs-toggle="modal"
                                            data-bs-target="#viewPlanFeaturesModalAds{{ $plan->id }}"></i>
                                    </td>
                                </tr>

                                {{-- Modal --}}
                                <div class="modal fade" id="viewPlanFeaturesModalAds{{ $plan->id }}" tabindex="-1"
                                    aria-labelledby="modalLabelAds{{ $plan->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabelAds{{ $plan->id }}">Plan Features</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <ul>
                                                    @foreach ($plan->features as $feature)
                                                        <li>{{ $feature->feature }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Service Plans --}}
            <div class="tab-pane fade" id="service" role="tabpanel" aria-labelledby="service-tab">
                <div class="table-responsive">
                    <table class="table table-striped align-middle datatable">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Name</th>
                                {{-- <th>Type</th> --}}
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($serviceplans as $key => $plan)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $plan->name }}</td>
                                    {{-- <td>{{ $plan->type == 'private_seller' ? 'Private Seller' : 'Car Dealer' }}</td> --}}
                                    <td>{{ $plan->price ?? 'Free Forever' }}</td>
                                    <td>
                                        <i class="bi bi-eye-fill" data-bs-toggle="modal"
                                            data-bs-target="#viewPlanFeaturesModalService{{ $plan->id }}"></i>
                                    </td>
                                </tr>

                                {{-- Modal --}}
                                <div class="modal fade" id="viewPlanFeaturesModalService{{ $plan->id }}" tabindex="-1"
                                    aria-labelledby="modalLabelService{{ $plan->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabelService{{ $plan->id }}">Plan Features</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <ul>
                                                    @foreach ($plan->features as $feature)
                                                        <li>{{ $feature->feature }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Success Modal --}}
    <div class="modal fade" id="plansresponse" tabindex="-1" aria-labelledby="plansresponseLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="plansresponseLabel">Plans Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ session('plansresponse') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @if (session('plansresponse'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                let modal = new bootstrap.Modal(document.getElementById('plansresponse'));
                modal.show();
            });
        </script>
    @endif
@endsection
