<?php


namespace App;


trait Favorable
{
    protected static function bootFavorable()
    {
        static::deleting(function ($model){
            $model->favorites->each->delete();
        });
    }


    // Add to favorite
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);
        }
    }


    //
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }


    public function isFavorited()
    {
        return $this->favorites()->where(['user_id' => auth()->id()])->exists();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    //
    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];
        $this->favorites()->where($attributes)->get()->each->delete();
    }
}
