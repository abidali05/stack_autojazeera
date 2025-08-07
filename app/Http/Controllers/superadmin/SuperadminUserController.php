<?php

namespace App\Http\Controllers\superadmin;

use Exception;
use App\Models\User;
use App\Models\Shops;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\AutoServices\Bookings;
use App\Models\Autoservices\ShopImages;
use App\Models\Autoservices\ShopTimings;
use App\Models\AutoServices\ShopServices;
use Illuminate\Support\Facades\Validator;
use App\Models\AutoServices\ShopAmenities;
use App\Models\AutoServices\BookingServices;

class SuperadminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dealers = User::where('role', 1)->where('userType', 'car_dealer')->get();
        $userSellers = User::where('role', 0)->where('userType', 'car_dealer')->get();
        $privateSellers = User::where('role', 1)->where('userType', 'private_seller')->get();
        $dealerusers = User::where('role', 2)->get();
        return view('superadmin.users.index', compact('dealers', 'privateSellers', 'dealerusers', 'userSellers'));
    }

    public function getUsersByRole(Request $request)
    {
        $privateSellers = User::where('userType', 'private_seller')->paginate(25);
        $carDealers = User::where('userType', 'car_dealer')->paginate(25);
        $carDealersList = User::where('role', 1)->get();

        // Fetch dealer users (role = 2) with pagination
        $dealerUsersQuery = User::where('role', 2);

        if ($request->has('dealer_id') && $request->dealer_id && $request->dealer_id != 0) {
            $dealerUsersQuery->where('dealer_id', $request->dealer_id);
        }

        $dealerUsers = $dealerUsersQuery->paginate(25); // Adjust pagination as needed

        return response()->json([
            'private_sellers' => $privateSellers,
            'car_dealers' => $carDealers,
            'dealer_users' => $dealerUsers,
            'car_dealers_list' => $carDealersList,

            'pagination' => [
                'private_sellers' => $privateSellers->links()->toHtml(),
                'car_dealers' => $carDealers->links()->toHtml(),
                'dealer_users' => $dealerUsers->links()->toHtml(),
            ],
        ]);
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
        try {
            $request->merge(['number' => "+92" . $request->number]);
            $request->validate([
                'dealershipName' => 'required|string',
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'number' => [
                    'required',
                    'string',
                    'unique:users', // Ensures no duplicate phone numbers
                    'regex:/[0-9]{10}/' // Validates only the 10-digit local number part
                ],


                //'province' => 'required',
                //'city' => 'required',
                'status' => 'required',
                //'address' => 'required',
                // 'website' => 'required',



            ]);
            $user = new User();
            $user->name = $request->name;
            $user->dealershipName = $request->dealershipName;
            $user->number = $request->number;
            $user->email = $request->email;
            $user->password = bcrypt($request->name);
            $dealer = User::where('role', 1)->where('dealershipName', $request->dealershipName)->first();
            if ($dealer) {
                $user->dealer_id = $dealer->id;
                $user->package = $dealer->package;
                $user->role = 2;
            } else {
                $user->role = 2;
            }
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

            $user->province = $dealer->province;
            $user->city = $dealer->city;
            $user->status = $request->status;

            $user->ads_count = $dealer->ads_count;
            $user->package = $dealer->package;
            $user->free_package_availed = $dealer->free_package_availed;

            $user->address = $dealer->address;
            $user->website = $dealer->website;
            $user->allow_company = $dealer->allow_company == "on" ? 1 : 0;
            $user->bulk_import = $dealer->bulk_import == "on" ? 1 : 0;
            $user->user_management = $dealer->user_management == "on" ? 1 : 0;

            //dd($user);
            $user->save();
            // return response()->json(['success' => true]);
            return redirect()->back()->with('success', 'User added successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error');
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
        // $request->merge(['number' => "+92" . $request->number]);

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string',
        //     'email' => 'required|email|unique:users',
        //     'number' => [
        //         'required',
        //         'string',
        //         'unique:users', // Ensures no duplicate phone numbers
        //         'regex:/[0-9]{10}/' // Validates only the 10-digit local number part
        //     ],
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->dealershipName = $request->dealershipName ?? '';
            $user->number = $request->number;
            $user->email = $request->email;

            // Update password only if provided
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            if (!$request->role_name) {
                $dealer = User::where('role', 1)->where('dealershipName', $request->dealershipName)->first();
                if ($dealer) {
                    $user->province = $dealer->province;
                    $user->city = $dealer->city;
                    $user->status = $request->status;
                    $user->ads_count = $dealer->ads_count;
                    $user->package = $dealer->package;
                    $user->free_package_availed = $dealer->free_package_availed;
                    $user->address = $dealer->address;
                    $user->website = $dealer->website;
                    $user->allow_company = $dealer->allow_company == "on" ? 1 : 0;
                    $user->bulk_import = $dealer->bulk_import == "on" ? 1 : 0;
                    $user->user_management = $dealer->user_management == "on" ? 1 : 0;
                } else {
                    return redirect()->back()->withErrors(['dealershipName' => 'Selected dealership not found.'])->withInput();
                }
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = date('His') . '_' . $file->getClientOriginalName();
                $file->move(public_path('web/profile'), $filename);

                if ($user->image && file_exists(public_path('web/profile/' . $user->image))) {
                    unlink(public_path('web/profile/' . $user->image));
                }

                $user->image = $filename;
            }

            $user->save();

            return redirect()->route('superadmin.users.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            Log::error('User update failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update user: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = User::find($request->deleted_id);
        $user->delete();
        $shop = Shops::where('dealer_id', $request->deleted_id)->first();
        if ($shop) {
            ShopServices::where('shop_id', $shop->id)->delete();
            ShopImages::where('shop_id', $shop->id)->delete();
            ShopTimings::where('shop_id', $shop->id)->delete();
            ShopAmenities::where('shop_id', $shop->id)->delete();

            $booking_ids = Bookings::where('shop_id', $shop->id)->pluck('id')->toArray();
            if (count($booking_ids) > 0) {
                BookingServices::whereIn('booking_id', $booking_ids)->delete();
                Bookings::whereIn('id', $booking_ids)->delete();
            }
            $shop->delete();
        }

        return redirect()->back()->with('danger', 'Data Deleted Successfully');
    }
}
