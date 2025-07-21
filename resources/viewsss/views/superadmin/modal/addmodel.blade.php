<div class="modal fade" id="makeModal" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0" style="background-color:#F0F3F6">
                    <h5 class="modal-title" id="colorModalLabel">Add Make</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color:#F0F3F6">
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

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn  custom-btn-nav rounded">Save</button>
                </div>
                       
                </form>
            </div>
        </div>
    </div>