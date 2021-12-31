<?php

namespace App\Http\Controllers;

use App\Models\Image;

class FireworkController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        Image::findOrFail(8645)->increment('views');

        return view('pages.fireworks');
    }
}
