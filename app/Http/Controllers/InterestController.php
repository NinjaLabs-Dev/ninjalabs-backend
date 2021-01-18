<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InterestController extends Controller
{
    public function store(Request $request) {
        Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'extra_storage' => 'required'
        ]);

        return $request->all();
    }
}
