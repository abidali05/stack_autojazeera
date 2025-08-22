<style>
    .newwwbtn {
    background-color: #281F48;
    color: white;
    font-size: 12px;
    font-weight: 600;
    border-radius: 30px;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}
.twelvenew {
    font-size: 14px;
    font-weight: 400;
}
.forteennew {
    font-size: 16px;
    font-weight: 600;
}
</style>

@if (count($posts) < 1)

       <div class="p-3 col-12" style="border:1px solid #281F48;border-radius:9px;">
                    <div class="row">
                        <div class="col-3 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('web/images/noinputs.svg') }}" alt="" class="img-fluid"
                                srcset="">
                        </div>
                        <div class="col-9 text-start">
                            <h1 style="color:#FD5631 !important"><strong>Sorry</strong></h1>
                            <p class="forteennew m-0">No inventory found.</p>
<p class="twelvenew">🚀 Calling all private sellers, dealers & auto service providers!
We’re onboarding now — List your cars and services today and be seen first!</p>
@if(Auth::check())
 <a href="{{ url('subscription') }}" class="newwwbtn">Post Inventory Now</a>
@else
    <a href="{{ route('subscription_plans') }}" class="newwwbtn">Post Inventory Now</a>
@endif
@if(Auth::check())
 <a href="{{ url('subscription') }}" class="newwwbtn ms-3">Post Auto Service Business Now</a>
@else
    <a href="{{ route('subscription_plans') }}" class="newwwbtn ms-3">Post Auto Service Business Now</a>
@endif
                        </div>
                    </div>
                </div>
@endif
<div class="row">
     @if (count($posts) > 0)
    <div class="col-md-6">
        <span class=" pagination_count" style="font-size: 18px; color: #FD5631; font-weight:700 ">
            Showing {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
            to {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
            of {{ $posts->total() }} Results
        </span>
    </div>
    @endif
    <div class="col-md-6">
        {{-- @if ($posts->hasPages()) --}}
         @if (count($posts) > 0)
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
        @endif

    </div>
</div>
@foreach ($posts as $post)
    <div class="col-lg-12 my-3 car" data-longitude="{{ $post->longitude }}" data-latitude="{{ $post->latitude }}">
        <div class="wishlist-card rounded" style=" border:1px solid #0000001F">
            <a href="{{ route('bikedetail', $post->id) }}" style="text-decoration: none; color: #ffffff;">
                <div class="row">
                    <div class="col-lg-4 pe-0">
                        <div class="img-bg-3" style="border-radius:10px 0px 0px 10px;">
                            <img src="{{ $post->media[0]->file_path ?? asset('web/bikes/images/logo.svg') }}"
                                class="img-adj-card" style="border-radius:10px 0px 0px 10px;">
                        </div>
                    </div>
                    <div class="col-lg-8  my-auto">
                        <div class="pe-lg-3 px-lg-0 pb-lg-0  p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>{{ $post->year }}</h6>

                          <div>       @if ($post->is_featured == 1)
                                                <span class="px-3 py-2 rounded text-capitalize"
                                                    style="background-color:#BF0000; font-size:12px; "><img
                                                        src="{{ asset('web/images/star-icon.svg') }}"
                                                        class="mb-1 me-2 img-fluid">{{ 'featured' }}</span>
                                            @endif
                                <span class="rounded px-3 py-2 text-capitalize"
                                    style="font-size:12px;background-color:{{ $post->condition == 'used' ? '#0EB617;' : '#4581F9;' }}">{{ $post->condition }}</span></div>
                            </div>
                            <h4>{{ $post->makename . ' ' . $post->modelname }}</h4>
                            <h5 style="color: #281F48;"><b>PKR
                                    {{ number_format($post->price) }}</b>
                            </h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="bi bi-geo-alt"></i>
                                    {{ $post->location->cityname }} <span class="distance">calculating...</span></h6>
                                <span style="color: #281F48;">Last Updated:
                                    {{ \Carbon\Carbon::parse($post->updated_at)->format('F j, Y') }}
                                </span>
                            </div>
                            <hr style="border: none; height: 1px; background-color: #66666680;">

                            <div class="row pb-2">
                                <div class="col-4">
                                    <div class="text-center py-2"
                                        style="background-color:#F0F3F6; border-radius: 10px;">
                                        <i style="color: #281F48;" class="bi bi-speedometer2"></i>
                                        <h6>{{ (float) $post->mileage >= 1000 ? rtrim(number_format((float) $post->mileage / 1000, 1), '.0') . 'KM' : (float) $post->mileage }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text-center py-2"
                                        style="background-color:#F0F3F6; border-radius: 10px;">
                                        <i style="color: #281F48;" class="bi bi-car-front-fill"></i>
                                        <h6>{{ $post->transmission }}</h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text-center py-2"
                                        style="background-color:#F0F3F6; border-radius: 10px;">
                                        <i style="color: #281F48;" class="bi bi-fuel-pump-diesel"></i>
                                        <h6>{{ $post->fuel_type }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>



        </div>
    </div>
@endforeach
<div class="row">
 @if (count($posts) > 0)
    <div class="col-md-6">
        <span class=" pagination_count" style="font-size: 18px; color: #FD5631; font-weight:700 ">
            Showing {{ ($posts->currentPage() - 1) * $posts->perPage() + 1 }}
            to {{ min($posts->currentPage() * $posts->perPage(), $posts->total()) }}
            of {{ $posts->total() }} Results
        </span>
    </div>
    @endif
    <div class="col-md-6">
        {{-- @if ($posts->hasPages()) --}}
         @if (count($posts) > 0)
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
        @endif

    </div>

</div>
