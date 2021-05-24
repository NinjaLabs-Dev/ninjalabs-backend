<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorFile extends Model
{
    public function domain() {
        return $this->belongsTo(Domain::class, 'domain_id');
    }
}
