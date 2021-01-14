<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    public function index() {
        return view('pages.login');
    }

//    Login POST request
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if( Auth::attempt(['name' => $request->username, 'password' => $request->password], true)) {
                return Redirect::route('dashboard');
        } else {
            return Redirect::back()->withErrors(['message', 'No user was found with that name!']);
        }
    }
}
