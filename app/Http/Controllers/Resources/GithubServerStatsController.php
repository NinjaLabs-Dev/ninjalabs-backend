<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;

use App\Models\Server;
use App\Models\ServerRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class GithubServerStatsController extends Controller
{
    public function __construct()
    {
        //
    }

    public function store(Request $request, $server_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'branch' => 'required|string',
            'token' => 'required|string|min:8'
        ]);

        if($validator->fails()) {
            return Response::json(array('error' => true, 'message' => $validator->errors()->first()));
        }

        $server = Server::findOrFail($server_id);

        $repo = new ServerRepo;
        $repo->server_id = $server->id;
        $repo->name = $request->name;
        $repo->branch = $request->branch;
        $repo->secret = $request->token;
        $repo->save();

        return Response::json(array('success' => true, 'message' => 'Created repo tracking'));
    }

    public function destroy($server_id, $id) {
        $server = Server::findOrFail($server_id);
        $github = ServerRepo::findOrFail($id);

        $github->delete();
        return Response::json(array('success' => true, 'message' => 'Deleted repo tracking'));
    }
}
