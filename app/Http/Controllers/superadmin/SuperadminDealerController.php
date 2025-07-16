<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\DeallerSubscription;
use App\Models\Provence;
use App\Models\Province;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use GPBMetadata\Google\Type\Month;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\Product;
use Illuminate\Support\Facades\Mail;
use App\Mail\Welcome;

class SuperadminDealerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
   
         Stripe::setApiKey(config('services.stripe.secret'));
       $users1=User::where('role',1)->paginate(25);
       if($request->user_id)
       {
        
        $users=User::orderby('id','desc')->where(['role'=>1,'id'=>$request->user_id])->paginate(25);
       }
       else{
        $users=User::orderby('id','desc')->where('role',1)->paginate(25);
       }
       
      
       return view('superadmin.Dealer.index',compact('users','users1'));
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
	
	public function checkEmailCreate(Request $request) {
		
		$exists = User::where('email', $request->email)->exists();
		
		if($exists) {
			return response()->json([
				'exists' => $exists
			]);
		}

	}
	
	public function checkEmailUpdate(Request $request) {
		
		$userId = $request->user_id;

    // Check if the email exists, but exclude the current user
    $exists = User::where('email', $request->email)
                  ->where('id', '!=', $userId)  // Exclude the current user
                  ->exists();

    return response()->json([
        'exists' => $exists
    ]);

	}
	
	public function checkNumberCreate(Request $request) {
		
		$number = $request->number;

    // Ensure the number starts with '+92' and strip any unwanted characters
    if (substr($number, 0, 3) !== '+92') {
        $number = '+92' . ltrim($number, '+');
    }

    // Normalize the number by removing any non-numeric characters (except '+')
    $number = preg_replace('/[^0-9+]/', '', $number);

    // Check if the number exists in the database
    $exists = User::where('number', $number)->exists();
		
		if($exists) {
			return response()->json([
				'exists' => $exists
			]);
		}

	}
	
	public function checkNumberUpdate(Request $request) {
		
		$userId = $request->user_id;
    $number = $request->number;

    // Ensure the number starts with '+92' and strip any unwanted characters
    if (substr($number, 0, 3) !== '+92') {
        $number = '+92' . ltrim($number, '+');
    }

    // Normalize the number by removing any non-numeric characters (except '+')
    $number = preg_replace('/[^0-9+]/', '', $number);

    // Check if the number exists in the database, excluding the current user's number
    $exists = User::where('number', $number)
                  ->where('id', '!=', $userId)  // Exclude the current user
                  ->exists();

    return response()->json([
        'exists' => $exists
    ]);

	}
	
    public function store(Request $request)
    {
	

			//dd($request->all(), $request->file('image'));

        // $user->number="+92".$request->number;
        $request->merge(['number' => "+92" . $request->number]);
        $validator = Validator::make($request->all(), [
           // 'dealershipName' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'number' => [
                'required',
                'string',
                //'unique:users', // Ensures no duplicate phone numbers
                'regex:/[0-9]{10}/' // Validates only the 10-digit local number part
            ],

            //'password' => 'required',
            'province' => 'required',
            'city' => 'required',
            'status' => 'required',
            'address' => 'required',
            // 'website' => 'required',
         
           
            
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // if ($validator->fails()) {
         
        //     return redirect()->back()
        //                      ->withErrors($validator)
        //                      ->withInput();
        // }
      
        $user=new User();
        $user->name=$request->name;
        $user->dealershipName=$request->dealershipName;
		
        $user->number=$request->number;
        $user->email=$request->email;
        
            $user->password=bcrypt($request->name);
      
       
        $user->package='prod_RTgB3KyZygKo2I';
        $user->province=$request->province;
        $user->city=$request->city;
        $user->status=$request->status;
        $user->role=1;
		$user->free_package_availed=1;
      
        $user->address=$request->address;
        $user->website=$request->website;
        $user->allow_company=$request->allow_company=="on"?1:0;
        $user->bulk_import=$request->bulk_import=="on"?1:0;
        $user->user_management=$request->user_management=="on"?1:0;
		if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('His') . '_' . $file->getClientOriginalName(); // Generate a unique filename

            // Move the file to the public directory
            $file->move(public_path('web/profile'), $filename);

            // Delete old image if it exists
            if ($user->image && file_exists(public_path('web/profile/' . $user->image))) {
                unlink(public_path('web/profile/' . $user->image));
            }

            $user->image = $filename; // Save new image name to input
        }
        $user->save();
		//$body = view('emails.welcome');
		// sendMail($user->name, $user->email, 'Auto Jazeera', 'Welcome To Auto Jazera', $body);
			Mail::to($user->email)->send(new Welcome());
        if($request->role == 1)
        {
            
           $dealer=new DeallerSubscription();
           $dealer->user_id=$user->id;
           $dealer->current_subscription="prod_RTgB3KyZygKo2I";
           $dealer->billing_start=Carbon::today();
           $dealer->billing_end=Carbon::today()->addMonths(1);
           //$dealer->billing_end=Carbon::tomorrow();
           $dealer->status=1;
           $dealer->save();
        }
		
		
        //return response()->json(['success' => true,'redirect' => url('dealer')]);
return redirect()->route('superadmin.dealer.index');

        // return redirect()->back()->with('success','dealer user added successfully');
      
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
    // public function update(Request $request, string $id)
    // {
    
    //     $validator = Validator::make($request->all(), [
    //         'dealershipName' => 'required|string',
    //         'name' => 'required|string',
           
    //         'email' => 'required|email|unique:users,email,' . $id,
    //         'number' => 'required|string|digits:12|unique:users,number,' . $id,
    
    //         // 'password' => 'required',
    //         'province' => 'required',
    //         'city' => 'required',
    //         'status' => 'required',
    //         'address' => 'required',
    //         // 'website' => 'required',
         
           
            
    //     ]);
        
      
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }
    //         //     if ($validator->fails()) {
         
    //         // return redirect()->back()
    //         //                  ->withErrors($validator)
    //         //                  ->withInput();
    //         //                 //  dd('ok');
    //         //                  }
    //     $user=User::find($id);
    //     $user->name=$request->name;
    //     $user->dealershipName=$request->dealershipName;
    //     $user->number='+92'.$request->number;
    //     $user->email=$request->email;
    //     if($request->password)
    //     {
    //         $user->password=bcrypt($request->password);
    //     }
       
    //     $user->province=$request->province;
    //     $user->city=$request->city;
    //     $user->status=$request->status;
    //     $user->address=$request->address;
    //     $user->website=$request->website;
    //     $user->allow_company=$request->allow_company=="on"?1:0;
    //     $user->bulk_import=$request->bulk_import=="on"?1:0;
    //     $user->user_management=$request->user_management=="on"?1:0;
    //     $user->update();
    //     // dd($user);
    //     return response()->json(['success' => true]);
    //     // return redirect()->back()->with('warning','dealer user updated successfully');
      
    // }
    public function update(Request $request, string $id)
    {
        
			$validator = Validator::make($request->all(), [
            //'dealershipName' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'number' => 'nullable|string|digits:10|unique:users,number,' . $id,
            //'province' => 'required',
            //'city' => 'required',
            'status' => 'required',
            //'address' => 'required',
            // 'website' => 'required',
        ]);
        
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $user = User::find($id);
        $user->name = $request->name;
        $user->dealershipName = $request->dealershipName;
		if( $request->number)
		{
        $user->number = '+92' . $request->number;
		}
        $user->email = $request->email;
    
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
    
        $user->province = $request->province;
        $user->city = $request->city;
        $user->status = $request->status;
        $user->address = $request->address;
        $user->website = $request->website;
        $user->allow_company = $request->allow_company == "on" ? 1 : 0;
        $user->bulk_import = $request->bulk_import == "on" ? 1 : 0;
        $user->user_management = $request->user_management == "on" ? 1 : 0;
    	if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('His') . '_' . $file->getClientOriginalName(); // Generate a unique filename

            // Move the file to the public directory
            $file->move(public_path('web/profile'), $filename);

            // Delete old image if it exists
            if ($user->image && file_exists(public_path('web/profile/' . $user->image))) {
                unlink(public_path('web/profile/' . $user->image));
            }

            $user->image = $filename; // Save new image name to input
        }
        $user->save(); // Use save() instead of update()
    
        return redirect()->route('superadmin.dealer.index');
        
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        $user=User::find($request->deleted_id);
        $user->delete();
        return redirect()->back()->with('danger','Data Deleted Successfully');
    }
    public function change_status($id)
    {
       
        $post=User::find($id);
        if($post->status == 'inactive')
        {
            $post->status='active';
        }
       else
       {
        $post->status='inactive';
       }
        $post->update();
        return redirect()->back()->with('warning','status change successfully');
    }
}
