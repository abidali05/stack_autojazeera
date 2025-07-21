<div class="modal fade" id="editDealeruserModal{{$user->id}}" tabindex="-1" aria-labelledby="addDealerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="editDealerModalLabel">Edit Dealer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editDealerForm{{$user->id}}" method="post"   @if (Request::is('superadmin/*')) action="{{route('superadmin.dealer_user.update',$user->id)}}" @else action="{{route('dealer_user.update',$user->id)}}" @endif >
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <?php

                    $provinces = \App\Models\Province::all();

                    ?>
                    <div class="alert alert-danger" style="display:none;"></div>
                    <div class="row mb-3">
                        <label for="dealershipName" class="col-sm-4 col-form-label">Dealership Name*</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control formcontrol" name="dealershipName" value="{{$user->dealershipName??''}}" id="dealershipName"
                                placeholder="Enter dealership name">
                            @error('dealershipName')
                            <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="fullName" class="col-sm-4 col-form-label">Full Name*</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control formcontrol" id="fullName" name="name" value="{{$user->name??''}}" placeholder="Enter full name">
                            @error('name')
                            <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="phone" class="col-sm-4 col-form-label">Phone*</label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control formcontrol" id="phone" name="number" value="{{'+92' }}" disabled>
                         
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control formcontrol" id="phone" name="number" value="{{ str_replace('+92', '', $user->number ?? '') }}" placeholder="Enter phone">
                            @error('number')
                            <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-4 col-form-label">Email*</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control formcontrol" name="email" id="email" value="{{$user->email??''}}" placeholder="Enter email">
                            @error('email')
                            <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-4 col-form-label">Password*</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control formcontrol" name="password" id="email" placeholder="Enter password">
                            @error('password')
                            <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="province" class="col-sm-4 col-form-label">Province*</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="province" name="province" required>
                                <option value="" selected>Select province</option>
                                @foreach($provinces as $province)
                                <option value="{{$province->id}}" {{$user->province == $province->id ?'selected':''}}>{{$province->name}}</option>

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
                            <select class="form-select" id="city" name="city" required>
                                @if(isset($user->city))
                                <option value="{{$user->city}}" selected>{{$user->cityname}}</option>'
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
                        <div class="col-sm-8">
                            <select class="form-select" id="addStatus" name="status" required>
                                <option value="" selected>Select Status</option>
                                <option value="active" {{$user->status == 'active' ?'selected':''}}>Active</option>
                                <option value="inactive" {{$user->status == 'inactive' ?'selected':''}}>Inactive</option>
                            </select>
                            @error('status')
                            <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="addStatus" class="col-sm-4 col-form-label">Enter Address</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" id="address" name="address" required>{!!$user->address!!}</textarea>
                            @error('address')
                            <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="website" class="col-sm-4 col-form-label">Website (if any)</label>
                        <div class="col-sm-8">
                            <input type="url" class="form-control" id="website" name="website" value="{{$user->website}}" placeholder="Enter website">
                            @error('website')
                            <div class="alert ">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="allow_company" id="marketplace" {{$user->allow_company == '1' ?'checked':''}}>
                        <label class="form-check-label" for="marketplace">
                            Enable for Marketplace - Allow your company to access and sell products in our online
                            marketplace.
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="bulk_import" id="inventory" {{$user->bulk_import == '1' ?'checked':''}}>
                        <label class="form-check-label" for="inventory">
                            Enable for Inventory Bulk Import - Streamline your operations by importing inventory
                            data in bulk.
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="user_management" id="userManagement" {{$user->user_management == '1' ?'checked':''}}>
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

<script>
    document.getElementById('province').addEventListener('change', function() {
        var provinceId = this.value;

        var citySelect = document.getElementById('city');

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
    $(document).ready(function() {
        $('#editDealerForm{{$user->id}}').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            $.ajax({
                url: $(this).attr('action'), // The action URL from your form
                method: $(this).attr('method'), // Form method (POST or PUT)
                data: $(this).serialize(), // Serialize form data
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    if (response.success) {
                        $('#editDealerModal{{ $user->id }}').modal('hide'); // Hide modal on success
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
                            errorHtml += '<li>' + value[0] + '</li>'; // Display each error
                            // Show the error next to each field
                            $('[name=' + key + ']').next('.alert').remove(); // Remove previous error messages
                            $('[name=' + key + ']').after('<div class="alert alert-danger">' + value[0] + '</div>');
                        });

                        errorHtml += '</ul>';
                        $('#editDealerModal{{ $user->id }} .modal-body').prepend(errorHtml); // Show errors at the top of the modal
                    }
                }
            });
        });
    });
</script>