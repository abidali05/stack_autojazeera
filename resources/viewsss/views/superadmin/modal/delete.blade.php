@method('DELETE')
@csrf
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="addDealerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
            <div class="modal-header border-0" style="background-color: #D9D9D9 !important; color: #281F48; border-bottom: none;">
                <h5 class="modal-title" id="editDealerModalLabel"><strong> Delete</strong></h5>
                <button type="button" class="btn-close" style="background-color: #D9D9D9 !important; color: #FD5631;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        
            <div class="modal-body" style="background-color: #F0F3F6; color: #FD5631;">
             <h4 style="color:#281F48 !important;">Are you sure to delete this record? </h4>
                    <div class="row mb-3">
                       
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" name="deleted_id"  id="deleted_id"
                                 name="dealershipName" required>
                        </div>
                    </div>
            
                 
             
           
            </div>
            <div class="modal-footer justify-content-center border-0 p-0 pb-3">
                <button type="button" class="btn btn-light px-4 py-2 " style="background-color: white; font-weight:600; color: #281F48; border-radius: 5px;" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-light px-4 py-2 " style="background-color: #281F48; font-weight:600; color: white; border-radius: 5px;">Delete</button>
            </div>
            </form>
        </div>
    </div>
</div>
