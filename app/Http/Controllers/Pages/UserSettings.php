<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserSettings extends Controller
{
    public function index()
    {
        $api_tokens = ApiToken::query()
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('pages.user.settings.index')
            ->with('api_tokens', $api_tokens);
    }
}
