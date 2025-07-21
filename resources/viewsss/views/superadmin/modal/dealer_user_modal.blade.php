<style>
    .col-form-label {
        color: #281F48;
    }

    .form-control {
        background-color: white !important;
        color: #281F48 !important;
    }
</style>

<!-- Model Create Dealer -->
<!-- Modal -->
<div class="modal fade" id="addDealeruserModal" tabindex="-1" aria-labelledby="addDealerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
            <div class="modal-header border-0" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                <h5 class="modal-title" id="addDealerModalLabel"><strong> Add New Dealer User</strong></h5>
                <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post"
                @if (Request::is('superadmin/*')) action="{{ route('superadmin.dealer-user.store') }}" @else action="{{ route('dealer_user.store') }}" @endif>
                @csrf
                <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">
                    <input type="hidden" name="role" id="role_id">
                    <div class="row mb-3">
                        <label for="dealershipName" class="col-sm-4 col-form-label">Dealership Name*</label>
                        <div class="col-sm-8">
                            <?php
                            $d = null; // Initialize the variable to prevent undefined variable errors
                            
                            if (Request::is('superadmin/dealeruser/*')) {
                                if (request()->has('id')) {
                                    // Check if 'id' exists in the request
                                    $u = App\Models\User::find(request()->id);
                                    if ($u) {
                                        // Ensure $u is not null
                                        $d = $u->dealershipName;
                                    }
                                }
                            }
                            
                            if (!Request::is('superadmin/*')) {
                                $authUserId = Auth::id(); // Safely get the authenticated user's ID
                                if ($authUserId) {
                                    $u = App\Models\User::find($authUserId);
                                    if ($u) {
                                        // Ensure $u is not null
                                        $d = $u->dealershipName;
                                    }
                                }
                            }
                            
                            // $d now holds the dealership name or remains null if not found
                            
                            ?>

                            <input type="hidden" class="form-control formcontrol" id="dealershipName"
                                placeholder="Enter dealership name" name="dealershipName" value="{{ $d ?? '' }}"
                                required>
                            <input type="text" class="form-control  " id="dealershipName"
                                placeholder="Enter dealership name" value="{{ $d ?? '' }}" disabled>
                            @if (isset(request()->id) || isset(Auth::user()->id))
                                <input type="hidden" class="form-control" id=""
                                    value="{{ request()->id ?? Auth::user()->id }}" name="dealerName" required>
                            @endif
                        </div>

                    </div>
                    <div class="row mb-3">
                        <label for="fullName" class="col-sm-4 col-form-label">Full Name*</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control " id="fullName" name="name"
                                placeholder="Enter full name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="phone" class="col-sm-4 col-form-label">Phone*</label>
                        <div class="col-sm-8">
                            <input type="tel" class="form-control " id="phone-number" name="PhoneNumber"
                                placeholder="+92 000 0000000" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-4 col-form-label">Email*</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control " style="background-color: white" name="email" id="email"
                                placeholder="Enter email" required>
                        </div>
                    </div>
                    <div class="row mb-3 d-none">
                        <label for="email" class="col-sm-4 col-form-label">Password*</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control " name="password" id="email"
                                placeholder="Enter password">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="province" class="col-sm-4 col-form-label">Permissions*</label>

                        <div class="col-sm-8">
                            <input class="form-check-input" type="checkbox" name="permissions[]" id="postAd"
                                value="post_ads" checked>
                            <label class="form-check-label" for="postAd">
                                Post an Ad
                            </label>

                            <input class="form-check-input" type="checkbox" name="permissions[]" id="manageAds"
                                value="manage_ads" checked>
                            <label class="form-check-label" for="manageAds">
                                Manage Ads
                            </label>

                            <input class="form-check-input" type="checkbox" name="permissions[]" id="viewLeads"
                                value="view_leads" checked>
                            <label class="form-check-label" for="viewLeads">
                                View Leads
                            </label>

                            {{-- <input class="form-check-input" type="checkbox" name="permissions[]" id="manageUsers" value="manage_users" checked>
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


<script>
    $(document).ready(function() {
        $('#phone-number').on('input', function() {
            let phoneValue = $(this).val().replace(/[^0-9]/g, '').replace(/^92/,
            ''); // Remove non-numeric & extra 92
            let formatted = '+92 ' + phoneValue.substring(0, 3) + (phoneValue.length > 3 ? ' ' +
                phoneValue.substring(3, 11) : '');
            $(this).val(formatted.substring(0, 15)); // Limit max length of "+92 XXX XXXXXXXX"

            // Show/hide error message based on correct format
            $('#phone-error').toggle(!/^\+92 \d{3} \d{8}$/.test(formatted));
        });
    });
</script>
