<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Superadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

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
            'number' => 'required|string|unique:superadmins,number|regex:/^\+92 3\d{2} \d{7}$/',
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

    public function edit(string $id)
    {
        $user = Superadmin::findOrFail($id);
        if ($user->role != 2) {
            return redirect()->route('superadmin.admins.index')->withErrors(['error' => 'Invalid admin user.']);
        }
        return view('superadmin.admins.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $user = Superadmin::findOrFail($id);
            if ($user->role != 2) {
                return redirect()->route('superadmin.admins.index')->withErrors(['error' => 'Invalid admin user.']);
            }

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:superadmins,email,' . $id,
                'number' => 'required|string|regex:/^\+92 3\d{2} \d{7}$/|unique:superadmins,number,' . $id,
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->number = $request->number;

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            return redirect()->route('superadmin.admins.index')->with('success', 'Admin user updated successfully.');
        } catch (\Exception $e) {
            Log::error('Admin update failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update admin: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = Superadmin::findOrFail($id);
            if ($user->role != 2) {
                return redirect()->route('superadmin.admins.index')->withErrors(['error' => 'Invalid admin user.']);
            }

            $user->delete();
            return redirect()->route('superadmin.admins.index')->with('success', 'Admin user deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Admin deletion failed: ' . $e->getMessage());
            return redirect()->route('superadmin.admins.index')->withErrors(['error' => 'Failed to delete admin: ' . $e->getMessage()]);
        }
    }
}