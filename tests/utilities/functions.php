<?php
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile as UploadedFile;

function create($class, $attribute = []){
    return factory($class)->create($attribute);
}

function make($class, $attribute = []){
    return factory($class)->make($attribute);
}

function raw($class, $attribute = []){
    return factory($class)->raw($attribute);
}

