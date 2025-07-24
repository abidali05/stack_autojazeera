<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class SuperadminColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->color_id)
        {
            $colors = Color::orderby('id', 'desc')->where('id',$request->color_id)->get();
        }
        else{
            $colors = Color::orderby('id', 'desc')->get();
        }
       
        return view('superadmin.colors.index', compact('colors'));
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
        $color = new Color();
        $color->name = $request->name;
        $color->color_id = $request->code;
        // if ($request->file('icon')) {
        //     $file = $request->file('icon');
        //     $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
        //     $file->move(public_path('posts/colors/'), $filename);
        //     $color->icon = $filename;
        // }
        $color->status = $request->status == 'on' ? 1 : 0;
        $color->save();
        return redirect()->back()->with('success', 'color store successfully');
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
        $color =Color::find($id);
        $color->name = $request->name;
        $color->color_id = $request->code;
 
        $color->status = $request->status == 'on' ? 1 : 0;
        $color->update();
        return redirect()->back()->with('warning', 'color update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        $color=Color::find($request->deleted_id);
        $color->delete();
        return redirect()->back()->with('danger','Color Deleted Successfully');
    }
}
