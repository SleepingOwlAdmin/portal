<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        return view('post.show', compact('post'));
    }
}