<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    
    public function index()
    {


        /* return view('posts.index', [
            'posts' => Post::latest()->filter(request(['search', 'category', 'author']))->get() //The query scope funtion filter() is placed with an arrow after the query builder. The query builder will then be passed as its argument. the get() function is for executing the built-up query
        ]); */

        return view('posts.index', [
            'posts' => Post::latest()->filter(
                request(['search', 'category', 'author'])
            )->paginate(6)->withQueryString() //withQueryString retains the query string that was there before clicking on the pagination
        ]);
    }


    public function show(Post $post)
    {

        return view('posts.show', ['post' => $post]);
    }

}



//7 restful actions are as follows: index, show, create, store, edit, update, destroy