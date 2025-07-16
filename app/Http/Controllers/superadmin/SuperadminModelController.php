<?php

namespace App\Http\Controllers\superadmin;

use App\Models\BodyType;
use App\Models\MakeCompany;
use App\Models\ModelCompany;
use Illuminate\Http\Request;
use App\Models\Bike\BikeMake;
use App\Models\Bike\BikeBodyTypes;
use App\Http\Controllers\Controller;
use App\Models\Bike\BikeModels;

class SuperadminModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $makes=MakeCompany::where('status',1)->get();
        $bodytypes=BodyType::where('status',1)->get();
        if($request->model_id)
        {
          $models = ModelCompany::orderby('id', 'desc')->where('id',$request->model_id)->paginate(25);
        }
        else{
        $models = ModelCompany::orderby('id', 'desc')->paginate(25);
        }
        $bikemakes = BikeMake::where('status',1)->get();
        $bikebodytypes = BikeBodyTypes::where('status',1)->get();
        if($request->bikemodel_id)
        {
          $bikemodels = BikeModels::orderby('id', 'desc')->where('id',$request->bikemodel_id)->paginate(25);
        }
        else{
        $bikemodels = BikeModels::orderby('id', 'desc')->paginate(25);
        }

        return view('superadmin.Model.index', compact('models','bodytypes','makes','bikemakes','bikebodytypes','bikemodels'));
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
        $model = new ModelCompany();
        $model->name = $request->name;
        $model->make_id = $request->make;
        $model->bodytype = $request->bodytype;

        $model->status = $request->status == 'on' ? 1 : 0;
        $model->save();
        return redirect()->back()->with('success', 'model store successfully');
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
        $model =ModelCompany::find($id);
        $model->name = $request->name;
        $model->make_id = $request->make;
        $model->bodytype = $request->bodytype;
 
        $model->status = $request->status == 'on' ? 1 : 0;
        $model->update();
        return redirect()->back()->with('warning', 'model update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        $model=ModelCompany::find($request->deleted_id);
        $model->delete();
        return redirect()->back()->with('danger','model Deleted Successfully');
    }
}
