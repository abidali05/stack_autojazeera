<div class="modal fade" id="information" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
               
                <div class="modal-body p-5">
                    <h2 class="sec mb-4 primary-color-custom">Request more Information</h2>
                    <form id="informationform" method="post" action="{{route('submitted-forms.store')}}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                            <input type="hidden" name="type" value="Request more Information">
                                <label for="firstName" class="form-label">Full Name*</label>
                                <input type="text" name="fullname" class="form-control" id="fullName" >
                            </div>
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <input type="hidden" name="dealer_id" value="{{$post->dealer_id}}">
                            @if(isset(Auth::user()->id))
                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            @endif
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" name="email" class="form-control" id="email" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phoneNo" class="form-label">Phone Number</label>
                                <input type="tel" name="number" class="form-control" id="phoneNo">
                            </div>
                          
                            <div class="col-md-6 mb-3">
                                <select class="form-select" name="Method" id="province">
                                    <option value="" selected="">Preferred Contact Method</option>
                                    <option value="number">Phone Number</option>
                                    <option value="email">Email</option>
                                  
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" id="message" name="Comment" rows="4" placeholder="" maxlength="1000"></textarea>
                        </div>
                        <button type="submit" class="btn custom-btn-nav rounded px-5">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>