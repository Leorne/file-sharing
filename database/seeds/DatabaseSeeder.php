<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $files = factory('App\File', 20)->create();
        $files->each(function ($files) {
            factory('App\Reply', 10)->create(['file_id' => $files->id]);
        });
    }
}
