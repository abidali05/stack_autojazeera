 {{-- @if ($shops->hasPages()) --}}
 @php
     $start = ($shops->currentPage() - 1) * $shops->perPage() + 1;
     $end = min($shops->currentPage() * $shops->perPage(), $shops->total());
 @endphp
 <style>
     .loading-overlay {
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background-color: rgba(255, 255, 255, 0.7);
         z-index: 9999;
         display: flex;
         align-items: center;
         justify-content: center;
     }

     /* Custom rotating loader */
     .loader {
         width: 60px;
         aspect-ratio: 1;
         border: 15px solid #ddd;
         border-radius: 50%;
         position: relative;
         transform: rotate(45deg);
     }

     .loader::before {
         content: "";
         position: absolute;
         inset: -15px;
         border-radius: 50%;
         border: 15px solid #514b82;
         animation: l18 2s infinite linear;
     }

     @keyframes l18 {
         0% {
             clip-path: polygon(50% 50%, 0 0, 0 0, 0 0, 0 0, 0 0)
         }

         25% {
             clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 0, 100% 0, 100% 0)
         }

         50% {
             clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 100% 100%, 100% 100%)
         }

         75% {
             clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 0 100%, 0 100%)
         }

         100% {
             clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 0 100%, 0 0)
         }
     }
 </style>
 <div class="row">
     <div class="col-md-6">
         <span class="row mt-2">
             {{ $start }} - {{ $end }} of {{ $shops->total() }} Results
         </span>
     </div>
     <div class="col-md-6">
         <nav class="d-flex justify-content-end align-items-center ">
             <!-- Page Info -->


             <!-- Pagination -->
             <ul class="pagination"
                 style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">

                 {{-- Previous Page Button --}}
                 @if ($shops->onFirstPage())
                     <li style="display: inline-block;">
                         <span
                             style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</span>
                     </li>
                 @else
                     @if (request()->isMethod('post'))
                         <li style="display: inline-block;">
                             <form method="POST" action="{{ request()->url() }}">
                                 @csrf
                                 <input type="hidden" name="page" value="{{ $shops->currentPage() - 1 }}">
                                 <input type="hidden" name="search" value="{{ request('search') }}">
                                 <input type="hidden" name="city" value="{{ request('city') }}">
                                 <button type="submit"
                                     style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                             </form>
                         </li>
                     @else
                         <li style="display: inline-block;">
                             <a href="{{ $shops->previousPageUrl() }}"
                                 style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                         </li>
                     @endif
                 @endif

                 {{-- Pagination Links --}}
                 @foreach ($shops->links()->elements as $element)
                     @if (is_string($element))
                         <li style="display: inline-block;">
                             <span
                                 style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                         </li>
                     @endif

                     @if (is_array($element))
                         @foreach ($element as $page => $url)
                             @if ($page == $shops->currentPage())
                                 <li style="display: inline-block;">
                                     <span
                                         style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #281F48; color: #fff;">{{ $page }}</span>
                                 </li>
                             @else
                                 @if (request()->isMethod('post'))
                                     <li style="display: inline-block;">
                                         <form method="POST" action="{{ request()->url() }}">
                                             @csrf
                                             <input type="hidden" name="page" value="{{ $page }}">
                                             <input type="hidden" name="search" value="{{ request('search') }}">
                                             <input type="hidden" name="city" value="{{ request('city') }}">
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

                 {{-- Next Page Button --}}
                 @if ($shops->hasMorePages())
                     @if (request()->isMethod('post'))
                         <li style="display: inline-block;">
                             <form method="POST" action="{{ request()->url() }}">
                                 @csrf
                                 <input type="hidden" name="page" value="{{ $shops->currentPage() + 1 }}">
                                 <input type="hidden" name="search" value="{{ request('search') }}">
                                 <input type="hidden" name="city" value="{{ request('city') }}">
                                 <button type="submit"
                                     style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                             </form>
                         </li>
                     @else
                         <li style="display: inline-block;">
                             <a href="{{ $shops->nextPageUrl() }}"
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

 {{-- @endif --}}

 @if (count($shops) == 0)
                  <div class=col-md-12>
		 <div class="row d-flex justify-content-center my-3">
		       <div class="p-3 col-8" style="border:1px solid #281F48;border-radius:9px;">
                    <div class="row">
                        <div class="col-3">
                            <img src="{{ asset('web/images/noinputs.svg') }}" alt="" class="img-fluid"
                                srcset="">
                        </div>
                        <div class="col-9 text-start">
                            <h1 style="color:#FD5631">Sorry</h1>
                            <p>No matches found for your search. Try adjusting your filters or expanding your criteria
                                to
                                explore available Shop!</p>

                        </div>
                    </div>
                </div>
		 </div>
</div>
 @endif
 <div class="shops-container" style="width:100%">
     <div id="loadingSpinner" class="loading-overlay d-none">
         <div class=" loader" role="status">
             <span class="visually-hidden">Loading...</span>
         </div>
     </div>
     @foreach ($shops as $shop)
         <div class="row mt-3 shopdiv" data-rating = "{{ $shop->rating }}">
             <div class="col-md-12" style="background-color: #F0F3F6; border-radius: 10px;">
                 <div class="row">
                     <div class="col-md-3 p-0">
                         <a href="{{ route('shopdetail', $shop->id) }}">
                             <div class="imagediv" style="height: 270px;">
                                 <img src="{{ $shop->logo }}" class="imagewidth" alt="...">
                             </div>
                         </a>
                     </div>

                     <div class="col-md-9">
                         <div class="row py-3 px-2">

                             <div class="col-md-7" onclick="{{ route('shopdetail', $shop->id) }}"
                                 style="cursor: pointer">
                                 <a href="{{ route('shopdetail', $shop->id) }}">
                                     <div class="row">
                                         <div class="col-md-12 px-4">
                                             <div class="row">
                                                 <div class="col-8">
                                                     <p class="twentyfour">{{ $shop->name }}</p>
                                                 </div>
                                                 <div class="col-4 d-flex justify-content-end">


                                                     <div class="rating-container">
                                                         @for ($i = 1; $i <= 5; $i++)
                                                             @php
                                                                 $rounded = round($shop->rating * 2) / 2; // e.g., 2.7 → 2.5
                                                             @endphp
                                                             <div class="star active"
                                                                 data-value="{{ $i }}">
                                                                 @if ($i <= floor($rounded))
                                                                     <i class="fas fa-star"></i>
                                                                     <!-- full star -->
                                                                 @elseif ($i == ceil($rounded) && fmod($rounded, 1) != 0)
                                                                     <i class="fas fa-star-half-alt"></i>
                                                                     <!-- half star -->
                                                                 @else
                                                                     <i class="far fa-star"></i>
                                                                     <!-- empty star -->
                                                                 @endif
                                                             </div>
                                                         @endfor

                                                     </div>

                                                 </div>
                                                 <div class="col-12 d-flex justify-content-between">

                                                     @php
                                                         $currentDay = date('l');
                                                         $timings = $shop->shop_timings
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


                                                     <div class="review-text" id="reviewText">
                                                         {{ $shop->rating }}
                                                         ({{ $shop->total_ratings }} reviews)
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="row">
                                                 <div class="col-12 d-flex justify-content-between">
                                                     @foreach ($shop->shop_services as $i => $shopservice)
                                                         @if ($i < 3)
                                                             <strong>
                                                                 <p class="eighteenwhitee mt-3">
                                                                     {{ $shopservice->service->name }}</p>
                                                             </strong>
                                                         @endif
                                                     @endforeach
                                                 </div>
                                                 <div class="col-12 borderbottom">
                                                     {{-- <p> <span class="fourteen "> <img
                                                                 src="{{ asset('web/services/images/Icon (Stroke).svg') }}"
                                                                 class="img-fluid me-2"
                                                                 alt="...">{{ $shop->address }}
                                                             ({{ $shop->distance }} km away)
                                                         </span></p> --}}
                                                 </div>
                                                 <div class="col-12 mt-3">
                                                     <p class="fourteen m-0">
                                                         {{ Str::limit($shop->description, 60) }}
                                                         <span style="color: #FD5631;">more</span>
                                                     </p>
                                                 </div>
                                             </div>
                                         </div>
                                 </a>
                             </div>
                         </div>

                         <div class="col-md-5 borderleft">
                             <div class="row">
                                 <div class="col-12">
                                     <div class="">
                                         @auth
                                             @if ($shop->dealer_id == auth()->user()->id)
                                                 <button class="button11 "
                                                     onclick="alert('You can not request a quote from your own shop')">Request
                                                     a
                                                     Quote</button>
                                                 <button class="button11 "
                                                     onclick="alert('You can not write a review from your own shop')"><i
                                                         class="bi bi-star text-white me-2"></i>Write
                                                     a review</button>
                                             @else
                                                 @if (Auth::user()->role == '2' || Auth::user()->role == '3')
                                                     <button class="button11 "
                                                         onclick="alert('You are not authorized for this action!')">Request
                                                         a
                                                         Quote</button>
                                                     <button class="button11 "
                                                         onclick="alert('You are not authorized for this action!')"><i
                                                             class="bi bi-star text-white me-2"></i>Write
                                                         a review</button>
                                                 @else
                                                     <button class="button11 " data-bs-toggle="modal"
                                                         data-bs-target="#requestQuoteModal{{ $shop->id }}">Request
                                                         a
                                                         Quote</button>
                                                     <button class="button11 " data-bs-toggle="modal"
                                                         data-bs-target="#reviewModal{{ $shop->id }}"><i
                                                             class="bi bi-star text-white me-2"></i>Write
                                                         a review</button>
                                                 @endif
                                             @endif
                                         @endauth

                                         @guest
                                             <a href="{{ route('login') }}" class="button11 ">Request a
                                                 Quote</a>
                                             <a href="{{ route('login') }}" class="button11 "><i
                                                     class="bi bi-star text-white me-2"></i>Write
                                                 a review</a>
                                         @endguest
                                     </div>
                                     <div class="d-flex justify-content-between align-items-center mt-4">
                                         <span class="pt-3 sixteen"
                                             style="word-break: break-word; max-width: 300px; display: inline-block;">
                                             @if ($shop->website)
                                                 {{ $shop->website }}
                                             @endif
                                         </span>

                                         <span>
                                             @auth
                                                 @php
                                                     $check = \App\Models\AutoServices\ShopWishlist::where(
                                                         'user_id',
                                                         auth()->id(),
                                                     )
                                                         ->where('shop_id', $shop->id)
                                                         ->first();
                                                 @endphp


                                             @endauth

                                             @guest
                                                 <a href="{{ route('login') }}"
                                                     style="background-color: transparent; border: none;">
                                                     <i class="bi bi-heart fs-4"></i>
                                                 </a>
                                             @endguest
                                             <img src="{{ asset('web/services/images/Group 1171275361.svg') }}"
                                                 class="img-fluid ms-3" alt="google map"
                                                 onclick="window.open('https://www.google.com/maps?q={{ $shop->latitude }},{{ $shop->longitude }}&output=embed', '_blank')">
                                         </span>
                                     </div>
                                     <div class="mt-4 pt-3">
                                         <p> <span class="fourteen "> <img
                                                     src="{{ asset('web/services/images/Icon (Stroke).svg') }}"
                                                     class="img-fluid me-2" alt="...">{{ $shop->address }}
                                                 ({{ $shop->distance }} km away)
                                             </span></p>



                                     </div>
                                     <div class="d-flex justify-content-between pt-4">
                                         @if ($shop->dealer->shop_pkg && $shop->dealer->shop_pkg->metadata->whatsapp_allowed == '1')
                                             <span class="twelvewhitee"
                                                 onclick="window.open('https://wa.me/{{ $shop->number }}','_blank')"
                                                 style="cursor: pointer"><img
                                                     src="{{ asset('web/services/images/whatsapp.svg') }}"
                                                     class="img-fluid me-2" alt="...">
                                             </span>
                                         @endif

                                         <span class="twelvewhitee {{ $shop->facebook ? '' : 'd-none' }}"
                                             onclick="window.open('{{ $shop->facebook }}','_blank')"
                                             style="cursor: pointer">
                                             <img src="{{ asset('web/services/images/facebook.svg') }}"
                                                 class="img-fluid me-2" alt="...">
                                         </span>

                                         <span class="twelvewhitee {{ $shop->instagram ? '' : 'd-none' }}"
                                             onclick="window.open('{{ $shop->instagram }}','_blank')"
                                             style="cursor: pointer"><img
                                                 src="{{ asset('web/services/images/instagram.svg') }}"
                                                 class="img-fluid me-2" alt="...">
                                         </span>

                                         <span class="twelvewhitee {{ $shop->twitter ? '' : 'd-none' }}"
                                             onclick="window.open('{{ $shop->twitter }}','_blank')"
                                             style="cursor: pointer"><img
                                                 src="{{ asset('web/services/images/Vector0.svg') }}"
                                                 class="img-fluid me-2" alt="...">
                                         </span>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

 </div>




 <!-- review Modal -->
 <div class="modal fade" id="reviewModal{{ $shop->id }}" tabindex="-1" aria-labelledby="uploadModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">


             <div class="modal-body">
                 <form action="{{ route('review.store') }}" method="post" enctype="multipart/form-data"
                     id="reviewForm">
                     @csrf

                     <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                     <div class="row mb-3">
                         <div class="col-md-12 d-flex justify-content-between">
                             <p class="fourtyeight">{{ $shop->name }}</p>
                             <button type="button" class="btn-close" data-bs-dismiss="modal"
                                 aria-label="Close"></button>
                         </div>
                         <div class="col-md-12 mb-2">
                             <div class="feedback-rating-container align-items-center ">
                                 <div id="feedback-stars-group">
                                     <span class="feedback-star-item" data-score="1">&#9733;</span>
                                     <span class="feedback-star-item" data-score="2">&#9733;</span>
                                     <span class="feedback-star-item" data-score="3">&#9733;</span>
                                     <span class="feedback-star-item" data-score="4">&#9733;</span>
                                     <span class="feedback-star-item" data-score="5">&#9733;</span>
                                     <input type="hidden" name="rating" id="rating-value" value="0">
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-12">
                             <div class="mb-3">
                                 <textarea class="form-controless" id="exampleFormControlTextarea1" rows="3" name="comment"></textarea>
                                 <p class="reed">You review should have at least 20 characters.</p>
                             </div>
                         </div>
                     </div>

                     <!-- Dropzone + Images Row -->
                     <div class="row g-3">
                         <div class="col-2">
                             <div class="dropzone text-center">
                                 <div class="upload-icon">
                                     <i class="bi bi-cloud-arrow-up fs-1 mb-3" style="color: #281F48;"></i>
                                 </div>
                                 <div class="upload-text">Upload Photo Here</div>
                                 <div class="upload-subtext">Maximum 10 Photos</div>
                                 <div id="image-counter" class="mt-1" style="font-size: 10px; color: #281F48;">
                                     0/10
                                     photos</div>
                                 <input type="file" multiple class="upload-input" accept="image/*"
                                     name="review_images[]" />
                             </div>
                         </div>

                         <!-- Empty divs for images -->
                         <div class="col-2 image-box"></div>
                         <div class="col-2 image-box"></div>
                         <div class="col-2 image-box"></div>
                         <div class="col-2 image-box"></div>
                         <div class="col-2 image-box"></div>
                     </div>

             </div>

             <div class="modal-footer d-flex justify-content-start" style="border: none;">
                 <button type="button" class="whitebtn py-2" data-bs-dismiss="modal"
                     onclick="window.location.reload();">Cancel</button>
                 <button type="submit" class="bluebtn py-2" id="submit-review-btn">Submit Review</button>
             </div>
             </form>

         </div>
     </div>
 </div>



 {{-- request quote modal start --}}
 <div class="modal fade classcrol" id="requestQuoteModal{{ $shop->id }}" data-bs-backdrop="static"
     data-bs-keyboard="false" tabindex="-1" aria-labelledby="requestQuoteModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable custom-modal-width">
         <div class="modal-content">
             <form id="multiStepForm{{ $shop->id }}" class="multiStepForm">
                 <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                 <div class="modal-header" style="border: none;">
                     <!-- Optional Header -->
                 </div>
                 <div class="modal-body pt-0">
                     <div class="d-flex justify-content-between">
                         <p class="fourtyeight ps-4 m-0 ms-3 p-0">Request a
                             Quote</p>
                         <button type="button" class="btn-close" data-bs-dismiss="modal"
                             aria-label="Close"></button>
                     </div>

                     <!-- Steps Start -->
                     <div class="step-content active step0" id="step0">
                         <div class="row classcrol">
                             <div class="col-md-5 ps-5">
                                 <div class="scrollable-content">
                                     <p class="twentyeight mt-4">Select your
                                         Vehicle </p>

                                     <div class="checkbox-group">
                                         <label class="checkbox-button">
                                             <input type="checkbox" name="vehicle_type" value="bike" hidden>
                                             <span>Bike</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" name="vehicle_type" value="car" hidden>
                                             <span>Car</span>
                                         </label>
                                     </div>
                                     <div id="vehicle-error" class="reed mt-2" style="display:none;">Please select a
                                         vehicle type</div>

                                 </div>
                                 <div class="d-flex justify-content-end mt-5">
                                     <button type="button" class="bluebtn ms-auto next next-valid px-5">Next</button>
                                 </div>
                             </div>
                             <div class="col-md-7">
                                 <img src="{{ asset('web/services/images/carbike.svg') }}" class="img-fluid"
                                     alt="...">
                             </div>
                         </div>
                     </div>
                     <!-- Step 1 -->
                     <div class="step-content step1" id="step1">
                         <div class="row classcrol">
                             <div class="col-md-5 ps-5">
                                 <div class="scrollable-content">
                                     <p class="twentyeight mt-4">Select body
                                         type</p>
                                     <div id="body_type-error" class="reed mt-2" style="display:none;">Please select
                                         a
                                         body type</div>



                                     <div class="checkbox-group">
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Bike</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Sedan</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>SUV</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Crossover</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Coupe</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Pickup</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Sport Coupe</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Hatchback</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Convertible</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Family Van</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Bike</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Commercial Large
                                                 Vehicle</span>
                                         </label>
                                     </div>

                                 </div>
                                 <div class=" d-flex justify-content-between mt-5">
                                     <button type="button" class="whitebtn prev px-5 ">Back</button>
                                     <button type="button" class="bluebtn ms-auto next px-5"
                                         id="secondstepbtn">Next</button>
                                 </div>
                             </div>
                             <div class="col-md-7">
                                 <img src="{{ asset('web/services/images/Frameee.svg') }}" class="img-fluid"
                                     alt="...">

                             </div>
                         </div>
                     </div>

                     <!-- Step 2 -->
                     <div class="step-content step2" id="step2">
                         <div class="row classcrol">
                             <div class="col-md-5 ps-5">
                                 <div class="scrollable-content">
                                     <p class="twentyeight mt-4">Select Make</p>

                                     <div class="checkbox-group">
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Honda</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>toyota</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>corola</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Exterior Car Wash</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Interior Car Wash</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Exterior Polish</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Interior Full Luster</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Full Exterior</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Not Sure</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Other</span>
                                         </label>
                                     </div>

                                 </div>
                                 <div class="d-flex justify-content-between mt-5 ">
                                     <button type="button" class="whitebtn prev px-5">Back</button>
                                     <button type="button" class="bluebtn  next px-5">Next</button>
                                 </div>
                             </div>
                             <div class="col-md-7">
                                 <img src="{{ asset('web/services/images/Frameee.svg') }}" class="img-fluid"
                                     alt="...">
                             </div>
                         </div>
                     </div>

                     <!-- Step 3 -->
                     <div class="step-content step3" id="step3">
                         <div class="row classcrol">
                             <div class="col-md-5 ps-5">
                                 <div class="scrollable-content">
                                     <p class="twentyeight mt-4">Select Model
                                     </p>

                                     <div class="checkbox-group">
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>Honda</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>toyota</span>
                                         </label>
                                         <label class="checkbox-button">
                                             <input type="checkbox" hidden>
                                             <span>corola</span>
                                         </label>

                                     </div>

                                 </div>
                                 <div class="d-flex justify-content-between mt-5">
                                     <button type="button" class="whitebtn prev px-5">Back</button>
                                     <button type="button" class="bluebtn  next px-5">Next</button>
                                 </div>
                             </div>
                             <div class="col-md-7">
                                 <img src="{{ asset('web/services/images/Frameee.svg') }}" class="img-fluid"
                                     alt="...">
                             </div>
                         </div>
                     </div>

                     <!-- Step 4 -->
                     <div class="step-content step4" id="step4">
                         <div class="row classcrol">
                             <div class="col-md-5 ps-5">
                                 <div class="scrollable-content">
                                     <p class="twentyeight mt-4">Select Year</p>
                                     <div id="year-error" class="reed mt-2" style="display:none;">Please select a
                                         year
                                     </div>

                                     <div class="checkbox-group">
                                         @for ($i = 1960; $i <= date('Y'); $i++)
                                             <label class="checkbox-button">
                                                 <input type="radio" hidden name="year"
                                                     value="{{ $i }}">
                                                 <span>{{ $i }}</span>
                                             </label>
                                         @endfor


                                     </div>

                                 </div>
                                 <div class="d-flex justify-content-between mt-5">
                                     <button type="button" class="whitebtn prev px-5">Back</button>
                                     <button type="button" class="bluebtn  next px-5">Next</button>
                                 </div>
                             </div>
                             <div class="col-md-7">
                                 <img src="{{ asset('web/services/images/popupimg.svg') }}" class="img-fluid"
                                     alt="...">
                             </div>
                         </div>
                     </div>

                     <!-- Step 5 -->
                     <div class="step-content step5" id="step5">
                         <div class="row classcrol">
                             <div class="col-md-5 ps-5">
                                 <div class="scrollable-content">
                                     <p class="twentyeight mt-4">Select services
                                         you need</p>
                                     <div class="checkbox-group">
                                         @foreach ($shop->shop_services as $shopservice)
                                             <label class="checkbox-button">
                                                 <input type="checkbox" hidden value="{{ $shopservice->id }}"
                                                     name="services[]">
                                                 <span>{{ $shopservice->service->name }}</span>
                                             </label>
                                         @endforeach

                                     </div>
                                 </div>
                                 <div class="d-flex justify-content-between mt-5">
                                     <button type="button" class="whitebtn prev px-5">Back</button>
                                     <button type="button" class="bluebtn  next px-5">Next</button>
                                 </div>
                             </div>
                             <div class="col-md-7">
                                 <img src="{{ asset('web/services/images/popupimg.svg') }}" class="img-fluid"
                                     alt="...">
                             </div>
                         </div>
                     </div>

                     <!-- Step 6 -->
                     <div class="step-content step6" id="step6">
                         <div class="row classcrol">
                             <div class="col-md-5 ps-5">
                                 <div class="scrollable-content">
                                     <p class="twentyeight mt-4">Describe your
                                         Needs </p>
                                     <textarea class="form-controles" style="height: 200px;" placeholder="Type..." rows="3"
                                         name="needs_description" required></textarea>

                                     <div class="row mt-2">
                                         <div class="col-9 p-3 rounded-3" style="background-color: #F9F9F9;">
                                             <div class="row">
                                                 <div class="g-recaptcha"
                                                     data-sitekey="6LfUATArAAAAALKTzza1dubHBdizdyL_WVl4ZW_F">
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="d-flex justify-content-between mt-5">
                                     <button type="button" class="whitebtn prev px-5">Back</button>
                                     <button type="button" class="bluebtn  next px-5">Submit</button>
                                 </div>
                             </div>
                             <div class="col-md-7">
                                 <img src="{{ asset('web/services/images/popupimg.svg') }}" class="img-fluid"
                                     alt="...">
                             </div>
                         </div>
                     </div>

                     <!-- Step 7 -->
                     <div class="step-content step7" id="step7">
                         <div class="row classcrol">
                             <div class="col-md-12 ps-5">
                                 <div class="scrollable-content">
                                     <div class="text-center ">
                                         <img src="{{ asset('web/services/images/image 57.svg') }}" class="w-25"
                                             alt="...">
                                         <p class="eighteen">Sending your
                                             request</p>
                                     </div>


                                 </div>
                                 <div class="col-md-5 d-flex justify-content-between mt-5 d-none">

                                     <button type="button" class="whitebtn prev  px-5">Back</button>
                                     <button type="button" class="bluebtn me-5  next px-5">Next</button>

                                 </div>
                             </div>


                         </div>
                     </div>

                     <!-- Step 8 (Final Step) -->
                     <div class="step-content step8" id="step8">
                         <div class="row classcrol">
                             <div class="col-md-12 ps-5">
                                 <div class="scrollable-content">
                                     <div class="text-center ">
                                         <img src="{{ asset('web/services/images/image (290).svg') }}" class=""
                                             style="height: 125px; width:180px" alt="...">
                                         <p class="eighteen m-0">Your request
                                             has been sent</p>
                                         <p class="twelve">You will receive
                                             quote in email and message box </p>
                                         <a href="{{ route('services.home') }}" type="button"
                                             class="btn btn-danger py-2 px-2" style="font-size: 12px;">Find More
                                             Auto
                                             Services</a>
                                     </div>

                                 </div>
                                 <div class="col-md-5 d-flex justify-content-between mt-5 d-none">

                                     <button type="button" class="whitebtn prev  px-5">Back</button>
                                     <button type="button" class="bluebtn me-5  next px-5">Next</button>

                                 </div>
                             </div>
                         </div>

                     </div>
                 </div>

                 <!-- Steps End -->

         </div>
         </form>
     </div>
 </div>

 {{-- request quote modal end --}}
 @endforeach
 </div>
 {{-- @if ($shops->hasPages()) --}}
 <div class="row mt-2">
     <div class="col-md-6">
         <span class="row ">
             {{ $start }} - {{ $end }} of {{ $shops->total() }} Results
         </span>
     </div>
     <div class="col-md-6">
         <nav class="d-flex justify-content-end align-items-center">
             <!-- Page Info -->


             <!-- Pagination -->
             <ul class="pagination"
                 style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">

                 {{-- Previous Page Button --}}
                 @if ($shops->onFirstPage())
                     <li style="display: inline-block;">
                         <span
                             style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</span>
                     </li>
                 @else
                     @if (request()->isMethod('post'))
                         <li style="display: inline-block;">
                             <form method="POST" action="{{ request()->url() }}">
                                 @csrf
                                 <input type="hidden" name="page" value="{{ $shops->currentPage() - 1 }}">
                                 <input type="hidden" name="search" value="{{ request('search') }}">
                                 <input type="hidden" name="city" value="{{ request('city') }}">
                                 <button type="submit"
                                     style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&laquo;</button>
                             </form>
                         </li>
                     @else
                         <li style="display: inline-block;">
                             <a href="{{ $shops->previousPageUrl() }}"
                                 style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">&laquo;</a>
                         </li>
                     @endif
                 @endif

                 {{-- Pagination Links --}}
                 @foreach ($shops->links()->elements as $element)
                     @if (is_string($element))
                         <li style="display: inline-block;">
                             <span
                                 style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #F0F3F6; color: #000;">{{ $element }}</span>
                         </li>
                     @endif

                     @if (is_array($element))
                         @foreach ($element as $page => $url)
                             @if ($page == $shops->currentPage())
                                 <li style="display: inline-block;">
                                     <span
                                         style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #281F48; color: #fff;">{{ $page }}</span>
                                 </li>
                             @else
                                 @if (request()->isMethod('post'))
                                     <li style="display: inline-block;">
                                         <form method="POST" action="{{ request()->url() }}">
                                             @csrf
                                             <input type="hidden" name="page" value="{{ $page }}">
                                             <input type="hidden" name="search" value="{{ request('search') }}">
                                             <input type="hidden" name="city" value="{{ request('city') }}">
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

                 {{-- Next Page Button --}}
                 @if ($shops->hasMorePages())
                     @if (request()->isMethod('post'))
                         <li style="display: inline-block;">
                             <form method="POST" action="{{ request()->url() }}">
                                 @csrf
                                 <input type="hidden" name="page" value="{{ $shops->currentPage() + 1 }}">
                                 <input type="hidden" name="search" value="{{ request('search') }}">
                                 <input type="hidden" name="city" value="{{ request('city') }}">
                                 <button type="submit"
                                     style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #F0F3F6; color: #000; border: none;">&raquo;</button>
                             </form>
                         </li>
                     @else
                         <li style="display: inline-block;">
                             <a href="{{ $shops->nextPageUrl() }}"
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



 {{-- @endif --}}
 </div>


 <script>
     document.addEventListener("DOMContentLoaded", function() {
         document.querySelectorAll(".multiStepForm").forEach((form) => {
             let currentStep = 0;
             const steps = form.querySelectorAll(".step-content");

             function showStep(index) {
                 steps.forEach((step, i) => {
                     step.classList.toggle("active", i === index);
                 });
             }

             function validateStep(step) {
                 if (step.classList.contains("step0")) {
                     const vehicle = step.querySelector('input[name="vehicle_type"]:checked');
                     const error = step.querySelector("#vehicle-error");
                     if (!vehicle) {
                         if (error) error.style.display = "block";
                         return false;
                     }
                     if (error) error.style.display = "none";

                     fetch(`/get-vehicle-body-type/${vehicle.value}`, {
                             method: "GET",
                             headers: {
                                 Accept: "application/json",
                                 "X-Requested-With": "XMLHttpRequest",
                                 "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                     ?.getAttribute("content"),
                             },
                         })
                         .then((response) => response.json())
                         .then((data) => {
                             const bodyTypeContainer = form.querySelector(".step1 .checkbox-group");
                             bodyTypeContainer.innerHTML = "";
                             if (data.body_types?.length) {
                                 data.body_types.forEach((bodyType) => {
                                     const label = document.createElement("label");
                                     label.className = "checkbox-button";

                                     const input = document.createElement("input");
                                     input.type = "radio";
                                     input.name = "body_type";
                                     input.value = bodyType.id;
                                     input.hidden = true;

                                     const span = document.createElement("span");
                                     span.textContent = bodyType.name;

                                     label.appendChild(input);
                                     label.appendChild(span);
                                     bodyTypeContainer.appendChild(label);
                                 });
                             }
                         });
                 }

                 if (step.classList.contains("step1")) {
                     const body = step.querySelector('input[name="body_type"]:checked');
                     const error = step.querySelector("#body_type-error");
                     if (!body) {
                         if (error) error.style.display = "block";
                         return false;
                     }
                     if (error) error.style.display = "none";

                     const vehicleType = form.querySelector('input[name="vehicle_type"]:checked')?.value;
                     fetch(`/get-vehicle-make/${vehicleType}`, {
                             method: "GET",
                             headers: {
                                 Accept: "application/json",
                                 "X-Requested-With": "XMLHttpRequest",
                                 "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                     ?.getAttribute("content"),
                             },
                         })
                         .then((response) => response.json())
                         .then((data) => {
                             const makeContainer = form.querySelector(".step2 .checkbox-group");
                             makeContainer.innerHTML = "";
                             if (data.makes?.length) {
                                 data.makes.forEach((make) => {
                                     const label = document.createElement("label");
                                     label.className = "checkbox-button";

                                     const input = document.createElement("input");
                                     input.type = "radio";
                                     input.name = "vehicle_make";
                                     input.value = make.id;
                                     input.hidden = true;

                                     const span = document.createElement("span");
                                     span.textContent = make.name;

                                     label.appendChild(input);
                                     label.appendChild(span);
                                     makeContainer.appendChild(label);
                                 });
                             }
                         });
                 }

                 if (step.classList.contains("step2")) {
                     const make = step.querySelector('input[name="vehicle_make"]:checked');
                     if (!make) return false;

                     const vehicleType = form.querySelector('input[name="vehicle_type"]:checked')?.value;
                     fetch(`/get-vehicle-model/${vehicleType}/${make.value}`, {
                             method: "GET",
                             headers: {
                                 Accept: "application/json",
                                 "X-Requested-With": "XMLHttpRequest",
                                 "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                     ?.getAttribute("content"),
                             },
                         })
                         .then((response) => response.json())
                         .then((data) => {
                             const modelContainer = form.querySelector(".step3 .checkbox-group");
                             modelContainer.innerHTML = "";
                             if (data.models?.length) {
                                 data.models.forEach((model) => {
                                     const label = document.createElement("label");
                                     label.className = "checkbox-button";

                                     const input = document.createElement("input");
                                     input.type = "radio";
                                     input.name = "vehicle_model";
                                     input.value = model.id;
                                     input.hidden = true;

                                     const span = document.createElement("span");
                                     span.textContent = model.name;

                                     label.appendChild(input);
                                     label.appendChild(span);
                                     modelContainer.appendChild(label);
                                 });
                             }
                         });
                 }

                 if (step.classList.contains("step6")) {
                     const submitBtn = step.querySelector("button.next");
                     if (!submitBtn) return true;
                     submitBtn.disabled = true;
                     submitBtn.innerHTML = "Submitting...";

                     const formData = new FormData(form);
                     const recaptchaResponse = grecaptcha.getResponse();
                     if (recaptchaResponse) formData.append("g-recaptcha-response", recaptchaResponse);

                     // Show step 7 (loading)
                     currentStep++;
                     showStep(currentStep);

                     fetch("/submit-service-quote", {
                             method: "POST",
                             body: formData,
                             headers: {
                                 Accept: "application/json",
                                 "X-Requested-With": "XMLHttpRequest",
                                 "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                     ?.getAttribute("content"),
                             },
                         })
                         .then((response) => response.json())
                         .then((data) => {
                             if (data.success) {
                                 currentStep++;
                                 showStep(currentStep); // step8 success
                             } else {
                                 currentStep = 6;
                                 showStep(currentStep); // return to step6
                                 alert(data.message);
                             }
                         })
                         .catch(() => {
                             currentStep = 6;
                             showStep(currentStep);
                             alert(
                                 "An error occurred while submitting your request. Please try again."
                             );
                         })
                         .finally(() => {
                             submitBtn.disabled = false;
                             submitBtn.innerHTML = "Submit";
                         });

                     return false;
                 }

                 return true;
             }

             form.querySelectorAll(".next").forEach((btn) => {
                 btn.addEventListener("click", () => {
                     const currentStepEl = steps[currentStep];
                     const valid = validateStep(currentStepEl);
                     if (!valid) return;
                     if (currentStep < steps.length - 1 && !currentStepEl.classList
                         .contains("step6")) {
                         currentStep++;
                         showStep(currentStep);
                     }
                 });
             });

             form.querySelectorAll(".prev").forEach((btn) => {
                 btn.addEventListener("click", () => {
                     if (currentStep > 0) {
                         currentStep--;
                         showStep(currentStep);
                     }
                 });
             });

             showStep(currentStep);
         });

         document.querySelectorAll(
             '.checkbox-button input[type="radio"], .checkbox-button input[type="checkbox"]').forEach((
             input) => {
             input.addEventListener("change", function() {
                 const name = this.getAttribute("name");
                 if (this.type === "radio") {
                     document.querySelectorAll(`input[name="${name}"] + span`).forEach((
                         span) => {
                         span.style.backgroundColor = "white";
                         span.style.color = "#A7A7A7";
                         span.style.borderColor = "#A7A7A7";
                     });
                 }

                 const span = this.nextElementSibling;
                 if (this.checked) {
                     span.style.backgroundColor = "#281F48";
                     span.style.color = "white";
                     span.style.borderColor = "#281F48";
                 } else {
                     span.style.backgroundColor = "white";
                     span.style.color = "#A7A7A7";
                     span.style.borderColor = "#A7A7A7";
                 }
             });
         });
     });
 </script>
 <script src="{{ asset('customjs/shopdetail.js') }}"></script>
