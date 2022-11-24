<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::paginate(50)
        ]);
    }

    public function create()
    {
        //moved the following logic to MustBeAdmin middleware
        /* if(auth()->guest())
        {
            abort(Response::HTTP_FORBIDDEN); //same as abort(403)
        }

        if(auth()->user()->username !== 'taledeus')
        {
            abort(Response::HTTP_FORBIDDEN);
        } */

        return view('admin.posts.create');
    }

    public function store()
    {


        $attributes = request()->validate([
            'title' => 'required',
            'thumbnail' => 'required|image',
            'slug' => ['required', Rule::unique('posts', 'slug')],
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')] //same as exists:catagories,id
        ]);


        $attributes['user_id'] = auth()->id();
        $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');

        Post::create($attributes);

        return redirect('/');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', ['post' => $post]);
    }

    public function update(Post $post)
    {
        $attributes = request()->validate([
            'title' => 'required',
            'thumbnail' => 'image',
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post->id)], //must be unique to all the other slug except the current slug
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')] //same as exists:catagories,id
        ]);

        if(isset($attributes['thumbnail']))
        {
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }


        $post->update($attributes);

        return back()->with('success', 'Post Updated!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('success', 'Post Deleted!');
    }
}
