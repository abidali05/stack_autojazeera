<div class="modal fade" id="editfeatureModal{{$feature->id}}" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="featureForm" method="post" action="{{route('superadmin.feature.update',$feature->id)}}" enctype="multipart/form-data">
            <div class="modal-header border-0" style="background-color:#F0F3F6">
                <h5 class="modal-title" id="featureModalLabel">Edit Feature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color:#F0F3F6">

                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Left Side: Upload Icon -->
                        <div class="col-md-6 text-center">
                            <div class="upload-area border border-dashed rounded p-4 text-center"
                                onclick="document.getElementById('imageupload1{{$feature->id}}').click();">
                                <p class="mb-0">Click here to upload Icon</p>
                                <input type="file" id="imageupload1{{$feature->id}}" name="icon" class="d-none"
                                    accept=".png, .jpg, .jpeg, .gif, .ico, .svg"
                                    onchange="handleimageUpload1(this, 'brochurePreview{{$feature->id}}')">
                            </div>
                            <div id="brochurePreview{{$feature->id}}" class="mt-3 text-success image-preview"></div>
                        </div>

                        <!-- Right Side: Input Fields -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="featureType" class="form-label">Select Feature Type*</label>
                                <select class="form-select" name="featureType" id="featureType"style="background-color:white;color:#281F48; text-align:start" required>
                                    <option value="" disabled selected>Select Feature Type</option>
                                    <option value="Exterior" {{$feature->feature == "Exterior"?"selected":""}}>Exterior</option>
                                    <option value="Interior" {{$feature->feature == "Interior"?"selected":""}}>Interior</option>
                                    <option value="Safety" {{$feature->feature == "Safety"?"selected":""}}>Safety</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="bodyType" class="form-label">Enter Feature Name</label>
                                <input type="text" name="featureName" value="{{$feature->Sub_feature}}" class="form-control" id="bodyType" placeholder="Enter Feature Name"
                                    required>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" name="status" type="checkbox" id="activateFeature" {{$feature->status == 1?"checked":""}}>
                                <label class="form-check-label" for="activateFeature">Activate</label>
                            </div>
                        </div>
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