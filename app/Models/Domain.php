<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    public function user() {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function errorfile() {
        return $this->hasMany(ErrorFile::class, 'id');
    }
}
