<div>
<div class="modal fade" id="appoinment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <div class="modal-body px-5">
                    <h2 class="sec mb-4 primary-color-custom">Book an Appointment</h2>
                    <form id="addappointmentForm" method="post" action="{{route('submitted-forms.store')}}">
                        @csrf
                        <div class="row mb-3">
							  <input type="hidden" name="type" value="Book an Appointment">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label" style="color:white">Full Name*</label>
                                <input type="text" name="fullname" style="background-color:white !important" class="form-control formcontrol" id="fullName" >
                            </div>
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <input type="hidden" style="background-color:white !important" name="dealer_id" value="{{$post->dealer_id}}">
                            @if(isset(Auth::user()->id))
                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                            @endif
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label" style="color:white">Email*</label>
                                <input type="email" style="background-color:white !important" name="email" class="form-control formcontrol" id="email" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phoneNo" class="form-label" style="color:white">Phone Number</label>
                               <input type="tel" name="number" class="form-control formcontrol"  
       id="phoneNo" maxlength="14" value="+92" 
       style="background-color: #282435;" 
        
       
    
       onfocus="ensureSpace()" oninput="formatPhone(this)">
								

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dateofbirth"  class="form-label" style="color:white">Date</label>
                                <input type="date" style="background-color:white !important; line-height: 1.2 !important" name="DateOfBirth" class="form-control formcontrol" id="dateofbirth">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="time" class="form-label" style="color:white">Time</label>
                                <input type="time" style="background-color:white !important ;" name="Time" class="form-control formcontrol" id="time">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="method" class="form-label" style="color:white ;">Preferred Contact Method</label>
                                <select class="form-select filter-style" style="background-color:white !important; color:#281F48 !important; max-width:100% !important" name="Method" id="province">
                                    <option value="" selected="">Preferred Contact Method</option>
                                    <option value="number">Phone Number</option>
                                    <option value="email">Email</option>
                                  
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="method" class="form-label" style="color:white">Message</label>
                            <textarea class="form-control formcontrol " style="background-color:white !important" id="message" name="Comment" rows="4" placeholder="" maxlength="1000"></textarea>
                        </div>
                        <button type="submit" class="btn custom-btn-nav rounded px-5">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
          <p style="color: #282435 !important">       Your appointment has been booked successfully!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>
<script>
$(document).ready(function () {
    $("#addappointmentForm").on("submit", function (e) {
        e.preventDefault(); 

        var form = $(this);
        $.ajax({
            type: form.attr("method"),
            url: form.attr("action"),
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                $("#appoinment").modal("hide");

                if (response.success) {
                    $("#successModal .modal-body").text("Your appointment has been booked successfully!");
                } else {
                    $("#successModal .modal-body").text("Something went wrong. Please try again.");
                }

                $("#successModal").modal("show");
                form[0].reset(); // Reset form only after showing successModal
            },
            error: function (xhr) {
               // alert("Something went wrong: " + xhr.responseText);
            }
        });
    });
});





function ensureSpace() {
    let input = document.getElementById("phoneNo");
    if (input.value === "+92") {
        input.value = "+92 "; // Ensure space after +92 when clicked
    }
}

function formatPhone(input) {
    let value = input.value.replace(/\D/g, ''); // Remove non-numeric characters
    if (value.startsWith("92")) value = value.slice(2); // Remove extra "92" if added manually
    if (value.length > 9) value = value.slice(0, 9); // Limit to 9 digits after +92

    let formatted = "+92 ";
    if (value.length > 0) formatted += value.slice(0, 3);
    if (value.length > 3) formatted += " " + value.slice(3);

    input.value = formatted;
}
</script>
