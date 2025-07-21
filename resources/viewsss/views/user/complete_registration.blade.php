@extends('layout.panel_layout.main')
@section('content')
   <div class="container">
    <div class="col-12 p-lg-5 p-3">
        <form  method="post" action="{{route('complete_registration_store')}}">
            @csrf
            
              
                <div class="row mb-3" id="dealershipNameRow">
                    <label for="dealershipName" class="col-sm-4 col-form-label">Dealership Name*</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control formcontrol" id="dealershipName"
                            placeholder="Enter dealership name" name="dealershipName" required>
                        @error('dealershipName')
                        <div class="alert bg-none">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
           
                <div class="row mb-3">
                    <label for="phone" class="col-sm-4 col-form-label">Phone*</label>
                    <div class="col-sm-1">
                        <input type="tel" class="form-control formcontrol" id="phone" placeholder="Enter phone" value="{{'+92'}}" disabled>

                    </div>
                    <div class="col-sm-7">
                        <input type="string" class="form-control formcontrol" id="phone" name="number" placeholder="Enter phone"  required>
                        @error('number')
                        <div class="alert ">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-4 col-form-label">Email*</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control formcontrol"  name="email" id="email" placeholder="Enter email" required>
                        @error('email')
                        <div class="alert ">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
           
                <div class="row mb-3">
                    <label for="province" class="col-sm-4 col-form-label">Province*</label>
                    <div class="col-sm-8">
                        <select class="form-select filter-style" id="province1" name="province" required>
                            <option value="" selected>Select province</option>
                            @foreach($provinces as $province)
                            <option value="{{$province->id}}">{{$province->name}}</option>

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
                        <select class="form-select filter-style" id="city1" name="city" required>

                            <!-- Cities will be populated here based on selected province -->
                        </select>
                        @error('city')
                        <div class="alert ">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="test drive" class="col-sm-4 col-form-label">Offer Test Drive</label>
                    <div class="col-sm-8">
                        <select class="form-select filter-style" name="offer_test_drive" required>
                          
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>

                       
                        </select>
                        @error('offer_test_drive')
                        <div class="alert ">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="addStatus" class="col-sm-4 col-form-label">Enter Address</label>
                    <div class="col-sm-8">
                        <textarea class="form-control formcontrol" id="address" name="address" required></textarea>
                        @error('address')
                        <div class="alert ">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn  custom-btn-nav rounded">Save</button>
                    </div>
                </div>
        
                
           
        </form>
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
@endsection