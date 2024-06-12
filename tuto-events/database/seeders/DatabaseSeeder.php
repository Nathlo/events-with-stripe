<?php

namespace Database\Seeders;

use App\Models\Tag;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $tags = Tag::factory(8)->create();

       User::factory(10)->create()->each(function ($user) use ($tags) {
            Event::factory(rand(2, 5))->create([
                'user_id' => $user->id
            ])->each(function ($event) use ($tags) {
                $event->tags()->attach($tags->random(3));
            });
        });

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
