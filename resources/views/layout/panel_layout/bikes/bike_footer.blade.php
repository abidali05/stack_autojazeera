<style>
    .ankere {
        text-decoration: none;
    }
</style>
<div class="container-fluid divborder" style="border: none !important; border-radius: 0px !important;">
    <div class="row justify-content-center footercontainer p-4">
        <div class="col-md-11">
            <div class="row">
                <div class="col-xxl-4  col-lg-4 col-md-4 col-sm-6 col-6">
                    <img src="{{ asset('web/bikes/images/fotter.svg') }}" class="img-fluid w-75 mb-3" alt="...">
                    <h4 class="footerl mt-2">Your Bike, Your Way, with Our Trusted Bike Dealers</h4>
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
                <div class="col-xxl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                    <h3 class="ab">Bike By Model</h3>
                    <ul class="footertag p-0">

                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf

                                <input type="hidden" name="make" value="17">
                                <input type="hidden" name="model" value="56">

                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;text-align:start">Eagle Fire Bolt 100CC</button>


                            </form>
                        </li>

                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf

                                <input type="hidden" name="make" value="7">
                                <input type="hidden" name="model" value="76">

                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Honda CG 125</button>


                            </form>
                        </li>

                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf

                                <input type="hidden" name="make" value="8">
                                <input type="hidden" name="model" value="77">

                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">
                                    Benelli TNT 25</button>


                            </form>
                        </li>

                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf

                                <input type="hidden" name="make" value="10">
                                <input type="hidden" name="model" value="45">

                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">BML BM
                                    70</button>


                            </form>
                        </li>

                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf

                                <input type="hidden" name="make" value="13">
                                <input type="hidden" name="model" value="78">

                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;text-align:start">Crown CR 70 HD Plus</button>


                            </form>
                        </li>

                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf

                                <input type="hidden" name="make" value="24">
                                <input type="hidden" name="model" value="75">

                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Hero Splander100</button>


                            </form>
                        </li>
                    </ul>
                </div>
                <div class="col-xxl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                    <h3 class="ab">Bike By Color</h3>
                    <ul class="footertag p-0">
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf
                                <input type="hidden" name="exterior_color" value="4">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">White</button>
                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf
                                <input type="hidden" name="exterior_color" value="1">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Black</button>
                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf
                                <input type="hidden" name="exterior_color" value="7">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Silver</button>
                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf
                                <input type="hidden" name="exterior_color" value="8">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Grey</button>
                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf
                                <input type="hidden" name="exterior_color" value="2">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Blue</button>
                            </form>
                        </li>
                        <li>
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf
                                <input type="hidden" name="exterior_color" value="5">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Green</button>
                            </form>
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

                        <input type="text" class="form-control" placeholder="Your email" aria-label="Email">


                        <img src="{{ asset('web/bikes/images/Group 2640.svg') }}" alt="Send Icon">

                    </div>

                </div>

                <div class="col-xxl-2 d-none col-md-2 col-sm-4 col-6">
                    <h3 class="ab">Auto Services</h3>
                    <ul class="footertag p-0">
                        <li><a href="">Car repair</a></li>
                        <li><a href="">Auto detailing</a></li>
                        <li><a href="">Car wash</a></li>
                        <li><a href="">Body work</a></li>
                    </ul>
                </div>
                <div class="col-xxl-2 col-lg-2 col-md-2 col-sm-4 col-6">
                    <h3 class="ab">Bike By Body Type</h3>
                    <ul class="footertag p-0">
                        <li class="me-3">
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf
                                <input type="hidden" name="bodytype" value="7">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Retro</button>
                            </form>
                        </li>
                        <li class="me-3">
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf
                                <input type="hidden" name="bodytype" value="8">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Enduro</button>
                            </form>
                        </li>
                        <li class="me-3">
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf
                                <input type="hidden" name="bodytype" value="9">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Classic</button>
                            </form>
                        </li>
                        <li class="me-3">
                            <form method="post" target="_blank"
                                @if (Request::is('superadmin/*')) action="{{ route('superadmin.bikes.search') }}" @else  action="{{ route('bikes.search') }}" @endif>
                                @csrf
                                <input type="hidden" name="bodytype" value="10">
                                <button class="nav_custom_form_btns" type="submit"
                                    style="background: transparent;padding: unset;border: none;color: #B4B3B8;">Sport</button>
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

                    </ul>
                </div>
                <div class="col-xxl-2  col-lg-2 d-none col-md-3 col-sm-4 col-6">
                    <img src="{{ asset('web/bikes/images/image 10.svg') }}" class="img-fluid mb-2" alt="...">
                    <img src="{{ asset('web/bikes/images/image 11.svg') }}" class="img-fluid" alt="...">
                </div>
                <div class="row">
                    <div class="col-5 copyright">
                        <p style="color:#B4B3B8">© All rights reserved. Made by Auto Jazeera</p>
                    </div>
                    <div class="col-3 ms-auto copyright">
                        <p><span class="me-3"><a class="ankere" style="color:#B4B3B8" target="_blank"
                                    href="{{ route('term_condition') }}">Terms of use</a></span> <a class="ankere"
                                style="color:#B4B3B8" target="_blank" href="{{ route('privacy_policy') }}">Privacy
                                policy</a> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
