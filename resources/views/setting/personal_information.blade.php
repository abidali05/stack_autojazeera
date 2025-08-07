@extends('layout.panel_layout.main')
@section('content')
    <?php
    
    use Illuminate\Support\Facades\Auth;
    $provinces = \App\Models\Province::all();
    $cities = \App\Models\City::all();
    $user = Auth::user();
    
    ?>
    <style>
        .form-control {
            background-color: transparent !important;
            color: #281F48 !important;
            border: 1px solid #281F48 !important;
            border-bottom: 2px solid #F5F5F5;
            border-radius: 0;
            padding: 0px 10px;
            line-height: 2.5 !important;
        }

        .profile-info {
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            max-width: 100%;
            /* Ensures it doesn't exceed container */
        }
    </style>
    <style>
        .custom-modal {
            border-radius: 10px;
            overflow: hidden;
        }

        .custom-modal-header {
            background-color: #FD5631;
            color: white;
            border-bottom: none;
        }

        .custom-close-btn {
            font-weight: 600;
            color: #FD5631;
            background-color: white;
            border-radius: 5px;
            border: none;
            padding: 8px 20px;
        }

        .custom-close-btn:hover {
            background-color: #FD5631;
            color: white;
        }

        .modal-content {
            background-color: #F0F3F6 !important;
        }

        .modal-body {
            background-color: #F0F3F6 !important;
        }

        .form-select {
            max-width: 100%;
            text-align: start;
            background-color: transparent !important;
            border: 1px solid #281F48 !important;
            color: #281F48 !important;
        }

        .formcontrol::placeholder {
            color: #281F48;
        }

        .formcontrol {
            color: #281F48;
        }
    </style>
    <div class="container py-3 py-lg-3">
        <div class="row">
            <div class="col-md-12 mb-3 d-flex align-items-center">

                <h2 class="sec mb-0 primary-color-custom">Profile Information</h2>
            </div>

        </div>
        <div class="row">
            <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content " style="border-radius: 10px; overflow: hidden;">
                        <!-- Modal Header -->
                        <div class="modal-header "
                            style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                            <h5 class="modal-title" id="alertModalLabel"><strong> Notification</strong></h5>
                            <button type="button" class="btn-close"
                                style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body text-center" style="background-color: #F0F3F6; color: #FD5631;">
                            <p id="modalMessage" class="mt-3"></p>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                            <button type="button" class="btn btn-light px-4 py-2 "
                                style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                                data-bs-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Left Column -->
            <div class="col-md-4">
                <div class="profile-card" style="background-color:#F0F3F6">
                    <div class="d-flex">
                        <div class="profile-image">
                            <img @if ($user->image) src="{{ asset('web/profile/' . $user->image) }}" @else src="data:image/png;base64,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" @endif
                                alt="Profile Picture">
                        </div>
                        <div class="profile-info">
                            <h5 class="only">{{ $user->name }}</h5>
                            @if ($user->number)
                                <p class="mb-0 only"><i class="bi bi-telephone-fill primary-color-custom"></i>
                                    {{ $user->number ?? 'N/A' }}
                                </p>
                            @endif
                            <p class="mb-2 only text-break d-flex"><i
                                    class="bi bi-envelope-fill primary-color-custom me-2"></i> {{ $user->email }}</p>

                        </div>
                    </div>
                    <hr>
                    <p class="mb-2 only"><strong>Name : </strong>{{ $user->name }}</p>
                    <hr>
                    <p class="mb-2 only"><strong>Email : </strong>{{ $user->email }}</p>
                    <hr>
                    @if ($user->number)
                        <p class="mb-2 only"><strong>Number : </strong>{{ $user->number }}</p>
                        <hr>
                    @endif
                    {{-- <p class="mb-2">{{ $user->gender ?? '' }}</p> --}}
                </div>
            </div>
            <!-- Center Column -->
            <div class="p-3 col-md-6 " style="border: 2px dotted #a9afb4; border-radius: 10px;">
                <form method="post" action="{{ route('update_profile') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <div class="px-1 py-2 text-center upload-box" style="height: 10%;"
                            onclick="profile_triggerFileInput()">
                            <img id="profile_preview_Image" src="" alt="Upload Photo"
                                style="max-width: 100%; display: none; border-radius: 10px;" />
                            <span id="profile_uploadText" style="color:#281F48">Click here to upload
                                marketplace profile photo <br> <small> <i> This photo
                                        will be displayed with your ad in marketplace</i> </span>
                        </div>

                        <!-- Hidden File Input -->
                        <input type="file" id="profile_fileInput" accept="image/*" name="image" style="display: none;"
                            onchange="handleprofile_FileUpload(event)">
                    </div>

                    <div class="mb-2">
                        <label for="f-name" class="form-label">Full Name</label>
                        <div class="input-groups" style="padding: 0px !important;">
                            <input type="text" class="form-control formcontrol" name="name" id="f-name"
                                placeholder="" value="{{ $user->name }}" required>
                            {{-- <button class="btn primary-color-custom" style="border-bottom: 2px solid white; border-radius: 0px;" type="button" id="edit-name">
                                                <i class="bi bi-pencil-square"></i>
                                            </button> --}}
                        </div>
                    </div>
                    <div class="mb-2 d-none">
                        <label for="gender" class="form-label">Gender</label>
                        <div class="input-groups">
                            <select class="form-select filter-style" name="gender" id="gender">
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>
                                    Male</option>
                                <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>
                                    Female</option>
                                <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>
                                    Other</option>
                            </select>


                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-groups">
                            <input type="email" class="form-control formcontrol" name="email" id="email"
                                value="{{ $user->email ?? old('email') }}" {{ $user->email ? 'disabled' : '' }} required>
                            <!-- <button class="btn primary-color-custom" style="border-bottom: 2px solid white; border-radius: 0px;" type="button" id="edit-name">
                                                                            <i class="bi bi-pencil-square"></i>
                                                                        </button> -->
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="phone" class="form-label">Phone Number</label>
                        <div class="input-groups">
                            <input type="tel" class="form-control formcontrol" name="number" id="phone-number"
                                value="{{ $user->number }}" placeholder="+92 000 0000000">

                            {{-- <button class="btn primary-color-custom" style="border-bottom: 2px solid white; border-radius: 0px;" type="button" id="edit-name">
                                                <i class="bi bi-pencil-square"></i>
                                            </button> --}}
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger p-0 m-0 mt-2">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <small class="" style="color:#FD5631" id="phone-error" style="display:none;"></small>
                    </div>


                    <div class="mb-2">
                        <label for="address" class="form-label">
                            Street Address <span style="color:#FD5631">*</span>
                        </label>
                        <input type="text" id="address" name="address"
                            class="form-control formcontrol validate-field" placeholder="Enter Address"
                            autocomplete="off" required value="{{ $user->address ?? old('address') }}" />
                        <div id="address-error" class="orange" style="display: none;">Street address is
                            required.</div>
                    </div>



                    <script
                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHTfGE9bbvleasezO-T-j1u5UVm6aTnl0&libraries=places&callback=initAutocomplete"
                        async defer></script>

                    <script>
                        let selectedPlace = false;

                        function initAutocomplete() {
                            const input = document.getElementById("address");


                            const autocomplete = new google.maps.places.Autocomplete(input, {
                                fields: ["formatted_address", "geometry"],
                            });

                            autocomplete.addListener("place_changed", () => {
                                const place = autocomplete.getPlace();
                                if (place.geometry) {
                                    selectedPlace = true;
                                    input.value = place.formatted_address;

                                } else {
                                    selectedPlace = false;
                                }
                            });

                            input.addEventListener("blur", () => {
                                if (!selectedPlace) {
                                    input.value = "";

                                }
                            });

                            input.addEventListener("input", () => {
                                selectedPlace = false;
                            });
                        }

                        window.initAutocomplete = initAutocomplete;
                    </script>


                    @if ($user->role == '1')
                        <div class="mb-2">
                            <label for="Address" class="form-label">Province</label>
                            <div class="input-groups">
                                <select name="province" id="profile_province" class="form-select"
                                    style="background-color:white !important" required>
                                    <option value="" disabled selected>Select Province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ $user->province == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>


                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="Address" class="form-label">City</label>
                            <div class="input-groups">
                                <select name="city" id="profile_city" class="form-select"
                                    style="background-color:white !important" required>

                                    <option value="" disabled selected>Select City</option>
                                    @foreach ($cities as $city)
                                        @if ($user->city == $city->id)
                                            <option value="{{ $city->id }}" selected>
                                                {{ $city->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>


                            </div>
                        </div>
                    @endif
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="px-5 mt-3 rounded btn custom-btn-nav">Save
                            changes</button>
                        {{-- <button type="button" class="px-5 mt-3 ms-3 rounded btn custom-btn-nav"
                                            data-bs-dismiss="modal">Close</button> --}}
                    </div>
                </form>

            </div>

            <!-- Right Column -->

            <div class="col-md-2">

                <script>
                    // Function to trigger the hidden file input
                    function profile_triggerFileInput() {
                        document.getElementById("profile_fileInput").click();
                    }

                    // Function to handle the file upload
                    function handleprofile_FileUpload(event) {
                        const file = event.target.files[0]; // Get the uploaded file
                        const maxSize = 2 * 1024 * 1024; // 2MB limit
                        const allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/webp"];

                        if (file) {

                            if (!allowedTypes.includes(file.type)) {
                                alert("Invalid file type! Only JPG, JPEG, PNG, and WEBP files are allowed.");
                                event.target.value = ""; // Reset input field
                                return;
                            }
                            if (file.size > maxSize) {
                                alert("File size exceeds 2MB! Please upload a smaller file.");
                                event.target.value = ""; // Reset input field
                                return;
                            }
                            const reader = new FileReader();

                            // Load the file and set it as the image preview
                            reader.onload = function(e) {
                                const profile_preview_Image = document.getElementById("profile_preview_Image");
                                const profile_uploadText = document.getElementById("profile_uploadText");

                                profile_preview_Image.src = e.target.result; // Set image source
                                profile_preview_Image.style.display = "block"; // Show the preview image
                                profile_uploadText.style.display = "none"; // Hide the text
                            };

                            reader.readAsDataURL(file); // Read file as data URL
                        }
                    }


                    $('.seller_type').change(function() {
                        if ($(this).val() == 'car_dealer') {
                            $('#dealership-name').parent().parent().removeClass('d-none');
                            $('#dealership-name').attr('required', true);

                        } else {
                            $('#dealership-name').parent().parent().addClass('d-none');
                            $('#dealership-name').attr('required', false);
                        }
                    });

                    document.getElementById('profile_province').addEventListener('change', function() {
                        var provinceId = this.value;

                        var citySelect = document.getElementById('profile_city');

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
            </div>
        </div>
    </div>
    <!-- <script>
        function enforcePhoneFormat(input) {
            if (!input.value.startsWith("+92")) {
                input.value = "+92";
            }
        }
    </script> -->

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
    <script>
        $(document).ready(function() {
            let message = "";
            let bgColor = "";

            @if (session('success'))
                message = "{{ session('success') }}";
                bgColor = "#28a745"; // Green
            @elseif (session('register_success'))
                message = "{{ session('register_success') }}";
                bgColor = "#28a745"; // Green
            @elseif (session('register_error'))
                message = "{{ session('register_error') }}";
                bgColor = "#fd7e14"; // Orange
            @elseif (session('error'))
                message = "{{ session('error') }}";
                bgColor = "#dc3545"; // Red
            @endif

            if (message) {
                $("#modalMessage").text(message);
                document.documentElement.style.setProperty("--modal-bg-color", bgColor);
                $("#alertModal").modal("show");
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById("latitude").value = position.coords.latitude;
                    document.getElementById("longitude").value = position.coords.longitude;
                    getAddressFromCoordinates(position.coords.latitude, position.coords.longitude, function(
                        address) {
                        if (address) {
                            document.getElementById("address").value = address;
                            // alert(address);
                        }
                    })
                    // alert("Latitude: " + position.coords.latitude + "\nLongitude: " + position.coords.longitude);
                }, function(error) {
                    console.warn("Geolocation failed or was denied:", error.message);
                });
            } else {
                console.warn("Geolocation is not supported by this browser.");
            }
        });
    </script>






    <script>
        async function getAddressFromCoordinates(lat, lng, callback) {
            try {
                const response = await fetch(
                    `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=AIzaSyBHTfGE9bbvleasezO-T-j1u5UVm6aTnl0`
                );
                const data = await response.json();

                if (data.status === "OK" && data.results.length > 0) {
                    const address = data.results[0].formatted_address;
                    if (callback) callback(address);
                } else {
                    console.warn("No address found.");
                    if (callback) callback(null);
                }
            } catch (err) {
                console.error("Geocoding error:", err.message);
                if (callback) callback(null);
            }
        }
    </script>



@endsection
