<div class="modal fade" id="testdrive" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <div class="modal-body px-5">
                    <h2 class="sec mb-4 primary-color-custom">Schedule Test Drive</h2>
                    <form id="testdriveform" method="post" action="{{route('submitted-forms.store')}}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                            <input type="hidden" name="type" value="Schedule Test Drive">
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
                            <div class="col-md-6 mb-3">
                                <label for="phoneNo" class="form-label">Phone Number</label>
                                <input type="tel" name="number" class="form-control formcontrol" id="phoneNo">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dateofbirth"  class="form-label">Date of Birth</label>
                                <input type="date" name="DateOfBirth" class="form-control formcontrol" id="dateofbirth">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="time"  class="form-label">Time</label>
                                <input type="time" name="Time" class="form-control formcontrol" id="time">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="Preferred Contact Method"  class="form-label">Preferred Contact Method</label>
                                <select class="form-select filter-style" name="Method" id="province">
                                    <option value="" selected="">Preferred Contact Method</option>
                                    <option value="number">Phone Number</option>
                                    <option value="email">Email</option>
                                  
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="message"  class="form-label">Message</label>
                            <textarea class="form-control formcontrol" id="message" name="Comment" rows="4" placeholder="" maxlength="1000"></textarea>
                        </div>
                        <button type="submit" class="btn custom-btn-nav rounded px-5">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>