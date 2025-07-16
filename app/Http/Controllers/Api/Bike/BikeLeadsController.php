<?php

namespace App\Http\Controllers\Api\Bike;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\New_lead;
use Illuminate\Http\Request;
use App\Models\Bike\BikePost;
use App\Models\Notifications;
use App\Models\Bike\BikeLeads;
use App\Jobs\SendFcmNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BikeLeadsController extends Controller
{
    public function submit(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $user = auth('sanctum')->user();

        $validator = Validator::make($request->all(), [

            'fullname' => 'required|string',
            'email' => 'required|email',
            'number' => 'required|string',
            // 'DateOfBirth' => 'required',
            // 'Time' => 'required',
            'Method' => 'required',
            'Comment' => 'required',
            'type' => 'required',
            'post_id' => 'required|integer|exists:bikes_posts,id',

        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 402,], 402);
        }
        $post = BikePost::where('id', $request->post_id)->where('status', 1)->first();
        if (!$post) {
            return response()->json(['status' => 404, 'message' => "Post not found"]);
        }
        $lead = BikeLeads::where('user_id', $request->user_id)->where('post_id', $request->post_id)->where('requesttype', $request->type)->first();
        if ($lead) {
            return response()->json([
                "status" => 200,
                "message" => "Already Submitted"
            ], 200);
        } else {
            $lead = new BikeLeads();
            $lead->fullname = $request->fullname;
            $lead->email = $request->email;
            $lead->post_id = $request->post_id;
            $lead->dealer_id = $request->dealer_id;
            $lead->user_id = $request->user_id;
            $lead->number = $request->number;
            $lead->requesttype = $request->type;
            $lead->dob = Carbon::parse($request->DateOfBirth)->format('Y-m-d');
            $lead->apointment_time = $request->Time;
            $lead->perefered_contact_method = $request->Method;
            $lead->comment = $request->Comment;
            $lead->save();
            $post = Bikepost::with(['features', 'location', 'contacts', 'media', 'dealer'])->find($request->post_id);
            $dealer = User::where('id', $post->dealer_id)->first();
            $body = view('emails.bikes.new_lead', compact('post'));
            sendMail($request->name, $dealer->email, 'Auto Jazeera', 'New Sales Lead', $body);


            $fcm_tokens = [$dealer->fcm_token];
            if ($fcm_tokens) {

                SendFcmNotification::sendPriceAlertNotification($fcm_tokens, ['title' => 'New Sales Lead', 'body' => 'New Sales Lead for ' . $post->makename . ' ' . $post->modelname]);



                Notifications::create([
                    'user_id' => $dealer->id,
                    'title' => 'New Sales Lead',
                    'body' => 'New Sales Lead for ' . $post->makename . ' ' . $post->modelname,
                    'url' => url('leads/bikes'),
                ]);
            }

            return response()->json([
                "status" => 200,
                "message" => "Your form submitted successfully"
            ], 200);
        }
    }

    public function mySubmittedBikeLeads()
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();
        $leads = BikeLeads::where('user_id', $user->id)->get();
        return response()->json([
            "data" => $leads,
            "status" => 200,
            "message" => "submitted form found"
        ], 200);
    }


    // view received leads 




    public function clearBikeLeads(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to access this route'
            ], 401);
        }
        // dd($request->all());
        $user = auth('sanctum')->user();

        if ($request->id) {
            $submitted_form_id = $request->id;

            if ($submitted_form_id) {
                $submitted_form = BikeLeads::find($submitted_form_id);
                if (!$submitted_form) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Submitted form not found'
                    ]);
                }

                if ($submitted_form->user_id !== $user->id) {
                    return response()->json([
                        'status' => 422,
                        'message' => 'You are not authorized to delete this form'
                    ]);
                }

                $submitted_form->delete();

                return response()->json([
                    'status' => 200,
                    'message' => 'Form deleted successfully'
                ]);
            }
        } else {
            BikeLeads::where('user_id', $user->id)->delete();

            return response()->json([
                'status' => 200,
                'message' => 'All forms deleted'
            ]);
        }
    }


    public function viewBikeLeads(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();
        if($user->role == 2 || $user->role == '2'){
            $user_id = $user->dealer_id;
        }
        else{

            $user_id = $user->id;
        }
        $leads = BikeLeads::where('dealer_id', $user_id)->get();
        return response()->json([
            "data" => $leads,    
            "status" => 200,
            "message" => "submitted form found"
        ], 200);
    }
}
