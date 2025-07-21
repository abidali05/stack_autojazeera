<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Upgraded</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;700&display=swap');
    </style>
</head>

<body style="font-family: 'Inter', sans-serif; margin: 0; padding: 0;">
    <div style="width: auto; margin: auto; background-color: white; border-radius: 10px; padding: 20px;">
        <div style="text-align: center; padding: 20px; border-bottom: 1px solid #1F1B2D;">
              <img src="{{asset('web/images/emallgo.png') }}" alt="Logo" style="height:50px; width:150px" class="img-fluid">
        </div>
        <div style="margin-top: 20px;">
            <p style="color: #1F1B2D; font-size: 22px; font-weight: 600;text-align:center">Credit Card Billing Failure</p>
   </div>
				   <div style="margin-top: 20px;text-align:center">
			  <img src="{{asset('web/images/emailbill.png')}}" alt="Logo" style="height:70px; width:100px" class="img-fluid">
		   </div>
		   <div style="margin-top: 20px;">
            <p style="color: #1F1B2D; font-size: 12px; font-weight: 500;text-align:center">
             We were unable to process your credit card payment for Auto Jazeera service on your 
            </p> <p style="color: #1F1B2D; font-size: 12px; font-weight: 500;text-align:center">
        http://xxxxxxxxxxxxxx.autojazeera.com
            </p>
			   </div>
            <div style="text-align: center; margin-top: 30px;">
            <a href="{{url('dashboard')}}" style="color: white; font-size: 12px; font-weight: 500; background-color: #FD5631; padding: 10px 20px; border: none; border-radius: 25px; text-decoration: none;">UPDATE MY BILLING</a>
        </div>
  <div style="margin-top: 20px;">
            <p style="color: #1F1B2D; font-size: 12px; font-weight: 500;">
             Your credit card transaction failed while attempting  to process a transaction for:
            </p>
	   </div><div style="margin-top: 20px;">
            <p style="color: #1F1B2D; font-size: 16px; font-weight: 600;">
        Rs 12000.00 - Standard Annual
            </p></div><div style="margin-top: 20px;">
			        <p style="color: #1F1B2D; font-size: 12px; font-weight: 500;">
     If you do not settle this invoice with 14 days of the involved date, your account may be suspended. Please contact us immediately If you have any questions or concerns regarding this notice
            </p>  </div><div style="margin-top: 20px;">
			   
            <p style="color: #1F1B2D; font-size: 12px; font-weight: 500;">
  Thanks again for you attention to this matter.
            </p>
			       </div>
      

        
        <div style="margin-top: 20px; border-top:1px solid #1F1B2D">
            <p style="color: #1F1B2D; font-size: 14px; font-weight: 300; text-align:center">Any questions? <span style="color: #FD5631;">
                    <a href="{{url('contact-us')}}" style="color: #FD5631; text-decoration: none;">Click here</a></span> to contact
                us.</p>
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
