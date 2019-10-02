<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use Favorable, RecordsActivity;

    protected $guarded = [];

    protected $withCount = ['favorites'];
    protected $with = ['uploader'];
    protected $appends = ['isFavorited'];
    //
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($file){
            $file->replies->each->delete();
        });
    }

    public function path()
    {
        return '/main/list/' . $this->id;
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFilePath()
    {
        return $this->path;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)
            ->with('owner');
    }


    public function getFormatFileSize()
    {
        $bytes = $this->size;
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $i = 0;
        while ($bytes >= 1024) {
            $bytes /= 1024;
            $i++;
        }
        $i = (count($units) < $i) ? 4 : $i;
        $formatSize = round($bytes, 2) . ' ' . $units[$i];
        return $formatSize;
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
