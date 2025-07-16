@if(session('error'))
<p>{{ session('error') }}</p>
@endif
<style>
.ElementsApp, .ElementsApp .InputElement  {
    color: orange !important; /* Corrected property name and syntax */
}

</style>
   <style>
.custom-checkbox {
  appearance: none;
  width: 18px;
  height: 18px;
  border: 2px solid #FD5631;
  border-radius: 3px;
  background-color: #1F1B2D;
  cursor: pointer;
  position: relative;
  transition: all 0.3s ease;
}
.custom-checkbox:checked {
  background-color: #FD5631; 
  border-color: #FD5631; 
}
	
    </style>
{{--@if(session('success'))
<p>{{ session('success') }}</p>
@endif


 <form action="{{ route('payment.process') }}" method="POST">
@csrf
<script
    src="https://checkout.stripe.com/checkout.js"
    class="stripe-button"
    data-key="{{ config('services.stripe.key') }}"
    data-amount="5000"
    data-name="{{Auth::user()->name}}"
    data-description="Payment Description"
    data-currency="usd"
    data-email="{{Auth::user()->email}}">
</script>
</form>
<div class=" container ">
    <h2 class="sec mb-5">2: Payment </h2>
    <div class="row">
        <div class="col-lg-6 mt-5">
            <form >
                <div class="row g-3 text-white">
                    <!-- Name on Card -->
                    <div class="col-md-12">
                        <label for="cardName" class="form-label">Name on Card</label>
                       <input type="text" class="form-control newclsa"  id="cardName" autocomplete="false" placeholder="Aycan Doganlar">
                    </div>
                    <!-- Card Number -->
                    <div class="col-md-12">
                        <label for="cardNumber" class="form-label">Card Number</label>
                        <input type="text" class="form-control " style="text:white !important" id="cardNumber"
                            placeholder="1234  4567  7890  1234" autocomplete="off">
                    </div>
                    <!-- Expire Date -->
                    <div class="col-md-6">
                        <label for="expireDate" class="form-label">Expire Date</label>
                        <input type="text" class="form-control" id="expireDate" placeholder="02/24">
                    </div>
                    <!-- CVV -->
                    <div class="col-md-6">
                        <label for="cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cvv" placeholder="XXX">
                    </div>
                </div>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" value="" id="autoRenew">
                    <label class="form-check-label text-white" for="autoRenew">
                        Enable Auto Renew
                    </label>
                </div>
                <button type="submit " class="btn btn-submit mt-4 py-3 w-100 custom-btn rounded fw-bold">Submit</button>
            </form>
        </div>
        <div class="col-lg-6 text-lg-center">
            <img src="{{asset('web/images/visacard.png')}}" alt="" class="img-fluid">
            <p class="text-white">We accept payments in both <span style="color: #FD5631;"> Visa</span> and <span style="color: #FD5631;">Master</span> cards</p>
        </div>
    </div>

</div> --}}
@include('superadmin.modal.security_popup')

<div class="container ">
   <h2 class="sec mb-4" >2: Payment</h2>
    <div class="row">
		<div class="col-md-12 bg-image px-1 py-5">  
			<div class="row d-flex ">
				   <div class="col-md-3 text-center">
				<img src="{{ asset('web/images/paymentlogoo.svg') }}" alt="" style="width:200px; height:80px" srcset="">
				</div>
       <div class="col-md-6  mt-3 ">
         
                <div class="row g-3 p-3">
                    <!-- Name on Card -->
                    <div class="col-md-12">
                        <label for="cardName" class="form-label">Name on Card</label>
                        <input type="text" class="form-control" id="cardName" name="cardName" placeholder="Enter your name" required>
                    </div>
                    <!-- Card Number -->
                    <div class="col-md-12">
                        <label for="cardNumber" class="form-label">Card Number</label>
                        <div id="cardNumber" class="form-control"></div>
                        <div id="cardNumber-errors" role="alert" class="text-danger mt-2"></div>
                    </div>
                    <!-- Expire Date -->
                    <div class="col-md-6">
                        <label for="expireDate" class="form-label">Expire Date</label>
                        <div id="expireDate" class="form-control"></div>
                        <div id="expireDate-errors" role="alert" class="text-danger mt-2"></div>
                    </div>
                    <!-- CVV -->
                    <div class="col-md-6">
                        <label for="cvv" class="form-label">CVV</label>
                        <div id="cvv" class="form-control"></div>
                        <div id="cvv-errors" role="alert" class="text-danger mt-2"></div>
                    </div>
					{{-- <div class="col-md-6">
                       <div class="form-check">
  <input class="form-check-input custom-checkbox" type="checkbox" id="flexCheckDefault">
  <label class="form-check-label" for="flexCheckDefault">
   Enable Auto Renew
  </label>
</div>
                    </div>--}}
                </div>
              
                <button type="submit" class="btn btn-submit mt-4 py-3 w-100 custom-btn rounded fw-bold">Submit</button>
         <p class="text-center mt-4">We accept payments in both <span style="color: #FD5631;">Visa</span> , <span style="color: #FD5631;">MasterCard debit</span> and <span style="color: #FD5631;">credit cards</span>.</p>
		   <p class="text-center mt-3">This card will be used for the recurring billing cycles payments. You can cancel your subscription any time by visiting Account<span style="color: #FD5631;"> > Manage Subscription.</span></p>
        </div>
			  <div class="col-md-3 text-center">
				<img src="{{ asset('web/images/mastercardd.svg') }}" alt="" class="mb-3" style="width:200px; height:80px" srcset="">
				  <img src="{{ asset('web/images/visa.svg') }}" alt="" style="width:150px; height:60px" srcset="">
				</div>
			</div> </div>
       {{-- <div class="col-lg-6 text-lg-center mt-5">
           <img src="{{ asset('web/images/visacard.png') }}" alt="" class="img-fluid">
            <p>We accept payments in both <span style="color: #FD5631;">Visa</span> and <span style="color: #FD5631;">Master</span> cards</p>
        
		</div>--}}
    </div>
</div>


<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Stripe
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements();

    // Style options for Stripe Elements
    const style = {
        base: {
            color: '#aab7c4',
            fontFamily: 'Arial, sans-serif',
            fontSize: '16px',
            '::placeholder': { color: '#aab7c4' },
        },
        invalid: { color: '#fa755a' },
    };

    // Create card elements
    const cardNumber = elements.create('cardNumber', { style });
    const cardExpiry = elements.create('cardExpiry', { style });
    const cardCvc = elements.create('cardCvc', { style });

    // Mount elements into their respective fields
    cardNumber.mount('#cardNumber');
    cardExpiry.mount('#expireDate');
    cardCvc.mount('#cvv');

    // Handle real-time validation errors
    cardNumber.addEventListener('change', function (event) {
        const displayError = document.getElementById('cardNumber-errors');
        displayError.textContent = event.error ? event.error.message : '';
    });

    cardExpiry.addEventListener('change', function (event) {
        const displayError = document.getElementById('expireDate-errors');
        displayError.textContent = event.error ? event.error.message : '';
    });

    cardCvc.addEventListener('change', function (event) {
        const displayError = document.getElementById('cvv-errors');
        displayError.textContent = event.error ? event.error.message : '';
    });

    // Handle form submission
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        // Create a Payment Method
        stripe.createPaymentMethod({
            type: 'card',
            card: cardNumber,
            billing_details: {
                name: document.getElementById('cardName').value,
            },
        }).then(function (result) {
            if (result.error) {
                // Display error to the user
                document.getElementById('cardNumber-errors').textContent = result.error.message;
            } else {
                // Send the PaymentMethod ID to the server
                stripePaymentMethodHandler(result.paymentMethod);
            }
        });
    });

    // Send Payment Method to the server
    function stripePaymentMethodHandler(paymentMethod) {
        // Add the PaymentMethod ID to the form
        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'paymentMethodId');
        hiddenInput.setAttribute('value', paymentMethod.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }
});


</script>