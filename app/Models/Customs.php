<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customs extends Model
{

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function image() {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
