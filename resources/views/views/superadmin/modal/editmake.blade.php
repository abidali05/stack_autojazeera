<div class="modal fade" id="editmakeModal{{$make->id}}" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 " style="background-color:#F0F3F6">
                    <h5 class="modal-title" id="colorModalLabel">Edit Make</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
				 <form id="featureForm" method="post" action="{{route('superadmin.make.update',$make->id)}}" enctype="multipart/form-data" >
                <div class="modal-body" style="background-color:#F0F3F6">
                   
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Left Side: Upload Icon -->
                            <div class="col-md-6 text-center">
                            <div class="upload-area border border-dashed rounded p-4 text-center"
                                onclick="document.getElementById('imageupload{{$make->id}}').click();">
                                <p class="mb-0">Click here to upload Icon</p>
                                <input type="file" id="imageupload{{$make->id}}" name="icon" class="d-none"
                                    accept=".png, .jpg, .jpeg, .gif, .ico, .svg"
                                    onchange="handleimageUpload1(this, 'brochurePreview{{$make->id}}')">
                            </div>
                            <div id="brochurePreview{{$make->id}}" class="mt-3 text-success image-preview"></div>
                        </div>


                            <!-- Right Side: Input Fields -->
                            <div class="col-md-6">
                               
                                <div class="mb-3">
                                    <label for="bodyType" class="form-label">Enter Make Name*</label>
                                    <input type="text" class="form-control" name="name" value="{{$make->name}}" id="bodyType" placeholder="Enter Make Name"
                                        required>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" name="status" type="checkbox" id="activateFeature" {{$make->status == 1?"checked":""}} >
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