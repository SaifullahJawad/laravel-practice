<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class Post
{
    public $title;
    public $excerpt;
    public $date;
    public $slug;
    public $body;


    public function __construct($title, $excerpt, $date, $slug, $body)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->slug = $slug;
        $this->body = $body;
    }

    public static function all()
    {
        /* $files = File::files(resource_path("posts/"));
        return array_map(fn ($file) => $file->getContents(), $files); */


        return cache()->rememberForever('posts/all', function () {
            return collect(File::files(resource_path("posts/")))
                ->map(fn ($file) => YamlFrontMatter::parseFile($file))
                ->map(fn ($document) => new Post(
                    $document->title,
                    $document->excerpt,
                    $document->date,
                    $document->slug,
                    $document->body()
                ))
                ->sortByDesc('date');
        });
    }

    public static function find($slug)
    {
        /* $path = resource_path("posts/{$slug}.html");

        if (!file_exists($path))
            throw new ModelNotFoundException();

        return cache()->remember("posts/{$slug}", 20, fn () => file_get_contents($path)); //arrow fucntion has access to all the variables from the scope in which it was created
 */

        
        return static::all()->firstWhere('slug', $slug);

    }


    public static function findOrFail($slug)
    {

        $post = static::find($slug);

         /* if (is_null($post))
            //abort(404);
            throw new ModelNotFoundException(); */

            if( !$post)
                throw new ModelNotFoundException();
                
        return $post;

    }
}
