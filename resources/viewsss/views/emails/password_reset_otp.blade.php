<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;700&display=swap');
    </style>
</head>

<body style="font-family: 'Inter', sans-serif;  margin: 0; padding: 0;">
    <div style="width: auto; margin: auto; background-color: white; border-radius: 10px; padding: 20px;">
        <div style="text-align: center; padding: 20px; border-bottom: 1px solid #1F1B2D;">
              <img src="{{asset('web/images/emallgo.png') }}" alt="Logo" style="height:50px; width:150px" class="img-fluid">
        </div>
        <div style=" margin-top: 20px; text-align: center;">
            <p style=" color: #FD5631; font-size: 18px; font-weight: 700;">OTP Verification</p>
            <p style=" color: #1F1B2D; font-size: 16px; font-weight: 700;">your account with the OTP below</p>
            <p style=" color: #1F1B2D; font-size: 16px; font-weight: 700;">Hi {{ $user->name }},</p>
            <p style=" color: #1F1B2D; font-size: 12px; font-weight: 500;">We’ve received a request to reset your password. To complete the process, please use the OTP below:</p>
                <!-- <input type="email" class="form-control text-center inputcolor" id="floatingInput"
                placeholder="enter opt" style=" color: #FD5631;
                font-size: 12px;
                font-weight: 500;
                padding: 10px;
                background-color: #1F1B2D;
                width:90%;
                border: 1px solid #FD5631;
                border-radius: 5px;"> -->
                <h3 style=" color: #FD5631">{{ $user->otp }}</h3>
               
        </div>
        
       

        
        <div style="margin-top: 20px;">
            <p style="color: #1F1B2D; font-size: 14px; font-weight: 300;">Any questions? <span style="color: #FD5631;">
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
