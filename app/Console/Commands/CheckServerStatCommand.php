<?php

namespace App\Console\Commands;

use App\Models\Server;
use App\Models\ServerStat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckServerStatCommand extends Command
{
    protected $signature = 'server:check';

    protected $description = 'Check stats of servers';

    public function handle()
    {
        $servers = Server::all();

        foreach ($servers as $server) {
            $info = Http::acceptJson()->withHeaders([
                'authorization' => $server->token
            ])->timeout(10)->get($this->generateApiUrl($server));

            if($info->failed()) {
                $stat = new ServerStat;
                $stat->server_id = $server->id;
                $stat->down = true;
                $stat->save();

                return true;
            }

            $info = $info->json();

            $stat = new ServerStat;
            $stat->server_id = $server->id;
            $stat->cpu = $info["data"]["cpu"];
            $stat->memory_total = $info["data"]["mem"]["totalMemMb"];
            $stat->memory_used = $info["data"]["mem"]["usedMemMb"];
            $stat->network_in = $info["data"]["net"]["inputMb"];
            $stat->network_out = $info["data"]["net"]["outputMb"];
            $stat->used_storage = $info["data"]["disk"]["usedGb"];
            $stat->total_storage = $info["data"]["disk"]["totalGb"];
            $stat->ssh_connections = $info["data"]["ssh"];
            $stat->uptime = $info["data"]["uptime"];
            $stat->save();

            return true;

        }

        return true;
    }

    private function generateApiUrl($server) {
        return 'http://' . $server->url . '/server-management/system/status';
    }
}
