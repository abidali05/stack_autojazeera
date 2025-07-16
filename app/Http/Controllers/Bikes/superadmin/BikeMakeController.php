<?php

namespace App\Http\Controllers\Bikes\superadmin;

use App\Exports\MakeBikeExport;
use Illuminate\Http\Request;
use App\Models\Bike\BikeMake;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Imports\MakeBikeImport;
use Maatwebsite\Excel\Facades\Excel;

class BikeMakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bike_makes = BikeMake::paginate(25);
        return view('bikes.superadmin.make.index', compact('bike_makes'));
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
        // dd($request->all());
        $make = new BikeMake();
        $make->name = $request->name;

        if ($request->file('icon')) {
            $file = $request->file('icon');
            $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
            $file->move(public_path('posts/makes/bikes/'), $filename);
            $make->icon = $filename;
        }
        $make->status = $request->status == 'on' ? 1 : 0;
        $make->save();
        return redirect()->back()->with('success', 'Make stored successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(BikeMake $bikeMake)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BikeMake $bikeMake)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $make = BikeMake::find($id);
        $make->name = $request->name;
        if ($request->file('icon')) {
            $file = $request->file('icon');
            $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
            $file->move(public_path('posts/makes/bikes/'), $filename);
            $make->icon = $filename;
        }

        $make->status = $request->status == 'on' ? 1 : 0;
        $make->update();
        return redirect()->back()->with('warning', 'Make update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $make = BikeMake::find($request->deleted_id);
        $make->delete();
        return redirect()->back()->with('danger', 'Make Deleted Successfully');
    }

    public function export()
    {
        try {
            Log::info('Starting export of MakeCompany data');
            return Excel::download(new MakeBikeExport, 'bike_make_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
        } catch (\Exception $e) {
            Log::error('Export failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('superadmin.ads.index')->with('error', 'Failed to export make companies: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        try {
            Excel::import(new MakeBikeImport, $request->file('excel_file'));
            return redirect()->route('superadmin.bike-make.index')->with('success', 'bike-make companies imported successfully.');
        } catch (\Exception $e) {
            Log::error('Import failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('superadmin.make.index')->with('error', 'Error importing make companies: ' . $e->getMessage());
        }
    }
}
