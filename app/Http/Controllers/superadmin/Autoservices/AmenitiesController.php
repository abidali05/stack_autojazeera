<?php

namespace App\Http\Controllers\superadmin\Autoservices;

use App\Http\Controllers\Controller;
use App\Models\AutoServices\Amenities;
use App\Models\AutoServices\ShopAmenities;
use Illuminate\Http\Request;


class AmenitiesController extends Controller
{
    public function index()
    {
        $amenities = Amenities::paginate(25);
        return view('superadmin.autoservices.amenities.index', compact('amenities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:amenities,name',
        ]);

        $amenity = new Amenities();
        $amenity->name = $request->name;
        $amenity->save();
        return redirect()->route('superadmin.amenities.index')->with('amenityresponse', 'Amenity created successfully.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:amenities,name,' . $id,
        ]);

        $amenity = Amenities::findOrFail($id);
        if(!$amenity) {
            return redirect()->route('superadmin.amenities.index')->with('amenityresponse', 'Amenity not found.');
        }
        $amenity->name = $request->name;
        $amenity->save();
        return redirect()->route('superadmin.amenities.index')->with('amenityresponse', 'Amenity updated successfully.');
    }

    public function destroy($id)
    {
        $amenity = Amenities::findOrFail($id);
        if(!$amenity) {
            return redirect()->route('superadmin.amenities.index')->with('amenityresponse', 'Amenity not found.');
        }
        ShopAmenities::where('amenity_id', $id)->delete();
        $amenity->delete();
        return redirect()->route('superadmin.amenities.index')->with('amenityresponse', 'Amenity deleted successfully.');
    }
}
