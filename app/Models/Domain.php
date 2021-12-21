<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domain extends Model
{
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function errorFile(): HasMany {
        return $this->hasMany(ErrorFile::class, 'id');
    }

    public static function getDomainList() {
        return self::all()->map(function($domain) {
            return $domain->sub . '.' . $domain->domain;
        });
    }
}
