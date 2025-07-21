<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trial Started</title>
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
            <p style="color: #1F1B2D; font-size: 12px; font-weight: 500;">Welcome to your free trial of <b><h4 style="display: inline;">{{ $product->name }}</h4></b>!</p>

            <p style="color: #1F1B2D; font-size: 12px; font-weight: 500;">
                Your trial has started! You now have access to premium features to help you explore all that we offer.
            </p>
            <ol style="color: #1F1B2D; padding: 0px; padding-left: 20px; font-size: 12px; font-weight: 500;">
                <li>Create and manage your listings with ease.</li>
                <li>Gain visibility and connect with potential customers.</li>
                <li>Utilize tools crafted for maximum productivity.</li>
            </ol>

            <p style="color: #1F1B2D; font-size: 12px; font-weight: 500;">
                Want to make the most of your trial? Our support team is ready to help — 
                <a href="{{url('contact-us')}}" style="color: red;">contact us anytime</a>.
            </p>

            <p style="color: #1F1B2D; font-size: 12px; font-weight: 500;">
                Enjoy your trial period and see how we can support your journey! 🚀
            </p>
        </div>

        <div style="margin-top: 20px;">
            <p style="color: #1F1B2D; font-size: 14px; font-weight: 300;">Any questions? <span style="color: #FD5631;">
                    <a href="{{url('contact-us')}}" style="color: #FD5631; text-decoration: none;">Click here</a></span> to contact us.
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
                <button type="button" style="background: none; border: none; padding: 0; margin-right:10px">
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
