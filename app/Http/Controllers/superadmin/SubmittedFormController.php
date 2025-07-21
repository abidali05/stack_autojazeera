<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Post;
use App\Models\User;
use App\Mail\New_lead;
use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Models\SubmittedForm;
use App\Models\Bike\BikeLeads;
use App\Jobs\SendFcmNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class SubmittedFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = SubmittedForm::with('post', 'user')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->paginate(25);
        return view('user.submitform.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'number' => 'required|string',
            'fullname' => 'required|string',
            // 'DateOfBirth' => 'required',
            // 'Time' => 'required',
            // 'Method' => 'required',
            'Comment' => 'required',

        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $sub = SubmittedForm::with('post', 'user')->where(['user_id' => $request->user_id, 'post_id' => $request->post_id, 'requesttype' => $request->type])->get();
        if ($sub->isEmpty()) {
            $sub = new SubmittedForm();
            $sub->fullname = $request->fullname;
            $sub->email = $request->email;
            $sub->post_id = $request->post_id;
            $sub->dealer_id = $request->dealer_id;
            $sub->user_id = $request->user_id;
            $sub->number = $request->number;
            $sub->requesttype = $request->type;
            if ($request->DateOfBirth) {
                $sub->dob = $request->DateOfBirth;
            }
            if ($request->Time) {
                $sub->apointment_time = $request->Time;
            }
            if ($request->friend_name) {
                $sub->friendFullname = $request->friend_name;
            }
            if ($request->friend_email) {
                $sub->friendemail = $request->friend_email;
            }
            if ($request->Method) {
                $sub->perefered_contact_method = $request->Method;
            }

            $sub->comment = $request->Comment;
            $sub->save();
            $post = Post::with('document')->find($request->post_id);
            $mainDoc = $post->document->first() ?? null;
            $post->setAttribute('image', $mainDoc ? url('posts/doc/' . $mainDoc->doc_name) : url('web/images/default-car.jpg'));
            $post->setAttribute('mileage_icon', 'bi bi-speedometer2');
            $post->setAttribute('transmission_icon', 'bi bi-car-front-fill');
            $post->setAttribute('fuel_icon', 'bi bi-fuel-pump-diesel');

            $user = User::find($request->dealer_id);
            //$body = view('emails.new_lead',compact('sub','post'));
            //sendmail($user->name, $user->email, 'Auto Jazeera Notification', 'You have a new Lead', $body);
            Mail::to($user->email)->send(new New_lead($post));

            $fcm_tokens = [$user->fcm_token];
            if ($fcm_tokens) {
                SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'New Sales Lead', 'body' => 'New Sales Lead for ' . $post->makeName . ' ' . $post->modelname]);
                Notifications::create([
                    'user_id' => $user->id,
                    'title' => 'New Sales Lead',
                    'body' => 'New Sales Lead for ' . $post->makeName . ' ' . $post->modelname,
                    'url' => route('cardetail', $post->id),
                ]);
            }

            return response()->json(['success' => true]);
        } else {
            return response()->json(['warning' => true]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function submitted_bike_leads()
    {
        $forms = BikeLeads::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->paginate(25);
        return view('user.submitform.submitted_bike_leads', compact('forms'));
    }
}
