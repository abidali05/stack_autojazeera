
    <!-- Modal Structure -->
    <div class="modal fade" id="colorModal" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0" style="background-color:#F0F3F6">
                    <h5 class="modal-title" id="colorModalLabel">Add Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color:#F0F3F6">
                    <form method="post" action="{{route('superadmin.color.store')}}">
                        @csrf
                        <div class="row mb-3">
                            <label for="colorName" class="col-sm-5 col-form-label">Enter Color Name*</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="name" id="colorName" placeholder="Enter Color Name" required="">
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
                                <input type="color" id="favcolor" name="code" >
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