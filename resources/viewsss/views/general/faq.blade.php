@extends('layout.website_layout.main')
@section('content')
<style>
	.accordion-button::after {
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' fill='none'%3e%3ccircle cx='256' cy='256' r='240' stroke='%23281F48' stroke-width='32'/%3e%3cpath d='M256 160v160m0 0l-80-80m80 80l80-80' stroke='%23281F48' stroke-width='32' stroke-linecap='round' stroke-linejoin='round'/%3e%3c/svg%3e") !important;
  background-repeat: no-repeat;

    background-repeat: no-repeat;
    background-size: 1rem 1rem;
}
.faq-background {
    background-image: url('/web/services/images/faqbackimg.svg'); /* <-- your correct path */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
<div class="faq-background">
    <!-- Banner -->
    <div class="container-fluid rounded-5 rounded-top-0 p-5" >
        <div class="container pt-5 pb-5">
            <div class="row align-items-center py-5">
                <div class="col-lg-6 py-4">
                    <h4 class="text-uppercase">Auto jazeera</h4>
                    <h1 class="" style="color: white !important;font-size:64px;font-weight:700;">Start Your Engine with Confidence</h1>
                    <p class="banner">FAQs that Drive You Forward </p>
                </div>
                <div class="col-lg-6 py-4">
                    <img src="{{asset('web/images/faqnew.svg')}}" alt="" srcset="" class="img-fluid">
                </div>
            </div>
        </div>

    </div></div>
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h4 class="sec mb-4"><strong>Frequently Asked Questions</strong></h4>
            </div>
            <div class="col-12">
                <div class="accordion" id="accordionExample">

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsezero" aria-expanded="true" aria-controls="collapsezero">
                      <strong>         What is Auto Jazeera?</strong>
                            </button>
                        </h2>
                        <div id="collapsezero" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                             AutoJazeera is an online platform where you can buy, sell, or promote cars, bikes, and auto services. Whether you're a private seller, dealer, or a car workshop owner — we make it easy and fast to connect with the right audience.
							
								
                            </div>
                        </div>
                    </div>

                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    <strong>           Who can use Auto Jazeera?</strong>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                  AutoJazeera is built for everyone involved in the automotive space — whether you're buying, selling, or offering auto services.
								<br><strong>🚗 Car & Bike Buyers</strong>
								<ul>
									<li>Browse listings using powerful filters to find exactly what you need.</li>
											<li>Contact sellers directly via call, chat, or WhatsApp.</li>
											<li>Send a “Request More Info” form and the seller will get back to you.</li>
									<li>Turn on price alerts to get notified when the price drops on vehicles you’re watching.</li>
								</ul>
								<strong>🏬 Car Dealers</strong>
								<ul>
									<li>Reach a nationwide audience and grow your dealership with ease.</li>
										<li>Our simple monthly subscription includes:	<br>
 ✅ Unlimited posting	<br>
 ✅ No ad expiry	<br>
 ✅ No extra charges for Featured Ads
</li>
										<li>Receive leads through:<br>
 📩 “Request More Info” forms<br>
 🔔 Price alert inquiries<br>
 💬 Chat, WhatsApp, and phone calls</li>
											<li>Manage your inventory, work your leads, and close deals — all from one place.</li>
								</ul>

								<strong>🔧 Auto Service Shops</strong>

								<ul>
									<li>Build a professional online presence by creating and maintaining your business page.</li>
												<li>AutoJazeera supports all types of automotive service providers, including:
													<ul>
														<li>Mechanics & Repair Shops</li>
															<li>Auto Electricians</li>
															<li>Tire & Battery Shops</li>
															<li>Spare Parts Dealers</li>
															<li>Car Wash, Detailing & Paint Services</li>
															<li>Vehicle Inspection Centers</li>
															<li>Car Accessories & Customization Shops</li>
													</ul>
									</li>
												<li>
									Once your page is live, customers can contact you through:<br>
 📞 Phone calls<br>
 💬 Live chat<br>
 📲 WhatsApp<br>
 📝 “Request a Quote” forms
</li>
												
								</ul>
Whether you’re a buyer, seller, dealer, or workshop owner — AutoJazeera is designed to help you connect, grow, and succeed.

 — AutoJazeera is built for all kinds of auto business. We are here to promote your auto ads and businesses.

								
                            </div>
                        </div>
                    </div>


                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  <strong>              What makes AutoJazeera different from other platforms?
</strong>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            
 We offer simple pricing with no hidden fees, include featured ads in every plan, provide smart tools like price alerts and Google distance filters, and our support team is fast and friendly.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
             <strong>                  Is AutoJazeera only for big dealers or businesses?
</strong>
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              Not at all. Whether you want to sell just one car or run a full auto business, we have plans and tools that fit your needs.

                            </div>
                        </div>
                    </div>
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsefour" aria-expanded="false" aria-controls="collapseThree">
                         <strong>      . How do I get started with AutoJazeera?
</strong>
                            </button>
                        </h2>
                        <div id="collapsefour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              Just sign up, choose your plan (or use the free one), and start posting your ads. You can also download our app for the easiest experience.
                            </div>
                        </div>
                    </div>
					<h4 class="sec  my-3"><strong>For Car Sellers (Individuals & Dealers)</strong></h4>
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsefive" aria-expanded="false" aria-controls="collapseThree">
                    <strong>           How do I post my car for sale?</strong>
                            </button>
                        </h2>
                        <div id="collapsefive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                             Just sign up, click “Post an Ad,” fill in your car details (like make, model, year, condition, price), add some photos, and submit.<br>
👉 Post Your Car Now

							
                            </div>
                        </div>
                    </div>
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsefivee" aria-expanded="false" aria-controls="collapseThree">
                              <strong>  Is it free to post a car ad?
</strong>
                            </button>
                        </h2>
                        <div id="collapsefivee" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                             Yes! Basic ads are free. You can pay for premium ads to get more attention.
                            </div>
                        </div>
                    </div>
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsesixx" aria-expanded="false" aria-controls="collapseThree">
                     <strong>        Can dealers post many cars?</strong>
                            </button>
                        </h2>
                        <div id="collapsesixx" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Yes, verified dealers can post lots of cars and use special dealer packages for easier management. <br>
👉 Subscriptions Packages

                            </div>
                        </div>
                    </div>
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsesix" aria-expanded="false" aria-controls="collapseThree">
                    <strong>           How long will my ad stay active?</strong>
                            </button>
                        </h2>
                        <div id="collapsesix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
								 Your ad stays live for 30 days. We’ll remind you before it expires, and you can renew or boost it anytime.<br>
👉 Manage My Ads

                            </div>
                        </div>
                    </div>
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseseven" aria-expanded="false" aria-controls="collapseThree">
                     <strong>          How do I boost my ad to get more buyers?
</strong>
                            </button>
                        </h2>
                        <div id="collapseseven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              Choose from our paid plan to feature your ads. Featured ads are always boosted top in the search.<br>
👉 Subscriptions Packages

                            </div>
                        </div>
                    </div>
					<h4 class="sec  my-3"><strong>	For Auto Mechanics & Car Shops</strong></h4>
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsesevenn" aria-expanded="false" aria-controls="collapseThree">
                          <strong>   Can I advertise my mechanic shop or auto service shop on auto jazeera platform ?</strong>
                            </button>
                        </h2>
                        <div id="collapsesevenn" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                           A: Absolutely! We welcome all kinds of auto service businesses, including:
								<ul>
									<li>Car Dealers</li>
											<li>Mechanics & Auto Repair Shops</li>
											<li>Auto Electricians</li>
											<li>Tire Shops</li>
											<li>Battery Shops</li>
											<li>Spare Parts Dealers</li>
											<li>Car Detailing & Cleaning Services</li>
											<li>Car Wash Services</li>
											<li>Car Painting & Body Shops</li>
											<li>Vehicle Inspection & Testing Centers</li>
											<li>Car Accessories & Customization Shops</li>
								</ul>

You can find all pricing plans for service providers on link below <br>
👉 List Your Shop Today
                            </div>
                        </div>
                    </div>
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsesevennn" aria-expanded="false" aria-controls="collapseThree">
                        <strong>        What types of businesses can advertise?
</strong>
                            </button>
                        </h2>
                        <div id="collapsesevennn" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               Any car-related business like repair shops, spare parts sellers, detailers, and more.<br>
👉 Advertise Your Business Today

                            </div>
                        </div>
                    </div>
					<h4 class="sec  my-3"><strong>		General Platform Questions</strong></h4>
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsesevennnn" aria-expanded="false" aria-controls="collapseThree">
                  <strong>          Is your platform available on mobile?</strong>
                            </button>
                        </h2>
                        <div id="collapsesevennnn" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              Yes, our website works great on mobile. Plus, you can download our app for Android and iOS for the best experience on the go.<br>
👉 Download Android/ iOS App

                            </div>
                        </div>
                    </div>
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsesevennnnn" aria-expanded="false" aria-controls="collapseThree">
                   <strong>           How do I contact a seller or dealer?</strong>
                            </button>
                        </h2>
                        <div id="collapsesevennnnn" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Each listing has buttons to call, WhatsApp, or message directly through our platform.<br>
👉 Browse Listings

                            </div>
                        </div>
                    </div>
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseeight" aria-expanded="false" aria-controls="collapseThree">
                   <strong>             Do you check if sellers and dealers are real?
</strong>
                            </button>
                        </h2>
                        <div id="collapseeight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              Yes, we verify dealers and mark trusted sellers so you can buy safely.

                            </div>
                        </div>
                    </div>
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseeightt" aria-expanded="false" aria-controls="collapseThree">
                    <strong>             How do I get help or contact support?
</strong>
                            </button>
                        </h2>
                        <div id="collapseeightt" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
								 You can reach us via:

                                <ul>
                                    <li >Phone Number: [Your WhatsApp Number]
</li>
                                    <li>Email: 
										<ul>
											<li>support@autojazeera.pk</li>
												<li>General questions: contactus@autojazeera.pk</li>
												<li>Payments: payments@autojazeera.pk
</li>
												<li>Feedback: feedback@autojazeera.pk
</li>
												<li>Marketing: marketing@autojazeera.pk
</li>
										</ul>
                                      </li>
                                    <li>
                                      Live Chat: Mon–Sat, 10am–7pm PKT<br>
 👉 Contact Support
</li>
                                </ul>
                            </div>
                        </div>
                    </div>
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsenine" aria-expanded="false" aria-controls="collapseThree">
          <strong>                    How can I send feedback or ideas?
</strong>
                            </button>
                        </h2>
                        <div id="collapsenine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               Email us anytime at feedback@autojazeera.pk — we love hearing from you!<br>
👉 Submit Feedback

							 
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseten" aria-expanded="false" aria-controls="collapseThree">
                       <strong>        What makes AutoJazeera special?
</strong>
                            </button>
                        </h2>
                        <div id="collapseten" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               👉 Why Choose Us
								<ul>
									<li>✅ Simple Pricing: One monthly fee, no confusing upselling.</li>
											<li>🚫 No Hidden Charges: Featured ads are included in flat monthly payment — no extra cost, no expiry.</li>
											<li>🖥️ Easy-to-Use Interface: Clean, modern design built for everyone.</li>
											<li>📱 Access Anywhere: Use our web platform or mobile app with the same ease.</li>
											<li>🔔 Price Alerts: Get notified instantly when a car matches your budget.</li>
											<li>📍 Google Address & Distance Tools: Auto-fill addresses and check how far listings are.</li>
											<li>🎯 Smart Search Filters: Easily find cars or services that match exactly what you need.</li>
											<li>💬 Built-In Live Chat: Chat with sellers, service providers, or our support team instantly.</li>
											<li>🙌 Friendly Support Team: Fast, local help whenever you need it.</li>
								</ul>

                            </div>
                        </div>
                    </div>
					<h4 class="sec  my-3"><strong>		Subscription Plans & Pricing</strong></h4>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetenn" aria-expanded="false" aria-controls="collapseThree">
                      <strong>        What subscription plans do you offer for car/bike ads?</strong>
                            </button>
                        </h2>
                        <div id="collapsetenn" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              👉 See All Car/Bike All Plans
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennn" aria-expanded="false" aria-controls="collapseThree">
               <strong>                What subscription plans do you offer for auto service business ads?
</strong>
                            </button>
                        </h2>
                        <div id="collapsetennn" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              👉 See All Auto Service Business Plans

                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn" aria-expanded="false" aria-controls="collapseThree">
                     <strong>          Is there a free plan?
</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               Yes, the First Gear plan is free forever with 2 ads limit for car enthusiasts only.<br>
👉 First Gear Plan Info

                            </div>
                        </div>
                    </div>
					     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn1" aria-expanded="false" aria-controls="collapseThree">
                     <strong>         Can I change my plan anytime?
</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn1" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              Yes, you can change your subscription plan anytime. Changes apply immediately, but no refunds for previous plan unused time. We recommend changing your plan one day before your current plan expires.<br>
👉 Manage Subscription


                            </div>
                        </div>
                    </div>
						     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn11" aria-expanded="false" aria-controls="collapseThree">
                     <strong>         Are there any additional charges for featured ads?

</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn11" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                  No, Featured Ads are included in your monthly plan at no extra cost. The number of Featured Ads you can post depends on your package type.<br>
 👉 See All Plans

                            </div>
                        </div>
                    </div>	  
					<div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn12" aria-expanded="false" aria-controls="collapseThree">
                     <strong>          Do featured ads expire?
</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn12" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               No, Featured Ads remain active until your car is sold. We recommend deleting your ad as soon as your car or bike is sold.


                            </div>
                        </div>
                    </div>
						     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn13" aria-expanded="false" aria-controls="collapseThree">
                     <strong>        Can I subscribe to both vehicle and service plans?

</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn13" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Yes, you can have one vehicle plan and one service plan at the same time.<br>
 👉 See All Plans

                            </div>
                        </div>
                    </div>		
						     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn14" aria-expanded="false" aria-controls="collapseThree">
                     <strong>How do I pay?

</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn14" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              Our platform offers a secure online payment system. We accept all major credit and debit cards, including Visa, MasterCard.<br>
 👉 See All Plans

                            </div>
                        </div>
                    </div>
			
						     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn15" aria-expanded="false" aria-controls="collapseThree">
                     <strong>          Do paid plans have a free trial?
</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn15" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                             Yes, a 1-month free trial is included for all paid plans.<br>👉 Start Free Trial Today

                            </div>
                        </div>
                    </div>
						     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn16" aria-expanded="false" aria-controls="collapseThree">
                     <strong>          What information will be displayed on Auto Service Business Page ?
</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn16" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            Business info, Google Maps address, hours, reviews, services, call/WhatsApp buttons, photo gallery, social media links, live chat, multi-user access.<br>
👉 Service Plan Features


                            </div>
                        </div>
                    </div>
						     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn17" aria-expanded="false" aria-controls="collapseThree">
                     <strong>          Can I cancel anytime?
</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn17" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                           Yes, you can cancel your monthly plan at any time. Please note that we do not offer refunds for unused time. We recommend canceling one day before your plan expires.

                            </div>
                        </div>
                    </div>
						     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn18" aria-expanded="false" aria-controls="collapseThree">
                     <strong>        Do you provide refunds?

</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn18" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                           We do not offer refunds for subscription payments, including unused time. Our plans run on a monthly basis, and we recommend canceling your plan one day before it expires. <br>
For any payment-related questions, please email us at payments@autojazeera.pk.

                            </div>
                        </div>
                    </div>
						     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn19" aria-expanded="false" aria-controls="collapseThree">
                     <strong>        Can I buy multiple plans?
</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn19" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            You can have one vehicle ad plan plus one service provider plan at the same time, but not multiple vehicle ad plans.


                            </div>
                        </div>
                    </div>
					<h4 class="sec  my-3"><strong>	Payments & Security</strong></h4>
						     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn31" aria-expanded="false" aria-controls="collapseThree">
                     <strong>       What payment methods do you accept?
</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn31" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              We accept all major credit and debit cards, securely processed.

                            </div>
                        </div>
                    </div>
											     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn32" aria-expanded="false" aria-controls="collapseThree">
                     <strong>          Is my payment safe?

</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn32" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                              Yes, payments are fully encrypted and your info is never stored on our servers.

                            </div>
                        </div>
                    </div>
							     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn33" aria-expanded="false" aria-controls="collapseThree">
                     <strong>     Are there any hidden fees?

</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn33" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                             No, our pricing is clear and fair — no hidden costs.


                            </div>
                        </div>
                    </div>
							     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn34" aria-expanded="false" aria-controls="collapseThree">
                     <strong>        Are subscription plans prepaid or postpaid?
</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn34" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                          Prepaid. We deduct the monthly subscription fee at the start of the month.

                            </div>
                        </div>
                    </div>
				<h4 class="sec  my-3"><strong>	Contact & Feedback</strong></h4>
						     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn340" aria-expanded="false" aria-controls="collapseThree">
                     <strong>         How can I contact AutoJazeera?
</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn340" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                       Email us anytime:
								<ul>
							
									<li>	General questions: contactus@autojazeera.pk</li>
											<li>Payments: payments@autojazeera.pk</li>
												<li>Feedback: feedback@autojazeera.pk</li>
												<li>Marketing: marketing@autojazeera.pk</li>
								</ul>

                            </div>
                        </div>
                    </div>
						     <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsetennnn345" aria-expanded="false" aria-controls="collapseThree">
                     <strong>        Do I need to buy a separate plan for my dealership business page?
</strong>
                            </button>
                        </h2>
                        <div id="collapsetennnn345" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                   Yes, if you want to showcase your dealership business page with features like business profile, contact buttons, and more, you need to purchase an Auto Service Provider plan separately from your car or bike ad posting plan.

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection