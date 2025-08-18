<?php

use Illuminate\Http\Request;
use App\Jobs\SendFcmNotification;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\ApiPostController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ApiNumbereController;
use App\Http\Controllers\Api\ApiPackageController;
use App\Http\Controllers\Api\ApiProfileController;
use App\Http\Controllers\Api\Bike\BikeLeadsController;
use App\Http\Controllers\Api\Bike\BikePostController;
use App\Http\Controllers\Api\Bike\BikePriceAlertController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\RegisterationController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\DealerUserController;
use App\Http\Controllers\Api\Services\ShopController;
use App\Http\Controllers\Api\Services\ShopWishlistController;
use App\Http\Controllers\Api\Subscription\SubscriptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/user-register', [RegisterationController::class, 'register']);
Route::post('/login', [RegisterationController::class, 'login']);
Route::post('/verify-login-otp', [RegisterationController::class, 'verifyLoginOtp']);
Route::post('/social-login', [RegisterationController::class, 'social_login']);
Route::post('/logout', [RegisterationController::class, 'logout']);
Route::post('/save-payment', [RegisterationController::class, 'savePayment']);
// JS
Route::post('/signin', [RegisterationController::class, 'signin']);
Route::post('/signup', [RegisterationController::class, 'signup']);
Route::post('/send_otp', [RegisterationController::class, 'send_otp']);
Route::post('/verify_otp', [RegisterationController::class, 'verify_otp']);


Route::post('/verification', [RegisterationController::class, 'verification']);

//stripe
Route::get('/plans', [ApiPostController::class, 'plans']);
Route::get('subscription', [ApiPostController::class, 'subscription']);

//filers
Route::get('model', [FilterController::class, 'model']);
Route::get('make', [FilterController::class, 'make']);
Route::get('city', [FilterController::class, 'city']);
Route::get('bodytype', [FilterController::class, 'bodytype']);
Route::get('used-car', [FilterController::class, 'usedcar']);
Route::get('new-car', [FilterController::class, 'newcar']);
Route::post('search', [FilterController::class, 'search']);
Route::get('color', [FilterController::class, 'color']);
Route::get('province', [FilterController::class, 'province']);
Route::get('feature', [FilterController::class, 'feature']);
//forget api
Route::post('send-email', [ForgetPasswordController::class, 'forgetPassword']);
Route::post('reset-password', [ForgetPasswordController::class, 'reset_password']);

//register number
Route::post('request-otp', [ApiNumbereController::class, 'requestOTP']);
Route::post('verify-otp', [ApiNumbereController::class, 'verifyOTP']);
//post
Route::middleware('refresh.token')->group(function () {
    Route::post('add-post', [ApiPostController::class, 'store']);
    Route::get('wishlist', [ApiPostController::class, 'wishlist']);
    Route::post('add-wishlist', [ApiPostController::class, 'addWishlist']);
    Route::post('clear-wishlist', [ApiPostController::class, 'clearWishlist']);
    Route::get('dealer-inventory', [ApiPostController::class, 'dealer_inventory']);
    Route::get('profile', [ApiProfileController::class, 'getUserprofile']);
    Route::post('profile-edit', [ApiProfileController::class, 'profile']);
    Route::post('apponitment', [ApiPostController::class, 'submitted_form']);
    Route::post('test_drive', [ApiPostController::class, 'submitted_form']);
    Route::post('inquiry', [ApiPostController::class, 'submitted_form']);
    Route::post('information', [ApiPostController::class, 'submitted_form']);
    Route::post('emil-friend', [ApiPostController::class, 'submitted_form']);
    Route::post('dealer-register', [ApiProfileController::class, 'register']);
    Route::post('manage-subscription', [ApiProfileController::class, 'planChange']);
    Route::get('previous-subscriptions', [ApiProfileController::class, 'previousSubscriptions']);
    Route::post('cancel_plan', [ApiProfileController::class, 'cancelPlan']);
    Route::post('Plans', [ApiPackageController::class, 'plan']);
    Route::get('submited-form', [ApiPostController::class, 'submited_form']);
    Route::get('received-form', [ApiPostController::class, 'received_form']);
    Route::post('contact-us', [ApiPostController::class, 'ContactUs']);
    Route::post('dealer-contact', [ApiPostController::class, 'dealer_contact']);
    Route::get('my-ads', [ApiPostController::class, 'my_ads']);
    Route::post('find-cars', [ApiPostController::class, 'find_cars']);
    Route::post('similar-ads', [ApiPostController::class, 'similar_cars']);
    Route::post('delete-post', [ApiPostController::class, 'delete_post']);
    Route::post('update-post', [ApiPostController::class, 'update_post']);
    Route::post('price-alert', [ApiPostController::class, 'price_alert']);
    Route::get('price-drop', [ApiPostController::class, 'price_drop']);
    Route::get('leads', [ApiPostController::class, 'leads']);
    Route::post('dealer-inventory', [ApiPostController::class, 'delete_dealer_inventory']);
    Route::post('submited-form', [ApiPostController::class, 'delete_submited_form']);
    // Route::get('get-dealer-post',[ApiPostController::class, 'get_dealer_post']);
    Route::get('get-car-details/{id}', [ApiPostController::class, 'getcardetails']);

    // ============================================================bike module===========================================================

    Route::post('add-bike-post', [BikePostController::class, 'store']);
    Route::post('update-bike-post', [BikePostController::class, 'update']);
    Route::get('get-bike-posts', [BikePostController::class, 'index']);                    //my ads
    Route::get('get-bike-features', [BikePostController::class, 'get_features']);
    Route::get('get-bike-bodytypes', [BikePostController::class, 'get_bodytypes']);
    Route::get('get-bike-makes', [BikePostController::class, 'get_makes']);
    Route::post('delete-bike-post', [BikePostController::class, 'deleteBikePost']);
    Route::post('get-bike-models', [BikePostController::class, 'get_models']);
    Route::post('bike-search', [BikePostController::class, 'search']);                     //bike search main home screen filter 
    Route::post('bike-advance-search', [BikePostController::class, 'advancedSearch']);     // bike advanced filters
    Route::post('add-bike-wishlist', [BikePostController::class, 'addRemoveWishlist']);    // add/remove to wishlist 
    Route::post('clear-bike-wishlist', [BikePostController::class, 'clearwishlist']);      // clear all wishlist 
    Route::get('get-bike-wishlist', [BikePostController::class, 'getwishlist']);      // clear all wishlist 
    Route::get('new-bikes', [BikePostController::class, 'newbikes']);
    Route::get('used-bikes', [BikePostController::class, 'usedbikes']);
    Route::get('get-all-bikes', [BikePostController::class, 'getallbikes']);
    Route::post('get-bike-details', [BikePostController::class, 'getbikedetails']);
    Route::post('get-bike-similar-ads', [BikePostController::class, 'similar_ads']);


    Route::post('add-bike-price-alert', [BikePriceAlertController::class, 'addRemoveBikePriceAlert']);
    Route::post('clear-bike-price-alert', [BikePriceAlertController::class, 'clearpricealert']);      // clear all price alert 
    Route::get('get-bike-price-alert', [BikePriceAlertController::class, 'index']);

    Route::post('update-view-counts', [BikePostController::class, 'udpateviews']);



    Route::post('request-bike-more-info', [BikeLeadsController::class, 'submit']);         // request more info
    Route::get('my-submitted-bike-leads', [BikeLeadsController::class, 'mySubmittedBikeLeads']);   // my submitted leads
    Route::post('clear-bike-leads', [BikeLeadsController::class, 'clearBikeLeads']);   // clear  leads

    Route::get('view-bike-leads', [BikeLeadsController::class, 'viewBikeLeads']);
});

// Route::post('budget-cars',[ApiPostController::class,'budgetCars']);
// Route::post('charge',[ApiPostController::class,'charge']);


Route::get('employees', [DealerUserController::class, 'getAllDealerUsers']);
Route::post('employee', [DealerUserController::class, 'store']);
Route::post('employe_update', [DealerUserController::class, 'update']);
Route::post('employe_delete', [DealerUserController::class, 'delete']);
Route::post('change_employe_status', [DealerUserController::class, 'changeStatus']);



Route::post('store-fcm-token', [NotificationController::class, 'store_fcm_token']);
Route::post('make-payment', [PaymentController::class, 'processPayment']);
Route::post('make-trial-payment', [PaymentController::class, 'processTrialPayment']);

Route::post('signup-free-plan', [PaymentController::class, 'signupwithfreeplan']);
Route::post('news-letter', [NotificationController::class, 'newsLetter']);
Route::get('findCarById', [ApiPostController::class, 'findCarById']);
Route::post('uploadAttachment', [ApiPostController::class, 'uploadAttachment']);
Route::post('uploadShopAttachment', [ApiPostController::class, 'uploadShopAttachment']);
Route::post('update-login-profile', [RegisterationController::class, 'update_login_profile']);

Route::post('/send-notification', function (Request $request) {
    // dd($request->all());
    try {
        SendFcmNotification::dispatch($request->tokens, $request->notification);
        return response()->json(['success' => true, 'response' => 'notification sent'], 200);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
    }
});




// ===================================================Services Module========================================================

Route::get('services/all', [ShopController::class, 'services']);
Route::get('amenities', [ShopController::class, 'amenities']);
Route::get('service-categories', [ShopController::class, 'service_categories']);
Route::get('category-services/{id}', [ShopController::class, 'category_services']);  // get shops by category id
Route::get('get-services/{id}', [ShopController::class, 'get_services']);  // get services by category id

Route::post('shop/create', [ShopController::class, 'create_shop']);
Route::get('shop/details', [ShopController::class, 'shop_detail']); //own shop details
Route::post('shop/update', [ShopController::class, 'update_shop']);

Route::get('shop/details/{id}', [ShopController::class, 'shop_details']);

Route::get('featured-services', [ShopController::class, 'get_featured_services']);  // home page 
Route::get('toprated-services', [ShopController::class, 'get_top_rated_services']);  // home page 

Route::get('services/wishlist', [ShopWishlistController::class, 'get_wishlist']);  
Route::post('services/wishlist/add/{id}', [ShopWishlistController::class, 'add_remove_shop_wishlist']);  

Route::get('get-subscription-plans', [SubscriptionController::class, 'get_subscription_plans']);
Route::post('submit-service-quote', [ShopController::class, 'submit_service_quote']);
Route::get('submitted-service-quotes', [ShopController::class, 'submitted_service_quotes']);
Route::get('received-service-quotes', [ShopController::class, 'received_service_quotes']);
Route::post('filter-services', [ShopController::class, 'filter_services']);
Route::post('filter-services-advanced', [ShopController::class, 'filter_services_advanced']);
Route::post('submit-review', [ShopController::class, 'submit_review']);


Route::get('service-users' ,[ShopController::class, 'service_users']);
Route::get('service-user/{id}' ,[ShopController::class, 'get_service_user']);
Route::post('create-service-user' ,[ShopController::class, 'create_service_user']);
Route::post('update-service-user/{id}' ,[ShopController::class, 'update_service_user']);
Route::delete('delete-service-user/{id}' ,[ShopController::class, 'delete_service_user']);

Route::get('get-price-alert-leads' ,[ShopController::class, 'get_price_alert_leads']);
Route::get('clear-service-wishlist', [ShopWishlistController::class, 'clear_wishlist']);      // clear all wishlist






