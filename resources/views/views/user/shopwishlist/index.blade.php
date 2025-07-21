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
              
                <h2 class="sec mb-0 primary-color-custom">Shop Wishlist</h2>
            </div>
        </div>
    </div>

    <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="container">
                @if (count($wishlists) < 1)
               	   <div class="d-flex pt-5 mb-3 justify-content-center">
				   <img src="{{ asset('web/bikes/images/wishlist.svg') }}" class="img-fluid" style="height:150px;">
			</div>
    <h3 class="text-center mx-auto  " style="color:#281F48">No wishlist item found</h3>
                @endif

                <div class="row pb-4 gy-3">
                    @foreach ($wishlists as $wishlist)
                        <div class="col-lg-6 py-2">
                            <div class="row gy-3">
                                <div class="col-lg-12">
                                    <div class="wishlist-card"
                                        onclick="location.href='{{ route('shopdetail', $wishlist->shop_id) }}';"
                                        style="cursor: pointer;">

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="img-bg-home-2" style="position: relative;">
                                                    @auth
                                                        <a href="{{ !Request::is('superadmin/*') ? route('shops.wishlist.add', ['shop' => $wishlist->shop_id, 'user' => Auth::id()]) : '#' }}"
                                                            class="action-btn" onclick="event.stopPropagation();">
                                                            <i class="bi bi-heart-fill text-danger"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('login') }}" class="action-btn"
                                                            onclick="event.stopPropagation();">
                                                            <i class="bi bi-heart-fill text-light"></i>
                                                        </a>
                                                    @endauth

                                                    <img src="{{ $wishlist->shop->logo }}" class="img-adj-card">
                                                </div>
                                            </div>

                                            <div class="col-lg-9 my-auto">
                                                <div class="pe-lg-3 px-lg-0 pb-lg-0 p-3">
                                                    <h4 style="color:#281F48">{{ $wishlist->shop->name }}</h4>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        @php
                                                            $currentDay = date('l');
                                                            $timings = $wishlist->shop->shop_timings
                                                                ->where('day', $currentDay)
                                                                ->first();
                                                        @endphp
                                                        <p class="fourteen">
                                                            @if ($timings)
                                                                <span style="color: #2ab500;font-weight: 600;"
                                                                    class="openclosed">Open
                                                                    Now
                                                                </span>
                                                                {{ date('h:i A', strtotime($timings->start_time)) }}
                                                                -
                                                                {{ date('h:i A', strtotime($timings->end_time)) }}
                                                            @else
                                                                <span style="color: orangered;"
                                                                    class="openclosed">Closed</span>
                                                            @endif
                                                        </p>
                                                        <h6 class="mb-0">
                                                            <i class="bi bi-geo-alt"></i>
                                                            {{ $wishlist->shop->address }}
                                                        </h6>
                                                    </div>
                                                    <hr style="border: none; height: 2px; background-color: #66666680;">
                                                    <div class="row">
                                                        <div class="col-12 d-flex justify-content-between">
                                                            @foreach ($wishlist->shop->shop_services as $i => $shopservice)
                                                                @if ($i < 3)
                                                                    <strong>
                                                                        <p class="eighteenwhitee mt-3">
                                                                            {{ $shopservice->service->name }}</p>
                                                                    </strong>
                                                                @endif
                                                            @endforeach
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

                    {{ $wishlists->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="wishlistresponse" tabindex="-1" aria-labelledby="wishlistresponseLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                <!-- Modal Header -->
                <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                    <h5 class="modal-title" id="wishlistresponseLabel"><strong> Wishlist</strong></h5>
                    <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body text-center"  style="background-color: #F0F3F6; color: #FD5631;" >
                    <p>{{ session('wishlistresponse') }}</p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                    <button type="button" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    </div>



    {{-- success modal end --}}

    @if (session('wishlistresponse'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                let modal = new bootstrap.Modal(document.getElementById('wishlistresponse'));
                modal.show();
            });
        </script>
    @endif
@endsection
