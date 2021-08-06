<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;

use App\Http\Resources\ServerStatsResource;
use App\Models\Server;
use App\Models\ServerStat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ServerStatsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:server stats']);
    }

    public function index($server_id) {
        $server = Server::findOrFail($server_id)->serverStats();

        $stats = [
            'cpu' => [],
            'ram' => [],
            'network_in' => [],
            'network_out' => [],
            'storage' => []
        ];

        $time = [];

        foreach ($server as $stat) {

            if(!$stat->down) {
                $stats["cpu"][] = round($stat->cpu, 2);
                $stats["ram"][] = round(($stat->memory_used / $stat->memory_total) * 100, 2);
                $stats["network_in"][] = (int)$stat->network_in;
                $stats["network_out"][] = (int)$stat->network_out;
            } else {
                $stats["cpu"][] = 0;
                $stats["ram"][] = 0;
                $stats["network_in"][] = 0;
                $stats["network_out"][] = 0;
            }

            $time[] = Carbon::parse($stat->created_at)->format('d/m/y H:i');
        }

        $storage = ServerStat::where('server_id', $server_id)->where('down', false)->orderBy('created_at', 'desc')->get();

        if($storage->isEmpty()) {
            $stats["storage"] = 0;
        } else {
            $storage = $storage->first();
            $stats["storage"] = [round(($storage->used_storage / $storage->total_storage) * 100, 2)];
        }

        return [
            'stats' => $stats,
            'time' => $time,
        ];
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'ip' => 'required|ip',
            'url' => 'required|string',
            'token' => 'required|string|min:10'
        ]);

        if($validator->fails()) {
            return Response::json(array('error' => true, 'message' => $validator->errors()->first()));
        }

        $server = new Server;
        $server->name = $request->name;
        $server->ip = $request->ip;
        $server->url = $request->url;
        $server->token = $request->token;
        $server->save();

        return Response::json(array('success' => true, 'message' => 'Created server'));
    }
}
