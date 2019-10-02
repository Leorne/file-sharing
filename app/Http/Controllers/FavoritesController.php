<?php

namespace App\Http\Controllers;

use App\Favorite;
use Illuminate\Http\Request;
use App\File;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(File $file)
    {
        $file->favorite();

        return back();
    }

    public function destroy(File $file)
    {
        $file->unfavorite();
    }
}
