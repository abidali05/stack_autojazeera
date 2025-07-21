

<!-- Model Create Dealer -->
<!-- Modal -->
<div class="modal fade" id="editDealeuserrModal{{$user->id}}" tabindex="-1" aria-labelledby="addDealerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
            <div class="modal-header border-0" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                <h5 class="modal-title" id="addDealerModalLabel"><strong> Update Dealer User</strong></h5>
                <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post"  @if (Request::is('superadmin/*'))  action="{{route('superadmin.dealer-user.update',$user->id)}}" @else action="{{route('dealer_user.update',$user->id)}}" @endif >
                @csrf
                @method('PUT')
            <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">
         <input type="hidden" name="role" id="role_id">
                    <div class="row mb-3">
                        <label for="dealershipName" class="col-sm-4 col-form-label">Dealership Name*</label>
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" id="dealershipName"
                                placeholder="Enter dealership name" name="dealershipName" value="{{$user->dealershipName}}" >
							 <input type="text" class="form-control" id="dealershipName"
                                placeholder="Enter dealership name" value="{{$user->dealershipName}}" disabled>
                            <input type="hidden" class="form-control" id=""
                             value="{{request()->id??Auth::user()->id}}" name="dealerName" required>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <label for="fullName" class="col-sm-4 col-form-label">Full Name*</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="fullName" name="name" value="{{$user->name}}" placeholder="Enter full name"
                                >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="phone" class="col-sm-4 col-form-label">Phone*</label>
                        <div class="col-sm-8">
                            <input type="tel" class="form-control" id="phone" name="PhoneNumber" placeholder="Enter phone" value="{{$user->number}}" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-4 col-form-label">Email*</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name="email" id="email" value="{{$user->email}}" placeholder="Enter email" >
                        </div>
                    </div>
                    <!--<div class="row mb-3">
                        <label for="email" class="col-sm-4 col-form-label">Password*</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password" id="email" placeholder="Enter password" >
                        </div>
                    </div> -->
                    <div class="row mb-3">
                        <label for="addStatus" class="col-sm-4 col-form-label">Status*</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="addStatus" name="status" required>
                                <option value="" selected>Select Status</option>
                                <option value="active" {{$user->status == 'active' ?'selected':''}}>Active</option>
                                <option value="inactive" {{$user->status == 'inactive' ?'selected':''}}>Inactive</option>
                            </select>
                            @error('status')
                            <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
    <label for="province" class="col-sm-4 col-form-label">Permissions*</label>

<div class="col-sm-8">
    @php
        $userPermissions = $permissions->where('user_id', $user->id)->pluck('permissions')->toArray();
    @endphp

    <input class="form-check-input" type="checkbox" name="permissions[]" id="postAd" 
           {{ in_array('post_ads', $userPermissions) ? 'checked' : '' }} value="post_ads">
    <label class="form-check-label" for="postAd">
        Post an Ad
    </label>

    <input class="form-check-input" type="checkbox" name="permissions[]" id="manageAds" 
           {{ in_array('manage_ads', $userPermissions) ? 'checked' : '' }} value="manage_ads">
    <label class="form-check-label" for="manageAds">
        Manage Ads
    </label>

    <input class="form-check-input" type="checkbox" name="permissions[]" id="viewLeads" 
           {{ in_array('view_leads', $userPermissions) ? 'checked' : '' }} value="view_leads">
    <label class="form-check-label" for="viewLeads">
        View Leads
    </label>

    {{-- <input class="form-check-input" type="checkbox" name="permissions[]" id="manageUsers" 
           {{ in_array('manage_users', $userPermissions) ? 'checked' : '' }} value="manage_users">
    <label class="form-check-label" for="manageUsers">
        Manage Users
    </label> --}}
</div>

</div>
                  
              
           
           
            </div>
            <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                <button type="button" class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>


