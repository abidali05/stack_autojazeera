<?php

namespace App\Http\Controllers\superadmin\Autoservices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AutoServices\Bookings;
use App\Models\AutoServices\Services;
use Illuminate\Support\Facades\Storage;
use App\Models\AutoServices\ShopServices;
use App\Models\AutoServices\BookingServices;
use App\Models\AutoServices\ServiceCategories;


class ServicesController extends Controller
{
    public function index()
    {
        $services = Services::paginate(25);
        $categories =  ServiceCategories::all();
        return view('superadmin.autoservices.services.index', compact('services', 'categories'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|unique:services,name',
            'category_id' => 'required|exists:service_categories,id',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $iconPath = $request->file('icon')->store('services', 'public');
        $service = new Services();
        $service->name = $request->name;
        $service->category_id = $request->category_id;
        $service->icon = $iconPath;
        $service->save();
        return redirect()->back()->with('serviceresponse', 'Service added successfully');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:services,name,' . $id,
            'category_id' => 'required|exists:service_categories,id',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $service = Services::findOrFail($id);
        if (!$service) {
            return redirect()->back()->with('serviceresponse', 'Service not found');
        }
        $service->name = $request->name;
        $service->category_id = $request->category_id;
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($request->hasFile('icon')) {
                if ($service->icon && Storage::disk('public')->exists(str_replace('storage/', '', $service->getRawOriginal('icon')))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $service->getRawOriginal('icon')));
                }
            }
            $iconPath = $request->file('icon')->store('services', 'public');
            $service->icon = $iconPath;
        }
        $service->save();
        return redirect()->back()->with('serviceresponse', 'Service updated successfully');
    }


    public function destroy($id)
    {
        $service = Services::findOrFail($id);

        // Get the actual stored path (not the accessor's URL)
        $iconPath = $service->getRawOriginal('icon');

        if ($iconPath && Storage::disk('public')->exists($iconPath)) {
            Storage::disk('public')->delete($iconPath);
        }

        $ShopServices = ShopServices::where('service_id', $id)->pluck('id')->toArray();
        if (count($ShopServices) > 0) {
            $ids =   BookingServices::whereIn('service_id', $ShopServices)->pluck('booking_id')->toArray();
            BookingServices::whereIn('service_id', $ShopServices)->delete();
            if (count($ids) > 0) {
                foreach ($ids as $id) {
                    $booking = Bookings::findOrFail($id);
                    $services  = BookingServices::where('booking_id', $id)->get();
                    if (count($services) == 0) {
                        $booking->delete();
                    } else {
                        continue;
                    }
                }
            }
        }

        $service->delete();

        return redirect()->back()->with('serviceresponse', 'Service deleted successfully');
    }
}
