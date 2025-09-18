<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogsController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('superadmin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $blogs = Blog::latest()->get();
        return view('superadmin.blogs.create', compact('blogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'description' => 'nullable|string',
            'tags'        => 'nullable|string',
        ]);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
          'tags' => $request->tags ? implode(', ', explode(',', $request->tags)) : null,

        ];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('blogs'), $imageName);
            $data['image'] = 'blogs/' . $imageName;
        }

        Blog::create($data);

        return redirect()
            ->route('superadmin.blogs.index')
            ->with('success', 'Blog created successfully!');
    }


    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('superadmin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'description' => 'nullable|string',
            'tags'        => 'nullable|string',
        ]);

        $blog = Blog::findOrFail($id);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
      'tags' => $request->tags ? implode(', ', explode(',', $request->tags)) : null,

        ];

        if ($request->hasFile('image')) {
            // Remove old image if exists
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }

            // Upload new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('blogs'), $imageName);
            $data['image'] = 'blogs/' . $imageName;
        }

        $blog->update($data);

        return redirect()
            ->route('superadmin.blogs.index')
            ->with('success', 'Blog updated successfully!');
    }


    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->image && file_exists(public_path('storage/' . $blog->image))) {
            unlink(public_path('storage/' . $blog->image));
        }
        $blog->delete();

        return redirect()->route('superadmin.blogs.index')->with('success', 'Blog deleted successfully!');
    }
}
