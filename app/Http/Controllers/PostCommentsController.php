<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentsController extends Controller
{

    public function store(Post $post)
    {

        request()->validate([
            'body' => 'required'
        ]);
        

        $post->comments()->create([  //$post->comments()->create() will automatically set the post_id
            'user_id' => request()->user()->id,
            'body' => request('body')
        ]);

        return back(); //redirect back to the page from which the request came
    }
}
