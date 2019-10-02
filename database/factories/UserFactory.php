<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Illuminate\Http\UploadedFile as UploadedFile;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});


$factory->define(App\File::class, function (Faker $faker) {
    try {
        $user = factory('App\User')->create();
        $tmpFile = $faker->image($dir = null, $width = 640, $height = 480, $category = null, $fullPath = false);
        $file = new UploadedFile("/tmp/{$tmpFile}", $tmpFile);
        if (!$file->getError()) {
            $userId = $user->id;
            $mime = $file->getClientMimeType();
            $name = $file->getClientOriginalName();
            $size = $file->getSize();
            $extension = $file->extension();
            $file->store("/public/uploads/{$userId}");
            $path = "uploads/{$userId}/{$file->hashName()}";
            return [
                'user_id' => $userId,
                'name' => $name,
                'path' => $path,
                'size' => $size,
                'mime' => $mime,
                'extension' => $extension
            ];
        } else {
            throw new Exception('RETURN NULL');
        }
    } catch (Exception $e) {
        echo($e);
    }
});


//$files->each(function($files){ factory('App\Reply',10)->create(['file_id' => $files->id]); });
$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'file_id' => function(){
            return factory('App\File')->create()->id;
        },
        'user_id' => function(){
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph
    ];
});
