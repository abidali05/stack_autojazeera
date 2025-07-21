<div 
    id="successModal" 
    class="d-none modal fade @if(session('success')) show @endif d-flex justify-content-center align-items-center" 
    tabindex="-1" 
    role="dialog" 
    @if(session('success')) style="display: block;" aria-modal="true" @endif 
    aria-hidden="true"
	data-bs-backdrop="static"
					 
>
    <div class="modal-dialog" role="document">
        <div class="modal-content" >
            <div class="modal-header" style="background-color: #F0F3F6; color: #281F48; border-bottom: none;">
                <h5 class="modal-title">Subscription Confirmation </h5>
              
            </div>
            <div class="modal-body text-center" style="background-color: #F0F3F6;">
                <p class="mt-3">{{ session('success') }}</p>
            </div>
            <div class="modal-footer" style="border:none">
                <a type="button" style="background-color: #F0F3F6; font-weight:600; color: 281F48; border-radius: 5px; border:1px solid #FD5631" @if (!Request::is('superadmin/*')) href="{{ route('personal_info') }}" @endif class="btn btn-primary">Close</a>
            </div>
        </div>
    </div>
</div>

<div 
    id="errorModal" 
    class="modal fade @if(session('error')) show @endif" 
    tabindex="-1" 
    role="dialog" 
    @if(session('error')) style="display: block;" aria-modal="true" @endif 
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content"  style="border-radius: 10px; overflow: hidden;">
            <div class="modal-header" style="background-color: #F0F3F6; color: #281F48; border-bottom: none;">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" style="background-color: #F0F3F6; color: #281F48; border-bottom: none;">
                <p>{{ session('error') }}</p>
            </div>
            <div class="modal-footer"  style="border:none">
                <a type="button"  style="background-color: #F0F3F6; font-weight:600; color: #281F48; border-radius: 5px; border:1px solid #FD5631"  @if (!Request::is('superadmin/*'))   href="{{url('subscription')}}" @endif  class="btn btn-primary" >Close</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successModal = document.getElementById('successModal');
        if (successModal && successModal.classList.contains('show')) {
			successModal.classList.remove('d-none');
            const modal = new bootstrap.Modal(successModal);
            modal.show();
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        const errorModal = document.getElementById('errorModal');
        if (errorModal && errorModal.classList.contains('show')) {
            const modal = new bootstrap.Modal(errorModal);
            modal.show();
        }
    });
</script>
