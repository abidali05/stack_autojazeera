<?php

namespace App\Http\Controllers\superadmin;

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
use App\Mail\Ad_accepted;
use App\Mail\Ad_inactive;
use App\Mail\Ad_rejected;
use App\Models\Whishlist;
use App\Models\PriceAlert;
use App\Models\ContactInfo;
use App\Models\MainFeature;
use App\Models\MakeCompany;
use App\Mail\PriceAlertMail;
use App\Models\ModelCompany;
use Illuminate\Http\Request;
use App\Models\Bike\BikeMake;
use App\Models\Bike\BikePost;
use App\Models\Notifications;
use App\Models\Bike\BikeModels;
use App\Jobs\SendFcmNotification;
use App\Models\Bike\BikeBodyTypes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Bike\BikeMainFeatures;
use Illuminate\Support\Facades\Validator;
use App\Exports\PostsExport;
use App\Imports\PostsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\bikes\New_lead as BikeNewLead;
use App\Mail\bikes\Ad_accepted as BikeAdAccepted;
use App\Mail\bikes\Ad_inactive as BikeAdInactive;
use App\Mail\bikes\Ad_rejected as BikeAdRejected;
use App\Mail\bikes\PriceAlertMail as BikePriceAlertMail;
use App\Mail\bikes\MonthlyPostEmail as BikeMonthlyPostEmail;
use App\Mail\bikes\InactivePostEmail as BikeInactivePostEmail;
use App\Mail\bikes\InactiveAdsNotification as BikeInactiveAdsNotification;


class SuperadminAddsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $users = User::where('role', 1)->get();
        if ($request->car_search) {
            $query = Post::withTrashed()->orderBy('feature_ad', 'DESC')->orderBy('created_at', 'DESC')->query();

            $car_search = $request->car_search;

            // Check for matching make and model
            $check = MakeCompany::where('name', $request->car_search)->first();
            $check2 = ModelCompany::where('name', $request->car_search)->first();

            // Safely extract IDs
            $makeId = $check ? $check->id : null;
            $modelId = $check2 ? $check2->id : null;

            // car_Search in multiple columns
            $query->where(function ($q) use ($car_search, $makeId, $modelId) {
                $q->where('title', 'like', '%' . $car_search . '%')
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
                    ->orWhere('year', $car_search)
                    ->orWhere('dealer_comment', 'like', '%' . $car_search . '%');
            });

            // Include relationships if necessary
            $posts = $query->with(['document' => function ($q) {
                $q->orderBy('position', 'asc');
            }])->get();
        } elseif ($request->car_post_id) {
            $posts = Post::withTrashed()->with(['feature', 'document' => function ($q) {
                $q->orderBy('position', 'asc');
            }, 'location', 'contact'])->orderby('id', 'desc')->where('dealer_id', $request->car_post_id)->get();
        } else {
            $posts = Post::withTrashed()->with(['feature', 'document' => function ($q) {
                $q->orderBy('position', 'asc');
            }, 'location', 'contact'])->orderby('id', 'desc')->get();
        }
        $bike_posts = BikePost::orderBy('id', 'desc')
            ->with(['features', 'location', 'contacts', 'media', 'dealer']);

        if ($request->bike_post_id) {
            $bike_posts->where('dealer_id', $request->bike_post_id);
        }

        if ($request->bike_search) {
            $searchTerm = $request->bike_search;

            $make = BikeMake::where('name', $searchTerm)->first();
            $model = BikeModels::where('name', $searchTerm)->first();

            $makeId = $make ? $make->id : null;
            $modelId = $model ? $model->id : null;

            $bike_posts->where(function ($q) use ($searchTerm, $makeId, $modelId) {
                $q->when($makeId, fn($q) => $q->orWhere('make', 'like', "%$makeId%"))
                    ->when($modelId, fn($q) => $q->orWhere('model', 'like', "%$modelId%"))
                    ->orWhere('year', $searchTerm)
                    ->orWhere('description', 'like', "%$searchTerm%");
            });
        }


        $bike_posts = $bike_posts->get();

        return view('superadmin.post.adds', compact('posts', 'users', 'bike_posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 1)->get();
        $makes = MakeCompany::where('status', 1)->get();
        $models = ModelCompany::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BodyType::where('status', 1)->get();
        $cities = City::all();
        $features = MainFeature::where('status', 1)->get();
        $post = Post::where(['submitedby' => 'superadmin', 'status' => 2])->latest()->first();
        return view('superadmin.post.create', compact('users', 'makes', 'models', 'colors', 'provinces', 'cities', 'features', 'bodytypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

        try {
            DB::beginTransaction();

            $post = new Post();

            $post->fill([
                'dealer_id' => $request->dealer,
                'title' => $request->title,
                'condition' => $request->condition,
                'assembly' => $request->assembly,
                'company_conection' => $request->dealerType,
                'currency' => $request->currency,
                'price' => $request->price,
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
                'status' => 2,
                'feature_ad' => $request->feature_ad === 'on' ? 1 : 0,
            ]);
            $post->save();

            $user = User::findOrFail($post->dealer_id);
            $dealerId = $user->role == 2 ? $user->dealer_id : $user->id;

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
                    Log::error('Stripe Subscription error: ' . $e->getMessage());
                    continue;
                }
            }

            if (!$hasValidAdSubscription || !$plan) {
                DB::rollBack();
                return redirect()->to(url('superadmin/ads'))->with('error', 'Dealer subscription is invalid or expired.');
            }

            $posted_ads = Post::where('dealer_id', $dealerId)->where('feature_ad', 1)->count();
            $posted_ads2 = BikePost::where('dealer_id', $dealerId)->where('is_featured', 1)->count();
            $total_ads = $posted_ads + $posted_ads2;

            if (($plan->metadata->allowed_feature_ads ?? '0') !== 'unlimited') {
                $post->feature_ad = $total_ads >= (int) $plan->metadata->allowed_feature_ads ? 0 : ($request->feature_ad === 'on' ? 1 : 0);
            } else {
                $post->feature_ad = $request->feature_ad === 'on' ? 1 : 0;
            }

            $post->save();

            $user->ads_count += 1;
            $user->save();

            $this->handleFeatures($post->id, $request->Features);

            if ($request->filedata) {
                $this->handleFileUpload($post->id, $request->filedata);
            }

            if ($request->hasFile('document_brochure') || $request->hasFile('document_auction')) {
                $this->handleDocuments($post->id, $request);
            }

            $this->handleLocation($post->id, $request);
            $this->handleContactInfo($post->id, $request);

            $this->updatePostStatus();

            DB::commit();
            return redirect()->route('superadmin.thankyou');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Post Store Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    private function handleStepFour($post, $request) {}

    private function handleFeatures($postId, $features)
    {
        Feature::where(['post_id' => $postId])->delete();
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


    // private function handleDocuments($postId, $request)
    // {
    //     $this->uploadDocument($postId, $request->file('document_brochure'), 'Brochure Document');
    //     $this->uploadDocument($postId, $request->file('document_auction'), 'Auction Document');
    // }

    // private function uploadDocument($postId, $file, $type)
    // {
    //     if ($file) {
    //         $filename = now()->format('His') . $file->getClientOriginalName();
    //         $file->move(public_path('posts/doc/'), $filename);
    //         Document::create([
    //             'post_id' => $postId,
    //             'doc_name' => $filename,
    //             'doc_type' => $type,
    //         ]);
    //     }
    // }


    private function handleDocuments($postId, $request)
    {
        $this->uploadDocument($postId, $request->file('document_brochure'), 'Brochure Document');
        $this->uploadDocument($postId, $request->file('document_auction'), 'Auction Document');
    }

    private function uploadDocument($postId, $file, $type)
    {
        if ($file) {
            $filename = now()->format('His') . $file->getClientOriginalName();
            // $file->move(public_path('posts/doc/'), $filename);
            $post = post::find($postId);
            if ($type == 'Brochure Document') {
                // $oldFile = public_path('posts/brochure/' . $post->document_brochure);
                // if (file_exists($oldFile)) {
                //     unlink($oldFile);
                // }
                $file->move(public_path('posts/brocuhre/'), $filename);
                $post->document_brochure = $filename;
            } else {
                $oldFile = public_path('posts/auction/' . $post->document_auction);
                // if (file_exists($oldFile)) {
                //     unlink($oldFile);
                // }
                $file->move(public_path('posts/auction/'), $filename);
                $post->document_auction = $filename;
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
        $post = Post::where(['submitedby' => 'superadmin', 'status' => 2])->latest()->first();
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
    // private function handleFileUpload($postId, $filedata)
    // {
    //     foreach ($filedata as $file) {
    //         // if (!$file || !$file->isValid()) {
    //         //     // Skip invalid files
    //         //     continue;
    //         // }

    //         $doc = new Document();
    //         $doc->post_id = $postId;

    //         // Generate filename and move the file
    //         $filename = date('His') . '_' . $file->getClientOriginalName();
    //         $file->move(public_path('posts/doc/'), $filename);
    //         $doc->doc_name = $filename;
    //         $post = post::find($postId);
    //         if($type == 'Brochure Document'){

    //             $post->document_brochure = $filename;
    //         }
    //         else{
    //             $post->document_auction = $filename;
    //         }
    //         $post->save();
    //         // Determine file type
    //         $fileExtension = strtolower($file->getClientOriginalExtension());

    //         if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
    //             $doc->doc_type = 'image';
    //         } elseif (in_array($fileExtension, ['mp4', 'mov', 'avi'])) {
    //             $doc->doc_type = 'video';
    //         } elseif ($fileExtension === 'pdf') {
    //             $doc->doc_type = 'pdf';
    //         } else {
    //             $doc->doc_type = 'other';
    //         }

    //         $doc->save();
    //     }
    // }

    private function handleFileUpload($postId, $filedata)
    {
        foreach ($filedata as $i => $file) {
            // if (!$file || !$file->isValid()) {
            //     // Skip invalid files
            //     continue;
            // }

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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::where('role', 1)->get();
        $post = Post::withTrashed()->with('feature')->find($id);
        $makes = MakeCompany::where('status', 1)->get();
        $models = ModelCompany::where('status', 1)->get();
        $colors = Color::all();
        $bodytypes = BodyType::where('status', 1)->get();
        $provinces = Province::all();
        $cities = City::all();
        $features = MainFeature::where('status', 1)->get()->groupBy('feature');

        return view('superadmin.post.edit', compact('users', 'makes', 'models', 'colors', 'provinces', 'cities', 'post', 'features', 'bodytypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    //     public function update(Request $request, string $id)
    //     {
    //         // dd($request->all());

    // 		$validationRules = [];

    // switch (true) {
    //     case $request->step <= 4:
    //         $validationRules = array_merge($validationRules, [
    //             'makecompany' => 'required',
    //             'model' => 'required',
    //             'year' => 'required',
    //             'mileage' => 'required',
    //             'bodyType' => 'required',
    //             'doorcount' => 'required',
    //             'fuelType' => 'required',
    //             'seatingCapacity' => 'required',
    //             'engineCapacity' => 'required',
    //             'transmission' => 'required',
    //             'driveType' => 'required',
    //             'exterior_color' => 'required',
    //         ]);
    // 		   break;
    //         // No break here as we want to add further rules for higher steps.

    //     case $request->step <= 5:
    //         $validationRules = array_merge($validationRules, [
    //             'Features' => 'required',
    //         ]);
    // 		   break;
    //         // No break here as we want to add further rules for higher steps.

    //     case $request->step <= 6:
    //         $validationRules = array_merge($validationRules, [
    //             'filedata' => 'required',
    //         ]);
    // 		   break;
    //         // No break here as we want to add further rules for higher steps.

    //     case $request->step <= 8:
    //         $validationRules = array_merge($validationRules, [
    //             'country' => 'required',
    //             'province' => 'required',
    //             'city' => 'required',
    //             'street_address' => 'required',
    //         ]);
    // 		   break;
    //         // No break here as we want to add further rules for higher steps.

    //     case $request->step <= 9:
    //         $validationRules = array_merge($validationRules, [
    //             'firstName' => 'required',
    //             'secondName' => 'required',
    //             'email' => 'required|email',
    //             'area' => 'required',
    //             'number' => 'required|string',
    //         ]);
    //         break;
    // }

    // $validator = Validator::make($request->all(), $validationRules);

    //   if ($validator->fails()) {
    //     return response()->json(['errors' => $validator->errors()], 422);
    // }

    //         $post = Post::find($id);

    //     // Step-based data handling

    //     if ($request->step >= 4) {
    //         $post->fill([
    //         'dealer_id' => $request->dealer,
    //         'title' => $request->title,
    //         'condition' => $request->condition,
    //         'assembly' => $request->assembly,
    //         'company_conection' => $request->dealerType,
    //         'currency' => $request->currency,
    //         'price' => $request->price,
    //         'negotiated_price' => $request->negotiatedPrice === 'on' ? 1 : 0,
    //         'make' => $request->makecompany,
    //         'model' => $request->model,
    //         'year' => $request->year,
    //         'milleage' => $request->mileage,
    //         'body_type' => $request->bodyType,
    //         'doors' => $request->doorcount,
    //         'fuel' => $request->fuelType,
    //         'seating_capacity' => $request->seatingCapacity,
    //         'engine_capacity' => $request->engineCapacity,
    //         'transmission' => $request->transmission,
    //         'drive_type' => $request->driveType,
    //         'exterior_color' => $request->exterior_color,
    //         'dealer_comment' => $request->dealer_comment,
    //         'submitedby' => 'superadmin',

    //         'feature_ad' => $request->feature_ad === 'on' ? 1 : 0,
    //     ]);
    //     $post->save();
    //     }

    //     if (isset($request->Features)) {
    //         $this->handleFeatures($post->id, $request->Features);
    //     }

    //     if ($request->step >= 6) {
    //         $this->validateStep($request, ['filedata' => 'required']);
    // 		    if ($request->filedata) {
    //         $this->handleFileUpload($post->id, $request->filedata);
    // 			}
    //     }

    //     if ($request->file('document_brochure') || $request->file('document_auction')) {
    //         $this->handleDocuments($post->id, $request);
    //     }

    //     if ($request->step >= 8) {
    //         $this->handleLocation($post->id, $request);
    //     }

    //     if ($request->step == 9) {
    //         $this->handleContactInfo($post->id, $request);
    //         $this->updatePostStatus();
    //     }
    //    return response()->json(['success' => true, 'redirect' => url('superadmin/ads')]);
    //     }


    public function update(Request $request, string $id)
    {
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

        try {
            DB::beginTransaction();

            $post = Post::withTrashed()->findOrFail($id);
            $sendfcm = $post->price > $request->price;

            $oldprice = $post->price;

            $post->fill([
                'dealer_id' => $request->dealer,
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
                'status' => 2,
                'feature_ad' => $request->feature_ad === 'on' ? 1 : 0,
            ]);

            $user = User::findOrFail($post->dealer_id);
            $dealerId = $user->role == 2 ? $user->dealer_id : $user->id;

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
                    Log::error('Stripe Subscription Error: ' . $e->getMessage());
                }
            }

            if (!$hasValidAdSubscription || !$plan) {
                DB::rollBack();
                return redirect()->to(url('superadmin/ads'))->with('error', 'Dealer subscription is invalid or expired.');
            }

            $posted_ads = Post::where('dealer_id', $dealerId)->where('feature_ad', 1)->count();
            $posted_ads2 = BikePost::where('dealer_id', $dealerId)->where('is_featured', 1)->count();
            $total_ads = $posted_ads + $posted_ads2;

            if (($plan->metadata->allowed_feature_ads ?? '0') !== 'unlimited') {
                $post->feature_ad = $total_ads >= (int) $plan->metadata->allowed_feature_ads ? 0 : ($request->feature_ad === 'on' ? 1 : 0);
            } else {
                $post->feature_ad = $request->feature_ad === 'on' ? 1 : 0;
            }

            // Price change logic
            if ($request->has('price') && $request->price != $oldprice) {
                $post->previous_price = $oldprice;
                $post->price = $request->price;
                $difference = $request->price - $oldprice;
                $percentageChange = ($difference / $oldprice) * 100;
                $post->percentage_diff = round($percentageChange, 2);
            }

            $post->save();

            if ($request->has('Features')) {
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

            // Send FCM/email alert if price dropped
            if ($sendfcm) {
                $user_ids = PriceAlert::where('post_id', $post->id)->where('status', 1)->pluck('user_id')->toArray();
                if (!empty($user_ids)) {
                    $fcm_tokens = User::whereIn('id', $user_ids)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
                    $postWithData = Post::with(['modelcompany', 'makecompany', 'document'])->find($post->id);

                    $mainDoc = $postWithData->document->first();
                    $postWithData->image = $mainDoc ? url('posts/doc/' . $mainDoc->doc_name) : url('web/images/default-car.jpg');
                    $postWithData->url = url('/car-detail/' . $post->id);
                    $postWithData->updated_at = Carbon::parse($post->updated_at)->format('d M Y');

                    if (!empty($fcm_tokens)) {
                        SendFcmNotification::sendPriceAlertNotification($fcm_tokens, [
                            'title' => 'Price Alert',
                            'body' => 'Vehicle ' . $postWithData->makecompany->name . ' ' . $postWithData->modelcompany->name . ' has been updated'
                        ]);
                    }

                    foreach ($user_ids as $uid) {
                        $u = User::find($uid);
                        if ($u) {
                            $body = view('emails.price_alert', compact('postWithData'));
                            sendMail($u->name, $u->email, 'Auto Jazeera', 'Auto Jazeera Price Alert', $body);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->to(url('superadmin/ads'))->with('success', 'Post Updated Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Post Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $post = Post::withTrashed()->where('id', $request->deleted_id)->first();
        $post->forceDelete();
        return redirect()->back()->with('danger', 'Post Deleted Successfully');
    }
    public function change_status($id)
    {
        $post = Post::withTrashed()->find($id);
        if ($post->status == 0) {
            $post->status = 1;
        } else {
            $post->status = 0;
        }
        $post->update();
        return redirect()->back()->with('warning', 'status change successfully');
    }
    public function Cars_data(Request $request, $name)
    {
        //dd($request->all());
        $users = User::where('role', 1)->get();
        $makes = MakeCompany::where('status', 1)->get();
        $models = ModelCompany::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BodyType::where('status', 1)->get();
        $cities = City::all();
        $features = MainFeature::where('status', 1)->get();
        if ($request->post_id) {
            $posts = Post::with('feature', 'document', 'location', 'contact')->orderBy('feature_ad', 'DESC')->orderBy('created_at', 'DESC')->where(['id' => $request->post_id, 'status' => 1])->paginate(25);
        } else {
            $posts = Post::with('feature', 'document', 'location', 'contact')->orderBy('feature_ad', 'DESC')->orderBy('created_at', 'DESC')->where(['condition' => $name, 'status' => 1])->paginate(25);
        }
        foreach ($posts as $post) {
            $dealer = User::find($post->dealer_id);
            $post->user_type = $dealer->userType;
        }
        return view('superadmin.Cars.index', compact('users', 'makes', 'models', 'posts', 'colors', 'provinces', 'cities',  'features', 'bodytypes'));
    }
    public function comingsoon()
    {
        return view('superadmin.bike.coming_soon');
    }
    public function welcome(Request $request)
    {

        $users = User::where('role', 1)->get();
        $makes = MakeCompany::where('status', 1)->get();
        $models = ModelCompany::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BodyType::where('status', 1)->get();
        $cities = City::all();
        $features = MainFeature::where('status', 1)->get();
        // if($request->search)
        // {

        //      $posts = Post::where('status', 0)
        //      ->when($request->bodytype, function ($query) use ($request) {
        //          return $query->where('body_type', $request->bodytype);
        //      })
        //      ->when($request->model, function ($query) use ($request) {
        //          return $query->where('model', $request->model);
        //      })
        //      ->when($request->make, function ($query) use ($request) {
        //          return $query->where('make', $request->make);
        //      })
        //      ->with(['bodytype1','make1','location' => function ($query) use ($request) {
        //          $query->when($request->province, function ($query) use ($request) {
        //              $query->where('province', $request->province);
        //          })
        //          ->when($request->city, function ($query) use ($request) {
        //              $query->where('city', $request->city);
        //          });
        //      }])
        //      ->get();
        // }

        $posts = Post::with(['bodytype1', 'make1'])->where('status', 1)->orderBy('feature_ad', 'DESC')->orderBy('created_at', 'DESC')->latest()->take(12)->get();
        $featured_new_posts = Post::with(['bodytype1', 'make1'])->where('status', 1)->where('feature_ad', '1')->where('condition', 'new')->orderBy('created_at', 'DESC')->latest()->take(12)->get();

        $featured_used_posts = Post::with(['bodytype1', 'make1'])->where('status', 1)->where('feature_ad', '1')->where('condition', 'used')->orderBy('created_at', 'DESC')->latest()->take(12)->get();

        return view('welcome', compact('users', 'makes', 'models', 'posts', 'colors', 'provinces', 'cities',  'features', 'bodytypes', 'featured_new_posts', 'featured_used_posts'));
    }


    public function carlist(Request $request)
    {
        // dd($request->all());
        $page = $request->input('page', 1);
        $condition = $request->input('condition') === '1e' ? null : $request->input('condition');
        $bodytype = $request->input('bodytype') === '1e' ? null : $request->input('bodytype');
        $make = $request->input('make') === '1e' ? null : $request->input('make');
        $model = $request->input('model') === '1e' ? null : $request->input('model');
        $province = $request->input('province') === '1e' ? null : $request->input('province');
        $city = $request->input('city') === '1e' ? null : $request->input('city');
// dd($request->all(), $condition, $bodytype, $make, $model, $province, $city);
        $users = User::where('role', 1)->get();
        $makes = MakeCompany::where('status', 1)->get();
        $models = ModelCompany::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BodyType::where('status', 1)->get();
        $cities = City::all();
        $features = MainFeature::where('status', 1)->get();
        $posts = Post::where('status', 1)
            ->orderBy('feature_ad', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->when($request->bodytype, function ($query) use ($request) {
                return $query->whereIn('body_type', is_array($request->bodytype) ? $request->bodytype : [$request->bodytype]);
            })
            ->when($request->model, function ($query) use ($request) {
                return $query->whereIn('model', is_array($request->model) ? $request->model : [$request->model]);
            })
            ->when($request->make, function ($query) use ($request) {
                return $query->where('make', $request->make);
            })
            ->when($request->filled('province_'), function ($query) use ($request) {
                $locations = Location::where('province', $request->province_)->pluck('post_id');
                $query->whereIn('id', $locations);
            })
            ->when($request->filled('city'), function ($query) use ($request) {
                $cities = is_array($request->city) ? $request->city : [$request->city];
                $locations = Location::whereIn('city', $cities)->pluck('post_id');
                $query->whereIn('id', $locations);
            })
            ->when($request->exterior_color, function ($query) use ($request) {
                return $query->where('exterior_color',  is_array($request->exterior_color) ? $request->exterior_color : [$request->exterior_color]);
            })
            ->when($request->condition, function ($query) use ($request) {
                return $query->where('condition', $request->condition);
            })
            ->with(['bodytype1', 'make1', 'location'])
            ->paginate(25, ['*'], 'page', $page); // Adjust as needed
        foreach ($posts as $post) {
            $dealer = User::find($post->dealer_id);

            $post->user_type = $dealer->userType;
        }

        return view('carlisting', compact('users', 'makes', 'models', 'posts', 'colors', 'provinces', 'cities',  'features', 'bodytypes'));
    }


    public function check_price_range(Request $request)
    {
        //dd($request->all());
        $users = User::get();
        $makes = MakeCompany::where('status', 1)->get();
        $models = ModelCompany::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BodyType::where('status', 1)->get();
        $cities = City::all();
        $features = MainFeature::where('status', 1)->get();
        // $posts = Post::where('status', 0)
        //     ->where('price', '<=',$request->min)
        //     ->orWhere('price','>=',$request->max)
        //     ->get();



        $posts = Post::where('status', 1)
            ->whereRaw("CAST(price AS UNSIGNED) BETWEEN ? AND ?", [(int) $request->min, (int) $request->max])
            ->orderBy('feature_ad', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(25);
        foreach ($posts as $post) {
            $dealer = User::find($post->dealer_id);
            //dd($dealer);

            $post->user_type = $dealer->userType;
            //dd($post->user_type);
        }
        return view('carlisting', compact('users', 'makes', 'models', 'posts', 'colors', 'provinces', 'cities',  'features', 'bodytypes'));
    }

    public function cardetail($id)
    {
        $post = Post::withTrashed()->with('feature', 'dealer', 'location')->find($id);
        $posts = Post::where('make', $post->make)
            ->where('id', '!=', $post->id) // Exclude the current post
            ->get();
        $makes = MakeCompany::where('status', 1)->get();
        $models = ModelCompany::where('status', 1)->get();
        $price_alert = PriceAlert::where('post_id', $id)->where('user_id', Auth::id())->first();
        if ($price_alert) {

            return view('postdetail', compact('post', 'posts', 'makes', 'models', 'price_alert'));
        } else {
            $post->views += 1;
            $post->save();
            return view('postdetail', compact('post', 'posts', 'makes', 'models'));
        }
    }

    public function preview($id)
    {

        $post = Post::with('feature', 'dealer')->find($id);
        $posts = Post::where('make', $post->make)
            ->where('id', '!=', $post->id) // Exclude the current post
            ->get();
        $makes = MakeCompany::where('status', 1)->get();
        $models = ModelCompany::where('status', 1)->get();
        return view('user.post.preview', compact('post', 'posts', 'makes', 'models'));
    }

    public function add_to_wishlist($postid, $dealerid)
    {
        $wishlist = Whishlist::where('post_id', $postid)->where('user_id', $dealerid)->first();
        // dd($wishlist);
        if (!$wishlist) {
            $wishlist = new Whishlist();
            $wishlist->post_id = $postid;
            $wishlist->user_id = Auth::id();
            $wishlist->status = 1;
            $wishlist->save();
            $user = Auth::user();
            //    if($user->fcm_token){
            //       $tokens[]= $user->fcm_token;
            //   $notificationInstance = new SendFcmNotification();
            //   $notificationInstance->sendAddWishlistNotification($tokens, ["title"=>'Wishlist Notification', "body"=> 'Added to wishlist successfully']);
            //  }
            return redirect()->back()->with('wishlistresponse', 'Whishlist item add  ');
        } else {
            $wishlist->delete();
            $user = Auth::user();
            //   if($user->fcm_token){
            //     $tokens[]= $user->fcm_token;
            //   $notificationInstance = new SendFcmNotification();
            //   $notificationInstance->sendAddWishlistNotification($tokens, ["title"=>'Wishlist Notification', "body"=> 'Wishlist item removed successfully']);
            //  }
            return redirect()->back()->with('wishlistresponse', 'Whishlist item removed  ');
        }
    }

    public function add_price_alert($postid, $dealerid)
    {
        $price_alert = PriceAlert::where(['post_id' => $postid, 'user_id' => $dealerid])->first();
        // dd($price_alert);
        if (!$price_alert) {
            $price_alert = new PriceAlert();
            $price_alert->post_id = $postid;
            $price_alert->user_id = $dealerid;
            $price_alert->status = 1;
            $price_alert->save();
            $user = Auth::user();
            //   if($user->fcm_token){
            //     $tokens[]= $user->fcm_token;
            // $notificationInstance = new SendFcmNotification();
            //  $notificationInstance->sendAddWishlistNotification($tokens, ["title"=>'Price Alert', "body"=> 'Price Alert Added successfully']);
            //  }
            //dd('zaid');
            $post = Post::find($postid);

            $dealer = User::find($post->dealer_id);

            if ($dealer && $dealer->fcm_token) {
                $fcm_tokens = [$dealer->fcm_token];
                if ($fcm_tokens) {

                    SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'Price Alert Lead', 'body' => 'New Price Alert Lead for ' . $post->makeName . ' ' . $post->modelname]);



                    Notifications::create([
                        'user_id' => $dealer->id,
                        'title' => 'Price Alert Lead',
                        'body' => 'New Price Alert Lead for ' . $post->makeName . ' ' . $post->modelname,
                        'url' => url('get-price-alerts'),
                    ]);
                }
            }
            return redirect()->back()->with('price_alert', 'Price Alert Added successfully');
        } else {
            $price_alert->delete();
            $user = Auth::user();
            // if($user->fcm_token){
            //   $tokens[]= $user->fcm_token;
            // $notificationInstance = new SendFcmNotification();
            // $notificationInstance->sendAddWishlistNotification($tokens, ["title"=>'Price Alert', "body"=> 'Price Alert removed successfully']);
            //  }
            return redirect()->back()->with('price_alert', 'Price Alert removed successfully');
        }
    }
    public function search_data($id, $type)
    {
        //dd($type);
        $users = User::where('role', 1)->get();
        $makes = MakeCompany::where('status', 1)->get();
        $models = ModelCompany::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BodyType::where('status', 1)->get();
        $cities = City::all();
        $features = MainFeature::where('status', 1)->get();
        if ($type == 'bodytype') {
            $posts = Post::where('status', 1)
                ->orderBy('feature_ad', 'DESC')
                ->orderBy('created_at', 'DESC')
                ->where('body_type', $id)
                ->paginate(25);
        }
        if ($type == 'make') {
            $posts = Post::where('status', 1)
                ->orderBy('feature_ad', 'DESC')
                ->orderBy('created_at', 'DESC')
                ->where('make', $id)
                ->paginate(25);
        }
        foreach ($posts as $post) {
            $dealer = User::find($post->dealer_id);
            //dd($dealer);

            $post->user_type = $dealer->userType;
            //dd($post->user_type);
        }

        return view('carlisting', compact('users', 'makes', 'models', 'posts', 'colors', 'provinces', 'cities',  'features', 'bodytypes'));
    }


    public function change_post_status(Request $request)
    {
        if ($request->vehicle_type == 'car') {
            $post = Post::withTrashed()->with(['makecompany', 'modelcompany'])->where('id', $request->post_id)->first();
            $post->status = $request->status;
            $post->rejected_reason = $request->rejected_reason;

            $user = User::find($post->dealer_id);
            $post->save();



            //dd($request->status);
            if ($request->status == 0 || $request->status == '0') {
                $user = User::find($post->dealer_id);
                Mail::to($user->email)->send(new Ad_inactive($post));
            } elseif ($request->status == 2 || $request->status == '2') {
                $post->rejected_reason = $request->rejected_reason;

                $user = User::find($post->dealer_id);

                Mail::to($user->email)->send(new Ad_rejected($post));

                if ($user && $user->fcm_token != null) {
                    $tokens[] = $user->fcm_token;
                    $notificationInstance = new SendFcmNotification();
                    $notificationInstance->sendAddWishlistNotification($tokens, ["title" => 'Your Ad for ' . $post->makecompany->name . ' ' . $post->modelcompany->name . ' is rejected', "body" => 'Reason: ' . $request->rejected_reason]);
                }
            } else {


                Mail::to($user->email)->send(new Ad_accepted($post));
                if ($user && $user->fcm_token != null) {
                    $tokens[] = $user->fcm_token;
                    $notificationInstance = new SendFcmNotification();
                    $notificationInstance->sendAddWishlistNotification($tokens, ["title" => 'Your Ad for ' . $post->makecompany->name . ' ' . $post->modelcompany->name . ' is active', "body" => '']);
                }
            }
            $post->save();
            return redirect()->back()->with('warning', 'status change successfully');
        }
        if ($request->vehicle_type == 'bike') {
            $post = BikePost::withTrashed()->with(['features', 'location', 'contacts', 'media', 'dealer'])->where('id', $request->post_id)->first();
            $post->status = $request->status;
            $post->rejected_reason = $request->rejected_reason;

            $user = User::find($post->dealer_id);
            $post->save();
            if ($request->status == 0 || $request->status == '0') {
                $user = User::find($post->dealer_id);
                Mail::to($user->email)->send(new BikeAdInactive($post));
            } elseif ($request->status == 2 || $request->status == '2') {
                $post->rejected_reason = $request->rejected_reason;

                $user = User::find($post->dealer_id);

                Mail::to($user->email)->send(new BikeAdRejected($post));

                if ($user && $user->fcm_token != null) {
                    $tokens[] = $user->fcm_token;
                    $notificationInstance = new SendFcmNotification();
                    $notificationInstance->sendAddWishlistNotification($tokens, ["title" => 'Your Ad for ' . $post->makename . ' ' . $post->modelname . ' is rejected', "body" => 'Reason: ' . $request->rejected_reason]);
                }
            } else {


                Mail::to($user->email)->send(new BikeAdAccepted($post));
                if ($user && $user->fcm_token != null) {
                    $tokens[] = $user->fcm_token;
                    $notificationInstance = new SendFcmNotification();
                    $notificationInstance->sendAddWishlistNotification($tokens, ["title" => 'Your Ad for ' . $post->makename . ' ' . $post->modelname . ' is active', "body" => '']);
                }
            }
            $post->save();
            return redirect()->back()->with('warning', 'status change successfully');
        }
    }

    public function allDealerAds($id)
    {
        $users = User::where('role', 1)->get();
        $makes = MakeCompany::where('status', 1)->get();
        $models = ModelCompany::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BodyType::where('status', 1)->get();
        $cities = City::all();
        $features = MainFeature::where('status', 1)->get();
        $posts = Post::with('feature', 'document', 'location', 'contact')->where(['dealer_id' => $id, 'status' => "1"])->paginate(25);
        $dealer = User::find($id);

        return view('superadmin.Cars.dealer_other_ads',  compact('users', 'makes', 'models', 'posts', 'colors', 'provinces', 'cities',  'features', 'bodytypes', 'dealer'));
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
        return view('superadmin.post.add_submition');
    }


    public function allDealerBikeAds($id)
    {
        $users = User::where('role', 1)->get();
        $makes = BikeMake::where('status', 1)->get();
        $models = BikeModels::where('status', 1)->get();
        $colors = Color::all();
        $provinces = Province::all();
        $bodytypes = BikeBodyTypes::where('status', 1)->get();
        $cities = City::all();
        $features = BikeMainFeatures::where('status', 1)->get();
        $posts = BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->where(['dealer_id' => $id, 'status' => "1"])->paginate(25);
        $dealer = User::find($id);

        return view('user.post.bikes.dealer_bike_other_ads',  compact('users', 'makes', 'models', 'posts', 'colors', 'provinces', 'cities',  'features', 'bodytypes', 'dealer'));
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

    public function check_dealer_posting_status(Request $request)
    {
        $user = User::findOrFail($request->dealer_id);
        $dealerId = $user->role == 2 ? $user->dealer_id : $user->id;

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
                Log::error('Stripe Subscription Error: ' . $e->getMessage());
            }
        }

        if (!$hasValidAdSubscription || !$plan) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Dealer subscription is invalid or expired.']);
        }

        $posted_ads = Post::where('dealer_id', $dealerId)->count();
        $posted_ads2 = BikePost::where('dealer_id', $dealerId)->count();
        $total_ads = $posted_ads + $posted_ads2;


        $featured_posted_ads = Post::where('dealer_id', $dealerId)->where('feature_ad', 1)->count();
        $featured_posted_ads2 = BikePost::where('dealer_id', $dealerId)->where('is_featured', 1)->count();
        $featured_total_ads = $featured_posted_ads + $featured_posted_ads2;

        if ($plan->metadata->allowed_ads == 'unlimited') {
            return response()->json(['success' => true, 'message' => 'You can post unlimited ads.']);
        } elseif ($plan->metadata->allowed_ads > $total_ads) {
            return response()->json(['success' => true, 'message' => 'You can post more ads.']);
        } else {
            return response()->json(['success' => false, 'message' => 'This dealer has reached the limit of ' . $plan->metadata->allowed_ads . ' ads they can post.']);
        }
    }

    public function export()
    {
        return Excel::download(new PostsExport, 'posts_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        try {
            Excel::import(new PostsImport, $request->file('excel_file'));
            return redirect()->route('superadmin.ads.index')->with('success', 'Posts imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.ads.index')->with('error', 'Error importing posts: ' . $e->getMessage());
        }
    }
}
