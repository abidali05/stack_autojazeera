
<div class="modal fade" id="makeModal" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0" style="background-color:#F0F3F6">
                    <h5 class="modal-title" id="colorModalLabel">Add Make</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color:#F0F3F6">
                    <form id="featureForm" method="post" action="{{route('superadmin.make.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Left Side: Upload Icon -->
                            <div class="col-md-6 text-center">
                            <div class="upload-area  rounded p-4 text-center"
                                onclick="document.getElementById('brochureUpload2').click();" style="border:1px dashed white">
                                <p class="mb-0">Click here to upload Icon</p>
                                <input type="file" id="brochureUpload2" name="icon" class="d-none"
                                    accept=".png, .jpg, .jpeg, .gif, .ico, .svg"
                                    onchange="handleimageUpload(this, 'brochurePreview2')">
                            </div>
                            <div id="brochurePreview2" class="mt-3 text-success"></div>
                        </div>


                            <!-- Right Side: Input Fields -->
                            <div class="col-md-6">
                               
                                <div class="mb-3">
                                    <label for="bodyType" class="form-label">Enter Make Name*</label>
                                    <input type="text" class="form-control" name="name" id="bodyType" placeholder="Enter Make Name"
                                        required>
                                </div>

                                <div class="form-check form-switch mb-3 d-flex justify-content-end">
                                    <input class="form-check-input" name="status" type="checkbox" id="activateFeature" checked>
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