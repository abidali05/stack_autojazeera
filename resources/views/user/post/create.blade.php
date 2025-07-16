 @extends('layout.panel_layout.main')
 @section('content')

     <style>
         .form-control {
             color: #281F48 !important;
         }

         .preview-item img,
         .preview-item video {
             width: 100%;
             height: 100%;
             object-fit: cover;
         }

         /* Preview Container */
         #previewContainer {
             display: flex;
             flex-wrap: wrap;
             gap: 12px;
             padding: 10px;
             border: 2px dashed #ccc;
             border-radius: 8px;
             min-height: 120px;
             background-color: #f9f9f9;
         }

         /* Each image block */
         .preview-item {
             position: relative;
             width: 100px;
             height: 100px;
             border: 2px solid #ddd;
             border-radius: 8px;
             overflow: hidden;
             transition: transform 0.2s ease-in-out;
             cursor: move;
             background-color: white;
             box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
         }

         /* Drag effect */
         .preview-item.dragging {
             opacity: 0.5;
             transform: scale(0.95);
         }

         /* Image styling */
         .preview-item img.draggable-img {
             width: 100%;
             height: 100%;
             object-fit: cover;
             pointer-events: none;
             /* So drag starts from wrapper, not image */
         }

         /* Close (remove) button */
         .preview-item button {
             position: absolute;
             top: 12px;
             right: 10px;
             width: 22px;
             height: 22px;
             background-color: #FD5631;
             color: white;
             border: none;
             border-radius: 50%;
             font-size: 14px;
             font-weight: bold;
             line-height: 1;
             padding: 0;
             display: flex;
             justify-content: center;
             align-items: center;
             cursor: pointer;
         }

         .preview-item button:hover {
             background-color: #e24724;
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
         .registeredDealer+.registeredDealer1 {
             position: relative;
             padding-left: 30px;
             cursor: pointer;
             display: inline-block;
             color: #fff;
             /* Text color */
             font-size: 16px;
         }

         /* Outer circle */
         .registeredDealer+.registeredDealer1::before {
             content: '';
             position: absolute;
             left: 0;
             top: 50%;
             transform: translateY(-50%);
             width: 20px;
             height: 20px;
             border: 2px solid #FD5631;
             /* Border color */
             border-radius: 50%;
             /* Makes it a circle */
             background-color: #2E2D3C;
             /* Background color */
             transition: all 0.3s ease;
         }

         /* Inner circle when checked */
         .registeredDealer:checked+.registeredDealer1::after {
             content: '';
             position: absolute;
             left: 5px;
             top: calc(50% + 0px);
             transform: translateY(-50%);
             width: 10px;
             height: 10px;
             background-color: #FD5631;
             /* Inner circle color */
             border-radius: 50%;
         }

         /* Hide the default radio button */
         .privateDealer {
             position: absolute;
             opacity: 0;
         }

         /* Custom radio button styling */
         .privateDealer+.privateDealer1 {
             position: relative;
             padding-left: 30px;
             cursor: pointer;
             display: inline-block;
             color: #fff;
             /* Text color */
             font-size: 16px;
         }

         /* Outer circle */
         .privateDealer+.privateDealer1::before {
             content: '';
             position: absolute;
             left: 0;
             top: 50%;
             transform: translateY(-50%);
             width: 20px;
             height: 20px;
             border: 2px solid #FD5631;
             /* Border color */
             border-radius: 50%;
             /* Makes it a circle */
             background-color: #2E2D3C;
             /* Background color */
             transition: all 0.3s ease;
         }

         /* Inner circle when checked */
         .privateDealer:checked+.privateDealer1::after {
             content: '';
             position: absolute;
             left: 5px;
             top: calc(50% + 0px);
             transform: translateY(-50%);
             width: 10px;
             height: 10px;
             background-color: #FD5631;
             /* Inner circle color */
             border-radius: 50%;
         }

         .feature_checkbox {
             width: 20px;
             height: 20px;
             background-color: transparent;
             border: 2px solid #00000080;
             border-radius: 4px;
             cursor: pointer;
             transition: all 0.3s ease;
         }

         .feature_checkbox:checked {
             background-color: #281F48;
             border-color: #281F48;
         }

         .feature_ad {
             width: 20px;
             height: 20px;
             background-color: transparent;
             border: 2px solid #00000080;
             border-radius: 4px;
             cursor: pointer;
             transition: all 0.3s ease;
         }

         .feature_ad:checked {
             background-color: #281F48;
             border-color: #281F48;
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
             border: none;
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

         .form-select {
             width: 100% !important;
             max-width: 100%;
             background-color: white !important;
             border: 1px solid #0000001F !important;
             color: #281F48 !important;
             text-align: start;
         }

         .formcontrol {
             color: #281F48 !important;
         }
     </style>
     <!-- back header start -->
     <div class="container mt-5">
         <div class="row align-items-center mb-4">

             <div class="col-md-12">
                 <h2 class="sec mb-0 primary-color-custom">Post An Ad</h2>
             </div>

         </div>
     </div>
     <div class="container">
         <div class="row  pt-md-3">
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
                 <form id="adFormasas" method="post" action="{{ route('ads.store') }}" enctype="multipart/form-data">
                     @csrf

                     <!-- Step 2: Basic Info -->
                     <input type="hidden" value="{{ Auth::user()->id }}" name="dealer">
                     <input type="hidden" name="latitude" id="latitude">
                     <input type="hidden" name="longitude" id="longitude">
                     <div class="mb-3 p-3 rounded borderallpost">
                         <h4 class="step-header">Basic Info</h4>
                         <div class="mb-3 d-none">
                             <label for="adTitle" class="form-label">Title *</label>
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
                                 <label for="vehicleCondition" class="form-label" style="color:white">Vehicle Condition<span
                                         class="m-0 fs-5" style="color:#FD5631">*</span></label>
                                 <select class="form-select vehicleCondition  validate-field" id="vehicleCondition"
                                     name="condition" required>
                                     <option value="">Any</option>
                                     <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New
                                     </option>
                                     <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>
                                         Used</option>
                                 </select>
                                 <div id="vehicleCondition-error" class="orange" style="display: none;">Vehicle Condition is
                                     required.</div>
                                 @error('condition')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                             <div class="col-lg-6">
                                 <label for="assembly" class="form-label" style="color:white">Assembly <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select class="form-select assembly  validate-field" name="assembly"
                                     id="assembly"required>
                                     <option value="">Any</option>
                                     <option value="local" {{ old('assembly') == 'local' ? 'selected' : '' }}>
                                         Local</option>
                                     <option value="imported" {{ old('assembly') == 'imported' ? 'selected' : '' }}>
                                         Imported
                                     </option>
                                 </select>
                                 <div id="assembly-error" class="" style="display: none; color:#FD5631">Assembly is
                                     required.</div>
                                 @error('assembly')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>
                         {{--  <div class="mb-3">
                            <label class="form-label"  style="color:white">What type of seller are you?</label>
                            <div class="form-check">
                                <input class="form-check-input registeredDealer"  type="radio" name="dealerType"
                                    id="registeredDealer" value="registered"
                                    {{ isset($post) && $post->company_conection == 'registered' ? 'checked' : '' }}
                                    checked>
                                <label class="form-check-label registeredDealer1" for="registeredDealer">I am a registered
                                    dealer</label>

                            </div>
                            <div class="form-check">
                                <input class="form-check-input privateDealer" type="radio" name="dealerType"
                                    id="privateDealer" value="private"
                                    {{ isset($post) && $post->company_conection == 'private' ? 'checked' : '' }}>
                                <label class="form-check-label privateDealer1" for="privateDealer">I am a private
                                    dealer</label>
                            </div>
                            @error('dealerType')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div> --}}
                     </div>

                     <!-- Step 3: Currency & Price -->
                     <div class="mb-3 p-3 rounded borderallpost">
                         <h4 class="step-header">Price</h4>
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
                                 <label for="priceInput" class="form-label">Price <span style="color:#FD5631"
                                         class="m-0 fs-5">*</span></label>
                                 <input type="number" class="form-control formcontrol validate-field" name="price"
                                     id="priceInput" placeholder="Enter price" min="0"
                                     value="{{ old('price') ?? '' }}" style="color:#281F48 !important" required>
                                 <div id="priceInput-error" class="orange" style="display: none;">Price is required.
                                 </div>
                                 @error('price')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>
                         {{--  <div class="form-check mb-3">
                            <input class="form-check-input custom-switch me-3 " name="negotiatedPrice" type="checkbox" id="negotiatedPrice"
                                {{ isset($post) && $post->negotiatedPrice == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="negotiatedPrice">Negotiated Price</label>
                            @error('negotiatedPrice')
                                <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div> --}}
                     </div>
                     <!-- Step 4: Vehicle Information -->
                     <div class="mb-3 p-3 rounded borderallpost">
                         <h4 class="step-header">Vehicle information</h4>
                         <input type="hidden" name="step4" value="step4">
                         <div class="row mb-3">
                             <div class="col-md-6">
                                 <label for="make" class="form-label" style="color:white">Make <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select class="form-select  validate-field" name="makecompany"
                                     id="makecompanydata"required>
                                     <option value="">Any</option>
                                     @foreach ($makes as $make)
                                         <option value="{{ $make->id }}"
                                             {{ old('makecompany') == $make->id ? 'selected' : '' }}>
                                             {{ $make->name }}</option>
                                     @endforeach
                                 </select>
                                 <div id="makecompanydata-error" class="orange" style="display: none;">Make is required.
                                 </div>
                                 @error('makecompany')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                             <div class="col-md-6">

                                 <label for="model" class="form-label" style="color:white">Model <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select class="form-select  validate-field" name="model" id="model"required>
                                     <option value="">Any</option>


                                 </select>
                                 <div id="model-error" class="orange" style="display: none;">Model is required.</div>
                                 @error('model')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>

                         <div class="row mb-3">
                             <div class="col-md-6">
                                 <label for="year" class="form-label" style="color:white">Year <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select class="form-select  validate-field" name="year" id="years"required>
                                     <option value="">Any</option>
                                     @for ($year = now()->year; $year >= 1960; $year--)
                                         <option value="{{ $year }}"
                                             {{ old('year') == $year ? 'selected' : '' }}>
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
                                 <label for="mileage" class="form-label" style="color:white">Mileage (Km) <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <input type="number" name="mileage" value="{{ old('milleage') ?? '' }}"
                                     class="form-control formcontrol validate-field" id="mileage"
                                     style="color:#281F48 !important" placeholder="e.g., 25000" min="0"required>
                                 <div id="mileage-error" class="orange" style="display: none;">Mileage is required.</div>
                                 @error('mileage')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>

                         <div class="row mb-3">
                             <div class="col-md-6">
                                 <label for="bodyType" class="form-label" style="color:white">Body Type <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select class="form-select  validate-field" name="bodyType" id="bodyType"required>
                                     <option value="">Any</option>
                                     @foreach ($bodytypes as $bodytype)
                                         <option value="{{ $bodytype->id }}"
                                             {{ old('bodyType') == $bodytype->id ? 'selected' : '' }}>
                                             {{ $bodytype->name }}</option>
                                     @endforeach
                                 </select>
                                 <div id="bodyType-error" class="orange" style="display: none;">Body type is required.
                                 </div>
                                 @error('bodyType')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                             <div class="col-md-6">
                                 <label for="doorCount" class="form-label" style="color:white">Door Count <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select class="form-select  validate-field" name="doorcount" id="doorCount"required>
                                     <option value="">Any</option>
                                     <option value="2" {{ old('doorcount') == '2' ? 'selected' : '' }}>2
                                     </option>
                                     <option value="4" {{ old('doorcount') == '4' ? 'selected' : '' }}>4
                                     </option>
                                     <option value="5+" {{ old('doorcount') == '5+' ? 'selected' : '' }}>
                                         5+
                                     </option>
                                 </select>
                                 <div id="doorCount-error" class="orange" style="display: none;">Door count is required.
                                 </div>
                                 @error('doorcount')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>

                         <div class="row mb-3">
                             <div class="col-md-6">
                                 <label for="fuelType" class="form-label" style="color:white">Fuel Type <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select class="form-select  validate-field" name="fuelType" id="fuelType"required>
                                     <option value="">Any</option>
                                     <option value="Gasoline" {{ old('fuelType') == 'Gasoline' ? 'selected' : '' }}>
                                         Gasoline
                                     </option>
                                     <option value="Diesel" {{ old('fuelType') == 'Diesel' ? 'selected' : '' }}>
                                         Diesel</option>
                                     <option value="Electric" {{ old('fuelType') == 'Electric' ? 'selected' : '' }}>
                                         Electric
                                     </option>
                                     <option value="Petrol" {{ old('fuelType') == 'Petrol' ? 'selected' : '' }}>Petrol
                                     </option>
                                     <option value="LPG" {{ old('fuelType') == 'LPG' ? 'selected' : '' }}>
                                         LPG</option>
                                     <option value="CNG" {{ old('fuelType') == 'CNG' ? 'selected' : '' }}>
                                         CNG</option>
                                     <option value="Hybrid" {{ old('fuelType') == 'Hybrid' ? 'selected' : '' }}>Hybrid
                                     </option>
                                 </select>
                                 <div id="fuelType-error" class="orange" style="display: none;">Fuel type is required.
                                 </div>
                                 @error('fuelType')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                             <div class="col-md-6">
                                 <label for="seatingCapacity" class="form-label" style="color:white">Seating Capacity
                                     <span style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select class="form-select  validate-field" name="seatingCapacity"
                                     id="seatingCapacity"required>
                                     <option value="">Any</option>
                                     <option value="2" {{ old('seatingCapacity') == '2' ? 'selected' : '' }}>2
                                     </option>
                                     <option value="4" {{ old('seatingCapacity') == '4' ? 'selected' : '' }}>4
                                     </option>
                                     <option value="5+" {{ old('seatingCapacity') == '5+' ? 'selected' : '' }}>5+
                                     </option>
                                 </select>
                                 <div id="seatingCapacity-error" class="orange" style="display: none;">seating Capacity
                                     is required.</div>
                                 @error('seatingCapacity')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>

                         <div class="row mb-3">
                             <div class="col-md-6">
                                 <label for="engineCapacity" class="form-label" style="color:white">Engine Capacity <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select class="form-select  validate-field" name="engineCapacity"
                                     id="engineCapacity"required>
                                     <option value="">Any</option>
                                     <option value="1.6L" {{ old('engineCapacity') == '1.6L' ? 'selected' : '' }}>1.6L
                                     </option>
                                     <option value="2.0L" {{ old('engineCapacity') == '2.0L' ? 'selected' : '' }}>2.0L
                                     </option>
                                     <option value="3.0L+" {{ old('engineCapacity') == '3.0L+' ? 'selected' : '' }}>3.0L+
                                     </option>
                                 </select>
                                 <div id="engineCapacity-error" class="orange" style="display: none;">Engine Capacity is
                                     required.</div>
                                 @error('engineCapacity')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                             <div class="col-md-6">
                                 <label for="transmission" class="form-label" style="color:white">Transmission <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select class="form-select  validate-field" name="transmission"
                                     id="transmission"required>
                                     <option value="">Any</option>
                                     <option value="Automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>
                                         Automatic
                                     </option>
                                     <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual
                                     </option>
                                 </select>
                                 <div id="transmission-error" class="orange" style="display: none;">Transmission is
                                     required.</div>
                                 @error('transmission')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>

                         <div class="row mb-3">
                             <div class="col-md-6">
                                 <label for="driveType" class="form-label" style="color:white">Drive Type <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select class="form-select  validate-field" name="driveType" id="driveType"required>
                                     <option value="">Any</option>
                                     <option value="Front Wheel Drive"
                                         {{ old('driveType') == 'Front Wheel Drive' ? 'selected' : '' }}>
                                         Front
                                         Wheel Drive</option>
                                     <option value="Rear Wheel Drive"
                                         {{ old('driveType') == 'Rear Wheel Drive' ? 'selected' : '' }}>
                                         Rear
                                         Wheel Drive</option>
                                     <option value="All Wheel Drive"
                                         {{ old('driveType') == 'All Wheel Drive' ? 'selected' : '' }}>All
                                         Wheel Drive</option>
                                 </select>
                                 <div id="driveType-error" class="orange" style="display: none;">driveType is required.
                                 </div>
                                 @error('driveType')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                             <div class="col-md-6">
                                 <label for="color" class="form-label" style="color:white">Exterior Color <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select class="form-select  validate-field" name="exterior_color"
                                     id="exterior_color"required>
                                     <option value="">Any</option>
                                     @foreach ($colors as $color)
                                         <option value="{{ $color->id }}"
                                             {{ old('exterior_color') == $color->id ? 'selected' : '' }}>
                                             {{ $color->name }}</option>
                                     @endforeach
                                 </select>
                                 <div id="exterior_color-error" class="orange" style="display: none;">exterior color is
                                     required.</div>
                                 @error('exterior_color')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                             @if (Auth::user()->package != 'prod_RTgB3KyZygKo2I')
                                 <div class="form-check mb-3 m-2">
                                     <input class="form-check-input feature_ad" name="feature_ad" type="checkbox"
                                         id="feature_ad" {{ old('feature_ad') == 1 ? 'checked' : '' }}>
                                     <label class="form-check-label feature_ad1" for="feature_ad">Feature Ad</label>

                                 </div>
                             @endif
                         </div>

                         <div class="mb-3">
                             <label for="comments" class="form-label" style="color:white">Dealer Comments <span
                                     style="color:#FD5631" class="m-0 fs-5">*</span></label>
                             <textarea class="form-control formcontrol validate-field" name="dealer_comment" id="comments"
                                 style="color:#281F48 !important ;     line-height: 1 !important;" rows="4" maxlength="3000"
                                 placeholder="Describe your vehicle. These comments will be displayed on your ad." required>{{ old('dealer_comment') ?? '' }}</textarea>
                             <div id="comments-error" class="orange" style="display: none;">comment is required.</div>
                             <!-- <div class="char-counter" id="commentCharCount">3000 characters left</div> -->
                             @error('dealer_comment')
                                 <div class="alert ">{{ $message }}</div>
                             @enderror
                         </div>
                     </div>
                     <!-- Step 5: Vehicle Features -->

                     <div class="mb-3 p-3 rounded borderallpost">
                         <h4 class="step-header">Features<span class="text-danger " class="m-0 fs-5">*</span> </h4>

                         <div class="feature-section">
                             <h6>Exterior</h6>

                             <!-- Display existing features for the post -->


                             <div class=" row d-flex flex-wrap ">
                                 <!-- Iterate over dynamic features -->
                                 <option value="">Any</option>
                                 @foreach ($features->where('feature', 'Exterior') as $feature)
                                     @php
                                         $isChecked = old("Features.Exterior.{$feature->Sub_feature}") ? 'checked' : '';
                                     @endphp
                                     <div class="col-4">
                                         <div class="form-check me-5">
                                             <input type="checkbox"
                                                 name="Features[Exterior][{{ $feature->Sub_feature }}]"
                                                 class="form-check-input feature_checkbox"
                                                 id="feature_{{ $feature->id }}" {{ $isChecked }}>
                                             <label class="form-check-label" for="feature_{{ $feature->id }}">
                                                 {{ $feature->Sub_feature }}
                                             </label>
                                         </div>
                                     </div>
                                 @endforeach

                             </div>
                             @error('Features["Exterior"]')
                                 <div class="alert alert-danger">{{ $message }}</div>
                             @enderror
                         </div>


                         <div class="feature-section mt-4">
                             <h6>Interior</h6>

                             <div class=" row d-flex flex-wrap">

                                 @foreach ($features->where('feature', 'Interior') as $feature)
                                     @php
                                         $isChecked = old("Features.Interior.{$feature->Sub_feature}") ? 'checked' : '';
                                     @endphp
                                     <div class="col-4">
                                         <div class="form-check me-5">
                                             <input type="checkbox"
                                                 name="Features[Interior][{{ $feature->Sub_feature }}]"
                                                 class="form-check-input feature_checkbox"
                                                 id="feature_{{ $feature->id }}" {{ $isChecked }}>
                                             <label class="form-check-label" for="feature_{{ $feature->id }}">
                                                 {{ $feature->Sub_feature }}
                                             </label>
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
                             <h6>Safety</h6>

                             <div class="row d-flex flex-wrap">

                                 @foreach ($features->where('feature', 'Safety') as $feature)
                                     @php
                                         $isChecked = old("Features.Safety.{$feature->Sub_feature}") ? 'checked' : '';
                                     @endphp
                                     <div class="col-4">
                                         <div class="form-check me-5">
                                             <input type="checkbox" name="Features[Safety][{{ $feature->Sub_feature }}]"
                                                 class="form-check-input feature_checkbox"
                                                 id="feature_{{ $feature->id }}" {{ $isChecked }}>
                                             <label class="form-check-label" for="feature_{{ $feature->id }}">
                                                 {{ $feature->Sub_feature }}
                                             </label>
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
                     <div class="upload-area border border-dashed rounded p-4 text-center" id="customDropzone"
                         ondrop="handleDrop(event)" ondragover="event.preventDefault()"
                         ondragleave="event.preventDefault()" style="cursor: pointer;">
                         <i class="bi bi-cloud-arrow-up fs-1 primary-color-custom mb-3"></i>
                         <p class="mb-2">Maximum 30 files (images or videos)</p>

                         <input type="file" id="fileUpload" class="d-none" name="filedata[]" multiple
                             accept=".jpg, .jpeg, .png, .mp4, .mov" onchange="handleImgUpload(this.files)">

                         <a class="btn mt-3" style="background-color:#281F48; color:white"
                             onclick="document.getElementById('fileUpload').click();">
                             Select Files
                         </a>
                     </div>

                     <div id="previewContainer" class="mt-4 d-flex flex-wrap gap-3"></div>
                     <div id="uploadError" class="text-danger mt-2"></div>


                     <div class="mb-3 p-3 rounded borderallpost">

                         <h4 class="step-header">Upload Documents <span style="color:#FFFFFF; font-size:12px;">
                                 (Optional)</span></h4>
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
                                     <input type="file" id="auctionSheetUpload" name="document_auction"
                                         class="d-none" accept=".pdf"
                                         onchange="handleDocumentUpload(this, 'auctionSheetPreview')">
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
                     <div class="mb-3 p-3 rounded borderallpost">
                         <h4 class="mb-4 step-header" style="color:#FD5631">Location</h4>

                         <div class="row mb-3">
                             {{--
                        <div class="col-md-6">
                            <label for="country" class="form-label"  style="color:white">Country / Region <span style="color:#FD5631">*</span></label>
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
                                 <label for="state" class="form-label" style="color:white">Province <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select id="province" name="province" class="form-select  validate-field"required>
                                     <option value="" disabled selected>Any</option>
                                     @foreach ($provinces as $province)
                                         <option value="{{ $province->id }}"
                                             {{ old('province') == $province->id ? 'selected' : '' }}>
                                             {{ $province->name }}</option>
                                     @endforeach

                                 </select>
                                 <div id="province-error" class="orange" style="display: none;">province is required.
                                 </div>
                                 @error('province')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>

                         <div class="row mb-3">
                             <div class="col-md-12">
                                 <label for="city" class="form-label" style="color:white">City <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <select id="city" name="city" class="form-select  validate-field" required>
                                     <option value="" disabled selected>Any</option>
                                     @foreach ($cities as $city)
                                         @if (old('city') == $city->id)
                                             <option value="{{ $city->id }}">{{ $city->name }}</option>
                                         @endif
                                     @endforeach
                                 </select>
                                 <div id="city-error" class="orange" style="display: none;">city is required.</div>
                                 @error('city')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>

                             <div class="col-md-6 d-none">
                                 <label for="area" class="form-label" style="color:white">Area <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <input type="number" id="area" name="area"
                                     class="form-control formcontrol validate-field" placeholder="Enter Area code"
                                     value="default area" style="color:#281F48">
                                 <div id="area-error" class="orange" style="display: none;">Area is required.</div>
                             </div>

                         </div>

                         <div class="mb-3">
                             <label for="streetAddress" class="form-label" style="color:white">
                                 Street Address <span style="color:#FD5631" class="m-0 fs-5">*</span>
                             </label>
                             <input type="text" id="streetAddress" name="street_address"
                                 class="form-control formcontrol validate-field" style="color:#281F48 !important"
                                 placeholder="Enter Address" autocomplete="off" required
                                 value="{{ old('street_address') }}" />
                             <div id="streetAddress-error" class="orange" style="display: none;">Street address is
                                 required.</div>
                         </div>

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

                     <div class="mb-3 p-3 borderallpost rounded">
                         <h4 class="step-header">Contacts</h4>
                         <div class="row mb-3">
                             <div class="col-md-6">
                                 <label for="firstName" class="form-label" style="color:white">First Name <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <input type="text" class="form-control formcontrol validate-field"
                                     style="color:#281F48 !important" name="firstName" id="firstName"
                                     placeholder="Enter First name" value="{{ old('firstName') }}"required>
                                 <div id="firstName-error" class="orange" style="display: none;">First Name is required.
                                 </div>
                                 @error('firstName')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                             <div class="col-md-6">
                                 <label for="secondName" class="form-label" style="color:white">Second Name <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <input type="text" class="form-control formcontrol validate-field"
                                     style="color:#281F48 !important" name="secondName" id="secondName"
                                     placeholder="Enter last name" required value="{{ old('secondName') }}">
                                 <div id="secondName-error" class="orange" style="display: none;">Second Name is
                                     required.</div>

                                 @error('secondName')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>

                         <div class="row mb-3">
                             <div class="col-md-6">
                                 <label for="email" class="form-label" style="color:white">Email <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <input type="email" class="form-control formcontrol" style="color:#281F48 !important"
                                     name="email" id="email" placeholder="Enter Email"
                                     value="{{ Auth::user()->email ?? '' }}"required readonly>
                                 @error('email')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                             <div class="col-md-6">
                                 <label for="phoneNumber" class="form-label" style="color:white">Phone Number <span
                                         style="color:#FD5631" class="m-0 fs-5">*</span></label>
                                 <input type="tel" class="form-control formcontrol" name="number" id="phoneNumber"
                                     placeholder="Enter phone number" style="color:#281F48 !important"
                                     value="{{ old('number') ?? '' }}" required>

                                 @error('number')
                                     <div class="alert ">{{ $message }}</div>
                                 @enderror
                             </div>
                         </div>

                         <div class="mb-3 d-none">
                             <label for="website" class="form-label" style="color:white">Website</label>
                             <input type="url" class="form-control formcontrol" style="color:#281F48 !important"
                                 name="website" id="website" placeholder="Enter website" pattern="https://.*"
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

                     <div class="mb-3" style="display:flex;justify-content:end">
                         {{--  <div>
                            <button type="button" class="btn rounded px-5 primary-color-custom py-2"
                                style="background-color: white;" onclick="scrolltop()">Preview</button>
                        </div> --}}
                         <div>
                             <input type="button" class="btn custom-btn-nav rounded px-5" value="Save and continue"
                                 onclick="submitform();">
                             <input type="submit" class="btn custom-btn-nav rounded px-5 d-none"
                                 value="Save and continue" id="form_submit_btn">
                         </div>
                     </div>
                 </form>
             </div>
             <div class="col-lg-4">
                 <div class="">
                     <div class="img-bg-home">

                         <img src="{{ asset('web/images/Group 1171275357.png') }}" class="img-adj-card"
                             id="preview_img_post_ad">
                     </div>
                     <div class="py-lg-3 px-lg-4 p-3">
                         <div class="d-flex justify-content-between align-items-center">
                             <h6 id="yearsvalue">-----</h6>
                             <div>
                                 <span class="rounded px-3 py-1 text-capitalize featured_label d-none"
                                     style="background-color:#BF0000; font-size:12px; "><img
                                         src="{{ asset('web/images/star-icon.svg') }}"
                                         class="me-2 mb-1 img-fluid">featured</span>
                                 <span class="rounded px-3 py-1 text-capitalize vehicleConditionvaluecolor"
                                     id="vehicleConditionvalue"
                                     style="background-color:#4581F9; font-size:12px;">-----</span>
                             </div>
                         </div>

                         <h4 id="vehiclename" style="color:#281F48">-----</h4>
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
                             <h5 style="color: #FD5631;">Features<span class="text-danger">*</span></h5>
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
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <!-- <button type="button" class="btn btn-primary" onclick="document.getElementById('adFormasas').submit();">Confirm & Submit</button> -->
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
                     <button type="button" class="btn-close" style="background-color: white; color: #FD5631;"
                         data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body text-center p-4">
                     <p class="m-0" id="modalMessage">Please upload at least 5 and at most 30 images.</p>
                 </div>
                 <div class="modal-footer justify-content-end border-0">
                     <button type="button" class=""
                         style="color:white; background-color:#FD5631;padding:5px 20px; border:none;border-radius:5px"
                         data-bs-dismiss="modal">OK</button>
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
                     <button type="button" class="btn-close" style="background-color: white; color: #FD5631;"
                         data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body text-center" id="alertModalBody">

                 </div>
                 <div class="modal-footer border-0 pt-0">
                     <button type="button" class=""
                         style="color:white; background-color:#FD5631;padding:5px 20px; border:none;border-radius:5px"
                         data-bs-dismiss="modal">Close</button>
                 </div>
             </div>
         </div>
     </div>

     <!-- jQuery Validation plugin -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

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
             $("#adFormasas").validate({
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
                         minlength: 10
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
                         required: "Please select assembly"
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
                         minlength: "Comments must be at least 10 characters long"
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
                         pattern: "Enter valid  number in format: +92 3XX XXXXXXX"
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

                     // Check if we have enough images
                     if (fileArray.length < 5) {
                         let modal = new bootstrap.Modal(document.getElementById(
                             'imageValidationModal'));
                         document.getElementById('modalMessage').textContent =
                             `You have ${fileArray.length} images. Please ensure you have at least 5 images.`;
                         modal.show();
                         return false;
                     }

                     if (fileArray.length > 30) {
                         let modal = new bootstrap.Modal(document.getElementById(
                             'imageValidationModal'));
                         document.getElementById('modalMessage').textContent =
                             `You have ${fileArray.length} images. Maximum allowed is 30 images.`;
                         modal.show();
                         return false;
                     }

                     // If validation passes and image count is correct, submit the form
                     form.submit();
                 }
             });

             // Custom validation for phone number format
             $.validator.addMethod("pattern", function(value, element, param) {
                 return this.optional(element) || param.test(value);
             }, "Please enter a valid phone number");

             // Update submitform function to use jQuery validation
             window.submitform = function() {
                 // First, check if the form is valid according to the standard validation rules
                 var isFormValid = $("#adFormasas").valid();

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
                 if (fileArray.length < 5 || fileArray.length > 30) {
                     let modal = new bootstrap.Modal(document.getElementById('imageValidationModal'));
                     document.getElementById('modalMessage').textContent =
                         `You have ${fileArray.length} images. Please ensure you have between 5 and 30 images.`;
                     modal.show();
                     return false;
                 }

                 // If all validations pass, submit the form
                 $('#form_submit_btn').click();
             };

             // Add feature checkbox change handler to hide error when any checkbox is selected
             $('.feature_checkbox').on('change', function() {
                 if ($('.feature_checkbox:checked').length > 0) {
                     $('#features-error').hide();
                 }
             });
         });
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
             } else {
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
             $('#vehiclename').text(makecompanydatavalue);
         });
         // handling model 
         $('#model').change(function(e) {
             e.preventDefault();
             //alert('e');
             var modelvalue = $(this).find('option:selected').text();

             $('#modelvalue').text(modelvalue);
             modelvalue = $('#makecompanydatavalue').text() + ' ' + modelvalue;
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
             const form = document.getElementById('adFormasas');
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



         let fileArray = [];
         const maxFiles = 30;
         const maxSize = 8 * 1024 * 1024; // 8MB
         const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'video/mp4', 'video/quicktime'];
         let draggedItem = null;

         function handleImgUpload(files) {
             const previewContainer = document.getElementById('previewContainer');
             const errorDiv = document.getElementById('uploadError');
             errorDiv.textContent = '';

             let newFiles = Array.from(files).filter(file => {
                 return !fileArray.some(f => f.name === file.name && f.size === file.size);
             });

             if (fileArray.length + newFiles.length > maxFiles) {
                 errorDiv.textContent = `You can upload a maximum of ${maxFiles} files.`;
                 return;
             }

             newFiles.forEach(file => {
                 if (!allowedTypes.includes(file.type)) {
                     errorDiv.textContent = `File "${file.name}" is not an allowed format.`;
                     return;
                 }

                 if (file.size > maxSize) {
                     errorDiv.textContent = `File "${file.name}" exceeds 8MB size limit.`;
                     return;
                 }

                 fileArray.push(file);
                 createPreview(file);
             });

             updateFileInput();
         }

         function createPreview(file) {
             const previewContainer = document.getElementById('previewContainer');

             const wrapper = document.createElement('div');
             wrapper.className = 'preview-item';
             wrapper.setAttribute('data-filename', file.name);
             wrapper.setAttribute('data-filesize', file.size);
             wrapper.setAttribute('draggable', true);

             // Drag behavior
             wrapper.addEventListener('dragstart', (e) => {
                 draggedItem = wrapper;
                 wrapper.style.opacity = '0.5';
             });

             wrapper.addEventListener('dragend', (e) => {
                 draggedItem = null;
                 wrapper.style.opacity = '1';
             });

             wrapper.addEventListener('dragover', (e) => {
                 e.preventDefault();
             });

             wrapper.addEventListener('drop', (e) => {
                 e.preventDefault();
                 if (draggedItem && draggedItem !== wrapper) {
                     const container = document.getElementById('previewContainer');
                     container.insertBefore(draggedItem, wrapper);
                     reorderFileArray();
                 }
             });

             let preview;
             if (file.type.startsWith('image/')) {
                 const img = document.createElement('img');
                 const reader = new FileReader();
                 reader.onload = e => {
                     img.src = e.target.result;
                 };
                 reader.readAsDataURL(file);
                 preview = img;
             } else {
                 const video = document.createElement('video');
                 video.controls = true;
                 const reader = new FileReader();
                 reader.onload = e => {
                     video.src = e.target.result;
                 };
                 reader.readAsDataURL(file);
                 preview = video;
             }

             const removeBtn = document.createElement('button');
             removeBtn.innerHTML = '×';
             removeBtn.type = 'button';
             removeBtn.className = 'btn btn-sm btn-danger  rounded-circle';
             removeBtn.style.transform = 'translate(50%, -50%)';
             removeBtn.onclick = () => {
                 wrapper.remove();
                 fileArray = fileArray.filter(f => !(f.name === file.name && f.size === file.size));
                 updateFileInput();
             };

             wrapper.appendChild(preview);
             wrapper.appendChild(removeBtn);
             previewContainer.appendChild(wrapper);
         }

         function handleDrop(event) {
             event.preventDefault();
             if (event.dataTransfer.files.length) {
                 handleImgUpload(event.dataTransfer.files);
             }
         }

         function updateFileInput() {
             const fileInput = document.getElementById('fileUpload');
             const dt = new DataTransfer();
             fileArray.forEach(file => dt.items.add(file));
             fileInput.files = dt.files;
         }

         function reorderFileArray() {
             const container = document.getElementById('previewContainer');
             const orderedWrappers = container.querySelectorAll('[data-filename]');
             const newOrder = [];

             orderedWrappers.forEach(wrapper => {
                 const name = wrapper.getAttribute('data-filename');
                 const size = parseInt(wrapper.getAttribute('data-filesize'));
                 const file = fileArray.find(f => f.name === name && f.size === size);
                 if (file) newOrder.push(file);
             });

             fileArray = newOrder;
             updateFileInput();
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

     <script>
         document.addEventListener("DOMContentLoaded", function() {
             if (navigator.geolocation) {
                 navigator.geolocation.getCurrentPosition(function(position) {
                     document.getElementById("latitude").value = position.coords.latitude;
                     document.getElementById("longitude").value = position.coords.longitude;
                     getAddressFromCoordinates(position.coords.latitude, position.coords.longitude, function(
                         address) {
                         if (address) {
                             //  document.getElementById("streetAddress").value = address;
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
         const GOOGLE_MAPS_API_KEY = "{{ config('services.google_maps.key') }}";
         async function getAddressFromCoordinates(lat, lng, callback) {
             try {
                 const response = await fetch(
                     `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${GOOGLE_MAPS_API_KEY}`
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
