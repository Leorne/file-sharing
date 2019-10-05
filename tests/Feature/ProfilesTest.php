<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;
    /** @test*/
    function user_has_a_profile(){
        $user = create('App\User');

        $this->get('/profiles/'.$user->id)
            ->assertSee($user->name);
    }

}
