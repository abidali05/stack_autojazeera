@extends('layout.superadmin_layout.main')
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
    </style>
    </head>

@php
    $totalcarads = App\Models\Post::count();
    $totalbikeads = App\Models\Bike\BikePost::count();
    $totalusers = App\Models\User::count();
    $totalshops = App\Models\Shops::count();

@endphp

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3 p-4">
                <div class="row">
                    <div class="col-12  divnewclas">
                        <div class="row p-3" style="position: relative;">
                            <div class="col-3 p-2 text-center "
                                style="position: absolute; background-color: red; border-radius:5px ;top: -20px;">
                                <i class="bi bi-car-front-fill fs-3" style="color: white;"></i>
                            </div>
                            <div class="col-12 text-end">
                                <p class="m-0 sixteen">Total Car Ads</p>
                                <p class="eighteens">{{$totalcarads}}</p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 p-4">
                <div class="row">
                    <div class="col-12  divnewclas">
                        <div class="row p-3" style="position: relative;">
                            <div class="col-3 p-2 text-center "
                                style="position: absolute; background-color: red; border-radius:5px ;top: -20px;">
                                <i class="fas fa-motorcycle fs-3" style=" color: white;"></i>
                            </div>
                            <div class="col-12 text-end">
                                <p class="m-0 sixteen">Total Bike Ads</p>
                                <p class="eighteens">{{$totalbikeads}}</p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 p-4">
                <div class="row">
                    <div class="col-12  divnewclas">
                        <div class="row p-3" style="position: relative;">
                            <div class="col-3 p-2 text-center "
                                style="position: absolute; background-color: red; border-radius:5px ;top: -20px;">
								<i class="bi bi-people-fill fs-3"  style="color: white;"></i>
                               
                            </div>
                            <div class="col-12 text-end">
                                <p class="m-0 sixteen">Total Users</p>
                                <p class="eighteens">{{$totalusers}}</p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 p-4">
                <div class="row">
                    <div class="col-12  divnewclas">
                        <div class="row p-3" style="position: relative;">
                            <div class="col-3 p-2 text-center "
                                style="position: absolute; background-color: red; border-radius:5px ;top: -20px;">
                           
<i class="bi bi-shop fs-3" style=" color: white;"></i>
                            </div>
                            <div class="col-12 text-end">
                                <p class="m-0 sixteen">Total Shops</p>
                                <p class="eighteens">{{$totalshops}}</p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
     
      
     
        </div>
    </div>
@endsection
