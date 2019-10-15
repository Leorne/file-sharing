<?php

namespace Tests\Feature;


use App\Notifications\ConfirmEmailNotification;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_confirmation_email_is_sent_upon_registration()
    {
        \Notification::fake();
        $user = create('App\User', ['email_verified_at' => null]);
        event(new Registered($user));
        \Notification::assertSentTo($user, ConfirmEmailNotification::class);
    }

    /** @test */
    function user_can_verify_his_email()
    {
        $this->post('/register', [
            'name' => 'Testuser',
            'email' => 'foobar@mail.com',
            'password' => 'passwordBar',
            'password_confirmation' => 'passwordBar'
        ]);
        $user = User::find(1);

        $this->assertNull($user->email_verify_at);
        $this->assertNotNull($user->email_verify_token);

        //Verify email
        $this->get('register/confirm?token='. $user->email_verify_token);

//        $this->assertNotNull($user->fresh()->email_verify_at);
    }
}
