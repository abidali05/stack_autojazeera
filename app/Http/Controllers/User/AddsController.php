<?php

namespace App\Http\Controllers\User;

use Exception;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Invoice;

use Stripe\Product;
use App\Models\City;
use App\Models\Post;
use App\Models\User;
use Stripe\Customer;
use App\Models\Color;
use App\Models\Feature;
use App\Models\BodyType;
use App\Models\Document;
use App\Models\location;
use App\Models\Province;
use Stripe\Subscription;

use App\Models\PriceAlert;
use App\Models\ContactInfo;
use App\Models\MainFeature;
use App\Models\MakeCompany;
use App\Mail\PriceAlertMail;
use App\Models\ModelCompany;
use Illuminate\Http\Request;
use App\Models\Bike\BikePost;
use App\Models\FacebookToken;
use App\Models\AdsSubscriptions;
use App\Jobs\SendFcmNotification;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\AdsSubscriptionPlans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\FacebookPageService;
use Illuminate\Support\Facades\Validator;

class AddsController extends Controller
{
    protected $facebook;

    public function __construct(FacebookPageService $facebook)
    {
        $this->facebook = $facebook;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $query = Post::query();

            $search = $request->search;

            // Check for matching make and model
            $check = MakeCompany::where('name', $request->search)->first();
            $check2 = ModelCompany::where('name', $request->search)->first();

            // Safely extract IDs
            $makeId = $check ? $check->id : null;
            $modelId = $check2 ? $check2->id : null;

            // Search in multiple columns
            $query->where(function ($q) use ($search, $makeId, $modelId) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere(function ($query) use ($makeId) {
                        if ($makeId) {
                            $query->where('make', 'like', '%' . $makeId . '%');
                        }
                    })
                    ->orWhere(function ($query) use ($modelId) {
                        if ($modelId) {
                            $query->where('model', 'like', '%' . $modelId . '%');
                        }
                    })
                    ->orWhere('year', $search)
                    ->orWhere('dealer_comment', 'like', '%' . $search . '%');
            });

            // Include relationships if necessary
            $posts = $query->with(['document' => function ($q) {
                $q->orderBy('position', 'asc');
            }])->get();
        } elseif ($request->post_id) {
            $user = Auth::user();
            if ($user->role == 2) {
                $posts = Post::with(['feature', 'document' => function ($q) {
                    $q->orderBy('position', 'asc');
                }, 'location', 'contact'])->orderby('id', 'desc')->where(['id' => $request->post_id, 'dealer_id' => $user->dealer_id, 'employee_id' => $user->id])->get();
            } else {
                $posts = Post::with(['feature', 'document' => function ($q) {
                    $q->orderBy('position', 'asc');
                }, 'location', 'contact'])->orderby('id', 'desc')->where(['id' => $request->post_id, 'dealer_id' => Auth::user()->id])->get();
            }
            // $posts = Post::with('feature', 'document', 'location', 'contact')->orderby('id', 'desc')->where(['id' => $request->post_id, 'dealer_id' => Auth::user()->id])->get();
        } else {
            $user = Auth::user();
            // dd($user);
            if ($user->role == 2) {
                // $posts = Post::with(['feature', 'document' => function ($q) {
                //     $q->orderBy('position', 'asc');
                // }, 'location', 'contact'])->orderby('id', 'desc')->where(['dealer_id' => $user->dealer_id, 'employee_id' => $user->id])->get();
                $posts = Post::with(['feature', 'document' => function ($q) {
                    $q->orderBy('position', 'asc');
                }, 'location', 'contact'])->orderby('id', 'desc')->where(['dealer_id' => $user->dealer_id])->get();
            } else {
                $posts = Post::with(['feature', 'document' => function ($q) {
                    $q->orderBy('position', 'asc');
                }, 'location', 'contact'])->orderby('id', 'desc')->where('dealer_id', Auth::user()->id)->get();
            }
        }
        return view('user.post.index', compact('posts'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        // $post = Post::find(136);
        
        //  $this->facebook->publishPost($post, null , auth()->user());
        //  dd('posted');
         
         
        $user = Auth::user();
        $userId = $user->role == 2 ? $user->dealer_id : $user->id;

        $user = User::find($userId);
        if ($user->role == '1' || $user->role == 1) {
            // check if facebook token exists or not 
            $check = FacebookToken::where('dealer_id', $user->id)->where('type', 'dealer')->first();
            if (!$check) {
                session('facebook_redirect_url', route('ads.create'));
                return redirect()->route('facebook.login');
            } else {
          
                // check if token is expired or not
                $check = FacebookToken::where('dealer_id', $user->id)->where('type', 'dealer')->first();
                if ($check) {
                    $tokenCreatedDate = Carbon::parse($check->created_at);
                    $daysSinceCreated = $tokenCreatedDate->diffInDays(Carbon::now());

                    if ($daysSinceCreated >= 60) {
                        session(['facebook_redirect_url' => route('ads.create')]);
                        return redirect()->route('facebook.login');
                    }
                }
            }
        }

        if (empty($user->package)) {
            return redirect()->route('dashboard')->with('error', 'Please upgrade your plan to post an ad.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $customer = $this->getOrCreateCustomer($user);

        $invoices = Invoice::all([
            'customer' => $customer->id,
            'limit' => 100000,
            'expand' => ['data.lines.data.price']
        ])->data;

        $hasValidAdSubscription = false;

        foreach ($invoices as $invoice) {
            $subscriptionId = $invoice->subscription;
            if (!$subscriptionId) continue;

            try {
                $sub = Subscription::retrieve($subscriptionId);
                $type = $sub->metadata['sub_type'] ?? null;

                if ($type === 'ads') {
                    $end = $sub->current_period_end ?? null;
                    $status = $sub->status;

                    if (($status === 'active' || $status === 'trialing') && $end && Carbon::now()->lt(Carbon::createFromTimestamp($end))) {
                        $hasValidAdSubscription = true;
                        break;
                    }
                }
            } catch (Exception $e) {
                continue;
            }
        }

        if (!$hasValidAdSubscription) {
            return redirect()->route('dashboard')->with('error', 'Please upgrade your subscription to post an ad.');
        }

        try {
            $plan = Product::retrieve($user->package);
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Subscription plan not found.');
        }

        $posted_ads = Post::where('dealer_id', $userId)->count();
        $posted_ads2 = BikePost::where('dealer_id', $userId)->count();
        $total_ads = $posted_ads + $posted_ads2;

        if (($plan->metadata->allowed_ads ?? '0') !== 'unlimited' && $total_ads >= (int) $plan->metadata->allowed_ads) {
            return redirect()->back()->with('error', 'You have reached plan maximum ads limit, kindly upgrade your plan to post more ads.');
        }

        if (empty($user->dealershipName)) {
            return redirect()->route('personal_info')->with('register_error', 'Please complete your dealership information first to post an ad.');
        }

        $users = User::where('role', 1)->get();
        $makes = MakeCompany::all();
        $models = ModelCompany::all();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BodyType::all();
        $cities = City::all();
        $features = MainFeature::all();

        return view('user.post.create', compact(
            'users',
            'makes',
            'models',
            'colors',
            'provinces',
            'cities',
            'features',
            'bodytypes'
        ));
    }


    public function store(Request $request)
    {
        $validationRules = [];

        $request->validate([
            'makecompany' => 'required',
            'model' => 'required',
            'year' => 'required',
            'mileage' => 'required',
            'bodyType' => 'required',
            'doorcount' => 'required',
            'fuelType' => 'required',
            'seatingCapacity' => 'required',
            'engineCapacity' => 'required',
            'transmission' => 'required',
            'driveType' => 'required',
            'exterior_color' => 'required',
            'Features' => 'required',
            'filedata' => 'required',
            'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            'street_address' => 'required',
            'firstName' => 'required',
            'secondName' => 'required',
            'email' => 'required|email',
            'number' => 'required|string',
        ]);

        $post = new Post;

        $post->fill([
            'title' => $request->title,
            'condition' => $request->condition,
            'assembly' => $request->assembly,
            'company_conection' => $request->dealerType,
            'currency' => $request->currency,
            'price' => $request->price,
            'previous_price' => $request->price,
            'percentage_diff' => 0,
            'negotiated_price' => $request->negotiatedPrice === 'on' ? 1 : 0,
            'make' => $request->makecompany,
            'model' => $request->model,
            'year' => $request->year,
            'milleage' => $request->mileage,
            'body_type' => $request->bodyType,
            'doors' => $request->doorcount,
            'fuel' => $request->fuelType,
            'seating_capacity' => $request->seatingCapacity,
            'engine_capacity' => $request->engineCapacity,
            'transmission' => $request->transmission,
            'drive_type' => $request->driveType,
            'exterior_color' => $request->exterior_color,
            'dealer_comment' => $request->dealer_comment,
            'submitedby' => 'dealer',
            'status' => 2,
            'feature_ad' => $request->feature_ad === 'on' ? 1 : 0,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        $user = User::find($request->dealer);
        $dealerId = $user->role == 2 ? $user->dealer_id : $user->id;

        if ($user->role == 2) {
            $post->employee_id = $user->id;
            $post->dealer_id = $user->dealer_id;
        } else {
            $user->save();
            $post->employee_id = null;
            $post->dealer_id = $user->id;
        }

        // Check valid Stripe subscription
        Stripe::setApiKey(config('services.stripe.secret'));
        $customer = $this->getOrCreateCustomer($user);

        $invoices = Invoice::all([
            'customer' => $customer->id,
            'limit' => 100000,
            'expand' => ['data.lines.data.price']
        ])->data;

        $hasValidAdSubscription = false;
        $plan = null;

        foreach ($invoices as $invoice) {
            $subscriptionId = $invoice->subscription;
            if (!$subscriptionId) continue;

            try {
                $sub = Subscription::retrieve($subscriptionId);
                $type = $sub->metadata['sub_type'] ?? null;

                if ($type === 'ads') {
                    $end = $sub->current_period_end ?? null;
                    $status = $sub->status;

                    if (($status === 'active' || $status === 'trialing') && $end && Carbon::now()->lt(Carbon::createFromTimestamp($end))) {
                        $hasValidAdSubscription = true;
                        $plan = Product::retrieve($sub->items->data[0]->price->product);
                        break;
                    }
                }
            } catch (Exception $e) {
                continue;
            }
        }

        if (!$hasValidAdSubscription || !$plan) {
            return redirect()->route('dashboard')->with('error', 'Your subscription is invalid or expired.');
        }

        // Check feature ad limit
        $posted_ads = Post::where('dealer_id', $dealerId)->where('feature_ad', '1')->count();
        $posted_ads2 = BikePost::where('dealer_id', $dealerId)->where('is_featured', '1')->count();
        $total_ads = $posted_ads + $posted_ads2;

        if (($plan->metadata->allowed_feature_ads ?? '0') !== 'unlimited') {
            if ($total_ads >= (int) $plan->metadata->allowed_feature_ads) {
                $post->feature_ad = 0;
            } else {
                $post->feature_ad = $request->feature_ad === 'on' ? 1 : 0;
            }
        } else {
            $post->feature_ad = $request->feature_ad === 'on' ? 1 : 0;
        }


        $post->save();


        if (isset($request->Features)) {
            $this->handleFeatures($post->id, $request->Features);
        }

        // if ($request->step >= 6) {
        // $this->validateStep($request, ['filedata' => 'required']);
        if ($request->filedata) {
            $this->handleFileUpload($post->id, $request->filedata);
        }
        // }

        if ($request->file('document_brochure') || $request->file('document_auction')) {
            $this->handleDocuments($post->id, $request);
        }

        // if ($request->step >= 8) {
        $this->handleLocation($post->id, $request);
        // }

        // if ($request->step == 9) {
        $this->handleContactInfo($post->id, $request);
        $this->updatePostStatus();
        // }
        $user = User::find($post->dealer_id);
        $user->ads_count += 1;
        $user->save();



        $this->facebook->publishPost($post, $request->all(), auth()->user());
        $this->facebook->publishAdminPost($post, $request->all(), auth()->user());

        return redirect()->route('thankyou');
        // return response()->json(['success' => true, 'redirect' => url('thankyou')]);
    }

    private function handleFeatures($postId, $features)
    {
        foreach ($features as $category => $items) {
            foreach ($items as $key => $value) {
                $data = MainFeature::where(['feature' => $category, 'Sub_feature' => $key])->first();
                if ($data) {
                    Feature::updateOrCreate(
                        ['post_id' => $postId, 'feature' => $category, 'feature_id' => $data->id],
                        ['feature_name' => trim($key, "'"), 'status' => $value === 'on' ? 1 : 0]
                    );
                }
            }
        }
    }

    private function handleDocuments($postId, $request)
    {
        $this->uploadDocument($postId, $request->file('document_brochure'), 'Brochure Document');
        $this->uploadDocument($postId, $request->file('document_auction'), 'Auction Document');
    }

    private function uploadDocument($postId, $file, $type)
    {
        if ($file) {
            $filename = now()->format('His') . $file->getClientOriginalName();

            $post = post::find($postId);
            if ($type == 'Brochure Document') {
                // $oldFile = public_path('posts/brocuhre/' . $post->document_brochure);
                // if (file_exists($oldFile)) {
                //     unlink($oldFile);
                // }
                $file->move(public_path('posts/brocuhre/'), $filename);
                $post->document_brochure = $filename;
            } else {
                // $oldFile = public_path('posts/auction/' . $post->document_auction);
                // if (file_exists($oldFile)) {
                //     unlink($oldFile);
                // }
                $post->document_auction = $filename;
                $file->move(public_path('posts/auction/'), $filename);
            }
            $post->save();
            Document::create([
                'post_id' => $postId,
                'doc_name' => $filename,
                'doc_type' => $type,
            ]);
        }
    }

    private function handleLocation($postId, $request)
    {
        Location::updateOrCreate(
            ['post_id' => $postId],
            [
                'country' => $request->country,
                'province' => $request->province,
                'city' => $request->city,
                'area' => $request->area,
                'address' => $request->street_address,
            ]
        );
    }

    private function handleContactInfo($postId, $request)
    {
        ContactInfo::updateOrCreate(
            ['post_id' => $postId],
            [
                'first_name' => $request->firstName,
                'last_name' => $request->secondName,
                'email' => $request->email,
                'number' => $request->number,
                'website' => $request->website ?? 'https://autojazera.pk/',
                'linkedIn' => $request->linkedin,
                'twitter' => $request->twitter,
            ]
        );
    }

    private function updatePostStatus()
    {
        $post = Post::where(['submitedby' => 'dealer', 'status' => 2])->latest()->first();
        if ($post) {
            $post->status = 0;
            $post->save();
        }
    }

    private function validateStep($request, $rules)
    {
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    }

    private function handleFileUpload($postId, $filedata)
    {
        foreach ($filedata as $i => $file) {
            // if (!$file || !$file->isValid()) {
            //     // Skip invalid files
            //     continue;
            // }
            // dd($filedata);

            $doc = new Document();
            $doc->post_id = $postId;

            // Generate filename and move the file
            $filename = date('His') . '_' . $file->getClientOriginalName();
            $file->move(public_path('posts/doc/'), $filename);
            $doc->doc_name = $filename;

            // Determine file type
            $fileExtension = strtolower($file->getClientOriginalExtension());

            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $doc->doc_type = 'image';
            } elseif (in_array($fileExtension, ['mp4', 'mov', 'avi'])) {
                $doc->doc_type = 'video';
            } elseif ($fileExtension === 'pdf') {
                $doc->doc_type = 'pdf';
            } else {
                $doc->doc_type = 'other';
            }
            if ($i = 0) {

                $doc->thumbnail = 1;
                //dd($doc);
            }

            $doc->save();
        }
    }


    public function edit(string $id)
    {
        $users = User::where('role', 1)->get();
        $post = Post::with('document')->where('id', $id)->first();
        $makes = MakeCompany::all();
        $bodytypes = BodyType::all();
        $models = ModelCompany::all();
        //dd($models);
        $colors = Color::all();
        $provinces = Province::all();
        $cities = City::all();
        $features = MainFeature::all();
        return view('user.post.edit', compact('users', 'makes', 'models', 'colors', 'provinces', 'cities', 'post', 'features', 'bodytypes'));
    }

    public function update(Request $request, string $id)
    {
        $validationRules = [];

        $request->validate([
            'makecompany' => 'required',
            'model' => 'required',
            'year' => 'required',
            'mileage' => 'required',
            'bodyType' => 'required',
            'doorcount' => 'required',
            'fuelType' => 'required',
            'seatingCapacity' => 'required',
            'engineCapacity' => 'required',
            'transmission' => 'required',
            'driveType' => 'required',
            'exterior_color' => 'required',
            'Features' => 'required',
            'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            'street_address' => 'required',
            'firstName' => 'required',
            'secondName' => 'required',
            'email' => 'required|email',
            'number' => 'required|string',
        ]);

        $post = Post::find($request->id);

        if ($post->price != $request->price) {
            $sendfcm = true;
        } else {
            $sendfcm = false;
        }

        $oldprice = $post->price;
        $post->fill([
            'title' => $request->title,
            'condition' => $request->condition,
            'assembly' => $request->assembly,
            'company_conection' => $request->dealerType,
            'currency' => $request->currency,
            'negotiated_price' => $request->negotiatedPrice === 'on' ? 1 : 0,
            'make' => $request->makecompany,
            'model' => $request->model,
            'year' => $request->year,
            'milleage' => $request->mileage,
            'body_type' => $request->bodyType,
            'doors' => $request->doorcount,
            'fuel' => $request->fuelType,
            'seating_capacity' => $request->seatingCapacity,
            'engine_capacity' => $request->engineCapacity,
            'transmission' => $request->transmission,
            'drive_type' => $request->driveType,
            'exterior_color' => $request->exterior_color,
            'dealer_comment' => $request->dealer_comment,
            'submitedby' => 'superadmin',
            'feature_ad' => $request->feature_ad === 'on' ? 1 : 0,
            // 'latitude' => $request->latitude ?? '',
            // 'longitude' => $request->longitude ?? '',
        ]);

        // Get authenticated user info
        $authUser = Auth::user();
        $userId = $authUser->role == 2 ? $authUser->dealer_id : $authUser->id;

        // Use dealer ID from request (if needed)
        $user = User::find($request->dealer);

        // Set Stripe API
        Stripe::setApiKey(config('services.stripe.secret'));

        // Get Stripe customer
        $customer = $this->getOrCreateCustomer($user);

        // Get all invoices
        $invoices = Invoice::all([
            'customer' => $customer->id,
            'limit' => 100000,
            'expand' => ['data.lines.data.price']
        ])->data;

        $hasValidAdSubscription = false;
        $plan = null;

        foreach ($invoices as $invoice) {
            $subscriptionId = $invoice->subscription;
            if (!$subscriptionId) continue;

            try {
                $sub = Subscription::retrieve($subscriptionId);
                $type = $sub->metadata['sub_type'] ?? null;

                if ($type === 'ads') {
                    $end = $sub->current_period_end ?? null;
                    $status = $sub->status;

                    if (($status === 'active' || $status === 'trialing') && $end && Carbon::now()->lt(Carbon::createFromTimestamp($end))) {
                        $hasValidAdSubscription = true;
                        $plan = Product::retrieve($sub->items->data[0]->price->product);
                        break;
                    }
                }
            } catch (Exception $e) {
                continue;
            }
        }

        if (!$hasValidAdSubscription || !$plan) {
            return redirect()->route('dashboard')->with('error', 'Your subscription is invalid or expired.');
        }

        $posted_ads = Post::where('dealer_id', $userId)->where('feature_ad', '1')->count();
        $posted_ads2 = BikePost::where('dealer_id', $userId)->where('is_featured', '1')->count();
        $total_ads = $posted_ads + $posted_ads2;

        if (($plan->metadata->allowed_feature_ads ?? '0') !== 'unlimited') {
            if ($total_ads >= (int) $plan->metadata->allowed_feature_ads) {
                $post->feature_ad = 0;
            } else {
                $post->feature_ad = $request->feature_ad === 'on' ? 1 : 0;
            }
        } else {
            $post->feature_ad = $request->feature_ad === 'on' ? 1 : 0;
        }

        if ($authUser->role == 2) {
            $post->employee_id = $authUser->id;
            $post->dealer_id = $authUser->dealer_id;
        } else {
            $post->employee_id = null;
            $post->dealer_id = $authUser->id;
        }
        if ($request->has('price') && $request->price != $post->price) {
            $post->previous_price = $oldprice;

            $post->price = $request->price;

            $difference = $request->price - $oldprice; // Difference between new and previous price
            $percentageChange = ($difference / $oldprice) * 100; // Calculate percentage change
            $post->percentage_diff = round($percentageChange, 2); // Round to 2 decimal places
        }

        $post->save();

        if (isset($request->Features)) {
            $this->handleFeatures($post->id, $request->Features);
        }

        if ($request->filedata) {
            $this->handleFileUpload($post->id, $request->filedata);
        }

        if ($request->file('document_brochure') || $request->file('document_auction')) {
            $this->handleDocuments($post->id, $request);
        }

        $this->handleLocation($post->id, $request);


        $this->handleContactInfo($post->id, $request);
        $this->updatePostStatus();

        if ($sendfcm == true) {

            $user_ids = PriceAlert::where('post_id', $request->id)->where('status', 1)->pluck('user_id')->toArray();
            if (count($user_ids) > 0) {

                $fcm_tokens = User::wherein('id', $user_ids)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

                if ($fcm_tokens) {
                    SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Price Alert', 'body' => 'Vehicle ' . $post->makecompany->name . ' ' . $post->modelcompany->name . ' has been updated']);
                }
                $post = Post::with(['modelcompany', 'makecompany'])->where('id', $post->id)->first();

                $mainDoc = $post->document->first() ?? null;
                $post->setAttribute('image', $mainDoc ? url('posts/doc/' . $mainDoc->doc_name) : url('web/images/default-car.jpg'));


                $url = url('/');
                $url = $url . '/car-detail/' . $request->id;
                $post->url = $url;
                $post->updated_at = Carbon::parse($post->updated_at)->format('d M Y');
                foreach ($user_ids as $id) {
                    $user = User::find($id);
                    if ($user) {

                        Mail::to($user->email)->send(new PriceAlertMail($post));
                    }
                }
            }
        }
        return redirect()->route('thankyou');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $post = Post::find($request->deleted_id);
        $post->status = 0;
        $post->save();
        $post->delete();
        return redirect()->back()->with('danger', 'Post Deleted Successfully');
    }

    public function Cars_data(Request $request, $name)
    {
        $users = User::where('role', 1)->get();
        $makes = MakeCompany::where('status', 1)->get();
        $models = ModelCompany::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BodyType::where('status', 1)->get();
        $cities = City::all();
        $features = MainFeature::where('status', 1)->get();
        if ($request->post_id) {
            $posts = Post::with([
                'feature' => function ($query) {
                    $query->with('mainfeature');
                },
                'document',
                'location',
                'contact'
            ])->orderBy('feature_ad', 'DESC')->orderBy('created_at', 'DESC')->where(['id' => $request->post_id, 'status' => 1])->paginate(25);
        } else {
            $posts = Post::with('feature', 'document', 'location', 'contact')->where(['condition' => $name, 'status' => "1"])->orderBy('feature_ad', 'DESC')->orderBy('created_at', 'DESC')->paginate(25);
        }
        foreach ($posts as $post) {
            $dealer = User::find($post->dealer_id);

            $post->user_type = $dealer->userType;
        }
        return view('superadmin.Cars.index',  compact('users', 'makes', 'models', 'posts', 'colors', 'provinces', 'cities',  'features', 'bodytypes'));
    }

    public function comingsoon()
    {
        return view('superadmin.bike.coming_soon');
    }

    public function cancel_plan($id)
    {

        $user = User::find($id);
        $user->role = 0;
        $user->save();
        $user = User::where(['dealer_id' => $id, 'role' => 2])->update(['status' => 'inactive']);
        $user = Post::where(['dealer_id' => $id])->update(['status' => '0']);
        return redirect('/dashboard')->with('success', 'your plan is canel and know you are user ');
    }


    public function deletepostold_image($post_id, $image_id)
    {
        // dd($request);
        $documentCount =  Document::where('post_id', $post_id)->count();
        if ($documentCount > 1) {
            $document =  Document::find($image_id);
            if ($document) {
                $document->delete();
                return redirect()->back()->with('imgdelete', 'Image Deleted Successfully');
                // return response()->json(['status' => 200, 'message' => "Deleted Successfully", 'id' => $image_id]);
            } else {
                return redirect()->back()->with('imgdelete', 'Image Not Found');
                // return response()->json(['status' => 402, 'message' => "Not Found"]);
            }
        } else {
            return redirect()->back()->with('imgdelete', 'At least one image is required');
            // return response()->json(['status' => 402, 'message' => "At least one image is required"]);
        }
    }
    public function thankyou()
    {
        return view('user.post.thankyou');
    }

    public function filterPosts(Request $request)
    {
        Log::info($request->all());
        $type = $request->segment(2);
        Log::info($type);

        $filteredData = collect($request->all())->map(function ($value) {
            if (is_array($value)) {
                return empty($value) ? null : $value;
            }

            if (in_array(strtolower(trim((string) $value)), ['any', 'null', ''], true)) {
                return null;
            }

            return $value;
        });

        // Replace request data with cleaned one
        $request->merge($filteredData->toArray());

        $query = Post::with('dealer')->where('status', 1)->whereNull('deleted_at');

        if (is_numeric($request->from_year)) {
            $query->where('year', '>=', $request->from_year);
        }

        if (is_numeric($request->to_year)) {
            $query->where('year', '<=', $request->to_year);
        }


        if ($type === 'used') {
            $query->where('condition', 'used');
        } elseif ($type === 'new') {
            $query->where('condition', 'new');
        }

        if ($request->filled('engine_capacity')) {
            if ($request->engine_capacity === "3.0L+") {
                $query->where('engine_capacity', '>=', 3.0);
            } else {
                $query->where('engine_capacity', $request->engine_capacity);
            }
        }

        if ($request->filled('mileage_from')) {
            $query->where('milleage', '>=', $request->mileage_from);
        }
        if ($request->filled('mileage_to')) {
            $query->where('milleage', '<=', $request->mileage_to);
        }

        if ($request->filled('body_type')) {
            $bodyTypeFilter = array_map('strval', (array) $request->body_type);
            $query->whereIn('body_type', $bodyTypeFilter);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int)$request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int)$request->max_price);
        }

        if ($request->filled('fuel_type')) {
            $query->whereIn('fuel', $request->fuel_type);
        }

        if ($request->filled('seating_capacity')) {
            $query->where('seating_capacity', $request->seating_capacity);
        }

        if ($request->filled('condition')) {
            $query->whereIn('condition', $request->condition);
        }

        if ($request->filled('transmission')) {
            $query->whereIn('transmission', $request->transmission);
        }

        if ($request->filled('door_count')) {
            $query->where('doors', $request->door_count);
        }

        if ($request->filled('assembly')) {
            $query->where('assembly', $request->assembly);
        }

        if ($request->filled('exterior_color')) {
            $query->whereIn('exterior_color', $request->exterior_color);
        }

        if ($request->filled('feature_ad')) {
            $query->where('feature_ad', true);
        }

        if ($request->filled('seller_type')) {
            $query->whereHas('dealer', function ($q) use ($request) {
                $q->whereIn('userType', $request->seller_type);
            });
        }

        if ($request->filled('make')) {
            $query->where('make', $request->make);
        }

        if ($request->filled('model')) {
            $models = is_array($request->model) ? $request->model : [$request->model];
            $query->whereIn('model', $models);
        }

        $query->select('posts.*')->join('locations', 'posts.id', '=', 'locations.post_id');

        if ($request->filled('province')) {
            $query->where('locations.province', $request->province);
        }

        // if ($request->filled('city')) {
        //     $cities = is_array($request->city) ? $request->city : [$request->city];
        //     $query->whereIn('locations.city', $cities);
        // }

        if ($request->filled('city')) {
            Log::info('Applying city filter: ' . $request->city);
            $query->where(function ($q) use ($request) {
                $q->where('locations.city', (int) $request->city)
                    ->orWhereNull('locations.city');
            });
        }

        if ($request->filled('sortby')) {
            switch ($request->sortby) {
                case 'Newest First':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'Oldest First':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'Price: Low to High':
                    $query->orderByRaw('CAST(price AS UNSIGNED) ASC');
                    break;
                case 'Price: High to Low':
                    $query->orderByRaw('CAST(price AS UNSIGNED) DESC');
                    break;
                case 'Model Year: Latest First':
                    $query->orderByRaw('CAST(year AS UNSIGNED) DESC');
                    break;
                case 'Model Year: Oldest First':
                    $query->orderByRaw('CAST(year AS UNSIGNED) ASC');
                    break;
                case 'Mileage: High to Low':
                    $query->orderByRaw('CAST(milleage AS UNSIGNED) DESC');
                    break;
                case 'Mileage: Low to High':
                    $query->orderByRaw('CAST(milleage AS UNSIGNED) ASC');
                    break;
            }
        }


        $count = $query->count();
        $posts = $query->distinct()->paginate(25)->appends(request()->except('page'));
        log::info($count);


        //dd($cities, $query->toSql(), $query->getBindings());
        return response()->json([
            'html' => view('superadmin.Cars.filtered_posts', compact('posts'))->render(),
            'posts_count' => $posts->total(),
            'current_page' => $posts->currentPage(),
            'per_page' => $posts->perPage(),
            'pagination_links' => (string) $posts->links(),
        ]);
    }


    private function getOrCreateCustomer($user)
    {
        $customers = Customer::all(['limit' => 10000]);
        foreach ($customers->data as $cust) {
            if ($cust->email === $user->email) {
                return $cust;
            }
        }

        return Customer::create([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
