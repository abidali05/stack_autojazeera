<?php

namespace App\Http\Controllers\Autoservices;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceUserController extends Controller
{
    public function index(){

        $users = User::where('role', 3)->where('dealer_id', auth()->user()->id)->paginate(25);
        return view('user.serviceusers.index', compact('users'));
    }

    public function store(Request $request)
{
    // Clean PhoneNumber: keep + at start, remove all other non-digits
    $cleanPhone = preg_replace('/(?!^\+)\D/', '', $request->PhoneNumber);
    $request->merge(['PhoneNumber' => $cleanPhone]);

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'PhoneNumber' => 'required|unique:users,number',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->number = $request->PhoneNumber; // cleaned
    $user->password = bcrypt($request->PhoneNumber);
    $user->role = 3;
    $user->dealer_id = auth()->user()->id;
    $user->save();

    return redirect()->back()->with('success', 'Service user created successfully.');
}


  public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Clean PhoneNumber: keep + at start, remove all other non-digits
    $cleanPhone = preg_replace('/(?!^\+)\D/', '', $request->PhoneNumber);
    $request->merge(['PhoneNumber' => $cleanPhone]);

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'PhoneNumber' => 'required|unique:users,number,' . $user->id,
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->number = $request->PhoneNumber; // cleaned
    $user->status = $request->status;
    $user->save();

    return redirect()->back()->with('success', 'Service user updated successfully.');
}


    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('success', 'Service user deleted successfully.');
    }
}
