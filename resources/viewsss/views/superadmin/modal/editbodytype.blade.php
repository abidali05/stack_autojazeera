<div class="modal fade" id="editbodytypeModal{{$type->id}}" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0" style="background-color:#F0F3F6">
                    <h5 class="modal-title" id="featureModalLabel">Add Body Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color:#F0F3F6">
                    <form id="bodytypeform" method="post" action="{{route('superadmin.bodytype.update',$type->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Left Side: Upload Icon -->
                            <div class="col-md-6 text-center">
                            <div class="upload-area border border-dashed rounded p-4 text-center"
                                onclick="document.getElementById('imageupload1{{$type->id}}').click();">
                                <p class="mb-0">Click here to upload Icon</p>
                                <input type="file" id="imageupload1{{$type->id}}" name="icon" class="d-none"
                                    accept=".png, .jpg, .jpeg, .gif, .ico, .svg"
                                    onchange="handleimageUpload1(this, 'brochurePreview{{$type->id}}')">
                            </div>
                            <div id="brochurePreview{{$type->id}}" class="mt-3 text-success image-preview"></div>
                        </div>

                            <!-- Right Side: Input Fields -->
                            <div class="col-md-6">
                               
                                <div class="mb-3">
                                    <label for="bodyType" class="form-label">Enter Body Type</label>
                                    <input type="text" class="form-control" name="name" value="{{$type->name}}" id="bodyType" placeholder="Enter Body Type"
                                        required>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" name="status" {{$type->status == 1?"checked":""}} type="checkbox" id="activateFeature" >
                                    <label class="form-check-label"  for="activateFeature">Activate</label>
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
 
    