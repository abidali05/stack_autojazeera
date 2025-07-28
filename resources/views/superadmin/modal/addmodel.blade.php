<div class="modal fade" id="makeModal" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content"  style="border-radius: 10px; overflow: hidden;">
                <div class="modal-header border-0" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                    <h5 class="modal-title" id="colorModalLabel"><strong> Add Model</strong></h5>
                    <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: white !important; color: #281F48;">
                    <form method="post" action="{{route('superadmin.model.store')}}">
                        @csrf
                        <div class="row mb-3">
                            <label for="colorName" class="col-sm-5 col-form-label">Select Make*</label>
                            <div class="col-sm-7">
                                <select class="form-select" name="make" style="color:#281F48;background-color:white;text-align:start;border:1px solid #281F48" id="featureType" required>
                                    <option value="" disabled selected>Select Make</option>
                                    @foreach($makes as $make)
                                    <option value="{{$make->id}}" >{{$make->name}}</option>
                                   @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="colorCode" class="col-sm-5 col-form-label">Enter Body Type*</label>
                            <div class="col-sm-7">
                                <select class="form-select" style="color:#281F48;background-color:white;text-align:start;border:1px solid #281F48" name="bodytype" id="bodyType" required>
                                    <option value="" disabled selected>Select Body Type</option>
                                    @foreach($bodytypes as $bodytype)
                                    <option value="{{$bodytype->id}}" >{{$bodytype->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="addStatus" class="col-sm-5 col-form-label">Enter Model*</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="name" id="bodyType" placeholder="Enter Model"
                                        required>
                            </div>
                            
                        </div>
                        <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" name="status" type="checkbox" id="activateFeature" checked>
                                    <label class="form-check-label" for="activateFeature">Activate</label>
                                </div>
                 
                </div>

                <div class="modal-footer justify-content-center border-0 p-0 pb-3" style="background-color: white !important;">
                    <button type="button" class="btn btn-light px-4 py-2 "
                            style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-light px-4 py-2 "
                            style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;">Save</button>
                </div>
                       
                </form>
            </div>
        </div>
    </div>