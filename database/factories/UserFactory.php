<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Helpers\FileHelper;
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
    $user = factory('App\User')->create();
    $tmpFile = $faker->image($dir  = null,$width = 640, $height = 480, $category = null, $fullPath = false);
//    $filesize = filesize('/tmp/'.$tmpFile);
    $file = new UploadedFile("/tmp/{$tmpFile}", $tmpFile);
    $helper = new FileHelper($file, $user->id);
    $data = $helper->getData();
    return $data;
});


$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'file_id' => function () {
            return factory('App\File')->create()->id;
        },
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph
    ];
});
