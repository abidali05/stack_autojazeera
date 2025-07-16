<style>
    hr {
        border-top: 1px solid #281F48;
    }.loader {
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
    0%   {clip-path: polygon(50% 50%,0 0,0 0,0 0,0 0,0 0)}
    25%  {clip-path: polygon(50% 50%,0 0,100% 0,100% 0,100% 0,100% 0)}
    50%  {clip-path: polygon(50% 50%,0 0,100% 0,100% 100%,100% 100%,100% 100%)}
    75%  {clip-path: polygon(50% 50%,0 0,100% 0,100% 100%,0 100%,0 100%)}
    100% {clip-path: polygon(50% 50%,0 0,100% 0,100% 100%,0 100%,0 0)}
}
</style>
          <div id="loadingSpinner" class="loading-overlay d-none">
    <div class="loader"></div>
</div>

<div class=" m-0 row gy-3" id="postresultsContainer">
    @if (count($posts) < 1)
    @else
       <div class="col-md-6">
              <div class="">
                <span class=" pagination_count" style="font-size: 18px; color: #FD5631; font-weight:700 ">
                    Showing {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
                    to {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
                    of {{ $posts->total() }} Results
                </span>
            </div> </div>
      <div class="col-md-6">
        
            {{-- @if ($posts->hasPages()) --}}
                <nav class="d-flex justify-content-end align-items-center">
                    <!-- Page Info -->


                    <!-- Pagination -->
                    <ul class="pagination"
                        style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                        @if ($posts->onFirstPage())
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
                                    <a href="{{ $posts->previousPageUrl() }}"
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                </li>
                            @endif
                        @endif

                        @foreach ($posts->links()->elements as $element)
                            @if (is_string($element))
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                </li>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $posts->currentPage())
                                        <li style="display: inline-block;">
                                            <span
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #f56; color: #fff;">{{ $page }}</span>
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

                        @if ($posts->hasMorePages())
                            @if (request()->isMethod('post'))
                                <li style="display: inline-block;">
                                    <form method="POST" action="{{ url()->current() }}">
                                        @csrf
                                        <input type="hidden" name="page" value="{{ $posts->currentPage() + 1 }}">
                                        <button type="submit"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                    </form>
                                </li>
                            @else
                                <li style="display: inline-block;">
                                    <a href="{{ $posts->nextPageUrl() }}"
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
            {{-- @endif --}}
              </div>
   
          </div>
      
        @foreach ($posts as $post)
            <div class="col-lg-12 post-item car" data-longitude="{{ $post->longitude }}"
                data-latitude="{{ $post->latitude }}">
                <a @if (Request::is('superadmin/*')) href="{{ route('superadmin.cardetail', $post->id) }}" @else href="{{ route('cardetail', $post->id) }}" @endif
                    class="text-white">
                    <div class="wishlist-card"
                        style="background-color:white !important ;border:1px solid #0000001F ; border-radius:20px">
                        <div class="row">
                            <?php
                            $main = $post->document->first();
                            
                            ?>
                            <div class="col-lg-4">
                                <div class="img-bg-home-2">

                                    <img src="{{ url('posts/doc/' . $main->doc_name) }}" class="img-adj-card">
                                </div>
                            </div>
                            <div class="my-auto col-lg-8">
                                <div class="p-3 pe-lg-3 px-lg-0 pb-lg-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 style="color:#281F48">{{ $post->year }}</h6>
                                        <div>
                                            @if ($post->feature_ad == 1)
                                                <span class="px-3 py-1 rounded text-capitalize"
                                                    style="background-color:#BF0000; font-size:12px; "><img
                                                        src="{{ asset('web/images/star-icon.svg') }}"
                                                        class="mb-1 me-2 img-fluid">{{ 'featured' }}</span>
                                            @endif
                                            <span class="px-3 py-1 rounded text-capitalize"
                                                style="background-color:{{ $post->condition == 'used' ? '#0EB617' : '#4581F9' }}; font-size:12px;">{{ $post->condition }}</span>
                                        </div>

                                    </div>
                                    <h4 style="color:#281F48">{{ $post->makename }} {{ $post->modelname }}</h4>
                                    <h5 style="color: #FD5631;"><b>PKR
                                            {{ number_format($post->price) }}</b></h5>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0" style="color:#281F48 !important "><i
                                                class="bi bi-geo-alt"></i>
                                            {{ $post->location->cityname ?? '' }} <span class="distance"
                                                style="font-size: 12px; color:#281F48;">calculating...</span></h6>
                                        <?php
                                        
                                        $date = $post->updated_at;
                                        $formattedDate = 'Last Updated: ' . date('F j, Y', strtotime($date));
                                        ?>
                                        <span
                                            style="font-size:14px;color:#281F48 !important">{{ $formattedDate }}</span>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="py-1 text-center"
                                                style="background-color:#F0F3F6; border-radius: 10px;">
                                                <i style="color:#281F48 !important " class="bi bi-speedometer2"></i>
                                                @php
                                                    $formattedMileage =
                                                        $post->milleage >= 1000
                                                            ? rtrim(number_format($post->milleage / 1000, 1), '.0')
                                                            : $post->milleage;
                                                @endphp
                                                <h6 style="color:#281F48 !important ">{{ $formattedMileage }} KM</h6>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="py-1 text-center"
                                                style="background-color:#F0F3F6; border-radius: 10px;">
                                                <i style="color:#281F48 !important " class="bi bi-car-front-fill"></i>
                                                <h6 style="color:#281F48 !important ">{{ $post->transmission }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="py-1 text-center"
                                                style="background-color:#F0F3F6; border-radius: 10px;">
                                                <i style="color:#281F48 !important " class="bi bi-fuel-pump-diesel"></i>
                                                <h6 style="color:#281F48 !important ">{{ $post->fuel }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </a>
            </div>
        @endforeach
       <div class="row mt-3">
        <div class="col-md-6">
               <div class="">
                <span class=" pagination_count" style="font-size: 18px; color: #FD5631; font-weight:700 ">
                    Showing {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
                    to {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
                    of {{ $posts->total() }} Results
                </span>
            </div>
        </div>
         <div class="col-md-6">
            {{-- @if ($posts->hasPages()) --}}
                <nav class="d-flex justify-content-end align-items-center">
                    <!-- Page Info -->


                    <!-- Pagination -->
                    <ul class="pagination"
                        style="display: flex; list-style: none; gap: 5px; justify-content: center; padding: 0; margin: 0;">
                        @if ($posts->onFirstPage())
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
                                    <a href="{{ $posts->previousPageUrl() }}"
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">&laquo;</a>
                                </li>
                            @endif
                        @endif

                        @foreach ($posts->links()->elements as $element)
                            @if (is_string($element))
                                <li style="display: inline-block;">
                                    <span
                                        style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #444; color: #fff;">{{ $element }}</span>
                                </li>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $posts->currentPage())
                                        <li style="display: inline-block;">
                                            <span
                                                style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; text-decoration: none; background-color: #f56; color: #fff;">{{ $page }}</span>
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

                        @if ($posts->hasMorePages())
                            @if (request()->isMethod('post'))
                                <li style="display: inline-block;">
                                    <form method="POST" action="{{ url()->current() }}">
                                        @csrf
                                        <input type="hidden" name="page" value="{{ $posts->currentPage() + 1 }}">
                                        <button type="submit"
                                            style="display: inline-flex; justify-content: center; align-items: center; width: 30px; height: 30px; border-radius: 50%; background-color: #444; color: #fff; border: none;">&raquo;</button>
                                    </form>
                                </li>
                            @else
                                <li style="display: inline-block;">
                                    <a href="{{ $posts->nextPageUrl() }}"
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
            {{-- @endif --}}
         
        </div>
       </div>
    @endif
</div>
