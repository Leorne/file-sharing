<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    public function favorited()
    {
        return $this->morphTo();
    }
}
//return Favorite::where(['user_id' => $this->id, 'favorited_type' => 'App\File'])->get();

