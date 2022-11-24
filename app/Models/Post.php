<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //protected $fillable = ['title', 'excerpt', 'body']; //only the mentioned fields can be assigned during mass assignment
    //protected $guarded = ['title']; //every other field can be assigned except the mentioned field
    //protected $guarded = []; //lets you mass assign; you can also mass assign application wide by setting up the unguard() method in AppServiceProvider

    //will return the key name by which you want to find the post
    /* public function getRouteKeyName()
    {
        return 'slug';
    } */

    //making Eager Loading a defalt setting
    protected $with = ['category', 'author']; //it will fetch associated category and author along with the post


    //query scopes helps build complex query; it takes already built up query as an argument and adds additional queries
    //Inside the name of the fucntion, first add the text "scope" and then follow it up with a function name of your choice 
    //call the function by the name written after the text "scope"
    public function scopeFilter($query, array $filters)      
    {
        
        /* if($filters['search'] ?? false)
        {
            $query->where('title', 'like', '%' . request('search') . '%')
            ->orWhere('body', 'like', '%' . request('search') . '%');
        } */

        //             ^
        //             |

        //        similar to
        
        //             ^
        //             |

        /* $query->when( $filters['search'] ?? false, fn ($query, $search) => 
            $query
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%')
        );  //if confused, checkout the defination of "when" function
        */

        $query->when( $filters['search'] ?? false, fn ($query, $search) => 
            $query->where(fn($query) =>
                $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%')
            )
        );

        // $query->when( $filters['category'] ?? false, fn ($query, $category) => 
        //     $query
        //         ->whereExists(fn($query) =>
        //             $query->from('categories')
        //                 ->whereColumn('categories.id', 'posts.category_id')
        //                 ->where('categories.slug', $category))  //SELECT * FROM posts WHERE EXISTS(SELECT * FROM categories WHERE categories.id = posts.category_id AND categories.slug = $category)
        // );

        //      ^
        //      |
        //
        //    smiler to
        //
        //      ^
        //      |

        $query->when( $filters['category'] ?? false, fn ($query, $category) => 
            $query
                ->whereHas('category', fn($query) =>
                    $query->where('slug', $category)) //Post, give me the posts where they have a category spicifically where the category slug matches what the user requested in the browser
        );


        $query->when( $filters['author'] ?? false, fn ($query, $author) => 
            $query
                ->whereHas('author', fn($query) =>
                    $query->where('username', $author))
        );

        
    }

    //setting up relationships with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()   //make the realtionship as "this post belongs to author" instead of "this post belongs to user", just to make it sound better
    {
        return $this->belongsTo(User::class, 'user_id'); //stricktly mention the name of the foreign key here as laravel is going to assume the foreign key name is "author_id" because of the function name
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }



}
