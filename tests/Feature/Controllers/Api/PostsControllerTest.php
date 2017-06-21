<?php

namespace Tests\Feature\Controllers\Api;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PostsControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_fetch_posts_feed()
    {
        $user = factory(User::class)->create();
        $posts1 = factory(Post::class, 2)->create(['user_id' => $user->id]);
        $posts2 = factory(Post::class, 2)->create();

        $response = $this->getJson(route('api.posts.index'), [
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => [
                'user_id',
                'content',
                'user' => [
                    'name',
                    'email'
                ],
            ]
        ]);

        $this->assertCount(2, json_decode($response->getContent()));
    }

    /** @test */
    public function user_can_create_a_post()
    {
        $user = factory(User::class)->create();

        $response = $this->postJson(route('api.posts.store'), ['content' => '1123'], [
            'Authorization' => 'Bearer ' . $user->api_token
        ]);
        $response->assertStatus(201);

        $this->assertDatabaseHas('posts', [
            'content' => '1123',
            'user_id' => $user->id,
        ]);
    }
}
