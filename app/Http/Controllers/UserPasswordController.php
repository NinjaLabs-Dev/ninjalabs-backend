<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current' => 'required',
            'new' => 'required|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/|min:12|different:current',
            'new_confirm' => 'required|same:new|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/|min:12|different:current'
        ]);

        if($validator->fails()) {
            return Response::json(array('error' => true, 'message' => $validator->errors()->first()), 403);
        }

        if(Hash::check($request->current, Auth::user()->password)) {
            $user = User::findOrFail(Auth::user()->id);
            $user->password = Hash::make($request->new_confirm);
            $user->save();

            return Response::json(array('success' => true, 'message' => 'Password Changed'));
        }

        return Response::json(array('error' => true, 'message' => 'Current password was invalid'), 403);
    }
}
