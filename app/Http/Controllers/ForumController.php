<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::withCount('threads')
            ->with('latestThread.user')
            ->get();
        
        return view('forum.index', compact('categories'));
    }

    // Show threads in a category
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

    // Show thread with posts
    public function thread($id)
    {
        $thread = ForumThread::with('category', 'user')->findOrFail($id);
        $posts = ForumPost::where('thread_id', $id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('forum.thread', compact('thread', 'posts'));
    }

    // Show create thread form
    public function createThread($categoryId)
    {
        $category = ForumCategory::findOrFail($categoryId);
        return view('forum.create-thread', compact('category'));
    }

    // Store new thread
    public function storeThread(Request $request, $categoryId)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|max:10000',
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

    // Store reply
    public function storeReply(Request $request, $threadId)
    {
        $request->validate([
            'body' => 'required|max:10000',
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

        return back()->with('success', 'Reply posted successfully.');
    }

    // Delete post
    public function deletePost($id)
    {
        $post = ForumPost::findOrFail($id);
        
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();
        return back()->with('success', 'Post deleted successfully.');
    }
}