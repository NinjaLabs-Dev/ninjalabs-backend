<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class APITokenController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index() {
        $tokens = ApiToken::where('user_id', Auth::user()->id)->get();

        return Response::json($tokens->makeHidden('token'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'token' => 'required|min:20|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'
        ]);

        if($validator->fails()) {
            return Response::json(array('error' => true, 'message' => $validator->errors()->first()), 403);
        }

        $token = new ApiToken;
        $token->user_id = Auth::user()->id;
        $token->token = Hash::make($request->token);
        $token->save();

        return Response::json(array('success' => true, 'message' => 'Token saved'));
    }

    public function destroy($id) {
        $token = ApiToken::where('id', $id)->where('user_id', Auth::user()->id)->first();
        $token->delete();

        return Response::json(array('success' => true, 'message' => 'Token deleted.'));
    }
}
