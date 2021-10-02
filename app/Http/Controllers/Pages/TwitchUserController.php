<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\TwitchUser;
use Illuminate\Http\Request;

class TwitchUserController extends Controller
{
    public function index() {
        return view('pages.twitch.index');
    }
}
