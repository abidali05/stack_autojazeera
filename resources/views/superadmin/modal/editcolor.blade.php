
    <!-- Modal Structure -->
    <div class="modal fade" id="editcolorModal{{$color->id}}" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"  style="border-radius: 10px; overflow: hidden;">
                <div class="modal-header border-0" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                    <h5 class="modal-title" id="colorModalLabel"> <strong>Edit Color</strong></h5>
                    <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">
                    <form method="post" action="{{route('superadmin.color.update',$color->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="colorName" class="col-sm-5 col-form-label">Enter Color Name*</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" value="{{$color->name}}" name="name" id="colorName" placeholder="Enter Color Name" required="">
                                
                            </div>
                        </div>
                        <!-- <div class="row mb-3">
                            <label for="colorCode" class="col-sm-5 col-form-label">Enter Color Code*</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="code" id="colorCode" placeholder="Enter Color Code" required="">
                            </div>
                        </div> -->
                      

                        <div class="row mb-3">
                            <label for="addStatus" class="col-sm-5 col-form-label">Color Picker</label>
                            <div class="col-sm-7">
                                <input type="color" id="favcolor" name="code" value="{{$color->color_id}}" >
                            </div>
                        </div>
                  
                </div>

                <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                    <button type="button" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>