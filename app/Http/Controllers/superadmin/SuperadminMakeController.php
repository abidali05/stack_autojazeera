<?php

namespace App\Http\Controllers\superadmin;

use App\Exports\MakeExport;
use App\Imports\MakeImport;
use App\Models\MakeCompany;
use App\Imports\PostsImport;
use Illuminate\Http\Request;
use App\Models\Bike\BikeMake;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class SuperadminMakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->make_id)
        {
          $makes = MakeCompany::orderby('id', 'desc')->where('id',$request->make_id)->paginate(25);
        }
        else{
        $makes = MakeCompany::orderby('id', 'desc')->paginate(25);
        }
        
        if($request->bikemake_id)
        {
          $bikemakes = BikeMake::orderby('id', 'desc')->where('id',$request->bikemake_id)->paginate(25);
        }
        else{
        $bikemakes = BikeMake::orderby('id', 'desc')->paginate(25);
        }
        return view('superadmin.Make.index', compact('makes','bikemakes'));
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
        $make = new MakeCompany();
        $make->name = $request->name;
        
        if ($request->file('icon')) {
            $file = $request->file('icon');
            $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
            $file->move(public_path('posts/makes/'), $filename);
            $make->icon = $filename;
        }
        $make->status = $request->status == 'on' ? 1 : 0;
        $make->save();
        return redirect()->back()->with('success', 'Make store successfully');
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
        $make =MakeCompany::find($id);
        $make->name = $request->name;
        if ($request->file('icon')) {
            $file = $request->file('icon');
            $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
            $file->move(public_path('posts/makes/'), $filename);
            $make->icon = $filename;
        }
 
        $make->status = $request->status == 'on' ? 1 : 0;
        $make->update();
        return redirect()->back()->with('warning', 'Make update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        $make=MakeCompany::find($request->deleted_id);
        $make->delete();
        return redirect()->back()->with('danger','Make Deleted Successfully');
    }

    public function export()
    {
        try {
            Log::info('Starting export of MakeCompany data');
            return Excel::download(new MakeExport, 'make_companies_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
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
            Excel::import(new MakeImport, $request->file('excel_file'));
            return redirect()->route('superadmin.make.index')->with('success', 'Make companies imported successfully.');
        } catch (\Exception $e) {
            Log::error('Import failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('superadmin.make.index')->with('error', 'Error importing make companies: ' . $e->getMessage());
        }
    }
}

