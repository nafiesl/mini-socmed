<?php

namespace Tests\Feature\Controllers\Auth;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function new_user_can_register()
    {
        $this->get(url('register'));

        $response = $this->post(route('register'), [
            'name'                  => 'Nama Member',
            'email'                 => 'email@mail.com',
            'password'              => 'password.111',
            'password_confirmation' => 'password.111',
        ]);

        $response->assertRedirect(route('home'));

        $this->assertDatabaseHas('users', [
            'name'  => 'Nama Member',
            'email' => 'email@mail.com',
        ]);

        $user = User::first();
        $this->assertNotNull($user->api_token);
    }
}
