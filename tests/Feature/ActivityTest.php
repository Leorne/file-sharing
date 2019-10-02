<?php


namespace Tests\Feature;

use App\Activity as Activity;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function records_activity_when_file_is_uploaded()
    {
        $this->signIn();

        $file = create('App\File', ['user_id' => auth()->id()]);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_file',
            'user_id' => auth()->id(),
            'subject_id' => $file->id,
            'subject_type' => 'App\File'
            ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $file->id);
    }

    /** @test */
    public function record_activity_when_reply_is_created(){
        $this->signIn();

        $reply = create('App\Reply');
        $this->assertEquals(2, Activity::count());
    }


}
