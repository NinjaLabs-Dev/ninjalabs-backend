<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $fillable = [
        'name', 'token'
    ];

    public function serverStats() {
        $ids = ServerStat::where('server_id', $this->id)->orderBy('created_at', 'desc')->get(['id'])->take(60);

        return ServerStat::whereIn('id', $ids)->orderBy('created_at', 'asc')->get();
    }

    public function stats() {
        return $this->hasMany(ServerStat::class, 'server_id');
    }

    public function repos() {
        return $this->hasMany(ServerRepo::class, 'server_id');
    }
}
