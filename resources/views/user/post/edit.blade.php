@extends('layout.panel_layout.main')
@section('content')
   <style>
   .form-control::placeholder {
  color: #281F48;
            opacity: 1;
            /* Ensures it's not too light */
}

	   .text-muted {
    --bs-text-opacity: 1;
            font-size: 16px;
    color: #281F48 !important;
}

	   .page-link {
    position: relative;
    display: block;
    padding: var(--bs-pagination-padding-y) var(--bs-pagination-padding-x);
    font-size: var(--bs-pagination-font-size);
    color: var(--bs-pagination-color);
    text-decoration: none;

    border: var(--bs-pagination-border-width) solid var(--bs-pagination-border-color);
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    color: white;
    background: #FD5631;
    border: none !important;
}

	        .search-container {
            display: flex;
            align-items: center;
            position: relative;
        
        }

        .search-container input {
            width: 100%;
            border: none;
            border-bottom: 1px solid #ccc;
            outline: none;
            font-size: 16px;
            padding: 5px 10px;
            background: none;
            color: #fff;
            /* Adjust for dark background */
        }

        .search-container button {
            position: absolute;
            right: 0px;
            background: none;
            border: none;
            cursor: pointer;
            color: #888;
            font-size: 12px;
        }

        .search-container input::placeholder {
            color: white;
            font-weight: 600;
            /* Adjust placeholder color */
        }

        .search-container input:focus {
            border-bottom-color: #fff;
            /* Change border color on focus */
        }

.form-check-input:checked {
    background-color: #281F48 !important;
    border-color: #281F48 !important;
}

		   .form-check-input {
    --bs-form-check-bg: var(--bs-body-bg);
    flex-shrink: 0;
    width: 1em;
    height: 1em;
    margin-top: .25em;
    vertical-align: top;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: #282435;
    background-image: var(--bs-form-check-bg-image);
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    border: var(--bs-border-width) solid var(--bs-border-color);
    -webkit-print-color-adjust: exact;
    color-adjust: exact;
    print-color-adjust: exact;
}

.form-select {
    max-width: 100%;
    text-align: start;
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

    <!-- Add jQuery Validation Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

    <script>
        $(document).ready(function() {
            // Add validation styles
            $("<style>")
                .prop("type", "text/css")
                .html(`
                    .error-message {
                        color: #FD5631;
                        font-size: 14px;
                        margin-top: 5px;
                        display: block;
                    }
                    .error {
                        border-color: #FD5631 !important;
                    }
                    #features-error {
                        color: #FD5631;
                        font-size: 14px;
                        margin-top: 5px;
                        margin-bottom: 15px;
                        display: none;
                    }
                `)
                .appendTo("head");
                
            // Add features error message element
            $('<div id="features-error">Please select at least one feature.</div>')
                .insertAfter('.step-header:contains("Features")');
                
            // Initialize jQuery Validation
            $("#adForm").validate({
                errorClass: "error-message",
                errorElement: "span",
                highlight: function(element) {
                    $(element).addClass("error");
                },
                unhighlight: function(element) {
                    $(element).removeClass("error");
                },
                rules: {
                    condition: {
                        required: true
                    },
                    assembly: {
                        required: true
                    },
                    price: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    makecompany: {
                        required: true
                    },
                    model: {
                        required: true
                    },
                    year: {
                        required: true
                    },
                    mileage: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    bodyType: {
                        required: true
                    },
                    doorcount: {
                        required: true
                    },
                    fuelType: {
                        required: true
                    },
                    seatingCapacity: {
                        required: true
                    },
                    engineCapacity: {
                        required: true
                    },
                    transmission: {
                        required: true
                    },
                    driveType: {
                        required: true
                    },
                    exterior_color: {
                        required: true
                    },
                    dealer_comment: {
                        required: true,
                        minlength: 10,
                        maxlength: 3000
                    },
                    province: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    street_address: {
                        required: true
                    },
                    firstName: {
                        required: true,
                        minlength: 2
                    },
                    secondName: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    number: {
                        required: true,
                        pattern: /^\+92 3\d{2} \d{7}$/
                    }
                },
                messages: {
                    condition: {
                        required: "Please select vehicle condition"
                    },
                    assembly: {
                        required: "Please select assembly type"
                    },
                    price: {
                        required: "Please enter price",
                        number: "Please enter a valid number",
                        min: "Price cannot be negative"
                    },
                    makecompany: {
                        required: "Please select make"
                    },
                    model: {
                        required: "Please select model"
                    },
                    year: {
                        required: "Please select year"
                    },
                    mileage: {
                        required: "Please enter mileage",
                        number: "Please enter a valid number",
                        min: "Mileage cannot be negative"
                    },
                    bodyType: {
                        required: "Please select body type"
                    },
                    doorcount: {
                        required: "Please select door count"
                    },
                    fuelType: {
                        required: "Please select fuel type"
                    },
                    seatingCapacity: {
                        required: "Please select seating capacity"
                    },
                    engineCapacity: {
                        required: "Please select engine capacity"
                    },
                    transmission: {
                        required: "Please select transmission"
                    },
                    driveType: {
                        required: "Please select drive type"
                    },
                    exterior_color: {
                        required: "Please select exterior color"
                    },
                    dealer_comment: {
                        required: "Please enter dealer comments",
                        minlength: "Comments must be at least 10 characters long",
                        maxlength: "Comments cannot exceed 3000 characters"
                    },
                    province: {
                        required: "Please select province"
                    },
                    city: {
                        required: "Please select city"
                    },
                    street_address: {
                        required: "Please enter street address"
                    },
                    firstName: {
                        required: "Please enter first name",
                        minlength: "First name must be at least 2 characters long"
                    },
                    secondName: {
                        required: "Please enter second name",
                        minlength: "Second name must be at least 2 characters long"
                    },
                    email: {
                        required: "Please enter email address",
                        email: "Please enter a valid email address"
                    },
                    number: {
                        required: "Please enter phone number",
                        pattern: "Enter phone number in format +92 3XX XXXXXXX"
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    // Check if at least one feature is selected
                    if ($('.feature_checkbox:checked').length === 0) {
                        $('#features-error').show();
                        $('html, body').animate({
                            scrollTop: $('#features-error').offset().top - 100
                        }, 500);
                        return false;
                    } else {
                        $('#features-error').hide();
                    }
                    
                    // Check image count before submitting
                    const fileInput = document.getElementById('fileUpload');
                    let existingImages = parseInt(document.getElementById('existingImageCount').value) || 0;
                    let newImages = fileInput.files.length;
                    let totalImages = existingImages + newImages;

                    if (totalImages < 5) {
                        let modal = new bootstrap.Modal(document.getElementById('imageValidationModal'));
                        document.getElementById('modalMessage').textContent = 
                            `You have ${totalImages} images. Please ensure you have at least 5 images.`;
                        modal.show();
                        return false;
                    }
                    
                    if (totalImages > 30) {
                        let modal = new bootstrap.Modal(document.getElementById('imageValidationModal'));
                        document.getElementById('modalMessage').textContent = 
                            `You have ${totalImages} images. Maximum allowed is 30 images.`;
                        modal.show();
                        return false;
                    }

                    form.submit();
                }
            });

            // Custom validation for phone number format
            $.validator.addMethod("pattern", function(value, element, param) {
                return this.optional(element) || param.test(value);
            }, "Please enter a valid phone number in format +92 3XX XXXXXXX");
            
            // Update submitform function to use jQuery validation
            window.submitform = function(event) {
                event.preventDefault(); // Prevent default form submission
                
                // First, check if the form is valid according to the standard validation rules
                var isFormValid = $("#adForm").valid();
                
                // Then check if at least one feature is selected
                var featuresSelected = $('.feature_checkbox:checked').length > 0;
                
                if (!featuresSelected) {
                    $('#features-error').show();
                } else {
                    $('#features-error').hide();
                }
                
                // If either validation fails, prevent form submission
                if (!isFormValid || !featuresSelected) {
                    // First scroll to any standard validation errors
                    if (!isFormValid) {
                        var firstError = $(".error-message:visible").first();
                        if (firstError.length) {
                            $('html, body').animate({
                                scrollTop: firstError.offset().top - 100
                            }, 500);
                        }
                    }
                    // If no standard errors or features error is higher in the page, scroll to features error
                    else if (!featuresSelected) {
                        $('html, body').animate({
                            scrollTop: $('#features-error').offset().top - 100
                        }, 500);
                    }
                    return false;
                }
                
                // If all validations pass, check image count
                const fileInput = document.getElementById('fileUpload');
                let existingImages = parseInt(document.getElementById('existingImageCount').value) || 0;
                let newImages = fileInput.files.length;
                let totalImages = existingImages + newImages;
                
                if (totalImages < 5 || totalImages > 30) {
                    let modal = new bootstrap.Modal(document.getElementById('imageValidationModal'));
                    document.getElementById('modalMessage').textContent = 
                        `You have ${totalImages} images. Please ensure you have between 5 and 30 images.`;
                    modal.show();
                    return false;
                }
                
                // If all validations pass, submit the form
                document.getElementById('form_submit_btn').click();
            };
            
            // Add feature checkbox change handler to hide error when any checkbox is selected
            $('.feature_checkbox').on('change', function() {
                if ($('.feature_checkbox:checked').length > 0) {
                    $('#features-error').hide();
                }
            });
        });
    </script>

    @if (session('imgdelete'))
        <div class="modal fade" id="imgdelete_successmodal" tabindex="-1" aria-labelledby="imgdelete_successmodalLabel"
            aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
            <!-- Modal Header -->
            <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                <h5 class="modal-title" id="dealer_register_successLabel"></h5>
                        <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;"
                            data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
                    <div class="modal-body text-center " style="background-color: #F0F3F6; color: #FD5631;">
               
                
                <h6 class="" style="line-height: 1.6;">
                            {{ session('imgdelete') }}
                    <br><br>
                    
                </h6>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                        <a href="#" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"
                            data-bs-dismiss="modal">close</a>
                
            </div>
        </div>
    </div>
</div>
		 <script>
        // Show the modal when the page loads
            document.addEventListener('DOMContentLoaded', function() {
            const myModal = new bootstrap.Modal(document.getElementById('imgdelete_successmodal'));
            myModal.show();
            @php
                session()->forget('imgdelete');
            @endphp
        });
    </script>
@endif
	   <style>
		   .orange {
            color: #FD5631 !important;
		   }
		   </style>
    <!-- back header start -->
    <div class="container mt-5">
        <div class="row align-items-center mb-4">
      
            <div class="col-auto p-0">
                <h2 class="sec mb-0 ms-2 primary-color-custom">Edit Ad</h2>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="row pb-md-5 pt-md-3">
            @if ($post->status == '2')
				<div class="mb-3 p-3 rounded col-lg-8" style="background-color:#F0F3F6;">
				<div class="mb-3 ">
                            <label for="adTitle" class="form-label" style="color: red !important;">Rejection Reason</label>
                        <p class="p-2 rounded" style =" background-color:white;   line-height: 1 !important; color:red !important" > {{ $post->rejected_reason }}</p>
                           
                            
                        </div>
				</div>
				@endif
            <div class="col-lg-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="adForm" method="post" action="{{ route('ads.update', $post->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Step 2: Basic Info -->
					<input type="hidden" id="existingImageCount" value="{{ count($post->document ?? []) }}">
                    <input type="hidden" value="{{ Auth::user()->id }}" name="dealer">
                    <input type="hidden" name="latitude" id="latitude" value="{{ $post->latitude ?? '' }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ $post->longitude ?? '' }}">
                    <div class="mb-3 p-3 rounded" style="    border: 1px solid #0000001F;">
						<div style="display:flex; justify-content:space-between">
                        <h4 class="step-header">Basic Info</h4>
						 @if($post->status == 0) <a   ><span class="badge text-bg-danger">Inactive</span></a> @elseif($post->status == '2')<a href="#"  ><span class="badge text-bg-danger" >Rejected</span></a>@else<a > <span class="badge text-bg-success">Active</span></a> @endif
							
						</div>
                        <div class="mb-3 d-none">
                            <label for="adTitle" class="form-label">Title <span style="color:#FD5631">*</span></label>
                            <input type="text" class="form-control adTitle" name="title" id="adTitle" maxlength="48"
                                placeholder="Enter Ad title e.g. Mercedes-Benz"
                                value="{{ $post->title ?? 'dummy title' }}">
                            <div class="char-counter" id="charCounter">48 characters left</div>
                            @error('title')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-6">
                                <label for="vehicleCondition" class="form-label" style="color:white">Vehicle Condition <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select class="form-select " id="vehicleCondition" name="condition" required>
                                    <option value="">Any</option>
                                    <option value="new"
                                        {{ isset($post) && $post->condition == 'new' ? 'selected' : '' }}>New
                                    </option>
                                    <option value="used"
                                        {{ isset($post) && $post->condition == 'used' ? 'selected' : '' }}>
                                        Used</option>
                                </select>
                                @error('condition')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="assembly" class="form-label" style="color:white">Assembly <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select class="form-select " name="assembly" id="assembly"required>
                                    <option value="">Any</option>
                                  
                                    <option value="local"
                                        {{ isset($post) && $post->assembly == 'local' ? 'selected' : '' }}>
                                        Local</option>
                                    <option value="imported"
                                        {{ isset($post) && $post->assembly == 'imported' ? 'selected' : '' }}>Imported
                                    </option>
                                </select>
                                @error('assembly')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                       {{-- <div class="mb-3">
                            <label class="form-label" style="color:white">What type of seller are you?</label>
                            <div class="form-check">
                                <input class="form-check-input registeredDealer" type="radio" name="dealerType"
                                    id="registeredDealer" value="registered"
                                    {{ isset($post) && $post->company_conection == 'registered' ? 'checked' : '' }}
                                    checked>
                                <label class="form-check-label" for="registeredDealer">I am a registered
                                    dealer</label>

                            </div>
                            <div class="form-check">
                                <input class="form-check-input privateDealer" type="radio" name="dealerType"
                                    id="privateDealer" value="private"
                                    {{ isset($post) && $post->company_conection == 'private' ? 'checked' : '' }}>
                                <label class="form-check-label" for="privateDealer">I am a private
                                    dealer</label>
                            </div>
                            @error('dealerType')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div> --}}
                    </div>

                    <!-- Step 3: Currency & Price -->
                    <div class="mb-3 p-3 rounded" style="    border: 1px solid #0000001F;">
                        <h3 class="step-header">Price</h3>
                        <div class="row align-items-center mb-3">
                            <div class="col-4">
                                <label for="currencySelect" class="form-label">Currency</label>
                                <input type="hidden" name="currency" id="currencySelect" value="PKR">
                                <p class="mb-0">PKR</p>
                                <!-- <select class="form-select" id="currencySelect" disabled>
                                                                                            <option value="PKR" selected>PKR</option>
                                                                                            <option value="USD">USD</option>
                                                                                            <option value="EUR">EUR</option>
                                                                                        </select> -->
                                @error('currency')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-8">
                                <label for="priceInput" class="form-label" style="color:white">Price <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <input type="number" class="form-control" name="price" id="priceInput"
                                    placeholder="Enter price"
                                    style="color:#281F48 !important;background-color:white !important" min="0"
                                    value="{{ $post->price ?? '' }}" required>
                                @error('price')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                     {{--   <div class="form-check mb-3">
                            <input class="form-check-input" name="negotiatedPrice" type="checkbox" id="negotiatedPrice"
                                {{ isset($post) && $post->negotiatedPrice == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="negotiatedPrice">Negotiated Price</label>
                            @error('negotiatedPrice')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div> --}}
                    </div>
                    <!-- Step 4: Vehicle Information -->
                    <div class="mb-3 p-3 rounded" style="    border: 1px solid #0000001F;">
                        <h4 class="step-header">Vehicle information</h4>
                        <input type="hidden" name="step4" value="step4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="make" class="form-label" style="color:white">Make <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select class="form-select " name="makecompany" id="makecompanydata"required>
                                    <option value="">Any</option>
                                  
                                    @foreach ($makes as $make)
                                        <option value="{{ $make->id }}"
                                            {{ isset($post) && $post->make == $make->id ? 'selected' : '' }}>
                                            {{ $make->name }}</option>
                                    @endforeach
                                </select>
                                @error('makecompany')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="model" class="form-label" style="color:white">Model <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select class="form-select " name="model" id="model"required>
                                    <option value="">Any</option>

                                    <option value="{{ $post->model ?? '' }}" selected>{{ $post->modelname ?? 'Any' }}
                                    </option>

                                </select>
                                @error('model')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="year" class="form-label" style="color:white">Year <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select class="form-select" name="year" id="years"required>
                                    <option value="">Any</option>
                             
                                    @for ($year = now()->year; $year >= 1960; $year--)
                                        <option value="{{ $year }}"
                                            {{ isset($post) && $post->year == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                                @error('year')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="mileage" class="form-label" style="color:white">Mileage (Km) <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <input type="number" name="mileage" value="{{ $post->milleage ?? '' }}"
                                    class="form-control " id="mileage" placeholder="e.g., 25000"
                                    style="color:#281F48 !important;background-color:white !important"
                                    min="0"required>
                                @error('mileage')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="bodyType" class="form-label" style="color:white">Body Type <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select class="form-select " name="bodyType" id="bodyType"required>
                                    <option value="" disabled selected>Any</option>
                                    @foreach ($bodytypes as $bodytype)
                                        <option value="{{ $bodytype->id }}"
                                            {{ isset($post) && $post->body_type == $bodytype->id ? 'selected' : '' }}>
                                            {{ $bodytype->name }}</option>
                                    @endforeach
                                </select>
                                @error('bodyType')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="doorCount" class="form-label" style="color:white">Door Count <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select class="form-select " name="doorcount" id="doorCount"required>
                                    <option value="">Any</option>
                                  
                                    <option value="2" {{ isset($post) && $post->doors == '2' ? 'selected' : '' }}>2
                                    </option>
                                    <option value="4" {{ isset($post) && $post->doors == '4' ? 'selected' : '' }}>4
                                    </option>
                                    <option value="5+" {{ isset($post) && $post->doors == '5+' ? 'selected' : '' }}>5+
                                    </option>
                                </select>
                                @error('doorcount')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fuelType" class="form-label" style="color:white">Fuel Type <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select class="form-select " name="fuelType" id="fuelType"required>
                                    <option value="">Any</option>
                                   
                                    <option value="Gasoline"
                                        {{ isset($post) && $post->fuel == 'Gasoline' ? 'selected' : '' }}>Gasoline</option>
                                    <option value="Diesel"
                                        {{ isset($post) && $post->fuel == 'Diesel' ? 'selected' : '' }}>
                                        Diesel</option>
                                    <option value="Electric"
                                        {{ isset($post) && $post->fuel == 'Electric' ? 'selected' : '' }}>Electric</option>
									<option value="Petrol"
                                        {{ isset($post) && $post->fuel == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                                    <option value="LPG" {{ isset($post) && $post->fuel == 'LPG' ? 'selected' : '' }}>
                                        LPG</option>
                                    <option value="CNG" {{ isset($post) && $post->fuel == 'CNG' ? 'selected' : '' }}>
                                        CNG</option>
											<option value="Hybrid"
                                        {{ isset($post) && $post->fuel == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                                @error('fuelType')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="seatingCapacity" class="form-label" style="color:white">Seating Capacity
                                    <span style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select class="form-select " name="seatingCapacity" id="seatingCapacity"required>
                                    <option value="">Any</option>
                              
                                    <option value="2"
                                        {{ isset($post) && $post->seating_capacity == '2' ? 'selected' : '' }}>2</option>
                                    <option value="4"
                                        {{ isset($post) && $post->seating_capacity == '4' ? 'selected' : '' }}>4</option>
                                    <option value="5+"
                                        {{ isset($post) && $post->seating_capacity == '5+' ? 'selected' : '' }}>5+</option>
                                </select>
                                @error('seatingCapacity')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="engineCapacity" class="form-label" style="color:white">Engine Capacity <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select class="form-select " name="engineCapacity" id="engineCapacity"required>
                                    <option value="">Any</option>
                               
                                    <option value="1.6L"
                                        {{ isset($post) && $post->engine_capacity == '1.6L' ? 'selected' : '' }}>1.6L
                                    </option>
                                    <option value="2.0L"
                                        {{ isset($post) && $post->engine_capacity == '2.0L' ? 'selected' : '' }}>2.0L
                                    </option>
                                    <option value="3.0L+"
                                        {{ isset($post) && $post->engine_capacity == '3.0L+' ? 'selected' : '' }}>3.0L+
                                    </option>
                                </select>
                                @error('engineCapacity')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="transmission" class="form-label" style="color:white">Transmission <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select class="form-select " name="transmission" id="transmission"required>
                                    <option value="">Any</option>
                                
                                    <option value="Automatic"
                                        {{ isset($post) && $post->transmission == 'Automatic' ? 'selected' : '' }}>
                                        Automatic
                                    </option>
                                    <option value="Manual"
                                        {{ isset($post) && $post->transmission == 'Manual' ? 'selected' : '' }}>Manual
                                    </option>
                                </select>
                                @error('transmission')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="driveType" class="form-label" style="color:white">Drive Type <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select class="form-select " name="driveType" id="driveType"required>
                                
                                    <option value="Front Wheel Drive"
                                        {{ isset($post) && $post->drive_type == 'Front Wheel Drive' ? 'selected' : '' }}>
                                        Front
                                        Wheel Drive</option>
                                    <option value="Rear Wheel Drive"
                                        {{ isset($post) && $post->drive_type == 'Rear Wheel Drive' ? 'selected' : '' }}>
                                        Rear
                                        Wheel Drive</option>
                                    <option value="All Wheel Drive"
                                        {{ isset($post) && $post->drive_type == 'All Wheel Drive' ? 'selected' : '' }}>All
                                        Wheel Drive</option>
                                </select>
                                @error('driveType')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="color" class="form-label" style="color:white">Exterior Color <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select class="form-select " name="exterior_color" id="exterior_color"required>
                                    <option value="">Any</option>

                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}"
                                            {{ isset($post) && $post->exterior_color == $color->id ? 'selected' : '' }}>
                                            {{ $color->name }}</option>
                                    @endforeach
                                </select>
                                @error('exterior_color')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (Auth::user()->package != 'prod_RTgB3KyZygKo2I')
                                <div class="form-check mb-3 m-2">
                                    <input class="form-check-input"
                                        style="
                                            appearance: none; 
                                            width: 20px; 
                                            height: 20px; 
                                            border: 2px solid #999; 
                                            background-color: transparent; 
                                            border-radius: 4px; 
                                            position: relative; 
                                            cursor: pointer;
                                        "
                                        onclick="this.style.backgroundColor = this.checked ? '#FD5631' : 'transparent';"
                                        name="feature_ad" type="checkbox" id="feature_ad"
                                        {{ isset($post) && $post->feature_ad == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="feature_ad">Features Ad <span
                                            style="color:#FD5631">*</span></label>

                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="comments" class="form-label" style="color:white">Dealer Comments <span
                                    style="color:#FD5631" class="m-0 fs-5">*</span></label>
                            <textarea class="form-control  "
                                style="color:#281F48 !important;background-color:white !important;    line-height: 1 !important;"
                                name="dealer_comment" id="comments" rows="4" maxlength="3000"
                                placeholder="Describe your vehicle. These comments will be displayed on your ad." required>{{ $post->dealer_comment ?? '' }}</textarea>
                            <!-- <div class="char-counter" id="commentCharCount">3000 characters left</div> -->
                            @error('dealer_comment')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Step 5: Vehicle Features -->

                    <div class="mb-3 p-3 rounded" style="    border: 1px solid #0000001F;">
                        <h4 class="step-header">Features<span class="text-danger" class="m-0 fs-5">*</span></h4>

                        <div class="feature-section">
                            <h5>Exterior</h5>

                            <!-- Display existing features for the post -->


                            <div class=" row d-flex flex-wrap">
                                <!-- Iterate over dynamic features -->
                                @foreach ($features->where('feature', 'Exterior') as $feature)
								<div class="col-md-4 col-6">
								   <div class="form-check me-3">
                                            <input type="checkbox"
                                                style="
            appearance: none; 
            width: 20px; 
            height: 20px; 
            border: 2px solid #281F48; 
            background-color: white; 
            border-radius: 4px; 
            position: relative; 
            cursor: pointer;
        "
                                                onclick="this.style.backgroundColor = this.checked ? '#281F48' : 'white';"
                                                name="Features[Exterior][{{ $feature->Sub_feature }}]"
                                                class="form-check-input feature_checkbox"
                                                id="feature_{{ $feature->id }}"
                                                {{ isset($post->feature) && $post->feature->where('feature', 'Exterior')->pluck('feature_name')->contains($feature->Sub_feature) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="feature_{{ $feature->id }}">{{ $feature->Sub_feature }}</label>
                                    </div>
								</div>
                                @endforeach
                            </div>
                            @error('Features["Exterior"]')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="feature-section mt-4">
                            <h5>Interior</h5>

                            <div class=" row d-flex flex-wrap">

                                @foreach ($features->where('feature', 'Interior') as $feature)
								<div class="col-md-4 col-6">
                                    <div class="form-check me-3">
                                            <input type="checkbox"
                                                style="
            appearance: none; 
            width: 20px; 
            height: 20px; 
            border: 2px solid #281F48; 
            background-color: white; 
            border-radius: 4px; 
            position: relative; 
            cursor: pointer;
        "
                                                onclick="this.style.backgroundColor = this.checked ? '#281F48' : 'white';"
                                                name="Features[Interior][{{ $feature->Sub_feature }}]"
                                                class="form-check-input feature_checkbox"
                                                id="feature_{{ $feature->id }}"
                                                {{ isset($post->feature) && $post->feature->where('feature', 'Interior')->pluck('feature_name')->contains($feature->Sub_feature) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="feature_{{ $feature->id }}">{{ $feature->Sub_feature }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- <a href="#" class="text-primary" onclick="showMore('interiorFeatures')">Show more</a> -->

                            @error('Features["Interior"]')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="feature-section mt-4">
                            <h5>Safety</h5>

                            <div class="row d-flex flex-wrap">

                                @foreach ($features->where('feature', 'Safety') as $feature)
																<div class="col-md-4 col-6">
                                    <div class="form-check me-3">
                                            <input type="checkbox"
                                                style="
            appearance: none; 
            width: 20px; 
            height: 20px; 
            border: 2px solid #281F48; 
            background-color: white; 
            border-radius: 4px; 
            position: relative; 
            cursor: pointer;
        "
                                                onclick="this.style.backgroundColor = this.checked ? '#281F48' : 'white';"
                                                name="Features[Safety][{{ $feature->Sub_feature }}]"
                                                class="form-check-input feature_checkbox"
                                                id="feature_{{ $feature->id }}"
                                                {{ isset($post->feature) && $post->feature->where('feature', 'Safety')->pluck('feature_name')->contains($feature->Sub_feature) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="feature_{{ $feature->id }}">{{ $feature->Sub_feature }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- <a href="#" class="text-primary" onclick="showMore('safetyFeatures')">Show more</a> -->

                            <!-- Add more safety features as needed -->
                        </div>
                        @error('Features["Safety"]')
                            <div class="alert ">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Step 6: Upload Photos / Videos -->
                    <div class="mb-3 p-3 rounded" style="    border: 1px solid #0000001F;">
                        <h4 class="step-header">Photos / Video Upload</h4>

                        <p class="rounded p-3" style="background-color:#281F48; color: white; ">
                            You can upload a minimum of <strong>5</strong> and a maximum of<strong> 30 </strong>photos. The
                            maximum file size per photo is<strong> 8 MB</strong>. Allowed formats: <strong>JPEG, JPG,
                                PNG</strong>.
                        </p>

                        <div class="upload-area border border-dashed rounded p-4 text-center" ondrop="handleDrop(event)"
                            ondragover="event.preventDefault()" ondragleave="event.preventDefault()">
                            <i class="bi bi-cloud-arrow-up fs-1 primary-color-custom mb-3"></i>
                            <p class="mb-2">Maximum 30 files (images) </p>
                            <input type="file" id="fileUpload" class="d-none" name="filedata[]" multiple
                                accept=".jpg, .jpeg, .png, .mp4, .mov" onchange="handleImgUpload(this.files)">

                            <a class="btn custom-btn-nav rounded-2 mt-3"
                                onclick="document.getElementById('fileUpload').click();">
                                Select Files
                            </a>
                        </div>
                        @error('filedata')
                            <div class="alert ">{{ $message }}</div>
                        @enderror
                        @if (isset($post->document))
                            <div id="uploadedImgsContainer" class="uploaded_imgs mt-2">
                               

                                @foreach ($post->document as $document)
                                    <div class="preview-item"
                                        style="display: inline-block; position: relative; margin: 10px;">
                                        @if ($document->doc_type == 'image')
                                            <img width="100px" height="100px" class="uploaded_img draggable-img"
                                                style="width: 150px; cursor: grab;object-fit: cover;" draggable="true"
                                                data-id="{{ $document->id }}" data-index="{{ $loop->index }}"
                                                src="{{ asset('posts/doc/' . $document->doc_name) }}">
                                        @endif
                                        @if ($document->doc_type == 'video')
                                            <iframe src="{{ asset('posts/doc/' . $document->doc_name) }}" width="100px"
                                                height="100px" frameborder="0" style="object-fit: cover;"></iframe>
                                        @endif
@if ($document->doc_type == 'image')
                                        <a href="{{ url("deletepostold_image/{$post->id}/{$document->id}") }}
"
                                                class="remove-btn" data-document-id="{{ $document->id }}"
                                            style="	
                                                position: absolute;
                                                top: 5px;
                                                right: 5px; 
                                                background: #FD5631;
                                                color: white;
                                                border: none;
                                                border-radius: 50%;
                                                cursor: pointer;
                                                width: 20px;
                                                height: 20px;
                                                display: flex;
                                            
                                                justify-content: center;
                                                padding: 0;
                                                line-height: 1;
                                            ">×</a>
										 @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div id="previewContainer" class="mt-4 d-flex flex-wrap gap-3"></div>
                    </div>

                    <div class="mb-3 p-3 rounded" style="    border: 1px solid #0000001F;">

                        <h4 class="step-header">Upload Documents <span
                                style="color:#281F48; font-size:12px">(Optional)</span></h4>
                        <p class="rounded p-3" style="background-color:#281F48; color: white; ">
                            You can upload a maximum of <strong>1 auction sheet</strong> and <strong>1 brochure PDF
                                file</strong>.
                            The maximum file size is <strong>16 MB</strong>. Allowed format: <strong>PDF</strong>.
                        </p>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="upload-area border border-dashed rounded p-4 text-center"
                                    onclick="document.getElementById('brochureUpload').click();">
                                    <i class="bi bi-file-earmark-pdf fs-1 text-danger mb-2"></i>
                                    <p class="mb-0">Click here to upload brochure</p>
                                    <small class="text-muted">(PDF only, max 16 MB)</small>
                                    <input type="file" id="brochureUpload" name="document_brochure" class="d-none"
                                        accept=".pdf" onchange="handleDocumentUpload(this, 'brochurePreview')">
                                </div>
                                <div id="brochurePreview" class="mt-3 text-success"></div>
                            </div>

                            <div class="col-md-6">
                                <div class="upload-area border border-dashed rounded p-4 text-center"
                                    onclick="document.getElementById('auctionSheetUpload').click();">
                                    <i class="bi bi-file-earmark-pdf fs-1 text-danger mb-2"></i>
                                    <p class="mb-0">Click here to upload auction sheet</p>
                                    <small class="text-muted">(PDF only, max 16 MB)</small>
                                    <input type="file" id="auctionSheetUpload" name="document_auction" class="d-none"
                                        accept=".pdf" onchange="handleDocumentUpload(this, 'auctionSheetPreview')">
                                </div>
                                @if (isset($post->document))
                                    @foreach ($post->document as $document)
                                        @if ($document->doc_type == 'Brochure Document')
                                            <div>
                                                <a href="{{ asset('posts/doc/' . $document->doc_name) }}"
                                                    frameborder="0">{{ $document->doc_type }}</a>
                                            </div>
                                        @endif
                                        @if ($document->doc_type == 'Auction Document')
                                            <div>
                                                <a href="{{ asset('posts/doc/' . $document->doc_name) }}"
                                                    frameborder="0">{{ $document->doc_type }}</a>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                <div id="auctionSheetPreview" class="mt-3 text-success"></div>
                            </div>
                            @error('document_auction')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                            @error('document_brochure')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <!-- Step 8: Location -->
                    <div class="mb-3 p-3 rounded" style="    border: 1px solid #0000001F;">
                        <h4 class="mb-4 step-header">Location</h4>

                        <div class="row mb-3">
                            {{--
                        <div class="col-md-6">
                            <label for="country" class="form-label">Country / Region <span style="color:#FD5631">*</span></label>
                            <select id="country" name="country" class="form-select">
									  <option value="" disabled selected>Select Country</option>
                                @foreach ($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                                
                                <!-- <option value="pakistan" selected>Pakistan</option> -->
                            </select>
                            @error('country')
                            <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                        --}}
                            <input type="hidden" name="country" value="pakistan">
                            <div class="col-md-12">
                                <label for="state" class="form-label" style="color:white">province <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select id="province" name="province" class="form-select "required>
                                    <option value="" disabled selected>Any</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ isset($post->location) && $post->location->province == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}</option>
                                    @endforeach

                                </select>
                                @error('province')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="city" class="form-label" style="color:white">City <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <select id="city" name="city" class="form-select "required>
                                 <!--    <option
                                        value="{{ isset($post->location) && $post->location->city ? '$post->location->city' : '' }}">
                                        {{ $post->location->cityname ?? '' }}</option>-->
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}"
                                            {{ isset($post->location) && $post->location->city == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}</option>
    @endforeach   
                                </select>
                                @error('city')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 d-none">
                                <label for="area" class="form-label" style="color:white">Area <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <input type="number" id="area" name="area" class="form-control formcontrol"
                                    placeholder="Enter Area code" value="default area">
                            </div>
                           
                        </div>

                        <div class="mb-3">
                            <label for="streetAddress" class="form-label" style="color:white">
                                Street Address <span style="color:#FD5631" class="m-0 fs-5">*</span>
                            </label>
                            <input type="text" name="street_address"
                                class="form-control formcontrol validate-field" style="color:#281F48 !important"
                                placeholder="Enter Address" autocomplete="off" required
                                value="{{ $post->location->address ?? '' }}" />
                            <div id="streetAddress-error" class="orange" style="display: none;">Street address is
                                required.</div>
                        </div>


                        <script
                            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initAutocomplete"
                            async defer></script>

                        <script>
                            let selectedPlace = false;

                            function initAutocomplete() {
                                const input = document.getElementById("streetAddress");
                                const latitudeInput = document.getElementById("latitude");
                                const longitudeInput = document.getElementById("longitude");

                                const autocomplete = new google.maps.places.Autocomplete(input, {
                                    fields: ["formatted_address", "geometry"],
                                });

                                autocomplete.addListener("place_changed", () => {
                                    const place = autocomplete.getPlace();
                                    if (place.geometry) {
                                        selectedPlace = true;
                                        input.value = place.formatted_address;
                                        latitudeInput.value = place.geometry.location.lat();
                                        longitudeInput.value = place.geometry.location.lng();
                                    } else {
                                        selectedPlace = false;
                                    }
                                });

                                input.addEventListener("blur", () => {
                                    if (!selectedPlace) {
                                        input.value = "";
                                        latitudeInput.value = "";
                                        longitudeInput.value = "";
                                    }
                                });

                                input.addEventListener("input", () => {
                                    selectedPlace = false;
                                });
                            }

                            window.initAutocomplete = initAutocomplete;
                        </script>

                        <div class="mb-3 d-none">
                            <label for="map" class="form-label">Display on the map <span
                                    style="color:#FD5631">*</span></label>
                        </div>

                        <div id="map" class="border rounded mb-3 d-none" style="height: 300px;">
                            <!-- <input type="text" id="location" name="location" class="form-control"
                                                                            placeholder=""> -->
                        </div>
                    </div>
                    <!-- Step 9: Contacts -->

                    <div class="mb-3 p-3" style="    border: 1px solid #0000001F;">
                        <h4 class="step-header">Contacts</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label" style="color:white">First Name <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <input type="text" class="form-control "
                                    style="color:#281F48 !important;background-color:white !important" name="firstName"
                                    id="firstName" placeholder="Enter First name"
                                    value="{{ $post->contact->first_name ?? '' }}"required>
                                @error('firstName')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="secondName" class="form-label" style="color:white">Second Name <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <input type="text" style="color:#281F48 !important;background-color:white !important"
                                    class="form-control " name="secondName" id="secondName"
                                    placeholder="Enter last name" value="{{ $post->contact->last_name ?? '' }}"required>
                                @error('secondName')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label" style="color:white">Email <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <input type="email" style="color:#281F48 !important;background-color:white !important"
                                    class="form-control " name="email" id="email" placeholder="Enter Email"
                                    value="{{ $post->contact->email ?? '' }}"required>
                                @error('email')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phoneNumber" class="form-label" style="color:white">Phone Number <span
                                        style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                <input type="tel" class="form-control "
                                    style="color:#281F48 !important;background-color:white !important" name="number"
                                    id="phoneNumber" placeholder="Enter phone number"
                                    value="{{ $post->contact->number ?? '' }}" required>


                                
                                @error('number')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 d-none">
                            <label for="website" class="form-label" style="color:white">Website</label>
                            <input type="url" class="form-control " name="website" id="website"
                                placeholder="Enter website"
                                style="color:#281F48 !important;background-color:white !important"
                                value="{{ $post->contact->website ?? '' }}">
                            <div id="website-error" class="text-danger mt-1" style="display: none;">
                                The website URL must start with <strong>https://</strong>.
                            </div>
                        </div>
                        <!-- <div id="socialMediaSection" class="collapse">
                                                                                    <div class="mb-3">
                                                                                        <label for="facebook" name="facebook" class="form-label">Your Facebook Account *</label>
                                                                                        <input type="url" class="form-control" name="facebookUrl" id="facebook" placeholder="Enter Facebook URL">
                                                                                        @error('facebookUrl')
        <div class="alert ">{{ $message }}</div>
    @enderror
                                                                                    </div>
                                                                                    <div class="mb-3">
                                                                                        <label for="linkedin" class="form-label">Your LinkedIn Account *</label>
                                                                                        <input type="url" name="linkedin" class="form-control" id="linkedin" placeholder="Eneter LinkedIn URL">
                                                                                        @error('linkedin')
        <div class="alert ">{{ $message }}</div>
    @enderror
                                                                                    </div>
                                                                                    <div class="mb-3">
                                                                                        <label for="twitter" class="form-label">Your Twitter Account *</label>
                                                                                        <input type="url" name="twitter" class="form-control" id="twitter" placeholder="Twitter URL">
                                                                                        @error('twitter')
        <div class="alert ">{{ $message }}</div>
    @enderror
                                                                                    </div>
                                                                                </div>

                                                                                <button type="button" class="btn btn-link text-white" data-bs-toggle="collapse"
                                                                                    data-bs-target="#socialMediaSection" aria-expanded="false">
                                                                                    Show More
                                                                                </button> -->
                    </div>

                    <div style="display:flex;justify-content:end">
                     {{--   <div>
                            <button type="button" class="btn rounded px-5 primary-color-custom py-2"
                                style="background-color: white;" onclick="scrolltop()">Preview</button>
                        </div>  --}}
                        <div>
                            <input type="button" class="btn custom-btn-nav rounded px-5" value="Update"
                                onclick="submitform(event);">
                            <input type="submit" class="btn custom-btn-nav rounded px-5 d-none"
                                value="Save and continue" id="form_submit_btn">
                        </div>
                    </div>
                </form>
                <!-- Include Google Maps API (use your own API key) -->
                <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>

            </div>
            <div class="col-lg-4">
                <div class="wishlist-card" style="    border: 1px solid #0000001F; background-color:transparent !important">
                    <div class="img-bg-home">

                        <img src="{{ asset('posts/doc/' . $post->document[0]->doc_name) ?? 'https://placehold.co/600x400@2x.png' }}"
                            class="img-adj-card" id="preview_img_post_ad">
                    </div>
                    <div class="py-lg-3 px-lg-4 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 id="yearsvalue">-----</h6>
                            <div>
                                <span
                                    class="rounded px-3 py-1 text-capitalize featured_label {{ $post->feature_ad == '1' ? '' : 'd-none' }}"
                                    style="background-color:#BF0000; font-size:12px; "><img
                                        src="{{ asset('web/images/star-icon.svg') }}"
                                        class="me-2 mb-1 img-fluid">featured</span>
                                <span class="rounded px-3 py-1 text-capitalize" id="vehicleConditionvalue"
                                    style="background-color:#4581F9; font-size:12px;">-----</span>
                            </div>
                        </div>

                        <h4 id="vehiclename" style="color:#281F48">-----</h4>
                        <h5 style="color: ##F6F6F6;"><b id="priceInputvalue">PKR -----</b></h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"> <i class="bi bi-geo-alt"></i>
                                <span id="cityvalue">-----</span>
                            </h6>
                            <span style="font-size:11px;">Last Updated:
                                {{ \carbon\carbon::parse($post->updated_at)->format('F d, Y') }}</span>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-4">
                                <div class="text-center py-1" style="background-color:#F6F6F6; border-radius: 10px;">
                                    <i class="bi bi-speedometer2"></i>
                                    <h6 id="mileagevalue" style="font-size:14px">-----</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center py-1" style="background-color:#F6F6F6; border-radius: 10px;">
                                    <i class="bi bi-car-front-fill"></i>
                                    <h6 id="transmission_value " style="font-size:14px">-----</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center py-1" style="background-color:#F6F6F6; border-radius: 10px;">
                                    <i class="bi bi-fuel-pump-diesel"></i>
                                    <h6 id="fule_type_value" style="font-size:14px">-----</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Row 1 -->
                        <div class="row my-3">
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Manufacturing Year</strong></span>
                                <span id="manufacturing_year_value">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Registered?</strong></span>
                                <span id="registeredDealervalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Make</strong></span>
                                <span id="makecompanydatavalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Model</strong></span>
                                <span id="modelvalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Transmission</strong></span>
                                <span id="transmissionvalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Assembly</strong></span>
                                <span id="assemblyvalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Door Count</strong></span>
                                <span id="doorCountvalue">-----</span>
                            </div>


                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Fuel Type</strong></span>
                                <span id="fuelTypevalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Engine Capacity</strong></span>
                                <span id="engineCapacityvalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Mileage</strong></span>
                                <span id="mileage_value">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Body Type</strong></span>
                                <span id="bodyTypevalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Exterior Color</strong></span>
                                <span id="exterior_colorvalue">-----</span>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between">
                                <span><strong>Seating Capacity</strong></span>
                                <span id="seatingCapacityvalue">-----</span>
                            </div>
                        </div>
                        <!-- Features Section -->
                        <div class="features mt-4">
                            <h5 style="color: #FD5631;">Features<span class="text-danger">*</span></h5>
                            <div class="row mt-3">
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-fan"></i> Air Conditioning
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-shield-shaded"></i> Air Bags
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-cassette-fill"></i> Cassette Player
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-thermometer-half"></i> Cool Box
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-speedometer2"></i> Cruise Control
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-disc"></i> DVD Player
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-speaker"></i> Front Speaker
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-camera-video"></i> Front Camera
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-key"></i> Keyless Entry
                                </div>
                                <div class="col-md-6 feature-item">
                                    <i class="bi bi-shield"></i> Immobilizer Key
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    @if (isset($post))
        @include('user.post.preview')
    @endif
    <div class="modal fade" id="preview" tabindex="-1" aria-labelledby="previewLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden">
                <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                    <h5 class="modal-title" id="previewLabel"><strong> Preview Your Ad</strong></h5>
                    <button type="button"  class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="background-color: #F0F3F6; color: #FD5631;">
                    <div id="previewContent">
                        <!-- Preview content will be populated here via JavaScript -->
                    </div>
                </div>
                <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                    <button type="button"
                       class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary" onclick="document.getElementById('adForm').submit();">Confirm & Submit</button> -->
                </div>
            </div>
        </div>
    </div>
<!-- Bootstrap Modal -->
    <div class="modal fade" id="fileAlertModal" tabindex="-1" aria-labelledby="fileAlertModalLabel"
        aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden">
            <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                <h5 class="modal-title" id="fileAlertModalLabel"><strong> File Upload Error</strong></h5>
                <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="fileAlertModalBody" style="background-color: #F0F3F6; color: #FD5631;">
                <!-- Alert message will be inserted here -->
            </div>
            <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                    <button type="button"
                        class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="imageValidationModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden">
            <div class="modal-header" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                <h5 class="modal-title" id="modalTitle"><strong> Image Upload Error</strong></h5>
                <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" style="background-color: #F0F3F6; color: #FD5631;">
                <p id="modalMessage">Please upload at least 5 and at most 30 images.</p>
            </div>
            <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                    <button type="button"
                        class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
    <!-- JavaScript for Step Navigation -->
    <script>
        let firstImageSet = false;

        function showMore(featureId) {
            const moreOptions = document.getElementById(featureId);
            moreOptions.classList.toggle('d-none');
        }

        function handleFiles(files) {
            const previewContainer = document.getElementById('previewContainer');
            previewContainer.innerHTML = ''; // Clear previous previews
let indexCounter = 0;
            Array.from(files).forEach((file) => {
                if (file.size <= 8 * 1024 * 1024) { // Image limit
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('draggable-img');
                        img.style.width = '150px';
						img.setAttribute('data-index', indexCounter);
                        previewContainer.appendChild(img);
						indexCounter++;
                    };
                    reader.readAsDataURL(file);
                } else if (file.size <= 10 * 1024 * 1024 && /\.(mp4|mov)$/i.test(file.name)) { // Video limit
                    const video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.controls = true;
                    video.style.width = '150px';
                    previewContainer.appendChild(video);
                } else {
                    alert('Invalid file or size exceeds limit!');
                }
            });
        }



        function handleDrop(event) {
            event.preventDefault();
            const files = event.dataTransfer.files;
            handleFiles(files);
        }
        document.addEventListener("DOMContentLoaded", function() {
const uploadedImgsContainer = document.getElementById('uploadedImgsContainer');
    const previewImgPostAd = document.getElementById('preview_img_post_ad'); // Ensure this exists!

    if (!uploadedImgsContainer || !previewImgPostAd) {
        console.error("One or both elements are missing!");
        return;
    }

    let draggedElement = null;

    // Make all images draggable
    function makeDraggable() {
        uploadedImgsContainer.querySelectorAll('.draggable-img').forEach(img => {
            img.setAttribute("draggable", "true");
            img.addEventListener("dragstart", handleDragStart);
        });
    }

    makeDraggable(); // Initialize drag events

    // Drag Start
    function handleDragStart(event) {
        draggedElement = event.target;
        event.dataTransfer.effectAllowed = "move";
    }

    // Drag Over
    function handleDragOver(event) {
        event.preventDefault();
        event.dataTransfer.dropEffect = "move";
    }

    // Drop (Swaps Images)
function handleDrop(event) {
    event.preventDefault();

    const targetElement = event.target;
    if (!targetElement.classList.contains("draggable-img") || targetElement === draggedElement) return;

    // Swap image sources
    let tempSrc = draggedElement.src;
    draggedElement.src = targetElement.src;
    targetElement.src = tempSrc;

    let tempId = draggedElement.getAttribute("data-id");
    draggedElement.setAttribute("data-id", targetElement.getAttribute("data-id"));
    targetElement.setAttribute("data-id", tempId);

    // Update `preview_img_post_ad` to show the first image
    updatePreviewImage();

    // Re-calculate image order and update DB
    updateImageOrderInDB();
}

function updateImageOrderInDB() {
    let imageOrder = [];
    
    // Re-traverse the DOM to get the correct order of images
    document.querySelectorAll("#uploadedImgsContainer .draggable-img").forEach((img, index) => {
        imageOrder.push({
            id: img.getAttribute("data-id"),
            position: index + 1 // Position starts from 1
        });
    });

    // Log the image order before sending to DB (for debugging)
    console.log("Updated Image Order:", imageOrder);

    // Send the updated order to the backend via AJAX
    fetch('/update-image-order', {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                "content") // CSRF token for Laravel
        },
                        body: JSON.stringify({
                            imageOrder: imageOrder
                        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Order updated:", data);
    })
    .catch(error => console.error("Error updating order:", error));
}

function updatePreviewImage() {
    const firstImg = uploadedImgsContainer.querySelector(".draggable-img");
    if (firstImg) {
        previewImgPostAd.src = firstImg.src;
    }
}


    // Attach event listeners to `uploadedImgsContainer`
    uploadedImgsContainer.addEventListener("dragover", handleDragOver);
    uploadedImgsContainer.addEventListener("drop", handleDrop);
    // Handle remove button click (for removing images)
    previewContainer.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-btn")) {
            const documentId = e.target.getAttribute("data-document-id");
            const previewItem = e.target.closest(".preview-item");

            // Send request to delete image (optional, depends on your backend setup)
            fetch(`/deletepostold_image/${postId}/${documentId}`, {
                method: "DELETE",
            })
            .then((response) => {
                if (response.ok) {
                    // Remove the image item from DOM after deletion
                    previewItem.remove();
                    console.log(`Document with ID ${documentId} deleted`);
                } else {
                    console.error("Failed to delete document");
                }
            })
            .catch((error) => {
                console.error("Error deleting document:", error);
            });

            // Optionally, remove the item from the file list in JavaScript if needed
            // This might require additional logic to track deleted files.
        }
    });
});

        function populatePreview() {

            const previewContent = document.getElementById('previewContent');
            previewContent.innerHTML = ''; // Clear previous content

            // Collect data from the form

            // Collect data from the form
            const title = document.getElementById('adTitle').value;
            const condition = document.getElementById('vehicleCondition').value;
            const price = document.getElementById('priceInput').value;
            const make = document.getElementById('makecompanydata').value;
            const model = document.getElementById('model').value;
            const year = document.getElementById('years').value;
            const mileage = document.getElementById('mileage').value;

            // Add collected data to the preview content
            previewContent.innerHTML += `
            <h6>Ad Title: ${title}</h6>
            <p>Condition: ${condition}</p>
            <p>Price: ${price}</p>
            <p>Make: ${make}</p>
            <p>Model: ${model}</p>
            <p>Year: ${year}</p>
            <p>Mileage: ${mileage}</p>
            <!-- Add more fields as needed -->
            <div class="container mb-4">
                        <div class="breadcrumb-nav mb-3">
                            <a href="#" class="breadcrumb-item text-white">Home</a>
                            <span class="breadcrumb-separator">></span>
                            <a href="#" class="breadcrumb-item text-white">${condition}</a>
                            <span class="breadcrumb-separator">></span>
                            <span class="breadcrumb-item active">${model}</span>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">

                                <h2>${modelname} ${year}</h2>
                            </div>
                        
                        </div>
                    </div>
                    <div class="container mb-4">
                        <div class="row">
                        
                            <div class="col-lg-7">
                            
                                <div class="container my-4">
                                    <h5 style="color: #FD5631;">Specifications</h5>

                                    <!-- Row 1 -->
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Manufacturing Year</strong></span>
                                            <span> ${year}</span>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Registered?</strong></span>
                                            <span>Yes</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Make</strong></span>
                                            <span> ${makename}</span>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Model</strong></span>
                                            <span> ${modelname}</span>
                                        </div>
                                    </div>

                                    <!-- Row 2 -->
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Transmission</strong></span>
                                            <span>${transmission}</span>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Assembly</strong></span>
                                            <span>${assembly}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Door Count</strong></span>
                                            <span>${doors}</span>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Fuel Type</strong></span>
                                            <span>${fuel}</span>
                                        </div>
                                    </div>

                                    <!-- Row 3 -->
                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Engine Capacity</strong></span>
                                            <span>${engine_capacity}</span>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Mileage</strong></span>
                                            <span>${milleage}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Body Type</strong></span>
                                            <span>${bodytypename}</span>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Exterior Color</strong></span>
                                            <span>${excolorname}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 d-flex justify-content-between">
                                            <span><strong>Seating Capacity</strong></span>
                                            <span>${seating_capacity}</span>
                                        </div>
                                    </div>

                                    <!-- Features Section -->
                                    <div class="features mt-4">
                                        <h5 style="color: #FD5631;">Features</h5>
                                        <div class="row mt-3">

                                            
                                            <div class="col-md-4 feature-item">
                                                <!-- <i class="bi bi-fan"></i>  -->
                                                ${feature_name}
                                            </div>
                                        



                                        </div>
                                    </div>
                                    <!-- Seller's Description Section -->
                                    <div class="description mt-4">
                                        <h5 style="color: #FD5631;">Seller's Description</h5>
                                        <p>${dealer_comment}.</p>
                                        <div class="mt-3">
                                        
    
                                        </div>
                                    </div>
                                    <!-- Information Section -->
                                    <div class="info-section mt-4">
                                        <div class="row text-start">
                                            <div class="col-md-3">
                                                <div class="info-item">Published:</div>
                                                <div class="info-value">${created_at} </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-item">Last Updated:</div>
                                                <div class="info-value">${ updated_at}</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-item">Ad Id:</div>
                                                <div class="info-value">${id}</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="info-item">Member Since:</div>
                                                <div class="info-value">${ created_at}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-5">
                                <div class="row align-items-center mb-4">
                                    <!-- Left Side Buttons -->
                                    <div class="col d-flex align-items-center">
                                        <button class="btn custom-btn-3">${condition}</button>
                                        <!-- <button class="btn custom-btn-3 ms-2">Used</button> -->
                                    </div>

                                
                                </div>
                                <div class="row align-items-center mb-3">
                                    <!-- First Column -->
                                    <div class="col-md-8">
                                        <h5 class="mb-1"><span style="color: #FD5631;">PKR ${price}</span></h5>
                                        <div class="row">
                                            <div class="col-auto">
                                                <p>${milleage} miles</p>
                                            </div>
                                            <div class="col-auto">
                                                <p>${cityname}, ${locationarea}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Second Column -->
                                    <div class="col-md-4 text-end">
                                        <p><strong>Posted on:</strong> ${created_at}</p>
                                    </div>
                                </div>

                            </div>
                        </div>



                    </div>
        `;
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const websiteInput = document.getElementById('website');
            const errorDiv = document.getElementById('website-error');

            websiteInput.addEventListener('input', function() {
                const value = websiteInput.value;
                const isValid = value.startsWith('https://');

                if (value && !isValid) {
                    errorDiv.style.display = 'block';
                } else {
                    errorDiv.style.display = 'none';
                }
            });

            websiteInput.addEventListener('blur', function() {
                const value = websiteInput.value;
                const isValid = value.startsWith('https://');

                if (value && !isValid) {
                    errorDiv.style.display = 'block';
                } else {
                    errorDiv.style.display = 'none';
                }
            });
        });
    </script>



    {{-- handling Ad preview  --}}


    <script>
        // handling image preview in ad preview 
        function handleAdPreview(files) {
            const previewAdImg = document.getElementById('preview_img_post_ad');



            Array.from(files).forEach((file, index) => {
                if (file.type.startsWith('image/') && file.size <= 8 * 1024 * 1024) {
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        // Update the primary preview image for the first valid image
                        if (!firstImageSet) {
                            previewAdImg.src = e.target.result;
                            firstImageSet = true;
                        }

                    };

                    reader.readAsDataURL(file);
                } else if (file.type.startsWith('video/') && file.size <= 10 * 1024 * 1024) {
                    previewAdImg.src = 'https://placehold.co/600x400@2x.png';
                    firstImageSet = false;

                } else {
                    console.warn('Invalid file type or size exceeds limit!');
                    firstImageSet = false;

                }
            });
        }

        // handling car condition 


        $('#vehicleCondition').change(function(e) {
            e.preventDefault();
            var vehicleConditionvalue = $(this).val();
            $('#vehicleConditionvalue').text(vehicleConditionvalue)
        });
        // handling assembly 
        $('#assembly').change(function(e) {
            e.preventDefault();
            var assemblyvalue = $(this).val();
            $('#assemblyvalue').text(assemblyvalue)
        });
        // handling registeredDealer 
        $('#registeredDealer').change(function(e) {
            if ($(this).prop('checked')) {

                $('#registeredDealervalue').text('Yes')
            }
        });
        $('#privateDealer').change(function(e) {
            if ($(this).prop('checked')) {

                $('#registeredDealervalue').text('No')
            }
        });
        // handling price 
        $('#priceInput').change(function(e) {
            e.preventDefault();
            var priceInputValue = $(this).val();

            // Remove any non-numeric characters except for "." (for decimal values)
            var numericValue = priceInputValue.replace(/[^0-9.]/g, '');

            // Format the numeric value with commas
            var formattedValue = parseFloat(numericValue).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            // Display the formatted value
            $('#priceInputvalue').text(formattedValue);
        });

        // handling make 
         $('#makecompanydata').change(function(e) {
             e.preventDefault();
             var makecompanydatavalue = $(this).find('option:selected').text();
			
             $('#makecompanydatavalue').text(makecompanydatavalue);
			  $('#vehiclename').text(makecompanydatavalue);
         });
         // handling model 
         $('#model').change(function(e) {
             e.preventDefault();
             //alert('e');
             var modelvalue = $(this).find('option:selected').text();
			 
             $('#modelvalue').text(modelvalue);
			 modelvalue = $('#makecompanydatavalue').text()  + ' ' + modelvalue;
             $('#vehiclename').text(modelvalue);
         });
        // handling year 
        $('#years').change(function(e) {
            e.preventDefault();
            var yearsvalue = $(this).val();
            $('#yearsvalue').text(yearsvalue);
            $('#manufacturing_year_value').text(yearsvalue);
        });
        // handling mileage 
        $('#mileage').change(function(e) {
            e.preventDefault();
            var mileagevalue = $(this).val();
            $('#mileagevalue').text(mileagevalue);
            $('#mileage_value').text(mileagevalue);
        });
        // handling bodytype 
        $('#bodyType').change(function(e) {
            e.preventDefault();
            var bodyTypevalue = $(this).find('option:selected').text();
            $('#bodyTypevalue').text(bodyTypevalue);
        });
        // handling doorCount 
        $('#doorCount').change(function(e) {
            e.preventDefault();
            var doorCountvalue = $(this).val();
            $('#doorCountvalue').text(doorCountvalue);
        });
        // handling fuelType 
        $('#fuelType').change(function(e) {
            e.preventDefault();
            var fuelTypevalue = $(this).val();
            $('#fuelTypevalue').text(fuelTypevalue);
            $('#fule_type_value').text(fuelTypevalue);
        });
        // handling seatingCapacity 
        $('#seatingCapacity').change(function(e) {
            e.preventDefault();
            var seatingCapacityvalue = $(this).val();
            $('#seatingCapacityvalue').text(seatingCapacityvalue);
        });
        // handling engineCapacity 
        $('#engineCapacity').change(function(e) {
            e.preventDefault();
            var engineCapacityvalue = $(this).val();
            $('#engineCapacityvalue').text(engineCapacityvalue);
        });
        // handling transmission 
        $('#transmission').change(function(e) {
            e.preventDefault();
            var transmissionvalue = $(this).val();
            $('#transmissionvalue').text(transmissionvalue);
            $('#transmission_value').text(transmissionvalue);
        });
        // handling exterior_color 
        $('#exterior_color').change(function(e) {
            e.preventDefault();
            var exterior_colorvalue = $(this).find('option:selected').text();
            $('#exterior_colorvalue').text(exterior_colorvalue);
        });
        // handling city 
        $('#city').change(function(e) {
            e.preventDefault();
            var cityvalue = $(this).find('option:selected').text();
            $('#cityvalue').text(cityvalue);
        });
        // handling feature_ad 
        $('#feature_ad').change(function(e) {
            e.preventDefault();

            if ($(this).prop('checked')) {
                $('.featured_label').removeClass('d-none');
            } else {
                $('.featured_label').addClass('d-none');
            }

        });


        // handling features 

        function updateSelectedFeatures() {
            const selectedFeaturesContainer = $('.features .row.mt-3');
            selectedFeaturesContainer.empty();

            // Get all checked checkboxes
            $('.feature_checkbox:checked').each(function() {
                const featureText = $(this).siblings('label').text().trim();
                const featureIcon = getFeatureIcon(featureText);
                const featureDiv = `
                <div class="col-md-6 feature-item">
                    <i class="${featureIcon} orange"></i> ${featureText}
                </div>`;
                selectedFeaturesContainer.append(featureDiv);
            });
        }


        function getFeatureIcon(featureText) {
            const featureIcons = {
                'Air Conditioning': 'bi bi-fan',
                'Air Bags': 'bi bi-shield-shaded',
                'Cassette Player': 'bi bi-cassette-fill',
                'Cool Box': 'bi bi-thermometer-half',
                'Cruise Control': 'bi bi-speedometer2',
                'DVD Player': 'bi bi-disc',
                'Front Speaker': 'bi bi-speaker',
                'Front Camera': 'bi bi-camera-video',
                'Keyless Entry': 'bi bi-key',
                'Immobilizer Key': 'bi bi-shield',
            };
            return featureIcons[featureText] || 'bi bi-check-circle';
        }


        $('.form-check-input').change(function() {
            updateSelectedFeatures();
        });


        updateSelectedFeatures();

        function scrolltop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }


       function submitform(event) {
    event.preventDefault(); // Prevent default form submission

    const form = document.getElementById('adForm');
    const fileInput = document.getElementById('fileUpload');
            let existingImages = parseInt(document.getElementById('existingImageCount').value) ||
            0; // Get existing images count
    let newImages = fileInput.files.length; // Get newly uploaded images count
    let totalImages = existingImages + newImages; // Combine both

    if (totalImages < 5 || totalImages > 30) {
        // Show Bootstrap Modal
        let modal = new bootstrap.Modal(document.getElementById('imageValidationModal'));
        document.getElementById('modalMessage').textContent = 
            `You have ${totalImages} images. Please ensure the total number of images is between 5 and 30.`;
        modal.show();
    } else {
        // Submit the form when validation passes
        document.getElementById('form_submit_btn').click();
    }
}
    </script>







    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updatePreview();

            $('#vehicleCondition').trigger('change');
            $('#assembly').trigger('change');
            $('#registeredDealer').trigger('change');
            $('#privateDealer').trigger('change');
            $('#priceInput').trigger('change');
            $('#makecompanydata').trigger('change');
            $('#model').trigger('change');
            $('#years').trigger('change');
            $('#mileage').trigger('change');
            $('#bodyType').trigger('change');
            $('#doorCount').trigger('change');
            $('#fuelType').trigger('change');
            $('#seatingCapacity').trigger('change');
            $('#engineCapacity').trigger('change');
            $('#transmission').trigger('change');
            $('#exterior_color').trigger('change');
            $('#city').trigger('change');
            $('#feature_ad').trigger('change');
            updateSelectedFeatures();
        });

        // Helper function to update all preview fields
        function updatePreview() {
            // Populate initial values into the preview
            $('#vehicleConditionvalue').text($('#vehicleCondition').val());
            $('#assemblyvalue').text($('#assembly').val());
            $('#registeredDealervalue').text($('#registeredDealer').is(':checked') ? 'Yes' : 'No');
            $('#priceInputvalue').text($('#priceInput').val());
            $('#makecompanydatavalue').text($('#makecompanydata option:selected').text());
            $('#modelvalue').text($('#model option:selected').text());
            $('#yearsvalue').text($('#years').val());
            $('#mileagevalue').text($('#mileage').val());
            $('#bodyTypevalue').text($('#bodyType option:selected').text());
            $('#doorCountvalue').text($('#doorCount').val());
            $('#fuelTypevalue').text($('#fuelType').val());
            $('#seatingCapacityvalue').text($('#seatingCapacity').val());
            $('#engineCapacityvalue').text($('#engineCapacity').val());
            $('#transmissionvalue').text($('#transmission').val());
            $('#transmission_value').text($('#transmission').val());
            $('#exterior_colorvalue').text($('#exterior_color option:selected').text());
            $('#cityvalue').text($('#city option:selected').text());
            if ($('#feature_ad').is(':checked')) {
                $('.featured_label').removeClass('d-none');
            } else {
                $('.featured_label').addClass('d-none');
            }
        }

        $('.delete_old_image').click(function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this?')) {
                var id = $(this).data('id'); // Get the ID from data attribute
                let formData = new FormData();
                formData.append("id", id);

                let type = 'POST';
                let url = '/deletepostold_image';

                // Send Ajax request to server
                SendAjaxRequestToServer(type, url, formData, '', deletepostold_imageResponse, '', '');
            }
        });

        function deletepostold_imageResponse(response) {
            console.log(response);

            if (response.status == 200) {
                // Show success notification
                toastr.success(response.message, '', {
                    timeOut: 3000
                });

                // Remove the corresponding container
                $('#old_img_container_' + response.id).remove();
            } else if (response.status == 402) {
                // Show error message for status 402
                toastr.error(response.message, '', {
                    timeOut: 3000
                });
            } else {
                // Handle other errors
                let error = response.message;

                if (response.errors) {
                    // Highlight invalid fields
                    $.each(response.errors, function(key) {
                        var inputField = $('[name="' + key + '"]');
                        inputField.addClass('is-invalid'); // Add 'is-invalid' class
                    });
                }

                // Show error notification
                toastr.error(error, '', {
                    timeOut: 3000
                });
            }
        }
</script>
<script>
        let fileArray = []; // To track all selected files globally

        function handleImgUpload(files) {
            const previewContainer = document.getElementById('previewContainer');
            const fileInput = document.getElementById('fileUpload'); // Get reference to file input

            // Append new files to the existing fileArray without duplicates
            const newFiles = Array.from(files).filter((file) => {
                return !fileArray.some((f) => f.name === file.name && f.size === file.size);
            });
			if (fileArray.length + newFiles.length > 30) {
				alert('You can upload a maximum of 30 files.');
				return;
			}
            fileArray = fileArray.concat(newFiles); // Add only non-duplicate files

            // Update the input's files with the current fileArray
            updateFileInput();
			
let indexCounter = fileArray.length - newFiles.length;
			
            // Render only the newly added files
            newFiles.forEach((file) => {
                if (file.size <= 8 * 1024 * 1024 && /\.(jpe?g|png|gif|bmp)$/i.test(file.name)) { // Image limit
                    const reader = new FileReader();

                    reader.onload = (e) => {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'preview-item';
                        wrapper.setAttribute('data-filename', file.name);
                        wrapper.setAttribute('data-filesize', file.size);
                        wrapper.style.display = 'inline-block';
                        wrapper.style.position = 'relative';
                        wrapper.style.margin = '10px';

                        const img = document.createElement('img');
                        img.src = e.target.result;
						img.classList.add('draggable-img');
                        //img.className = 'img-thumbnail';
                        img.style.width = '150px';
                        img.style.height = '150px';
                        img.style.objectFit = 'cover';
						img.setAttribute('data-index', indexCounter);

                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.innerHTML = '×';
                        removeBtn.style.position = 'absolute';
                        removeBtn.style.top = '5px';
                        removeBtn.style.right = '5px';
                        removeBtn.style.background = '#FD5631';
                        removeBtn.style.color = 'white';
                        removeBtn.style.border = 'none';
                        removeBtn.style.borderRadius = '50%';
                        removeBtn.style.cursor = 'pointer';
                        removeBtn.style.width = '20px';
                        removeBtn.style.height = '20px';
                        removeBtn.style.display = 'flex';
                  
                        removeBtn.style.justifyContent = 'center';
                        removeBtn.style.padding = '0';
                        removeBtn.style.lineHeight = '1';

                        // Improved remove functionality
                        removeBtn.onclick = () => {
                            wrapper.remove(); // Remove from DOM
                            // Remove from fileArray using file identifiers
                            fileArray = fileArray.filter(f =>
                                !(f.name === file.name && f.size === file.size)
                            );
                            updateFileInput(); // Update input files after removal
                            console.log('Remaining files:', fileArray);
                        };

                        wrapper.appendChild(img);
                        wrapper.appendChild(removeBtn);
                        previewContainer.appendChild(wrapper);
						indexCounter++;
                    };

                    reader.readAsDataURL(file);
                } else {
                   function showFileAlert(message) {
    document.getElementById('fileAlertModalBody').innerText = message;
    var fileAlertModal = new bootstrap.Modal(document.getElementById('fileAlertModal'));
    fileAlertModal.show();
}

// Example Usage:
                    if (file.size > 8 * 1024 * 1024) { // 8MB limit
    showFileAlert(`File "${file.name}" is invalid or exceeds the 8MB size limit!`);
} else {
    // Process valid file
}

                }
            });
        }

        // Function to update the file input with current fileArray
        function updateFileInput() {
            const fileInput = document.getElementById('fileUpload');
            // Create a DataTransfer object and add our files
            const dataTransfer = new DataTransfer();
            fileArray.forEach(file => {
                dataTransfer.items.add(file);
            });
            // Set the input's files to our DataTransfer files
            fileInput.files = dataTransfer.files;
        }

      

        function removeDocument(postId, documentId) {
    
        fetch(`/deletepostold_image/${postId}/${documentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status == 200) {
                // Remove the element from DOM
                const element = document.querySelector(`[data-document-id="${documentId}"]`).parentElement;
                element.remove();
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error removing image');
        });
    
}
    </script>


<script>
        $(document).ready(function() {
    $('#phoneNumber').on('input', function() {
    // Remove all non-numeric characters
    let phoneValue = $(this).val().replace(/\D/g, '');
    
    // If number starts with 92, remove it
    phoneValue = phoneValue.replace(/^92/, '');
    
    // If number starts with 0, remove it
    phoneValue = phoneValue.replace(/^0/, '');
    
    // Format the number with proper spacing
    let formatted = '';
    if (phoneValue.length > 0) {
        formatted = '+92 ' + phoneValue.substring(0, 3);
        if (phoneValue.length > 3) {
            formatted += ' ' + phoneValue.substring(3);
        }
    }
    
    // Limit the total length
    formatted = formatted.substring(0, 15);
    
    // Update input value
    $(this).val(formatted);
    
    // Validate: must be exactly "+92 3XX XXXXXXXX" format
    const isValid = /^\+92 3\d{2} \d{7}$/.test(formatted);
    $('#phone-error').toggle(!isValid);
});
});
</script>















@endsection
