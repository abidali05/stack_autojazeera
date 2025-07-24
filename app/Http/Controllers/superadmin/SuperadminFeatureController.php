<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\Bike\BikeMainFeatures;
use App\Models\Feature;
use App\Models\MainFeature;
use Illuminate\Http\Request;

class SuperadminFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->feature_id)
        {
            $features=MainFeature::where('id',$request->feature_id)->get();
        }
        else{
            $features=MainFeature::orderby('id','desc')->get();
        }

        if($request->bikefeature_id)
        {
            $bikefeatures=BikeMainFeatures::where('id',$request->bikefeature_id)->get();
        }
        else{
            $bikefeatures=BikeMainFeatures::orderby('id','desc')->get();
        }
     
        return view('superadmin.features.index',compact('features','bikefeatures'));
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
        $feature=new MainFeature();
        $feature->feature=$request->featureType;
        $feature->sub_feature=$request->featureName;
        if($request->file('icon'))
        {
            $file=$request->file('icon');
            $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
            $file->move(public_path('posts/features/'), $filename);
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
        $feature=MainFeature::find($id);
        $feature->feature=$request->featureType;
        $feature->sub_feature=$request->featureName;
        if($request->file('icon'))
        {
            $file=$request->file('icon');
            $filename = date('His') . $file->getClientOriginalName(); // Ensure correct method name
            $file->move(public_path('posts/features/'), $filename);
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
        $user=MainFeature::find($request->deleted_id);
        $user->delete();
        return redirect()->back()->with('danger','Feature Deleted Successfully');
    }
}
