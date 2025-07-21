<!-- Model Create Dealer -->
<!-- Modal -->
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
<div class="modal fade" id="addDealerModal" tabindex="-1" aria-labelledby="addDealerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content" >

            <form method="post" action="{{ route('superadmin.dealer.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-5 " style="background-color:#F0F3F6 !important">
                    <div class="row mb-4">
                        <div class="col-6">
                            <h3 style=" font-weight: 600; color:#281F48 !important">Add New Dealer</h3>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <div class="dropzone"
                                style=" border: 2px dotted #ccc;
                                    border-radius: 8px;
                                    width: 150px;
                                    height: 150px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    text-align: center;
                                    position: relative;
                                    background-color:#F0F3F6;"
                                onmouseenter="showButtons()" onmouseleave="hideButtons()">
                                <input type="file" id="profileimg" accept="image/*" style="display: none;"
                                    name="image">
                                <label id="dropzoneLabel" for="profileimg"
                                    style="   color: #888;
    cursor: pointer;
    font-size: 14px;
    padding: 10px;"
                                    class="dropzone-label">Drop an image here or click to upload</label>
                                <img id="previewImage" alt="Preview"
                                    style="display: none;   position: absolute;
                                        max-width:150px;
                                        max-height: 150px;
                                        object-fit: contain;">
                                <div id="buttons" class="action-buttons"
                                    style="display: none;     position: absolute;
                                        bottom: 10px;
                                     
                                        gap: 5px;
                                        justify-content: center;
                                        align-items: center;">
                                    <i class="bi bi-x-circle me-auto" style="color: black; font-size: 18px;"
                                        onclick="deleteImage()"></i>
                                    <i class="bi bi-plus-circle ms-auto" onclick="triggerFileInput()"
                                        style="color: black; font-size: 18px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <input type="hidden" name="role" id="role_id">
                    <div class="row mb-3 mt-3" id="dealershipNameRow">
                        <label for="dealershipName" class="col-sm-4 col-form-label">Dealership Name*</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="dealershipName"
                                placeholder="Enter dealership name" name="dealershipName" required>
                            @error('dealershipName')
                                <div class="alert bg-none">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="row mb-3">
                        <label for="fullName" class="col-sm-4 col-form-label">Full Name*</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="fullName" name="name"
                                placeholder="Enter full name" required>
                            @error('name')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="phone" class="col-sm-4 col-form-label">Phone*</label>
                        <div class="col-sm-1">
                            <input type="tel" class="form-control" id="phone" placeholder="Enter phone"
                                value="{{ '+92' }}" disabled style="padding-left:4px; padding-right:0px">

                        </div>
                        <div class="col-sm-7">
                            <input type="string" class="form-control" id="number" name="number"
                                placeholder="Enter phone" maxlength="10" pattern="\d{10}" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10);" required>
                            <small id="number-error" class="text-danger"></small>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-4 col-form-label">Email*</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter email" required>
                            <small id="email-error" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="row mb-3 d-none">
                        <label for="password" class="col-sm-4 col-form-label">Password*</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter password">
                            @error('password')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="province" class="col-sm-4 col-form-label">Province*</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="province1" name="province" style="background-color:white; color:#281F48 ;text-align:start" required>
                                <option value="" selected>Select province</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('province')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="city" class="col-sm-4 col-form-label">City*</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="city1" name="city" style="background-color:white; color:#281F48 ;text-align:start" required>
                                <option value="" selected>Select City</option>
                                <!-- Cities will be populated here based on selected province -->
                            </select>
                            @error('city')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="addStatus" class="col-sm-4 col-form-label">Add Status*</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="addStatus" name="status" style="background-color:white; color:#281F48 ;text-align:start" required>
                                <option value="" selected>Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            @error('status')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="addStatus" class="col-sm-4 col-form-label">Enter Address*</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="address" name="address" required></textarea>
                            @error('address')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="website" class="col-sm-4 col-form-label">Website (if any)</label>
                        <div class="col-sm-8">
                            <input type="url" class="form-control" id="website" name="website"
                                placeholder="Enter website">
                            @error('website')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="allow_company" id="marketplace">
                        <label class="form-check-label" for="marketplace">
                            Enable for Marketplace - Allow your company to access and sell products in our online
                            marketplace.
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="bulk_import" id="inventory">
                        <label class="form-check-label" for="inventory">
                            Enable for Inventory Bulk Import - Streamline your operations by importing inventory
                            data in bulk.
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="user_management" id="userManagement">
                        <label class="form-check-label" for="userManagement">
                            Enable for User Management - Manage user roles and permissions within your organization
                            effectively.
                        </label>
                    </div>

                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="saveBtn" class="btn  custom-btn-nav rounded">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    document.getElementById('province1').addEventListener('change', function() {
        var provinceId = this.value;

        var citySelect = document.getElementById('city1');

        // Clear the current city options
        citySelect.innerHTML = '<option value="" selected>Select City</option>';

        // Fetch cities based on selected province
        if (provinceId) {
            fetch(`/getCities/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(city => {
                        var option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        citySelect.appendChild(option);

                    });

                })
                .catch(error => console.error('Error fetching cities:', error));
        }
    });
</script>
<script>
    const fileInput = document.getElementById('profileimg');
    const previewImage = document.getElementById('previewImage');
    const dropzoneLabel = document.getElementById('dropzoneLabel');
    const buttons = document.getElementById('buttons');

    // Trigger file input on click
    function triggerFileInput() {
        fileInput.click();
    }

    // Handle file selection and image preview
    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                dropzoneLabel.style.display = 'none'; // Hide label
                buttons.style.display = 'flex'; // Show action buttons
            };
            reader.readAsDataURL(file);
        }

        // Clear the input value to allow re-selection of the same file
        
    });

    // Delete the image
    function deleteImage() {
        previewImage.src = '';
        previewImage.style.display = 'none';
        dropzoneLabel.style.display = 'block'; // Show label again
        buttons.style.display = 'none'; // Hide action buttons
    }

    // Show buttons on hover
    function showButtons() {
        if (previewImage.style.display === 'block') {
            buttons.style.display = 'flex';
        }
    }

    // Hide buttons on mouse leave
    function hideButtons() {
        if (previewImage.style.display === 'block') {
            buttons.style.display = 'none';
        }
    }
</script>
<script>
$(document).ready(function() {
	
    $(document).on('input', '#email', function() {
        let email = $(this).val();
		//console.log('Input Triggered');
        //if (email.length > 5) { // Only check after a few characters
            $.ajax({
                url: "{{ route('superadmin.check_email_create') }}",
                type: "POST",
                data: {
                    email: email,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.exists) {
                        $('#email-error').text('This email is already taken.').show();
						$('#saveBtn').prop('disabled', true);
                    } else {
                        $('#email-error').text('');
						$('#saveBtn').prop('disabled', false);
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
    
    $(document).on('input', '#number', function() {
        let number = $(this).val();

        // Clear the previous debounce timer to avoid rapid requests
        clearTimeout(debounceTimer);

        // Set a new debounce timer (500ms delay)
        debounceTimer = setTimeout(function() {
            // If the number field is empty, disable the button and clear error message
            if (number.trim() === '') {
                $('#number-error').text('');
                $('#saveBtn').prop('disabled', false);
                return;
            }

            $.ajax({
                url: "{{ route('superadmin.check_number_create') }}",
                type: "POST",
                data: {
                    number: number,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.exists) {
                        $('#number-error').text('This number is already taken.').show();
                        $('#saveBtn').prop('disabled', true);
                    } else {
                        $('#number-error').text('').hide();
                        $('#saveBtn').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error during AJAX request: " + status + " " + error);
                }
            });
        }, 500);  // Delay the request for 500ms after the user stops typing
    });
});

</script>
