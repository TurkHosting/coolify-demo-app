<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        // Create categories
        $categories = Category::factory()->count(5)->create();

        // Create blog posts for admin user
        Post::factory()
            ->count(15)
            ->recycle($admin)
            ->create()
            ->each(function (Post $post) use ($categories) {
                // Attach 1-3 random categories to each post
                $post->categories()->attach(
                    $categories->random(rand(1, 3))->pluck('id')
                );
            });
    }
}
