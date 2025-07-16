<?php

namespace App\Http\Controllers;

use App\Models\Superadmin;
use App\Models\User;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionBuy;

class SettingController extends Controller
{
    public function loginSecurity()
    {
        return view('setting.loginSecurity');
    }
	    public function personal_info()
    {
        return view('setting.personal_information');
    }
	public function admin_loginSecurity()
    {
        return view('setting.admin_loginSecurity');
    }
	    public function admin_personal_info()
    {
        return view('setting.admin_personal_information');
    }
	    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'dealer' => 'required|max:255',
            'old_password' => 'required|string',
            'password' => 'required|min:8|confirmed',

        ]);

        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = auth()->user();
        // $credentials = $request->only('email', 'password');
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The current password does not match our records.']);
        }

        // Update the password
        $u = User::find($user->id);
        $u->password = bcrypt($request->password);
        $u->save();

        return back()->with('success', 'Password updated successfully.');
    }
	 public function change_image(Request $request)
    {
        //dd($request->all());
			   $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048', // Validation rules
    ], [
        'image.required' => 'The image is required.',
        'image.image' => 'The file must be an image.',
        'image.mimes' => 'Allowed image types are jpeg, png, jpg, and svg.',
        'image.max' => 'The image must not be greater than 2MB.',
    ]);
  
       $user= User::find(Auth::user()->id);
       if($request->file('image'))
       {
           $file=$request->file('image');
           $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
           $file->move(public_path('web/profile/'), $filename);
           $user->image = $filename;
       }
        $user->update();
        return redirect()->back()->with('success','image updated successfully');
    }
 public function profile(Request $request)
{
    $input = $request->except('_token');

    if ($request->number) {
        // Keep leading +, remove all other non-digit characters
        $cleanNumber = preg_replace('/(?!^\+)\D/', '', $request->number);
        $input['number'] = $cleanNumber;
    }

    // Validate using the cleaned number
    Validator::make(
        ['number' => $input['number'] ?? null],
        [
            'number' => 'nullable|unique:users,number,' . auth()->user()->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ],
        [
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Allowed image types are jpeg, png, jpg, and svg.',
            'image.max' => 'The image must not be greater than 2MB.',
        ]
    )->validate();

    try {
        $user = Auth::user();

        // Handle image upload
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('His') . '_' . $file->getClientOriginalName();
            $file->move(public_path('web/profile'), $filename);

            if ($user->image && file_exists(public_path('web/profile/' . $user->image))) {
                unlink(public_path('web/profile/' . $user->image));
            }

            $input['image'] = $filename;
        }

        // Set additional fields
        $input['province'] = $request->province;
        $input['city'] = $request->city;

        // Update user profile
        $user->update($input);
        $user->province = $request->province;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to update profile.');
    }
}

	 public function admin_change_image(Request $request)
    {
        //dd($request->all());
		   $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048', // Validation rules
    ], [
        'image.required' => 'The image is required.',
        'image.image' => 'The file must be an image.',
        'image.mimes' => 'Allowed image types are jpeg, png, jpg, and svg.',
        'image.max' => 'The image must not be greater than 2MB.',
    ]);
  
       $user= Superadmin::find( Auth::guard('superadmin')->user()->id);
       if($request->file('image'))
       {
           $file=$request->file('image');
           $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
           $file->move(public_path('web/profile/'), $filename);
           $user->image = $filename;
       }
        $user->update();
        return redirect()->back()->with('success','image updated successfully');
    }
    public function admin_profile(Request $request)
    {

        $input = $request->except('_token','password_confirmation');

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Allowed image types are jpeg, png, jpg, and svg.',
            'image.max' => 'The image must not be greater than 2MB.',
        ]);
        $user = Auth::guard('superadmin')->user();

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('His') . '_' . $file->getClientOriginalName(); // Generate a unique filename

            // Move the file to the public directory
            $file->move(public_path('web/profile'), $filename);

            // Delete old image if it exists
            if ($user->image && file_exists(public_path('web/profile/' . $user->image))) {
                unlink(public_path('web/profile/' . $user->image));
            }

            $input['image'] = $filename; // Save new image name to input
        }
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        } else {
			unset($input['password']);
		}
        try {
		$user = Superadmin::where('id', Auth::guard('superadmin')->user()->id)->update($input);	
		} catch(\Exception $e) {
			dd($e->getMessage());
		}

        return redirect()->back()->with('success', 'profile updated successfully');
    }
	    public function complete_registration()
    {
        $user=Auth::user();
        if($user->role == '1' && $user->dealershipName !=null){

            return redirect('/dashboard')->with('success','congratulation, your plan has been upgraded');
        }
        else{

            $provinces = Province::all();
            return view('user.complete_registration',compact('user','provinces'));
        }
    }
   public function dealer_store(Request $request)
    {
        $request->merge(['number' => "+92" . $request->number]);
        $validator = Validator::make($request->all(), [
            'dealershipName' => 'required|string',
         
            'number' => [
                'required',
                'string',
                'unique:users', // Ensures no duplicate phone numbers
                'regex:/[0-9]{10}/' // Validates only the 10-digit local number part
            ],

            'province' => 'required',
            'city' => 'required',
        
            'address' => 'required',
            // 'website' => 'required',
         
           
            
        ]);
        $user=User::find(Auth::user()->id);
        
        $user->dealershipName=$request->dealershipName;
		
        $user->number=$request->number;     
        
       
        $user->province=$request->province;
        $user->city=$request->city;
     
        $user->role=1;
        $user->free_package_availed=1;
        $user->offer_test_drive=$request->offer_test_drive;
        $user->address=$request->address;
        $user->save();
        //$body = view('emails.subscription_buy');
        //sendMail($user->name, $user->email, 'Auto Jazera', 'Plan Subscribed Successfully', $body);
	   	Mail::to($user->email)->send(new SubscriptionBuy());
        return redirect('/dashboard')->with('dealer_register_success','Thanks for subscribing ! Your payment is confirmed, and you`re now part of our platform');

    }
	
	public function dealership_info(){
		if(Auth::user()->userType == 'private_seller'){
			return redirect('unauthorized');
		}
		 return view('setting.dealer_profile');
	}
	
	public function dealership_profile(Request $request)
{
    $input = $request->except('_token');

    if ($request->number) {
        // Clean number: remove non-digits except leading +
        $cleanNumber = preg_replace('/(?!^\+)\D/', '', $request->number);
        $input['number'] = $cleanNumber;
    }

    $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        'dealershipName' => $request->seller_type === 'car_dealer' ? 'required' : 'nullable',
    ], [
        'image.image' => 'The file must be an image.',
        'image.mimes' => 'Allowed image types are jpeg, png, jpg, and svg.',
        'image.max' => 'The image must not be greater than 2MB.',
        'dealershipName.required' => 'Dealership Name is required.',
    ]);

    try {
        $user = Auth::user();

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('His') . '_' . $file->getClientOriginalName();

            $file->move(public_path('web/profile'), $filename);

            if ($user->image && file_exists(public_path('web/profile/' . $user->image))) {
                unlink(public_path('web/profile/' . $user->image));
            }

            $input['image'] = $filename;
        }

        $input['dealershipName'] = $request->dealershipName ?? 'Private Seller';
        $input['province'] = $request->province;
        $input['city'] = $request->city;

        $user->update($input);
        $user->address = $request->address;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to update profile.');
    }
}


}
