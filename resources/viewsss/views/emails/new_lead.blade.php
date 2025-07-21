<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Lead Alert!</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;700&display=swap');
    </style>
</head>

<body style="font-family: 'Inter', sans-serif; margin: 0; padding: 0;">
    <div style="width: auto; margin: auto; background-color: white; border-radius: 10px; padding: 20px;">
		
		 <div style="text-align: center; padding: 20px; border-bottom: 1px solid #1F1B2D;">
              <img src="{{asset('web/images/emallgo.png') }}" alt="Logo" style="height:50px; width:150px" class="img-fluid">
        </div>
        <div style="margin-top: 20px; margin-bottom:10px">
            <p style="color: #1F1B2D; font-size: 16px; font-weight: 500;text-align:center">
           New Sales Lead has been submitted in your account . Please login to your account to review details
            </p>
       
        </div>

		     <div style="width: 100%; margin: 0 auto; margin-top:20px;">
    <div style="display: flex; flex-wrap: wrap;width: 100%; gap: 20px; justify-content: space-between;">
                <div style="display: flex;width: 100%; flex-wrap: wrap; gap: 20px; justify-content: space-between;">
                
					    <div style="width:90%; display:flex; background-color:white;border-radius:10px;    margin-right: 17px; border:1px solid #1F1B2D">
                            <div style="background: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow: hidden; transition: 0.3s ease-in-out; width: 30%; height: 170px; text-align: center;">
                                <div>
                                       <img src="{{ $post->image }}" alt="Car Image" style="max-width: 100%;height: 180px; object-fit: contain; object-position: center; display: block; margin: 0 auto;">  
                                </div>
 </div>
                                <div style="padding: 10px; width:70%; ">
                                    <div style="display:flex">
										<div>    <p style="margin:0px; color:#1F1B2D ; font-size:12px;font-weight:600"> {{ $post->year ?? 'N/A' }} </p></div>
                                        <div style="    margin-left: auto;">
                                     @if ($post->feature_ad == 1)
                                              <span style="padding: 5px 5px; border-radius: 5px; font-size: 8px; font-weight: bold; display: flex; background-color:#BF0000; color:#fff;">
                                                  <!-- <img src="{{ asset('web/images/star-icon.svg') }}" style="margin-bottom: 1px; margin-right: 2px;"> -->
                                                    Featured
                                                </span>
                                    @endif  
                                       <span style="padding: 5px 5px; border-radius: 5px; font-size: 8px; font-weight: bold; display: flex; background-color:{{ $post->condition == 'new' ? '#4581F9' : '#0EB617' }} ; color:#fff;">
                                                {{ ucfirst($post->condition) }} 
                                            </span>
                                        </div>
                                    </div>

                                  <h2 style="font-size: 16px; font-weight: bold; margin: 10px 0;color:#1F1B2D;margin:0px"> {{ $post->makename ?? 'Unknown Make' }} {{ $post->modelname ?? 'Unknown Model' }} </h2>
									
									<h5 style="font-size: 14px; color: #FD5631;margin:0px ;margin-bottom:10px"><b>PKR  {{ number_format($post->price, 0) }} </b></h5>

                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                       <h5 style="margin: 0; color:#1F1B2D">
                                            <i class="bi bi-geo-alt"></i>
                                          {{ $post->location->cityname ?? 'Location Not Available' }} 
                                        </h5>
										 
                                       
										     <span style="font-size:8px; color:#1F1B2D ;     margin-left: auto;
    padding-top: 2px;">
                                            Last Updated: {{ $post->updated_at ? $post->updated_at->format('F j, Y') : 'N/A' }} 
                                        </span>
                                    </div>

                                    <hr style="border: 0; height: 1px; background: #66666680; margin: 10px 0;">

                                    <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                                        <div style="background-color:#002D690F;width:30%; margin-right: 20px; color:#281F48; padding: 5px 10px; border-radius: 10px; text-align: center;">
                                            <i class="{{ $post->mileage_icon }}"></i>  
											<p style="margin: 5px 0; font-size: 8px;color:#281F48"> {{ $post->milleage ?? 'N/A' }} KM</p>
                                        </div>
                                        <div style="background-color:#002D690F;width:30%; margin-right: 20px; color:#281F48; padding: 5px 10px; border-radius: 10px; text-align: center; ">
                                        <i class="{{ $post->transmission_icon }}"></i> 
											<p style="margin: 5px 0; font-size: 8px; color:#281F48">{{ ucfirst($post->transmission ?? 'N/A') }} </p>
                                        </div>
                                        <div style="background-color:#002D690F;width:30%; margin-right: 20px; color:#281F48; padding: 5px 10px; border-radius: 10px; text-align: center; ">
                                          <i class="{{ $post->fuel_icon }}"></i> 
											<p style="margin: 5px 0; font-size: 8px; color:#281F48">{{ ucfirst($post->fuel ?? 'N/A') }} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
						
                   
                        </div>
              
                </div>
      
    </div>
	
		
     <div style="text-align: center; margin-top: 40px;">
            <a href="" style="color: white; font-size: 12px; font-weight: 500; background-color: #FD5631; padding: 10px 20px; border: none; border-radius: 15px; text-decoration: none;">Go to my account</a>
        </div>
	    <div style="margin-top: 20px;">
            <p style="color: #1F1B2D; font-size: 12px; font-weight: 500;">
        Thanks again for you attention to this matter.
            </p>
          
        </div>
       <div style="margin-top: 20px; text-align:center;border-top:1px solid white">
             <p style="color: #1F1B2D; font-size: 14px; font-weight: 300;">
               Any Question? <span style="color: #FD5631;">
                    <a href="{{url('contact-us')}}" style="color: #FD5631; text-decoration: none;"> Click here</a>
                </span>  to contact us.
            </p>
        </div>

             <div style="text-align: center; margin-top: 20px;">
            <div style="display: flex; justify-content:space-between; width: 350px; margin: auto;">
                <button type="button" style="background: none; border: none; padding: 0; margin-left:40px;margin-right:10px">
                    <img src="{{asset('web/images/email_assets/images/facebook.png')}}" alt="Facebook" style="width: 40px;">  
                </button>
                <button type="button" style="background: none; border: none; padding: 0; margin-right:10px">
                    <img src="{{asset('web/images/email_assets/images/insta1.png')}}" alt="Instagram" style="width: 40px;">
                </button>
                <button type="button" style="background: none; border: none; padding: 0; margin-right:10px ">
                    <img src="{{asset('web/images/email_assets/images/lasttwuiter.png')}}" alt="Twitter" style="width: 40px;">
                </button>
				  <button type="button" style="background: none; border: none; padding: 0; margin-right:10px">
                <img src="{{asset('web/images/youtube.png')}}" alt="Youtube" style="width: 40px;">

                </button>
				  <button type="button" style="background: none; border: none; padding: 0;  margin-right:10px">
           <img src="{{asset('web/images/tiktok.png')}}" alt="Tiktok" style="width: 40px;">

                </button>
                
            </div>
        </div>
    </div>
</body>

</html>
