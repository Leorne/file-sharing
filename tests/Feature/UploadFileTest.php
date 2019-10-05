<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadFileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_to_upload_file()
    {
        $this->post('/upload')->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_upload_file()
    {
        $this->signIn();
        \Storage::fake('public');
        $this->postJson('/upload', ['file' => $file = UploadedFile::fake()->image('testImage.jpg')]);
        \Storage::disk('public')->assertExists('uploads/' . \Auth::user()->id . '/' . $file->hashName());

        $this->get('/list')
            ->assertSee($file->name);
    }

    /** @test */
    function a_file_can_be_deleted()
    {
        $this->signIn();
        $file = create('App\File', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['file_id' => $file->id]);

        $this->deleteJson($file->path())->assertStatus(204);

        $this->assertDatabaseMissing('files', [
            'id' => $file->id
        ]);
        $this->assertDatabaseMissing('replies', [
            'id' => $reply->id
        ]);
    }


    /** @test */
    function a_file_may_be_delete_by_only_who_have_permission()
    {
        $file = create('App\File');

        $this->delete($file->path())->assertRedirect('/login');

        $this->signIn();
        $file = create('App\File');

        $this->deleteJson($file->path())->assertStatus(403);
    }
}
