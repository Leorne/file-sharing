<?php


namespace App\Filters;

use App\Favorite;
use App\User;
use Illuminate\Http\Request;

class FileFilters extends Filter
{
    protected $filters = ['by', 'comments', 'uncommented', 'favorited', 'searching', 'favorable'];

    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    public function comments()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }

    public function uncommented()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->where('replies_count', 0);
    }

    public function favorited()
    {
        if(auth()->check()){
            $favoritesFiles = Favorite::where(['user_id' => auth()->id(), 'favorited_type' => 'App\File'])->get();
            $filesId = [];
            foreach ($favoritesFiles as $file) {
                $filesId[] = $file->favorited_id;
            }
            return $this->builder->whereIn('id', $filesId);
        }
    }

    public function searching($searchString){
        return $this->builder->where('name', 'like', "%{$searchString}%");
    }

    public function favorable(){
        $this->builder->getQuery()->orders = [];
        return $this->builder->OrderBy('favorites_count', 'desc');
    }
}
