<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;


class DealerUserController extends Controller
{
    public function getAllDealerUsers()
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = auth('sanctum')->user();
        $users = User::orderby('id', 'desc')->where('dealer_id', $user->id)->where('role', 2)->get();


        if ($users->isEmpty()) {
            return response()->json([
                "data" => [],
                "status" => 200,
                "message" => "No employees found"


            ], 200);
        } else {
            return response()->json([
                "data" => $users,
                "status" => 200,
                "message" => "employees found"


            ], 200);
        }
        return response()->json(['users' => $users]);
    }

    public function store(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $dealer = auth('sanctum')->user();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'phoneNumber' => 'required|unique:users,number',
            'permissions' => 'required'
        ], [
            'permissions.required' => 'Select at least one permission'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = new User();
        $user->name = $request->name;
        $user->dealershipName = $dealer->dealershipName;
        $user->number = $request->phoneNumber;
        $user->email = $request->email;
        $user->password = Hash::make($request->name);
        $user->status = "inactive";
        $user->dealer_id = $dealer->id;
        $user->role = 2;
        $user->userType = $dealer->userType;
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
        return response()->json(['status' => 200, 'message' => "dealer user added successfully"]);
    }


    public function update(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'phoneNumber' => 'required',
            'permissions' => 'required',
            'id' => 'required'
        ], [
            'permissions.required' => 'Select at least one permission'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->number = $request->phoneNumber;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->save();
        UserPermission::where('user_id', $request->id)->delete();
        foreach ($request->permissions as $data) {
            $permission = new UserPermission();
            $permission->user_id = $user->id;
            $permission->permissions = $data;
            $permission->save();
        }
        return response()->json(['status' => 200, 'message' => "dealer user updated successfully"]);
    }

    public function delete(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }
        $user = User::find($request->id);
        $user->delete();
        UserPermission::where('user_id', $request->id)->delete();
        return response()->json(['status' => 200, 'message' => "dealer user deleted successfully"], 200);
    }

    public function changeStatus(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json(['status' => 422, 'message' => "You are not authorized to access this route"]);
        }

        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::find($request->id);
        if ($user->status == "active") {
            $user->status = "inactive";
        } else {
            $user->status = "active";
        }
        $user->update();
        return response()->json(['status' => 200, 'message' => "dealer user status changed successfully"], 200);
    }
}
