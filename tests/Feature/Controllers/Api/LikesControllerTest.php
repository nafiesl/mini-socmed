<?php

namespace Tests\Feature\Controllers\Api;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LikesControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_like_a_post()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->postJson(route('api.like', $post->id), [], [
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $this->assertTrue($user->liked($post));

        $response->assertStatus(201);

        $this->assertDatabaseHas('likes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function user_can_unlike_a_post()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $user->like($post);

        $response = $this->postJson(route('api.like', $post->id), [], [
            'Authorization' => 'Bearer ' . $user->api_token
        ]);

        $response->assertStatus(204);

        $this->assertFalse($user->liked($post));

        $this->assertDatabaseMissing('likes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
    }
}
