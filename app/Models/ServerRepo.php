<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerRepo extends Model
{

    protected $fillable = [
        'server_id', 'name', 'branch', 'secret'
    ];

    protected $hidden = [
        'secret'
    ];

    public function server() {
        return $this->belongsTo(Server::class);
    }
}
