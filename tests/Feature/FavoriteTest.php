<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guest_may_not_favorute_anything()
    {
        $this->post('/list/1/favorites')
            ->assertRedirect('/login');
    }


    /** @test */
    function auth_user_can_favorite_file()
    {
        $this->signIn();
        $file = create('App\File');
        $this->post('/list/' . $file->id . '/favorites');
        $this->assertCount(1, $file->favorites);
    }

    /** @test */
    function user_can_favorite_once()
    {
        $this->signIn();
        $file = create('App\File');
        try{
            $this->post('/list/' . $file->id . '/favorites');
            $this->post('/list/' . $file->id . '/favorites');
        }catch (\Exception $e){
            $this->fail('Did not expect to insert same record twice');
        }

        $this->assertCount(1, $file->favorites);

    }

    /** @test */
    function user_can_unfavorite_file(){
        $this->signIn();
        $file = create('App\File');

        $file->favorite();
        $this->assertCount(1, $file->favorites);

        $this->delete('/list/' . $file->id . '/favorites');
        $this->assertCount(0, $file->fresh()->favorites);
    }

}
