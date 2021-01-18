<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InterestController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $entry = new Interest();
        $entry->name = $request->name;
        $entry->email = $request->email;
        $entry->extra_storage = $request->extra_storage;
        $entry->save();


        return response()->json([
            'code' => 200,
            'message' => 'Response submitted'
        ], 200);
    }
}
