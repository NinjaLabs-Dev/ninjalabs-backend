<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

use App\Models\Server;
use App\Models\ServerStat;
use Illuminate\Http\Request;

class ServerStatsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:server stats']);
    }

    public function index(Request $request)
    {
        $servers = Server::with(['repos'])->get();

        foreach ($servers as $server) {
            $stat = ServerStat::where('server_id', $server->id)->orderBy('created_at', 'desc')->get();

            if ($stat->isEmpty()) {
                $stat["ssh_connections"] = 0;
                $stat["uptime"] = 0;
            }

            $server["stat"] = $stat->first();
        }

        return view('pages.server-stats.index')->with('servers', $servers);
    }
}
