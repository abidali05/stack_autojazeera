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
<div class="modal fade" id="superadmin_add_userModal" tabindex="-1" aria-labelledby="addDealerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
   <div class="border-0 modal-header"
                                                style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
										
												 <h5 class="modal-title" id="newsletterresponseLabel"> <strong> 	Add New User	</strong></h5>
                                                <button type="button" class="btn-close"
                                                    style="background-color: #D9D9D9 !important; color: #FD5631;"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
            <form id="superadmin_add_userForm" method="post" action="{{ route('superadmin.user.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-5 "  style="background-color:#F0F3F6 !important;">
                    <div class="row mb-4">
                        <div class="col-6">
             
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
                                <input type="file" id="profileimggg" accept="image/*" style="display: none;"
                                    name="image">
                                <label id="dropzoneLabelll" for="profileimggg"
                                    style="   color: #888;
    cursor: pointer;
    font-size: 14px;
    padding: 10px;"
                                    class="dropzone-label">Drop an image here or click to upload</label>
                                <img id="previewImageee" alt="Preview"
                                    style="display: none;   position: absolute;
                                        max-width:150px;
                                        max-height: 150px;
                                        object-fit: contain;">
                                <div id="buttonsss" class="action-buttons"
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
                   @php
       $dealershipNames = \App\Models\User::where('status','active')->where('role','1')->whereNotNull('dealershipName')->pluck('dealershipName');
    @endphp
                    <input type="hidden" name="role" id="role_id">
                    <div class="row mb-3 mt-3" id="dealershipNameRow">
                        <label for="dealershipName" class="col-sm-4 col-form-label">Dealership Name*</label>
                        <div class="col-sm-8">
							<select style="color:#281F48;background-color:white;border:1px solid #281F48;text-align:center" name="dealershipName" id="dealershipName" class=" form-select" required>
								<option value="">Select Dealership Name </option>
								@foreach($dealershipNames as $dealershipName)
								<option value="{{$dealershipName}}">{{$dealershipName}}</option>
								@endforeach
							</select>
                           
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
                            <input type="tel" class="form-control px-0 ps-1" id="phone" placeholder="Enter phone"
                                value="{{ '+92' }}" disabled>

                        </div>
                        <div class="col-sm-7">
                            <input type="string" class="form-control" id="phone" name="number"
                                placeholder="Enter phone" maxlength="10" pattern="\d{10}" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10);" required>
                            @error('number')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-4 col-form-label">Email*</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Enter email" required>
                            @error('email')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
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
                    <div class="row mb-3 d-none">
                        <label for="province" class="col-sm-4 col-form-label">Province*</label>
                        <div class="col-sm-8">
                            <select  class="form-select" id="province11" name="province">
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
                    <div class="row mb-3 d-none">
                        <label for="city" class="col-sm-4 col-form-label">City*</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="city11" name="city">
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
                            <select class="form-select" style="color:#281F48;background-color:white;border:1px solid #281F48;text-align:center" id="addStatus" name="status" required>
                                <option value="" selected>Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            @error('status')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 d-none">
                        <label for="addStatus" class="col-sm-4 col-form-label">Enter Address</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="address" name="address"></textarea>
                            @error('address')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 d-none">
                        <label for="website" class="col-sm-4 col-form-label">Website (if any)</label>
                        <div class="col-sm-8">
                            <input type="url" class="form-control" id="website" name="website"
                                placeholder="Enter website">
                            @error('website')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-check mb-2 d-none">
                        <input class="form-check-input" type="checkbox" name="allow_company" id="marketplace">
                        <label class="form-check-label" for="marketplace">
                            Enable for Marketplace - Allow your company to access and sell products in our online
                            marketplace.
                        </label>
                    </div>
                    <div class="form-check mb-2 d-none">
                        <input class="form-check-input" type="checkbox" name="bulk_import" id="inventory">
                        <label class="form-check-label" for="inventory">
                            Enable for Inventory Bulk Import - Streamline your operations by importing inventory
                            data in bulk.
                        </label>
                    </div>
                    <div class="form-check mb-2 d-none">
                        <input class="form-check-input" type="checkbox" name="user_management" id="userManagement">
                        <label class="form-check-label" for="userManagement">
                            Enable for User Management - Manage user roles and permissions within your organization
                            effectively.
                        </label>
                    </div>

                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn  custom-btn-nav rounded">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    document.getElementById('province11').addEventListener('change', function() {
        var provinceId = this.value;

        var citySelect = document.getElementById('city11');

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
    const fileInputtt = document.getElementById('profileimggg');
    const previewImageee = document.getElementById('previewImageee');
    const dropzoneLabelll = document.getElementById('dropzoneLabelll');
    const buttonsss = document.getElementById('buttonsss');

    // Trigger file input on click
    function triggerFileInput() {
        fileInputtt.click();
    }

    // Handle file selection and image preview
    fileInputtt.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImageee.src = e.target.result;
                previewImageee.style.display = 'block';
                dropzoneLabelll.style.display = 'none'; // Hide label
                buttonsss.style.display = 'flex'; // Show action buttons
            };
            reader.readAsDataURL(file);
        }

        // Clear the input value to allow re-selection of the same file
        
    });

    // Delete the image
    function deleteImage() {
        previewImageee.src = '';
        previewImageee.style.display = 'none';
        dropzoneLabelll.style.display = 'block'; // Show label again
        buttonsss.style.display = 'none'; // Hide action buttons
    }

    // Show buttons on hover
    function showButtons() {
        if (previewImageee.style.display === 'block') {
            buttonsss.style.display = 'flex';
        }
    }

    // Hide buttons on mouse leave
    function hideButtons() {
        if (previewImageee.style.display === 'block') {
            buttonsss.style.display = 'none';
        }
    }
</script>
