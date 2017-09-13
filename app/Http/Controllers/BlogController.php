<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with('categories', 'photo', 'user')->latest()->orderBy('updated_at', 'desc')->get();
        return response()->json([
            'posts' => $posts
        ]);
    }

    public function show($id)
    {
        $blog = Post::with('comments','comments.user','comments.user.photo','categories', 'photo', 'user')->findOrfail($id);
        return response()->json([
            'post' => $blog
        ]);
    }
}
