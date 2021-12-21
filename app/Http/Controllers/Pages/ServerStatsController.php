<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

use App\Models\Server;
use App\Models\ServerStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServerStatsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:server stats']);
    }

    public function index(Request $request)
    {
        $servers = Server::with(['repos'])->get();

        return view('pages.server-stats.index')->with('servers', $servers);
    }

    public function show(Server $server) {
        return Cache::remember('server-stats-overview-' . $server->id, 900, function() use($server) {
            return self::getStats($server);
        });
    }

    private function getStats($server, $firstOnly = false) {
        $stat = ServerStat::where('server_id', $server->id)->orderBy('created_at', 'desc');

        if($firstOnly) {
            $stat = $stat->first();
        } else {
            $stat = $stat->get();
        }

        if ($stat->isEmpty()) {
            $stat["ssh_connections"] = 0;
            $stat["uptime"] = 0;
        }

        return $stat->first();
    }
}
