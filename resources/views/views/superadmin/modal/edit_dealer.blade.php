<!-- Bootstrap Modal -->
<style>
    .col-form-label {
        font-family: Maven Pro;
        font-size: 18.6px;
        font-weight: 600;
        line-height: 20.68px;
        text-align: left;
        color: white;
    }

    .form-control {
        background-color: transparent !important;
        color: #D0D5DD !important;
        border: 1px solid #D0D5DD;

        border-radius: 5px;
    }

    .form-select {
        --bs-form-select-bg-img: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e);
        display: block;
        width: 100%;
        padding: .375rem 2.25rem .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 25.68px;
        color: #281F48 !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
		background-color: white !important;
        background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
        background-repeat: no-repeat;
        background-position: right .75rem center;
        background-size: 16px 12px;
        border: var(--bs-border-width) solid var(--bs-border-color);
        border-radius: var(--bs-border-radius);
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
</style>
<div class="modal fade" id="editDealerModal{{ $user->id }}" tabindex="-1" aria-labelledby="editDealerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Form -->
            <form method="post"
                action="{{ route('superadmin.dealer.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body" style="background-color:#F0F3F6 !important;">
                    <?php
                    
                    $provinces = \App\Models\Province::all();
                    
                    ?>
                    <div class="mb-4 row">
                        <div class="col-6">
                            <h3 style="color: #281F48; font-weight: 600;">Edit Dealer</h3>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <div class="dropzone" style="border: 2px dotted #ccc; border-radius: 8px; width: 150px; height: 150px; 
        display: flex; align-items: center; justify-content: center; text-align: center; 
        position: relative; background-color:#28223ECC;"
        onmouseenter="admin_edit_dealer_showButtons({{ $user->id }})"
        onmouseleave="admin_edit_dealer_hideButtons({{ $user->id }})">
        <input type="file" id="admin_edit_dealer_profileimg{{ $user->id }}" accept="image/*"
               style="display: none;" name="image">
        <label id="admin_edit_dealer_dropzoneLabel{{ $user->id }}"
               for="admin_edit_dealer_profileimg{{ $user->id }}"
               style="color: #888; cursor: pointer; font-size: 14px; padding: 10px; display: {{ $user->image ? 'none' : 'block' }};"
               class="dropzone-label">Drop an image here or click to upload</label>

        <img id="admin_edit_dealer_previewImage{{ $user->id }}"
             data-id="{{ $user->id }}" alt="Preview"
             src="{{ $user->image ? asset('web/profile/' . $user->image) : '' }}"
             style="{{ $user->image ? 'display: block;' : 'display: none;' }} position: absolute; max-width:150px; max-height: 150px; object-fit: contain;">

        <div id="admin_edit_dealer_buttons{{ $user->id }}" class="action-buttons"
             style="display: {{ $user->image ? 'flex' : 'none' }}; position: absolute; bottom: 10px; gap: 5px; 
                justify-content: center; align-items: center;">
            <i class="bi bi-x-circle me-auto" style="color: black; font-size: 18px;"
               onclick="admin_edit_dealer_deleteImage({{ $user->id }})"></i>
            <i class="bi bi-plus-circle ms-auto"
               onclick="admin_edit_dealer_triggerFileInput({{ $user->id }})"
               style="color: black; font-size: 18px;"></i>
        </div>
    </div>
                    </div>
                    <div class="alert alert-danger" style="display:none;"></div>
                    @if ($user->role == 1)
                        <div class="mb-3 row mt-3">
                            <label for="dealershipName" class="col-sm-4 col-form-label">Dealership Name*</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control " name="dealershipName"
                                    value="{{ $user->dealershipName ?? '' }}" id="dealershipName"
                                    placeholder="Enter dealership name">
                                @error('dealershipName')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endif
                    <div class="mb-3 row">
                        <label for="fullName" class="col-sm-4 col-form-label">Full Name*</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control " id="fullName" name="name"
                                value="{{ $user->name ?? '' }}" placeholder="Enter full name">
                            @error('name')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="phone" class="col-sm-4 col-form-label">Phone*</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control" id="phone" name="code"
                                value="{{ '+92' }}" disabled style="padding-left:4px; padding-right:0px">

                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="number-update" name="number"
                                value="{{ str_replace('+92', '', $user->number ?? '') }}" maxlength="10" pattern="\d{10}" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10);" placeholder="Enter phone">
                            <small id="number-update-error" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-4 col-form-label">Email*</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ $user->email ?? '' }}" placeholder="Enter email">
							<small id="email-error-update" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="mb-3 row d-none">
                        <label for="email" class="col-sm-4 col-form-label">Password*</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password" id="email"
                                placeholder="Enter password">

                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="province" class="col-sm-4 col-form-label">Province*</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="province" name="province" style="background-color:white !important;color:#281F48 !important;text-align:start;">
                                <option value="" selected>Select province</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}"
                                        {{ $user->province == $province->id ? 'selected' : '' }}>{{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('province')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 row">
                        <label for="city" class="col-sm-4 col-form-label">City*</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="city" name="city" style="background-color:white !important;color:#281F48 !important;text-align:start;">
                                @if (isset($user->city))
                                    <option value="{{ $user->city }}" selected>{{ $user->cityname }}</option>'
                                    <!-- Cities will be populated here based on selected province -->
                                @endif
                            </select>
                            @error('city')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="addStatus" class="col-sm-4 col-form-label" >Add Status*</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="addStatus" name="status" style="background-color:white !important;color:#281F48 !important;text-align:start;">
                                <option value="" selected>Select Status</option>
                                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="addStatus" class="col-sm-4 col-form-label">Enter Address</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="address" name="address">{!! $user->address !!}</textarea>
                            @error('address')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="website" class="col-sm-4 col-form-label">Website (if any)</label>
                        <div class="col-sm-8">
                            <input type="url" class="form-control" id="website" name="website"
                                value="{{ $user->website }}" placeholder="Enter website">
                            @error('website')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2 form-check">
                        <input class="form-check-input" type="checkbox" name="allow_company" id="marketplace"
                            {{ $user->allow_company == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="marketplace">
                            Enable for Marketplace - Allow your company to access and sell products in our online
                            marketplace.
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input class="form-check-input" type="checkbox" name="bulk_import" id="inventory"
                            {{ $user->bulk_import == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="inventory">
                            Enable for Inventory Bulk Import - Streamline your operations by importing inventory
                            data in bulk.
                        </label>
                    </div>
                    <div class="mb-2 form-check">
                        <input class="form-check-input" type="checkbox" name="user_management" id="userManagement"
                            {{ $user->user_management == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="userManagement">
                            Enable for User Management - Manage user roles and permissions within your organization
                            effectively.
                        </label>
                    </div>

                </div>
                <div class="border-0 modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="updateBtn" class="rounded btn custom-btn-nav">update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    function admin_edit_dealer_triggerFileInput(id) {
        document.getElementById('admin_edit_dealer_profileimg' + id).click();
    }

    document.querySelectorAll("[id^=admin_edit_dealer_profileimg]").forEach(input => {
        input.addEventListener('change', (event) => {
            let id = event.target.id.replace('admin_edit_dealer_profileimg', '');
            let file = event.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('admin_edit_dealer_previewImage' + id).src = e.target
                        .result;
                    document.getElementById('admin_edit_dealer_previewImage' + id).style.display =
                        'block';
                    document.getElementById('admin_edit_dealer_dropzoneLabel' + id).style.display =
                        'none';
                    document.getElementById('admin_edit_dealer_buttons' + id).style.display =
                    'flex';
                };
                reader.readAsDataURL(file);
            }
        });
    });

    function admin_edit_dealer_deleteImage(id) {
    document.getElementById('admin_edit_dealer_previewImage' + id).src = '';
    document.getElementById('admin_edit_dealer_previewImage' + id).style.display = 'none';
    document.getElementById('admin_edit_dealer_dropzoneLabel' + id).style.display = 'block';
    document.getElementById('admin_edit_dealer_buttons' + id).style.display = 'none';
    
    // Reset the file input value when image is deleted
    document.getElementById('admin_edit_dealer_profileimg' + id).value = ''; 
    
    // If you are submitting the form, ensure the image field is still valid
    document.getElementById('admin_edit_dealer_profileimg' + id).setCustomValidity(''); // Clear any custom validation
}



    document.getElementById('province').addEventListener('change', function() {
        let provinceId = this.value;
        let citySelect = document.getElementById('city');
        citySelect.innerHTML = '<option value="" selected>Select City</option>';
        if (provinceId) {
            fetch(`/getCities/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(city => {
                        let option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                });
        }
    });


    $(document).ready(function() {
        $('#editDealerForm{{ $user->id }}').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            $.ajax({
                url: $(this).attr('action'), // The action URL from your form
                method: $(this).attr('method'), // Form method (POST or PUT)
                data: $(this).serialize(), // Serialize form data
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    if (response.success) {
                        $('#editDealerModal{{ $user->id }}').modal(
                            'hide'); // Hide modal on success
                        alert('Data updated successfully!'); // Show success message
                        location.reload();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) { // Check for validation errors
                        let errors = xhr.responseJSON.errors;
                        let errorHtml = '<ul class="alert alert-danger">';

                        // Clear previous error messages
                        $('.alert-danger').remove();

                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value[0] +
                                '</li>'; // Display each error
                            // Show the error next to each field
                            $('[name=' + key + ']').next('.alert')
                                .remove(); // Remove previous error messages
                            $('[name=' + key + ']').after(
                                '<div class="alert alert-danger">' + value[0] +
                                '</div>');
                        });

                        errorHtml += '</ul>';
                        $('#editDealerModal{{ $user->id }} .modal-body').prepend(
                            errorHtml); // Show errors at the top of the modal
                    }
                }
            });
        });
    });


    // Show buttons on hover
    function admin_edit_dealer_showButtons(id) {
        if (document.getElementById('admin_edit_dealer_previewImage' + id).style.display === 'block') {
            document.getElementById('admin_edit_dealer_buttons' + id).style.display = 'flex';
        }
    }

    // Hide buttons on mouse leave
    function admin_edit_dealer_hideButtons(id) {
        if (document.getElementById('admin_edit_dealer_previewImage' + id).style.display === 'block') {
            document.getElementById('admin_edit_dealer_buttons' + id).style.display = 'none';
        }
    }
</script>
	
	<script>
$(document).ready(function() {
	
    $(document).on('input', '#email_update', function() {
        let email = $(this).val();
		//console.log('Input Triggered');
        //if (email.length > 5) { // Only check after a few characters
            $.ajax({
                url: "{{ route('superadmin.check_email_update') }}",
                type: "POST",
                data: {
                    email: email,
					user_id: "{{ $user->id }}", 
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.exists) {
                        $('#email-error-update').text('This email is already taken.').show();
						$('#updateBtn').prop('disabled', true);
                    } else {
                        $('#email-error-update').text('');
						$('#updateBtn').prop('disabled', false);
                    }
                }
            });
       // } else {
         //   $('#email-error').text('');
			//$('#saveBtn').prop('disabled', false);
       // }
    });
});
</script>
	<script>
$(document).ready(function() {
	let debounceTimer;
    $(document).on('input', '#number-update', function() {
        let email = $(this).val();
		clearTimeout(debounceTimer);
		//console.log('Input Triggered');
        //if (email.length > 5) { // Only check after a few characters
		debounceTimer = setTimeout(function() {
            $.ajax({
                url: "{{ route('superadmin.check_number_update') }}",
                type: "POST",
                data: {
                    number: number,
					user_id: "{{ $user->id }}", 
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.exists) {
                        $('#number-update-error').text('This number is already taken.').show();
						$('#saveBtn').prop('disabled', true);
                    } else {
                        $('#number-update-error').text('');
						$('#saveBtn').prop('disabled', false);
                    }
                }
            });
			}, 500);
       // } else {
         //   $('#email-error').text('');
			//$('#saveBtn').prop('disabled', false);
       // }
    });
});
</script>
