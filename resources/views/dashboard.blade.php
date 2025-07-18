@extends('layout.panel_layout.main')

@section('content')
    <style>
        .sixteen {
            font-size: 14px;
            font-weight: 500;
            color: #0000004D;
        }

        .eighteens {
            font-size: 18px;
            font-weight: 600;
            color: #281F48;
        }

        .newsixteen {
            font-size: 16px;
            font-weight: 500;
            color: #0000004D;
        }

        .divnewclas {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 5px #0000001A;
        }

        .minh {
            font-size: 22px;
            font-weight: 600;
            color: #FFFFFF;
        }

        .neweig {
            font-size: 16px;
            font-weight: 500;
            color: #FFFFFF;
        }

        .neweig1 {
            font-size: 18px;
            font-weight: 600;
            color: #FFFFFF;
        }

        .neweig12 {
            font-size: 12px;
            font-weight: 500;
            color: #FFFFFF;
        }

        .eighteens1 {
            font-size: 18px;
            font-weight: 600;
            color: #281F48;
        }

        .sixteen2 {
            font-size: 16px;
            font-weight: 500;
            color: #281F48;
        }
    </style>





    @if (Auth::user()->role == '0')
        @php
            $carwishlist = App\Models\Whishlist::where('user_id', Auth::user()->id)
                ->where('status', 1)
                ->count();
            $bikewishlist = App\Models\Bike\BikeWishlist::where('user_id', Auth::user()->id)
                ->where('status', 1)
                ->count();
            $shopwishlist = App\Models\AutoServices\ShopWishlist::where('user_id', Auth::user()->id)->count();
            $carpricealert = App\Models\PriceAlert::where('user_id', Auth::user()->id)
                ->where('status', 1)
                ->count();
            $bikepricealert = App\Models\Bike\BikePriceAlert::where('user_id', Auth::user()->id)
                ->where('status', 1)
                ->count();
            $submitted_car_leads = App\Models\SubmittedForm::where('user_id', Auth::user()->id)->count();
            $submitted_bike_leads = App\Models\Bike\BikeLeads::where('user_id', Auth::user()->id)->count();
            $submitted_service_leads = App\Models\AutoServices\Bookings::where('user_id', Auth::user()->id)->count();
            $shop = App\Models\Shops::where('dealer_id', Auth::user()->id)->first();
            if ($shop) {
                $service_lead_counts = App\Models\AutoServices\Bookings::where('shop_id', $shop->id)->count();
                $service_leads = App\Models\AutoServices\Bookings::with([
                    'shop',
                    'make_r',
                    'model_r',
                    'bodytype_r',
                    'user',
                ])
                    ->where('shop_id', $shop->id)
                    ->take(3)
                    ->get();
            } else {
                $service_lead_counts = 0;
            }

        @endphp

        <div class="container">
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('warning'))
                    <div class="alert alert-warning" role="alert">
                        {{ session('warning') }}
                    </div>
                @endif
				    <div class="col-md-6 p-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row rounded p-4" style="background: linear-gradient(to right, #1e1e60, #990033);">
                                <div class="col-md-12 d-flex">
                                    <div>
                                        <img src="{{ asset('web/images/image 65.svg') }}" class="img-fluid ">
                                    </div>
                                    <div>
                                        <p class="m-0 ms-2 pt-3 minh">Current Subscription Plans</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p class="m-0 neweig">Ads</p>
                                    <p class="m-0 neweig1">No plan subscribed yet.</p>
                                    {{-- <p class="m-0 neweig12">Exp: April, 18 2026</p> --}}
                                </div>
                                <div class="col-6">
                                    <p class="m-0 neweig">Service</p>
                                    @if (Auth::user()->shop_package)
                                        <p class="m-0 neweig1">{{ Auth::user()->shop_pkg->name }}</p>
                                        <p class="m-0 neweig12">Exp: {{ $service_sub->end_date }}</p>
                                    @else
                                        <p class="m-0 neweig1">No plan subscribed yet.</p>
                                        {{-- <p class="m-0 neweig12">Exp: April, 18 2026</p> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row">
                <div class="col-md-3 p-3">
                    <div class="row">
                        <a href="{{url('whishlist')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/car_wishlist.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                               
                                    <p class="m-0 sixteen2"> Car Wishlist</p>
                                </div>
                                <div class="col-md-4 my-3">
                              <p class="m-0 text-end eighteens1"><strong>{{ $carwishlist }}</strong></p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                        <a href="{{url('bike/wishlist')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/bike_wishlist.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                               
                                    <p class="m-0 sixteen2"> Bike Wishlist</p>
                                </div>
                                <div class="col-md-4 my-3">
                     <p class="m-0 text-end eighteens1"><strong>{{ $bikewishlist }}</strong></p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                        <a href="{{url('shops/wishlist')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/shop_wishlist.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                           
                                    <p class="m-0 sixteen2">Shop Wishlist</p>
                                </div>
                                <div class="col-md-4 my-3">
                          <p class="m-0 text-end eighteens1"><strong>{{ $shopwishlist }}</strong></p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                                  <a href="{{url('price-alert')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                      
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/car_price_alert.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                          
                                    <p class="m-0 sixteen2"> Car price alert</p>
                                </div>
                                <div class="col-md-4 my-3">
                                      <p class="m-0 text-end eighteens1"><strong>{{ $carpricealert }}</strong></p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                        <a href="{{url('bike/price-alert')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/bike_price_alert.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                          
                                    <p class="m-0 sixteen2"> Bike price alert</p>
                                </div>
                                <div class="col-md-4 my-3">
                                     <p class="m-0 text-end eighteens1"><strong>{{ $bikepricealert }}</strong></p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                        <a href="{{url('submitted-forms')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/submitted_car_leads.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                
                                    <p class="m-0 sixteen2">Submitted Car leads </p>
                                </div>
                                <div class="col-md-4 my-3">
                                     <p class="m-0 text-end eighteens1"><strong>{{ $submitted_car_leads }}</strong></p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                        <a href="{{url('submitted-bike-leads')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/submitted_bike_leads.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                         
                                    <p class="m-0 sixteen2">Submitted Bike leads</p>
                                </div>
                                <div class="col-md-4 my-3">
                                     <p class="m-0 text-end eighteens1"><strong>{{ $submitted_bike_leads }}</strong></p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                        <a href="{{url('submitted-service-quotes')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/submitted_services_leads.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                       
                                    <p class="m-0 sixteen2">Submitted Service leads</p>
                                </div>
                                <div class="col-md-4 my-3">
                                       <p class="m-0 text-end eighteens1"><strong>{{ $submitted_service_leads }}</strong></p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                @if (Auth::user()->shop_package && $shop)
                    <div class="col-md-3 p-3">
                        <div class="row">
                            <div class="col-md-12  rounded" style="background-color: white">

                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <img src="{{ asset('web/images/submitted_services_leads.svg') }}" class="img-fluid ">
                                    </div>
                                    <div class="col-md-8 my-3">

                                   
                                        <p class="m-0 sixteen2"> Service lead</p>
                                    </div>
                                    <div class="col-md-4 my-3">
                                      <p class="m-0 text-end eighteens1"><strong>{{ $service_lead_counts }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
        @if (Auth::user()->shop_package && $shop)
            <div class="container">
                <div class="row">

                    <div class="col-md-12 p-3">
                        <div class="row">
                            <div class="col-md-12 shadow p-3 mb-4 bg-white rounded">
                                <div class="d-flex justify-content-between">
                                    <p class="fw-bold">Services Leads</p>
                                    <p class="fw-bold">{{ $service_lead_counts }}</p>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="">
                                            <tr>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($service_leads) < 1)
                                                <tr>
                                                    <td colspan="5" class="text-center">No leads found</td>
                                                </tr>
                                            @endif
                                            @foreach ($service_leads as $lead)
                                                <tr>
                                                    <td>{{ $lead->type ?? '' }}</td>
                                                    <td>{{ $lead->make_r->name ?? '' . ' ' . $lead->model_r->name ??'' }}</td>
                                                    <td>{{ $lead->user->number ?? '' }}</td>
                                                    <td>{{ $lead->user->email ?? '' }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- @if (count($service_leads) > 3) --}}
                                    <a href="{{ url('service-quotes') }}" style="color: #F40000" class="fw-bold">Show
                                        more</a>
                                {{-- @endif --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

    @if (Auth::user()->role == '1')
        <div class="container">
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('warning'))
                    <div class="alert alert-warning" role="alert">
                        {{ session('warning') }}
                    </div>
                @endif
                @php
                    $totalcarads = App\Models\Post::where('dealer_id', Auth::user()->id)->count();
                    $totalbikeads = App\Models\Bike\BikePost::where('dealer_id', Auth::user()->id)->count();
                    $carleads = App\Models\SubmittedForm::where('dealer_id', Auth::user()->id)->count();
                    $bikeleads = App\Models\Bike\BikeLeads::where('dealer_id', Auth::user()->id)->count();
                    $carwishlist = App\Models\Whishlist::where('user_id', Auth::user()->id)
                        ->where('status', 1)
                        ->count();
                    $bikewishlist = App\Models\Bike\BikeWishlist::where('user_id', Auth::user()->id)
                        ->where('status', 1)
                        ->count();
                    $shopwishlist = App\Models\AutoServices\ShopWishlist::where('user_id', Auth::user()->id)->count();
                    $carpricealert = App\Models\PriceAlert::where('user_id', Auth::user()->id)
                        ->where('status', 1)
                        ->count();
                    $bikepricealert = App\Models\Bike\BikePriceAlert::where('user_id', Auth::user()->id)
                        ->where('status', 1)
                        ->count();
                    $submitted_car_leads = App\Models\SubmittedForm::where('user_id', Auth::user()->id)->count();
                    $submitted_bike_leads = App\Models\Bike\BikeLeads::where('user_id', Auth::user()->id)->count();
                    $submitted_service_leads = App\Models\AutoServices\Bookings::where(
                        'user_id',
                        Auth::user()->id,
                    )->count();
                    $carleadss = App\Models\SubmittedForm::with(['post', 'user'])
                        ->where('dealer_id', Auth::user()->id)
                        ->take(3)
                        ->get();

                    $bikeleadss = App\Models\Bike\BikeLeads::where('dealer_id', Auth::user()->id)
                        ->take(3)
                        ->get();

                    $shop = App\Models\Shops::where('dealer_id', Auth::user()->id)->first();
                    if ($shop) {
                        $service_lead_counts = App\Models\AutoServices\Bookings::where('shop_id', $shop->id)->count();
                        $service_leads = App\Models\AutoServices\Bookings::with([
                            'shop',
                            'make_r',
                            'model_r',
                            'bodytype_r',
                            'user',
                        ])
                            ->where('shop_id', $shop->id)
                            ->take(3)
                            ->get();
                    } else {
                        $service_lead_counts = 0;
                    }

                @endphp
				      <div class="col-md-6 p-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row rounded p-4" style="background: linear-gradient(to right, #1e1e60, #990033);">
                                <div class="col-md-12 d-flex">
                                    <div>
                                        <img src="{{ asset('web/images/image 65.svg') }}" class="img-fluid ">
                                    </div>
                                    <div>
                                        <p class="m-0 ms-2 pt-3 minh">Current Subscription Plans</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <p class="m-0 neweig">Ads</p>
                                    <p class="m-0 neweig1">{{ Auth::user()->ads_pkg->name }}</p>
                                    <p class="m-0 neweig12">Exp: {{ $ads_sub->end_date ?? '' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="m-0 neweig">Service</p>
                                    @if (Auth::user()->shop_package)
                                        <p class="m-0 neweig1">{{ Auth::user()->shop_pkg->name ?? '' }}</p>
                                        <p class="m-0 neweig12">Exp: {{ $service_sub->end_date ?? '' }}</p>
                                    @else
                                        <p class="m-0 neweig1">No plan subscribed yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<div class="row">
                <div class="col-md-3 p-3">
                    <div class="row">
                            <a href="{{url('ads')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/car.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                           
                                    <p class="m-0 sixteen2">Total Car ads</p>
                                </div>
                                <div class="col-md-4 my-3">
                            <p class="m-0 text-end  eighteens1" style="font:size:20px !important;"><strong>{{ $totalcarads }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                        <a href="{{url('bike/ads')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/bike.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                                
                                    <p class="m-0 sixteen2"> Total Bike ads</p>
                                </div>
                                <div class="col-md-4 my-3">
                               <p class="m-0 text-end eighteens1"><strong>{{ $totalbikeads }}</strong></p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                        <a href="{{url('lead')}}">
                        <div class="col-md-12 p-1 rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/submitted_car_leads.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                        
                                    <p class="m-0 sixteen2"> Car Leads</p>
                                </div>
                                <div class="col-md-4 my-3">
                                            <p class="m-0 text-end eighteens1"><strong>{{ $carleads }}</strong></p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                        <a href="{{url('leads/bikes')}}">
                        <div class="col-md-12 p-1 rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/submitted_bike_leads.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                         
                                    <p class="m-0 sixteen2"> Bike Leads</p>
                                </div>
                                <div class="col-md-4 my-3">
                                <p class="m-0 text-end eighteens1"><strong>{{ $bikeleads }}</strong></p>
                                </div>
                            </div>
                        </div></a>
                    </div>
                </div>
                @if (Auth::user()->shop_package && $shop)
                    <div class="col-md-3 p-3">
                        <div class="row">
                            <div class="col-md-12  rounded" style="background-color: white">

                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <img src="{{ asset('web/images/submitted_services_leads.svg') }}" class="img-fluid ">
                                    </div>
                                    <div class="col-md-8 my-3">

      
                                        <p class="m-0 sixteen2"> Service Leads</p>
                                    </div>
                                    <div class="col-md-4 my-3">
                                                <p class="m-0 text-end eighteens1"><strong>{{ $service_lead_counts }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-3 p-3">
                    <div class="row">
                          <a href="{{url('whishlist')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/car_wishlist.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                     
                                    <p class="m-0 sixteen2"> Car Wishlist</p>
                                </div>
                                <div class="col-md-4 my-3">
                                 <p class="m-0 text-end eighteens1"><strong>{{ $carwishlist }}</strong></p>
                                </div>
                            </div>
                        </div>
                          </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                         <a href="{{url('bike/wishlist')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/bike_wishlist.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                               
                                    <p class="m-0 sixteen2"> Bike Wishlist</p>
                                </div>
                                <div class="col-md-4 my-3">
                          <p class="m-0 text-end eighteens1"><strong>{{ $bikewishlist }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                           <a href="{{url('shops/wishlist')}}">
                        <div class="col-md-12 p-1 rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/shop_wishlist.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                              
                                    <p class="m-0 sixteen2">Shop Wishlist</p>
                                </div>
                                <div class="col-md-4 my-3">
                                   <p class="m-0 text-end eighteens1"><strong>{{ $shopwishlist }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                                 <a href="{{url('price-alert')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/car_price_alert.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

     
                                    <p class="m-0 sixteen2"> Car price alert</p>
                                </div>
                                <div class="col-md-4 my-3">
                                                       <p class="m-0 text-end eighteens1"><strong>{{ $carpricealert }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                              <a href="{{url('bike/price-alert')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/bike_price_alert.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                           
                                    <p class="m-0 sixteen2"> Bike price alert</p>
                                </div>
                                <div class="col-md-4 my-3">
                   <p class="m-0 text-end eighteens1"><strong>{{ $bikepricealert }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                           <a href="{{url('submitted-forms')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/submitted_car_leads.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                                 
                                    <p class="m-0 sixteen2">Submitted Car leads </p>
                                </div>
                                <div class="col-md-4 my-3">
                         <p class="m-0 text-end eighteens1"><strong>{{ $submitted_car_leads }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                             <a href="{{url('submitted-bike-leads')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/submitted_bike_leads.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                            
                                    <p class="m-0 sixteen2">Submitted Bike leads</p>
                                </div>
                                <div class="col-md-4 my-3">
                              <p class="m-0 text-end eighteens1"><strong>{{ $submitted_bike_leads }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                </div>
                <div class="col-md-3 p-3">
                    <div class="row">
                               <a href="{{url('submitted-service-quotes')}}">
                        <div class="col-md-12 p-1 rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/submitted_services_leads.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                              
                                    <p class="m-0 sixteen2">Submitted Service leads</p>
                                </div>
                                <div class="col-md-4 my-3">
                                  <p class="m-0 text-end eighteens1"><strong>{{ $submitted_service_leads }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                </div>


            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="{{ Auth::user()->shop_package ? 'col-md-4' : 'col-md-6' }} p-3">
                    <div class="row">
                        <div class="col-md-12 shadow p-3 mb-4 bg-white rounded">
                            <div class="d-flex justify-content-between">
                                <p class="fw-bold"> Car Leads</p>
                                <p class="fw-bold"> {{ $carleads }}</p>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th>Type</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            {{-- <th>Detail</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($carleadss) < 1)
                                            <tr>
                                                <td colspan="5" class="text-center">No leads found</td>
                                            </tr>
                                        @endif
                                        @foreach ($carleadss as $lead)
                                            <tr>
                                                <td>{{ $lead->requesttype ?? '' }}</td>
                                                <td>{{ $lead->post->makename ?? '' . ' ' . $lead->post->modelname ?? '' }}</td>
                                                <td>{{ $lead->user->number ?? '' }}</td>
                                                <td>{{ $lead->user->email ?? '' }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- @if (count($carleadss) > 3) --}}
                                <a href="{{ url('lead') }}" style="color: #F40000" class="fw-bold">Show
                                    more</a>
                            {{-- @endif --}}
                        </div>

                    </div>
                </div>
                <div class="{{ Auth::user()->shop_package ? 'col-md-4' : 'col-md-6' }} p-3">
                    <div class="row">
                        <div class="col-md-12 shadow p-3 mb-4 bg-white rounded">
                            <div class="d-flex justify-content-between">
                                <p class="fw-bold"> Bike Leads</p>
                                <p class="fw-bold">{{ $bikeleads }}</p>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th>Type</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            {{-- <th>Detail</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($bikeleadss) < 1)
                                            <tr>
                                                <td colspan="5" class="text-center">No leads found</td>
                                            </tr>
                                        @endif
                                        @foreach ($bikeleadss as $lead)
                                            <tr>
                                                <td>{{ $lead->requesttype ?? '' }}</td>
                                                <td>{{ $lead->post->makename ?? '' . ' ' . $lead->post->modelname ?? '' }}</td>
                                                <td>{{ $lead->user->number ?? '' }}</td>
                                                <td>{{ $lead->user->email ?? '' }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- @if (count($bikeleadss) > 3) --}}
                                <a href="{{ url('leads/bikes') }}" style="color: #F40000" class="fw-bold">Show
                                    more</a>
                            {{-- @endif --}}
                        </div>

                    </div>
                </div>
                @if (Auth::user()->shop_package && $shop)
                    <div class="col-md-4 p-2">
                        <div class="row">
                            <div class="col-md-12 shadow p-3 mb-4 bg-white rounded">
                                <div class="d-flex justify-content-between">
                                    <p class="fw-bold">Services Leads</p>
                                    <p class="fw-bold">{{ $service_lead_counts }}</p>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="">
                                            <tr>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($service_leads) < 1)
                                                <tr>
                                                    <td colspan="5" class="text-center">No leads found</td>
                                                </tr>
                                            @endif
                                            @foreach ($service_leads as $lead)
                                                <tr>
                                                    <td>{{ $lead->type ?? '' }}</td>
                                                    <td>{{ $lead->make_r->name ?? '' . ' ' . $lead->model_r->name ??'' }}</td>
                                                    <td>{{ $lead->user->number ?? '' }}</td>
                                                    <td>{{ $lead->user->email ?? '' }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- @if (count($service_leads) > 3) --}}
                                    <a href="{{ url('service-quotes') }}" style="color: #F40000" class="fw-bold">Show
                                        more</a>
                                {{-- @endif --}}
                            </div>

                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif



    @if (Auth::user()->role == '2')
        <div class="container">
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('warning'))
                    <div class="alert alert-warning" role="alert">
                        {{ session('warning') }}
                    </div>
                @endif

                @php

                    $userPermissions = \App\Models\UserPermission::where('user_id', Auth::user()->id)
                        ->pluck('permissions')
                        ->toArray();
                @endphp
                @php
                    $totalcarads = App\Models\Post::where('dealer_id', Auth::user()->dealer_id)->count();
                    $totalbikeads = App\Models\Bike\BikePost::where('dealer_id', Auth::user()->dealer_id)->count();
                    $carleads = App\Models\SubmittedForm::where('dealer_id', Auth::user()->dealer_id)->count();
                    $bikeleads = App\Models\Bike\BikeLeads::where('dealer_id', Auth::user()->dealer_id)->count();

                    $carleadss = App\Models\SubmittedForm::with(['post', 'user'])
                        ->where('dealer_id', Auth::user()->dealer_id)
                        ->take(3)
                        ->get();

                    $bikeleadss = App\Models\Bike\BikeLeads::where('dealer_id', Auth::user()->dealer_id)
                        ->take(3)
                        ->get();

                @endphp

                <div class="col-md-3 p-3 {{ in_array('view_leads', $userPermissions) ? '' : 'd-none' }}">
                    <div class="row">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/submitted_car_leads.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                           
                                    <p class="m-0 sixteen2">Total Car leads</p>
                                </div>
                                <div class="col-md-4 my-3">
                                  <p class="m-0 text-end eighteens1"><strong>{{ $carleads }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 p-3 {{ in_array('view_leads', $userPermissions) ? '' : 'd-none' }}">
                    <div class="row">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/submitted_bike_leads.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                               
                                    <p class="m-0 sixteen2">Total Bike leads</p>
                                </div>
                                <div class="col-md-4 my-3">
                                   <p class="m-0 text-end eighteens1"><strong>{{ $bikeleads }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 p-3 {{ in_array('manage_ads', $userPermissions) ? '' : 'd-none' }}">
                    <div class="row">
                        <a href="{{url('ads')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/car.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                                  
                                    <p class="m-0 sixteen2">Total Car ads</p>
                                </div>
                                <div class="col-md-4 my-3">
                        <p class="m-0 text-end eighteens1"><strong>{{ $totalcarads }}</strong></p>
                                </div>
                            </div>
                           
                        </div> </a>
                    </div>
                </div>
                <div class="col-md-3 p-3 {{ in_array('manage_ads', $userPermissions) ? '' : 'd-none' }}">
                    <div class="row">
                         <a href="{{url('bike/ads')}}">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/bike.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8 my-3">

                            
                                    <p class="m-0 sixteen2">Total Bike ads</p>
                                </div>
                                <div class="col-md-4 my-3">
                             <p class="m-0 text-end eighteens1"><strong>{{ $totalbikeads }}</strong></p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>





            </div>
        </div>
        <div class="container {{ in_array('view_leads', $userPermissions) ? '' : 'd-none' }}">
            <div class="row">
                <div class="col-md-6 p-3">
                    <div class="row">
                        <div class="col-md-12 shadow p-3 mb-4 bg-white rounded">
                            <div class="d-flex justify-content-between">
                                <p class="fw-bold"> Car Leads</p>
                                <p class="fw-bold"> {{ $carleads }}</p>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th>Type</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            {{-- <th>Detail</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($carleadss) < 1)
                                            <tr>
                                                <td colspan="5" class="text-center">No leads found</td>
                                            </tr>
                                        @endif
                                        @foreach ($carleadss as $lead)
                                            <tr>
                                                <td>{{ $lead->requesttype ?? '' }}</td>
                                                <td>{{ $lead->post->makename ?? '' . ' ' . $lead->post->modelname ?? '' }}</td>
                                                <td>{{ $lead->user->number ?? '' }}</td>
                                                <td>{{ $lead->user->email ?? '' }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- @if (count($carleadss) > 3) --}}
                                <a href="{{ url('lead') }}" style="color: #F40000" class="fw-bold">Show
                                    more</a>
                            {{-- @endif --}}
                        </div>

                    </div>
                </div>
                <div class="col-md-6 p-3">
                    <div class="row">
                        <div class="col-md-12 shadow p-3 mb-4 bg-white rounded">
                            <div class="d-flex justify-content-between">
                                <p class="fw-bold"> Bike Leads</p>
                                <p class="fw-bold">{{ $bikeleads }}</p>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th>Type</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            {{-- <th>Detail</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($bikeleadss) < 1)
                                            <tr>
                                                <td colspan="5" class="text-center">No leads found</td>
                                            </tr>
                                        @endif
                                        @foreach ($bikeleadss as $lead)
                                            <tr>
                                                <td>{{ $lead->requesttype ?? '' }}</td>
                                                <td>{{ $lead->post->makename ?? '' . ' ' . $lead->post->modelname ?? '' }}</td>
                                                <td>{{ $lead->user->number ?? '' }}</td>
                                                <td>{{ $lead->user->email ?? '' }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- @if (count($bikeleadss) > 3) --}}
                                <a href="{{ url('leads/bikes') }}" style="color: #F40000" class="fw-bold">Show
                                    more</a>
                            {{-- @endif --}}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    @endif



    @if (Auth::user()->role == '3')
        @php
            $shop = App\Models\Shops::where('dealer_id', Auth::user()->dealer_id)->first();
            if ($shop) {
                $service_lead_counts = App\Models\AutoServices\Bookings::where('shop_id', $shop->id)->count();
                $service_leads = App\Models\AutoServices\Bookings::with([
                    'shop',
                    'make_r',
                    'model_r',
                    'bodytype_r',
                    'user',
                ])
                    ->where('shop_id', $shop->id)
                    ->take(3)
                    ->get();
            } else {
                $service_lead_counts = 0;
$service_leads = null;
            }
        @endphp
        <div class="container">
            <div class="row">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('warning'))
                    <div class="alert alert-warning" role="alert">
                        {{ session('warning') }}
                    </div>
                @endif
               

                <div class="col-md-3 p-3">
                    <div class="row">
                        <div class="col-md-12  rounded" style="background-color: white">

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <img src="{{ asset('web/images/submitted_services_leads.svg') }}" class="img-fluid ">
                                </div>
                                <div class="col-md-8">

                          
                                    <p class="m-0 sixteen2">Total Service leads</p>
                                </div>
                                <div class="col-md-4">
                                          <p class="m-0 text-end eighteens1"><strong>{{$service_lead_counts}}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>







            </div>
        </div>
	@if($service_leads)
           <div class="container">
                <div class="row">

                    <div class="col-md-12 p-3">
                        <div class="row">
                            <div class="col-md-12 shadow p-3 mb-4 bg-white rounded">
                                <div class="d-flex justify-content-between">
                                    <p class="fw-bold">Services Leads</p>
                                    <p class="fw-bold">{{ $service_lead_counts }}</p>
                                </div>
	
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="">
                                            <tr>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($service_leads) < 1)
                                                <tr>
                                                    <td colspan="5" class="text-center">No leads found</td>
                                                </tr>
                                            @endif
                                            @foreach ($service_leads as $lead)
                                                <tr>
                                                    <td>{{ $lead->type ?? '' }}</td>
                                                    <td>{{ $lead->make_r->name ?? '' . ' ' . $lead->model_r->name ??'' }}</td>
                                                    <td>{{ $lead->user->number ?? '' }}</td>
                                                    <td>{{ $lead->user->email ?? '' }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- @if (count($service_leads) > 3) --}}
                                    <a href="{{ url('service-quotes') }}" style="color: #F40000" class="fw-bold">Show
                                        more</a>
                                {{-- @endif --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection
