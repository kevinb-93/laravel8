<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->confirmRefreshDatabase();
        $this->call([UsersTableSeeder::class, BlogPostsTableSeeder::class, CommentsTableSeeder::class]);
    }

    public function confirmRefreshDatabase()
    {
        if ($this->command->confirm('Refresh database?', true)) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');
        }
    }

    public function runSeeder()
    {
        $doe = User::factory()->johnDoe()->create();
        $users = User::factory(10)->create();

        $users = $users->concat([$doe]);

        $posts = BlogPost::factory(50)->make()->each(function ($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();
        });

        $comments = Comment::factory(150)->make()->each(function ($comment) use ($posts) {
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        });
    }
}
