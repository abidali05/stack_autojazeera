<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumPost;
use App\Models\ForumLike;
use App\Models\ForumFavorite;
use App\Models\ForumImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::withCount('threads')
            ->with(['latestThreads' => function ($q) {
                $q->latest()->take(4);
            }, 'latestThreads.user'])
            ->get();

        return view('forum.index', compact('categories'));
    }

    public function category($id)
    {
        $category = ForumCategory::findOrFail($id);
        $threads = ForumThread::where('category_id', $id)
            ->with(['user', 'latestPost.user'])
            ->withCount('posts')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('forum.category', compact('category', 'threads'));
    }

    public function thread($id)
    {
        $thread = ForumThread::with('category', 'user')->findOrFail($id);

        $thread->incrementViews();

        $posts = ForumPost::where('thread_id', $id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('forum.thread', compact('thread', 'posts'));
    }


    public function storeThread(Request $request, $categoryId)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $thread = ForumThread::create([
            'category_id' => $categoryId,
            'user_id' => Auth::id(),
            'title' => $request->title,
        ]);

        ForumPost::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return redirect()->route('forum.thread', $thread->id);
    }

    public function storeReply(Request $request, $threadId)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $thread = ForumThread::findOrFail($threadId);

        if ($thread->is_locked) {
            return back()->with('error', 'This thread is locked.');
        }

        ForumPost::create([
            'thread_id' => $threadId,
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
            'body' => $request->body,
        ]);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Reply posted successfully.');
    }

    public function deletePost($id)
    {
        $post = ForumPost::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();
        return back()->with('success', 'Post deleted successfully.');
    }

    // Toggle like for thread or post
    public function toggleLike(Request $request)
    {
        $type = $request->type; // 'thread' or 'post'
        $id = $request->id;

        $model = $type === 'thread' ? ForumThread::findOrFail($id) : ForumPost::findOrFail($id);
        $modelClass = get_class($model);

        $like = ForumLike::where([
            'user_id' => Auth::id(),
            'likeable_type' => $modelClass,
            'likeable_id' => $id
        ])->first();

        if ($like) {
            $like->delete();
            $model->decrement('likes_count');
            $liked = false;
        } else {
            ForumLike::create([
                'user_id' => Auth::id(),
                'likeable_type' => $modelClass,
                'likeable_id' => $id
            ]);
            $model->increment('likes_count');
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $model->fresh()->likes_count
        ]);
    }

    // Toggle favorite for thread
    public function toggleFavorite(Request $request)
    {
        $threadId = $request->thread_id;

        $favorite = ForumFavorite::where([
            'user_id' => Auth::id(),
            'thread_id' => $threadId
        ])->first();

        if ($favorite) {
            $favorite->delete();
            $favorited = false;
        } else {
            ForumFavorite::create([
                'user_id' => Auth::id(),
                'thread_id' => $threadId
            ]);
            $favorited = true;
        }

        return response()->json(['favorited' => $favorited]);
    }

    // User's favorites
    public function favorites()
    {
        $favorites = ForumFavorite::where('user_id', Auth::id())
            ->with(['thread.category', 'thread.user'])
            ->latest()
            ->paginate(20);

        return view('forum.favorites', compact('favorites'));
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originalName = $request->file('upload')->getClientOriginalName();

            $filename = pathinfo($originalName, PATHINFO_FILENAME);

            $extension = $request->file('upload')->getClientOriginalExtension();

            $filename = $filename . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('images/test'), $filename);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');

            $url = asset('images/test/' . $filename);

            $msg = 'Image uploaded successfully.';

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg');</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
