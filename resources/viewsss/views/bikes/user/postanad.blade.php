@extends('layout.website_layout.bikes.bike_main')
@section('content')

  <style>
	  body {
    font-family: 'Maven Pro', sans-serif !important;
}
	  .form-select {
    max-width: 100% !important;
    text-align: start !important;
}
	.orange {
    color: #FD5631 !important;
}
.img-adj-card {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
        /* Hide the default radio button */
        .registeredDealer {
            position: absolute;
            opacity: 0;
        }
-input:focus {
    border: 2px solid red !important;
}
        /* Custom radio button styling */
        .registeredDealer + .registeredDealer1 {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            display: inline-block;
            color: #fff; /* Text color */
            font-size: 16px;
        }

        /* Outer circle */
        .registeredDealer + .registeredDealer1::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #FD5631; /* Border color */
            border-radius: 50%; /* Makes it a circle */
            background-color: #2E2D3C; /* Background color */
            transition: all 0.3s ease;
        }

        /* Inner circle when checked */
        .registeredDealer:checked + .registeredDealer1::after {
            content: '';
            position: absolute;
            left: 5px;
            top: calc(50% + 0px);
            transform: translateY(-50%);
            width: 10px;
            height: 10px;
            background-color: #FD5631; /* Inner circle color */
            border-radius: 50%;
        }
      /* Hide the default radio button */
        .privateDealer {
            position: absolute;
            opacity: 0;
        }

        /* Custom radio button styling */
        .privateDealer + .privateDealer1 {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
            display: inline-block;
            color: #fff; /* Text color */
            font-size: 16px;
        }
	           #goToTop,
    #goToBottom {
        position: fixed;
        right: 20px;
        padding: 10px;
        padding-left: 15px;
        padding-right: 15px;
        font-size: 20px;
        background-color: #FD5631;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        z-index: 1000;
        opacity: 0;
        /* Start hidden */
        visibility: hidden;
        /* Prevent interaction when hidden */
        transition: opacity 0.3s ease, visibility 0.3s ease;
        /* Smooth transition */
    }

    #goToTop {
        bottom: 80px;
    }

    #goToBottom {
        bottom: 20px;
    }

    #goToTop:hover,
    #goToBottom:hover {
        background-color: #f94922;
    }

    /* Show buttons with fade-in effect */
    #goToTop.show,
    #goToBottom.show {
        opacity: 1;
        visibility: visible;
    }

        /* Outer circle */
        .privateDealer + .privateDealer1::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #FD5631; /* Border color */
            border-radius: 50%; /* Makes it a circle */
            background-color: #2E2D3C; /* Background color */
            transition: all 0.3s ease;
        }

        /* Inner circle when checked */
        .privateDealer:checked + .privateDealer1::after {
            content: '';
            position: absolute;
            left: 5px;
            top: calc(50% + 0px);
            transform: translateY(-50%);
            width: 10px;
            height: 10px;
            background-color: #FD5631; /* Inner circle color */
            border-radius: 50%;
        }
.feature_checkbox {
    width: 15px;
    height: 15px;
   
    border: 2px solid #00000080; 
    border-radius: 4px; 
    cursor: pointer;
    transition: all 0.3s ease; 
}
.feature_checkbox:checked {
    background-color: #281F48;
    border-color:#281F48;
}
   .feature_ad {
    width: 20px;
    height: 20px;
    background-color: #282435; 
    border: 2px solid #EFEFEF80; 
    border-radius: 4px; 
    cursor: pointer;
    transition: all 0.3s ease; 
}
.feature_ad:checked {
    background-color: #FD5631;
    border-color: #FD5631;
}
	  .custom-switch {
    width: 40px;
    height: 20px;
    background-color: #484553;
    border-radius: 20px !important; 
    position: relative;
    cursor: pointer;
    outline: none;
    transition: background-color 0.3s ease; 
		  border:none;
}
.custom-switch::before {
    content: '';
    width: 16px;
    height: 16px;
    background-color: white;
    border-radius: 50%;
    position: absolute;
    top: 2px;
    left: 2px;
    transition: transform 0.3s ease;
}
.custom-switch:checked {
    background-color: #FD5631; 
}

.custom-switch:checked::before {
    transform: translateX(20px); 
}
	  .form-label{
	  color:#281F48 !important;
		  font-weight:400;
		  font-size:18px;
	  }
	  .form-check-label{
	    color:#281F48 !important;
		  font-weight:400;
		  font-size:16px;
	  }
	  .step-header{
	    color:#281F48 !important;
		  font-weight:700;
		  font-size:24px;
	  }
	  .primary-color-custom{
	      color:#281F48 !important;
		  font-weight:700;
		  font-size:48px;
	  }
    </style>
    <!-- back header start -->
    <div class="container mt-3">
        <div class="row align-items-center mb-2">
          
            <div class="col-auto">
                <h2 class="sec mb-0 primary-color-custom">Post an Ad</h2>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="row pb-md-5 pt-md-3">
            <div class="col-lg-8" >
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="adForm" method="post" action="{{ route('ads.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Step 2: Basic Info -->
                    <input type="hidden" value="" name="dealer">
                    <div class="mb-3 p-3 d-none rounded" style="background-color:#282435;">
                
                
                    
                    </div>

                    <!-- Step 3: Currency & Price -->
                    <div class="mb-3 p-3 d-none rounded" style="background-color:#282435;">
                
                  
                    </div>
                    <!-- Step 4: Vehicle Information -->
                    <div class=" row mb-3  rounded" style="background-color:white;">
             <div class="col-md-12 " >
				 <div class="row">
				            <h4 class="step-header">Vehicle information</h4>
                        <input type="hidden" name="step4" value="step4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="make" class="form-label"  style="color:white">Feature Ad <span style="color:#FD5631">*</span></label>
                             <select class="form-select " aria-label="Default select example">
  <option selected>Open this select menu</option>
  <option value="1">One</option>
  <option value="2">Two</option>
  <option value="3">Three</option>
</select>
									 <div id="makecompanydata-error" class="orange" style="display: none;">Make is required.</div>
                                @error('makecompany')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
								
                                <label for="model" class="form-label"  style="color:white">Registered <span style="color:#FD5631">*</span></label>
                                <select class="form-select filter-style validate-field" name="model" id="model"required>
                                    <option value="{{ $post->model ?? '' }}" selected>{{ $post->modelname ?? 'model' }}
                                    </option>

                                </select>
									 <div id="model-error" class="orange" style="display: none;">Model is required.</div>
                                @error('model')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="year" class="form-label"  style="color:white">Assembly <span style="color:#FD5631">*</span></label>
                                <select class="form-select filter-style validate-field" name="year" id="years"required>
                                    <option value="">Any</option>
                                    @for ($year = now()->year; $year >= 1960; $year--)
                                        <option value="{{ $year }}"
                                            {{ isset($post) && $post->year == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
									 <div id="years-error" class="orange" style="display: none;">Year is required.</div>
                                @error('year')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="mileage" class="form-label"  style="color:white">Price <span style="color:#FD5631">*</span></label>
                                <input type="number" name="mileage" value="{{ $post->milleage ?? '' }}"
                                    class="form-control formcontrol validate-field" id="mileage" placeholder="e.g., 25000"
                                    min="0"required>
									 <div id="mileage-error" class="orange" style="display: none;">Mileage is required.</div>
                                @error('mileage')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="bodyType" class="form-label"  style="color:white">Make <span style="color:#FD5631">*</span></label>
                                <select class="form-select filter-style validate-field" name="bodyType" id="bodyType"required>
                                 <option value="">Any</option>
                                    @foreach ($bodytypes as $bodytype)
                                        <option value="{{ $bodytype->id }}"
                                            {{ isset($post) && $post->body_type == $bodytype->id ? 'selected' : '' }}>
                                            {{ $bodytype->name }}</option>
                                    @endforeach
                                </select>
									 <div id="bodyType-error" class="orange" style="display: none;">Body type is required.</div>
                                @error('bodyType')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="doorCount" class="form-label"  style="color:white">Model <span style="color:#FD5631">*</span></label>
                                <select class="form-select filter-style validate-field" name="doorcount" id="doorCount"required>
                              		<option value="">Any</option>
                                    <option value="2" {{ isset($post) && $post->doors == '2' ? 'selected' : '' }}>2
                                    </option>
                                    <option value="4" {{ isset($post) && $post->doors == '4' ? 'selected' : '' }}>4
                                    </option>
                                    <option value="5+" {{ isset($post) && $post->doors == '5+' ? 'selected' : '' }}>5+
                                    </option>
                                </select>
									 <div id="doorCount-error" class="orange" style="display: none;">Door count is required.</div>
                                @error('doorcount')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fuelType" class="form-label"  style="color:white">Year <span style="color:#FD5631">*</span></label>
                                <select class="form-select filter-style validate-field" name="fuelType" id="fuelType"required>
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
									<option value="LPG"
                                        {{ isset($post) && $post->fuel == 'LPG' ? 'selected' : '' }}>LPG</option>
									<option value="CNG"
                                        {{ isset($post) && $post->fuel == 'CNG' ? 'selected' : '' }}>CNG</option>
										<option value="Hybrid"
                                        {{ isset($post) && $post->fuel == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
									 <div id="fuelType-error" class="orange" style="display: none;">Fuel type is required.</div>
                                @error('fuelType')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="seatingCapacity" class="form-label"  style="color:white">Mileage (Km) <span style="color:#FD5631">*</span></label>
                            <input type="number" name="mileage" value="{{ $post->milleage ?? '' }}"
                                    class="form-control formcontrol validate-field" id="mileage" placeholder="e.g., 25000"
                                    min="0"required>
									 <div id="seatingCapacity-error" class="orange" style="display: none;">seating Capacity is required.</div>
                                @error('seatingCapacity')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="engineCapacity" class="form-label"  style="color:white">Body type <span style="color:#FD5631">*</span></label>
                                <select class="form-select filter-style validate-field" name="engineCapacity"
                                    id="engineCapacity"required>
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
									 <div id="engineCapacity-error" class="orange" style="display: none;">Engine Capacity is required.</div>
                                @error('engineCapacity')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="transmission" class="form-label"  style="color:white">Fuel type <span style="color:#FD5631">*</span></label>
                                <select class="form-select filter-style validate-field" name="transmission" id="transmission"required>
                                <option value="">Any</option>
                                    <option value="Automatic"
                                        {{ isset($post) && $post->transmission == 'Automatic' ? 'selected' : '' }}>
                                        Automatic
                                    </option>
                                    <option value="Manual"
                                        {{ isset($post) && $post->transmission == 'Manual' ? 'selected' : '' }}>Manual
                                    </option>
                                </select>
									 <div id="transmission-error" class="orange" style="display: none;">Transmission is required.</div>
                                @error('transmission')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="driveType" class="form-label"  style="color:white">Fuel capacity <span style="color:#FD5631">*</span></label>
                                <select class="form-select filter-style validate-field" name="driveType" id="driveType"required>
                               		<option value="">Any</option>
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
									 <div id="driveType-error" class="orange" style="display: none;">driveType is required.</div>
                                @error('driveType')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="color" class="form-label"  style="color:white"> Color <span style="color:#FD5631">*</span></label>
                                <select class="form-select filter-style validate-field" name="exterior_color"
                                    id="exterior_color"required>
									<option value="">Any</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}"
                                            {{ isset($post) && $post->exterior_color == $color->id ? 'selected' : '' }}>
                                            {{ $color->name }}</option>
                                    @endforeach
                                </select>
								 <div id="exterior_color-error" class="orange" style="display: none;">exterior color is required.</div>
                                @error('exterior_color')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
						
                        </div>

				 </div>
						</div>
                     
                    </div>
                    <!-- Step 5: Vehicle Features -->

                    <div class="mb-3 p-3 rounded-4" style="background-color:#white; border:1px solid #0000001F">
                        <h4 class="step-header">Features</h4>

                        <div class="feature-section">
                            <h6>Tires & Wheels</h6>

                            <!-- Display existing features for the post -->


                            <div class=" row d-flex flex-wrap ">
                                <!-- Iterate over dynamic features -->
							
                            
									<div class=" col-4">
									   <div class="form-check me-5 ">
            <input type="checkbox" name=""
                class="form-check-input feature_checkbox" id=""
              >
            <label class="form-check-label"
                for="">Alloy wheels</label>
        </div></div>		
								<div class=" col-4">
									   <div class="form-check me-5 ">
            <input type="checkbox" name=""
                class="form-check-input feature_checkbox" id=""
              >
            <label class="form-check-label"
                for="">Tubeless</label>
        </div></div>
     	<div class=" col-4">
									   <div class="form-check me-5 ">
            <input type="checkbox" name=""
                class="form-check-input feature_checkbox" id=""
              >
            <label class="form-check-label"
                for="">Spokes</label>
        </div></div>
 
                        
                            </div>
                         
                        </div>


                        <div class="feature-section mt-4">
                            <h6>Braking System</h6>

                            <div class=" row d-flex flex-wrap">

                         
								<div class="col-4">
								    <div class="form-check me-5">
                                        <input type="checkbox" name=""
                                            class="form-check-input feature_checkbox" id=""
                                          >
                                        <label class="form-check-label"
                                            for="">Disc</label>
                                    </div>
								</div>
									<div class="col-4">
								    <div class="form-check me-5">
                                        <input type="checkbox" name=""
                                            class="form-check-input feature_checkbox" id=""
                                          >
                                        <label class="form-check-label"
                                            for="">Drum</label>
                                    </div>
								</div>
									<div class="col-4">
								    <div class="form-check me-5">
                                        <input type="checkbox" name=""
                                            class="form-check-input feature_checkbox" id=""
                                          >
                                        <label class="form-check-label"
                                            for="">ABS</label>
                                    </div>
								</div>
                          
                            </div>
                         

                          
                        </div>

                        <div class="feature-section mt-4">
                            <h6>Lighting System</h6>

                            <div class="row d-flex flex-wrap">

                            
								<div class="col-4">      <div class="form-check me-5">
                                        <input type="checkbox" name=""
                                            class="form-check-input feature_checkbox" id=""
                                          >
                                        <label class="form-check-label"
                                            for="">LED</label>
                                    </div></div>
									<div class="col-4">      <div class="form-check me-5">
                                        <input type="checkbox" name=""
                                            class="form-check-input feature_checkbox" id=""
                                          >
                                        <label class="form-check-label"
                                            for="">Halogen</label>
                                    </div></div>
									<div class="col-4">      <div class="form-check me-5">
                                        <input type="checkbox" name=""
                                            class="form-check-input feature_checkbox" id=""
                                          >
                                        <label class="form-check-label"
                                            for="">DRLs</label>
                                    </div></div>
                             
                            </div>
          

                            <!-- Add more safety features as needed -->
                        </div>
						    <div class="feature-section mt-4">
                            <h6>Safety Features</h6>

                            <div class="row d-flex flex-wrap">

                            
								<div class="col-4">      <div class="form-check me-5">
                                        <input type="checkbox" name=""
                                            class="form-check-input feature_checkbox" id=""
                                          >
                                        <label class="form-check-label"
                                            for="">ABS</label>
                                    </div></div>
									<div class="col-4">      <div class="form-check me-5">
                                        <input type="checkbox" name=""
                                            class="form-check-input feature_checkbox" id=""
                                          >
                                        <label class="form-check-label"
                                            for="">Traction Control</label>
                                    </div></div>
									<div class="col-4">      <div class="form-check me-5">
                                        <input type="checkbox" name=""
                                            class="form-check-input feature_checkbox" id=""
                                          >
                                        <label class="form-check-label"
                                            for="">Stand Sensor</label>
                                    </div></div>
                             
                            </div>
          

                            <!-- Add more safety features as needed -->
                        </div>
						    <div class="feature-section mt-4">
                            <h6>Technology & Connectivity</h6>

                            <div class="row d-flex flex-wrap">

                            
								<div class="col-4">      <div class="form-check me-5">
                                        <input type="checkbox" name=""
                                            class="form-check-input feature_checkbox" id=""
                                          >
                                        <label class="form-check-label"
                                            for="">Anti Theft Lock</label>
                                    </div></div>
									<div class="col-4">      <div class="form-check me-5">
                                        <input type="checkbox" name=""
                                            class="form-check-input feature_checkbox" id=""
                                          >
                                        <label class="form-check-label"
                                            for="">Navigation</label>
                                    </div></div>
									<div class="col-4">      <div class="form-check me-5">
                                        <input type="checkbox" name=""
                                            class="form-check-input feature_checkbox" id=""
                                          >
                                        <label class="form-check-label"
                                            for="">Smart Features</label>
                                    </div></div>
                             
                            </div>
          

                            <!-- Add more safety features as needed -->
                        </div>
               
                    </div>
                    <!-- Step 6: Upload Photos / Videos -->
                    <div class="mb-3 p-3 rounded-4" style="background-color:#white; border:1px solid #0000001F">
                        <h4 class="step-header">Photos</h4>

                        <p class="rounded p-3" style="background-color:#281F48; color: white; ">
							You can upload a minimum of <strong>5</strong> and a maximum of<strong> 30 </strong>photos. The maximum file size per photo is<strong> 8 MB</strong>. Allowed formats: <strong>JPEG, JPG, PNG</strong>.
                            
                        </p>

                        <div class="upload-area border border-dashed rounded p-4 text-center" ondrop="handleDrop(event)"
                            ondragover="event.preventDefault()" ondragleave="event.preventDefault()">
                            <i class="bi bi-cloud-arrow-up fs-1 primary-color-custom mb-3"></i>
                            <p class="mb-2">Maximum 30 files (images)</p>
                            {{-- <input type="file" id="fileUpload" class="d-none" name="filedata[]" multiple
                                accept=".jpg, .jpeg, .png, .mp4, .mov"
                                onchange="handleFiles(this.files), handleAdPreview(this.files)"> --}}


                                <input type="file" id="fileUpload" class="d-none" name="filedata[]" multiple
                                accept=".jpg, .jpeg, .png, .mp4, .mov"
                                onchange="handleImgUpload(this.files), handleAdPreview(this.files)">

                            <a class="btn btn-primary mt-3" style="background-color:#281F48 !important;" onclick="document.getElementById('fileUpload').click();">
                                Select Files
                            </a>
                        </div>
                        @error('filedata')
                            <div class="alert ">{{ $message }}</div>
                        @enderror
                        @if (isset($post->document))
                            @foreach ($post->document as $document)
                                @if ($document->doc_type == 'image')
                                    <img width="100px" height="100px" 
										   class="draggable-img"
											 style="width: 150px; cursor: grab;"
											 draggable="true"
											 data-index="{{ $loop->index }}"
                                        src="{{ asset('posts/doc/' . $document->doc_name) }}">
                                @endif
                                @if ($document->doc_type == 'video')
                                    <iframe src="{{ asset('posts/doc/' . $document->doc_name) }}"
                                        frameborder="0"></iframe>
                                @endif
                            @endforeach
                        @endif
                        <div id="previewContainer" class="mt-4 d-flex flex-wrap gap-3" ></div>
                    </div> 
                    <div class="mb-3 p-3 rounded-4"  style="background-color:#white; border:1px solid #0000001F">

                        <h4 class="step-header">Upload Documents <span style="color:#281F48; font-size:12px;"> (Optional)</span></h4>
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
                                <div id="brochurePreview" class="mt-3 " style="color:#FD5631"></div>
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
                                <div id="auctionSheetPreview" class="mt-3 " style="color:#FD5631"></div>
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
                    <div class="mb-3 p-3 rounded-4" style="background-color:#white; border:1px solid #0000001F">
                        <h4 class="mb-4 step-header" style="color:#FD5631">Location</h4>

                        <div class="row mb-3">
                         
                        <div class="col-md-6">
                            <label for="country" class="form-label"  style="color:white">Country / Region <span style="color:#FD5631">*</span></label>
                            <select id="country" name="country" class="form-select filter-style validate-field">
									  <option value="" disabled selected>Select Country</option>
                         
                                <option value=""></option>
                             
                                
                 
                            </select>
                     
                        </div>
                      
                            <input type="hidden" name="country" value="pakistan">
                            <div class="col-md-6">
                                <label for="state" class="form-label"  style="color:white">State <span style="color:#FD5631">*</span></label>
                                <select id="province" name="province" class="form-select filter-style validate-field"required>
                                    <option value="" disabled selected>Select province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ isset($post->location) && $post->location->province == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}</option>
                                    @endforeach

                                </select>
									 <div id="province-error" class="orange" style="display: none;">province is required.</div>
                                @error('province')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
							     <input type="hidden" name="country" value="pakistan">
                            <div class="col-md-8">
                                <label for="state" class="form-label"  style="color:white">City <span style="color:#FD5631">*</span></label>
                                <select id="province" name="province" class="form-select filter-style validate-field"required>
                                    <option value="" disabled selected>Select province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ isset($post->location) && $post->location->province == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}</option>
                                    @endforeach

                                </select>
									 <div id="province-error" class="orange" style="display: none;">province is required.</div>
                                @error('province')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
							   <input type="hidden" name="country" value="pakistan">
                            <div class="col-md-4">
                                <label for="state" class="form-label"  style="color:white">Area <span style="color:#FD5631">*</span></label>
                                <select id="province" name="province" class="form-select filter-style validate-field"required>
                                    <option value="" disabled selected>Select province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ isset($post->location) && $post->location->province == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}</option>
                                    @endforeach

                                </select>
									 <div id="province-error" class="orange" style="display: none;">province is required.</div>
                                @error('province')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
								   <input type="hidden" name="country" value="pakistan">
                            <div class="col-md-12">
                                <label for="state" class="form-label"  style="color:white">Street address <span style="color:#FD5631">*</span></label>
                                <select id="province" name="province" class="form-select filter-style validate-field"required>
                                    <option value="" disabled selected>Select province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ isset($post->location) && $post->location->province == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}</option>
                                    @endforeach

                                </select>
									 <div id="province-error" class="orange" style="display: none;">province is required.</div>
                                @error('province')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                  

                        <div class="mb-3 d-none">
                            <label for="map" class="form-label" >Display on the map <span style="color:#FD5631">*</span></label>
                        </div>

                        <div id="map" class="border rounded mb-3 d-none" style="height: 300px;">
                            <!-- <input type="text" id="location" name="location" class="form-control"
                                                        placeholder=""> -->
                        </div>
                    </div>
                    <!-- Step 9: Contacts -->

                    <div class="mb-3 p-3 rounded-4" style="background-color:#white; border:1px solid #0000001F">
                        <h4 class="step-header">Contacts</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label"  style="color:white">First Name <span style="color:#FD5631">*</span></label>
                                <input type="text" class="form-control formcontrol validate-field" name="firstName" id="firstName"
                                    placeholder="Enter First name"
                                    value="{{ $post->contact->first_name ?? '' }}"required>
								<div id="firstName-error" class="orange" style="display: none;">First Name is required.</div>
                                @error('firstName')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="secondName" class="form-label"  style="color:white">Second Name <span style="color:#FD5631">*</span></label>
                            <input type="text" class="form-control formcontrol validate-field" name="secondName" id="secondName"
    placeholder="Enter last name" required>
<div id="secondName-error" class="orange" style="display: none;">Second Name is required.</div>

                                @error('secondName')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label"  style="color:white">Email <span style="color:#FD5631">*</span></label>
                                <input type="email" class="form-control formcontrol" name="email" id="email"
                                    placeholder="Enter Email" value="{{ Auth::user()->email ?? '' }}"required readonly>
                                @error('email')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phoneNumber" class="form-label"  style="color:white">Phone Number <span style="color:#FD5631">*</span></label>
                                <input type="tel" class="form-control formcontrol" name="number" id="phoneNumber"
                                    placeholder="Enter phone number" value="{{ $post->contact->number ?? '' }}"  required >
								
                                @error('number')
                                    <div class="alert ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="website" class="form-label"  style="color:white">Website (Optional)</label>
                            <input type="url" class="form-control formcontrol" name="website" id="website"
                                placeholder="Enter website" pattern="https://.*"
                                value="{{ $post->contact->website ?? '' }}" >
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

                    <div class="mb-3" style="display:flex;justify-content:end">
                      {{--  <div>
                            <button type="button" class="btn rounded px-5 primary-color-custom py-2"
                                style="background-color: white;" onclick="scrolltop()">Preview</button>
                        </div> --}}
                        <div>
                            <input type="button" class="btn custom-btn-nav rounded px-5" value="Save and continue" style="background-color:#281F48 !important; color:white !important"
                                onclick="submitform();">
                            <input type="submit" class="btn custom-btn-nav rounded px-5 d-none" style="background-color:#281F48 !important; color:white !important"  value="Save and continue"
                                id="form_submit_btn">
                        </div>
                    </div>
                </form>
                <!-- Include Google Maps API (use your own API key) -->
                <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>

            </div>
            <div class="col-lg-4">
                <div class="wishlist-card">
                    <div class="img-bg-home">

                <img src="{{asset('web/images/Group 1171275357.png')}}" class="img-adj-card" id="preview_img_post_ad">
                    </div>
                    <div class="py-lg-3 px-lg-4 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 id="yearsvalue">-----</h6>
                            <div>
                                <span class="rounded px-3 py-1 text-capitalize featured_label d-none"
                                    style="background-color:#BF0000; font-size:12px; "><img
                                        src="{{ asset('web/images/star-icon.svg') }}"
                                        class="me-2 mb-1 img-fluid">featured</span>
                                <span class="rounded px-3 py-1 text-capitalize vehicleConditionvaluecolor" id="vehicleConditionvalue"
                                    style="background-color:#4581F9; font-size:12px;">-----</span>
                            </div>
                        </div>

                        <h4 id="vehiclename">-----</h4>
                        <h5 style="color: #FD5631;"><b id="priceInputvalue">PKR -----</b></h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"> <i class="bi bi-geo-alt"></i>
                                <span id="cityvalue">-----</span>
                            </h6>
                            <span style="font-size:11px;">Last Updated:
                                {{ \carbon\carbon::parse(date('Y-M-d'))->format('F d, Y') }}</span>
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
                                    <h6 id="transmission_value" style="font-size:14px">-----</h6>
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
                            <h5 style="color: #FD5631;">Features</h5>
                            <div class="row mt-3">
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-fan"></i> Air Conditioning
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-shield-shaded"></i> Air Bags
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-cassette-fill"></i> Cassette Player
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-thermometer-half"></i> Cool Box
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-speedometer2"></i> Cruise Control
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-disc"></i> DVD Player
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-speaker"></i> Front Speaker
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-camera-video"></i> Front Camera
                                </div>
                                <div class="col-md-6 feature-item ">
                                    <i class="bi bi-key "></i> Keyless Entry
                                </div>
                             <div class="col-md-6 feature-item ">
								 <i class="bi bi-shield"></i> <span style="color:white">Immobilizer Key</span>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewLabel">Preview Your Ad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="previewContent">
                        <!-- Preview content will be populated here via JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn custom-btn-nav" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary" onclick="document.getElementById('adForm').submit();">Confirm & Submit</button> -->
                </div>
            </div>
        </div>
    </div>
<!-- Bootstrap Modal -->
<div class="modal fade" id="imageValidationModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content " style="border-radius: 10px; overflow: hidden;">
            <div class="modal-header" style="background-color: #FD5631; color: white; border-bottom: none;">
                <h5 class="modal-title" id="modalTitle">Image Upload Error</h5>
                <button type="button" class="btn-close"  style="background-color: white; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p class="m-0" id="modalMessage">Please upload at least 5 and at most 30 images.</p>
            </div>
            <div class="modal-footer justify-content-end border-0">
                <button type="button" class="custom-btn-nav" style="color:white; background-color:#FD5631;padding:5px 20px; border:none;border-radius:5px" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
            <div class="modal-header" style="background-color: #FD5631; color: white; border-bottom: none;">
                <h5 class="modal-title" id="alertModalLabel">Invalid File Size</h5>
                <button type="button" class="btn-close" style="background-color: white; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="alertModalBody">
         
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="" style="color:white; background-color:#FD5631;padding:5px 20px; border:none;border-radius:5px" data-bs-dismiss="modal">Close</button>
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
document.addEventListener("DOMContentLoaded", function () {
    const previewContainer = document.getElementById("previewContainer");
    const previewAdImg = document.getElementById("preview_img_post_ad");

    let draggedElement = null;

    // Drag Start
    previewContainer.addEventListener("dragstart", (e) => {
        if (e.target.classList.contains("draggable-img")) {
            draggedElement = e.target.closest(".preview-item"); // Get the parent preview-item
            e.dataTransfer.setData("text/plain", ""); // Required for Firefox
            e.dataTransfer.effectAllowed = "move";
            console.log("Drag Start:", draggedElement);
        }
    });

    // Drag Over (Allow Drop)
    previewContainer.addEventListener("dragover", (e) => {
        e.preventDefault();
    });

    // Drop (Swap Images)
    previewContainer.addEventListener("drop", (e) => {
        e.preventDefault();

        // Ensure the target is an image and inside previewContainer
        const target = e.target.closest(".draggable-img");
        const targetItem = target ? target.closest(".preview-item") : null;

        //console.log('Dropped target:', targetItem);

        // Check if the target element is valid and a child of previewContainer
        if (targetItem && draggedElement !== targetItem && previewContainer.contains(targetItem)) {
            const items = Array.from(previewContainer.querySelectorAll(".preview-item"));
            const draggedIndex = items.indexOf(draggedElement);
            const targetIndex = items.indexOf(targetItem);

            console.log("Dragged Index:", draggedIndex, "Target Index:", targetIndex);

            if (draggedIndex !== -1 && targetIndex !== -1) {
                swapItems(draggedElement, targetItem);
            } else {
                console.log("Error: Invalid drag or target element");
            }
        } else {
            console.log("Target element is not a valid draggable item.");
        }
    });

    // Swap Function
    function swapItems(dragged, target) {
        console.log('Swapping:', dragged, target); // Debugging the swap

        if (dragged && target) {
            const parent = previewContainer;

            // Ensure that both dragged and target are still children of previewContainer
            if (parent.contains(dragged) && parent.contains(target)) {
                try {
                    // Insert the dragged element before the target
                    target.parentNode.insertBefore(dragged, target);

                    console.log('Preview-item swapped');
                } catch (error) {
                    console.log('Error inserting element:', error);
                }
            } else {
                console.log('Dragged or target element is not part of the parent container');
            }

            // Update the first image preview
            if (previewContainer.firstElementChild && previewContainer.firstElementChild.querySelector("img")) {
                previewAdImg.src = previewContainer.firstElementChild.querySelector("img").src;
                console.log('Updated preview image:', previewAdImg.src);
            }
        }
    }
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
			//console.log(previewAdImg);


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
            $('#vehicleConditionvalue').text(vehicleConditionvalue);
            if (vehicleConditionvalue == 'used') {
            $('.vehicleConditionvaluecolor').css({
                'background': 'green'
            });
            }else{
                $('.vehicleConditionvaluecolor').css({
                'background': '#4581F9'
            });
            }

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
        });
        // handling model 
        $('#model').change(function(e) {
            e.preventDefault();
			//alert('e');
            var modelvalue = $(this).find('option:selected').text();
            $('#modelvalue').text(modelvalue);
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


        function submitform() {
            const form = document.getElementById('adForm');
            const fileInput = document.getElementById('fileUpload');
            

            if (fileArray.length < 5 || fileArray.length > 30) {
            
            event.preventDefault(); // Prevent form submission
					let modal = new bootstrap.Modal(document.getElementById('imageValidationModal'));
            modal.show();
        //}
                //return false;
            } else {
                $('#form_submit_btn').click();
            }
        }




          let fileArray = []; // To track all selected files globally

function handleImgUpload(files) {
    const previewContainer = document.getElementById('previewContainer');
    const fileInput = document.getElementById('fileUpload'); // Get reference to file input

    // Append new files to the existing fileArray without duplicates
    const newFiles = Array.from(files).filter((file) => {
        return !fileArray.some((f) => f.name === file.name && f.size === file.size);
    });
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
                    //console.log('Remaining files:', fileArray);
                };

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                previewContainer.appendChild(wrapper);
				indexCounter++;
            };

            reader.readAsDataURL(file);
        } else {
function showAlert(message) {
    document.getElementById('alertModalBody').innerText = message;
    var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
    alertModal.show();
}

// Example Usage:
if (file.size > 8 * 1024 * 1024) {  // 8MB limit
    showAlert(`File "${file.name}" is invalid or exceeds the 8MB size limit!`);
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

// Optional: Function to get the final files for submission
function getSelectedFiles() {
    return fileArray;
}
    </script>


<script>
$(document).ready(function () {
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





<script>
    $(document).ready(function () {
        $(".validate-field").on("blur input", function () { 
            var inputVal = $(this).val().trim();
            var errorId = $(this).attr("id") + "-error"; // Dynamically get error field ID

            if (inputVal === "") {
                $("#" + errorId).show();
                $(this).addClass("is-invalid");
            } else {
                $("#" + errorId).hide();
                $(this).removeClass("is-invalid");
            }
        });

        // Prevent form submission if any field is empty
        $("form").on("submit", function (e) {
            var isValid = true;

            $(".validate-field").each(function () {
                var inputVal = $(this).val().trim();
                var errorId = $(this).attr("id") + "-error";

                if (inputVal === "") {
                    $("#" + errorId).show();
                    $(this).addClass("is-invalid");
                    isValid = false;
                } else {
                    $("#" + errorId).hide();
                    $(this).removeClass("is-invalid");
                }
            });

            if (!isValid) {
                e.preventDefault(); // Stop form submission if any field is empty
            }
        });
    });
</script>
















@endsection
