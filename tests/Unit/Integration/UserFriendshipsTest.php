<?php

namespace Tests\Unit\Integration;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserFriendshipsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_add_other_as_friend()
    {
        $users = factory(User::class, 2)->create();
        $users[0]->addFriend($users[1]);

        $this->assertTrue($users[0]->hasRequestedAsFriend($users[1]));
    }

    /** @test */
    public function user_has_requested_friend_request_list()
    {
        $users = factory(User::class, 2)->create();
        $users[0]->addFriend($users[1]);

        $this->assertCount(1, $users[1]->pendingFriendRequests());
    }

    /** @test */
    public function user_has_sent_friend_requests_list()
    {
        $users = factory(User::class, 3)->create();
        $users[0]->addFriend($users[1]);
        $users[0]->addFriend($users[2]);

        $this->assertCount(2, $users[0]->sentFriendRequests());
    }

    /** @test */
    public function user_can_accept_other_friend_request()
    {
        $users = factory(User::class, 2)->create();
        $users[0]->addFriend($users[1]);

        $users[1]->acceptFriend($users[0]);

        $this->assertTrue($users[0]->isFriendWith($users[1]));
        $this->assertTrue($users[1]->isFriendWith($users[0]));
    }

    /** @test */
    public function user_can_see_friend_list()
    {
        $users = factory(User::class, 3)->create();
        $users[0]->addFriend($users[1]);
        $users[2]->addFriend($users[0]);
        $users[1]->acceptFriend($users[0]);
        $users[0]->acceptFriend($users[2]);

        $this->assertTrue($users[0]->isFriendWith($users[1]));
        $this->assertTrue($users[1]->isFriendWith($users[0]));
        $this->assertTrue($users[0]->isFriendWith($users[2]));
        $this->assertTrue($users[2]->isFriendWith($users[0]));

        $this->assertCount(2, $users[0]->friends());
        $this->assertCount(1, $users[1]->friends());
        $this->assertCount(1, $users[2]->friends());
    }
}
