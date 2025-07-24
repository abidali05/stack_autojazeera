<?php

namespace App\Http\Controllers\Bikes\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Bike\BikeMainFeatures;
use Illuminate\Http\Request;

class BikeMainFeaturesController extends Controller
{
    public function index(Request $request)
    {
        if($request->feature_id)
        {
            $features=BikeMainFeatures::where('id',$request->feature_id)->get();
        }
        else{
            $features=BikeMainFeatures::orderby('id','desc')->get();
        }
     
        return view('bikes.superadmin.bike_main_features.index',compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.features.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $feature=new BikeMainFeatures();
        $feature->category=$request->featureType;
        $feature->name=$request->featureName;
        if($request->file('icon'))
        {
            $file=$request->file('icon');
            $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
            $file->move(public_path('posts/features/bikes/'), $filename);
            $feature->icon = $filename;
        }
        $feature->status=$request->status=='on'?1:0;
        $feature->save();
        return redirect()->back()->with('success','feature store successfully');

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
        $feature=BikeMainFeatures::find($id);
        $feature->category=$request->featureType;
        $feature->name=$request->featureName;
        if($request->file('icon'))
        {
            $file=$request->file('icon');
            $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
            $file->move(public_path('posts/features/bikes/'), $filename);
            $feature->icon = $filename;
        }
        $feature->status=$request->status=='on'?1:0;
        $feature->update();
        return redirect()->back()->with('success','feature update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        $user=BikeMainFeatures::find($request->deleted_id);
        $user->delete();
        return redirect()->back()->with('danger','Feature Deleted Successfully');
    }
}
