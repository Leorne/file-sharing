<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileListTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function user_may_filter_files_by_uncommented()
    {
        $fileUncommented = create('App\File');

        $fileCommented = create('App\File');
        $reply = create('App\Reply', ['file_id' => $fileCommented->id]);

        $response = $this->getJson('/list/get/files?uncommented=1')->json();

        $this->assertCount(1, $response['data']);
    }

    /** @test */
    function a_user_may_get_paginated_files_list()
    {
        $file = factory('App\File',21)->create();
        $response = $this->getJson('/list/get/files')->json();
        $this->assertCount(20,$response['data']);
    }

}
