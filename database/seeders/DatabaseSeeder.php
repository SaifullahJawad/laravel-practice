<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //if you don't refresh your database(e.x. migrate:fresh), use truncate to avoid duplication.
        //Otherwise it will just add same data to the existing data creating duplication
        
        Schema::disableForeignKeyConstraints(); //if there is any foreign key contraints, you need to disable it. Otherwise, you won't be able to truncate the tables

        User::truncate();
        Post::truncate();
        Category::truncate();

        Schema::enableForeignKeyConstraints();
        /* $user = User::factory()->create();

        //seed manually without factory
        $personal = Category::create([ //the data persists with create method
            'name' => 'Personal',
            'slug' => 'personal'
        ]);

        $family = Category::create([
            'name' => 'Family',
            'slug' => 'family'
        ]);

        $work = Category::create([
            'name' => 'Work',
            'slug' => 'work'
        ]);

        Post::create([
            'user_id' => $user->id,
            'category_id' => $family->id,
            'title' => 'My Family Post',
            'slug' => 'my-family-post',
            'excerpt' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>',
            'body' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ut purus at eros dictum aliquam. Curabitur euismod lectus ac libero bibendum aliquet. In sit amet dapibus lectus. Sed tincidunt ligula sed erat tempus imperdiet. Duis imperdiet et arcu a porttitor. Morbi tellus nulla, imperdiet vel euismod a, sollicitudin a augue. Nullam malesuada volutpat sapien ac posuere. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin gravida ornare turpis sit amet tristique.</p>'
        ]);

        Post::create([
            'user_id' => $user->id,
            'category_id' => $work->id,
            'title' => 'My Work Post',
            'slug' => 'my-work-post',
            'excerpt' => '<p>Vivamus dui tellus, scelerisque eget risus a, bibendum finibus arcu.</p>',
            'body' => '<p>Vivamus dui tellus, scelerisque eget risus a, bibendum finibus arcu. Interdum et malesuada fames ac ante ipsum primis in faucibus. Duis nisi sapien, faucibus sit amet fringilla vel, ornare bibendum nisi. Maecenas interdum, justo nec efficitur consequat, diam sapien tempus nisi, eu iaculis eros metus ut arcu. Nullam cursus tortor dui, nec tempor tortor eleifend sit amet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam sit amet ligula nisi. Sed auctor consectetur mauris vitae vehicula. Aenean in arcu accumsan, aliquet tortor sed, scelerisque neque. Aenean ipsum augue, fermentum bibendum erat mollis, auctor sodales velit.</p>'
        ]); */


        //seed with factory
        Post::factory(5)->create();

        //in case you don't want to seed all the data with fake data
        /* $user = User::factory()->create([
            'name' => 'John Doe' //All the other field except the name will have fake data
        ]);

        Post::factory(5)->create([
            'user_id' => $user->id //override the user_id that is being created at the PostFactory
        ]); */


    }
}
