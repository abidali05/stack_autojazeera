 <style>
.subscription-card {
    background-image: url('web/images/newbackimg.svg');
    background-size: cover;       /* Cover the whole card */
    background-repeat: no-repeat; /* Prevent tiling */
    background-position: center;  /* Center the image */
		background-color:#281F48 !important;
}

</style>
@extends('layout.panel_layout.main')
@section('content')
<div class="modal fade" id="cancelplanmodal" tabindex="-1" aria-labelledby="cancelplanmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
            <!-- Modal Header -->
            <div class="modal-header" style="background-color: #F0F3F6; color: white; border-bottom: none;">
                <h5 class="modal-title" id="cancelplanmodalLabel">Cancel Subscription</h5>
                <button type="button" class="btn-close" style="background-color: white; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body text-center p-4"  style="background-color: #F0F3F6;">
                <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                
                <h6 class="" style="line-height: 1.6;">
                    Your subscription will be canceled at the end of the current billing cycle. By canceling, you will no longer be able to post ads, and all existing ads will be removed from the marketplace.
                    <br><br>
                    <strong>Are you sure you want to proceed?</strong>
                </h6>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer justify-content-center border-0">
                <a href="#" class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #FD5631; border-radius: 5px;" data-bs-dismiss="modal">No</a>
                <a href="{{route('cancel_plan',Auth::user()->id)}}" class="btn  px-4 py-2" style="border-radius: 5px; font-weight:600;background-color:  #FD5631;  color: white;">Yes</a>
            </div>
        </div>
    </div>
</div>

<div class="container">
        <div class="row mb-5 pt-5">
            <div class="col-md-12">
                <div class="subscription-card">
                    <div class="card-header d-flex">
                        <i class="bi bi-lightbulb"></i> Current Subscription Plan
                    </div>

                    <div class="card-body">
                    
                      <h2 class="plan-name d-flex align-items-center">@if(isset($subscription)){{$subscription->subscribe()->name??""}} @endif: <span class="price"> 
                       
                     {{$subscription->subscribe()->metadata->freemium == 'true' ? "Free" : 'PKR '.$subscription->subscribe()->metadata->price}} </span>
                           </h2>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                            <p class="next-billing mb-0">Next billing date - {{$subscription->billing_end??""}}</p>
                        <div class="d-flex">
                            <a class="btn change-plan me-1" style="font-size:14px" href="{{route('subscription.index')}}">Upgrade Plan</a>
                            <a href="#" data-bs-toggle="modal"  style="font-size:14px" data-bs-target="#cancelplanmodal" class="btn cancel-plan">Cancel Plan</a>
                        </div>
                    </div>
                </div>
                <div class="subscription-card mt-3 d-none">
                    <div class="card-header">
                        <span class="card-logo">VISA</span>
                        <div class="card-actions">
                            <i class="bi bi-pencil edit-icon" title="Edit"></i>
                            <i class="bi bi-trash delete-icon" title="Delete"></i>
                        </div>
                    </div>
                    <div class="card-number">
                        •••• •••• •••• <span class="last-digits">1234</span>
                    </div>
                    <div class="card-details">
                        <div class="card-holder">
                            <span>Card Holder</span>
                            <p>Aycan Doganlar</p>
                        </div>
                        <div class="card-expiry">
                            <span>Expires</span>
                            <p>12/29</p>
                        </div>
                    </div>
                </div>

                <button class="add-card-btn mt-3 w-100 text-center d-none">
                    <i class="bi bi-plus-circle"></i> Add Card
                </button>


            </div>
            <div class="col-md-7 d-none">
                <div class="d-flex justify-content-between filter-bar mb-3 d-none">
                    <input type="text" class="form-control w-25" placeholder="Search User">
                    <select class="form-select w-25">
                        <option>Filter item type</option>
                    </select>
                    <select class="form-select w-25">
                        <option>Filter date</option>
                    </select>
                </div>
         <div class="table-responsive">
    <table class="table table-striped transparent-table align-middle">
        <thead>
            <tr>
                {{-- <th>Description</th> --}}
                <th style="color:#FD5631 !important">Billed To</th>
                <th style="color:#FD5631 !important">Created On</th>
                <th style="color:#FD5631 !important">Status</th>
                <th style="color:#FD5631 !important">Total</th>
                <th style="color:#FD5631 !important">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (count($subscriptionData) == 0)
                <tr>
                    <td colspan="5" class="text-center">No subscriptions found.</td>
                </tr>
                
            @endif
        @foreach($subscriptionData as $subscription)
            <tr>
                {{-- <td>
                    {{ $subscription->items->data[0]->plan->nickname ?? 'N/A' }}
                    <br>
                    <small>{{ $subscription->id }}</small>
                </td> --}}
                <td>
                    {{ $customer['name'] }}
                    <br>
                    <small>{{ $customer['email'] }}</small>
                </td>
                <td>
                    {{-- {{\carbon\carbon::parse($subscription->current_period_end)->format('d/m/Y')}} --}}
                    {{ date('d/m/Y', $subscription->created) }}
                </td>
                <td>
                    <span class="status-{{ $subscription->status }}">
                        {{ ucfirst($subscription->status) }}
                    </span>
                </td>
                <td>
                    PKR {{ $subscription->metadata->price }}
                </td>
                {{-- <td>
                    PKR {{ number_format($subscription->items->data[0]->plan->amount / 100, 2) }}
                </td> --}}
                <td>
                <?php
                // Find the invoice related to the current subscription
                $invoiceCollection = collect($invoiceData);
                $invoice = $invoiceCollection->firstWhere('subscription', $subscription->id);
                $invoiceUrl = $invoice ? $invoice->hosted_invoice_url : '#'; // Fallback if no invoice is found
                ?>
                    <a href="{{ $invoice ? route('downloadInvoice', $invoice->id): ''}}" target="_blank" class="view-invoice">View Invoice</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

 

            </div>
        </div>
        <h3 class="my-3 primary-color-custom"> Subscription History</h3>
         {{-- subscription history table  --}}
  <table class="table table-striped transparent-table align-middle mb-5">
    <thead>
        <tr>
            {{-- <th>Description</th> --}}
            <th style="color:#FD5631 !important">Plan</th>
            <th style="color:#FD5631 !important">Billed To</th>
            <th style="color:#FD5631 !important">Created On</th>
            <th style="color:#FD5631 !important">Status</th>
            <th style="color:#FD5631 !important">Total</th>
              <th style="color:#FD5631 !important">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (count($subscriptionHistory) == 0)
            <tr>
                <td colspan="5" class="text-center">No subscriptions found.</td>
            </tr>
            
        @endif
@foreach ($subscriptionHistory as $subscriptionHistory)
<tr>
    <td>
        {{ $subscriptionHistory->subscription_name }}
    
    </td>
    <td>
        {{ $subscriptionHistory->user->name }}
        <br>
        <small>{{ $subscriptionHistory->user->email }}</small>
    </td>
    <td>
        {{ \Carbon\Carbon::parse($subscriptionHistory->billing_start)->format('d-m-Y') }}
    </td>
    <td>
        <span class="status-{{ $subscriptionHistory->status }}">
            {{ $subscriptionHistory->status == '1' ? 'Active' : 'Inactive' }}
        </span>
    </td>
    <td>
        PKR {{ $subscriptionHistory->price }}
    </td>
             <td>
                <?php
                // Find the invoice related to the current subscription
                $invoiceCollection = collect($invoiceData);
                $invoice = $invoiceCollection->firstWhere('subscription', $subscription->id);
                $invoiceUrl = $invoice ? $invoice->hosted_invoice_url : '#'; // Fallback if no invoice is found
                ?>
                    <a href="{{ $invoice ? route('downloadInvoice', $invoice->id): ''}}" target="_blank" class="view-invoice">View Invoice</a>
                </td>

@endforeach
</tbody>
</table>
    </div>
@endsection