<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserdealeruserController extends Controller
{

    public function index()
    {
        if (Auth::user()->userType == 'private_seller') {
            return redirect('unauthorized');
        }
        $permissions = UserPermission::all();

        $users = User::orderby('id', 'desc')->where('dealer_id', Auth::user()->id)->where('role', 2)->paginate(25);


        return view('superadmin.Dealer_user.index', compact('users', 'permissions'));
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
    // Clean PhoneNumber: keep + at start, remove all other non-digits
    $cleanPhone = preg_replace('/(?!^\+)\D/', '', $request->PhoneNumber);

    // Merge cleaned number back into request for validation
    $request->merge([
        'PhoneNumber' => $cleanPhone
    ]);

    $request->validate([
        'email' => 'required|email|unique:users,email',
        'PhoneNumber' => 'required|unique:users,number',
        'permissions' => 'required'
    ], [
        'permissions.required' => 'Select at least one permission'
    ]);

    $user = new User();
    $dealer = User::find($request->dealerName);

    $user->name = $request->name;
    $user->dealershipName = $request->dealershipName;
    $user->number = $request->PhoneNumber; // already cleaned
    $user->email = $request->email;
    $user->password = bcrypt($request->dealerName);
    $user->status = "inactive";
    $user->dealer_id = $request->dealerName;
    $user->role = 2;

    $user->userType = $dealer->userType;
    $user->dealershipName = $dealer->dealershipName;
    $user->ads_count = $dealer->ads_count;
    $user->free_package_availed = $dealer->free_package_availed;
    $user->gender = $dealer->gender;
    $user->province = $dealer->province;
    $user->city = $dealer->city;
    $user->area = $dealer->area;
    $user->address = $dealer->address;
    $user->package = $dealer->package;
    $user->website = $dealer->website;
    $user->dealer_logo = $dealer->dealer_logo;
    $user->save();

    foreach ($request->permissions as $data) {
        $permission = new UserPermission();
        $permission->user_id = $user->id;
        $permission->permissions = $data;
        $permission->save();
    }

    return redirect()->back()->with('success', 'dealer user added successfully');
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
    $user = User::findOrFail($id);

    // Clean PhoneNumber: keep + at start, remove all other non-digits
    $cleanPhone = preg_replace('/(?!^\+)\D/', '', $request->PhoneNumber);

    // Validate cleaned number and other fields
    $request->merge([
        'PhoneNumber' => $cleanPhone
    ]);

    $request->validate([
        'email' => 'required|email|unique:users,email,' . $user->id,
        'PhoneNumber' => 'required|unique:users,number,' . $user->id,
    ]);

    $user->name = $request->name;
    $user->dealershipName = $request->dealershipName;
    $user->number = $request->PhoneNumber;
    $user->email = $request->email;

    if ($request->password) {
        $user->password = bcrypt($request->password);
    }

    $user->province = $request->province;
    $user->city = $request->city;

    if ($request->status) {
        $user->status = $request->status;
    }

    $user->address = $request->address;
    $user->website = $request->website;
    $user->allow_company = $request->allow_company == "on" ? 1 : 0;
    $user->bulk_import = $request->bulk_import == "on" ? 1 : 0;
    $user->user_management = $request->user_management == "on" ? 1 : 0;

    if ($request->has('permissions')) {
        UserPermission::where('user_id', $user->id)->delete();
        foreach ($request->permissions as $data) {
            UserPermission::create([
                'user_id' => $user->id,
                'permissions' => $data
            ]);
        }
    }

    $user->save();

    return redirect()->back()->with('warning', 'Dealer user updated successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = User::find($request->deleted_id);
        $user->delete();
        return redirect()->back()->with('danger', 'Data Deleted Successfully');
    }

    public function change_status($id)
    {
        $user = User::find($id);
        if ($user->status == "active") {
            $user->status = "inactive";
        } else {
            $user->status = "active";
        }
        $user->update();
        return redirect()->back()->with('warning', 'status updated successfully');
    }
}
