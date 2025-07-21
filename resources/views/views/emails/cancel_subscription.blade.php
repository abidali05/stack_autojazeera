<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Cancellation Confirmation</title>
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
            <p style="color: #1F1B2D; font-size: 12px; font-weight: 500;">We’re sorry to see you leave our platform. If there’s anything we can do to help you stay, please let us know—we’d be happy to assist. We respect your decision, and as of now, your subscription has been cancelled.<br>
You’re always welcome to return and take advantage of our platform to boost your sales. We’d also love to hear your feedback—please feel free to share it with us at feedback@autojazeera.com.</p>
        </div>
        
       
        <div style="text-align: center; margin-top: 80px;">
            <a href="{{url('subscription')}}" type="button" style="color: #ffffff; font-size: 12px; font-weight: 500; background-color: #FD5631; padding: 10px 10px; border: none; border-radius: 15px; text-decoration:none">Rejoin the Marketplace</a>
        </div>
        <div style="margin-top: 20px;">
            <p style="color: #1F1B2D; font-size: 14px; font-weight: 300;">Thanks again for you attention to this matter.</p>

        </div>
        <div style="margin-top: 20px;text-align:center; border-top:1px solid #1F1B2D">
            <p style="color: #1F1B2D; font-size: 14px; font-weight: 300;">Have any questions? <span style="color: #FD5631;">
                <a href="{{url('contact-us')}}" style="color: #FD5631; text-decoration: none;">Click here</a></span> to contact us.</p>
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
