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
}
