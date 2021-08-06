<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerStat extends Model
{
    protected $fillable = [
        'server_id', 'cpu', 'memory_total', 'memory_used', 'network_in', 'network_out', 'total_storage', 'used_storage', 'ssh_connections', 'uptime'
    ];

    public function server() {
        return $this->belongsTo(Server::class);
    }
}
