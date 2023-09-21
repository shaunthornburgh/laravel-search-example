<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchPostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_search_for_posts()
    {
        // Given: We have three posts in the database
        $post1 = Post::factory()->create(['title' => 'First Post']);
        $post2 = Post::factory()->create(['title' => 'Second Post']);
        $post3 = Post::factory()->create(['title' => 'Third unrelated']);

        // When: We hit the search endpoint with the query "Post"
        $response = $this->postJson('/api/post/search', [
            'title' => 'Post'
        ]);

        // Then: We should see the first two posts in the results
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => $post1->title]);
        $response->assertJsonFragment(['title' => $post2->title]);
        $response->assertJsonMissing(['title' => $post3->title]);
    }
}
