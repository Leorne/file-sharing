<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileStatusTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function only_auth_user_can_edit_status()
    {
        $this->postJson('/profiles/1/status')
            ->assertStatus(401);
    }

    /** @test */
    function a_user_may_edit_status_profile()
    {
        $this->withExceptionHandling();

        $this->signIn();
        $user = auth()->user();

        $status = 'All fine!';

        $this->postJson("profiles/{$user->id}/status", [
            'status_message' => $status,
        ])->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status_message' => $status
        ]);
    }

    /** @test */
    function status_message_max_size()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $user = auth()->user();

        $status = 'This message longer than 20 symbols.';
        $this->postJson("profiles/{$user->id}/status", [
            'status_message' => $status,
        ])->assertStatus(422);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'status_message' => $status
        ]);
    }
}
