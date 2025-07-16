{{-- @dd($whishlists[0]->post->id) --}}
@extends('layout.panel_layout.main')
@section('content')

<div class="container">
    <div class="mt-3 row mt-lg-3">
		        <div class="col-lg-12 d-flex align-items-center">
	
            <h2 class="sec mb-0 primary-color-custom">Bike Price Alerts</h2>
        </div>
      

    </div>
    @if(count($priceAlerts) < 1)
        <h3 class="py-5 mx-auto my-5 text-center text-dark">No price alert found</h3>
        @endif
        <div class="py-3 row gy-3">
            @foreach($priceAlerts as $priceAlert)


            <div class="py-2 col-lg-6">
                <div class="row gy-3">
                    <div class="col-lg-12">
                        <div class="wishlist-card" onclick="location.href='{{Request::is('superadmin/*') ? route('superadmin.bikedetail', $priceAlert->post->id) : route('bikedetail', $priceAlert->post->id) }}';" style="cursor: pointer;">
                            <div class="row">
								
                                <div class="col-lg-3 pe-0">
                                  
                                    <div class="img-bg-home-2" style="position: relative;">
                                     

                                        
                                            <img src="{{ $priceAlert->post->media[0]->file_path ?? asset('web/bikes/images/logo.svg') }}" class="img-adj-card">
                                        
                                        
                                    </div>

                                </div>
									
                                <div class="my-auto col-lg-9">
                                    <div class="p-3 pe-lg-3 px-lg-0 pb-lg-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6>{{$priceAlert->post->year}}</h6>
                                            <span class="px-3 py-1 rounded text-capitalize" style="background-color: {{$priceAlert->post->condition == 'new' ? '#4581F9; ' : '#0EB617; '}} font-size:12px; color:white">{{$priceAlert->post->condition}} </span>
                                        </div>
                                    <span class="d-flex justify-content-between align-items-center">    <h4 class="m-0" style="color:#281F48">{{$priceAlert->post->makename}} {{$priceAlert->post->modelname}} </h4>
										   @auth
                                        <div class="col-4 text-end align-items-center mt-2" style="background-color:#281F48; border-radius:5px">
                                            <div class="toggle-container d-flex align-items-center justify-content-center">
                                                <span class="me-2" style="font-size:12px ;color:white;">Price Alert</span>
                                                <a @unless(Request::is('superadmin/*')) href="{{ route('bike_ads.add-price-alert', ['post_id' => $priceAlert->post->id, 'dealer_id' => Auth::id()]) }}" @endunless class="action-btn-2">
                                                    <i class="bi {{ isset($priceAlert) && $priceAlert->status == 1 ? 'bi-toggle2-on text-danger' : 'bi-toggle2-off text-light' }} fs-4"></i>
                                                </a>
                                            </div>
                                        </div> </span>
                                        @else
                                        <a href="{{route('login')}}" class="action-btn">
                                            <i class="bi bi-heart-fill text-light"></i>
                                        </a>
                                        @endauth
                                        <h5 style="color: #FD5631;"><b>PKR {{$priceAlert->post->price}} </b>
											@if(!empty($priceAlert->post->previous_price) && $priceAlert->post->previous_price != $priceAlert->post->price)
												<span style="text-decoration: line-through; color: gray; font-weight: normal; font-size:small"
                                                class="{{$priceAlert->post->previous_price > $priceAlert->post->price ? '' : 'd-none'}}">
													PKR {{$priceAlert->post->previous_price}}
												</span>
											@endif
										</h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0"><i class="bi bi-geo-alt"></i> {{$priceAlert->post->location->cityname}} </h6>
                                            <?php

                                            $date = $priceAlert->post->updated_at;
                                            $formattedDate = "Last Updated: " . date("F j, Y", strtotime($date));
                                            ?>
                                            <span style="font-size:14px">{{$formattedDate}}</span>
                                        </div>
                                 <hr style="border: none; height: 1px; background-color: #66666680;">

                                        <div class="row pb-3">
                                            <div class="col-4">
                                                <div class="py-1 text-center"
                                                    style="background-color:#FAFAFA; border-radius: 10px;">
                                                    <i class="bi bi-speedometer2"></i>
                                                    <h6>{{$priceAlert->post->mileage}} KM</h6>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="py-1 text-center"
                                                    style="background-color:#FAFAFA; border-radius: 10px;">
                                                             <i class="fa fa-motorcycle fs-5" aria-hidden="true" style="color: #281F48;"></i>
                                                    <h6>{{$priceAlert->post->transmission}} </h6>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="py-1 text-center"
                                                    style="background-color:#FAFAFA; border-radius: 10px;">
                                                    <i class="bi bi-fuel-pump-diesel"></i>
                                                    <h6>{{$priceAlert->post->fuel_type}}</h6>
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


            @endforeach
            {{-- {{ $priceAlerts->links('pagination::bootstrap-5') }} --}}
        </div>
</div>

@endsection