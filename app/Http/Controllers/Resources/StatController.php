<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;

use App\Models\Server;
use App\Models\ServerStat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        $stats = ServerStat::where('created_at', '>', Carbon::now()->subHour())->get()->filter(function ($stat) {
            return $stat->uptime <= 3600 ||
                $stat->cpu >= 80 ||
                round(($stat->memory_used / $stat->memory_total) * 100, 2) >= 75 ||
                round(($stat->used_storage / $stat->total_storage) * 100, 2) >= 75;
        });

        $servers = [];
        foreach ($stats as $stat) {
            $server = Server::findOrFail($stat->server_id);
            $servers[] = $server->name;
        }

        return $servers;
    }
}
