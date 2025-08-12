<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Superadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageAdminsController extends Controller
{

    public function index()
    {
        $users = Superadmin::where('role', 2)->get();
        return view('superadmin.admins.index', compact('users'));
    }


    public function create()
    {
        return view('superadmin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:superadmins,email',
            'number' => 'required|string|unique:superadmins,number',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Superadmin::create([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'password' => bcrypt($request->password),
            'role' => '2',
        ]);

        return redirect()->route('superadmin.admins.index')->with('success', 'Admin user created successfully.');
    }
}
