{{-- @dd($whishlists[0]->post->id) --}}
@extends('layout.panel_layout.main')
@section('content')
<style>
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
   <div class="container">
	     <div class="row mt-lg-3 mt-3">
        <div class="col-lg-12 d-flex align-items-center">
			 
            <h2 class="sec mb-0 primary-color-custom">Wishlist</h2>
        </div>

    </div>
	   <div class="row ">
	 
            <div class="col-md-12 text-center row d-none">

                <ul class="nav nav-tabs" style="border:none" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-links active " id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                            type="button" role="tab" aria-controls="home" aria-selected="true">Cars</button>
                    </li>
                    <li class="nav-item m-0" role="presentation">
                        <button class="nav-links " id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab" aria-controls="profile" aria-selected="false">Bikes</button>
                    </li>
                </ul>

            </div>
       
	   </div>
	   </div>
  <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            {{-- tab start  --}}
<div class="container">
  
    @if(count($whishlists) < 1)
							   <div class="d-flex pt-5 mb-3 justify-content-center">
				   <img src="{{ asset('web/bikes/images/wishlist.svg') }}" class="img-fluid" style="height:150px;">
			</div>
    <h3 class="text-center mx-auto  " style="color:#281F48">No wishlist item found</h3>
    @endif
  <div class="row  pb-4 gy-3">
    @foreach($whishlists as $wishlist)
    
  
        <div class="col-lg-6 py-2">
            <div class="row  gy-3">
                <div class="col-lg-12">
                    <div class="wishlist-card" onclick="location.href='{{Request::is('superadmin/*') ? route('superadmin.cardetail', $wishlist->post->id) : route('cardetail', $wishlist->post->id) }}';" style="cursor: pointer;">
						 
                        <div class="row">
                            <div class="col-lg-3">
                                <?php
                                $main = $wishlist->post->document->first();

                                ?>
                                <div class="img-bg-home-2" style="position: relative;">
                                    <!-- <i class="bi bi-heart"></i> -->
                                    @auth
                                    <a 
    @if (!Request::is('superadmin/*')) 
        href="{{ route('add-to-wishlist', ['post_id' => $wishlist->post->id, 'dealer_id' => Auth::id()]) }}" 
    @else 
        href="" 
    @endif 
    class="action-btn"
>
    <i class="bi bi-heart-fill text-danger"></i>
</a>

                                    @else
                                    <a href="{{route('login')}}" class="action-btn">
                                        <i class="bi bi-heart-fill  text-light"></i>
                                    </a>
                                    @endauth
                                  <img src="{{url('posts/doc/'.$main->doc_name)}}" class="img-adj-card">

                                </div>
                            </div>
                            <div class="col-lg-9 my-auto">
                                <div class="pe-lg-3 px-lg-0 pb-lg-0  p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>{{$wishlist->post->year}}</h6>
                                        <span class="rounded px-3 py-1 text-capitalize" style="background-color: {{$wishlist->post->condition == 'new' ? '#4581F9; ' : '#0EB617; '}} font-size:12px;">{{$wishlist->post->condition}} </span>
                                    </div>
                                    <h4 style="color:#281F48">{{$wishlist->post->makename}} {{$wishlist->post->modelname}} </h4>
                                    <h5 style="color: #FD5631;"><b>PKR {{$wishlist->post->price}} </b></h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0"><i class="bi bi-geo-alt"></i> {{$wishlist->post->location->cityname}} </h6>
                                        <?php

                                        $date = $wishlist->post->updated_at;
                                        $formattedDate = "Last Updated: " . date("F j, Y", strtotime($date));
                                        ?>
                                        <span style="font-size:14px">{{$formattedDate}}</span>
                                    </div>
                             <hr style="border: none; height: 2px; background-color: #66666680;">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="text-center py-1"
                                                style="background-color:#F6F6F6; border-radius: 10px;">
                                                <i class="bi bi-speedometer2"></i>
                                                <h6>{{$wishlist->post->milleage}} KM</h6>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-center py-1"
                                                style="background-color:#F6F6F6; border-radius: 10px;">
                                                <i class="bi bi-car-front-fill"></i>
                                                <h6>{{$wishlist->post->transmission}} </h6>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-center py-1"
                                                style="background-color:#F6F6F6; border-radius: 10px;">
                                                <i class="bi bi-fuel-pump-diesel"></i>
                                                <h6>{{$wishlist->post->fuel}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
					</a>
                </div>
            </div>
        </div>


    @endforeach
	   {{ $whishlists->links('pagination::bootstrap-5') }}
	      </div>
</div>
  </div>
        {{-- tab end  --}}
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            {{-- tab start  --}}
			<div class="container">

    @if(count($whishlists) < 1)
    <h3 class="text-center mx-auto my-5 py-5">No wishlist item found</h3>
    @endif
  <div class="row  py-4 gy-3">
    @foreach($whishlists as $wishlist)
    
  
        <div class="col-lg-6 py-2">
            <div class="row  gy-3">
                <div class="col-lg-12">
                    <div class="wishlist-card" onclick="location.href='{{Request::is('superadmin/*') ? route('superadmin.cardetail', $wishlist->post->id) : route('cardetail', $wishlist->post->id) }}';" style="cursor: pointer;">
						 
                        <div class="row">
                            <div class="col-lg-3">
                                <?php
                                $main = $wishlist->post->document->first();

                                ?>
                                <div class="img-bg-home-2" style="position: relative;">
                                    <!-- <i class="bi bi-heart"></i> -->
                                    @auth
                                    <a 
    @if (!Request::is('superadmin/*')) 
        href="{{ route('add-to-wishlist', ['post_id' => $wishlist->post->id, 'dealer_id' => Auth::id()]) }}" 
    @else 
        href="" 
    @endif 
    class="action-btn"
>
    <i class="bi bi-heart-fill text-danger"></i>
</a>

                                    @else
                                    <a href="{{route('login')}}" class="action-btn">
                                        <i class="bi bi-heart-fill  text-light"></i>
                                    </a>
                                    @endauth
                                  <img src="{{url('posts/doc/'.$main->doc_name)}}" class="img-adj-card">

                                </div>
                            </div>
                            <div class="col-lg-9 my-auto">
                                <div class="pe-lg-3 px-lg-0 pb-lg-0  p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6>{{$wishlist->post->year}}</h6>
                                        <span class="rounded px-3 py-1 text-capitalize" style="background-color: {{$wishlist->post->condition == 'new' ? '#4581F9; ' : '#0EB617; '}} font-size:12px;">{{$wishlist->post->condition}} </span>
                                    </div>
                                    <h4 style="color:#281F48">{{$wishlist->post->makename}} {{$wishlist->post->modelname}} </h4>
                                    <h5 style="color: #FD5631;"><b>PKR {{$wishlist->post->price}} </b></h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0"><i class="bi bi-geo-alt"></i> {{$wishlist->post->location->cityname}} </h6>
                                        <?php

                                        $date = $wishlist->post->updated_at;
                                        $formattedDate = "Last Updated: " . date("F j, Y", strtotime($date));
                                        ?>
                                        <span style="font-size:14px">{{$formattedDate}}</span>
                                    </div>
                             <hr style="border: none; height: 2px; background-color: #66666680;">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="text-center py-1"
                                                style="background-color:#F6F6F6; border-radius: 10px;">
                                                <i class="bi bi-speedometer2"></i>
                                                <h6>{{$wishlist->post->milleage}} KM</h6>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-center py-1"
                                                style="background-color:#F6F6F6; border-radius: 10px;">
                                                <i class="bi bi-car-front-fill"></i>
                                                <h6>{{$wishlist->post->transmission}} </h6>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-center py-1"
                                                style="background-color:#F6F6F6; border-radius: 10px;">
                                                <i class="bi bi-fuel-pump-diesel"></i>
                                                <h6>{{$wishlist->post->fuel}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
					</a>
                </div>
            </div>
        </div>


    @endforeach
	   {{ $whishlists->links('pagination::bootstrap-5') }}
	      </div>
</div>
  </div>
@endsection