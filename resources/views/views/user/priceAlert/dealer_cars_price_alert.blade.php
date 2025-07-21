@extends('layout.panel_layout.main')
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
    </style>
    <!-- Buttons to toggle between Ads and Services -->
    <div class="container my-3">
        <div class="row">
            <div class="col-md-6">
                <h2 class="sec mb-0 primary-color-custom">Price Alerts</h2>

            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1"
                            type="button" role="tab" style="background-color: #281F48; color: white;">
                            Cars Price Alert
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button"
                            role="tab" style="background-color: white; color: #281F48;">
                            Bike Price Alert
                        </button>
                    </li>
                </ul>

            </div>


        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Nav Tabs -->

                <div class="tab-content" id="myTabContent">
                    <!-- Tab 1 -->
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel">
						
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        {{-- <th>Image</th> --}}
                                        <th>Car</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>User Phone</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($car_price_alerts) == 0)
                                        <tr>
                                            <td colspan="8" class="text-center">No Car Price Alert Found</td>
                                        </tr>
                                    @endif

                                    @foreach ($car_price_alerts as $i => $car_price_alert)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            {{-- <td>{{ url('posts/doc/' . $main->doc_name) }}</td> --}}
                                            <td>{{ $car_price_alert->post->make_name . ' ' . $car_price_alert->post->model_name ?? 'N/A' }}
                                            </td>
                                            <td>{{ $car_price_alert->user->name ?? 'N/A' }}</td>
                                            <td>{{ $car_price_alert->user->email ?? 'N/A' }}</td>
                                            <td>{{ $car_price_alert->user->number ?? 'N/A' }}</td>
                                            <td>{{ \carbon\Carbon::parse($car_price_alert->created_at)->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 2 -->
                    <div class="tab-pane fade" id="tab2" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        {{-- <th>Image</th> --}}
                                        <th>Bike</th>
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>User Phone</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($bike_price_alerts) == 0)
                                        <tr>
                                            <td colspan="8" class="text-center">No Bike Price Alert Found</td>
                                        </tr>
                                    @endif

                                    @foreach ($bike_price_alerts as $i => $bike_price_alert)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            {{-- <td>{{ url('posts/doc/' . $main->doc_name) }}</td> --}}
                                            <td>{{ $bike_price_alert->post->make_name . ' ' . $bike_price_alert->post->model_name ?? 'N/A' }}
                                            </td>
                                            <td>{{ $bike_price_alert->user->name ?? 'N/A' }}</td>
                                            <td>{{ $bike_price_alert->user->email ?? 'N/A' }}</td>
                                            <td>{{ $bike_price_alert->user->number ?? 'N/A' }}</td>
                                            <td>{{ \carbon\Carbon::parse($bike_price_alert->created_at)->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 3 -->

                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const adsButton = document.getElementById('adsButton');
            const servicesButton = document.getElementById('servicesButton');
            const adsTable = document.getElementById('adsTable');
            const servicesTable = document.getElementById('servicesTable');

            // Initially, show Ads table and hide Services table
            adsTable.style.display = 'block';
            servicesTable.style.display = 'none';

            adsButton.addEventListener('click', function() {
                adsTable.style.display = 'block';
                servicesTable.style.display = 'none';
            });

            servicesButton.addEventListener('click', function() {
                servicesTable.style.display = 'block';
                adsTable.style.display = 'none';
            });
        });
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
