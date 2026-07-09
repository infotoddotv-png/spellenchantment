<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts        = BlogPost::orderByDesc('published_at')->get();
        $featuredPost = $posts->firstWhere('featured', true) ?? $posts->first();
        $regularPosts = $posts->filter(fn($p) => $p->id !== $featuredPost?->id)->values();

        return view('pages.blog.index', compact('posts', 'featuredPost', 'regularPosts'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        return view('pages.blog.show', compact('post'));
    }
}
