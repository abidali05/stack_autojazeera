@extends('layout.panel_layout.main')
@section('content')

<div class="container-fluid rounded-5 rounded-top-0 p-lg-5  p-2">
    <h3 class="mb-4">All Ads by <span class="text-capitalize">{{ $posts[0]->dealer->name }}</span></h3>
    <div class="row py-3 gy-3">
        @foreach($posts as $post)
        <div class="col-lg-6">
            <a @if (Request::is('superadmin/*')) href="{{ route('superadmin.cardetail', $post->id) }}" 
                @else href="{{ route('cardetail', $post->id) }}" @endif class="text-white">
            <div class="wishlist-card">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="img-bg-home-2">
                            <?php $main = $post->document->first(); ?>
                           
                                <img src="{{ url('posts/doc/' . $main->doc_name) }}" alt="Car Image">
                          
                        </div>
                    </div>
                    <div class="col-lg-8 my-auto">
                        <div class="pe-lg-3 px-lg-0 pb-lg-0 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>{{ $post->year }}</h6>
                                <div>
                                    @if($post->feature_ad == 1)
                                    <span class="rounded px-3 py-1 text-capitalize" style="background-color:#FD5631; font-size:12px;">
                                        {{ "featured" }}
                                    </span>
                                    @endif
                                    <span class="rounded px-3 py-1 text-capitalize" style="background-color:#4581F9; font-size:12px;">
                                        {{ $post->condition }}
                                    </span>
                                </div>
                            </div>
                            <h4>{{ $post->makename }} {{ $post->modelname }}</h4>
                            <h5 style="color: #FD5631;"><b>PKR {{ $post->price }}</b></h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="bi bi-geo-alt"></i> {{ $post->location->cityname }}</h6>
                                <span style="font-size:14px;">{{ date('F j, Y', strtotime($post->updated_at)) }}</span>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-4">
                                    <div class="text-center py-2" style="background-color:#1F1B2D; border-radius: 10px;">
                                        <i class="bi bi-speedometer2"></i>
                                        <h6>{{ $post->milleage }} KM</h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text-center py-2" style="background-color:#1F1B2D; border-radius: 10px;">
                                        <i class="bi bi-car-front-fill"></i>
                                        <h6>{{ $post->transmission }}</h6>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text-center py-2" style="background-color:#1F1B2D; border-radius: 10px;">
                                        <i class="bi bi-fuel-pump-diesel"></i>
                                        <h6>{{ $post->fuel }}</h6>
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
    </div>
</div>

@endsection
