<?php


namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAvatarTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function only_auth_user_can_add_avatars()
    {
        $this->postJson('/profiles/1/avatar')
            ->assertStatus(401);
    }

    /** @test */
    function a_valid_avatar_must_be_provided(){
        $this->signIn();

        $this->postJson('/profiles/' .auth()->id() .'/avatar', [
            'avatar' => 'not-an-image'
        ])->assertStatus(422);
    }

    /** @test */
    function a_user_may_add_avatar_to_profile()
    {
        $this->signIn();

        \Storage::fake('public');

        $avatar = UploadedFile::fake()->image('avatar.jpg');

        $this->postJson('/profiles/' .auth()->id() .'/avatar', [
            'avatar' => $avatar]);

        $this->assertEquals(asset('storage/avatars/'.$avatar->hashName()), auth()->user()->avatar_path);
        \Storage::disk('public')->assertExists('avatars/'. $avatar->hashName());
    }

}
