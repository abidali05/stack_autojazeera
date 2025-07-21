<style>
	.ankere{
	text-decoration:none;
	}
	.divborder {
    border: 1px solid #BFBEC34D;
    background-color: #281F48;

}
	.ab {
		font-size:16px !important;
	    color: white;
		font-weight:500;
	}
	.footertag a {

    color: #B4B3B8; /* Set text color */
		
}
	.footertag {
    list-style: none; /* removes bullets */
    padding-left: 0; /* removes extra space on left */
}
	.footerl {
    font-size: 16px;
    font-weight: 500;
    color: #B4B3B8;
}
	.firstpp {
    color: #B4B3B8;
    font-size: 14px;
    font-weight: 500;
}
.input-group {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    width: 100%;
}
	.custom-input-group {
    background-color: #281F48;
    border: 1px solid #4b6179;
    border-radius: 8px;
}
	.input-group-text {
    display: flex;
    align-items: center;
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: var(--bs-body-color);
    text-align: center;
    white-space: nowrap;
    background-color: var(--bs-tertiary-bg);
    border: var(--bs-border-width) solid var(--bs-border-color);
    border-radius: var(--bs-border-radius);
}
	.custom-input-group input {
    background-color: transparent;
    border: none;
    color: #bfc7d5;
}
	.custom-input-group .input-group-text {
    background-color: transparent;
    border: none;
}
	.form-control {
    border-right: 0;
    border-left: 0;
    padding: 10px;
    font-size: 16px;
    color: #281f48 !important;
}
	.form-control::placeholder {
    color: #bfc7d5  !important;
}
</style>
<div class="container-fluid divborder" style="border: none !important;position: static;">
    <div class="row justify-content-center footercontainer p-4">
        <div class="col-md-10">
            <div class="row">
                   <div class="col-xxl-4  col-lg-4 col-md-4 col-sm-6 col-6">
                    <img src="{{ asset('web/bikes/images/fotter.svg') }}" class="img-fluid w-75 mb-3"
                        alt="...">
                    <p class="footerl mt-2">Your Car, Your Way, with Our Trusted Car Dealers</p>
                </div>
                <div class="col-xxl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                    <h3 class="ab">Cars By Make</h3>
                    <ul class="footertag p-0">
                        <li> <a href="{{ url('/search-data/53/make') }}" style="color:#B4B3B8" target="_blank"
                                class=" nav_custom_form_btns">Toyota</a>
                        </li>
                        <li> <a href="{{ url('/search-data/68/make') }}" style="color:#B4B3B8" target="_blank"
                                class=" nav_custom_form_btns">Suzuki</a>
                        </li>
                        <li><a href="{{ url('/search-data/67/make') }}" style="color:#B4B3B8" target="_blank"
                                class=" nav_custom_form_btns">Honda</a>
                        </li>
                        <li><a href="{{ url('/search-data/120/make') }}" style="color:#B4B3B8" target="_blank"
                                class=" nav_custom_form_btns">BMW</a>
                        </li>
                        <li><a href="{{ url('/search-data/60/make') }}" style="color:#B4B3B8" target="_blank"
                                class=" nav_custom_form_btns">Hyundi</a>
                        </li>
                        <li><a href="{{ url('/search-data/110/make') }}" style="color:#B4B3B8" target="_blank"
                                class=" nav_custom_form_btns">KIA</a>
                        </li>
                    </ul>
                </div>
				   <div class="col-xxl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                    <h3 class="ab">Cars By City</h3>
                    <ul class="footertag p-0">
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.search') }}" @else  action="{{ route('search') }}" @endif>
                                @csrf

                                <input type="hidden" name="city" value="85">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Islamabad</button>


                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.search') }}" @else  action="{{ route('search') }}" @endif>
                                @csrf

                                <input type="hidden" name="city" value="3">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Rawalpindi</button>


                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.search') }}" @else  action="{{ route('search') }}" @endif>
                                @csrf

                                <input type="hidden" name="city" value="49">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Peshawar</button>


                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.search') }}" @else  action="{{ route('search') }}" @endif>
                                @csrf

                                <input type="hidden" name="city" value="30">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Karachi</button>


                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.search') }}" @else  action="{{ route('search') }}" @endif>
                                @csrf
                                <input type="hidden" name="city" value="68">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Quetta</button>
                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.search') }}" @else  action="{{ route('search') }}" @endif>
                                @csrf

                                <input type="hidden" name="city" value="5">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Multan</button>


                            </form>
                        </li>
                    </ul>
                </div>
            <div class="col-xxl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                    <h3 class="ab">Bike By Make</h3>
                    <ul class="footertag p-0">
                        <li> <a href="{{ url('/search-bikes/17/make') }}" style="color:#B4B3B8" target="_blank"
                                class=" nav_custom_form_btns">EAGLE</a>
                        </li>
                        <li> <a href="{{ url('/search-bikes/7/make') }}" style="color:#B4B3B8" target="_blank"
                                class=" nav_custom_form_btns">HONDA</a>
                        </li>
                        <li><a href="{{ url('/search-bikes/8/make') }}" style="color:#B4B3B8" target="_blank"
                                class=" nav_custom_form_btns">BENLING</a>
                        </li>
                        <li><a href="{{ url('/search-bikes/10/make') }}" style="color:#B4B3B8" target="_blank"
                                class=" nav_custom_form_btns">BML</a>
                        </li>
                        <li><a href="{{ url('/search-bikes/13/make') }}" style="color:#B4B3B8" target="_blank"
                                class=" nav_custom_form_btns">CROWN</a>
                        </li>
                        <li><a href="{{ url('/search-bikes/24/make') }}" style="color:#B4B3B8" target="_blank"
                                class=" nav_custom_form_btns">HERO</a>
                        </li>
                    </ul>
                </div>
               <div class="col-xxl-2 col-lg-2 col-md-3 col-sm-4 col-6">
                    <h3 class="ab">Bike By City</h3>
                    <ul class="footertag p-0">
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf

                                <input type="hidden" name="city" value="85">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Islamabad</button>


                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf

                                <input type="hidden" name="city" value="3">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Rawalpindi</button>


                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf

                                <input type="hidden" name="city" value="49">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Peshawar</button>


                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf

                                <input type="hidden" name="city" value="30">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Karachi</button>


                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf
                                <input type="hidden" name="city" value="68">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Quetta</button>
                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf

                                <input type="hidden" name="city" value="5">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Multan</button>


                            </form>
                        </li>
                    </ul>
                </div>
             
				 <div class="col-xxl-4  col-lg-4 col-md-4 col-sm-8 col-8">
                    <h3 class="ab">Subscribe to our newsletter</h3>
                    <p class="firstpp"></p>

                    <div class="input-group custom-input-group p-2">
                      
                        <span class="input-group-text">
                            <img src="{{ asset('web/bikes/images/Icon (Stroke) (7).svg') }}" alt="Email Icon">
                        </span>

                        <input type="text" class="form-control" placeholder="Your email" aria-label="Email" name="newsletter_email"
                            aria-describedby="basic-addon1" required id="newsletter_email">

                       
                        <img src="{{ asset('web/bikes/images/Group 2640.svg') }}" alt="Send Icon" id="newsletter_submit_btn" style="cursor: pointer">

                        
                    </div>

                </div>
            @php
                $service_categories = App\Models\AutoServices\ServiceCategories::all();
            @endphp
                <div class="col-xxl-2 col-md-2 col-sm-4 col-6">
                    <h3 class="ab">Auto Services</h3>
                    <ul class="footertag p-0">
                        @if ($service_categories->count() > 0)
                            
                        
                        @for ($i = 0; $i < 6; $i++)
                          <li> <a href="{{route('services.categorysearch', $service_categories[$i]->name)}}">{{$service_categories[$i]->name}}</a> <li>  
                        @endfor
                        @endif
                        
                    </ul>
                </div>
				    <div class="col-xxl-2 col-md-2 col-sm-4 col-6">
                    <h3 class="ab">Auto Services By City</h3>
                    <ul class="footertag p-0">
                        <li>
                            <form method="post" target="_blank"
                               action="{{ route('services.search') }}" >
                                @csrf

                                <input type="hidden" name="city" value="85">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Islamabad</button>


                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                               action="{{ route('services.search') }}" >
                                @csrf

                                <input type="hidden" name="city" value="3">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Rawalpindi</button>


                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                               action="{{ route('services.search') }}" >
                                @csrf

                                <input type="hidden" name="city" value="49">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Peshawar</button>


                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                               action="{{ route('services.search') }}" >
                                @csrf

                                <input type="hidden" name="city" value="30">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Karachi</button>


                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                               action="{{ route('services.search') }}" >
                                @csrf
                                <input type="hidden" name="city" value="68">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Quetta</button>
                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                               action="{{ route('services.search') }}" >
                                @csrf

                                <input type="hidden" name="city" value="5">


                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Multan</button>


                            </form>
                        </li>
                    </ul>
                </div>
                <div class="col-xxl-2 d-none col-lg-2 col-md-2 col-sm-4 col-6">
                    <h3 class="ab">Cars By Body Type</h3>
                    <ul class="footertag p-0">
                        <li class="me-3">
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.search') }}" @else  action="{{ route('search') }}" @endif>
                                @csrf
                                <input type="hidden" name="bodytype" value="46">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">HatchBack</button>
                            </form>
                        </li>
                        <li class="me-3">
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.search') }}" @else  action="{{ route('search') }}" @endif>
                                @csrf
                                <input type="hidden" name="bodytype" value="14">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Sedan</button>
                            </form>
                        </li>
                        <li class="me-3">
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.search') }}" @else  action="{{ route('search') }}" @endif>
                                @csrf
                                <input type="hidden" name="bodytype" value="44">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">SUV</button>
                            </form>
                        </li>
                        <li class="me-3">
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.search') }}" @else  action="{{ route('search') }}" @endif>
                                @csrf
                                <input type="hidden" name="bodytype" value="42">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Crossover</button>
                            </form>
                        </li>

                    </ul>
                </div>
                <div class="col-xxl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                    <h3 class="ab">Auto Jazeera Marketplace</h3>
                    <ul class="footertag p-0">
                        <li class="me-3"><a href="{{ route('aboutus') }}" target="_blank"
                                class=" nav_custom_form_btns text-decoration-none" style="color:#B4B3B8">About Us</a>
                        </li>
                        <li class="me-3"><a href="{{ route('faq') }}" target="_blank"
                                class=" nav_custom_form_btns text-decoration-none" style="color:#B4B3B8">FAQ</a></li>
                        <li class="me-3"><a href="{{ route('register') }}" target="_blank"
                                class=" nav_custom_form_btns text-decoration-none" style="color:#B4B3B8">Dealer Sign
                                up</a></li>
                        <li><a href="{{ route('contact') }}" target="_blank"
                                class=" nav_custom_form_btns text-decoration-none" style="color:#B4B3B8">Contact
                                Us</a></li>
						     <li><a href="{{ route('subscription_plan') }}" target="_blank"
                                class=" nav_custom_form_btns text-decoration-none" style="color:#B4B3B8">Advertise
                                </a></li>

                    </ul>
                </div>
                <div class="col-xxl-2  col-lg-2  col-md-3 col-sm-4 col-6">
                    <img src="{{ asset('web/bikes/images/image 10.svg') }}" class="img-fluid mb-2" alt="...">
                    <img src="{{ asset('web/bikes/images/image 11.svg') }}" class="img-fluid" alt="...">
                </div>
                <div class="row">
                    <div class="col-5 copyright">
                        <p class="ankere" style="color:#B4B3B8">© 2025 AutoJazeera, All Rights Reserved.</p>
                    </div>
                    <div class="col-3 ms-auto copyright">
						<p><span class="me-3"><a class="ankere" style="color:#B4B3B8" target="_blank" href="{{ route('term_condition') }}">Terms of use</a></span> <a class="ankere" style="color:#B4B3B8" target="_blank" href="{{ route('privacy_policy') }}">Privacy policy</a> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script>
    $('#newsletter_submit_btn').on('click', function () {
        var email = $('#newsletter_email').val();
        // alert(email);
        if (email) {
            $.ajax({
                type: 'POST',
                url: '{{ route('newsletter.submit') }}',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#newsletterresponseBody').html(response.message);
                    $('#newsletterresponse').modal('show');
                }
            });
        } else {
            $('#newsletterresponseBody').html('Please enter a valid email address.');
            $('#newsletterresponse').modal('show');
        }
    });
</script>


    <div class="modal fade" id="newsletterresponse" tabindex="-1" aria-labelledby="newsletterresponseLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
                <div class="modal-header" style="background-color: #FD5631; color: white; border-bottom: none;">
                    <h5 class="modal-title" id="newsletterresponseLabel">NewsLetter</h5>
                    <button type="button" class="btn-close" style="background-color: white; color: #FD5631;"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="newsletterresponseBody">
                    
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button"
                        style="color:white; background-color:#FD5631;padding:5px 20px; border:none;border-radius:5px"
                        data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                </div>
            </div>
        </div>
    </div>
