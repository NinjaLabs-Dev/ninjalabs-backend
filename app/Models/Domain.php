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

    public static function getDomainList() {
        $domains = collect();

        self::all()->each(function($domain) use ($domains) {
            if($domain->sub !== 'i') {
                $domains->push(['i.' . $domain->domain]);
            }

            if($domain->sub !== 'd') {
                $domains->push(['d.' . $domain->domain]);
            }

            $domain->push([$domain->sub . '.' . $domain->domain]);
        });

        return $domains;
    }
}
