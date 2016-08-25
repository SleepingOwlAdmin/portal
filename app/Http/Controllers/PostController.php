<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $this->meta->setMetaData($post);
        
        return view('post.show', compact('post'));
    }
}