<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNoBlogPosts()
    {
        $response = $this->get('/posts');
        $response->assertSeeText('No posts found');
    }

    public function testCreatedBlogPostIsVisible(){
        // arrange
        $this->createDummyBlogPost();

        // act
        $response = $this->get('/posts');

        // assert
        $response->assertSeeText('New title');
        $response->assertSeeText('No comments yet!');
        $this->assertDatabaseHas('blog_posts', ['title' => 'New title']);
    }

    public function testSeeBlogPostWithComments() {
        // arrange
        $post = $this->createDummyBlogPost();
        Comment::factory()->count(4)->create([
            'blog_post_id' => $post->id
        ]);

        // act
        $response = $this->get('/posts');

        $response->assertSeeText('4 comments');
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        $this->post('/posts', $params)->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function testStoreFail() 
    {
        $params = [
            'title' => 'x',
            'content' => 'At'
        ];

        $this->post('/posts', $params)->assertStatus(302)->assertSessionHas('errors');
        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', ['title' => 'New title']);

        $params = [
            'title' => 'new Valid title',
            'content' => 'content changed'
        ];

        $this->put("/posts/{$post->id}", $params)->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'), 'The blog post was updated!');
        $this->assertDatabaseMissing('blog_posts', ['title' => 'New title']);
        $this->assertDatabaseHas('blog_posts', ['title' => 'new Valid title']);

    }

    public function testDelete() 
    {
        $post = $this->createDummyBlogPost();
        $this->assertDatabaseHas('blog_posts', ['title' => 'New title']);

        $this->delete("/posts/{$post->id}")->assertStatus(302)->assertSessionHas('status');
        $this->assertEquals(session('status'), 'Blog post was deleted!');
        $this->assertDatabaseMissing('blog_posts', ['title' => 'New title']);

    }

    private function createDummyBlogPost(): BlogPost
    {
        return BlogPost::factory()->newTitle()->create();
    }
}
