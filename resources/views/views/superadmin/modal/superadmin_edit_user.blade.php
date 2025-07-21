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
        color: white;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: #1F1B2D;
        background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
        background-repeat: no-repeat;
        background-position: right .75rem center;
        background-size: 16px 12px;
        border: var(--bs-border-width) solid var(--bs-border-color);
        border-radius: var(--bs-border-radius);
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
</style>

<!-- Bootstrap Modal -->
@php
    $dealershipNames = \App\Models\User::where('role', 1)->pluck('dealershipName')->toArray();
@endphp
<div class="modal fade" id="editUsererModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUsererModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                
            <!-- Form -->

            <form method="post"
                action="{{ route('superadmin.user.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <?php
                    
                    $provinces = \App\Models\Province::all();
                    
                    ?>
					<div class="mb-4 row">
                        <div class="col-6 mb-3">
                            <h3 style="color: white; font-weight: 600;">Edit User</h3>
                        </div>
                    
					<!-- Image Upload Section -->
                <div class="col-6 mb-3 d-flex justify-content-end pe-4">
                    <div class="dropzone"
                        style="border: 2px dotted #ccc; border-radius: 8px; width: 150px; height: 150px; 
                               display: flex; align-items: center; justify-content: center; text-align: center; 
                               position: relative; background-color:#28223ECC;"
                        onmouseenter="admin_edit_user_showButtons({{ $user->id }})" 
                        onmouseleave="admin_edit_user_hideButtons({{ $user->id }})">
                        
						<input type="file" id="admin_edit_user_profileimg{{ $user->id }}" accept="image/*" 
                    style="display: none;" name="image">
						
                        <label id="admin_edit_user_dropzoneLabel{{ $user->id }}" for="admin_edit_user_profileimg{{ $user->id }}"
                            style="color: #888; cursor: pointer; font-size: 14px; padding: 10px;"
                            class="dropzone-label">Drop an image here or click to upload</label>

                        <img id="admin_edit_user_previewImage{{ $user->id }}"
    data-id="{{ $user->id }}" alt="Preview"
    src="{{ $user->image ? asset('web/profile/' . $user->image) : '' }}"
    style="{{ $user->image ? 'display: block;' : 'display: none;' }} position: absolute; max-width:150px; max-height: 150px; object-fit: contain;">


                        <div id="admin_edit_user_buttons{{ $user->id }}" class="action-buttons"
                            style="display: {{ $user->image ? 'flex' : 'none' }}; position: absolute; bottom: 10px; gap: 5px; 
                                   justify-content: center; align-items: center;">
                            <i class="bi bi-x-circle me-auto" style="color: black; font-size: 18px;"
                                onclick="admin_edit_user_deleteImage({{ $user->id }})"></i>
                            <i class="bi bi-plus-circle ms-auto" onclick="admin_edit_user_triggerFileInput({{ $user->id }})"
                                style="color: black; font-size: 18px;"></i>
                        </div>
                    </div>
                </div>
                    <div class="alert alert-danger" style="display:none;"></div>
                    
                        <div class="row mb-3">
                            <label for="dealershipName" class="col-sm-4 col-form-label">Dealership Name*</label>
                            <div class="col-sm-8 pe-0">
                                <select name="dealershipName" class=" form-select">
                                @foreach ($dealershipNames as $dealershipName)
                                        <option value="{{ $dealershipName }}" {{ $user->dealershipName == $dealershipName ? 'selected' : '' }}>
                                            {{ $dealershipName }}</option>
                                            
                                            @endforeach
                                        </select>
                               
                                @error('dealershipName')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    
                    <div class="row mb-3">
                        <label for="fullName" class="col-sm-4 col-form-label">Full Name*</label>
                        <div class="col-sm-8 pe-0">
                            <input type="text" class="form-control formcontrol" id="fullName" name="name"
                                value="{{ $user->name ?? '' }}" placeholder="Enter full name">
                            @error('name')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="phone" class="col-sm-4 col-form-label">Phone*</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control px-0 ps-1" id="phone" name="code"
                                value="{{ '+92' }}" disabled>

                        </div>
                        <div class="col-sm-7 pe-0">
                            <input type="text" class="form-control " id="phone" name="number"
                                value="{{ str_replace('+92', '', $user->number ?? '') }}" maxlength="10" pattern="\d{10}" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10);" placeholder="Enter phone">
                            @error('number')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-4 col-form-label">Email*</label>
                        <div class="col-sm-8 pe-0">
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ $user->email ?? '' }}" placeholder="Enter email">
                            @error('email')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 d-none">
                        <label for="email" class="col-sm-4 col-form-label">Password*</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password" id="email"
                                placeholder="Enter password">

                        </div>
                    </div>
                    <div class="row mb-3 d-none">
                        <label for="province" class="col-sm-4 col-form-label">Province*</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="province{{ $user->id }}" name="province">
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


                    <div class="row mb-3 d-none">
                        <label for="city" class="col-sm-4 col-form-label">City*</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="city{{ $user->id }}" name="city">
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
                    <div class="row mb-3">
                        <label for="addStatus" class="col-sm-4 col-form-label">Add Status*</label>
                        <div class="col-sm-8 pe-0">
                            <select class="form-select" id="addStatus" name="status">
                                <option value="" selected>Select Status</option>
                                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 d-none">
                        <label for="addStatus" class="col-sm-4 col-form-label">Enter Address</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="address" name="address">{!! $user->address !!}</textarea>
                            @error('address')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 d-none">
                        <label for="website" class="col-sm-4 col-form-label">Website (if any)</label>
                        <div class="col-sm-8">
                            <input type="url" class="form-control" id="website" name="website"
                                value="{{ $user->website }}" placeholder="Enter website">
                            @error('website')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-check mb-2 d-none">
                        <input class="form-check-input" type="checkbox" name="allow_company" id="marketplace"
                            {{ $user->allow_company == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="marketplace">
                            Enable for Marketplace - Allow your company to access and sell products in our online
                            marketplace.
                        </label>
                    </div>
                    <div class="form-check mb-2 d-none">
                        <input class="form-check-input" type="checkbox" name="bulk_import" id="inventory"
                            {{ $user->bulk_import == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="inventory">
                            Enable for Inventory Bulk Import - Streamline your operations by importing inventory
                            data in bulk.
                        </label>
                    </div>
                    <div class="form-check mb-2 d-none">
                        <input class="form-check-input" type="checkbox" name="user_management" id="userManagement"
                            {{ $user->user_management == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="userManagement">
                            Enable for User Management - Manage user roles and permissions within your organization
                            effectively.
                        </label>
                    </div>

                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn  custom-btn-nav rounded">update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    function admin_edit_user_triggerFileInput(id) {
        document.getElementById('admin_edit_user_profileimg' + id).click();
    }

    document.querySelectorAll("[id^=admin_edit_user_profileimg]").forEach(input => {
        input.addEventListener('change', (event) => {
            let id = event.target.id.replace('admin_edit_user_profileimg', '');
            let file = event.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('admin_edit_user_previewImage' + id).src = e.target.result;
                    document.getElementById('admin_edit_user_previewImage' + id).style.display = 'block';
                    document.getElementById('admin_edit_user_dropzoneLabel' + id).style.display = 'none';
                    document.getElementById('admin_edit_user_buttons' + id).style.display = 'flex';
                };
                reader.readAsDataURL(file);
            }
        });
    });

    function admin_edit_user_deleteImage(id) {
        document.getElementById('admin_edit_user_previewImage' + id).src = '';
        document.getElementById('admin_edit_user_previewImage' + id).style.display = 'none';
        document.getElementById('admin_edit_user_dropzoneLabel' + id).style.display = 'block';
        document.getElementById('admin_edit_user_buttons' + id).style.display = 'none';
    }

    document.getElementById('province'+{{ $user->id }}).addEventListener('change', function() {
        let provinceId = this.value;
        let citySelect = document.getElementById('city'+{{ $user->id }});
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
        $('#SuperadmineditUserForm{{ $user->id }}').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            $.ajax({
                url: $(this).attr('action'), // The action URL from your form
                method: $(this).attr('method'), // Form method (POST or PUT)
                data: $(this).serialize(), // Serialize form data
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    if (response.success) {
                        $('#SuperadmineditUserForm{{ $user->id }}').modal(
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
     function admin_edit_user_showButtons(id) {
        if (document.getElementById('admin_edit_user_previewImage' + id).style.display === 'block') {
            document.getElementById('admin_edit_user_buttons' + id).style.display = 'flex';
        }
    }

    // Hide buttons on mouse leave
    function admin_edit_user_hideButtons(id) {
        if (document.getElementById('admin_edit_user_previewImage' + id).style.display === 'block') {
            document.getElementById('admin_edit_user_buttons' + id).style.display = 'none';
        }
    }
</script>
