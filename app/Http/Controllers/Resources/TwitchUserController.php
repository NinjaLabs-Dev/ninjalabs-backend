<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Http\Resources\TwitchUserResource;
use App\Models\TwitchUser;
use Illuminate\Http\Request;

class TwitchUserController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    public function index() {
        return TwitchUserResource::collection(TwitchUser::all());
    }
}
