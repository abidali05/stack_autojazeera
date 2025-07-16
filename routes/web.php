<?php

use App\Models\User;
use App\Models\Document;
use App\Models\Province;
use App\Mail\PriceAlertMail;
use Illuminate\Http\Request;
use App\Mail\MonthlyPostEmail;
use App\Mail\InactivePostEmail;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OTPController;
use Kreait\Firebase\Auth as FirebaseAuth;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\User\AddsController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\LeadController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\Bikes\User\BikeController;
use App\Http\Controllers\User\ShopReviewController;
use App\Http\Controllers\ForgetPasswordControllerWeb;
use App\Http\Controllers\User\SubscriptionController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Bikes\User\BikeAdsController;
use App\Http\Controllers\Bikes\User\WishlistController;
use App\Http\Controllers\superadmin\AdsPlansController;
use App\Http\Controllers\User\UserdealeruserController;
use App\Http\Controllers\superadmin\WhishlistController;
use App\Http\Controllers\superadmin\PriceAlertController;
use App\Http\Controllers\Autoservices\ServiceChatController;
use App\Http\Controllers\Autoservices\ServiceUserController;
use App\Http\Controllers\superadmin\SubmittedFormController;
use App\Http\Controllers\Autoservices\ShopWishlistController;
use App\Http\Controllers\Bikes\superadmin\BikeMakeController;
use App\Http\Controllers\Bikes\User\BikePricealertController;
use App\Http\Controllers\superadmin\SuperadminAddsController;
use App\Http\Controllers\superadmin\SuperadminMakeController;
use App\Http\Controllers\superadmin\SuperadminUserController;
use App\Http\Controllers\superadmin\SuperadminColorController;
use App\Http\Controllers\superadmin\SuperadminModelController;


use App\Http\Controllers\Bikes\superadmin\BikeModelsController;
use App\Http\Controllers\superadmin\SuperadminDealerController;
use App\Http\Controllers\superadmin\SuperadminFeatureController;
use App\Http\Controllers\superadmin\SuperadminBodyTypeController;
use App\Http\Controllers\Bikes\superadmin\BikeBodyTypesController;
use App\Http\Controllers\superadmin\Autoservices\ServiceCategories;
use App\Http\Controllers\superadmin\SuperadminDealerUserController;
use App\Http\Controllers\superadmin\Autoservices\ServicesController;
use App\Http\Controllers\Bikes\superadmin\BikeMainFeaturesController;
use App\Http\Controllers\superadmin\Autoservices\AmenitiesController;
use App\Http\Controllers\superadmin\SuperadminSubscriptionController;
use App\Http\Controllers\Bikes\superadmin\BikeController as SuperadminBikeController;
use App\Http\Controllers\Autoservices\ServicesController as AutoservicesServicesController;
use App\Http\Controllers\Autoservices\superadmin\ShopController as SuperadminShopController;
use App\Models\Post;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('subscription-plans', [SubscriptionController::class, 'subscription_plans'])->name('subscription_plans');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('post', [PostController::class, 'addpost'])->name('addpost')->middleware('permission');
    Route::get('add-to-wishlist/{post_id}/{dealer_id}', [SuperadminAddsController::class, 'add_to_wishlist'])->name('add-to-wishlist');
    Route::get('add-price-alert/{post_id}/{dealer_id}', [SuperadminAddsController::class, 'add_price_alert'])->name('add-price-alert');
    Route::resource('dealer_user', UserdealeruserController::class);

    Route::get('dealer_user/change_status/{id}', [UserdealeruserController::class, 'change_status'])->name('dealer_user.change_status');

    Route::resource('whishlist', WhishlistController::class);
    Route::resource('price-alert', PriceAlertController::class);
    Route::resource('submitted-forms', SubmittedFormController::class);
    Route::get('submitted-bike-leads', [SubmittedFormController::class, 'submitted_bike_leads']);
    Route::resource('subscription', SubscriptionController::class);
    Route::get('subscription-history', [SubscriptionController::class, 'subscription_history'])->name('subscription_history');
    Route::get('service-subscription-history', [SubscriptionController::class, 'service_subscription_history'])->name('service_subscription_history');
    Route::get('subscription-plan', [SubscriptionController::class, 'plan'])->name('subscription_plan');
    Route::get('download-invoice/{id}', [SubscriptionController::class, 'downloadInvoice'])->name('downloadInvoice');
    Route::get('download-service-invoice/{id}', [SubscriptionController::class, 'downloadServiceInvoice'])->name('downloadServiceInvoice');
    //  Route::resource('lead', LeadController::class);
    Route::get('lead/', [LeadController::class, 'index'])->name('lead.index')->middleware('dealeruserpermissions:view_leads');
    Route::get('leads/bikes', [LeadController::class, 'bikeleads'])->name('bikes.lead.index')->middleware('dealeruserpermissions:view_leads');
    Route::get('lead/create', [LeadController::class, 'create'])->name('lead.create');
    Route::post('ads', [LeadController::class, 'store'])->name('lead.store');
    Route::get('lead/{id}/edit', [LeadController::class, 'edit'])->name('lead.edit');
    Route::put('lead/{id}', [LeadController::class, 'update'])->name('lead.update');
    Route::delete('lead/{id}', [LeadController::class, 'destroy'])->name('lead.destroy');


    Route::get('login-security', [SettingController::class, 'loginSecurity'])->name('login_security');
    Route::get('personal-info', [SettingController::class, 'personal_info'])->name('personal_info');
    Route::get('dealership-information', [SettingController::class, 'dealership_info'])->name('dealership_info');
    Route::post('change-password', [SettingController::class, 'change_password'])->name('change_password');
    Route::post('change-image', [SettingController::class, 'change_image'])->name('change_profile_image');
    Route::post('update-profile', [SettingController::class, 'profile'])->name('update_profile');
    Route::post('dealership_profile', [SettingController::class, 'dealership_profile'])->name('dealership_profile');
    Route::get('preview/{id}', [SuperadminAddsController::class, 'preview'])->name('preview');
    Route::get('view-invoice/{id}', [SubscriptionController::class, 'invoice'])->name('view.invoice');
    Route::get('complete-registration', [SettingController::class, 'complete_registration'])->name('complete_registration');
    Route::post('complete-registration', [SettingController::class, 'dealer_store'])->name('complete_registration_store');
    Route::get('cancel-plan', [SubscriptionController::class, 'cancel_plan'])->name('cancel_plan');
    Route::get('cancel-service-plan', [SubscriptionController::class, 'cancel_service_plan'])->name('cancel_service_plan');

    Route::get('signupwithfreeplan', [SubscriptionController::class, 'signupwithfreeplan'])->name('signupwithfreeplan');


    Route::get('get-price-alerts', [PriceAlertController::class, 'get_price_alerts'])->name('get_price_alerts'); // for dealer to see price alerts of users
    Route::get('dashboard', [SubscriptionController::class, 'dashboard'])->name('dashboard');

    // Route::resource('ads', AddsController::class)->middleware('dealeruserpermissions:addpost');
    Route::get('ads/', [AddsController::class, 'index'])->name('ads.index')->middleware('dealeruserpermissions:manage_ads');
    Route::get('ads/create', [AddsController::class, 'create'])->name('ads.create')->middleware('dealeruserpermissions:post_ads');
    Route::post('ads', [AddsController::class, 'store'])->name('ads.store')->middleware('dealeruserpermissions:post_ads');
    Route::get('ads/{id}/edit', [AddsController::class, 'edit'])->name('ads.edit')->middleware('dealeruserpermissions:manage_ads');
    Route::put('ads/{id}', [AddsController::class, 'update'])->name('ads.update')->middleware('dealeruserpermissions:manage_ads');
    Route::delete('ads/{id}', [AddsController::class, 'destroy'])->name('ads.destroy')->middleware('dealeruserpermissions:manage_ads');
    Route::get('deletepostold_image/{post_id}/{image_id}', [AddsController::class, 'deletepostold_image'])->name('deletepostold_image');


    // ==============================================bike module user =====================================================

    Route::group(['prefix' => 'bike', 'as' => 'bike_ads.'], function () {
        Route::get('ads/', [BikeAdsController::class, 'index'])->name('index')->middleware('dealeruserpermissions:manage_ads');
        Route::get('ads/create', [BikeAdsController::class, 'create'])->name('create')->middleware('dealeruserpermissions:post_ads');
        Route::post('ads', [BikeAdsController::class, 'store'])->name('store')->middleware('dealeruserpermissions:post_ads');
        Route::get('ads/{id}/edit', [BikeAdsController::class, 'edit'])->name('edit')->middleware('dealeruserpermissions:manage_ads');
        Route::put('ads/{id}', [BikeAdsController::class, 'update'])->name('update')->middleware('dealeruserpermissions:manage_ads');
        Route::delete('ads/{id}', [BikeAdsController::class, 'destroy'])->name('destroy')->middleware('dealeruserpermissions:manage_ads');
        Route::get('deletepostold_image/{post_id}/{image_id}', [BikeAdsController::class, 'deletepostold_image'])->name('deletepostold_image');

        // request more info (bike details page)
        Route::post('request-more-info', [BikeAdsController::class, 'request_more_info'])->name('request_more_info');
        // book an appointment for bike 
        Route::post('book-appointment', [BikeAdsController::class, 'book_appointment'])->name('book_appointment');


        // add wishlist 

        Route::get('add-to-wishlist/{post_id}', [WishlistController::class, 'add_to_wishlist'])->name('add-to-wishlist');
        Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist');
        Route::get('add-price-alert/{post_id}', [BikePricealertController::class, 'add_price_alert'])->name('add-price-alert');
        Route::get('price-alert', [BikePricealertController::class, 'index'])->name('price_alert');
    });

    // =============================================================CHAT MODULE===================================================================
    Route::get('chats', [ChatController::class, 'index'])->name('chats.index');
    Route::post('/set-user-online', [ChatController::class, 'setUserPresence'])->name('set.user.online');
    Route::post('/set-user-offline', [ChatController::class, 'setUserPresence'])->name('set.user.offline');

    Route::post('/create-chat', [ChatController::class, 'createChat'])->name('chat.create');
    Route::get('/get-user-chats', [ChatController::class, 'getUserChats'])->name('getuserchats');
    Route::get('/chat/{id}', [ChatController::class, 'showChatPage'])->name('chat.show');

    Route::post('/send-message', [ChatController::class, 'sendMessasge'])->name('sendMessage');







    // =============================================================User Shop Module=========================================================

    Route::resource('shop', ShopController::class);
    Route::resource('review', ShopReviewController::class);
    Route::get('delete-shop-image/{image_id}/{shop_id}', [ShopController::class, 'deleteShopImage'])->name('delete.shop.image');

    Route::get('service-quotes', [ShopController::class, 'get_quotes'])->name('user.quotes');


    Route::get('shops/wishlist', [ShopWishlistController::class, 'index'])->name('shops.wishlist');
    Route::get('shops/wishlist/{shop}/{user}', [ShopWishlistController::class, 'addRemoveShopWishlist'])->name('shops.wishlist.add');

    Route::middleware('serviceuserpermissions')->group(function () {

        Route::get('service/users', [ServiceUserController::class, 'index'])->name('service.users.index');
        Route::post('service/users/store', [ServiceUserController::class, 'store'])->name('service.users.store');
        Route::post('service/users/update/{id}', [ServiceUserController::class, 'update'])->name('service.users.update');
        Route::delete('service/users/delete/{id}', [ServiceUserController::class, 'delete'])->name('service.users.delete');
    });

    Route::get('submitted-service-quotes', [ShopController::class, 'get_submitted_quotes'])->name('submitted.service.quotes');

    Route::post('create-service-chat', [ServiceChatController::class, 'createChat'])->name('service.chat.create');
    Route::get('service-chats', [ServiceChatController::class, 'index'])->name('service.chat.index');
});
Route::get('/getBikeModels/{modelId}', [BikeController::class, 'get_model'])->name('getBikeModels');

Route::post('/search', [SuperadminAddsController::class, 'carlist'])->name('search');
Route::get('/search-data/{id}/{type}', [SuperadminAddsController::class, 'search_data'])->name('search_data');
Route::post('/check-price-range', [SuperadminAddsController::class, 'check_price_range'])->name('check-price-range');
Route::get('/', [SuperadminAddsController::class, 'welcome'])->name('home');
Route::get('car-detail/{id}', [SuperadminAddsController::class, 'cardetail'])->name('cardetail');
Route::get('contact-us', [GeneralController::class, 'contact'])->name('contact');
Route::post('contact-us', [GeneralController::class, 'contactUs'])->name('contactUs');



Route::get('bike-details/{id}', [BikeAdsController::class, 'bikedetail'])->name('bikedetail');
Route::post('bikes/search', [BikeController::class, 'search'])->name('bikes.search');
Route::post('/bikes/filter', [BikeController::class, 'filter'])->name('bikes.filter');
Route::get('bikes/{name}', [BikeController::class, 'new_used_bikes'])->name('new_used_bikes');
Route::get('/search-bikes/{id}/{type}', [BikeController::class, 'search_data'])->name('search_bikedata');
Route::post('/check-bike-price-range', [BikeController::class, 'check_price_range'])->name('check-bike-price-range');



require __DIR__ . '/auth.php';

Route::get('thankyou', [AddsController::class, 'thankyou'])->name('thankyou')->middleware('auth');
Route::get('superadmin/thankyou', [SuperadminAddsController::class, 'thankyou'])->name('superadmin.thankyou')->middleware('auth:superadmin');
//superadmin routes
Route::group(['prefix' => 'superadmin', 'as' => 'superadmin.'], function () {
    Route::get('login', [SuperadminController::class, 'showLoginForm'])->name('login');
    Route::post('login', [SuperadminController::class, 'login']);

    Route::middleware('auth:superadmin')->group(function () {
        Route::get('/dashboard', [SuperadminController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [SuperadminController::class, 'logout'])->name('logout');
        Route::get('post', [SuperadminController::class, 'addpost'])->name('addpost');
        Route::post('/subscription-update/{id}/update-status', [SuperadminSubscriptionController::class, 'updatestatus'])->name('updatestatus');

        Route::resource('dealer', SuperadminDealerController::class);
        Route::post('change-password', [SuperadminController::class, 'admin_change_password'])->name('change_password');
        Route::get('dealeruser/{id}', [SuperadminDealerUserController::class, 'index'])->name('dealeruser');
        Route::resource('dealer-user', SuperadminDealerUserController::class);
        Route::get('dealer-status-change/{id}', [SuperadminDealerController::class, 'change_status'])->name('dealer_status_change');
        Route::resource('user', SuperadminUserController::class);
        Route::get('/get-users-by-role', [SuperadminUserController::class, 'getUsersByRole']);
        Route::resource('ads', SuperadminAddsController::class);
        Route::post('ads/import', [SuperadminAddsController::class, 'import'])->name('ads.import');
        Route::get('adss/export', [SuperadminAddsController::class, 'export'])->name('adss.export');
        Route::get('deletepostold_image/{post_id}/{image_id}', [SuperadminAddsController::class, 'deletepostold_image'])->name('deletepostold_image');
        Route::get('change-post-status/{id}', [SuperadminAddsController::class, 'change_status'])->name('change_post_status');
        Route::post('change-post-status', [SuperadminAddsController::class, 'change_post_status'])->name('change_posts_status');
        Route::resource('subscription', SuperadminSubscriptionController::class);
        Route::resource('feature', SuperadminFeatureController::class);
        Route::resource('color', SuperadminColorController::class);
        Route::resource('make', SuperadminMakeController::class);
        Route::get('make-export', [SuperadminMakeController::class, 'export'])->name('make-export');
        Route::post('make-import', [SuperadminMakeController::class, 'import'])->name('make-import');
        Route::resource('bodytype', SuperadminBodyTypeController::class);
        Route::get('login-security', [SettingController::class, 'admin_loginSecurity'])->name('login_security');
        Route::get('personal-info', [SettingController::class, 'admin_personal_info'])->name('personal_info');
        Route::post('change-image', [SettingController::class, 'admin_change_image'])->name('change_profile_image');
        Route::post('update-profile', [SettingController::class, 'admin_profile'])->name('update_profile');
        // Add other routes that should be protected
        Route::get('cars/{name}', [SuperadminAddsController::class, 'Cars_data'])->name('cars');
        Route::get('add-to-wishlist/{post_id}/{dealer_id}', [SuperadminAddsController::class, 'add_to_wishlist'])->name('add-to-wishlist');
        Route::get('add-price-alert/{post_id}/{dealer_id}', [SuperadminAddsController::class, 'add_price_alert'])->name('add-price-alert');
        Route::get('bike-coming-soon', [SuperadminAddsController::class, 'comingsoon'])->name('comingsoon');
        Route::get('bike-details', [SuperadminAddsController::class, 'bike_details'])->name('bike_details');


        Route::get('/home', [SuperadminAddsController::class, 'welcome'])->name('home');
        Route::post('/search', [SuperadminAddsController::class, 'carlist'])->name('search');
        Route::get('/search-data/{id}/{type}', [SuperadminAddsController::class, 'search_data'])->name('search_data');
        Route::post('/check-price-range', [SuperadminAddsController::class, 'check_price_range'])->name('check-price-range');
        Route::get('/car-detail/{id}', [SuperadminAddsController::class, 'cardetail'])->name('cardetail');
        Route::get('preview/{id}', [SuperadminAddsController::class, 'preview'])->name('preview');

        Route::post('/check-email-create', [SuperadminDealerController::class, 'checkEmailCreate'])->name('check_email_create');
        Route::post('/check-email-update', [SuperadminDealerController::class, 'checkEmailUpdate'])->name('check_email_update');

        Route::post('/check-number-create', [SuperadminDealerController::class, 'checkNumberCreate'])->name('check_number_create');
        Route::post('/check-number-update', [SuperadminDealerController::class, 'checkNumberUpdate'])->name('check_number_update');

        // ====================superadmin bike module starts===================================
        Route::resource('bike-make', BikeMakeController::class);
        Route::get('export-bike-make', [BikeMakeController::class, 'export'])->name('export-bike-make');
        Route::post('import-bike-make', [BikeMakeController::class, 'import'])->name('import-bike-make');
        Route::resource('bike-model', BikeModelsController::class);
        Route::resource('bike-bodytype', BikeBodyTypesController::class);
        Route::resource('bike-features', BikeMainFeaturesController::class);


        Route::resource('bike-ads', SuperadminBikeController::class);
        Route::get('advertise', [SuperadminBikeController::class, 'advertise'])->name('advertise');

        // ====================superadmin bike module ends===================================


        // ====================superadmin service module ends===================================

        Route::resource('shops', SuperadminShopController::class);
        Route::post('update-shop-status', [SuperadminShopController::class, 'update_status'])->name('update_shop_status');

        Route::get('shop-reviews', [SuperadminShopController::class, 'shop_reviews'])->name('shop_reviews');
        Route::delete('delete-shop-review/{id}', [SuperadminShopController::class, 'delete_shop_review'])->name('delete_shop_review');

        Route::get('news-letter', [GeneralController::class, 'all_newsletters']);

        // ====================superadmin service module ends===================================

        // =================================================Autoservices module starts=====================================================

        Route::resource('service-categories', ServiceCategories::class);
        Route::resource('services', ServicesController::class);
        Route::resource('amenities', AmenitiesController::class);

        // =================================================Autoservices module ends=====================================================



        // =================================================Subscription Module start=====================================================

        Route::get('plans/ads', [AdsPlansController::class, 'index'])->name('ads_plans.index');
        Route::get('change-ads-plan-status/{id}', [AdsPlansController::class, 'change_status'])->name('ads_plans.change_status');

        Route::get('subscriptions/ads', [SuperadminSubscriptionController::class, 'ads_subscriptions'])->name('ads_subscriptions');
        Route::get('subscriptions/service', [SuperadminSubscriptionController::class, 'service_subscriptions'])->name('service_subscriptions');

        Route::post('check-dealer-posting-status', [SuperadminAddsController::class, 'check_dealer_posting_status'])->name('check_dealer_posting_status');

        // =================================================Subscription Module end=====================================================


    });
});
Route::get('dealer/{id}/ads/all', [SuperadminAddsController::class, 'allDealerAds'])->name('dealer.posts.all');
Route::get('dealer/{id}/bikes/all', [SuperadminAddsController::class, 'allDealerBikeAds'])->name('dealer.bikeposts.all');


//generals
Route::get('/getCities/{provinceId}', [GeneralController::class, 'get_city'])->name('get_city');
Route::get('/getCity/{provinceId}', [GeneralController::class, 'get_cities'])->name('get_cities');
Route::get('/getmodel/{modelId}', [GeneralController::class, 'get_model'])->name('get_model');
Route::get('/getmodels/{makeId}', [GeneralController::class, 'get_models'])->name('get_models');
Route::get('/term_condition', [GeneralController::class, 'term_condition'])->name('term_condition');
Route::get('/privacy_policy', [GeneralController::class, 'privacy_policy'])->name('privacy_policy');
Route::post('/subscribe', [GeneralController::class, 'subscribe'])->name('subscribe.store');
Route::get('/faqs', [GeneralController::class, 'faq'])->name('faq');
Route::get('/about-us', [GeneralController::class, 'aboutus'])->name('aboutus');


//googlr authorize
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);




Route::get('/checkotp', function () {
    return view('otpcheck');
});
Route::post('/request-otp', [OTPController::class, 'requestOTP']);
Route::post('/verify-otp', [OTPController::class, 'verifyOTP']);

Route::post('/send-number', [OTPController::class, 'sendOtpNumber'])->name('verify.number');
Route::post('/verify-number', [OTPController::class, 'verifyOtpNumber'])->name('verify.numberOTP');
Route::get('/number-verification/{user_id}', function ($user_id) {
    $check = \App\Models\User::findOrFail($user_id);
    return view('num_verification', compact('check'));
})->name('number.verification');

Route::post('/send-email-number', [OTPController::class, 'sendOtpEmail'])->name('verify.emailNumber');
Route::post('/verify-email-number', [OTPController::class, 'verifyOtpEmail'])->name('verify.emailNumberOTP');
Route::get('/emailNumber-verification/{user_id}', function ($user_id) {
    $check = \App\Models\User::findOrFail($user_id);
    return view('email_verification', compact('check'));
})->name('emailNumber.verification');


//dealer 
Route::get('cars/{name}', [AddsController::class, 'Cars_data'])->name('cars');
Route::get('bike-coming-soon', [AddsController::class, 'comingsoon'])->name('comingsoon');
Route::get('bike-details', [AddsController::class, 'bike_details'])->name('bike_details');
Route::get('/posts/{type}', [AddsController::class, 'filterPosts'])->name('filter.posts');

//patment integration


Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');

//Export 


Route::get('/export-forms', [ExportController::class, 'export'])->name('forms.export');


Route::post('/newsletter/submit', [GeneralController::class, 'newsletterSubmit'])->name('newsletter.submit');


Route::get('/forget-password', [ForgetPasswordControllerWeb::class, 'index'])->name('password.forget');
Route::post('/sendForgetOtp', [ForgetPasswordControllerWeb::class, 'sendForgetOtp'])->name('password.sendForgetOtp');
Route::post('verifyForgetOtp', [ForgetPasswordControllerWeb::class, 'verifyOtp'])->name('verifyForgetOtp');
Route::post('updateForgetPassword', [ForgetPasswordControllerWeb::class, 'updatePassword'])->name('updateForgetPassword');

Route::post('/update-image-order', function (Request $request) {
    $imageOrder = $request->imageOrder; // This is the array containing IDs and positions
    foreach ($imageOrder as $order) {
        $document = Document::find($order['id']); // Find document by ID
        if ($document) {
            $document->position = $order['position']; // Update the position
            $document->save(); // Save changes
        }
    }

    return response()->json(['success' => true]);
});

Route::get('/test', function () {
    return view('emails.welcome');
});


//cache route
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('optimize:clear');
    $exitCode1 = Artisan::call('route:cache');
    $exitCode2 = Artisan::call('config:cache');
    $exitCode3 = Artisan::call('cache:clear');
    return '<h1>clear cache</h1>';
});

Route::get('unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');


Route::get('/run-cronjobs', function () {
    $exitCode = Artisan::call('status:change');
});

Route::get('/subscription-cronjobs', function () {
    $exitCode = Artisan::call('stripe:notify-subscription-status');
});

Route::get('/monthly-posts', function () {
    Artisan::call('email:monthly-posts');
});

Route::get('/weekly-posts', function () {
    Artisan::call('notify:inactive-ads');
});

Route::get('services/featured', [AutoservicesServicesController::class, 'allFeaturedServices'])->name('services.featured');
Route::get('services/top-rated', [AutoservicesServicesController::class, 'allTopRatedServices'])->name('services.toprated');




Route::get('/send-test-email', function () {
    $testEmail = 'stackbuffersislamabad@gmail.com'; // Change to your email

    $user = User::whereHas('posts')->first(); // Fetch one user for testing

    if (!$user) {
        return 'No users found with posts this month.';
    }

    $posts = Post::latest()->take(5)->get();
    $user = User::where('email', 'stackbuffersislamabad@gmail.com')->first();

    try {
        Mail::to($testEmail)->send(new MonthlyPostEmail($user, $posts));
        return "Test email sent to $testEmail successfully!";
    } catch (\Exception $e) {
        return "Failed to send email: " . $e->getMessage();
    }
});

Route::get('/send-alert-email', function () {
    $testEmail = 'anabkhanm@gmail.com'; // Change to your email

    $user = User::whereHas('posts')->first(); // Fetch one user for testing

    $posts = $user->posts()
        // ->whereMonth('created_at', $currentMonth)
        // ->whereYear('created_at', $currentYear)
        ->get();

    try {
        Mail::to($testEmail)->send(new PriceAlertMail($posts));
        return "Test email sent to $testEmail successfully!";
    } catch (\Exception $e) {
        return "Failed to send email: " . $e->getMessage();
    }
});

// =================================================================BIKE MODULE========================================================================================


Route::get('/bikes', [BikeController::class, 'index'])->name('bikes.home');

Route::get('bike/bike-listing', [BikeController::class, 'listing'])->name('bike.listing');
Route::get('/advertise', [BikeController::class, 'advertise'])->name('advertise');


// =================================================================SERVICE MODULE========================================================================================
Route::get('services', [AutoservicesServicesController::class, 'index'])->name('services.home');

Route::get('shop-details/{id}', [ShopController::class, 'shopdetail'])->name('shopdetail');

Route::get('get-vehicle-body-type/{name}', [ShopController::class, 'get_vehicle_body_type'])->name('quote.get_vehicle_body_type');
Route::get('get-vehicle-make/{name}', [ShopController::class, 'get_vehicle_make'])->name('quote.get_vehicle_make');
Route::get('get-vehicle-model/{name}/{id}', [ShopController::class, 'get_vehicle_model'])->name('quote.get_vehicle_model');
Route::post('submit-service-quote', [ShopController::class, 'submit_quote'])->name('quote.submit');


Route::post('services/search', [AutoservicesServicesController::class, 'search'])->name('services.search');
Route::get('services/search', function () {

    return redirect('services');
});
Route::get('bikes/search', function () {

    return redirect('bikes');
});
Route::get('search', function () {

    return redirect()->route('home');
});


Route::get('services/{name}', [AutoservicesServicesController::class, 'searchByCategory'])->name('services.categorysearch');



Route::post('services/filter', [AutoservicesServicesController::class, 'filter'])->name('services.filter');

Route::get('download-invoice/{id}', [SubscriptionController::class, 'downloadInvoice'])->name('downloadInvoice');
Route::get('download-service-invoice/{id}', [SubscriptionController::class, 'downloadServiceInvoice'])->name('downloadServiceInvoice');


Route::get('/storage-link', function () {

    Artisan::call('storage:link');

    return '✅ Storage Link fixed';
});
