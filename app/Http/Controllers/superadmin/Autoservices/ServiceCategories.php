<?php

namespace App\Http\Controllers\superadmin\Autoservices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AutoServices\BookingServices;
use Illuminate\Support\Facades\Storage;
use App\Models\AutoServices\ServiceCategories as ServiceCategoriesModel;
use App\Models\AutoServices\Services;
use App\Models\AutoServices\ShopServices;

class ServiceCategories extends Controller
{
    public function index()
    {
        $categories = ServiceCategoriesModel::paginate(25);
        return view('superadmin.autoservices.servicecategories.index', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:service_categories,name',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'app_icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $iconPath = $request->file('icon')->store('service_categories', 'public');
        $appIconPath = $request->file('app_icon')->store('service_categories/app_icons', 'public');

        $category = new ServiceCategoriesModel();
        $category->name = $request->category_name;
        $category->icon = $iconPath;
        $category->app_icon = $appIconPath;
        $category->save();

        return redirect()->back()->with('servicecategoryresponse', 'Category added successfully');
    }


    public function update(Request $request, $id)
    {
        $category = ServiceCategoriesModel::find($id);
        if (!$category) {
            return redirect()->back()->with('servicecategoryresponse', 'Category not found');
        }
        $request->validate([
            'category_name' => 'required|unique:service_categories,name,' . $id,
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'app_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        if ($request->hasFile('icon')) {
            if ($category->icon && Storage::disk('public')->exists(str_replace('storage/', '', $category->getRawOriginal('icon')))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $category->getRawOriginal('icon')));
            }
            $iconPath = $request->file('icon')->store('service_categories', 'public');
            $category->icon = $iconPath;
        }

        if ($request->hasFile('app_icon')) {
            if ($category->app_icon && Storage::disk('public')->exists(str_replace('storage/', '', $category->getRawOriginal('app_icon')))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $category->getRawOriginal('app_icon')));
            }
            $appiconPath = $request->file('app_icon')->store('service_categories/app_icons', 'public');
            $category->app_icon = $appiconPath;
        }
        $category->name = $request->category_name;
        $category->save();
        return redirect()->back()->with('servicecategoryresponse', 'Category updated successfully');
    }


    public function destroy(Request $request, $id)
    {
        $category = ServiceCategoriesModel::find($id);
        if (!$category) {
            return redirect()->back()->with('servicecategoryresponse', 'Category not found');
        }
        if ($category->icon && Storage::disk('public')->exists(str_replace('storage/', '', $category->getRawOriginal('icon')))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $category->getRawOriginal('icon')));
        }
        $category_ids = Services::where('category_id', $id)->pluck('id');
        if (count($category_ids) > 0) {
            $shop_services = ShopServices::whereIn('service_id', $category_ids)->pluck('id');

            BookingServices::whereIn('service_id', $shop_services)->delete();
            ShopServices::whereIn('id', $shop_services)->delete();
            Services::whereIn('id', $category_ids)->delete();
        }
        $category->delete();
        return redirect()->back()->with('servicecategoryresponse', 'Category deleted successfully');
    }
}
