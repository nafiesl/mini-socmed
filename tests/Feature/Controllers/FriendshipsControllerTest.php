<?php

namespace Tests\Feature\Controllers;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Notification;
use Tests\TestCase;

class FriendshipsControllerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_check_their_friend_status_to_other()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $response = $this->get(route('friendships.check', [$user1->id, $user2->id]));
        $response->assertStatus(200);
        $response->assertExactJson(['status' => 0]);

        $user1->request($user2);
        $response = $this->get(route('friendships.check', [$user1->id, $user2->id]));
        $response->assertStatus(200);
        $response->assertExactJson(['status' => 'waiting']);

        $response = $this->get(route('friendships.check', [$user2->id, $user1->id]));
        $response->assertStatus(200);
        $response->assertExactJson(['status' => 'pending']);

        $user2->accept($user1);
        $response = $this->get(route('friendships.check', [$user1->id, $user2->id]));
        $response->assertStatus(200);
        $response->assertExactJson(['status' => 'friends']);
    }

    /** @test */
    public function user_can_make_frend_a_request()
    {
        Notification::fake();
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $response = $this->post(route('friendships.request', [$user2->id, $user1->id]));
        $response->assertStatus(201);
        $response->assertExactJson(['status' => 'waiting']);

        Notification::assertSentTo(
            [$user1], 'App\Notifications\Friendships\NewRequest'
        );

        $this->assertDatabaseHas('friendships', [
            'requester_id' => $user2->id,
            'requested_id' => $user1->id,
            'approved' => 0,
        ]);
    }

    /** @test */
    public function user_can_accept_friend_request()
    {
        Notification::fake();
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $user1->request($user2);

        $response = $this->post(route('friendships.accept', [$user2->id, $user1->id]));
        $response->assertStatus(200);
        $response->assertExactJson(['status' => 'friends']);

        $this->assertDatabaseHas('friendships', [
            'requester_id' => $user1->id,
            'requested_id' => $user2->id,
            'approved' => 1,
        ]);

        Notification::assertSentTo(
            [$user1], 'App\Notifications\Friendships\AcceptRequest'
        );
    }

    /** @test */
    public function user_can_delete_friendship_with_other()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $user1->request($user2);
        $user2->accept($user1);

        $response = $this->post(route('friendships.remove', [$user2->id, $user1->id]));
        $response->assertStatus(200);
        $response->assertExactJson(['status' => 0]);

        $this->assertDatabaseMissing('friendships', [
            'requester_id' => $user1->id,
            'requested_id' => $user2->id,
        ]);
    }
}
