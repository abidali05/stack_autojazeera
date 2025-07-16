<div class="modal fade" id="inquiry" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <div class="modal-body px-5">
                    <h2 class="sec mb-4 primary-color-custom">General Inquiry</h2>
                    <form id="inquiryform" method="post" action="{{route('submitted-forms.store')}}">
                        @csrf
                        <div class="row mb-3">

                        <input type="hidden" name="type" value="General Inquiry">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">Full Name*</label>
                                <input type="text" name="fullname" class="form-control formcontrol" id="fullName" >
                            </div>
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <input type="hidden" name="dealer_id" value="{{$post->dealer_id}}">
                            @if(isset(Auth::user()->id))
                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            @endif
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" name="email" class="form-control formcontrol" id="email" >
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="phoneNo" class="form-label">Phone Number</label>
                                <input type="tel" name="number" class="form-control formcontrol" id="phoneNo">
                            </div>
                           
                          
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control formcontrol" id="message" name="Comment" rows="4" placeholder="" maxlength="1000"></textarea>
                        </div>
                        <button type="submit" class="btn custom-btn-nav rounded px-5">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>