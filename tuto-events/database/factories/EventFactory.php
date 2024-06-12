<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(rand(2,6));

        return [
            'title' => $title,
            'slug' =>  Str::slug($title),
            'content' =>  $this->faker->sentence(rand(4, 10)),
            'premium' =>  $this->faker->boolean(25),
            'starts_at' =>  $this->faker->dateTimeBetween('now', '+2 months'),
            'ends_at' =>  $this->faker->dateTimeBetween('+3 months', '+4 months'),
        ];
    }
}
