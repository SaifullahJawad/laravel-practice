<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Services\Newsletter;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use League\CommonMark\Extension\FrontMatter\Data\LibYamlFrontMatterParser;
use Spatie\YamlFrontMatter\YamlFrontMatter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {

    
//     //$files = File::files(resource_path('posts'));


//     //Use array_map as we are looping over an array to return a different array
//     /* $posts = array_map(function ($file) {

//         $documents = YamlFrontMatter::parseFile($file);

//         return new Post(
//             $documents->title,
//             $documents->excerpt,
//             $documents->date,
//             $documents->slug,
//             $documents->body()
//         );
        
//     }, $files);
//  */

//     //we can also use collection
//     /* $posts = collect($files)->map(
//         function ($file) {
//             $documents = YamlFrontMatter::parseFile($file);

//             return new Post(
//                 $documents->title,
//                 $documents->excerpt,
//                 $documents->date,
//                 $documents->slug,
//                 $documents->body()
//             );
//         }
//     );

//     return view('posts', [
//         'posts' => $posts
//     ]); */

//     //DB::select('select * from posts, categories where posts.category_id = categories.id');


//     //You can either manually Eager Load category and author
//     //return view('posts', ['posts' => Post::latest()->with(['category', 'author'])->get()]); 

//     //Or you Eager Load by default by setting up the $with attribute in model
//     /* return view('posts', [
//         'posts' => Post::latest()->get(),
//         'categories' => Category::all()
//     ]); */
//     //you can also disable Eager Loading by without() method once the with() method is set up in the model

    
    
// })->name('home'); //name route is a way to reference an uri without writing the uri itself

Route::get('/', [PostController::class, 'index'])->name('home');

// Route::get('posts/{post}', function ($slug) { //wildcards

//     /* $path = __DIR__ . "/../resources/posts/{$slug}.html";

//     if(!file_exists($path))
//     {
//         return redirect('/');
//         //abort(404);
//     }

//     //$post = file_get_contents($path); file system gets accessed everytime the page is requested
//     //caching can solve the problem

//     $post = cache()->remember("posts/{$slug}", 5, fn() => file_get_contents($path) ); //arrow fucntion has access to all the variables from the scope in which it was created

//     return view('post', ['post' => $post]); */


//     //cleaner way
//     //Find a post by its slug and pass it to a view called "post"

//     return view('post', ['post' => Post::find($slug)]);
// })->where('post', '[A-z-]+'); //route constraints


/* Route::get('posts/{post}', function ($slug) {

    return view('post', ['post' => Post::findOrFail($slug)]);
}); */

/* Route::get('posts/{post}', function ($id){

    return view('post', ['post' => Post::findOrFail($id)]);
}); */



//route model binding

//the wildcard name and variable in the parameter should match up
//by default the route-model-binding works by finding the id of the model
/* Route::get('posts/{post}', function (Post $post){

    return view('post', ['post' => $post]);
}); */

//but you can override it by mentioning the field name with a colon
//you can also achieve the same by defining a fucntion named getRouteKeyName() in the model
//if you have to bind the model with lots of routes, it's always better to use the function
/* Route::get('posts/{post:slug}', function (Post $post){  //equivalent to Post::where('slug', $post)->firstOrFail();

    return view('post', ['post' => $post]);
}); */

Route::get('posts/{post:slug}', [PostController::class, 'show']);




/* Route::get('categories/{category:slug}', function (Category $category){

    //You can either manually Eager Load category and author
    //return view('posts', ['posts' => $category->posts->load(['category', 'author'])]); 

    //Or you can Eager Load by default by setting up the $with attribute in model
    return view('posts', [ 
        'posts' => $category->posts,
        'currentCategory' => $category,
        'categories' => Category::all()
    ]); 

})->name('category'); */

/* Route::get('authors/{author:username}', function (User $author){

    return view('posts.index', [ 
        'posts' => $author->posts
    ]);

}); */

Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);


Route::get('register', [RegisterController::class, 'create'])->middleware('guest'); //the middleware will redirect the logged in user to home
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class,'create'])->middleware('guest');
Route::post('login', [SessionsController::class,'store'])->middleware('guest');

Route::post('logout', [SessionsController::class,'destroy'])->middleware('auth');


//simple integration of an api
/* Route::post('newsletter', function() {
    request()->validate(['email' => 'required|email']);
    
    $mailchimp = new \MailchimpMarketing\ApiClient();

    $mailchimp->setConfig([
        'apiKey' => config('services.mailchimp.key'),
        'server' => 'us17'
    ]);

    try {
        $response = $mailchimp->lists->addListMember('3e8d1e1840', [
            'email_address' => request('email'),
            'status' => 'subscribed'
        ]);
    } catch (\Exception $e) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'This email could not be added to our newsletter list'
        ]);
    }

    
    return redirect('/')->with('success', 'You are now signed up for our newsletter');

}); */


//integrating api using a service
// Route::post('newsletter', function(Newsletter $newsletter) {
//     request()->validate(['email' => 'required|email']);
    

//     try {

// /*         $newsletter = new Newsletter();
//         $newsletter->subscribe(request('email'));
//         //we can also combine the previous two lines as (new Newsletter())->subscribe(request('email'));
//  */
//         $newsletter->subscribe(request('email'));

//     } catch (\Exception $e) {
//         throw ValidationException::withMessages([
//             'email' => 'This email could not be added to our newsletter list'
//         ]);
//     }

    
//     return redirect('/')->with('success', 'You are now signed up for our newsletter');

// });

Route::post('newsletter', NewsletterController::class); //Single action controller is the controller which offers only a single action; When we don't provide an array of controller and action name, it will automatically call the invoke method in the controller


Route::get('admin/posts/create', [AdminPostController::class, 'create'])->middleware('admin');
Route::post('admin/posts', [AdminPostController::class, 'store'])->middleware('admin');
Route::get('admin/posts', [AdminPostController::class, 'index'])->middleware('admin');
Route::get('admin/posts/{post}/edit', [AdminPostController::class, 'edit'])->middleware('admin');
Route::patch('admin/posts/{post}', [AdminPostController::class, 'update'])->middleware('admin');
Route::delete('admin/posts/{post}', [AdminPostController::class, 'destroy'])->middleware('admin');




