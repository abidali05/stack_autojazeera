{{--<div class="modal fade" id="preview" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="colorModalLabel">Post Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container mb-4">
                    <div class="breadcrumb-nav mb-3">
                        <a href="#" class="breadcrumb-item text-white">Home</a>
                        <span class="breadcrumb-separator">></span>
                        <a href="#" class="breadcrumb-item text-white">{{$post->condition}}</a>
                        <span class="breadcrumb-separator">></span>
                        <span class="breadcrumb-item active">{{$post->modelname}}</span>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">

                            <h2>{{$post->modelname}} {{$post->year??""}}</h2>
                        </div>
                        <div class="col-lg-4 text-end">
                            <div class="action-buttons">
                                <button class="action-btn">
                                    <i class="bi bi-share-fill"></i>
                                </button>

                                <?php

                                use Illuminate\Support\Facades\Auth;

                                if (isset($post->whishlist) && isset(Auth::user()->id)) {

                                    $data = $post->whishlist->where('user_id', Auth::user()->id)->first();
                                }


                                ?>
                                @auth
                                <a @if (!Request::is('superadmin/*')) href="{{route('add-to-wishlist',['post_id'=>$post->id,'dealer_id'=>Auth::user()->id])}}" @else href="" @endif class="action-btn">
                                    <i @if(isset($data)) class="bi bi-heart-fill  text-danger" @else class="bi bi-heart-fill  text-light" @endif></i>
                                </a>
                                @else
                                <a href="{{route('login')}}" class="action-btn">
                                    <i class="bi bi-heart-fill  text-light"></i>
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container mb-4">
                    <div class="row">
                        <?php
                        $main = $post->document->first();

                        ?>
                        <div class="col-lg-7">
                            <img src="{{url('posts/doc/'.$main->doc_name)}}" alt="" srcset="" class="img-fluid">

                            <div class="container my-4">
                                <h5 style="color: #FD5631;">Specifications</h5>

                                <!-- Row 1 -->
                                <div class="row">
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <span><strong>Manufacturing Year</strong></span>
                                        <span>{{$post->year}}</span>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <span><strong>Registered?</strong></span>
                                        <span>Yes</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <span><strong>Make</strong></span>
                                        <span>{{$post->makename}}</span>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <span><strong>Model</strong></span>
                                        <span>{{$post->modelname}}</span>
                                    </div>
                                </div>

                                <!-- Row 2 -->
                                <div class="row">
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <span><strong>Transmission</strong></span>
                                        <span>{{$post->transmission}}</span>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <span><strong>Assembly</strong></span>
                                        <span>{{$post->assembly}}</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <span><strong>Door Count</strong></span>
                                        <span>{{$post->doors}}</span>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <span><strong>Fuel Type</strong></span>
                                        <span>{{$post->fuel}}</span>
                                    </div>
                                </div>

                                <!-- Row 3 -->
                                <div class="row">
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <span><strong>Engine Capacity</strong></span>
                                        <span>{{$post->engine_capacity}}</span>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <span><strong>Mileage</strong></span>
                                        <span>{{$post->milleage}}</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <span><strong>Body Type</strong></span>
                                        <span>{{$post->bodytypename}}</span>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <span><strong>Exterior Color</strong></span>
                                        <span>{{$post->excolorname}}</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 d-flex justify-content-between">
                                        <span><strong>Seating Capacity</strong></span>
                                        <span>{{$post->seating_capacity}}</span>
                                    </div>
                                </div>

                                <!-- Features Section -->
                                <div class="features mt-4">
                                    <h5 style="color: #FD5631;">Features</h5>
                                    <div class="row mt-3">

                                        @foreach($post->feature as $feature)
                                        <div class="col-md-4 feature-item">
                                            <!-- <i class="bi bi-fan"></i>  -->
                                            {{$feature->feature_name}}
                                        </div>
                                        @endforeach



                                    </div>
                                </div>
                                <!-- Seller's Description Section -->
                                <div class="description mt-4">
                                    <h5 style="color: #FD5631;">Seller's Description</h5>
                                    <p>{{$post->dealer_comment}}.</p>
                                    <div class="mt-3">
                                        @foreach($post->document as $document)
                                        @if($document->doc_type == 'Brochure Document')
                                        <a class="btn custom-btn-3 p-3" href="{{asset('posts/doc/'.$document->doc_name)}}" frameborder="0">Download Brochure</a>
                                        @endif
                                        @if($document->doc_type == 'Auction Document')
                                        <a class="btn custom-btn-3 p-3" href="{{asset('posts/doc/'.$document->doc_name)}}" frameborder="0">Download Auction Sheet</a>
                                        @endif
                                        @endforeach
                                        <!-- <button class="btn custom-btn-3 p-3">Download Brochure</button>
                            <button class="btn custom-btn-3 p-3">Download Auction Sheet</button> -->
                                    </div>
                                </div>
                                <!-- Information Section -->
                                <div class="info-section mt-4">
                                    <div class="row text-start">
                                        <div class="col-md-3">
                                            <div class="info-item">Published:</div>
                                            <div class="info-value">{{ \Carbon\Carbon::parse($post->created_at)->format('F j, Y') }} </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-item">Last Updated:</div>
                                            <div class="info-value">{{ \Carbon\Carbon::parse($post->updated_at)->format('F j, Y') }}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-item">Ad Id:</div>
                                            <div class="info-value">{{$post->id}}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="info-item">Member Since:</div>
                                            <div class="info-value">{{ \Carbon\Carbon::parse($post->dealer->created_at)->format('F j, Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-5">
                            <div class="row align-items-center mb-4">
                                <!-- Left Side Buttons -->
                                <div class="col d-flex align-items-center">
                                    <button class="btn custom-btn-3">{{$post->condition}}</button>
                                    <!-- <button class="btn custom-btn-3 ms-2">Used</button> -->
                                </div>

                                <!-- Right Side Toggle Switch -->
                                <div class="col text-end">
                                    <div class="toggle-container">
                                        Price Alert
                                        <input type="checkbox" class="form-check-input ms-2" id="priceAlertToggle">
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <!-- First Column -->
                                <div class="col-md-8">
                                    <h5 class="mb-1"><span style="color: #FD5631;">PKR {{$post->price}}</span></h5>
                                    <div class="row">
                                        <div class="col-auto">
                                            <p>{{$post->milleage}} miles</p>
                                        </div>
                                        <div class="col-auto">
                                            <p>{{$post->location->cityname}}, {{$post->location->area}}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Second Column -->
                                <div class="col-md-4 text-end">
                                    <p><strong>Posted on:</strong> {{ \Carbon\Carbon::parse($post->created_at)->format('F j, Y') }}</p>
                                </div>
                            </div>

                        </div>
                    </div>



                </div>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>

            </div>
           
        </div>
    </div>
</div> --}}
<!-- Preview Modal -->
<div class="modal fade" id="preview" tabindex="-1" aria-labelledby="previewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewLabel">Preview Your Ad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="previewContent">
                    <!-- Preview content will be populated here via JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('adForm').submit();">Confirm & Submit</button>
            </div>
        </div>
    </div>
</div>

