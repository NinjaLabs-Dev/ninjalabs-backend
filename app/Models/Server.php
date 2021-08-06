<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $fillable = [
        'name', 'token'
    ];

    public function serverStats() {
        return ServerStat::where('server_id', $this->id)->orderBy('created_at', 'desc')->get()->take(30);
    }

    public function stats() {
        return $this->hasMany(ServerStat::class, 'server_id');
    }

    public function repos() {
        return $this->hasMany(ServerRepo::class, 'server_id');
    }
}
