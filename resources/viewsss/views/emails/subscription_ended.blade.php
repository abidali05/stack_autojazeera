<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Card Billing Failure</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;700&display=swap');
    </style>
</head>

<body style="font-family: 'Inter', sans-serif;  margin: 0; padding: 0;">
    <div style="width: auto; margin: auto; background-color: white; border-radius: 10px; padding: 20px;">
        <div style="text-align: center; padding: 20px; border-bottom: 1px solid #1F1B2D;">
              <img src="{{asset('web/images/emallgo.png') }}" alt="Logo" style="height:50px; width:150px" class="img-fluid">
        </div>
        <div style=" margin-top: 20px;">
            <p style="color: #1F1B2D; font-size: 12px; font-weight: 500;">We noticed that your subscription has ended, and we want to make
                sure
                you don't miss out on all the great benefits our platform offers. To continue
                enjoying our services, simply log in to your account and activate your subscription
                from the available plans.<br>
                Your business is important to us, and we truly appreciate the trust you’ve placed in
                our platform. If there’s anything we can do to assist or improve your experience,
                we’re here to help!<br>
                Thank you for being a valued part of our community. If you decide to return, we’re
                always here to support you in boosting your sales. We’d also love to hear your
                feedback—please send any thoughts or suggestions to feedback@autojazeera.com. Your
                feedback helps us improve and serve you better.</p>
        </div>
        
       
        <div style="text-align: center; margin-top: 60px;">
            <a href="{{url('dashboard')}}" type="button" style="color: #ffffff; font-size: 12px; font-weight: 500; background-color: #FD5631; padding: 10px 10px; border: none; border-radius: 15px; text-decoration:none">Go to my account</button>
        </div>
		<div style="margin-top: 20px;">
		<p style="color: #1F1B2D; font-size: 14px; font-weight: 300;">Thanks again for you attention to this matter.</p>
			<p style="color: #1F1B2D; font-size: 14px; font-weight: 300;">You subscribed to these notifications. If you no longer wish to receive these notifications, please unsubscribe <span style="color:#FD5631">here.</span></p>
		</div>
        <div style="margin-top: 20px;text-align:center;border-top:1px solid #1F1B2D">
            <p style="color: #1F1B2D; font-size: 14px; font-weight: 300;">Any questions? <span style="color: #FD5631;">
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
