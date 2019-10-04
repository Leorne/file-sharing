<?php

namespace Tests\Unit;


use App\Helpers\FileHelper;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class getIdTest extends TestCase{
    use DatabaseMigrations;

    /** @test*/
    public function getid3_test(){
        $file = UploadedFile::fake()->image('newfile.jpg');

        $info = FileHelper::getFileInfo($file);
        dd($info);
    }
}
