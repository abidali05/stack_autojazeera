<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\Bike\BikeBodyTypes;
use App\Models\BodyType;
use Illuminate\Http\Request;

class SuperadminBodyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->bodytype_id) {
            $bodytypes = BodyType::orderby('id', 'desc')->where('id', $request->bodytype_id)->get();
        } else {
            $bodytypes = BodyType::orderby('id', 'desc')->get();
        }
        
        
        if ($request->bikebodytype_id) {
            $bikebodytypes = BikeBodyTypes::orderby('id', 'desc')->where('id', $request->bikebodytype_id)->get();
        } else {
            $bikebodytypes = BikeBodyTypes::orderby('id', 'desc')->get();
        }

        return view('superadmin.bodytype.index', compact('bodytypes','bikebodytypes'));
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
        $bodytype = new BodyType();

        $bodytype->name = $request->name;
        if ($request->file('icon')) {
            $file = $request->file('icon');
            $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
            $file->move(public_path('posts/bodytypes/'), $filename);
            $bodytype->icon = $filename;
        }

        $bodytype->status = $request->status == 'on' ? 1 : 0;
        $bodytype->save();
        return redirect()->back()->with('success', 'bodytype store successfully');
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
        // dd($request->all());
        $bodytype = BodyType::find($id);
        // $bodytype->make_id = $request->make;
        $bodytype->name = $request->name;
        if ($request->file('icon')) {
            $file = $request->file('icon');
            $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
            $file->move(public_path('posts/bodytypes/'), $filename);
            $bodytype->icon = $filename;
        }

        $bodytype->status = $request->status == 'on' ? 1 : 0;
        $bodytype->update();
        return redirect()->back()->with('warning', 'bodytype update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $bodytype = BodyType::find($request->deleted_id);
        $bodytype->delete();
        return redirect()->back()->with('danger', 'bodytype Deleted Successfully');
    }
}
