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
             
                <h2 class="sec mb-0 primary-color-custom">Submitted Car Leads</h2>
            </div>
        </div>
        <div class="row mt-3">
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


                <div class="row pb-lg-3 pb-3 gy-3">
                    <div class="col-lg-12">
                        <div class="row gy-3">
                            @if (count($forms) < 1)
                                <h3 class="text-center my-5 py-5" style="color:#281F48">You havent submitted any forms yet</h3>
                            @endif
                            @foreach ($forms as $form)
                                <div class="col-lg-6">
                                    <div class="wishlist-card">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <?php
                                                $main = $form->post->document->first();
                                                
                                                ?>
                                                <div class="img-bg-home-2">
                                                    <a
                                                        @if (Request::is('superadmin/*')) href="{{ route('superadmin.cardetail', $form->post->id) }}" @else href="{{ route('cardetail', $form->post->id) }}" @endif>
                                                        <img src="{{ url('posts/doc/' . $main->doc_name) }}"
                                                            class="img-adj-card"></a>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 my-auto">
                                                                   <a
                                                        @if (Request::is('superadmin/*')) href="{{ route('superadmin.cardetail', $form->post->id) }}" @else href="{{ route('cardetail', $form->post->id) }}" @endif>
                                                <div class="pe-lg-3 px-lg-0 pb-lg-0  p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6>{{ $form->post->year }}</h6>
                                                        <span class="rounded px-3 py-1 text-capitalize"
                                                            style="background-color:#4581F9; font-size:12px;color:#281F48">{{ $form->post->condition }}
                                                        </span>
                                                    </div>
                                                    <h4 style="color:#281F48">{{ $form->post->makename }}
                                                        {{ $form->post->modelname }} </h4>
                                                    <div class="d-flex justify-content-between">
                                                        <h5 style="color: #FD5631;"><b>PKR {{ $form->post->price }}</b></h5>

</a>

                                                        <a href="#" class="nav-link" data-bs-toggle="modal"
                                                            data-bs-target="#viewformModal{{ $form->id }}">Click to see
                                                            info.</a>
                                                    </div>
                   <a
                                                        @if (Request::is('superadmin/*')) href="{{ route('superadmin.cardetail', $form->post->id) }}" @else href="{{ route('cardetail', $form->post->id) }}" @endif>
                                               
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0"><i class="bi bi-geo-alt"></i>
                                                            {{ $form->post->location->cityname }}</h6>
                                                        <?php
                                                        
                                                        $date = $form->post->updated_at;
                                                        $formattedDate = 'Last Updated: ' . date('F j, Y', strtotime($date));
                                                        ?>
                                                        <span style="font-size:14px;color:#281F48">{{ $formattedDate }}</span>
                                                    </div>
                                                    <hr style="border: none; height: 1px; background-color: #66666680;">

                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="text-center py-1"
                                                                style="background-color:#F6F6F6; border-radius: 10px;">
                                                                <i class="bi bi-speedometer2" style="color:#281F48"></i>
                                                                <h6>{{ $form->post->milleage }} KM</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="text-center py-1"
                                                                style="background-color:#F6F6F6; border-radius: 10px;">
                                                                <i class="bi bi-car-front-fill" style="color:#281F48"></i>
                                                                <h6>{{ $form->post->transmission }}</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="text-center py-1"
                                                                style="background-color:#F6F6F6; border-radius: 10px;">
                                                                <i class="bi bi-fuel-pump-diesel" style="color:#281F48"></i>
                                                                <h6>{{ $form->post->fuel }}</h6>
                                                            </div>
                                                        </div>
                                                    </div>  </a>
                                                </div>
                                              
                                            </div>
                                        </div>



                                    </div>
                                </div>

                                <div class="modal fade" id="viewformModal{{ $form->id }}" tabindex="-1"
                                    aria-labelledby="infoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                            <div class="modal-header"
                                                style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                                <h5 class="modal-title" id="infoModalLabel"><strong> Submitted Information</strong></h5>
                                                <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body ps-4" style="background-color: #F0F3F6; color: #FD5631;" >
                                                <span class="list-group-item"><strong>Full Name:</strong>
                                                    {{ $form->fullname }}</span>
                                                <span class="list-group-item"><strong>Email:</strong>
                                                    {{ $form->email }}</span>
                                                <span class="list-group-item"><strong>Phone Number:</strong>
                                                    {{ $form->number }}</span>
                                                {{-- <span class="list-group-item"><strong>Date of Birth:</strong>
                                                    {{ $form->dob ?? 'N/A' }}</span>
                                                <span class="list-group-item"><strong>Time:</strong>
                                                    {{ $form->apointment_time ?? 'N/A' }}</span>
                                                <span class="list-group-item"><strong>Preferred Contact Method:</strong>
                                                    {{ $form->perefered_contact_method ?? 'N/A' }}</span> --}}
                                                <span class="list-group-item"><strong>Message:</strong>
                                                    {{ $form->comment ?? 'N/A' }}</span>
                                                @if ($form->friendFullname)
                                                    <li class="list-group-item"><strong>Friend's Name:</strong>
                                                        {{ $form->friendFullname }}</span>
                                                @endif
                                                @if ($form->friendemail)
                                                    <li class="list-group-item"><strong>Friend's Email:</strong>
                                                        {{ $form->friendemail }}</span>
                                                @endif
                                            </div>
                                            <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                                                <button type="button" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{ $forms->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- tab end  --}}
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            {{-- tab start  --}}<div class="container">


                <div class="row py-lg-5 py-3 gy-3">
                    <div class="col-lg-12">
                        <div class="row gy-3">
                            @if (count($forms) < 1)
                                <h3 class="text-center my-5 py-5">You havent submitted any forms yet</h3>
                            @endif
                            @foreach ($forms as $form)
                                <div class="col-lg-6">
                                    <div class="wishlist-card">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <?php
                                                $main = $form->post->document->first();
                                                
                                                ?>
                                                <div class="img-bg-home-2">
                                                    <a
                                                        @if (Request::is('superadmin/*')) href="{{ route('superadmin.cardetail', $form->post->id) }}" @else href="{{ route('cardetail', $form->post->id) }}" @endif>
                                                        <img src="{{ url('posts/doc/' . $main->doc_name) }}"
                                                            class="img-adj-card"></a>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 my-auto">
                                                <div class="pe-lg-3 px-lg-0 pb-lg-0  p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6>{{ $form->post->year }}</h6>
                                                        <span class="rounded px-3 py-1 text-capitalize"
                                                            style="background-color:#4581F9; font-size:12px;">{{ $form->post->condition }}
                                                        </span>
                                                    </div>
                                                    <h4 style="color:#281F48">{{ $form->post->makename }}
                                                        {{ $form->post->modelname }} </h4>
                                                    <div class="d-flex justify-content-between">
                                                        <h5 style="color: #FD5631;"><b>PKR {{ $form->post->price }}</b>
                                                        </h5>



                                                        <a href="#" class="nav-link" data-bs-toggle="modal"
                                                            data-bs-target="#viewformModal{{ $form->id }}">Click to
                                                            see info.</a>
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0"><i class="bi bi-geo-alt"></i>
                                                            {{ $form->post->location->cityname }}</h6>
                                                        <?php
                                                        
                                                        $date = $form->post->updated_at;
                                                        $formattedDate = 'Last Updated: ' . date('F j, Y', strtotime($date));
                                                        ?>
                                                        <span style="font-size:14px;">{{ $formattedDate }}</span>
                                                    </div>
                                                    <hr style="border: none; height: 1px; background-color: #66666680;">

                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="text-center py-1"
                                                                style="background-color:#F6F6F6; border-radius: 10px;">
                                                                <i class="bi bi-speedometer2"></i>
                                                                <h6>{{ $form->post->milleage }} KM</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="text-center py-1"
                                                                style="background-color:#F6F6F6; border-radius: 10px;">
                                                                <i class="bi bi-car-front-fill"></i>
                                                                <h6>{{ $form->post->transmission }}</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="text-center py-1"
                                                                style="background-color:#F6F6F6; border-radius: 10px;">
                                                                <i class="bi bi-fuel-pump-diesel"></i>
                                                                <h6>{{ $form->post->fuel }}</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>

                                <div class="modal fade" id="viewformModal{{ $form->id }}" tabindex="-1"
                                    aria-labelledby="infoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                                            <div class="modal-header"
                                               style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                                                <h5 class="modal-title" id="infoModalLabel"> <strong>Submitted Information</strong></h5>
                                                <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body ps-4" style="background-color: #F0F3F6; color: #FD5631;">
                                                <span class="list-group-item"><strong>Full Name:</strong>
                                                    {{ $form->fullname }}</span>
                                                <span class="list-group-item"><strong>Email:</strong>
                                                    {{ $form->email }}</span>
                                                <span class="list-group-item"><strong>Phone Number:</strong>
                                                    {{ $form->number }}</span>
                                                {{-- <span class="list-group-item"><strong>Date of Birth:</strong>
                                                    {{ $form->dob ?? 'N/A' }}</span>
                                                <span class="list-group-item"><strong>Time:</strong>
                                                    {{ $form->apointment_time ?? 'N/A' }}</span>
                                                <span class="list-group-item"><strong>Preferred Contact Method:</strong> --}}
                                                    {{ $form->perefered_contact_method ?? 'N/A' }}</span>
                                                <span class="list-group-item"><strong>Message:</strong>
                                                    {{ $form->comment ?? 'N/A' }}</span>
                                                @if ($form->friendFullname)
                                                    <li class="list-group-item"><strong>Friend's Name:</strong>
                                                        {{ $form->friendFullname }}</span>
                                                @endif
                                                @if ($form->friendemail)
                                                    <li class="list-group-item"><strong>Friend's Email:</strong>
                                                        {{ $form->friendemail }}</span>
                                                @endif
                                            </div>
                                            <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                                                <button type="button" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{ $forms->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
