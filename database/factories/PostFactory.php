<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            
            'user_id' => User::factory(), //automatically creates a random user and assigns its id into user_id
            'category_id' => Category::factory(),//same functinality as user factory
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'excerpt' => '<p>' . implode( '</p><p>', $this->faker->paragraphs(2) ) . '</p>',
            'body' => '<p>' . implode( '</p><p>', $this->faker->paragraphs(6) ) . '</p>'
        ];
    }
}
