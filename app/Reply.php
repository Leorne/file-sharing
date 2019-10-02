<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner'];

    protected static function boot()
    {
        parent::boot();

        static::created(function($reply){
            $reply->file->increment('replies_count');
        });

        static::deleted(function($reply){
            $reply->file->decrement('replies_count');
        });

    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function path()
    {
        return $this->file->path() . "#reply-{$this->id}";
    }
}
