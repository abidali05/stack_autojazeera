<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Provence;
use App\Models\Province;
use App\Models\State;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperadminDealerUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
		
        $permissions=UserPermission::all();
        $users=User::orderby('id','desc')->where('dealer_id',$id)->where('role',2)->paginate(25);
       
        return view('superadmin.Dealer_user.index',compact('users','permissions'));
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
    //  dd($request->all());
        $user=new User();
        $dealer = User::find($request->dealerName);
        $user->name=$request->name;
        $user->dealershipName=$request->dealershipName;
        $user->number=$request->PhoneNumber;
        $user->email=$request->email;
        if($request->password)
        {
            $user->password=bcrypt($request->password);
        }
       
    
        // $user->status=$request->status;
        $user->status="inactive";
        $user->dealer_id=$request->dealerName;
        // $user->role=$request->role;
        $user->role=2;
        $user->userType = $dealer->userType;
    
            $user->dealershipName = $dealer->dealershipName;
            $user->ads_count = $dealer->ads_count;
            $user->free_package_availed = $dealer->free_package_availed;
            $user->gender = $dealer->gender;
            $user->province=$dealer->province;
            $user->city=$dealer->city;
            $user->area = $dealer->area;
            $user->address = $dealer->address;
            $user->package = $dealer->package;
            $user->website = $dealer->website;
            $user->dealer_logo = $dealer->dealer_logo;

        $user->save();
        foreach($request->permissions as $data)
        {
            $permission=new UserPermission();
            $permission->user_id=$user->id;
            $permission->permissions=$data;
            $permission->save();
        }
    
        // Assign permissions
        // if ($request->has('permissions')) {
        //     $user->permissions()->attach(Permission::whereIn('name', $request->permissions)->pluck('id'));
        // }
        return redirect()->back()->with('success','dealer user added successfully');
      
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
        $user=User::find($id);
        $user->name=$request->name;
        $user->dealershipName=$request->dealershipName;
        $user->number=$request->PhoneNumber;
        $user->email=$request->email;
        if($request->password)
        {
            $user->password=bcrypt($request->password);
        }
       
        $user->province=$request->province;
        $user->city=$request->city;
        $user->status=$request->status;
        $user->address=$request->address;
        $user->website=$request->website;
        $user->allow_company=$request->allow_company=="on"?1:0;
        $user->bulk_import=$request->bulk_import=="on"?1:0;
        $user->user_management=$request->user_management=="on"?1:0;
        $user->update();
        return redirect()->back()->with('warning','dealer user updated successfully');
      
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
}
