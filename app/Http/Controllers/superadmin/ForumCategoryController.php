<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\ForumCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForumCategoryController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::withCount('threads')->get();
        return view('superadmin.forum.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('superadmin.forum.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        ForumCategory::create($request->all());
        return redirect()->route('superadmin.forum-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = ForumCategory::findOrFail($id);
        return view('superadmin.forum.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        $category = ForumCategory::findOrFail($id);
        $category->update($request->all());
        
        return redirect()->route('superadmin.forum-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = ForumCategory::findOrFail($id);
        $category->delete();
        
        return redirect()->route('superadmin.forum-categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}