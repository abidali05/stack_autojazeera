@extends('layout.panel_layout.main')
@section('content')
<div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-auto">
                <a href="{{route('superadmin.dashboard')}}" class="text-white me-3">
                    <img src="{{asset('web/images/icon.svg')}}" alt="back-arrow" width="50px" height="35px">
                </a>
            </div>
            <div class="col-auto">
                <h2 class="sec mb-0 primary-color-custom">Manage Dealer Ads </h2>
            </div>
        </div>
        <div class="row align-items-center mb-4">
            <div class="col-md-4 mb-md-0 mb-2">
                <div class="input-group">
                    <span class="input-group-text" id="search-addon">
                        <i class="bi bi-search"></i>
                    </span>
                    <select class="form-select" aria-label="Search Dealer" aria-describedby="search-addon">
                        <option selected>Select Dealer</option>
                        <option value="1">Dealer 1</option>
                        <option value="2">Dealer 2</option>
                        <option value="3">Dealer 3</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="container table-responsive">
        <div class="row">
            <table class="table table-striped transparent-table align-middle">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Dealer Name</th>
                        <th>Dealer ID</th>
                        <th>Current Subscription</th>
                        <th>Billing End Date</th>
                        <th>Add Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Repeat this block for each row -->
                     @foreach($subscriptions as $sub)
                    <tr>
                        <td>
                            <a href="#" class="text-white me-2" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="#" class="primary-color-custom" title="Delete">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                        <td>{{$sub->user->name}}</td>
                        <td>{{$sub->user_id}}</td>
                        <td>{{$sub->current_subscription}}</td>
                        <td>{{$sub->billing_end}}</td>
                        <td><div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" checked>
                          </div></td>
                    </tr>
                    <!-- Repeat the row -->
                    <tr>
                        @endforeach
                        <td>
                            <a href="#" class="text-white me-2" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="#" class="primary-color-custom" title="Delete">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                        <td>XYZ Motors</td>
                        <td>0001</td>
                        <td>Yearly</td>
                        <td>08/01/2025</td>
                        <td><div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" checked>
                          </div></td>
                    </tr>
                    <!-- Repeat the row -->
                    <tr>
                        <td>
                            <a href="#" class="text-white me-2" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="#" class="primary-color-custom" title="Delete">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                        <td>XYZ Motors</td>
                        <td>0001</td>
                        <td>Yearly</td>
                        <td>08/01/2025</td>
                        <td><div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" checked>
                          </div></td>
                    </tr>
                    <!-- Repeat the row -->
                </tbody>
            </table>
        </div>
    </div>
@endsection