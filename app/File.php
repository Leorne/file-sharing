<?php

namespace App;

use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use Favorable, RecordsActivity;

    protected $guarded = [];

    protected $casts = [
      'additional_data' => 'array'
    ];
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

    public function setAdditionalDataAttribute($additionalData)
    {
        $this->additional_data = json_encode($additionalData);
    }

    public function formatSize()
    {
        return FileHelper::getFormatSize($this->size);
    }

    public function extensionImage(){
        return FileHelper::extensionImagePath($this->extension);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
