<div class="modal fade" id="editbodytypeModal{{$type->id}}" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                <div class="modal-header border-0" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                    <h5 class="modal-title" id="featureModalLabel"><strong> Add Body Type</strong></h5>
                    <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">
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

                <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                    <button type="button" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;"  data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;" >Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
 
    