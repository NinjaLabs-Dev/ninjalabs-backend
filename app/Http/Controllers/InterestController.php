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
            'email' => 'required|email',
            'extra_storage' => 'required'
        ]);

        return $validator;

        if($validator->errors()) {
            return response()->json($validator->errors()->toArray(), 500);
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
