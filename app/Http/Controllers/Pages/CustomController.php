<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Customs;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomController extends Controller
{
    public function index() {
        $images = Image::query()
            ->where('owner_id', Auth::user()->id)
            ->get();

        return view('pages.customs.index')
            ->with('images', $images);
    }
}
