<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIFallback extends Controller
{
    public function index() {
        return response()->json([
            'error' => 404,
            'message' => 'This API route does not exist.'
        ]);
    }
}
