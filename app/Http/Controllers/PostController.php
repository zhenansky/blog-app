<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Post::with('user');

        // Sorting
        if ($request->filled('sort') && $request->sort === 'oldest') {
            $query->oldest();
        } else {
            $query->latest(); // default
        }

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->paginate(10)->withQueryString();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Auth::user()->posts()->create([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return redirect()->route('posts.index')->with('success', 'Postingan berhasil dibuat.');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post->update($request->only('title', 'content'));

        return redirect()->route('posts.index')->with('success', 'Berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Berhasil dihapus.');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'comments.replies.user']);
        return view('posts.show', compact('post'));
    }


}
