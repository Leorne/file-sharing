<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guest_may_not_to_add_reply()
    {
        $reply = make('App\Reply');

        $this->post('/list/1/reply', ['body' => $reply->body])->assertRedirect('login');
    }

    /** @test */
    function auth_user_may_add_reply()
    {
        $this->signIn();

        $reply = make('App\Reply');

        $this->post('/list/1/reply', ['body' => $reply->body]);
        $this->assertDatabaseHas('replies', [
            'file_id' => 1,
            'body' => $reply->body,
            'user_id' => auth()->id()
        ]);
    }

    /** @test */
    function user_without_participate_may_not_delete_reply()
    {
        $reply = create('App\Reply');
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn();
        $this->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    function user_with_participate_may_delete_reply()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete('/replies/' . $reply->id)->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    function user_without_participate_may_not_edit_reply()
    {
        $reply = create('App\Reply');
        $newReplyBody = 'U been changed.';

        $this->patch("/replies/{$reply->id}", ['body' => $newReplyBody])
            ->assertRedirect('/login');


        $this->signIn();
        $this->patch("/replies/{$reply->id}", ['body' => $newReplyBody])
            ->assertStatus(403);
    }

    /** @test */
    function user_with_participate_may_edit_reply()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $newReplyBody = 'U been changed.';
        $this->patch('/replies/' . $reply->id, ['body' => $newReplyBody]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $newReplyBody]);
    }


    /** @test */
    function a_user_can_request_all_replies_for_a_given_file_page(){
        $file = create('App\File');
        $replies = factory('App\Reply',5)->create(['file_id' => $file->id]);

        $response = $this->getJson($file->path().'/reply')->json();
//        dd($response);
        $this->assertCount(5, $response['data']);
        $this->assertEquals(5, $response['total']);


    }
}
